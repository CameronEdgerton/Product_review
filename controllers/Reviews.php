<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reviews extends CI_Controller
{
	// AJAX Autocomplete functionality largely adapted from https://mfikri.com/en/blog/codeigniter-autocomplete
	function index() 
	{
		$data['title'] = 'autocomplete';
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
					$this->load->view('reviews', $data); //if user already logined show main page
				}
			}else{
				redirect('login');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			
			$this->load->view('reviews', $data); //if user already logined show main page
		}

		$this->load->view('template/footer');
		
	}

	function show_restaurants()
	{
		$city = $this->input->get('city', TRUE);
		$data["fetch_data"] = $this->file_model->fetch_distinct($city);
		if($data!='')
		{	
			$this->load->view('template/header');
			$this->load->view('reviews', $data);
			$this->load->view('template/footer');
		}
		else
		{
			$this->session->set_flashdata('error', 'There are no reviews from that city');
			redirect('reviews');
		}

	}

	function show_reviews($city, $restaurant)
	{
		$data["fetch_data"] = $this->file_model->fetch_data($city, $restaurant);
		$data["comment_data"] = $this->comment_model->getRows($restaurant, $city);
		$this->load->view('template/header');
		$this->load->view('full_reviews', $data);
		$this->load->view('comments', $data);
		$this->load->view('template/footer');
	}

	// As above, this autocomplete functionality was sourced from https://mfikri.com/en/blog/codeigniter-autocomplete
	public function get_city_names()
	{
		if (isset($_GET['term'])) {
			$data = $this->security->xss_clean($_GET['term']);
            $result = $this->file_model->get_row($data);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = $row->city;
                echo json_encode($arr_result);
            }
        }
	}

	// adapted from https://github.com/nmccrory/codeigniter-wishlist/blob/master/CodeIgniter-3.0.0/application/controllers/Processes.php
	public function addtoWishlist($restaurant, $city){
		//add a check if exists already
		$username = $this->session->userdata('username');
		$result = $this->wishlist_model->checkWishlist($username, $restaurant, $city);
		if (!$result) 
		{
			$this->wishlist_model->addtoWishlist($username, $restaurant, $city);
			$this->session->set_flashdata('success', 'This restaurant has been added to your wishlist');
			redirect('reviews/show_reviews/'.$city.'/'.$restaurant);
		}
		else
		{
			$this->session->set_flashdata('error', 'This restaurant is already in your wishlist.');
			redirect('reviews/show_reviews/'.$city.'/'.$restaurant);
		}
	}

	public function likeReview($id, $restaurant, $city) 
	{
		$username = $this->session->userdata('username');
		$result = $this->file_model->check_liked($username, $id);
		if (!$result)
		{
			$this->file_model->increment_likes($id);
			$like_data = array(
				'review_id' => $id,
				'username' => $username
			);
			$this->file_model->record_likes($like_data);
			$this->session->set_flashdata('good', 'You have liked this review');
			redirect('reviews/show_reviews/'.$city.'/'.$restaurant);
		}
		else {
			$this->session->set_flashdata('bad', 'You have already liked this review');
			redirect('reviews/show_reviews/'.$city.'/'.$restaurant);
		}
	}

	public function show_comments($city, $restaurant)
	{
		$data["comment_data"] = $this->comment_model->getRows($restaurant, $city);
		$this->load->view('comments', $data);
	}

	public function addComment($city, $restaurant)
	{
		$this->form_validation->set_rules('comment', 'Comment', 'required|max_length[250]|xss_clean');
		
		if ($this->form_validation->run())
		{
			date_default_timezone_set('Australia/Brisbane');
			$now = date('Y-m-d H:i:s');
			$comment_data = array(
				'username'			=>	$this->session->userdata('username'),
				'date'				=>	$now,
				'restaurant'		=>	$restaurant,
				'city'				=> 	$city,
				'comment'			=> 	$this->input->post('comment', TRUE)
			);
			$this->comment_model->post_comment($comment_data);
			$this->session->set_flashdata('posted', 'Your comment has been posted');
			redirect('reviews/show_reviews/'.$city.'/'.$restaurant);
		}
		else
		{
			$this->session->set_flashdata('not_posted', 'Comments must be 250 characters or less');
			redirect('reviews/show_comments/'.$city.'/'.$restaurant);
		}
	}
}