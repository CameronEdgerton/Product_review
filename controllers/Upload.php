<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller
{
    // File upload functionality largely adapted from course materials
    public function index()
    {
		$this->load->view('template/header'); 
    	if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = $this->user_model->get_username(get_cookie('v_key')); //get the username
				$password = $this->user_model->get_password(get_cookie('v_key')); //get the password
				$result = $this->user_model->login($username, $password);
				if ($result)//check username and password correct
				{
					$user_data = array(
						'firstName'		=> $result->firstName,
						'lastName'		=> $result->lastName,
						'username' 		=> $username,
						'logged_in' 	=> true, 	
						'email'			=> $result->email,
						'mobile'		=> $result->mobile,
						'v_key'			=> $result->verification_key
					);
					$this->session->set_userdata($user_data); //set user status to login in session
					$this->load->view('file',array('error' => ' ')); //if user already logined show upload page
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
			$this->load->view('file',array('error' => ' ')); //if user already logined show login page
		}
		$this->load->view('template/footer');
	}
	
    public function do_upload() {

		$this->form_validation->set_rules('flavour', 'Flavour', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]|xss_clean');
        $this->form_validation->set_rules('portion_size', 'Portion size', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]|xss_clean');
        $this->form_validation->set_rules('crumb_quality', 'Crumb quality', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]|xss_clean');
        $this->form_validation->set_rules('juiciness', 'Juiciness', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]|xss_clean');
        $this->form_validation->set_rules('ratio', 'Chicken-sauce-cheese ratio', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]|xss_clean');
        $this->form_validation->set_rules('condiment_quality', 'Condiment quality', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]|xss_clean');
        $this->form_validation->set_rules('restaurant', 'Restaurant', 'required|trim|alpha_numeric_spaces|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'required|trim|alpha_dash|xss_clean'); 
		
        $config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';
		$config['max_size'] = 10000;
		$config['max_width'] = 3000;
		$config['max_height'] = 3000;
		
		if ($this->form_validation->run())
		{
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('userfile')) {
				$this->load->view('template/header');
				$data = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('error', 'Please complete all sections of the form and select a jpg, jpeg or png image file before uploading a review.');
				$this->load->view('file');//, $data);
				$this->load->view('template/footer');
			} else {
				date_default_timezone_set('Australia/Brisbane');
				$now = date('Y-m-d H:i:s');
				$file_data = array(
					'filename' => $this->upload->data('file_name'),
					'path' => $this->upload->data('full_path'),
					'username' => $this->session->userdata('username'),
					'flavour'   => $this->input->post('flavour', TRUE),
					'portion_size'   => $this->input->post('portion_size', TRUE),
					'crumb_quality'   => $this->input->post('crumb_quality', TRUE),
					'juiciness'   => $this->input->post('juiciness', TRUE),
					'ratio'   => $this->input->post('ratio', TRUE),
					'condiment_quality'   => $this->input->post('condiment_quality', TRUE),
					'restaurant'   => str_replace(' ', '_', $this->input->post('restaurant', TRUE)),
					'city'   => $this->input->post('city', TRUE),
					'date'  => $now        
				);

				// Resize image to 600 pixels max in 1 dimension (maintains ratio)
				$resize['image_library'] = 'gd2';
				$resize['maintain_ratio'] = TRUE;
				$resize['width'] = 600;
				$resize['height'] = 600;
				$resize['source_image'] = $file_data['path'];
				$resize['new_image'] = FCPATH.'uploads/resized/'.$file_data['filename'];
				$this->load->library('image_lib', $resize);

				$file_data['path'] = $resize['new_image'];

				if (!$this->image_lib->resize()) {
					echo $this->image_lib->display_errors();
				}
				$this->file_model->upload($file_data);
				$this->session->set_flashdata('success', 'Your review has been posted');
				redirect('upload');
			}
		} 
		else {
			$this->index();
		}
	}
}


