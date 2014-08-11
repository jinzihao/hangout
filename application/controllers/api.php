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
		echo $this->api_model->getActivityList();
	}
	
	/*
  功能：加入活动
  方法：POST /api/joinActivity
  参数：username,password1,password2
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
	public function checkActivitySlug($id)
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
}
?>
