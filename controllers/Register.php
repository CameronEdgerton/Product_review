<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Register extends CI_Controller
{

	// User registration and email verification functionality largely adapted from https://www.webslesson.info/2018/10/user-registration-and-login-system-in-codeigniter-3.html
	function index() 
	{
		if(!$this->session->userdata('captchaTrue'))
		{
			redirect('login');
		}
		$this->load->view('template/header');
		$this->load->view('register');
		$this->load->view('template/footer');

	}

	// Validation function largely adapted from https://www.webslesson.info/2018/10/user-registration-and-login-system-in-codeigniter-3.html
	// Also utilised course materials for UQ zone email functionality
	function validation()
	{
		$this->form_validation->set_rules('firstName', 'First Name', 'required|trim|max_length[30]|xss_clean');
		$this->form_validation->set_rules('lastName', 'Last Name', 'required|trim|max_length[30]|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'required|trim|max_length[20]|is_unique[users.username]|xss_clean');
		$this->form_validation->set_rules('email', 'Email Address', 'required|trim|max_length[50]|is_unique[users.email]|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|max_length[20]|callback_password_strength_check|xss_clean');
		$this->form_validation->set_rules('conf_password', 'Confirm Password', 'required|matches[password]|xss_clean');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|min_length[10]|max_length[10]|numeric|xss_clean');
		
		if ($this->form_validation->run())
		{
			$temp = md5(rand());
			$verification_key = hash('sha512', $temp);
			$hashed_password = password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT);
			$data = array(
				'firstName'			=>	$this->input->post('firstName', TRUE),
				'lastName'			=>	$this->input->post('lastName', TRUE),
				'username'			=>	$this->input->post('username', TRUE),
				'email'				=> 	$this->input->post('email', TRUE),
				'password' 			=>	$hashed_password,
				'mobile'			=> 	$this->input->post('mobile', TRUE),
				'verification_key' 	=> 	$verification_key
			);
			$id = $this->register_model->insert($data);
			if($id > 0)
			{
				$subject = "Please verify your email address to use Parmme";
				$message = "
				<p>G'day ".$this->input->post('username', TRUE)."</p>
				<p>Please verify your email address by clicking this <a href='".base_url()."register/verify_email/".$verification_key."'>link</a>. </p>
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
					$this->session->set_flashdata('message', 'Please check your inbox for a verification email');
					redirect('register');
				}

				
			}
		} 
		else
		{
			$this->index();
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

	// As above, email verification function sourced from https://www.webslesson.info/2018/10/user-registration-and-login-system-in-codeigniter-3.html 
	function verify_email()
	{
		
		if($this->uri->segment(3))
		{
			$verification_key = $this->uri->segment(3);
			
			if($this->register_model->verify_email($verification_key))
			{
				$data['message'] = '<h1 align="center"> Thank you for verifying your email address. Click <a href="'.base_url().'login">here</a> to login.</h1>';
			}
			else
			{
				$data['message'] = '<h1 align="center"> This link is invalid.</h1>';
			}
			$this->load->view('template/header');
			$this->load->view('email_verification', $data);
			$this->load->view('template/footer');
		}

	}
}