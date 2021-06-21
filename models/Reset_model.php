<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here
 class Reset_model extends CI_Model{

    function insert_reset_code($email, $code)
    {
        $this->db->set('reset_code', $code);
        $this->db->where('email', $email);
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

    function set_resettable($key) {
        $this->db->where('reset_code', $key);
        $this->db->where('resettable', 0);
        $query = $this->db->get('users');
        // if true, there is a verification key in the table
        // if false, no verification key or the email has already been verified
        if($query->num_rows() > 0)
        {
            $data = array(
                'resettable'  => 1
            );
            $this->db->where('reset_code', $key);
            $this->db->update('users', $data);
            return true;
        }
        else
        {
            return false;
        }
    }

    function unset_resettable($key) {
        $this->db->where('reset_code', $key);
        $this->db->where('resettable', 1);
        $query = $this->db->get('users');
        // if true, there is a verification key in the table
        // if false, no verification key or the email has already been verified
        if($query->num_rows() > 0)
        {
            $data = array(
                'resettable'  => 0
            );
            $this->db->where('reset_code', $key);
            $this->db->update('users', $data);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function update_password($id, $password) 
    {
        $this->db->set('password', $password);
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

    // Check that email exists in database
    function verify_email($email)
    {
        $this->db->where('email', $email);
        $this->db->where('if_validated', 1);
        $query = $this->db->get('users');
        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function get_verification($email) {
        $this->db->where('email', $email);
        $result = $this->db->get('users');
        return $result->row()->verification_key;
    }


    // check that valid key is used
    function check_key($key)
    {
        $this->db->where('reset_code', $key);
        $result = $this->db->get('users');    
        if($result->num_rows() > 0)
        {
            foreach($result->result() as $row)
            {
            return $row;
            }
        }
        else
        {
            return false;
        }
    }
}
?>

