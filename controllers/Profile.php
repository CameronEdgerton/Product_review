<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class profile extends CI_Controller {

	public function index()
	{     
        $data['title']= "User Profile";   
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
                    $data['files'] = $this->file_model->getRows($user_data['username']);
                    
                    $this->session->set_userdata($user_data); //set user status to login in session
                    $this->load->view('profile'); //if user already logined show main page
                    $this->load->view('upload_multi', $data); 
				}
			}else{
				redirect('login');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			$data = array();
            $data['files'] = $this->file_model->getRows($this->session->userdata('username'));
            $this->load->view('profile'); //if user already logined show main page
            $this->load->view('upload_multi', $data);
		}
        $this->load->view('template/footer');
    }

    // Load profile and update functionality largely adapted from https://buildasite.info/17-codeigniter-3-create-user-profile-page-and-update-user-profile-data/
    public function load_profile() {       

        $this->form_validation->set_rules('firstName', 'First Name', 'required|trim|max_length[30]|xss_clean');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required|trim|max_length[30]|xss_clean');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|min_length[10]|max_length[10]|numeric|xss_clean');

        if($this->form_validation->run() == false) {
            $data['title']= "User Profile";
            $this->load->view('template/header');
            $this->load->view('profile');
            $this->load->view('template/footer');
        }
        else 
        {
            $data = array(
				'firstName'			=>	$this->input->post('firstName', TRUE),
				'lastName'			=>	$this->input->post('lastName', TRUE),
				'mobile'			=> 	$this->input->post('mobile', TRUE)
            );
            $result = $this->user_model->update_profile($this->session->userdata('id'), $data);
            if($result > 0)
            {
                $this->session->set_userdata($data);
                $this->session->set_flashdata('success', 'Your profile has been updated');
                return redirect('profile');
            }
            else
            {
                $this->session->set_flashdata('error', 'Your profile update was unsuccessful');
                return redirect('profile');
                
            }
        }
           
    }
      
    // adapted from https://www.codexworld.com/codeigniter-drag-and-drop-file-upload-with-dropzone/
    function dragDropUpload() {
        if(!empty($_FILES)) {
            $config['upload_path'] = 'uploads/';
            $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG';

            $this->load->library('upload', $config); 
            $this->upload->initialize($config);

            if($this->upload->do_upload('file')){ 
                $fileData = $this->upload->data(); 
                $uploadData['file_name'] = $fileData['file_name']; 
                $uploadData['uploaded_on'] = date("Y-m-d H:i:s"); 
                $uploadData['username'] = $this->session->userdata['username'];
                 
                // Insert files info into the database 
                $insert = $this->file_model->insert($uploadData); 
            }
        }
    }
        
}