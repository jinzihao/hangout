<?php
class a_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }
	
	public function getActivity($slug)
	{ 
		$row=$this->db->get_where('activities', array('slug' => $slug))->result();
		return $row[0]->title;
	}
	
	public function checkActivity($slug)
	{
		if($this->db->get_where('activities', array('slug' => $slug))->num_rows()>0){return true;}else{return false;}
	}
	
	public function getID($slug)
	{
		$row=$this->db->get_where('activities', array('slug' => $slug))->result(); 
		return $row[0]->id;
	}
	
	public function getDescription($id)
	{
		$row=$this->db->get_where('model_info', array('id' => $id))->result(); 
		return $row[0]->description;
	}
	
}

