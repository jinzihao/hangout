<?php

/**
 * 这个类目前只是用来我熟悉框架用的，暂时还没有开发新功能
 *
 *
 * @package		CI
 * @author		mysunck@163.com
 * @category	Output
 * @link		http://www.onlyke.com
 */

class Ceshi extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->config->load('kses', true);	//加载KSES过滤类的配置文件
		$kses_config = $this->config->item('kses');	//将配置项目放入数组
		$this->output->jsonReturn($kses_config);	//测试新覆盖的OUTPUT核心类的方法
	}

}