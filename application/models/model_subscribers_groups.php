<?php
class Model_subscribers_groups extends MY_records{
	var $group_id;
	var $title;
	var $description;
	
	function __construct(){
		parent::__construct();
		$this->table='subscribers_groups';
	}
	
// SETTERS
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
		return true;
	}	
	
	function setDefault($group_id){
		if(empty($group_id)||!is_numeric($group_id))
			throw new Exception('Wrong data given');
		
		try{
			$this->edit(array('default'=>0));
			$this->edit(array('group_id'=>$group_id,'default'=>1));
		}catch(Exception $e){
			throw new Exception('Error setting default group');
		}
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
		if(!is_null($this->group_id)) $attrs['group_id']=$this->group_id;
		if(!is_null($this->title)) $attrs['title']=$this->title;
		if($this->description!==NULL) $attrs['description']=$this->description;
		
		if(!empty($attrs))
			return $attrs;
		else return false;
	}	
	
	function getDefault(){
		try{
			$group=$this->get(array('default'=>1));
			return $group;
		}catch(Exception $e){
			throw new Exception('Could not get default subscribers group');
		}
	}
	
// ACTIONS

	function excludeSubscriber($subscriber_id){
		if(empty($subscriber_id)||(!is_numeric($subscriber_id)&&!is_array($subscriber_id)))
			throw new Exception('Wrong data given');
			
		if(is_numeric($subscriber_id))
			$condition='subscriber_id="'.$subscriber_id.'" AND group_id="'.$this->group_id.'"';
		else{
			$condition='subscriber_id IN('.implode(',',$subscriber_id).') AND group_id="'.$this->group_id.'"';
		}
		
		try{
			$this->load->model('model_relations');
			$this->model_relations->setTable('subscribers_groups_rel');
			$this->model_relations->setRelations('subscribers','subscribers_groups');
			$attrs=$this->getAttrs();
			$this->model_relations->delete($condition);
		}catch(Exception $e){
			throw new Exception('Error deleting relations');
		}		
	}
}