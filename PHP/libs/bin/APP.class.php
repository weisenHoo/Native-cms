<?php
/*
 * ��Ŀ������
 * 
 * */

class APP{
	static $module;//ģ��
	static $control;//������
	static $action;//��������
	
	static function run(){
		//�����Զ��������ļ�
		spl_autoload_register(array(__CLASS__, "autoload"));//ע������ĺ�����Ϊ __autoload ��ʵ��
		//ע���������
		set_error_handler(array(__CLASS__, "error"));//�����û��Զ���Ĵ�������
		//ע���쳣������
		set_exception_handler(array(__CLASS__,"exception"));//�����û��Զ���Ĵ�������
		//�Ƿ�ת��
		define("MAGIC_QUTES_GPC", get_magic_quotes_gpc()?TRUE:FALSE);//��ȡ��ǰ magic_quotes_gpc ������ѡ������
		//����ʱ��
		if(function_exists("date_default_timezone_set")){
			date_default_timezone_set(C("DEFAULT_TIMEZOBE_SET"));//�趨����һ���ű�����������ʱ�亯����Ĭ��ʱ��
		}
		//����������
		self::config();	
		//���Կ�ʼ
		if(C("DEBUG")){
			debug::start("app_start");
		}
		self::init();	
		if(C("DEBUG")){
			debug::show("app_start", "app_end");
		}
		log::save();
	}
	
	//��ʼ������
	static function init(){			
		//����·����
		url::parseUrl();
		$control_file = MODULE_PATH.'/'.MODULE.'/'.CONTROL.C("CONTROL_FIX").C("CLASS_FIX").'.php';
		$control = A(CONTROL);
		$action = ACTION;
		if(!method_exists($control, $action)){
			error("������".CONTROL."�еĶ���".$action."������");
		}
		$control->$action();
	}
	
	//��ʼ�������ļ�����
	static function config(){
		$config_file = CONFIG_PATH.'/config.php';
		if(is_file($config_file)){
			C(require $config_file);
		}
	}
	
	//�Զ��������ļ�
	static function autoload($classname){
		if(strpos($classname, C("CONTROL_FIX"))>0){
			error("���󣺿�����������A()����������������û�д���");
		}
		$classfile = PHP_PATH.'/libs/bin/'.$classname.'.class.php';
		loadfile($classfile);
	}
	
	//������
	static function error($erron,$errstr,$errfile,$errline){
		switch($erron){
			case E_ERROR:
			case E_USER_ERROR:
				$errmsg = "ERROR:[$erron]<strong>$errstr</strong>File:$errfile"."[$errline]";
				log::write("[ERROR:][$erron]<strong>$errstr</strong>File:$errfile($errline)");
				error($errmsg);
				break;
			case E_NOTICE:
			case E_USER_NOTICE:
			case E_USER_WARNING:
			default:
				$errmsg = "NOTICE:[$erron]<strong>$errstr</strong>File:$errfile"."[$errline]";
				log::set("[$erron]<strong>$errstr</strong>File:$errfile($errline)", "NOTICE");
				notice(func_get_args());//����һ���������������б������
				break;
		}
	}
	
	//�쳣����
	static function exception($e){
		error($e->show());
	}
}





































?>