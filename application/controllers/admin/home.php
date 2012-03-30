<?php
class Home extends Admin_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->data['content']='home';
		$this->load->view('admin/layout',$this->data);
	}
	
	public function login(){
		if($this->input->post()!==false){
			$data=$this->input->post();
			$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
			if($this->form_validation->run() == FALSE){
				$this->data['name']=$data['name'];
				$this->load->view('admin/login',$this->data);
				return false;
			}else{
				try{
					$this->model_admin->login();
				}catch(Exception $e){
					$this->data['errors'][]=$e->getMessage();
					$this->load->view('admin/login',$this->data);
					return false;
				}
				$this->data['message']='You were successfully logged in';
				$this->index();
			}
		}
		else $this->load->view('admin/login',$this->data);
	}
	public function logout(){
		if($this->model_admin->logout()){
			$this->data['message']='You were successfully logged out';
			$this->load->view('admin/login',$this->data);
		}
		else{
			$this->data['errors'][]='Error logging out';
			$this->index();
		}		
	}
}