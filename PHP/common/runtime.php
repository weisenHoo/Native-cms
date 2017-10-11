<?php
/*
 * 生成编译文件
 * 
 * */
 
function runtime(){
	$files = require_once PHP_PATH.'/common/files.php';
	foreach($files as $v){
		if(is_file($v)){
			require $v;
		}		
	}
	mkdirs();
	//框架常规配置项
	C(require PHP_PATH.'/libs/etc/init.config.php');
	$data = '';
	foreach($files as $v){
		$data.=del_space($v);
	}
	$data = "<?php".$data."C(require PHP_PATH.'/libs/etc/init.config.php');"."?>";
	file_put_contents(TEMP_PATH.'/runtime.php', $data);//将一个字符串写入文件
	index_control();
}
//测试页面
function index_control(){
	$index_dir = MODULE_PATH.'/index';
	$index_file = $index_dir.'/index'.C("CONTROL_FIX").C("CLASS_FIX").'.php';
	if(!is_dir($index_dir)){
		mkdir($index_dir, 0777);
	}
	if(!is_file($index_file)){
		$data = <<<str
<?php
class indexControl extends Control{
	function index(){
		echo "<div style='width: 350px;line-height: 60px;border: 2px solid #dcdcdc;padding: 20px;'>
			<h1 style='text-align: center;color: #f00;font-size: 18px;'>欢迎使用后盾网学习框架HDPHP</h1>					
		</div>";
	}
}
?>
str;
		file_put_contents($index_file, $data);
	}
}
//创建环境目录
function mkdirs(){
	//判断目录是否存在
	if(!is_dir(TEMP_PATH)){
		@mkdir(TEMP_PATH, 0777);
	}
	//检测目录是否有写的权限
	if(!is_writable(TEMP_PATH)){
		error("目录没有写的权限，程序无法运行");
	}
	if(!is_dir(CACHE_PATH)) mkdir(CACHE_PATH, 0777);
	if(!is_dir(LOG_PATH)) mkdir(LOG_PATH, 0777);
	if(!is_dir(CONFIG_PATH)) mkdir(CONFIG_PATH, 0777);
	if(!is_dir(TEMPLETE_PATH)) mkdir(TEMPLETE_PATH, 0777);
	if(!is_dir(TPL_PATH)) mkdir(TPL_PATH, 0777);
	if(!is_dir(MODULE_PATH)) mkdir(MODULE_PATH, 0777);
	if(!is_dir(UPLOAD_PATH)) mkdir(UPLOAD_PATH, 0777);
}




















?>