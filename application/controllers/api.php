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
  ��¼����ĺ��ģ�飬POST /api/login?username=&password=&activity=��Ŀǰ������
  */
  public function login()
	{
			//var_dump($_POST);
			echo $_POST['username'];
			echo " ";
			echo $_POST['password'];
			echo " ";	
			echo $_POST['activity'];
	}
	/*
  �г�ϵͳ�����л��GET /api/activitylist���ɻ���Ի��з��ָ��Ļ�б�
  */
  public function activitylist()
	{
		echo $this->api_model->getActivityList();
	}
  /*
  �������POST /api/createactivity?title=&slug=&password=��Ŀǰ������
  ��������SHA1���ܺ��ύ
  */
  public function createactivity()
	{
			echo $_POST['title'];
			echo " ";
			echo $_POST['slug'];
			echo " ";	
			echo $_POST['password'];
	}
}
?>
