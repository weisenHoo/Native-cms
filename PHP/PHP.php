<?php
/*
 * ��������ʱ��
 * 
 * */
function run_time($start,$end='',$decimial=3){
	static $times = array();
	if($end != ''){
		$times[$end] = microtime();
		return number_format(($times[$end]-$times[$start]), $decimial);
	}
	$times[$start] = microtime();
}

run_time("start");

//��Ŀ��ʼ��
if(!defined("APP_PATH")){
	define("APP_PATH", dirname($_SERVER['SCRIPT_FILENAME']));
}
//�����Ŀ¼
define("PHP_PATH", dirname(__FILE__));
//��ʱĿ¼
define("TEMP_PATH", APP_PATH.'/temp');
//���ر����ļ�
$runtime_file = TEMP_PATH.'/runtime.php';
if(is_file($runtime_file)){
	require $runtime_file;
}else{
	include PHP_PATH.'/common/runtime.php';
	runtime();
}

run_time("end");








?>