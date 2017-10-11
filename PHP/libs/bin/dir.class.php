<?php
/*
 * 文件操作类
 * 
 * */

class dir{
	//转换为标准目录结构
	static function dir_path($dirname){
		$dirname = str_ireplace('\\', '/', $dirname);//子字符串替换忽略大小写
		return substr($dirname, -1)=='/'?$dirname:$dirname.'/';//返回字符串的子串
	}
	
	//获得文件扩展名
	static function get_ext($filename){
		return substr(strrchr($filename, "."), 1);
	}
	
	//获得目录内容
	static function tree($dirname,$exts='',$son=0,$list=array()){
		$dirname = self::dir_path($dirname);
		if(is_array($exts)){
			$exts = implode("|", $exts);
		}
		static $id=0;
		foreach(glob($dirname."*") as $v){//glob()寻找与模式匹配的文件路径
			$id++;
			if(!$exts || preg_match("/\.($exts)/i", $v)){
				$list[$id]['name'] = basename($v);//basename()返回路径中的文件名部分
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
	
	//只获得目录结构
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
	
	//删除目录
	static function del($dirname){
		$dirPath = self::dir_path($dirname);
		if(!is_dir($dirPath)) return FALSE;
		foreach(glob($dirPath."*") as $v){
			is_dir($v)?self::del($v):unlink($v);//删除文件
		}
		rmdir($dirPath);//删除目录
	}
	
	//支持层级的目录结构创建
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
	
	//复制目录内容
	static function copy($oldDir,$newDir){
		$oldDir = self::dir_path($oldDir);
		$newDir = self::dir_path($newDir);
		if(!is_dir($oldDir)) error("复制失败：".$oldDir."目录不存在");
		if(!is_dir($newDir)) self::create($newDir);
		foreach(glob($oldDir."*") as $v){
			$toFile = $newDir.basename($v);
			if(is_file($toFile)) continue;
			if(is_dir($v)){
				self::copy($v, $toFile);
			}else{
				copy($v, $toFile);
				chmod($toFile, "0777");//改变文件模式
			}
		}
		return TRUE;
	}
}





















?>