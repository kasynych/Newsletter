<?php
class Model_templates extends MY_records{
	var $template_id;
	var $subject;
	var $text_body;
	var $html_body;
	
	function __construct(){
		parent::__construct();
		$this->setTable('templates');
	}
	
// SETTERS
	function setAttrs(array $data){
		$this->emptyAttrs();
		if(isset($data['template_id'])) $this->setId($data['template_id']);
		if(isset($data['subject'])) $this->setSubject($data['subject']);
		if(isset($data['text_body'])) $this->setTextBody($data['text_body']);		
		if(isset($data['html_body'])) $this->setHtmlBody($data['html_body']);

		return true;
	}
		
	function setId($value){
		if(empty($value)||!is_numeric($value)) return false;
		
		$this->template_id=$value;
	}
	
	function setSubject($value){
		if(empty($value)) return false;

		$this->subject=$value;		
	}
	
	function setTextBody($value){
		if(empty($value)) return false;

		$this->text_body=$value;		
	}
	
	function setHtmlBody($value){
		if(empty($value)) return false;

		$this->html_body=$value;		
	}
	
	function setDefault($template_id){
		if(empty($template_id)||!is_numeric($template_id))
			throw new Exception('Wrong data given');
		
		try{
			$this->edit(array('default'=>0));
			$this->edit(array('template_id'=>$template_id,'default'=>1));
		}catch(Exception $e){
			throw new Exception('Error setting default template');
		}
	}	
	
	function emptyAttrs(){
		$this->template_id	 		 = NULL;
		$this->subject				 = NULL;
		$this->text_body			 = NULL;
		$this->html_body			 = NULL;

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
		if(!is_null($this->template_id)) $attrs['template_id']=$this->template_id;
		if(!is_null($this->subject)) $attrs['subject']=$this->subject;
		if(!is_null($this->text_body)) $attrs['text_body']=$this->text_body;
		if(!is_null($this->html_body)) $attrs['html_body']=$this->html_body;
		
		if(!empty($attrs))
			return $attrs;
		else return false;
	}

	function getDefault(){
		try{
			$template=$this->get(array('default'=>1));
			return $template;
		}catch(Exception $e){
			throw new Exception('Could not get default template');
		}
	}
	
	function load($subject,$data=array()){
		if(empty($subject))
			throw new exception('No Input Data');
		$this->get('subject LIKE "%'.$subject.'%"');
		if(!empty($data))
			foreach($data as $field=>$value){
				if(is_array($value)) continue;
				$this->subject=str_replace('%'.$field.'%',$value,$this->subject);
				$this->text_body=str_replace('%'.$field.'%',$value,$this->text_body);
				$this->html_body=str_replace('%'.$field.'%',$value,$this->html_body);
			}
	}
}