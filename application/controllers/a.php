<?php
/*
活动内容显示的前端模块，由activities模块接收数据，对应的视图为a/目录下的页面
*/
class a extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('a_model');
  }
  
  /*
  显示活动内容模块，用于加载/a/{slug}页面内容
  */
  public function view($slug,$action="")
	{
		if ($this->a_model->checkActivitySlug($slug)===false){ header ("location:/"); }
		
		$id=$this->a_model->getID($slug);
		$title=$this->a_model->getActivityTitle($id);
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
