<?php
/*
 * ��ҳ������
 * 
 * */


class page{
	private $total_rows;//�ܼ�¼��
	private $total_page;//��ҳ��
	private $onepage_rows;//ÿҳ��ʾ����
	private $self_page;//��ǰҳ
	private $url;//URL��ַ
	private $page_rows;//ҳ������
	private $start_id;//��ǰҳ��ʼID
	private $end_id;//��ǰҳ����ID
	private $desc = array();
	
	//��ʼ������
	function __construct($total,$row=10,$page_rows=8,$desc=''){
		$this->total_rows = $total;
		$this->onepage_rows = $row;
		$this->page_rows = $page_rows;
		$this->desc = $desc;
		$this->total_page = ceil($this->total_rows/$this->onepage_rows);//��ҳ��
		$this->self_page = min($this->total_page,max((int)@$_GET['page'],1));//��ǰҳ
		$this->start_id = ($this->self_page-1)*$this->onepage_rows+1;//��ʼID
		$this->end_id = min($this->total_rows,$this->self_page*$this->onepage_rows);//����ID
		$this->url = $this->requestUrl();//����URL��ַ
		$this->desc = $this->desc($desc);//��ҳ��������
	}
	
	//����URL��ַ
	private function requestUrl(){
		//�õ�URL��ַ
		$url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING'];
		//����URL��ַ����������
		$request_Arr = parse_url($url);
		if(isset($request_Arr['query'])){
			//�����������
			parse_str($request_Arr['query'],$arr);
			//ɾ�������еĲ���
			unset($arr['page']);
			//�ϲ�·�����������Ϊ��׼��URL��ַ
			$url = $request_Arr['path']."?".http_build_query($arr)."&page=";
		}else{
			//û���������GET�������
			$url = strstr($url, "?")?$url."page=":$url."?page=";
		}
		return $url;
	}
	
	/*
	 * ���÷�ҳ������������
	 * "pre"=>"��һҳ"
	 * "next"=>"��һҳ"
	 * "first"=>"��ҳ"
	 * "end"=>"ĩҳ"
	 * "unit"=>"��"
	 * 
	 * */
	private function desc($desc){
		//Ĭ����������
		$d = array(
			"pre"=>"��һҳ",
			"next"=>"��һҳ",
			"first"=>"��ҳ",
			"end"=>"ĩҳ",
			"unit"=>"��",
		);
		if(empty($desc) || !is_array($desc)){
			return $d;
		}
		function filter($v){
			return !empty($v);
		}
		return array_merge($d, array_filter($desc, "filter"));
	}
	
	//SQL��limit���
	public function limit(){
		return "LIMIT ".max(0, ($this->self_page-1)*$this->onepage_rows).",".$this->onepage_rows;
	}
	
	//��һҳ
	public function pre(){
		return $this->self_page>1?"<a href='{$this->url}".($this->self_page-1)."'>{$this->desc['pre']}</a>":'';
	}
	
	//����һҳ
	public function next(){
		return $this->self_page<$this->total_page?"<a href='{$this->url}".($this->self_page+1)."'>{$this->desc['next']}</a>":'';
	}
	
	//��ҳ
	public function first(){
		return $this->self_page>1?"<a href='{$this->url}1'>{$this->desc['first']}</a>":'';
	}
	
	//ĩҳ
	public function end(){
		return $this->self_page<$this->total_page?"<a href='{$this->url}{$this->total_page}'>{$this->desc['end']}</a>":'';
	}
	
	//��ǰҳ�ļ�¼
	public function nowpage(){
		return "��".$this->start_id.$this->desc['unit']."-".$this->end_id.$this->desc['unit'];
	}
	
	//���ص�ǰҳҳ��
	public function selfnum(){
		return $this->self_page;
	}
	
	//count ͳ��������Ϣ
	public function count(){
		return "<span>��ҳ:{$this->total_page}ҳ&nbsp;&nbsp;&nbsp;&nbsp;�ܼ�:{$this->total_rows}��</span>";
	}
	
	//ǰ��ҳ
	public function pres(){
		$num = $this->self_page-$this->page_rows;
		return $this->self_page>$this->page_rows?"<a href='{$this->url}{$num}'>ǰ{$this->page_rows}ҳ</a>":'';
	}
	
	//��ҳ
	public function nexts(){
		$num = $this->self_page+$this->page_rows;
		return $this->self_page<$this->total_page-$this->page_rows?"<a href='{$this->url}{$num}'>��{$this->page_rows}ҳ</a>":'';
	}
	
	//���ҳ������
	private function pagelist(){
		$pagelist = array();
		$start = max(1, min($this->self_page-ceil($this->page_rows/2), $this->total_page-ceil($this->page_rows)));
		$end = min($this->total_page, $start+$this->page_rows);
		for($i=$start;$i<=$end;$i++){
			if($i==$this->self_page){
				$pagelist[$i]['url'] = '';
				$pagelist[$i]['str'] = $i;
				continue;
			}
			$pagelist[$i]['url'] = $this->url.$i;
			$pagelist[$i]['str'] = $i;
		}
		
		/*for($i=0;$i<=$this->total_page;$i++){
			if($i==$this->self_page){
				$pagelist.="<strong>{$i}</strong>";
				continue;
			}
			$pagelist.="<a href='{$this->url}{$i}'>{$i}</a>";
		}*/
		return $pagelist;
	}
	
	//�ַ�����ʾ��ҳ���б�
	public function strlist(){
		$arr = $this->pagelist();
		$pagelist = '';
		foreach($arr as $v){
			$pagelist.=empty($v['url'])?"<strong>{$v['str']}</strong>":"<a href='{$v['url']}'>{$v['str']}</a>";
		}
		return $pagelist;
	}
	
	//�����б��ҳ
	public function select(){
		$str = "<select class='pageselect' onchange='javascript:location.href = this.options[selectedIndex].value'>";
		for($i=1;$i<=$this->total_page;$i++){
			if($i==$this->self_page){
				$str.="<option value='{$this->url}{$i}' selected='selected'>{$i}</option>";
				continue;
			}
			$str.="<option value='{$this->url}{$i}'>{$i}</option>";
		}
		$str.="</select>";
		
		/*$arr = $this->pagelist();
		$str = "<select class='pageselect' onchange='javascript:location.href = this.options[selectedIndex].value'>";
		foreach($arr as $v){
			$str.=empty($v['url'])?"<option value='{$this->url}{$v['str']}' selected='selected'>{$v['str']}</option>":"<option value='{$v['url']}'>{$v['str']}</option>";
		}
		$str.="</select>";*/
		return $str;
	}
	
	//ֱ������ҳ�������ת
	public function input(){
		$str = "<input type='text' value='{$this->self_page}' id='pageinput' class='pageinput' onkeydown=\"javascript:
					if(event.keyCode==13) location.href = '{$this->url}'+this.value;\" />
				<button onclick=\"javascript:
					var url = document.getElementById('pageinput').value;
					location.href = '{$this->url}'+url;
		\">��ת</button>";
		return $str;
	}
	
	//
	public function show($style_id){
		switch($style_id){
			case 1:
				return $this->pre().$this->strlist().$this->next();
			case 2:
				return$this->pre().$this->strlist().$this->next().$this->count();
			case 3:
				return $this->pres().$this->select().$this->nexts();
			case 3:
				return $this->pres().$this->first().$this->pre().$this->strlist().$this->next().$this->end().$this->nexts()."&nbsp;&nbsp;".$this->count()."&nbsp;&nbsp;��ǰҳ��".$this->nowpage().$this->select().$this->input();
		}
	}
}










































?>