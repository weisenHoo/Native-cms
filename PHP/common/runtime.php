<?php
/*
 * ���ɱ����ļ�
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
	//��ܳ���������
	C(require PHP_PATH.'/libs/etc/init.config.php');
	$data = '';
	foreach($files as $v){
		$data.=del_space($v);
	}
	$data = "<?php".$data."C(require PHP_PATH.'/libs/etc/init.config.php');"."?>";
	file_put_contents(TEMP_PATH.'/runtime.php', $data);//��һ���ַ���д���ļ�
	index_control();
}
//����ҳ��
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
			<h1 style='text-align: center;color: #f00;font-size: 18px;'>��ӭʹ�ú����ѧϰ���HDPHP</h1>					
		</div>";
	}
}
?>
str;
		file_put_contents($index_file, $data);
	}
}
//��������Ŀ¼
function mkdirs(){
	//�ж�Ŀ¼�Ƿ����
	if(!is_dir(TEMP_PATH)){
		@mkdir(TEMP_PATH, 0777);
	}
	//���Ŀ¼�Ƿ���д��Ȩ��
	if(!is_writable(TEMP_PATH)){
		error("Ŀ¼û��д��Ȩ�ޣ������޷�����");
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