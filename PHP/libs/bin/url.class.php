<?php
/*
 * ·����������
 * 
 * */

final class url{
	//����PATHINFO��Ϣ
	static $pathinfo;
	
	//����URL
	static function parseUrl(){
		if(self::Pathinfo()!=FALSE){
			$info = explode(C("PATHINFO_DLI"), self::$pathinfo);
			if($info[0]!=C("VAR_MODULE")){
				$get['m'] = $info[0];
				array_shift($info);//�����鿪ͷ�ĵ�Ԫ�Ƴ����� 
				$get['c'] = $info[0];
				array_shift($info);
				$get['a'] = $info[0];
				array_shift($info);
			}
			$count = count($info);
			for($i=0;$i<$count;$i+=2){
				$get[$info[$i]] = $info[$i+1];
			}
			$_GET = $get;
		}
		
		//  http://localhost/blog/index.php/m/shop/c/channel/a/add
		//  http://localhost/blog/index.php/shop/channel/add
		//  http://localhost/blog/index.php?q=shop/channel/add
		//  http://localhost/blog/index.php?m=shop&c=channel&a=add
		
		define("MODULE", isset($_GET['m'])?$_GET['m']:C("DEFAULT_MODULE"));
		define("CONTROL", isset($_GET['c'])?$_GET['c']:C("DEFAULT_CONTROL"));
		define("ACTION", isset($_GET['a'])?$_GET['a']:C("DEFAULT_ACTION"));
	}
	
	//����PATHINFO
	static function Pathinfo(){
		//���PATHINFO����
		if(!empty($_GET[C("PATHINFO_VAR")])){
			$pathinfo = $_GET[C("PATHINFO_VAR")];
		}elseif(!empty($_SERVER["PATH_INFO"])){
			$pathinfo = $_SERVER["PATH_INFO"];
		}else{
			return FALSE;
		}
		$pathinfo_html = ".".trim(C("PATHINFO_HTML"), ".");//ȥ���ַ�����β���Ŀհ��ַ������������ַ���
		$pathinfo = str_ireplace($pathinfo_html, "", $pathinfo);
		$pathinfo = trim($pathinfo, "/");
		if(stripos($pathinfo, C("PATHINFO_DLI"))==FALSE){
			return FALSE;
		}
		self::$pathinfo = $pathinfo;
		return TRUE;
	}
}


















?>