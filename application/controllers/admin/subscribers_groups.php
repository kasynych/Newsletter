<?php
class Subscribers_groups extends Admin_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('model_subscribers_groups');
	}
	
	function index(){
		try{
			$subscribers_groups_list=$this->model_subscribers_groups->getList();
		}catch(Exception $e){
			$this->data['errors'][]=$e->getMessage();
		}
		
		if(!empty($subscribers_groups_list))
			$this->data['subscribers_groups']=$subscribers_groups_list;
			
		$this->data['title']='Subscribers groups';
		$this->data['content']='subscribers_groups';
		$this->load->view('admin/layout',$this->data);
	}
	
	function add(){
		if($this->input->post()!==false){			
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean|max_length=50');
			$this->form_validation->set_rules('description', 'Description', 'xss_clean|max_length=1000');			
			if($this->form_validation->run() == FALSE){
				$this->getFormData();
				$this->data['title']='Add subscribers group';
				$this->data['form_action']='add';
				$this->data['content']='subscribers_group_form';
				$this->load->view('admin/layout',$this->data);				
			}else{
				try{
					$data=$this->input->post();
					$this->model_subscribers_groups->add($data);
					$this->data['message']='Subscribers group was successfully added';
					$this->index();			
				}catch(Exception $e){
					$this->data['errors']=$e->getMessage();
					$this->data['form_action']='add';
					$this->data['title']='Add subscribers group';
					$this->data['content']='subscribers_group_form';
					$this->load->view('admin/layout',$this->data);
				}
			}
		}else{
			try{
				$this->data['subscribers_group']=$this->model_subscribers_groups->get();
				$this->data['title']='Add subscribers group';		
			}catch(Exception $e){
				$this->data['errors']=$e->getMessage();
			}
			$this->data['form_action']='add';
			$this->data['content']='subscribers_group_form';
			$this->load->view('admin/layout',$this->data);
		}		
	}
	
	function edit(){
		if($this->input->post()!==false){
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean|max_length=50');
			$this->form_validation->set_rules('description', 'Description', 'required|xss_clean|max_length=1000');			
			if($this->form_validation->run() == FALSE){
				$this->getFormData();
				$this->data['title']='Edit subscribers group';
				$this->data['form_action']='edit/'.$this->uri->segment(4);
				$this->data['content']='subscribers_group_form';
				$this->load->view('admin/layout',$this->data);				
			}else{
				try{
					$data=$this->input->post();
					$data['group_id']=$this->uri->segment(4);
					$this->model_subscribers_groups->edit($data);
					$this->data['message']='Subscribers group was successfully changed';
					$this->index();			
				}catch(Exception $e){
					$this->data['errors']=$e->getMessage();
					$this->data['form_action']='edit/'.$this->uri->segment(4);
					$this->data['title']='Edit subscribers group';
					$this->data['content']='subscribers_group_form';
					$this->load->view('admin/layout',$this->data);
				}
			}
		}else{
			try{
				$this->data['subscribers_group']=$this->model_subscribers_groups->get($this->uri->segment(4));				
				$this->data['title']='Edit subscribers group';		
			}catch(Exception $e){
				$this->data['errors']=$e->getMessage();
			}
			$this->data['form_action']='edit/'.$this->uri->segment(4);
			$this->data['content']='subscribers_group_form';
			$this->load->view('admin/layout',$this->data);
		}		
	}
	
	function delete(){
		if(!is_numeric($this->uri->segment(4))){
			$this->data['errors']='Group ID undefined';
			$this->index();
			return false;
		}

		try{
			$this->model_subscribers_groups->delete($this->uri->segment(4));
			$this->data['message']='Group was successfully deleted';
			$this->index();
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
	}
	
	function setDefault(){
		if(!is_numeric($this->input->post('group_id'))){
			$this->data['errors']='Group ID undefined';
			$this->index();
			return false;
		}

		try{
			$this->model_subscribers_groups->setDefault($this->input->post('group_id'));
			$this->data['message']='Default group successfully set';
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
		$this->index();
	}
	
	function excludeSubscribers($group_id){
		if(!is_numeric($group_id)){
			$this->data['errors']='Group ID undefined';
			$this->index();
			return false;
		}
		
		try{
			$this->model_subscribers_groups->setAttrs(array('group_id'=>$group_id));
			$this->model_subscribers_groups->excludeSubscriber($this->input->post('subscriber_id'));
			$this->data['message']='Subscriber was successfully excluded from group';
			$this->showSubscribers($group_id);		
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
			$this->showSubscribers($group_id);
		}
	}
	
	function showSubscribers($group_id){
		$this->load->model('model_subscribers');
		try{
			if(!is_null($group_id)){
				$subscribers_list=$this->model_subscribers->getList(array('sg.group_id'=>$group_id));
			}
			else
				$subscribers_list=$this->model_subscribers->getList();
		}catch(Exception $e){
			$this->data['errors'][]=$e->getMessage();		
		}
		
		if(!empty($subscribers_list))
			$this->data['subscribers']=$subscribers_list;
		
		$this->data['subscribers_group']=$this->model_subscribers_groups->get($group_id);
		$this->data['title']='Subscribers (Group "'.$this->data['subscribers_group']['title'].'")';
		$this->data['content']='subscribers';
		$this->data['component']='subscribers_groups';
		$this->load->view('admin/layout',$this->data);		
	}
	
	private function getFormData(){
		if($this->input->post()===false) return false;
		$data=$this->input->post();
		$this->data['subscribers_group']['group_id']=$this->uri->segment(4);
		$this->data['subscribers_group']['title']=$data['title'];
		$this->data['subscribers_group']['description']=$data['description'];
	}	
}