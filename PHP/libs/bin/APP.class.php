<?php
/*
 * 项目处理类
 * 
 * */

class APP{
	static $module;//模块
	static $control;//控制器
	static $action;//动作方法
	
	static function run(){
		//配置自动加载类文件
		spl_autoload_register(array(__CLASS__, "autoload"));//注册给定的函数作为 __autoload 的实现
		//注册错误处理函数
		set_error_handler(array(__CLASS__, "error"));//设置用户自定义的错误处理函数
		//注册异常处理函数
		set_exception_handler(array(__CLASS__,"exception"));//设置用户自定义的错误处理函数
		//是否转义
		define("MAGIC_QUTES_GPC", get_magic_quotes_gpc()?TRUE:FALSE);//获取当前 magic_quotes_gpc 的配置选项设置
		//设置时区
		if(function_exists("date_default_timezone_set")){
			date_default_timezone_set(C("DEFAULT_TIMEZOBE_SET"));//设定用于一个脚本中所有日期时间函数的默认时区
		}
		//载入配置项
		self::config();	
		//调试开始
		if(C("DEBUG")){
			debug::start("app_start");
		}
		self::init();	
		if(C("DEBUG")){
			debug::show("app_start", "app_end");
		}
		log::save();
	}
	
	//初始化配置
	static function init(){			
		//调用路由器
		url::parseUrl();
		$control_file = MODULE_PATH.'/'.MODULE.'/'.CONTROL.C("CONTROL_FIX").C("CLASS_FIX").'.php';
		$control = A(CONTROL);
		$action = ACTION;
		if(!method_exists($control, $action)){
			error("控制器".CONTROL."中的动作".$action."不存在");
		}
		$control->$action();
	}
	
	//初始化配置文件处理
	static function config(){
		$config_file = CONFIG_PATH.'/config.php';
		if(is_file($config_file)){
			C(require $config_file);
		}
	}
	
	//自动加载类文件
	static function autoload($classname){
		if(strpos($classname, C("CONTROL_FIX"))>0){
			error("错误：控制器必须有A()函数创建，或者类没有创建");
		}
		$classfile = PHP_PATH.'/libs/bin/'.$classname.'.class.php';
		loadfile($classfile);
	}
	
	//错误处理
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
				notice(func_get_args());//返回一个包含函数参数列表的数组
				break;
		}
	}
	
	//异常处理
	static function exception($e){
		error($e->show());
	}
}





































?>