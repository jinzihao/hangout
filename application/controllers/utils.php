<?php
/*
����ģ�飬�ṩһЩ����������ģ�����
*/

class utils extends CI_Controller {
	
	/*
  ���ܣ�slug����
  ������POST /utils/slug
  ������title
  �������ͣ�text
  �������ݣ�"slug"
  */
	public function slug()
	{
		$this->load->helper('url');
		
		echo url_title($this->input->post('title'), 'dash', TRUE);
	}
}
