<?php 
/*
������ʾ����ִ�н��(json)��ҳ��
*/
echo $this->encoding->utf8encode($this->encoding->convert_entities(str_replace('\\','%',$result)));
?>
