<?php
/*
 * �ļ�������
 * 
 * */

class dir{
	//ת��Ϊ��׼Ŀ¼�ṹ
	static function dir_path($dirname){
		$dirname = str_ireplace('\\', '/', $dirname);//���ַ����滻���Դ�Сд
		return substr($dirname, -1)=='/'?$dirname:$dirname.'/';//�����ַ������Ӵ�
	}
	
	//����ļ���չ��
	static function get_ext($filename){
		return substr(strrchr($filename, "."), 1);
	}
	
	//���Ŀ¼����
	static function tree($dirname,$exts='',$son=0,$list=array()){
		$dirname = self::dir_path($dirname);
		if(is_array($exts)){
			$exts = implode("|", $exts);
		}
		static $id=0;
		foreach(glob($dirname."*") as $v){//glob()Ѱ����ģʽƥ����ļ�·��
			$id++;
			if(!$exts || preg_match("/\.($exts)/i", $v)){
				$list[$id]['name'] = basename($v);//basename()����·���е��ļ�������
				$list[$id]['path'] = realpath($v);
				$list[$id]['type'] = filetype($v);
				$list[$id]['ctime'] = filectime($v);
				$list[$id]['atime'] = fileatime($v);
				$list[$id]['filesize'] = filesize($v);
				$list[$id]['iswrite'] = is_writable($v);
				$list[$id]['isread'] = is_readable($v);
			}
			if($son){
				if(is_dir($v)){
					$list = self::tree($v, $exts, $son, $list);
				}
			}
		}
		return $list;
	}
	
	//ֻ���Ŀ¼�ṹ
	static function tree_dir($dirname,$pid=0,$son,$list=array()){
		$dirname = self::dir_path($dirname);
		static $id = 0;
		foreach(glob($dirname."*") as $v){
			if(is_dir($v)){
				$id++;
				$list[$id]['id'] = $id;
				$list[$id]['pid'] = $pid;
				$list[$id]['name'] = basename($v);
				$list[$id]['path'] = realpath($v);
				if($son){
					$list = self::tree($v,$id,$son,$list);
				}
			}
		}
		return $list;
	}
	
	//ɾ��Ŀ¼
	static function del($dirname){
		$dirPath = self::dir_path($dirname);
		if(!is_dir($dirPath)) return FALSE;
		foreach(glob($dirPath."*") as $v){
			is_dir($v)?self::del($v):unlink($v);//ɾ���ļ�
		}
		rmdir($dirPath);//ɾ��Ŀ¼
	}
	
	//֧�ֲ㼶��Ŀ¼�ṹ����
	static function create($dirname,$auth="0777"){
		$dirPath = self::dir_path($dirname);
		if(is_dir($dirPath)) return TRUE;
		$dirArr = explode("/", $dirPath);
		$dir = '';
		foreach($dirArr as $v){
			$dir.=$v.'/';
			if(is_dir($dir)) continue;
			mkdir($dir,$auth);
		}
		return is_dir($dirPath);
	}
	
	//����Ŀ¼����
	static function copy($oldDir,$newDir){
		$oldDir = self::dir_path($oldDir);
		$newDir = self::dir_path($newDir);
		if(!is_dir($oldDir)) error("����ʧ�ܣ�".$oldDir."Ŀ¼������");
		if(!is_dir($newDir)) self::create($newDir);
		foreach(glob($oldDir."*") as $v){
			$toFile = $newDir.basename($v);
			if(is_file($toFile)) continue;
			if(is_dir($v)){
				self::copy($v, $toFile);
			}else{
				copy($v, $toFile);
				chmod($toFile, "0777");//�ı��ļ�ģʽ
			}
		}
		return TRUE;
	}
}





















?>