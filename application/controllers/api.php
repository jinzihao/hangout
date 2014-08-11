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
  登录到活动的后端模块，POST /api/login?username=&password=&activity=，目前不可用
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
  列出系统内所有活动，GET /api/activitylist，可获得以换行符分隔的活动列表
  */
  public function activitylist()
	{
		echo $this->api_model->getActivityList();
	}
  /*
  创建活动，POST /api/createactivity?title=&slug=&password=，目前不可用
  密码需用SHA1加密后提交
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
