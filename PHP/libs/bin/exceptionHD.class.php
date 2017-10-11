<?php
/*
 * �쳣������
 * 
 * */

class exceptionHD extends Exception{
	function __construct($message, $code=0){
		parent::__construct($message, $code);
	}
	
	//��ʾ�쳣
	function show(){
		$trace = $this->getTrace();
		$error['message'] = "Message:".$this->message;
		$error['message'].="<br/>File:".$this->file."[".$this->line."]";
		$error['message'].="<br/>".$trace[0]['class'];
		$error['message'].=$trace[0]['type'];
		$error['message'].=$trace[0]['function']."()";
		array_shift($trace);
		$info = '';
		foreach($trace as $v){
			$class = isset($v['class'])?$v['class']:'';
			$type = isset($v['type'])?$v['type']:'';
			$file = isset($v['file'])?$v['file']:'';
			$info.=$file."\t".$class.$type.$v['function']."<br/>";
		}		
		$error['info'] = $info;
		log::write($error['message']);
		return $error;
	}
}





















?>