<?php
/*
����ģ�飬�ṩһЩ����������ģ�����
*/

class utils extends CI_Controller {
	
	/*
  ���ܣ�slug����
  ������POST /utils/generateSlug
  ������title
  �������ͣ�text
  �������ݣ�"%slug%"
  */
	public function generateSlug()
	{
		$this->load->helper('url');
		
		echo url_title($this->input->post('title'), 'dash', TRUE);
	}
}
