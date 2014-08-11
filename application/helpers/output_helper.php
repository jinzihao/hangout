<?php

/**
 * CI输出函数扩展
 *
 *
 * @package		CI
 * @author		mysunck@163.com
 * @category	Output
 * @link		http://www.onlyke.com
 */

/**
 * 直接创建不给中文进行编码的json_cncode来代替常量
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function json_cncode($data){
	return json_encode($data,JSON_UNESCAPED_UNICODE);
}

/**
 * 快速输出数组数据方便调试
 * @param  [type] $array [description]
 * @return [type]        [description]
 */
function dump ($array){
	echo "<pre>";
	var_dump($array);
	exit();
}