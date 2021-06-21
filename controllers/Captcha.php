<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends CI_Controller {

    // All Captcha functionality (view and controller) is largely adapted from the following link: https://www.codexworld.com/implement-captcha-codeigniter-captcha-helper/
	public function index()
	{
		if($this->input->post('submit', TRUE)){
            $inputCaptcha = $this->input->post('captcha', TRUE);
            $sessCaptcha = $this->session->userdata('captchaCode');
            if($inputCaptcha == $sessCaptcha){
                $this->session->set_userdata('captchaTrue', true);
                redirect('register');
            }else{
                $this->session->set_flashdata('message', 'The code entered was incorrect. Please try again.');
            }
        }
        
        // Captcha configuration
        $config = array(
            'img_path'      => APPPATH.'../assets/img/',
            'img_url'       => base_url('/assets/img/'),
            'img_width'     => '150',
            'img_height'    => 40,
            'word_length'   => 6,
            'font_size'     => 20
        );
        $captcha = create_captcha($config);
        
        // Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);
        
        // Pass captcha image to view
        $data['captchaImg'] = $captcha['image'];
        
        // Load the views
        $this->load->view('template/header');
        $this->load->view('captcha', $data);
        $this->load->view('template/footer');
    }
    
    public function refresh(){
        // Captcha configuration
        $config = array(
            'img_path'      => APPPATH.'../assets/img/',
            'img_url'       => base_url('assets/img/'),
            'img_width'     => '150',
            'img_height'    => 40,
            'word_length'   => 6,
            'font_size'     => 20
        );
		
        $captcha = create_captcha($config);
        
        // Unset previous captcha and set new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        
        // Display captcha image
        echo $captcha['image'];

	}
}
?>
