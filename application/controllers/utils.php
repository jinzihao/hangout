<?php
/*
工具模块，提供一些函数供其它模块调用
*/

class utils extends CI_Controller {
	
	/*
  功能：slug生成
  方法：POST /utils/generateSlug
  参数：title
  返回类型：text
  返回内容："%slug%"
  */
	public function generateSlug()
	{
		$this->load->helper('url');
		
		echo url_title($this->input->post('title'), 'dash', TRUE);
	}
}
