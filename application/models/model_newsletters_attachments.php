<?php
class Model_newsletters_attachments extends MY_records{
	var $attachment_id;
	var $newsletter_id;
	var $filename;
	var $file;
	
	function __construct(){
		parent::__construct();
		$this->setTable('newsletters_attachments');
	}
	
// SETTERS

	function setAttrs($data){
		$this->emptyAttrs();
		if(isset($data['attachment_id'])) $this->setId($data['attachment_id']);
		if(isset($data['newsletter_id'])) $this->setNewsletterId($data['newsletter_id']);
		if(isset($data['filename'])) $this->setFilename($data['filename']);
		if(isset($data['file'])) $this->setFile($data['file']);
		return true;		
	}
	
	function setId($value){
		if(empty($value)||!is_numeric($value)) return false;
		
		$this->attachment_id=$value;			
	}
	
	function setNewsletterId($value){
		if(empty($value)||!is_numeric($value)) return false;
		
		$this->newsletter_id=$value;			
	}
	
	function setFilename($value){
		if(empty($value)) return false;
		
		$this->filename=urlencode($value);			
	}	
	
	function setFile($value){
		if(empty($value)) return false;
		
		$this->file=$value;			
	}
	
	function emptyAttrs(){
		$this->attachment_id = NULL;
		$this->newsletter_id = NULL;
		$this->filename		 = NULL;
		$this->file			 = NULL;
		return true;
	}
	
// GETTERS

	function getAttrs(){
		$attrs=array();
		if(!is_null($this->attachment_id)) $attrs['attachment_id']=$this->attachment_id;
		if(!is_null($this->newsletter_id)) $attrs['newsletter_id']=$this->newsletter_id;
		if(!is_null($this->filename)) $attrs['filename']=$this->filename;
		if(!is_null($this->file)) $attrs['file']=$this->file;
		
		if(!empty($attrs))
			return $attrs;
		else return false;		
	}
}