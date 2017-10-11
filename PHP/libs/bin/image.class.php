<?php
/*
 * ͼ������
 * 
 * */

class image{
	//�Ƿ�Ӧ��ˮӡ
	private $water_on;
	//ˮӡͼƬ
	public $water_img;
	//ˮӡ��λ��
	public $water_pos;
	//ˮӡ��͸����
	public $water_pct;
	//ͼ���ѹ����
	public $water_quality;
	
	//ˮӡ��������
	public $water_text;
	//ˮӡ���ִ�С
	public $water_text_size;
	//ˮӡ������ɫ
	public $water_text_color;
	//ˮӡ��������
	public $water_text_font;
	
	//�Ƿ�������ͼ����
	private $thumb_on;
	//��������ͼ�ķ�ʽ
	public $thumb_type;
	//����ͼ�Ŀ��
	public $thumb_width;
	//����ͼ�ĸ߶�
	public $thumb_height;
	//��������ͼ�ļ���ǰ׺
	public $thumb_prefix;
	//��������ͼ�ļ�����׺
	public $thumb_endfix;
	
	/*
	 * ���캯��
	 * */
	function __construct(){
		//ˮӡ����
		$this->water_on = C("WATER_ON");
		$this->water_img = (C("WATER_TYPE")==1)?C("WATER_IMG"):'';
		$this->water_pct = C("WATER_PCT");
		$this->water_quality = C("WATER_QUALITY");
		$this->water_pos = C("WATER_POS");
		$this->water_text = C("WATER_TEXT");
		$this->water_text_color = C("WATER_TEXT_COLOR");
		$this->water_text_size = C("WATER_TEXT_SIZE");
		$this->water_text_font = C("FONT");
		
		//����ͼ����
		$this->thumb_on = C("THUMB_ON");
		$this->thumb_type = C("THUMB_TYPE");
		$this->thumb_width = C("THUMB_WIDTH");
		$this->thumb_height = C("THUMB_HEIGHT");
		$this->thumb_prefix = C("THUMB_PREFIX");
		$this->thumb_endfix = C("THUMB_ENDFIX");
	}
	
	/*
	 * ������֤
	 * @param $img   ͼƬ·��
	 * */
	private function check($img){
		$type = array(".jpg",".jpeg",".png",".gif");
		$img_type = strtolower(strrchr($img, '.'));
		
		return extension_loaded('gd') && file_exists($img) && in_array($img_type, $type);
	}
	
	/*
	 * ˮӡ����
	 * @param $img_w	ԭͼ���
	 * @param $img_h	ԭͼ�߶�
	 * @param $w_w		����ͼ���
	 * @param $w_h		����ͼ�߶�
	 * 
	 * */
	private function thumb_size($img_w,$img_h,$t_w,$t_h,$t_type){
		//��ʼ������ͼ
		$w = $t_w;
		$h = $t_h;
		//��ʼ��ԭͼ�ߴ�
		$cut_w = $img_w;
		$cut_h = $img_h;
		
		if($img_w<=$t_w && $img_h<=$t_h){
			$w = $img_w;
			$h = $img_h;
		}elseif(!empty($t_type) && $t_type>0){
			switch($t_type){
				case 1:
					//�̶���� �߶�����
					$h = $t_w/$img_w*$img_h;
					break;
				case 2:
					//�̶��߶� �������
					$w = $t_h/$img_h*$img_w;
					break;
				case 3:
					//�̶���� �߶Ȳ���
					$cut_h = $img_w/$t_w*$t_h;
					break;
				case 4:
					//�̶��߶� ��Ȳ���
					$cut_w = $img_h/$t_h*$t_w;
					break;
				default:
					//��������
					if(($img_w/$t_w)>($img_h/$t_h)){
						$h = $t_w/$img_w*$img_h;
					}elseif(($img_h/$t_h)>($img_w/$t_w)){
						$w = $t_h/$img_h*$img_w;
					}else{
						$w = $t_w;
						$h = $t_h;
					}				
			}
		}
		
		$arr[0] = $w;
		$arr[1] = $h;
		$arr[2] = $cut_w;
		$arr[3] = $cut_h;
		return $arr;
	}
	
	/*
	 * ˮӡ����
	 * @param $img			������ͼƬ·��
	 * @param $outfile		������ļ�·��
	 * @param $t_type		����ͼƬ�ķ�ʽ
	 * @param $t_w			����ͼ���
	 * @param $t_h			����ͼ�߶�
	 * @param $string		�������ļ���
	 * 
	 * */
	public function thumb($img,$outfile='',$t_type='',$t_w='',$t_h=''){
		if(!$this->thumb_on || !$this->check($img)) return FALSE;
		//��������
		$t_type = $t_type?$t_type:$this->thumb_type;
		$t_w = $t_w?$t_w:$this->thumb_width;
		$t_h = $t_h?$t_h:$this->thumb_height;
		//���ͼ����Ϣ
		$img_info = getimagesize($img);
		$img_w = $img_info[0];
		$img_h = $img_info[1];
		$img_type = image_type_to_extension($img_info[2]);
		//�����سߴ�
		$thumb_size = $this->thumb_size($img_w,$img_h,$t_w,$t_h,$t_type);
		//ԭʼͼ����Դ
		$func = "imagecreatefrom".substr($img_type, 1);
		$res_img = $func($img);
		//����ͼ����Դ
		if($img_type=='.gif' || $img_type=='.png'){
			$res_thumb = imagecreate($thumb_size[0], $thumb_size[1]);
			$color = imagecolorallocate($res_thumb, 255, 0, 0);
		}else{
			$res_thumb = imagecreatetruecolor($thumb_size[0], $thumb_size[1]);
		}
		//��������ͼ
		if(!function_exists("imagecopyresampled")){
			imagecopyresampled($res_thumb, $res_img, 0, 0, 0, 0, $thumb_size[0], $thumb_size[1], $thumb_size[2], $thumb_size[3]);
		}else{
			imagecopyresized($res_thumb, $res_img, 0, 0, 0, 0, $thumb_size[0], $thumb_size[1], $thumb_size[2], $thumb_size[3]);
		}
		//����͸��ɫ
		if($img_type=='.gif' || $img_type=='png'){
			imagecolortransparent($res_thumb,$color);
		}
		//��������ļ���
		$thumbPath = C("THUMB_PATH");	
		dir::create($thumbPath);
		$info = pathinfo($img);
		$outfile = $outfile?$outfile:$this->thumb_prefix.$info['filename'].$this->thumb_endfix.".".$info['extension'];
		$outfile = $thumbPath.'/'.$outfile;
		$func = "image".substr($img_type, 1);
		$func($res_thumb, $outfile);
		if(isset($res_thumb)) imagedestroy($res_thumb);
		if(isset($res_img)) imagedestroy($res_img);
		return $outfile;
	}
	
