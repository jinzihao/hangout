﻿<?php
/*
API模块，用于提供API所需功能
*/
class api_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }
  
  /*
  获得活动列表函数，以换行符分隔
  */
  public function getActivityList()
	{
		$result="";
		$row=$this->db->get('activities')->result();
		foreach ($row as $title)
		{
			$json[$title->id]=$title->title;
		}
		return json_encode($json);
	}
	
	public function addActivity($title,$slug,$model_timetable,$model_chatroom,$model_location,$password)
	{
	  $this->load->helper('url');
	  
	  $slug = url_title($this->input->post('title'), 'dash', TRUE);
	  
	  $data = array(
		'title' => $title,
		'slug' => $slug,
		'model_timetable' => $model_timetable,
		'model_chatroom' => $model_chatroom,
		'model_location' => $model_location,
		'password' => sha1($password)
		);
	 $this->db->insert('activities', $data);
	 $data = array(
		'description' => ''
		);
	 $this->db->insert('model_info', $data);
	 $data = array(
		'userdata' => ''
		);
	 $this->db->insert('model_users', $data);
	  return 0;
	}
	
	public function joinActivity($id,$username,$password)
	{
		$row=$this->db->get_where('model_users',array('id' => $id))->result();
		$currentUserData=$row[0]->userdata;
		$currentUsernamesArray=explode("\r\n",$currentUserData);
		$isDuplicate=0;
		for($i=0;$i<(count($currentUsernamesArray)-1)/2;$i++)
		{
			if(stripos($currentUsernamesArray[$i*2],$username)!==false)
			{
				$isDuplicate=1;
				break;
			}
			
		}
		if($isDuplicate==0)
		{
			$data = array(
                	'userdata' => $currentUserData.$username."\r\n".sha1($password)."\r\n"
                		);
			$this->db->where('id',$id);
         		$this->db->update('model_users', $data);
			return 0;
		}
		elseif($isDuplicate==1)
		{
			return 1;
		}
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
	public function getActivityInfo($id)
	{
		$row=$this->db->get_where('model_info', array('id' => $id))->result(); 
		return $row[0]->description;
	}
}
