<?php
/*
 * �ļ��ϴ���
 * 
 * */

class upload{
	//�ļ��ϴ�����
	private $exts;
	//�ļ��ϴ���С
	public $size;
	//�ļ�����Ŀ¼
	public $path;
	//�ļ��ϴ���
	public $field;
	//������Ϣ
	public $error;
	//�Ƿ�������ͼ
	public $thumb_on;
	//����ͼ����
	public $ghumb;
	//ˮӡ����
	public $waterMark_on;
	//�ϴ��ɹ��ļ���Ϣ
	public $uploadFiles = array();
	
	/*
	 * ���캯��
	 * @param $path			����·��
	 * @param $ext_size		�ļ��������С
	 * @param $thumb		����ͼ����
	 * 
	 * */
	function __construct($path="",$ext_size=array(),$thumb=1,$waterMark=1){
		//ˮӡ����
		$this->waterMark_on = empty($waterMark)?0:1;
		//����ͼ����
		$this->thumb_on = empty($thumb)?0:1;
		
		$this->path = empty($path)?C("UPLOAD_PATH"):$path;
		if(!empty($ext_size) && is_array($ext_size)){
			$this->exts = array_keys($ext_size);//array_keys()���������в��ֵĻ����еļ���
			$this->size = $ext_size;
		}else{
			$this->exts = array_keys(C("UPLOAD_EXT_SIZE"));
			$this->size = C("UPLOAD_EXT_SIZE");
		}
		$this->thumb = $thumb;
	}
	
	//�ļ��ϴ�
	public function upload(){
		if(!$this->checkDir()){
			$this->error = "Ŀ¼".$this->path."����ʧ�ܻ��߲���д";
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
	 * �����ϴ��ļ�
	 * @param Array $file �ϴ��ļ�����
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
			$this->error = "�ϴ��ļ�ʧ��";
			return FALSE;
		}			
		if(!$is_img){
			return array("path"=>$filePath);
		}
		//��ͼ���ļ����д���
		$img = new image();
		//����ͼ����
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
		//ˮӡ����
		if($this->waterMark_on){
			$img->watermark($filePath);
		}
		return array("path"=>$filePath,"thumb"=>$thumbfile);
	}
	
	//Ŀ¼��֤
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
			$this->error = "û���κ��ļ��ϴ�";
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
	 * ��֤�ϴ��ļ�
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
			$this->error = "�Ƿ��ϴ�����";
			return FALSE;
		}
		if(!empty($ext_size) && $file['size']>$ext_size){
			$this->error = "�ļ��ϴ�����";
			return FALSE;
		}
		if(!is_uploaded_file($file['tmp_name'])){
			$this->error = "�Ƿ��ļ�";
			return FALSE;
		}
		return TRUE;
	}
	
	/*
	 * ��ô�������
	 * @param Number $file
	 * 
	 * */
	private function error(){
		switch($type){
			case UPLOAD_ERR_INI_SIZE:
				$this->error = "����PHP.INI�����ļ�ָ����С";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$this->error = "�ϴ��ļ�����HTML��ָ����С";
				break;
			case UPLOAD_ERR_NO_FILE:
				$this->error = "û���ϴ��κ��ļ�";
				break;
			case UPLOAD_ERR_PARTIAL:
				$this->error = "�ļ�ֻ�ϴ�һ����";
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$this->error = "û���ϴ���ʱĿ¼";
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$this->error = "����д����ʱ�ϴ��ļ�";
				break;
		}
	}
	
	//��ȡ������Ϣ
	public function geterror(){
		return $this->error;
	}
}




















?>