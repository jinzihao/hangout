<?php
/*
API模块，用于和客户端及第三方网站交互，用户不可见
*/
class api extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('api_model');
  }
	
	/*
  功能：活动列表
  方法：GET /api/activityList
  参数：无
  返回类型：json
  返回内容：{"%id%":"%title%"}
  */
  public function activitylist()
	{
		echo $this->encoding->utf8encode($this->encoding->convert_entities(str_replace('\\','%',$this->api_model->getActivityList())));
	}
	
	/*
  功能：加入活动
  方法：POST /api/joinActivity
  参数：id,username,password1,password2
  返回类型：json
  返回内容：{"status":["0","1","2"],"usernameError":["0","1"],"password1Error":["0","1"],"password2Error":["0","1"],"passwordMismatch":["0","1"]}
  */
	public function joinActivity()
	{
	  $invalid=0;
	  
	  $this->load->helper('form');
	  $this->load->library('form_validation');
	  
	  $this->form_validation->set_rules('username', '姓名', 'required|trim|xss_clean|max_length[128]');
	  $this->form_validation->set_rules('password1', '密码', 'required');
	  $this->form_validation->set_rules('password2', '密码(重复)', 'required');
	  
	  if (strlen(trim($this->input->post('username')))==0){$data['usernameError']='1';$invalid=1;}else{$data['usernameError']='0';}
	  if (strlen(trim($this->input->post('password1')))==0){$data['password1Error']='1';$invalid=1;}else{$data['password1Error']='0';}
	  if (strlen(trim($this->input->post('password2')))==0){$data['password2Error']='1';$invalid=1;}else{$data['password2Error']='0';}
	  if ($this->input->post('password1')!=$this->input->post('password2')){$data['passwordMismatch']='1';$invalid=1;}else{$data['passwordMismatch']='0';}
	  
	  if ($this->form_validation->run() === FALSE or $invalid===1)
	  {
	    $data['status']='1'; //error: invalid form data
	  }
	  else
	  {
		$result=$this->api_model->joinActivity(intval($this->input->post('id')),$this->input->post('username'),$this->input->post('password1'));
		if ($result==1)
		{
			$data['status']='2'; //error: duplicate username
		}
		elseif ($result==0)
		{
			$data['status']='0'; //success	
		}
	  }
	$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
  功能：创建活动
  方法：POST /api/createActivity
  参数：title,slug,model_timetable,model_chatroom,model_location,password1,password2
  返回类型：json
  返回内容：{"status":["0","1"],"titleError":["0","1"],"slugError":["0","1"],"password1Error":["0","1"],"password2Error":["0","1"],"passwordMismatch":["0","1"],"slugUnavailable":["0","1"]}
  */
	public function createActivity()
	{
	  $invalid=0;
	  
	  $this->load->helper('form');
	  $this->load->library('form_validation');
	  
	  $this->form_validation->set_rules('title', '活动名称', 'required|trim|xss_clean|max_length[128]');
	  $this->form_validation->set_rules('slug', '活动主页', 'required|trim|xss_clean|max_length[128]');
	  $this->form_validation->set_rules('password1', '管理密码', 'required');
	  $this->form_validation->set_rules('password2', '管理密码(重复)', 'required');
	  
	  if (strlen(trim($this->input->post('title')))==0){$data['titleError']='1';$invalid=1;}else{$data['titleError']='0';}
	  if (strlen(trim($this->input->post('slug')))==0){$data['slugError']='1';$invalid=1;}else{$data['slugError']='0';}
	  if (strlen(trim($this->input->post('password1')))==0){$data['password1Error']='1';$invalid=1;}else{$data['password1Error']='0';}
	  if (strlen(trim($this->input->post('password2')))==0){$data['password2Error']='1';$invalid=1;}else{$data['password2Error']='0';}
	  if ($this->input->post('password1')!=$this->input->post('password2')){$data['passwordMismatch']='1';$invalid=1;}else{$data['passwordMismatch']='0';}
	  if ($this->db->get_where('activities', array('slug' => $this->input->post('slug')))->num_rows() > 0){$data['slugUnavailable']='1';$invalid=1;}else{$data['slugUnavailable']='0';}
	  
	  if ($this->form_validation->run() === FALSE or $invalid===1)
	  {
	    $data['status']='1'; //error:invalid
	  }
	  else
	  {
	    $data['status']='0'; //success
			$this->api_model->addActivity($this->input->post('title'),$this->input->post('slug'),$this->input->post('model_timetable'),$this->input->post('model_chatroom'),$this->input->post('model_location'),$this->input->post('password1'));
	  }
	  $this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：由slug查询id
  方法：GET /api/getID
  参数：slug
  返回类型：json
  返回内容：{"id":"%id%"}
	*/
	public function getID($slug)
	{
		$data['id']=$this->api_model->getID($slug);
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：由id查询slug
  方法：GET /api/getSlug
  参数：id
  返回类型：json
  返回内容：{"slug":"%slug%"}
	*/
	public function getSlug($id)
	{
		$data['slug']=$this->api_model->getSlug($id);
		$this->load->view('api/status',array("result" => json_encode($data)));
	}

	/*
	功能：检查给定的id是否存在
  方法：GET /api/checkActivityID
  参数：id
  返回类型：json
  返回内容：{"exist":["0","1"]}
	*/
	public function checkActivityID($id)
	{
		$data['exist']=strval(intval($this->api_model->checkActivityID($id)));
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：检查给定的slug是否存在
  方法：GET /api/checkActivitySlug
  参数：slug
  返回类型：json
  返回内容：{"exist":["0","1"]}
	*/
	public function checkActivitySlug($slug)
	{
		$data['exist']=strval(intval($this->api_model->checkActivitySlug($slug)));
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：由id查询活动标题
	方法：GET /api/getActivityTitle
  参数：id
  返回类型：json
  返回内容：{"title":"%title%"}
	*/
	public function getActivityTitle($id)
	{ 
		$data['title']=$this->api_model->getActivityTitle($id);
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：由id查询活动信息
	方法：GET /api/getActivityInfo
  参数：id
  返回类型：json
  返回内容：{"info":"%info%"}
	*/
	public function getActivityInfo($id)
	{
		$data['info']=$this->api_model->getActivityInfo($id);
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：登录到活动后台管理
	方法：POST /api/adminLogin
	参数：id,password
	返回类型：json
	返回内容：{"status":["0","1"]}
	*/
	public function adminLogin()
	{
		$id=$this->input->post('id');
		$password=$this->input->post('password');
		if($this->api_model->checkAdminPassword($id,$password)==true)
		{
			$data['status']="0";
			$this->session->set_userdata(array(
				'adminid' => $id
				));
		}
		else
		{
			$data['status']="1";
		}
		$this->load->view('api/status',array("result" => json_encode($data)));
	}

	/*
	功能：活动后台管理登出
	方法：GET /api/adminLogout
	参数：无
	返回类型：json
	返回内容：{"status":["0","1"]}
	*/	
	public function adminLogout()
	{
		if($this->session->userdata('adminid')!==false)
		{
			$this->session->unset_userdata('adminid');
			$data['status']="0";
		}
		else
		{
			$data['status']="1";
		}
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：修改活动标题
	方法：POST /api/updateActivityTitle
	参数：id,title
	返回类型：json
	返回内容：{"status":["0","1"]}
	*/	
	public function updateActivityTitle()
	{
		$id=$this->input->post('id');
		if($this->api_model->checkAdminLoggedIn($id)==true)
		{
			$title=$this->input->post('title');
			$this->api_model->updateActivityTitle($id,$title);
			$data['status']="0";
		}
		else
		{
			$data['status']="1";
		}
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：修改活动信息
	方法：POST /api/updateActivityInfo
	参数：id,info
	返回类型：json
	返回内容：{"status":["0","1"]}
	*/	
	public function updateActivityInfo()
	{
		$id=$this->input->post('id');
		if($this->api_model->checkAdminLoggedIn($id)==true)
		{
			$info=$this->input->post('info');
			$this->api_model->updateActivityInfo($id,$info);
			$data['status']="0";
		}
		else
		{
			$data['status']="1";
		}
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：修改活动slug
	方法：POST /api/updateActivitySlug
	参数：id,slug
	返回类型：json
	返回内容：{"status":["0","1"],"slugError":["0","1"],"loginError":["0","1"]}
	*/	
	public function updateActivitySlug()
	{
		$id=$this->input->post('id');
		$slug=$this->input->post('slug');
		if($this->api_model->checkActivitySlug($slug)==true)
		{
			$data['slugError']="1";
		}
		else
		{
			$data['slugError']="0";
		}
		if($this->api_model->checkAdminLoggedIn($id)==false)
		{
			$data['loginError']="1";
		}
		else
		{
			$data['loginError']="0";
		}
		if($data['slugError']="0" && $data['loginError']="0")
		{

			$this->api_model->updateActivitySlug($id,$slug);
			$data['status']="0";
		}
		else
		{
			$data['status']="1";
		}
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：用户登录
	方法：POST /api/userLogin
	参数：id,username,password
	返回类型：json
	返回内容：{"status":["0","1"]}
	*/	
	public function userLogin()
	{
		$id=$this->input->post('id');
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		if($this->api_model->checkUserPassword($id,$username,$password)===true)
		{
			$this->session->set_userdata(array(
				"activity".$id => $username
				));
			$data['status']="0";
		}
		else
		{
			$data['status']=$this->api_model->checkUserPassword($id,$username,$password);
		}
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：用户登出
	方法：GET /api/userLogout
	参数：id
	返回类型：json
	返回内容：{"status":["0","1"]}
	*/	
	public function userLogout($id)
	{
		if($this->api_model->checkUserLoggedIn($id)==true)
		{
			$this->session->unset_userdata('activity'.$id);
			$data['status']="0";
		}
		else
		{
			$data['status']="1";
		}
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：用户退出活动
	方法：POST /api/userUnregister
	参数：id,username
	返回类型：json
	返回内容：{"status":["0","1"]}
	*/	
	public function userUnregister()
	{
		$id=$this->input->post('id');
		$username=$this->input->post('username');
		if($this->api_model->checkUserLoggedIn($id,$username)==true)
		{
			$r=$this->api_model->userUnregister($id,$username);
			if($r==true)
			{
				$this->session->unset_userdata('activity'.$id);
				$data['status']="0";
			}
			else
			{
				$data['status']="1";
			}
		}
		else
		{
			$data['status']="1";
		}
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：活动管理员获取活动的用户列表
	方法：GET /api/getUserList
	参数：id
	返回类型：json
	返回内容：{"status":["0","1"],"%id%":"%username%"}
	*/	
	public function getUserList($id)
	{
		echo $this->encoding->utf8encode($this->encoding->convert_entities(str_replace('\\','%',$this->api_model->getUserList($id))));
	}
	
	/*
	功能：活动管理员移除用户
	方法：POST /api/removeUser
	参数：id,username
	返回类型：json
	返回内容：{"status":["0","1"],"loginerror":["0","1"],"usernameerror":["0","1"]}
	*/	
	public function removeUser()
	{
		$id=$this->input->post('id');
		$username=$this->input->post('username');
		if($this->api_model->checkAdminLoggedIn($id)==false)
		{
			$data['loginerror']="1";
		}
		else
		{
			$data['loginerror']="0";
		}
		if($this->api_model->checkUserRegistered($id,$username)==false)
		{
			$data['usernameerror']="1";
		}
		else
		{
			$data['usernameerror']="0";
		}
		if($data['loginerror']=="1" || $data['usernameerror']=="1")
		{
			$data['status']="1";
		}
		else
		{
			$data['status']="0";
		}
		$this->api_model->userUnregister($id,$username); //此处借用用户退出活动的函数，由于先前已检验checkUserRegistered，故此处userUnregister的返回值忽略(因不可能返回false)
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：检查用户是否在一个活动注册
	方法：POST /api/checkUser
	参数：id,username
	返回类型：json
	返回内容：{"status":["0","1"],"exist":["0","1",""]}
	*/	
	public function checkUser()
	{
		$id=$this->input->post('id');
		$username=$this->input->post('username');
		if($this->api_model->checkAdminLoggedIn($id)==false)
		{
			$data['status']="1";
			$data['exist']="";
		}
		else
		{
			$data['status']="0";
			$r=$this->api_model->checkUserRegistered($id,$username); //此处借用其他用户管理功能所使用的一个内部函数
			if ($r==true)
			{
				$data['exist']="1";
			}
			else
			{
				$data['exist']="0";
			}
		}
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	功能：启用/禁用活动的时间表模块
	方法：POST /api/setModelTimetable
	参数：id,state
	返回类型：json
	返回内容：{"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"]}
	*/
	public function setModelTimetable()
	{
		$id=$this->input->post('id');
		$state=$this->input->post('state');
		if($state!=="1")
		{
			$state="0";
		}
		$r=$this->api_model->setModelTimetable($id,$state);
		$this->load->view('api/status',array("result" => $r));
	}
	
	/*
	功能：启用/禁用活动的聊天室模块
	方法：POST /api/setModelChatroom
	参数：id,state
	返回类型：json
	返回内容：{"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"]}
	*/
	public function setModelChatroom()
	{
		$id=$this->input->post('id');
		$state=$this->input->post('state');
		if($state!=="1")
		{
			$state="0";
		}
		$r=$this->api_model->setModelChatroom($id,$state);
		$this->load->view('api/status',array("result" => $r));
	}
	
	/*
	功能：启用/禁用活动的位置共享模块
	方法：POST /api/setModelLocation
	参数：id,state
	返回类型：json
	返回内容：{"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"]}
	*/
	public function setModelLocation()
	{
		$id=$this->input->post('id');
		$state=$this->input->post('state');
		if($state!=="1")
		{
			$state="0";
		}
		$r=$this->api_model->setModelLocation($id,$state);
		$this->load->view('api/status',array("result" => $r));
	}
	
	/*
	功能：查看活动的时间表模块状态
	方法：GET /api/getModelTimetable
	参数：id
	返回类型：json
	返回内容：{"state":["0","1"],"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"]}
	*/
	public function getModelTimetable($id)
	{
		$r=$this->api_model->getModelTimetable($id);
		$this->load->view('api/status',array("result" => $r));
	}
	
	/*
	功能：查看活动的聊天室模块状态
	方法：GET /api/getModelChatroom
	参数：id
	返回类型：json
	返回内容：{"state":["0","1"],"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"]}
	*/
	public function getModelChatroom($id)
	{
		$r=$this->api_model->getModelChatroom($id);
		$this->load->view('api/status',array("result" => $r));
	}
	
	/*
	功能：查看活动的位置共享模块状态
	方法：GET /api/getModelLocation
	参数：id
	返回类型：json
	返回内容：{"state":["0","1"],"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"]}
	*/
	public function getModelLocation($id)
	{
		$r=$this->api_model->getModelLocation($id);
		$this->load->view('api/status',array("result" => $r));
	}
	
	/*
	功能：用户添加可用时间
	方法：POST /api/addAvailableTime
	参数：id,time1,time2
	返回类型：json
	返回内容：{"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"],"timeerror":["0","1"]}
	*/
	public function addAvailableTime()
	{
		$id=$this->input->post('id');
		$time1=$this->input->post('time1');
		$time2=$this->input->post('time2');
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
		if (intval($time1)<intval($time2) && intval($time1)>0 && intval($time2)>0)
		{
			$data['timeerror']="0";
		}
		else
		{
			$data['timeerror']="1";
		}
		if ($data['iderror']=="1"||$data['loginerror']=="1"||$data['timeerror']=="1")
		{
			$data['status']="1";
		}
		else
		{
			$data['status']="0";
			$this->api_model->addAvailableTime($id,$time1,$time2);
		}
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	public function addUnavailableTime()
	{
		$id=$this->input->post('id');
		$time1=$this->input->post('time1');
		$time2=$this->input->post('time2');
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
		if (intval($time1)<intval($time2) && intval($time1)>0 && intval($time2)>0)
		{
			$data['timeerror']="0";
		}
		else
		{
			$data['timeerror']="1";
		}
		if ($data['iderror']=="1"||$data['loginerror']=="1"||$data['timeerror']=="1")
		{
			$data['status']="1";
		}
		else
		{
			$data['status']="0";
			$this->api_model->addUnavailableTime($id,$time1,$time2);
		}
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
}
?>
