<?php
/*
 * 数据库处理类
 * 
 * 增、删、改、查
 * */


class db{
	//数据库连接
	protected $mysqli;
	//表名
	protected $table;
	//选项
	protected $opt;
	
	/*
	 * 构造方法
	 * @param 表名
	 * 
	 * */
	function __construct($tab_name){
		$this->config($tab_name);
	}
	
	/*
	 * 配置方法
	 * 
	 * */
	protected function config($tab_name){
		$this->db = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
		$this->table = DBFIX.$tab_name;
		if(mysqli_connect_errno()){
			echo "数据库连接错误".mysqli_connect_errno();
			exit();
		}
		$this->db->query("SET NAMES 'GBK'");
		$this->opt['field'] = "*";
		$this->opt['where'] = $this->opt['order'] = $this->opt['limit'] = $this->opt['group'] = '';
	}
	
	/*
	 * 获得表字段
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
	 * 获得查询字段
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
	 * SQL条件方法
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
	 * 排序ORDER
	 * 
	 * */
	function order($order){
		$this->opt['order'] = is_string($order)?"ORDER BY ".$order:'';
		return $this;
	}
	
	/*
	 * 分组GROUP BY
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
	 * DELETE语句
	 * 
	 * */
	function delete($id=''){
		if($id=='' && empty($this->opt['where'])) die("查询条件不能为空");
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
	 * 查找单条记录
	 * 
	 * */
	function find($id){
		$sql = "SELECT {$this->opt['field']} FROM {$this->table} WHERE `id` = {$id}";
		return $this->sql($sql);		
	}
	
	/*
	 * 添加数据
	 * 
	 * */
	function insert($args){
		is_array($args) or die("参数非数组");
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
	 * 更新UPDATE
	 * 
	 * */
	function update($args){
		is_array($args) or die("参数非数组");
		if(empty($this->opt['where'])) die("条件不能为空");
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
	 * 统计所有记录数
	 * 
	 * */
	function count($tablename=''){
		$tablename = $tablename==''?$this->table:$tablename;
		$sql = "SELECT `id` FROM {$tablename} {$this->opt['where']}";
		return $this->query($sql);
	}
	
	/*
	 * 数据数组转为字符串格式，同时进行转义
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
	 * 发送SQL返回结果集
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
	 * 没有结果集SQL
	 * 
	 * */
	function query($sql){
		$this->db->query($sql) or die($this->dbError());
		return $this->db->affected_rows;
	}
	
	/*
	 * 返回错误
	 * 
	 * */
	 function dbError($id=''){
	 	return $this->db->error;
	 }
}








































?>