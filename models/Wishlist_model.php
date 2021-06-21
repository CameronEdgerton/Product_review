<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here 
 class Wishlist_model extends CI_Model{

    /* 
     * Fetch wishlist items from the database 
     */ 
    public function getRows($username){ 
        $this->db->select('restaurant, city'); 
        $this->db->from('wishlist');
        $this->db->where('username', $username); 
        $query = $this->db->get(); 
        $result = $query->result_array(); 
        return $result; 
    } 
     
    // adapted from https://github.com/nmccrory/codeigniter-wishlist/blob/master/CodeIgniter-3.0.0/application/models/Process.php
    public function addtoWishlist($username, $restaurant, $city){
		$query = "INSERT INTO wishlist (username, restaurant, city) VALUES (?,?,?)";
		$values = array($username, $restaurant, $city);
		$this->db->query($query, $values);
	} 

    // adapted from https://github.com/nmccrory/codeigniter-wishlist/blob/master/CodeIgniter-3.0.0/application/models/Process.php
    public function removefromWishlist($username, $restaurant, $city){
		$query = 'DELETE FROM wishlist WHERE wishlist.username = ? AND wishlist.restaurant = ? AND wishlist.city = ?';
		$values = array($username,$restaurant, $city);
		$this->db->query($query, $values);
  }

    public function checkWishlist($username, $restaurant, $city) {
      $this->db->where('username', $username, true);
      $this->db->where('restaurant', $restaurant, true);
      $this->db->where('city', $city, true);
      $query = $this->db->get('wishlist');
      if($query->num_rows() > 0)
      {
          return true;
      }
      else
      {
          return false;
      }
    }
}
