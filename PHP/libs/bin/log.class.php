<?php
/*
 * 日志处理类
 * 
 * */

class log{
	static $log = array();
	
	//记录日志内容
	static function set($message,$type='NOTICE'){
		if(in_array($type, C("LOG_TYPE"))){
			$date = date("y-m-d h:i:s");
			self::$log[] = "[".$type."]".$message."(".$date.")"."\r\n";
		}
	}
	
	//储存日志内容到日志文件
	static function save($message_type=3,$destination=null,$extra_headers=null){
		if(!C("LOG_START")) return;
		if(is_null($destination)){
			$destination = LOG_PATH.'/'.date("y_m_d").".log";
		}
		if($message_type==3){
			if(is_file($destination) && filesize($destination)>C("LOG_SIZE")){//filesize()取得文件大小
				rename($destination, dirname($destination).'/'.time().'.log');//rename()重命名一个文件或目录,dirname()返回路径中的目录部分
			}
		}
		error_log(implode(",", self::$log), $message_type, $destination);
	}
	
	//直接写入日志文件
	static function write($message,$message_type=3,$destination=null,$extra_headers=null){
		if(!C("LOG_START")) return;
		if(is_null($destination)){
			$destination = LOG_PATH.'/'.date("y_m_d").".log";
		}
		if($message_type==3){
			if(is_file($destination) && filesize($destination)>C("LOG_SIZE")){
				rename($destination, dirname($destination).'/'.time().'.log');
			}
		}
		$date = date("y-m-d h:i:s");
		$message = $message.$date."\r\n";
		error_log($message, $message_type, $destination);//发送错误信息到某个地方
	}
}













?>