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
	  return 0;
	}
	
	/*
	加入活动
	*/
	public function joinActivity($id,$username,$password)
	{
		$row=$this->db->get_where('model_users',array('id' => $id, 'username' => $username))->result();
		if(count($row)==0)
		{
			$data = array(
				'id' => $id,
				'username' => $username,
				'password' => sha1($password)
			);
      $this->db->insert('model_users', $data);
			return 0;
		}
		else
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
		if($this->api_model->checkActivitySlug($slug)==false){return "";}
		$row=$this->db->get_where('activities', array('slug' => $slug))->result(); 
		return $row[0]->id;
	}
	
	/*
	由id查询活动slug
	*/
	public function getSlug($id)
	{
		if($this->api_model->checkActivityID($id)==false){return "";}
		$row=$this->db->get_where('activities', array('id' => $id))->result(); 
		return $row[0]->slug;
	}
	
	/*
	根据id返回活动标题
	*/
	public function getActivityTitle($id)
	{ 
		if($this->api_model->checkActivityID($id)==false){return "";}
		$row=$this->db->get_where('activities', array('id' => $id))->result();
		return $row[0]->title;
	}
	
	/*
	由id查询活动描述
	*/
	public function getActivityInfo($id)
	{
		if($this->api_model->checkActivityID($id)==false){return "";}
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
		$row=$this->db->get_where('model_users', array('id' => $id, 'username' => $this->encoding->utf8encode($this->encoding->convert_entities(str_replace('\\','%',$username))), 'password' => sha1($password)))->result();
		if(count($row)>0)
		{
			return true;
		}
		else
		{
			return false;
		}
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
		$row=$this->db->get_where('model_users', array('id' => $id, 'username' => $this->encoding->utf8encode($this->encoding->convert_entities(str_replace('\\','%',$username)))))->result();
		if(count($row)>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	用户退出活动
	*/
	public function userUnregister($id,$username)
	{
		if($this->api_model->checkUserRegistered($id,$username)==true)
		{
			$row=$this->db->delete('model_users', array('id' => $id, 'username' => $this->encoding->utf8encode($this->encoding->convert_entities(str_replace('\\','%',$username)))));
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
  获得活动内的用户列表(管理员和用户均可以查看)
  */
  public function getUserList($id)
	{
		if($this->api_model->checkAdminLoggedIn($id)==true || $this->api_model->checkUserLoggedIn($id)==true)
		{
			$row=$this->db->get_where('model_users', array('id' => $id))->result();
			for($i=0;$i<=count($row)-1;$i++)
			{
				$data[$i]=$this->encoding->utf8encode($this->encoding->convert_entities(str_replace('\\','%',$row[$i]->username)));
			}
			$data['status']="0";
		}
		else
		{
			$data['status']="1";
		}
		return json_encode($data);
	}
	
	/*
	设置活动的时间表模块状态
	*/
	public function setModelTimetable($id,$state)
	{
		if($this->api_model->checkActivityID($id)==true)
		{
			$data['iderror']="0";
		}
		else
		{
			$data['iderror']="1";
		}
		if($this->api_model->checkAdminLoggedIn($id)==true)
		{
			$data['loginerror']="0";
		}
		else
		{
			$data['loginerror']="1";
		}
		if($data['loginerror']=="1"||$data['loginerror']=="1")
		{
			$data['status']="1";
		}
		else
		{
			$data['status']="0";
			$db = array(
			'model_timetable' => $state
			);
			$this->db->where('id',$id);
			$this->db->update('activities', $db);
		}
		return json_encode($data);
	}

	/*
	设置活动的聊天室模块状态
	*/
	public function setModelChatroom($id,$state)
	{
		if($this->api_model->checkActivityID($id)==true)
		{
			$data['iderror']="0";
		}
		else
		{
			$data['iderror']="1";
		}
		if($this->api_model->checkAdminLoggedIn($id)==true)
		{
			$data['loginerror']="0";
		}
		else
		{
			$data['loginerror']="1";
		}
		if($data['loginerror']=="1"||$data['loginerror']=="1")
		{
			$data['status']="1";
		}
		else
		{
			$data['status']="0";
			$db = array(
			'model_chatroom' => $state
			);
			$this->db->where('id',$id);
			$this->db->update('activities', $db);
		}
		return json_encode($data);
	}
	
	/*
	设置活动的位置共享模块状态
	*/
	public function setModelLocation($id,$state)
	{
		if($this->api_model->checkActivityID($id)==true)
		{
			$data['iderror']="0";
		}
		else
		{
			$data['iderror']="1";
		}
		if($this->api_model->checkAdminLoggedIn($id)==true)
		{
			$data['loginerror']="0";
		}
		else
		{
			$data['loginerror']="1";
		}
		if($data['loginerror']=="1"||$data['loginerror']=="1")
		{
			$data['status']="1";
		}
		else
		{
			$data['status']="0";
			$db = array(
			'model_location' => $state
			);
			$this->db->where('id',$id);
			$this->db->update('activities', $db);
		}
		return json_encode($data);
	}
	
	/*
	获得活动的时间表模块状态
	*/
	public function getModelTimetable($id)
	{
		if($this->api_model->checkActivityID($id)==false)
		{
			$data['iderror']="1";
		}
		else
		{
			$data['iderror']="0";
		}
		if($this->api_model->checkAdminLoggedIn($id)==false&&$this->api_model->checkUserLoggedIn($id)==false)
		{
			$data['loginerror']="1";
		}
		else
		{
			$data['loginerror']="0";
		}
		if($data['iderror']=="1"||$data['loginerror']=="1")
		{
			$data['status']="1";
		}
		else
		{
			$data['status']="0";
		}
		$row=$this->db->get_where('activities', array('id' => $id))->result(); 
		$data['state']=$row[0]->model_timetable;
		return json_encode($data);
	}

	/*
	获得活动的聊天室模块状态
	*/
	public function getModelChatroom($id)
	{
		if($this->api_model->checkActivityID($id)==false)
		{
			$data['iderror']="1";
		}
		else
		{
			$data['iderror']="0";
		}
		if($this->api_model->checkAdminLoggedIn($id)==false&&$this->api_model->checkUserLoggedIn($id)==false)
		{
			$data['loginerror']="1";
		}
		else
		{
			$data['loginerror']="0";
		}
		if($data['iderror']=="1"||$data['loginerror']=="1")
		{
			$data['status']="1";
		}
		else
		{
			$data['status']="0";
		}
		$row=$this->db->get_where('activities', array('id' => $id))->result(); 
		$data['state']=$row[0]->model_chatroom;
		return json_encode($data);
	}
	
	/*
	获得活动的位置共享模块状态
	*/
	public function getModelLocation($id)
	{
		if($this->api_model->checkActivityID($id)==false)
		{
			$data['iderror']="1";
		}
		else
		{
			$data['iderror']="0";
		}
		if($this->api_model->checkAdminLoggedIn($id)==false&&$this->api_model->checkUserLoggedIn($id)==false)
		{
			$data['loginerror']="1";
		}
		else
		{
			$data['loginerror']="0";
		}
		if($data['iderror']=="1"||$data['loginerror']=="1")
		{
			$data['status']="1";
		}
		else
		{
			$data['status']="0";
		}
		$row=$this->db->get_where('activities', array('id' => $id))->result(); 
		$data['state']=$row[0]->model_location;
		return json_encode($data);
	}
	
	/*
	用户增加可用时间
	*/
	public function addAvailableTime($id,$time1,$time2)
	{
		$this->db->where('time2 <=', intval($time1));
		$this->db->where('time2 >=', intval($time2));
		$this->db->or_where('time1 <=', intval($time1));
		$this->db->where('time2 >=', intval($time2));
		$row = $this->db->get('model_timetable')->result();
		if (count($row)>0)
		{
			return false;
		}
		else
		{
			$data = array(
				'id' => $id,
				'username' => $this->session->userdata('activity'.$id),
				'available' => 1,
				'time1' => $time1,
				'time2' => $time2
			);
			$this->db->insert('model_timetable', $data);
	    return true;
  	}
	}
	
	/*
	用户增加不可用时间
	*/
	public function addUnavailableTime($id,$time1,$time2)
	{
		$this->db->where('time2 <=', intval($time1));
		$this->db->where('time2 >=', intval($time2));
		$this->db->or_where('time1 <=', intval($time1));
		$this->db->where('time2 >=', intval($time2));
		$row = $this->db->get('model_timetable')->result();
		if (count($row)>0)
		{
			return false;
		}
		else
		{
			$data = array(
				'id' => $id,
				'username' => $this->session->userdata('activity'.$id),
				'available' => 0,
				'time1' => $time1,
				'time2' => $time2
			);
			$this->db->insert('model_timetable', $data);
	    return true;
	  }
	}
	
	/*
	用户查询可用时间
	*/
	public function getAvailableTime($id)
	{
		if ($this->api_model->checkActivityID($id)==false)
		{
			$data['iderror']="1";
		}
		else
		{
			$data['iderror']="0";
		}
		if ($this->api_model->checkUserLoggedIn($id)==false)
		{
			$data['loginerror']="1";
		}
		else
		{
			$data['loginerror']="0";
		}
		if ($data['iderror']=="1"||$data['loginerror']=="1")
		{
			$data['status']="1";
		}
		else
		{
			$data['status']="0";
			$this->db->where('id', $id); 
			$this->db->where('available', 1); 
			$this->db->where('username', $this->session->userdata('activity'.$id)); 
			$row = $this->db->get('model_timetable')->result();
			$i=0;
			foreach ($row as $time)
			{
				$i=$i+1;
				$data[$i]=$time->time1.",".$time->time2;
			}
		}
		return json_encode($data);
	}
	
	/*
	用户查询不可用时间
	*/
	public function getUnavailableTime($id)
	{
		if ($this->api_model->checkActivityID($id)==false)
		{
			$data['iderror']="1";
		}
		else
		{
			$data['iderror']="0";
		}
		if ($this->api_model->checkUserLoggedIn($id)==false)
		{
			$data['loginerror']="1";
		}
		else
		{
			$data['loginerror']="0";
		}
		if ($data['iderror']=="1"||$data['loginerror']=="1")
		{
			$data['status']="1";
		}
		else
		{
			$data['status']="0";
			$this->db->where('id', $id); 
			$this->db->where('available', 0); 
			$this->db->where('username', $this->session->userdata('activity'.$id)); 
			$row = $this->db->get('model_timetable')->result();
			$i=0;
			foreach ($row as $time)
			{
				$i=$i+1;
				$data[$i]=$time->time1.",".$time->time2;
			}
		}
		return json_encode($data);
	}
}
