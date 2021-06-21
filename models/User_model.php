<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class User_model extends CI_Model{

    // User model functionality largely adapted from course materials
    // Log in
    public function login($username, $password){
        // Validate
        $this->db->where('username', $username);
        $result = $this->db->get('users');
        if($result->num_rows() == 1){
            foreach($result->result() as $row)
            {
                if($row->if_validated == 1)
                {
                    if(password_verify($password, $row->password) || $password == $row->password) //allows the hashed password to be used when using 'remember me' function
                    {
                        $this->session->set_userdata('id', $row->id);
                    }
                    else 
                    {
                        return false; //password incorrect
                    }
                }
                else
                {
                    return false; //email not verified
                }
            }
            return $row;
        } else {
            return false;
        }
    }

    // Load profile and update functionality largely adapted from https://buildasite.info/17-codeigniter-3-create-user-profile-page-and-update-user-profile-data/
    public function update_profile($id, $data) 
    {
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('users');
        if ($this->db->affected_rows() > 0) 
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // Retrieves the username for remember me function
    public function get_username($v_key){
        $this->db->select('username');
        $this->db->where('verification_key', $v_key);
        $result = $this->db->get('users');
        
        if($result->num_rows() == 1){
            foreach($result->result() as $row)
            {
                return $row->username;
            }
        }
    }

    // Retrieves the hashed password for remember me function
    public function get_password($v_key){
        $this->db->select('password');
        $this->db->where('verification_key', $v_key);
        $result = $this->db->get('users');

        if($result->num_rows() == 1){
            foreach($result->result() as $row)
            {
                return $row->password;
            }
        }
    }
}
?>

