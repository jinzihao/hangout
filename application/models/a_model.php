<?php
/*
活动信息相关功能
*/
class a_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }
  
  /*
	检查给定的slug是否存在
	*/
	public function checkActivitySlug($slug)
	{
		if($this->db->get_where('activities', array('slug' => $slug))->num_rows()>0){return true;}else{return false;}
	}
	
	/*
	检查给定的id是否存在
	*/
	public function checkActivityID($id)
	{
		if($this->db->get_where('activities', array('id' => $id))->num_rows()>0){return true;}else{return false;}
	}
  
  /*
	由slug查询活动id
	*/
	public function getID($slug)
	{
		$row=$this->db->get_where('activities', array('slug' => $slug))->result(); 
		return $row[0]->id;
	}
	
	/*
	由id查询活动slug
	*/
	public function getSlug($slug)
	{
		$row=$this->db->get_where('activities', array('id' => $id))->result(); 
		return $row[0]->slug;
	}
	
	/*
	根据id返回活动标题
	*/
	public function getActivityTitle($id)
	{ 
		$row=$this->db->get_where('activities', array('id' => $id))->result();
		return $row[0]->title;
	}
	
	/*
	由id查询活动描述
	*/
	public function getDescription($id)
	{
		$row=$this->db->get_where('model_info', array('id' => $id))->result(); 
		return $row[0]->description;
	}
	
}

