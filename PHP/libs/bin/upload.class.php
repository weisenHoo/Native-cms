<?php
/*
 * 文件上传类
 * 
 * */

class upload{
	//文件上传类型
	private $exts;
	//文件上传大小
	public $size;
	//文件保存目录
	public $path;
	//文件上传表单
	public $field;
	//错误信息
	public $error;
	//是否开启缩略图
	public $thumb_on;
	//缩略图参数
	public $ghumb;
	//水印处理
	public $waterMark_on;
	//上传成功文件信息
	public $uploadFiles = array();
	
	/*
	 * 构造函数
	 * @param $path			保存路径
	 * @param $ext_size		文件类型与大小
	 * @param $thumb		缩略图参数
	 * 
	 * */
	function __construct($path="",$ext_size=array(),$thumb=1,$waterMark=1){
		//水印配置
		$this->waterMark_on = empty($waterMark)?0:1;
		//缩略图配置
		$this->thumb_on = empty($thumb)?0:1;
		
		$this->path = empty($path)?C("UPLOAD_PATH"):$path;
		if(!empty($ext_size) && is_array($ext_size)){
			$this->exts = array_keys($ext_size);//array_keys()返回数组中部分的或所有的键名
			$this->size = $ext_size;
		}else{
			$this->exts = array_keys(C("UPLOAD_EXT_SIZE"));
			$this->size = C("UPLOAD_EXT_SIZE");
		}
		$this->thumb = $thumb;
	}
	
	//文件上传
	public function upload(){
		if(!$this->checkDir()){
			$this->error = "目录".$this->path."创建失败或者不可写";
			return FALSE;
		}
		$files = $this->format();
		foreach($files as $v){
			$info = pathinfo($v['name']);
			$v['ext'] = $info['extension'];
			$v['filename'] = $info['filename'];
			if(!$this->checkFile($v)){
				continue;
			}
			$uploadFile = $this->save($v);
			if($uploadFile){
				$this->uploadFiles[] = $uploadFile;
			}
		}
	}
	
	/*
	 * 储存上传文件
	 * @param Array $file 上传文件数组
	 * 
	 * */
	private function save($file){
		$is_img = 0;
		$filePath = $this->path.'/'.$file['filename'].time().'.'.$file['ext'];			
		if(in_array($file['ext'],array("jpg","jpeg","gif","bmp","png")) && getimagesize($file['tmp_name'])){
			$filePath = C("UPLOAD_PATH_IMG").'/'.$file['filename'].time().'.'.$file['ext'];
			$is_img = 1;
		}
		if(!move_uploaded_file($file['tmp_name'], $filePath)){
			$this->error = "上传文件失败";
			return FALSE;
		}			
		if(!$is_img){
			return array("path"=>$filePath);
		}
		//对图像文件进行处理
		$img = new image();
		//缩略图处理
		if($this->thumb_on){
			$args = array();
			if(is_array($this->thumb)){
				array_unshift($args, $filePath, "");
				$args = array_merge($args, $this->thumb);
			}else{
				array_unshift($args, $filePath);
			}
			$thumbfile = call_user_func_array(array($img,"thumb"), $args);
		}
		//水印处理
		if($this->waterMark_on){
			$img->watermark($filePath);
		}
		return array("path"=>$filePath,"thumb"=>$thumbfile);
	}
	
	//目录验证
	private function checkDir(){
		$path = $this->path;
		if(!dir::create($path) || !is_writable($path)){
			return FALSE;
		}		
		$img_path = C("UPLOAD_PATH_IMG");
		if(!dir::create($path) || !is_writable($path)){
			return FALSE;
		}
		if(!dir::create($img_path) || !is_writable($img_path)){
			return FALSE;
		}
		return TRUE;
	}
	
	//
	private function format(){
		$files = $_FILES;
		if(!isset($files)){
			$this->error = "没有任何文件上传";
			return FALSE;
		}
		$info = array();
		$n = 0;
		foreach($files as $v){
			if(is_array($v['name'])){
				$count = count($v['name']);
				for($i=0;$i<$count;$i++){
					foreach($v as $m=>$k){
						$info[$n][$m] = $k[$i];
					}
					$n++;
				}
			}else{
				$info[$n] = $v;
				$n++;
			}
		}
		return $info;
	}
	
	/*
	 * 验证上传文件
	 * @param String $file
	 * 
	 * */
	private function checkFile($file){
		if($file['error']!=0){
			$this->error = $this-error($file['error']);
			return FALSE;
		}
		$ext_size = empty($this->size)?C("UPLOAD_EXT_SIZE"):$this->size;
		$ext = strtolower($file['ext']);
		if(!in_array($ext, $this->exts)){
			$this->error = "非法上传类型";
			return FALSE;
		}
		if(!empty($ext_size) && $file['size']>$ext_size){
			$this->error = "文件上传过大";
			return FALSE;
		}
		if(!is_uploaded_file($file['tmp_name'])){
			$this->error = "非法文件";
			return FALSE;
		}
		return TRUE;
	}
	
	/*
	 * 获得错误类型
	 * @param Number $file
	 * 
	 * */
	private function error(){
		switch($type){
			case UPLOAD_ERR_INI_SIZE:
				$this->error = "超过PHP.INI配置文件指定大小";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$this->error = "上传文件超过HTML表单指定大小";
				break;
			case UPLOAD_ERR_NO_FILE:
				$this->error = "没有上传任何文件";
				break;
			case UPLOAD_ERR_PARTIAL:
				$this->error = "文件只上传一部分";
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$this->error = "没有上传临时目录";
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$this->error = "不能写入临时上传文件";
				break;
		}
	}
	
	//获取错误信息
	public function geterror(){
		return $this->error;
	}
}




















?>