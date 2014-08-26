<?php
class lab extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('lab_model');
  }
  
	public function processImage($filename)
	{
		$r=$this->lab_model->processImage($filename);
		$this->load->view('lab/status',array("result" => $r));
	}
}
?>
