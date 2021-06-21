<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here
 class Register_model extends CI_Model{

    function insert($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    // User registration and email verification functionality largely adapted from https://www.webslesson.info/2018/10/user-registration-and-login-system-in-codeigniter-3.html
    function verify_email($key)
    {
        $this->db->where('verification_key', $key);
        $this->db->where('if_validated', 0);
        $query = $this->db->get('users');
        // if true, there is a verification key in the table
        // if false, no verification key or the email has already been verified
        if($query->num_rows() > 0)
        {
            $data = array(
                'if_validated'  => 1
            );
            $this->db->where('verification_key', $key);
            $this->db->update('users', $data);
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>

