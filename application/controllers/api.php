<?php
class api extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('api_model');
  }
  
  public function login()
	{
			//var_dump($_POST);
			echo $_POST['username'];
			echo " ";
			echo $_POST['password'];
			echo " ";	
			echo $_POST['activity'];
	}
  public function activitylist()
	{
		echo $this->api_model->getActivityList();
	}
  
  public function createactivity()
	{
		$_POST['title'];
	}
}
?>
