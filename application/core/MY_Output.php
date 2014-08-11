<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CI输出类的扩展
 *
 *
 * @package		CI
 * @author		mysunck@163.com
 * @category	Output
 * @link		http://www.onlyke.com
 */

class MY_Output extends CI_Output{

	/**
	 * 快速输出JSON数据，使用CI原生方法
	 * @param  [type] $data [数据]
	 * @return [type]       [description]
	 */
	public function jsonReturn($data) {
		$this->set_content_type('application/json')->set_output(json_cncode($data));
	}

	/**
	 * 快速输出JSON成功数据，配合前台使用
	 * @param  string $message [提示信息]
	 * @param  string $jumpUrl [跳转地址]
	 * @return [type]          [description]
	 */
	public function jsonSuccess($message='',$jumpUrl=''){
		$data = array();
		$data['info']   =   $message;
	    $data['status'] =   1;
	    $data['url']    =   $jumpUrl === true ? '[#RELOAD#]' : $jumpUrl;
	    $this->jsonReturn($data);
	}

	/**
	 * 快速输出JSON失败数据，配合前台使用
	 * @param  string $message [提示信息]
	 * @param  string $jumpUrl [跳转地址]
	 * @return [type]          [description]
	 */
	public function jsonError($message='',$jumpUrl=''){
		$data = array();
		$data['info']   =   $message;
	    $data['status'] =   0;
	    $data['url']    =   $jumpUrl===true ? '[#RELOAD#]' : $jumpUrl;
	    $this->jsonReturn($data);
	}

}