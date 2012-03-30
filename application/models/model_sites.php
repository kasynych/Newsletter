<?php
class Model_sites extends MY_records{
	var $site_id;
	var $title;
	var $url;
	
	function __construct(){
		parent::__construct();
		$this->setTable('sites');
	}
	
// SETTERS

	function setAttrs(array $data){
		$this->emptyAttrs();
		if(isset($data['site_id'])) $this->setId($data['site_id']);
		if(isset($data['title'])) $this->setTitle($data['title']);
		if(isset($data['url'])) $this->setUrl($data['url']);		
		return true;
	}	
	
	function setId($value){
		if(empty($value)||!is_numeric($value)) return false;
		
		$this->site_id=$value;		
	}	
	
	function setTitle($value){
		if(empty($value)) return false;
		
		$this->title=$value;		
	}	
	
	function setUrl($value){
		if(empty($value)) return false;
		
		$this->url=$value;		
	}		
	
	function emptyAttrs(){
		$this->site_id = NULL;
		$this->title   = NULL;
		$this->url     = NULL;

		return true;
	}	
	
// GETTERS

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
		if(!is_null($this->site_id)) $attrs['site_id']=$this->site_id;
		if(!is_null($this->title)) $attrs['title']=$this->title;
		if(!is_null($this->url)) $attrs['url']=$this->url;
		if(!empty($attrs))
			return $attrs;
		else return false;
	}	
}