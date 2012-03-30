<?php
class Model_admin extends MY_records{
	function __construct(){
		parent::__construct();
		$this->setTable('admin');
	}
	function login(){
		if(!$this->input->post())
			throw new Exception('No input data', 0);
			
		$data['name']=$this->input->post('name');
		$data['password']=md5($this->input->post('password'));
		try{
			$admin=$this->get($data);
		}catch(Exception $e){
			if($e->getCode()==1)
				throw new Exception('Login or Password wrong', 2);
			elseif($e->getPrevious()->getCode()==0)
				throw new Exception('No input data', 0);
		}
		
		$this->session->set_userdata('admin_id',$admin['id']);
		return true;
	}
	
	function logout(){
		$this->session->unset_userdata('admin_id');
		return !$this->logged_in();		
	}
	
	function logged_in(){
		$admin_id=$this->session->userdata('admin_id');
		return $admin_id!==false;
	}
	
	function changePassword(){
		
	}
}