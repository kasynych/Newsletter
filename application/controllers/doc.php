<?php
class Doc extends CI_Controller{
	function __construct(){
		parent::__construct();	
		$this->data['base_url']=base_url();	
	}
	function index(){
		$this->load->view('doc_view',$this->data);
	}
	
	function download(){
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=unnamed.doc");
	}
}