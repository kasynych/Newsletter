<?php
class Model_relations extends MY_records{
	var $table1=array('primary_key' => NULL,
					  'name'       => NULL);
	var $table2=array('primary_key' => NULL,
					  'name'       => NULL);
	
	function __construct(){
		parent::__construct();
		// not setting table in constructor, because there can be relations of different pares of tables managed by this model
	}
	
	function setRelations($table1,$table2){
		$this->table1['primary_key']=$this->getPrimaryKey($table1);
		$this->table2['primary_key']=$this->getPrimaryKey($table2);
		$this->table1['name']=$table1;
		$this->table2['name']=$table2;
	}
	
	function edit($data1,$data2){
		if(empty($data1)||empty($data2))
			throw new Exception('Wrong input data',8);
		if(!is_array($data1)&&!is_array($data2))
			throw new Exception('Wrong input data',8);			
		if(!is_numeric($data1)&&!is_numeric($data2))
			throw new Exception('Wrong input data',8);
		try{
			if(is_numeric($data1)){
				parent::delete($this->table1['primary_key'].' = "'.$data1.'"');
				foreach($data2 as $id2)
					parent::add(array($this->table1['primary_key']=>$data1,
									 $this->table2['primary_key']=>$id2));
			}
			else{
				parent::delete($this->table2['primary_key'].' = "'.$data2.'"');
				foreach($data1 as $id1)
					parent::add(array($this->table1['primary_key']=>$id1,
									 $this->table2['primary_key']=>$data2));
			}
		}catch(Exception $e){
			throw new Exception('Error setting relations',9);
		}			
	}
	
	function add($data1,$data2){	
		if(empty($data1)||empty($data2))
			throw new Exception('Wrong input data',8);
		if(!is_array($data1)&&!is_array($data2))
			throw new Exception('Wrong input data',8);			
		if(!is_numeric($data1)&&!is_numeric($data2))
			throw new Exception('Wrong input data',8);
		try{
			if(is_numeric($data1))
				foreach($data2 as $id2)
					parent::add(array($this->table1['primary_key']=>$data1,
									 $this->table2['primary_key']=>$id2));
			else
				foreach($data1 as $id1)
					parent::add(array($this->table1['primary_key']=>$id1,
									 $this->table2['primary_key']=>$data2));
		}catch(Exception $e){
			throw new Exception('Error setting relations',9);
		}			
	}
}