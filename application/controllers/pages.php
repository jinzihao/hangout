<?php
/*
页面加载模块，用于加载首页及其他非功能性页面
*/
class Pages extends CI_Controller {
	/*
	页面加载函数，默认加载主页
	*/
	public function view($page = 'home')
	{
		 if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
  		{
   			 // 页面不存在
   			 show_404();
 		 }
  
 		 $data['title'] = ucfirst($page); // 将title中的第一个字符大写
  
  		$this->load->view('templates/header', $data);
  		$this->load->view('pages/'.$page, $data);
  		$this->load->view('templates/footer', $data);

	}
}
