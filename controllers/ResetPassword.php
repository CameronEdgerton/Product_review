<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ResetPassword extends CI_Controller
{

	function index() 
	{
		$this->load->view('template/header');
		$this->load->view('forgot_password');
		$this->load->view('template/footer');

	}

	function validation()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'required|trim|max_length[50]|valid_email|xss_clean');
		
		if ($this->form_validation->run())
		{
			$temp = md5(rand());
			$reset_code = hash('sha512', $temp);
			$data = $this->input->post('email', TRUE);
			$result = $this->reset_model->verify_email($data);
			if ($result)
			{
				$this->reset_model->insert_reset_code($data, $reset_code);
				$this->reset_model->set_resettable($reset_code);
				//$verification_key = $this->reset_model->get_verification($data);
				$subject = "Reset your password";
				$message = "
				<p>G'day,</p>
				<p>You can change your password by clicking this <a href='".base_url()."ResetPassword/verify_email/".$reset_code."'>link</a>. </p>
				<p>Thanks!</p>
				";
				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'mailhub.eait.uq.edu.au',
					'smtp_port' => 25,
					'mailtype' => 'html',
					'charset' => 'iso-8859-1',
					'wordwrap' => TRUE ,
					'mailtype' => 'html',
					'starttls' => true,
					'newline' => "\r\n"
					);

				$this->email->initialize($config);
				$this->email->from(get_current_user().'@student.uq.edu.au',get_current_user());
				$this->email->to($this->input->post('email', TRUE));
				$this->email->subject($subject);
				$this->email->message($message);
				if($this->email->send())
				{
					$this->session->set_flashdata('message', 'Check your email for a reset link');
					redirect('ResetPassword/validation');
				}
			}
			$this->session->set_flashdata('message', 'Check your email for a reset link');
			redirect('ResetPassword/validation');
		} 
		else
		{
			$this->index();
		}
	}


	function verify_email()
	{
		if($this->uri->segment(3))
		{
			$verification_key = $this->uri->segment(3);
			$result = $this->reset_model->check_key($verification_key);
			if($result)
			{
				$data = array(
					'id'				=> $result->id,
					'username' 			=> $result->username,
					'email'				=> $result->email,
					'reset_code'	=> $verification_key
				);
				$this->session->set_userdata($data);
				$this->load->view('template/header');
				$this->load->view('reset_password', $data);
				$this->load->view('template/footer');
			}
			else
			{
				$this->load->view('template/header');
				//$data['message'] = '<h1 align="center"> This link is invalid.</h1>';
				$this->load->view('invalid_link'); // loading this to show invalid link
				$this->load->view('template/footer');
			}
		}
	}

	// Password strength check callback function sourced from https://stackoverflow.com/questions/32502446/codeigniter-form-validation-setting-strong-password-validation-rule-in-an-array 
	public function password_strength_check($str)
	{
		if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message('password_strength_check', 'Your password must be at least 6-19 characters in length and contain a number and both uppercase and lowercase letters');
			return FALSE;
		}

		
	}

	function reset()
	{
		$verification_key = $this->session->userdata('reset_code');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|max_length[20]|callback_password_strength_check|xss_clean');
		$this->form_validation->set_rules('conf_password', 'Confirm Password', 'required|matches[password]|xss_clean');

		if ($this->form_validation->run())
		{
			$hashed_password = password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT);
			$id = $this->session->userdata('id');
	
			if ($this->reset_model->update_password($id, $hashed_password))
			{
				//$this->session->set_flashdata('success', 'Your password has been changed');
				$temp = md5(rand());
				$reset_code = hash('sha512', $temp);
				$email = $this->session->userdata('email');
				$this->reset_model->unset_resettable($verification_key);
				$this->reset_model->insert_reset_code($email, $reset_code);
				$data['message'] = '<h1 align="center"> Your password has been reset. Click <a href="'.base_url().'login">here</a> to login.</h1>';
				//redirect('ResetPassword/verify_email/'.$verification_key);
				$this->load->view('template/header');
				$this->load->view('reset_success');
				$this->load->view('template/footer');
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'Invalid password.');
			redirect('ResetPassword/verify_email/'.$verification_key);
		}
	}
}