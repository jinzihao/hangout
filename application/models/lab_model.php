<?php
/*
API模块，用于提供API所需功能
*/
class lab_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }
  
  public function processImage($filename)
  {
  	$resize['image_library'] = 'gd2';
		$resize['source_image'] = $filename;
		$resize['create_thumb'] = TRUE;
		$resize['maintain_ratio'] = FALSE;
		$resize['width'] = 155;
		$resize['height'] = 155;
		$resize['quality'] = 100;
		$resize['dynamic_output'] = FALSE;
		$resize['thumb_marker'] = '';
		$this->load->library('image_lib', $resize); 
		
		$r1=$this->image_lib->resize();
		$this->image_lib->clear();
		
		$overlay['thumb_marker'] = '';
		$overlay['quality'] = 100;
		$overlay['source_image'] = $filename;
		$overlay['image_library'] = 'gd2';
		$overlay['wm_overlay_path'] = '/var/www/hangout/img/redpoint.png';
		$overlay['wm_opacity'] = 100;
		$overlay['wm_type'] = 'overlay';
		$overlay['padding'] = 0;
		$overlay['wm_vrt_alignment'] = 'top';
		$overlay['wm_hor_alignment'] = 'right';
		$this->load->library('image_lib', $overlay); 
		
		$r2=$this->image_lib->watermark();
		
		return $this->image_lib->display_errors();;
  }
}
