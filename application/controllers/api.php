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
  ������username,password1,password2
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
	public function checkActivitySlug($id)
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
}
?>
