<?php
/*
 * ��֤�룺����
 * 
 * 1�������������  �߶�  ������ɫ
 * 2��������֤�룺32dskjdskjs  ��֤�볤��
 * 3��д��֤����֣����ִ�С  ����  ������ɫ
 * 4��������֤��
 * 5�����ߣ���㻮��  ��  ֱ��  ����  Բ
 * 6����ʾ��֤�룺���  gif jpeg png
 * 
 * �������ԣ�ͼƬ��Դ
 * 
 * */

class code{
	//��Դ
	private $img;
	//�������
	public $width;
	//�����߶�
	public $height;
	//������ɫ
	public $bg_color;
	//��֤��
	public $code;
	//��֤����������
	public $code_str;
	//��֤�볤��
	public $code_len;
	//��֤������
	public $font;
	//��֤�������С
	public $font_size;
	//��֤��������ɫ
	public $font_color;
	
	/*
	 * ���캯��
	 * */
	public function __construct(){
		$this->code_str = C("CODE_STR");
		$this->font = C("FONT");
		$this->width = C("CODE_WIDTH");
		$this->height = C("CODE_HEIGHT");
		$this->bg_color = C("CODE_BG_COLOR");
		$this->code_len = C("CODE_LEN");
		$this->font_size = C("CODE_FONT_SIZE");
		$this->font_color = C("CODE_FONT_COLOR");
		$this->create();
	}
	
	/*
	 * ������֤��
	 * */
	private function create_code(){
		$code = '';
		for($i=0;$i<$this->code_len;$i++){
			$code.=$this->code_str[mt_rand(0, strlen($this->code_str)-1)];
		}
		$this->code = strtoupper($code);
		$_SESSION[C("CODE")] = $this->code;
	}
	
	/*
	 * ������֤��
	 * */
	public function getstr(){
		return $this->code;
	}
	
	/*
	 * ������
	 * */
	public function create(){
		$w = $this->width;
		$h = $this->height;
		$bg_color = $this->bg_color;
		if(!$this->checkgd()) return FALSE;
		$img = imagecreatetruecolor($w, $h);
		$bg_color = imagecolorallocate($img, hexdec(substr($bg_color, 1, 2)), hexdec(substr($bg_color, 3, 2)), hexdec(substr($bg_color, 5, 2)));
		imagefill($img, 0, 0, $bg_color);
		$this->img = $img;
		$this->create_font();
		$this->create_pix();		
	}
	
	/*
	 * д����֤������
	 * */
	private function create_font(){
		$this->create_code();
		$color = $this->font_color;
		$font_color = imagecolorallocate($this->img, hexdec(substr($color, 1, 2)), hexdec(substr($color, 3, 2)), hexdec(substr($color, 5, 2)));
		$x = $this->width/$this->code_len;
		for($i=0;$i<$this->code_len;$i++){
			if(empty($color)){
				$font_color = imagecolorallocate($this->img, mt_rand(50, 155), mt_rand(50, 155), mt_rand(50, 155));
			}
			imagettftext($this->img, $this->font_size, mt_rand(-30, 30), $x*$i+mt_rand(3, 6), mt_rand($this->height/1.2, $this->height-5), $font_color, $this->font, $this->code[$i]);
		}
	}
	
	/*
	 * ����
	 * */
	private function create_pix(){
		$pix_color = imagecolorallocate($this->img, hexdec(substr($this->font_color, 1,2)), hexdec(substr($this->font_color, 3,2)), hexdec(substr($this->font_color, 5,2)));
		for($i=0;$i<100;$i++){
			imagesetpixel($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), $pix_color);
		}
		for($i=0;$i<2;$i++){
			imagesetthickness($this->img, mt_rand(1, 2));
			imageline($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $pix_color);
		}
		
	}
	
	/*
	 * ��ʾ��֤��
	 * */
	public function getimage(){
		header("content-type:image/png");
		imagepng($this->img);
		imagedestroy($this->img);
	}
	
	/*
	 * ��֤GD���Ƿ��imagepng�����Ƿ����
	 * */	
	private function checkgd(){
		return extension_loaded('gd')&&function_exists("imagepng");
	}
}












?>