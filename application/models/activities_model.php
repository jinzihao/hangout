<?php
/*
活动管理相关功能
*/
class activities_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }
	
	public function addActivity()
	{
	  $this->load->helper('url');
	  
	  $slug = url_title($this->input->post('title'), 'dash', TRUE);
	  
	  $data = array(
		'title' => $this->input->post('title'),
		'slug' => $this->input->post('slug'),
		'model_timetable' => $this->input->post('model_timetable'),
		'model_chatroom' => $this->input->post('model_chatroom'),
		'model_location' => $this->input->post('model_location'),
		'password' => sha1($this->input->post('adminPassword'))
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
}
