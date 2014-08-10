<?php
class utils extends CI_Controller {
	public function slug()
	{
		$this->load->helper('url');
		
		echo url_title($this->input->post('title'), 'dash', TRUE);
	}
}
