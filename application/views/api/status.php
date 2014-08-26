<?php 
/*
用于显示函数执行结果(json)的页面
*/
echo $this->encoding->utf8encode($this->encoding->convert_entities(str_replace('\\','%',$result)));
?>
