<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class encoding {
	/**
	* 将 %u4F19 转换成如 伙 的 HTML Entity 的形式
	*
	* @param mixed $str
	* @access public
	* @return void
	*/
	function convert_entities($str) {
	    $str = preg_replace_callback('|%u([a-f0-9]{4})|i',
	        create_function(
	            '$matches',
	            'return \'&#\' . hexdec($matches[1]) . \';\';'
	        ),
	        $str
	    );
	    return $str;
	}
	
	/**
	* 把 HTML Entity 转换为原始字符
	*
	* @param mixed $source
	* @access public
	* @return void
	*/
	function utf8encode($source) {
	    $utf8str  = '';
	    $entities = explode('&#', $source);
	    $size     = count($entities);
	
	    for ($i = 0; $i < $size; $i++) {
	        $foo       = $entities[$i];
	        $nonEntity = strstr($foo, ';');
	
	        if ($nonEntity !== false) {
	            $unicode = intval(substr($foo, 0, (strpos($foo, ';') + 1)));
	            // determine how many chars are needed to reprsent this unicode char
	            if ($unicode < 128) {
	                $bar = chr($unicode);
	            }
	            else if ($unicode >= 128 and $unicode < 2048) {
	                $binVal   = str_pad(decbin($unicode), 11, '0', STR_PAD_LEFT);
	                $binPart1 = substr($binVal, 0, 5);
	                $binPart2 = substr($binVal, 5);
	
	                $char1 = chr(192 + bindec($binPart1));
	                $char2 = chr(128 + bindec($binPart2));
	                $bar   = $char1 . $char2;
	            }
	            else if ($unicode >= 2048 and $unicode < 65536) {
	                $binVal   = str_pad(decbin ($unicode), 16, '0', STR_PAD_LEFT);
	                $binPart1 = substr($binVal, 0, 4);
	                $binPart2 = substr($binVal, 4, 6);
	                $binPart3 = substr($binVal, 10);
	
	                $char1 = chr(224 + bindec($binPart1));
	                $char2 = chr(128 + bindec($binPart2));
	                $char3 = chr(128 + bindec($binPart3));
	                $bar   = $char1 . $char2 . $char3;
	            }
	            else {
	                $binVal   = str_pad(decbin($unicode), 21, '0', STR_PAD_LEFT);
	                $binPart1 = substr($binVal, 0, 3);
	                $binPart2 = substr($binVal, 3, 6);
	                $binPart3 = substr($binVal, 9, 6);
	                $binPart4 = substr($binVal, 15);
	
	                $char1 = chr(240 + bindec($binPart1));
	                $char2 = chr(128 + bindec($binPart2));
	                $char3 = chr(128 + bindec($binPart3));
	                $char4 = chr(128 + bindec($binPart4));
	                $bar   = $char1 . $char2 . $char3 . $char4;
	            }
	
	            if (strlen($nonEntity) > 1) {
	                $nonEntity = substr($nonEntity, 1); // chop the first char (';')
	            }
	            else {
	                $nonEntity = '';
	            }
	            $utf8str .= $bar . $nonEntity;
	        }
	        else {
	            $utf8str .= $foo;
	        }
	    }
	    return $utf8str;
	}
}