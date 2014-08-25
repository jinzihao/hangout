<?php
/*
APIģ�飬���ںͿͻ��˼���������վ�������û����ɼ�
*/
class api extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('api_model');
  }
	
	/*
  ���ܣ���б�
  ������GET /api/activityList
  ��������
  �������ͣ�json
  �������ݣ�{"%id%":"%title%"}
  */
  public function activitylist()
	{
		echo $this->api_model->getActivityList();
	}
	
	/*
  ���ܣ�����
  ������POST /api/joinActivity
  ������id,username,password1,password2
  �������ͣ�json
  �������ݣ�{"status":["0","1","2"],"usernameError":["0","1"],"password1Error":["0","1"],"password2Error":["0","1"],"passwordMismatch":["0","1"]}
  */
	public function joinActivity()
	{
	  $invalid=0;
	  
	  $this->load->helper('form');
	  $this->load->library('form_validation');
	  
	  $this->form_validation->set_rules('username', '����', 'required|trim|xss_clean|max_length[128]');
	  $this->form_validation->set_rules('password1', '����', 'required');
	  $this->form_validation->set_rules('password2', '����(�ظ�)', 'required');
	  
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
  ���ܣ������
  ������POST /api/createActivity
  ������title,slug,model_timetable,model_chatroom,model_location,password1,password2
  �������ͣ�json
  �������ݣ�{"status":["0","1"],"titleError":["0","1"],"slugError":["0","1"],"password1Error":["0","1"],"password2Error":["0","1"],"passwordMismatch":["0","1"],"slugUnavailable":["0","1"]}
  */
	public function createActivity()
	{
	  $invalid=0;
	  
	  $this->load->helper('form');
	  $this->load->library('form_validation');
	  
	  $this->form_validation->set_rules('title', '�����', 'required|trim|xss_clean|max_length[128]');
	  $this->form_validation->set_rules('slug', '���ҳ', 'required|trim|xss_clean|max_length[128]');
	  $this->form_validation->set_rules('password1', '��������', 'required');
	  $this->form_validation->set_rules('password2', '��������(�ظ�)', 'required');
	  
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
	���ܣ���slug��ѯid
  ������GET /api/getID
  ������slug
  �������ͣ�json
  �������ݣ�{"id":"%id%"}
	*/
	public function getID($slug)
	{
		$data['id']=$this->api_model->getID($slug);
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	���ܣ���id��ѯslug
  ������GET /api/getSlug
  ������id
  �������ͣ�json
  �������ݣ�{"slug":"%slug%"}
	*/
	public function getSlug($id)
	{
		$data['slug']=$this->api_model->getSlug($id);
		$this->load->view('api/status',array("result" => json_encode($data)));
	}

	/*
	���ܣ���������id�Ƿ����
  ������GET /api/checkActivityID
  ������id
  �������ͣ�json
  �������ݣ�{"exist":["0","1"]}
	*/
	public function checkActivityID($id)
	{
		$data['exist']=strval(intval($this->api_model->checkActivityID($id)));
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	���ܣ���������slug�Ƿ����
  ������GET /api/checkActivitySlug
  ������slug
  �������ͣ�json
  �������ݣ�{"exist":["0","1"]}
	*/
	public function checkActivitySlug($slug)
	{
		$data['exist']=strval(intval($this->api_model->checkActivitySlug($slug)));
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	���ܣ���id��ѯ�����
	������GET /api/getActivityTitle
  ������id
  �������ͣ�json
  �������ݣ�{"title":"%title%"}
	*/
	public function getActivityTitle($id)
	{ 
		$data['title']=$this->api_model->getActivityTitle($id);
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	���ܣ���id��ѯ���Ϣ
	������GET /api/getActivityInfo
  ������id
  �������ͣ�json
  �������ݣ�{"info":"%info%"}
	*/
	public function getActivityInfo($id)
	{
		$data['info']=$this->api_model->getActivityInfo($id);
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	���ܣ���¼�����̨����
	������POST /api/adminLogin
	������id,password
	�������ͣ�json
	�������ݣ�{"status":["0","1"]}
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
	���ܣ����̨����ǳ�
	������GET /api/adminLogout
	��������
	�������ͣ�json
	�������ݣ�{"status":["0","1"]}
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
	���ܣ��޸Ļ����
	������POST /api/updateActivityTitle
	������id,title
	�������ͣ�json
	�������ݣ�{"status":["0","1"]}
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
	���ܣ��޸Ļ��Ϣ
	������POST /api/updateActivityInfo
	������id,info
	�������ͣ�json
	�������ݣ�{"status":["0","1"]}
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
	���ܣ��޸Ļslug
	������POST /api/updateActivitySlug
	������id,slug
	�������ͣ�json
	�������ݣ�{"status":["0","1"],"slugError":["0","1"],"loginError":["0","1"]}
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
	���ܣ��û���¼
	������POST /api/userLogin
	������id,username,password
	�������ͣ�json
	�������ݣ�{"status":["0","1"]}
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
	���ܣ��û��ǳ�
	������GET /api/userLogout
	������id
	�������ͣ�json
	�������ݣ�{"status":["0","1"]}
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
	���ܣ��û��˳��
	������POST /api/userUnregister
	������id,username
	�������ͣ�json
	�������ݣ�{"status":["0","1"]}
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
	���ܣ������Ա��ȡ����û��б�
	������GET /api/getUserList
	������id
	�������ͣ�json
	�������ݣ�{"status":["0","1"],"%id%":"%username%"}
	*/	
	public function getUserList($id)
	{
		echo $this->api_model->getUserList($id);
	}
	
	/*
	���ܣ������Ա�Ƴ��û�
	������POST /api/removeUser
	������id,username
	�������ͣ�json
	�������ݣ�{"status":["0","1"],"loginerror":["0","1"],"usernameerror":["0","1"]}
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
		$this->api_model->userUnregister($id,$username); //�˴������û��˳���ĺ�����������ǰ�Ѽ���checkUserRegistered���ʴ˴�userUnregister�ķ���ֵ����(�򲻿��ܷ���false)
		$this->load->view('api/status',array("result" => json_encode($data)));
	}
	
	/*
	���ܣ�����û��Ƿ���һ���ע��
	������POST /api/checkUser
	������id,username
	�������ͣ�json
	�������ݣ�{"status":["0","1"],"exist":["0","1",""]}
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
			$r=$this->api_model->checkUserRegistered($id,$username); //�˴����������û���������ʹ�õ�һ���ڲ�����
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
	���ܣ�����/���û��ʱ���ģ��
	������POST /api/setModelTimetable
	������id,state
	�������ͣ�json
	�������ݣ�{"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"]}
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
	���ܣ�����/���û��������ģ��
	������POST /api/setModelChatroom
	������id,state
	�������ͣ�json
	�������ݣ�{"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"]}
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
	���ܣ�����/���û��λ�ù���ģ��
	������POST /api/setModelLocation
	������id,state
	�������ͣ�json
	�������ݣ�{"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"]}
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
	���ܣ��鿴���ʱ���ģ��״̬
	������GET /api/getModelTimetable
	������id
	�������ͣ�json
	�������ݣ�{"state":["0","1"],"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"]}
	*/
	public function getModelTimetable($id)
	{
		$r=$this->api_model->getModelTimetable($id);
		$this->load->view('api/status',array("result" => $r));
	}
	
	/*
	���ܣ��鿴���������ģ��״̬
	������GET /api/getModelChatroom
	������id
	�������ͣ�json
	�������ݣ�{"state":["0","1"],"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"]}
	*/
	public function getModelChatroom($id)
	{
		$r=$this->api_model->getModelChatroom($id);
		$this->load->view('api/status',array("result" => $r));
	}
	
	/*
	���ܣ��鿴���λ�ù���ģ��״̬
	������GET /api/getModelLocation
	������id
	�������ͣ�json
	�������ݣ�{"state":["0","1"],"status":["0","1"],"iderror":["0","1"],"loginerror":["0","1"]}
	*/
	public function getModelLocation($id)
	{
		$r=$this->api_model->getModelLocation($id);
		$this->load->view('api/status',array("result" => $r));
	}
}
?>
