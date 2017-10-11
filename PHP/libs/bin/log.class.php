<?php
/*
 * ��־������
 * 
 * */

class log{
	static $log = array();
	
	//��¼��־����
	static function set($message,$type='NOTICE'){
		if(in_array($type, C("LOG_TYPE"))){
			$date = date("y-m-d h:i:s");
			self::$log[] = "[".$type."]".$message."(".$date.")"."\r\n";
		}
	}
	
	//������־���ݵ���־�ļ�
	static function save($message_type=3,$destination=null,$extra_headers=null){
		if(!C("LOG_START")) return;
		if(is_null($destination)){
			$destination = LOG_PATH.'/'.date("y_m_d").".log";
		}
		if($message_type==3){
			if(is_file($destination) && filesize($destination)>C("LOG_SIZE")){//filesize()ȡ���ļ���С
				rename($destination, dirname($destination).'/'.time().'.log');//rename()������һ���ļ���Ŀ¼,dirname()����·���е�Ŀ¼����
			}
		}
		error_log(implode(",", self::$log), $message_type, $destination);
	}
	
	//ֱ��д����־�ļ�
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
		error_log($message, $message_type, $destination);//���ʹ�����Ϣ��ĳ���ط�
	}
}













?>