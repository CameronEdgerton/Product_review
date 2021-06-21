<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

	// Login / logout functions largely adapted from provided course materials
	public function index()
	{
		$data['error']= "";
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
					$this->load->view('reviews'); //if user already logined show main page
				}
			}else{
				$this->load->view('login', $data);	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			
			$this->load->view('reviews'); //if user already logined show main page
		}
		$this->load->view('template/footer');
	}
	
	public function check_login()
	{
		$this->form_validation->set_rules('password', 'Password', 'required|max_length[20]|xss_clean');
		
		if (!$this->form_validation->run())
		{
			redirect('login'); // prevents people using hash to log in. Function related to 'remember me' function where hash retrieved from database to log in.
		}
		$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect username or password </div> ";
		$this->load->view('template/header');
		$username = $this->input->post('username', TRUE); //getting username from login form
		$password = $this->input->post('password', TRUE); //getting password from login form
		$remember = $this->input->post('remember', TRUE); //getting remember checkbox from login form
		$result = $this->user_model->login($username, $password);
		if(!$this->session->userdata('logged_in')){	//Check if user already login
			if ( $result )//check username and password
			{ //create session variables
				$user_data = array(
					'firstName'		=> $result->firstName,
					'lastName'		=> $result->lastName,
					'username' 		=> $username,
					'logged_in' 	=> true, 	
					'email'			=> $result->email,
					'mobile'		=> $result->mobile,
					'v_key'			=> $result->verification_key
				);
				$this->session->set_userdata($user_data);
				if($remember) { // if remember me is activated create cookie
					set_cookie("remember", $remember, '300'); //set cookie remember
					set_cookie("v_key", $this->session->userdata('v_key'), '300');
					set_cookie("logged_in", true, '300'); //set cookie logged in
				}	
				 //set user status to login in session
				redirect('login'); // direct user home page
			}else
			{
				$this->load->view('login', $data);	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			{
				redirect('login'); //if user already logined direct user to home page
			}
		$this->load->view('template/footer');
		}
	}



	public function logout()
	{
		$this->session->unset_userdata('logged_in'); //delete login status
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('mobile');
		$this->session->unset_userdata('firstName');
		$this->session->unset_userdata('lastName');
		$this->session->unset_userdata('v_key');
		delete_cookie("remember"); //delete the remember cookie if they click to log out
		delete_cookie("v_key");
		delete_cookie("logged_in");

		redirect('login'); // redirect user back to login
	}
}
?>
