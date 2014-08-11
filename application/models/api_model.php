<?php
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
}
