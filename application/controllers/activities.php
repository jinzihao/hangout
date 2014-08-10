<?php
class activities extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('activities_model');
  }
  
  public function create()
	{
	  $invalid=0;
	  
	  $this->load->helper('form');
	  $this->load->library('form_validation');
	  
	  $this->form_validation->set_rules('title', '活动名称', 'required|trim|xss_clean|max_length[128]');
	  $this->form_validation->set_rules('slug', '活动主页', 'required|trim|xss_clean|max_length[128]');
	  $this->form_validation->set_rules('adminPassword', '管理密码', 'required');
	  $this->form_validation->set_rules('adminPasswordAgain', '管理密码(重复)', 'required');
	  
	  if (strlen(trim($this->input->post('title')))==0){$data['error1']='1';$invalid=1;}else{$data['error1']='0';}
	  if (strlen(trim($this->input->post('slug')))==0){$data['error2']='1';$invalid=1;}else{$data['error2']='0';}
	  if (strlen(trim($this->input->post('adminPassword')))==0){$data['error3']='1';$invalid=1;}else{$data['error3']='0';}
	  if (strlen(trim($this->input->post('adminPasswordAgain')))==0){$data['error4']='1';$invalid=1;}else{$data['error4']='0';}
	  if ($this->input->post('adminPassword')!=$this->input->post('adminPasswordAgain')){$data['error5']='1';$invalid=1;}else{$data['error5']='0';}
	  if ($this->db->get_where('activities', array('slug' => $this->input->post('slug')))->num_rows() > 0){$data['error6']='1';$invalid=1;}else{$data['error6']='0';}
	  
	  if ($this->form_validation->run() === FALSE or $invalid===1)
	  {
	    $data['success']='0';
		$this->load->view('activities/error',array("result" => json_encode($data)));
	  }
	  else
	  {
	    $data['success']='1';
	  	$data['slug'] = $this->input->post('slug');
		$this->activities_model->addActivity();
		$this->load->view('activities/success',array("result" => json_encode($data)));
	  }
	}
	public function join()
	{
	  $invalid=0;
	  
	  $this->load->helper('form');
	  $this->load->library('form_validation');
	  
	  $this->form_validation->set_rules('username', '姓名', 'required|trim|xss_clean|max_length[128]');
	  $this->form_validation->set_rules('userPassword', '密码', 'required');
	  $this->form_validation->set_rules('userPasswordAgain', '密码(重复)', 'required');
	  
	  if (strlen(trim($this->input->post('username')))==0){$data['error1']='1';$invalid=1;}else{$data['error1']='0';}
	  if (strlen(trim($this->input->post('userPassword')))==0){$data['error2']='1';$invalid=1;}else{$data['error2']='0';}
	  if (strlen(trim($this->input->post('userPasswordAgain')))==0){$data['error3']='1';$invalid=1;}else{$data['error3']='0';}
	  if ($this->input->post('userPassword')!=$this->input->post('userPasswordAgain')){$data['error4']='1';$invalid=1;}else{$data['error4']='0';}
	  
	  if ($this->form_validation->run() === FALSE or $invalid===1)
	  {
	    $data['status']='1'; //error: invalid form data
	  }
	  else
	  {
		$result=$this->activities_model->joinActivity(intval($this->input->post('id')),$this->input->post('username'),$this->input->post('userPassword'));
		if ($result==1)
		{
			$data['status']='2'; //error: duplicate username
		}
		elseif ($result==0)
		{
			$data['status']='0'; //success	
		}
	  }
	$this->load->view('a/status',array("result" => json_encode($data)));
	}
}
?>
