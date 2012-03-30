<?php
class Model_newsletters_groups extends MY_records{
	var $group_id;
	var $title;
	var $description;
	
	function __construct(){
		parent::__construct();
		$this->table='newsletters_groups';
	}
	
	function setAttrs(array $data){
		$this->emptyAttrs();
		if(isset($data['group_id'])) $this->setId($data['group_id']);
		if(isset($data['title'])) $this->setTitle($data['title']);
		if(isset($data['description'])) $this->setDescription($data['description']);		
		return true;
	}
		
	function setId($value){
		if(empty($value)||!is_numeric($value)) return false;
		
		$this->group_id=$value;
	}
	
	function setTitle($value){
		if($value===NULL) return false;

		$this->title=$value;		
	}
	
	function setDescription($value){
		if($value===NULL) return false;

		$this->description=$value;		
	}
	
	function emptyAttrs(){
		$this->group_id	 			 = NULL;
		$this->title				 = NULL;
		$this->description			 = NULL;
		$this->site_id			     = NULL;
		return true;
	}	
	
	function get($conditions=null){
		if(empty($conditions)) return get_object_vars($this);
		try{
			$data=parent::get($conditions);
			$this->setAttrs($data);
		}catch(Exception $e){
			throw new Exception('Error getting data', 11);
		}
		
		return $this->getAttrs();
	}

	function getAttrs(){
		$attrs=array();
		if(!is_null($this->group_id)) $attrs['group_id']=$this->group_id;
		if(!is_null($this->title)) $attrs['title']=$this->title;
		if(!is_null($this->description)) $attrs['description']=$this->description;
		
		if(!empty($attrs))
			return $attrs;
		else return false;
	}	
}