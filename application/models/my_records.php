<?php
class MY_records extends CI_Model{
	var $fields=array();
	var $table;
	var $site=array('site_id'=>NULL,'title'=>NULL,'url'=>NULL);
	var $records=array();
	
	function __construct(){
		parent::__construct();
		$this->getSite();

	}
	
	function setTable($table){
		if(empty($table)||!is_string($table))
			throw new Exception('No input data', 0);
		$this->table=$table;
	}
	
	function getSite(){
		if($this->session->userdata('site_id')!==false){
			$this->setTable('sites');
			try{
				$this->site=self::get(array('site_id'=>$this->session->userdata('site_id')));
			}catch(Exception $e){
				throw new Exception('Could not get site');
			}
		}else
			$this->site=false;
	}
	
	function get($conditions){
		if(empty($conditions))
			throw new Exception('No input data', 0);
			
		$primary_key=$this->getPrimaryKey();
		if(is_array($conditions)){
			$where=array();
			foreach($conditions as $field=>$value)
				$where[]='`'.$field.'`="'.$value.'"';
			$where=implode(' AND ',$where);
		}elseif(is_numeric($conditions))
			$where='`'.$primary_key.'` = "'.$conditions.'"';
		elseif(is_string($conditions))
			$where=$conditions;
		else throw new Exception('Wrong input data', 8);
		
		$columns=$this->getTableColumns();
		if(in_array('site_id',$columns)&&isset($this->site['site_id']))
			$where.=' AND `site_id`="'.$this->site['site_id'].'"';
		
		$query=$this->db->query('SELECT * FROM `'.$this->table.'` WHERE '.$where);
	
		if ($query->num_rows()==0)
			throw new Exception('Empty result', 1);
		else
			return $query->row_array();
	}
	
	function getList($conditions='',$order=''){
		if(!empty($conditions)){
			if(is_array($conditions)){
				$where=array();
				foreach($conditions as $field=>$value)
					$where[]='`'.$field.'`="'.$value.'"';
				$where=implode(' AND ',$where);
			}elseif(is_string($conditions))
				$where=$conditions;			
		}else $where=1;
		
		$columns=$this->getTableColumns();
		if(in_array('site_id',$columns)&&is_numeric($this->site['site_id']))
			$where.=' AND `site_id`="'.$this->site['site_id'].'"';
		
		
		if(is_string($order)&&$order!='')
			$order='ORDER BY '.$order;
		else
			$order='ORDER BY '.$this->getPrimaryKey().' DESC';		
		
		$query=$this->db->query('SELECT * FROM `'.$this->table.'` WHERE '.$where.' '.$order);
		if ($query->num_rows()==0)
			throw new Exception('Empty result', 1);
		else
			return $query->result_array();		
	}
	
	function getTableColumns(){
		$columns=$this->db->query('SHOW COLUMNS FROM `'.$this->table.'`');
		if($columns->num_rows()==0)
			throw new Exception('Empty result', 1);
		$columns=$columns->result_array();
		$columns_names=array();
		foreach($columns as $column)
			$columns_names[]=$column['Field'];
		return $columns_names;
	}
	
	function getPrimaryKey($table=NULL){
		
		if(is_null($table))
			$table=$this->table;
		$query=$this->db->query('SHOW KEYS FROM `'.$table.'` WHERE Key_name = "PRIMARY"');
		$table=$query->result_array();
		if($this->db->_error_number()!=0)
			throw new Exception('MySQL Error',7);		
		return $table[0]['Column_name'];		
	}
	
	function lastInsertId($table=NULL){
		if(is_null($table))
			return $this->db->last_insert_id();
		$primary_key=$this->getPrimaryKey($table);
		$res=mysql_query('select * FROM '.$table.' ORDER BY '.$primary_key.' DESC LIMIT 1');
		$row=mysql_fetch_row($res);
		return $row[0];
	}
	
	function add($data){
		if(empty($data)||!is_array($data))
			throw new Exception('No input data', 0);

		$primary_key=$this->getPrimaryKey();
		
		$inserts=array();
		foreach($data as $field=>$value){
			if($field!=$primary_key)
				$inserts[]='`'.$field.'` = "'.addslashes($value).'"';
		}
		
		$columns=$this->getTableColumns();
		if(in_array('site_id',$columns)&&is_numeric($this->site['site_id']))
			$inserts[]='`site_id`="'.$this->site['site_id'].'"';
		
		$inserts=implode(', ',$inserts);		
				
		$this->db->query('INSERT INTO `'.$this->table.'` SET '.$inserts);
		if($this->db->_error_number()!=0)
			throw new Exception('MySQL Error',7);

		return true;
	}
		
	function edit($data){
		if(empty($data)||!is_array($data))
			throw new Exception('No input data', 0);
						
		$primary_key=$this->getPrimaryKey();
		
		$updates=array();
		foreach($data as $field=>$value){
			if($field!=$primary_key)
				$updates[]='`'.$field.'` = "'.addslashes($value).'"';
		}
		
		$columns=$this->getTableColumns();
		if(in_array('site_id',$columns)&&is_numeric($this->site['site_id']))
			$updates[]='`site_id`="'.$this->site['site_id'].'"';
		
		
		if(isset($data[$primary_key]))
			$where=$primary_key.' = "'.$data[$primary_key].'"';
		else{
			$where=1;
			$columns=$this->getTableColumns();
			if(in_array('site_id',$columns)&&is_numeric($this->site['site_id']))
				$where.=' AND `site_id`="'.$this->site['site_id'].'"';
			
		}
		$updates=implode(', ',$updates);
		$query=$this->db->query('UPDATE `'.$this->table.'` 
									SET '.$updates.' 
									WHERE '.$where);
		
		if($this->db->_error_number()!=0)
			throw new Exception('MySQL Error',7);
			
		return true;
	}

	function delete($condition){
		if(empty($condition)||(!is_numeric($condition)&&!is_string($condition)))
			throw new Exception('No input data', 0);
			
		$primary_key=$this->getPrimaryKey();			
		if(is_numeric($condition))
			$condition='`'.$primary_key.'` = "'.$condition.'"';

		$this->db->query('DELETE FROM `'.$this->table.'` 
							WHERE '.$condition);
		
		if($this->db->_error_number()!=0)
			throw new Exception('MySQL Error',7);
			
		return true;		
	}		
}