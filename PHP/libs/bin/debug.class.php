<?php
/*
 * 
 * 
 * */

class debug{
	//����ʱ��
	static $runtime;
	//�ڴ�ռ��
	static $memory;
	//�ڴ��ֵ
	static $memory_peak;
	
	//���Կ�ʼ
	static function start($start){
		self::$runtime[$start] = microtime(TRUE);//���ص�ǰ Unix ʱ�����΢����
		self::$memory[$start] = memory_get_usage();//���ط���� PHP ���ڴ���
		self::$memory_peak[$start] = memory_get_peak_usage();//���ط���� PHP �ڴ�ķ�ֵ
	}
	
	//����ʱ��
	static function runtime($start,$end='',$decimals=4){
		if(!isset(self::$runtime[$start])){
			error("����������Ŀ��㣡");
		}
		if(empty(self::$runtime[$end])){
			self::$runtime[$end] = microtime(TRUE);
			return number_format(self::$runtime[$end]-self::$runtime[$start], $decimals);
		}
	}
	
	//�ڴ��ֵռ��
	static function memory_peak($start,$end=''){
		if(!isset(self::$memory_peak[$start])){
			return FALSE;
		}
		if(!empty($end)){
			self::$memory_peak[$end] = memory_get_peak_usage();
		}
		return max(self::$memory_peak[$start], self::$memory_peak[$end]);
	}
	
	//��Ŀ���н��
	static function show($start,$end){
		$message = "��Ŀ����ʱ��".self::runtime($start,$end)."&nbsp;&nbsp;�ڴ��ֵ".number_format(self::memory_peak($start,$end)/1024)."KB";//��ǧλ�ָ�����ʽ��ʽ��һ������
		$load_file_list = loadfile();
		$info = '';
		$i = 1;
		foreach($load_file_list as $k=>$v){
			$info.="[".$i++."]".$k."<br/>";
		}
		$e['info'] = $info."<p>{$message}</p>";
		include c("DEBUG_TPL");
	}
}



























?>