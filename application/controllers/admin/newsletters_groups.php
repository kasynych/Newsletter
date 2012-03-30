<?php
class Newsletters_groups extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('model_newsletters_groups');
	}
	
	function index(){
		try{
			$newsletters_groups_list=$this->model_newsletters_groups->getList();
		}catch(Exception $e){
			$this->data['errors'][]=$e->getMessage();
		}
		
		if(!empty($newsletters_groups_list))
			$this->data['newsletters_groups']=$newsletters_groups_list;
			
		$this->data['title']='Newsletters groups';
		$this->data['content']='newsletters_groups';
		$this->load->view('admin/layout',$this->data);
	}
	
	function add(){
		if($this->input->post()!==false){
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean|max_length=50');
			$this->form_validation->set_rules('description', 'Description', 'xss_clean|max_length=1000');			
			if($this->form_validation->run() == FALSE){
				$this->getFormData();
				$this->data['title']='Add newsletters group';
				$this->data['form_action']='add';
				$this->data['content']='newsletters_group_form';
				$this->load->view('admin/layout',$this->data);				
			}else{
				try{
					$data=$this->input->post();
					$this->model_newsletters_groups->add($data);
					$this->data['message']='Newsletters group was successfully added';
					$this->index();			
				}catch(Exception $e){
					$this->data['errors']=$e->getMessage();
					$this->data['form_action']='add';
					$this->data['title']='Add newsletters group';
					$this->data['content']='newsletters_group_form';
					$this->load->view('admin/layout',$this->data);
				}
			}
		}else{
			try{
				$this->data['newsletters_group']=$this->model_newsletters_groups->get();
				$this->data['title']='Add newsletters group';		
			}catch(Exception $e){
				$this->data['errors']=$e->getMessage();
			}
			$this->data['form_action']='add';
			$this->data['content']='newsletters_group_form';
			$this->load->view('admin/layout',$this->data);
		}		
	}
	
	function edit(){
		if($this->input->post()!==false){
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean|max_length=50');
			$this->form_validation->set_rules('description', 'Description', 'required|xss_clean|max_length=1000');			
			if($this->form_validation->run() == FALSE){
				$this->getFormData();
				$this->data['title']='Edit newsletters group';
				$this->data['form_action']='edit/'.$this->uri->segment(4);
				$this->data['content']='newsletters_group_form';
				$this->load->view('admin/layout',$this->data);				
			}else{
				try{
					$data=$this->input->post();
					$data['group_id']=$this->uri->segment(4);
					$this->model_newsletters_groups->edit($data);
					$this->data['message']='Newsletters group was successfully changed';
					$this->index();			
				}catch(Exception $e){
					$this->data['errors']=$e->getMessage();
					$this->data['form_action']='edit/'.$this->uri->segment(4);
					$this->data['title']='Edit newsletters group';
					$this->data['content']='newsletters_group_form';
					$this->load->view('admin/layout',$this->data);
				}
			}
		}else{
			try{
				$this->data['newsletters_group']=$this->model_newsletters_groups->get($this->uri->segment(4));
				$this->data['title']='Edit newsletters group';		
			}catch(Exception $e){
				$this->data['errors']=$e->getMessage();
			}
			$this->data['form_action']='edit/'.$this->uri->segment(4);
			$this->data['content']='newsletters_group_form';
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
			$this->model_newsletters_groups->delete($this->uri->segment(4));
			$this->data['message']='Group was successfully deleted';
			$this->index();
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
	}
	
	function showNewsletters($group_id){
		$this->load->model('model_newsletters');
		try{
			if(!is_null($group_id)){
				$newsletters_list=$this->model_newsletters->getList(array('ng.group_id'=>$group_id));
			}
			else
				$newsletters_list=$this->model_newsletters->getList();
		}catch(Exception $e){
			$this->data['errors'][]=$e->getMessage();		
		}
		
		if(!empty($newsletters_list))
			$this->data['newsletters']=$newsletters_list;
		
		$this->data['newsletters_group']=$this->model_newsletters_groups->get($group_id);
		$this->data['title']='Newsletters (Group "'.$this->data['newsletters_group']['title'].'")';
		$this->data['content']='newsletters';
		$this->data['component']='newsletters_groups';
		$this->load->view('admin/layout',$this->data);		
	}
	
	private function getFormData(){
		if($this->input->post()===false) return false;
		$data=$this->input->post();
		$this->data['newsletters_group']['group_id']=$this->uri->segment(4);
		$this->data['newsletters_group']['title']=$data['title'];
		$this->data['newsletters_group']['description']=$data['description'];
	}	
}