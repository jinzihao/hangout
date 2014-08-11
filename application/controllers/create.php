<?php

/**
 * 创建新活动控制器
 *
 *
 * @package		CI
 * @author		Daniel Sun
 * @category	Output
 * @link		http://www.onlyke.com
 */

class Create extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->parser->assign('activity_url','http://hangout.jinzihao.info/a/');	//注册活动的基础URL
		$this->parser->parse("create/index.tpl");	//加载模板
	}

	/**
	 * 在这里处理表单数据
	 * @return [type] [description]
	 */
	public function handle(){
		dump($this->input->post());
	}

}