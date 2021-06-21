<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here 
 class File_model extends CI_Model{

    function __construct() { 
        $this->tableName = 'multifiles'; 
    } 

    /* 
     * Fetch files data from the database 
     * @param id returns a single record if specified, otherwise all records 
     */ 
    public function getRows($username){ 
        $this->db->select('id,file_name,uploaded_on'); 
        $this->db->from('multifiles');
        $this->db->where('username', $username, true); //DS added
        $this->db->order_by('uploaded_on','desc'); 
        $query = $this->db->get(); 
        $result = $query->result_array(); 
         
         
        return !empty($result)?$result:false; 
    } 
     
    /* 
     * Insert file data into the database 
     * @param array the data for inserting into the table 
     */ 
    public function insert($data = array()){ 
        $insert = $this->db->insert('multifiles', $data); 
        return $insert?true:false; 
    } 

    // upload file
    public function upload($file_data){
        $query = $this->db->insert('files', $file_data);
    }

    function fetch_distinct($query)
    {
        // Fetches distinct restaurants for a specific city
        $this->db->distinct();
        $this->db->select('restaurant');
        $this->db->select('city');
        $this->db->where("city", $query, true);
        return $this->db->get("files")->result();
    }

    function fetch_data($city, $restaurant)
    {
        // Fetches all of the reviews for a specific restaurant
        $this->db->where("city", $city, true);
        $this->db->where("restaurant", $restaurant, true);
        return $this->db->get("files")->result();
    }

    // Function finds rows in the dataset for the autocomplete functionality. Adapted from https://mfikri.com/en/blog/codeigniter-autocomplete
    public function get_row($keyword)
    {
        $this->db->distinct();
        $this->db->select('city');
        $this->db->like('city', $keyword, 'both');
        $this->db->order_by('city', 'ASC');
        $this->db->limit(10);
        return $this->db->get('files')->result();
    }

    public function increment_likes($id)
    {
        $this->db->where('id', $id);
        $this->db->set('likes', 'likes+1', FALSE);
        $this->db->update('files');
    }

    public function record_likes($like_data)
    {
        $this->db->insert('likes', $like_data);
    }

    public function check_liked($username, $id)
    {
        $this->db->where('username', $username, true);
        $this->db->where('review_id', $id, true);
        $query = $this->db->get('likes');
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