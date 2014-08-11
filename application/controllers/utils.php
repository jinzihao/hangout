<?php
/*
工具模块，提供一些函数供其它模块调用
*/
class utils extends CI_Controller {
	public function slug()
	{
		$this->load->helper('url');
		
		echo url_title($this->input->post('title'), 'dash', TRUE);
	}
}