	/*
	 * ˮӡ����
	 * @param $img			������ͼ��
	 * @param $out_img		����ͼ��
	 * @param $water_img	ˮӡͼƬ
	 * @param $pos			ˮӡλ��
	 * @param $text			����ˮӡ����
	 * @param $pct			͸����
	 * @return boolen
	 * */
	public function watermark($img,$out_img='',$water_img='',$pos='',$text="",$pct=''){
		//��֤ԭͼ��
		if(!$this->check($img) || !$this->water_on) return FALSE;
		//��֤ˮӡͼ��
		$water_img = $water_img?$water_img:$this->water_img;
		$waterimg_on = $this->check($water_img)?1:0;
		//�ж����ͼ��
		$out_img = $out_img?$out_img:$img;
		//ˮӡλ��
		$pos = $pos?$pos:$this->water_pos;
		//ˮӡ����
		$text = $text?$text:$this->water_text;
		$text = iconv("gbk", "utf-8", $text);
		//ˮӡ͸����
		$pct = $pct?$pct:$this->water_pct;
		
		$img_info = getimagesize($img);
		$img_w = $img_info[0];
		$img_h = $img_info[1];
		//���ˮӡ��Ϣ
		if($waterimg_on){
			$w_info = getimagesize($water_img);
			$w_w = $w_info[0];
			$w_h = $w_info[1];
			switch($w_info[2]){
				case 1:
					$w_img = imagecreatefromgif($water_img);
					break;
				case 2:
					$w_img = imagecreatefromjpeg($water_img);
					break;
				case 3:
					$w_img = imagecreatefrompng($water_img);
					break;
			}
		}else{
			if(empty($text) || strlen($this->water_text_color)!=7) return FALSE;
			$text_info = imagettfbbox($this->water_text_size, 0, $this->water_text_font, $text);
			$w_w = $text_info[2]-$text_info[6];
			$w_h = $text_info[3]-$text_info[7];
		}
		
		//����ԭͼ��Դ
		if($img_h<$w_h || $img_w<$w_h) return FALSE;
		switch($img_info[2]){
			case 1:
				$res_img = imagecreatefromgif($img);
				break;
			case 2:
				$res_img = imagecreatefromjpeg($img);
				break;
			case 3:
				$res_img = imagecreatefrompng($img);
				break;
		}
		
		//ˮӡλ�ô�����
		switch($pos){
			case 1:
				$x = $y = 25;
				break;
			case 2:
				$x = ($img_w-$w_w)/2;
				$y = 25;
				break;
			case 3:
				$x = $img_w-$w_w-25;
				$y = 25;
				break;
			case 4:
				$x = 25;
				$y = ($img_h-$w_h)/2;
				break;
			case 5:
				$x = ($img_w-$w_w)/2;
				$y = ($img_h-$w_h)/2;
				break;
			case 6:
				$x = $img_w-$w_w-25;
				$y = ($img_h-$w_h)/2;
				break;
			case 7:
				$x = 25;
				$y = $img_h-$w_h-25;
				break;
			case 8:
				$x = ($img_w-$w_w)/2;
				$y = $img_h-$w_h-25;
				break;
			case 9:
				$x = $img_w-$w_w-25;
				$y = $img_h-$w_h-25;
				break;
			default:
				$x = mt_rand(25, $img_w-$w_w);
				$y = mt_rand(25, $img_h-$w_h);
		}
		
		if($waterimg_on){
			if($w_info[2]==3){
				imagecopy($res_img, $w_img, $x, $y, 0, 0, $w_w, $w_h);
			}else{
				imagecopymerge($res_img, $w_img, $x, $y, 0, 0, $w_w, $w_h, $pct);
			}			
		}else{
			$r = hexdec(substr($this->water_text_color, 1, 2));
			$g = hexdec(substr($this->water_text_color, 3, 2));
			$b = hexdec(substr($this->water_text_color, 5, 2));
			$color = imagecolorallocate($res_img, $r, $g, $b);
			imagettftext($res_img, $this->water_text_size, 0, $x, $y, $color, $this->water_text_font, $text);
		}
		switch($img_info[2]){
			case 1:
				imagegif($res_img, $out_img);
				break;
			case 2:
				imagejpeg($res_img, $out_img, $this->water_quality);
				break;
			case 3:
				imagepng($res_img, $out_img);
				break;
		}
		if(isset($res_img)) imagedestroy($res_img);
		if(isset($w_img)) imagedestroy($w_img);
		return TRUE;
	}
}
















?>