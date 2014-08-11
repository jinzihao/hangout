<?php
/*
�������ʾ��ǰ��ģ�飬��activitiesģ��������ݣ���Ӧ����ͼΪa/Ŀ¼�µ�ҳ��
*/
class a extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('a_model');
  }
  
  /*
  ��ʾ�����ģ�飬���ڼ���/a/{slug}ҳ������
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
