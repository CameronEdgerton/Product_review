<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class wishlist extends CI_Controller {

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
                    
                    $data = array();
                    $data["fetch_data"] = $this->wishlist_model->getRows($this->session->userdata('username'));
                    
                    $this->session->set_userdata($user_data); //set user status to login in session
                    $this->load->view('wishlist', $data); //if user already logined show main page
				}
			}else{
				redirect('login');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			$data = array();
            $data["fetch_data"] = $this->wishlist_model->getRows($this->session->userdata('username'));
            $this->load->view('wishlist', $data);
		}
        $this->load->view('template/footer');
    }
          
    function show_wishlist()
	{
        $username = $this->session->userdata('username');
		$data["fetch_data"] = $this->wishlist_model->getRows($username);
        $this->load->view('wishlist', $data);
	}
    
    // adapted from https://github.com/nmccrory/codeigniter-wishlist/blob/master/CodeIgniter-3.0.0/application/controllers/Processes.php
	public function removefromWishlist($restaurant, $city){
        $this->wishlist_model->removefromWishlist($this->session->userdata('username'), $restaurant, $city);
        $this->session->set_flashdata('success', 'This restaurant has been removed from your wishlist');
		redirect('wishlist');
	}
}