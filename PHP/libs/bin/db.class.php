<?php
/*
 * ���ݿ⴦����
 * 
 * ����ɾ���ġ���
 * */


class db{
	//���ݿ�����
	protected $mysqli;
	//����
	protected $table;
	//ѡ��
	protected $opt;
	
	/*
	 * ���췽��
	 * @param ����
	 * 
	 * */
	function __construct($tab_name){
		$this->config($tab_name);
	}
	
	/*
	 * ���÷���
	 * 
	 * */
	protected function config($tab_name){
		$this->db = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
		$this->table = DBFIX.$tab_name;
		if(mysqli_connect_errno()){
			echo "���ݿ����Ӵ���".mysqli_connect_errno();
			exit();
		}
		$this->db->query("SET NAMES 'GBK'");
		$this->opt['field'] = "*";
		$this->opt['where'] = $this->opt['order'] = $this->opt['limit'] = $this->opt['group'] = '';
	}
	
	/*
	 * ��ñ��ֶ�
	 * 
	 * */
	function tbFields(){
		$result = $this->db->query("DESC {$this->table}");
		$fieldArr = array();
		while(($row = $result->fetch_assoc()) != FALSE){
			$fieldArr[] = $row['Field'];
		}
		return $fieldArr;
	}
	
	/*
	 * ��ò�ѯ�ֶ�
	 * 
	 * */
	function field($field){
		$fieldArr = is_string($field)?explode(",", $field):$field;
		if(is_array($fieldArr)){
			$field = '';
			foreach($fieldArr as $v){
				$field.="`".$v."`".",";
			}
		}
		return rtrim($field,',');
	}
	
	/*
	 * SQL��������
	 * 
	 * */
	function where($where){
		$this->opt['where'] = is_string($where)?"WHERE ".$where:'';
		return $this;
	}
	
	/*
	 * LIMIT
	 * 
	 * */
	function limit($limit){
		$this->opt['limit'] = is_string($limit)?"LIMIT ".$limit:'';
		return $this;
	}
	
	/*
	 * ����ORDER
	 * 
	 * */
	function order($order){
		$this->opt['order'] = is_string($order)?"ORDER BY ".$order:'';
		return $this;
	}
	
	/*
	 * ����GROUP BY
	 * 
	 * */
	function group($group){
		$this->opt = is_string($group)?"GROUP BY ".$group:'';
		return $this;
	}
	
	/*
	 * SELECT
	 * 
	 * */
	function select(){
		$sql = "SELECT {$this->opt['field']} FROM {$this->table} {$this->opt['where']} {$this->opt['group']} {$this->opt['limit']} {$this->opt['order']}";
		return $this->sql($sql);
	}
	
	/*
	 * DELETE���
	 * 
	 * */
	function delete($id=''){
		if($id=='' && empty($this->opt['where'])) die("��ѯ��������Ϊ��");
		if($id!=''){
			if(is_array($id)){
				$id = implode(",", $id);				
			}
			$this->opt['where'] = "WHERE id IN (".$id.")";
		}	
		$sql = "DELETE FROM {$this->table} {$this->opt['where']} {$this->opt['limit']}";
		return $this->query($sql);
	}
	
	/*
	 * ���ҵ�����¼
	 * 
	 * */
	function find($id){
		$sql = "SELECT {$this->opt['field']} FROM {$this->table} WHERE `id` = {$id}";
		return $this->sql($sql);		
	}
	
	/*
	 * �������
	 * 
	 * */
	function insert($args){
		is_array($args) or die("����������");
		$fields = $this->field(array_keys($args));
		var_dump($fields);
		$values = $this->values(array_values($args));
		$sql = "INSERT INTO {$this->table}({$fields}) VALUES({$values})";
		if($this->query($sql)>0){
			return $this->db->insert_id;
		}
		return FALSE;
	}
	
	/*
	 * ����UPDATE
	 * 
	 * */
	function update($args){
		is_array($args) or die("����������");
		if(empty($this->opt['where'])) die("��������Ϊ��");
		$set = '';
		$gpc = get_magic_quotes_gpc();
		while(list($k,$v) = each($args)){
			$v = !$gpc?addslashes($v):$v;
			$set.="`{$k}`='".$v."',";
		}
		$set = rtrim($set,',');
		$sql = "UPDATE {$this->table} SET {$set} {$this->opt['where']}";
		return $this->query($sql);
	}
	
	/*
	 * ͳ�����м�¼��
	 * 
	 * */
	function count($tablename=''){
		$tablename = $tablename==''?$this->table:$tablename;
		$sql = "SELECT `id` FROM {$tablename} {$this->opt['where']}";
		return $this->query($sql);
	}
	
	/*
	 * ��������תΪ�ַ�����ʽ��ͬʱ����ת��
	 * 
	 * */
	protected function values($value){
		$strValue = '';
		if(!get_magic_quotes_gpc()){			
			foreach($value as $v){
				$strValue.="'".addslashes($v)."',";
			}
		}else{
			foreach($value as $v){
				$strValue.="'".$v."',";
			}	
		}
		return rtrim($strValue,',');
	}
	
	/*
	 * ����SQL���ؽ����
	 * 
	 * */
	function sql($sql){
		$result = $this->db->query($sql) or die($this->dbError());
		$resultArr = array();
		while(($row = $result->fetch_assoc()) != FALSE){
			$resultArr[] = $row;
		}
		return $resultArr;
	}
	
	/*
	 * û�н����SQL
	 * 
	 * */
	function query($sql){
		$this->db->query($sql) or die($this->dbError());
		return $this->db->affected_rows;
	}
	
	/*
	 * ���ش���
	 * 
	 * */
	 function dbError($id=''){
	 	return $this->db->error;
	 }
}








































?>