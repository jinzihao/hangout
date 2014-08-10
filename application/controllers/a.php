<?php
class a extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('a_model');
  }
  
  public function view($slug,$action="")
	{
		if ($this->a_model->checkActivity($slug)===false){ header ("location:/"); }
		
		$title=$this->a_model->getActivity($slug);
		$id=$this->a_model->getID($slug);
		$description=$this->a_model->getDescription($id);
		switch ($action)
		{
		case "":
			$data['id']=$id;
			$data['title']=$title;
			$data['slug']=$slug;
			$data['description']=$description;
			$this->load->view('a/header',$data);
			$this->load->view('a/view',$data);
			$this->load->view('a/footer');
		}
	}
}
?>
