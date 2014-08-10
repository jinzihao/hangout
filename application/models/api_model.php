<?php
class api_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }
  
  public function getActivityList()
	{
		$result="";
		$row=$this->db->get('activities')->result();
		foreach ($row as $title)
		{
			$result=$result.$title->title."\r\n";
		}
		return $result;
	}
}
