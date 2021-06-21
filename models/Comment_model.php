<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here 
 class Comment_model extends CI_Model{

    public function getRows($restaurant, $city){ 
        $this->db->where('restaurant', $restaurant, true); 
        $this->db->where('city', $city, true);
        return $this->db->get("comments")->result(); 
    } 
     
    public function post_comment($comment_data)
    {
        $this->db->insert('comments', $comment_data);
    }

}
