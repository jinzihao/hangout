<?php
/*
API模块，用于提供API所需功能
*/
class api_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
    $this->load->library('session');
    $this->load->library('encoding');
  }
  
  /*
  获得活动列表
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
	
	/*
	新建活动
	*/
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
	
	/*
	加入活动
	*/
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
		if(checkActivitySlug($slug)==false){return "";}
		$row=$this->db->get_where('activities', array('slug' => $slug))->result(); 
		return $row[0]->id;
	}
	
	/*
	由id查询活动slug
	*/
	public function getSlug($id)
	{
		if(checkActivityID($id)==false){return "";}
		$row=$this->db->get_where('activities', array('id' => $id))->result(); 
		return $row[0]->slug;
	}
	
	/*
	根据id返回活动标题
	*/
	public function getActivityTitle($id)
	{ 
		if(checkActivityID($id)==false){return "";}
		$row=$this->db->get_where('activities', array('id' => $id))->result();
		return $row[0]->title;
	}
	
	/*
	由id查询活动描述
	*/
	public function getActivityInfo($id)
	{
		if(checkActivityID($id)==false){return "";}
		$row=$this->db->get_where('model_info', array('id' => $id))->result(); 
		return $row[0]->description;
	}
	
	/*
	检查活动管理密码是否正确
	*/
	public function checkAdminPassword($id,$password)
	{
		$row=$this->db->get_where('activities', array('id' => $id))->result();
		if($row[0]->password==sha1($password))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	检查活动管理员是否登陆
	*/
	public function checkAdminLoggedIn($id)
	{
		if($this->session->userdata('adminid')===$id)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	更改活动标题
	*/
	public function updateActivityTitle($id,$title)
	{
		$data = array(
			'title' => $title
		);
	$this->db->where('id',$id);
  $this->db->update('activities', $data);
  return true;
	}
	
	/*
	更改活动标题
	*/
	public function updateActivityInfo($id,$info)
	{
		$data = array(
			'description' => $info
		);
	$this->db->where('id',$id);
  $this->db->update('model_info', $data);
  return true;
	}
	
	/*
	更改活动slug
	*/
	public function updateActivitySlug($id,$slug)
	{
		$data = array(
			'slug' => $slug
		);
	$this->db->where('id',$id);
  $this->db->update('activities', $data);
  return true;
	}
	
	/*
	检查用户密码是否正确
	*/
	public function checkUserPassword($id,$username,$password)
	{
		$row=$this->db->get_where('model_users', array('id' => $id))->result();
		$userdata=$row[0]->userdata;
		$userarr=explode("\r\n",$userdata);
		for($i=0;$i<=count($userarr)-1;$i++)
		{
			if($userarr[$i]==$this->encoding->utf8encode($this->encoding->convert_entities(str_replace('\\','%',$username))) && $userarr[$i+1]==sha1($password))
			{
				return true;
			}
		}
			return false;
	}
	
	/*
	检查用户是否登录
	*/
	public function checkUserLoggedIn($id)
	{
		if($this->session->userdata('activity'.$id)!==false)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	检查用户是否在活动注册
	*/
	public function checkUserRegistered($id,$username)
	{
		$row=$this->db->get_where('model_users', array('id' => $id))->result();
		$userdata=$row[0]->userdata;
		$userarr=explode("\r\n",$userdata);
		for($i=0;$i<=count($userarr)-1;$i=$i+2)
		{
			if($userarr[$i]==$this->encoding->utf8encode($this->encoding->convert_entities(str_replace('\\','%',$username))))
			{
				return true;
			}
		}
		return false;
	}
	
	/*
	用户退出活动
	*/
	public function userUnregister($id,$username)
	{
		$row=$this->db->get_where('model_users', array('id' => $id))->result();
		$userdata=$row[0]->userdata;
		$userarr=explode("\r\n",$userdata);
		for($i=0;$i<=count($userarr)-1;$i++)
		{
			if($userarr[$i]==$this->encoding->utf8encode($this->encoding->convert_entities(str_replace('\\','%',$username))))
			{
				array_splice($userarr,$i,2);
				$userdata=implode("\r\n",$userarr)."\r\n";
				$data = array(
					'userdata' => $userdata
				);
				$this->db->where('id',$id);
  			$this->db->update('model_users', $data);
				return true;
			}
		}
		return false;
	}
}
