<?php
class Templates extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('model_templates');
	}
	
	function index(){
		try{
			$templates_list=$this->model_templates->getList();
		}catch(Exception $e){
			$this->data['errors'][]=$e->getMessage();
		}
		
		if(!empty($templates_list))
			$this->data['templates']=$templates_list;
			
		$this->data['title']='Templates';
		$this->data['content']='templates';
		$this->load->view('admin/layout',$this->data);
	}
	
	function showDetails(){
		if(!is_numeric($this->uri->segment(4))){
			$this->data['errors']='No ID given';
			$this->index();
			return true;			
		}		
		
		try{
			$this->data['template']=$this->model_templates->get($this->uri->segment(4));
			$this->data['title']='Template Details';		
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
		$this->data['content']='template_details';
		$this->load->view('admin/layout',$this->data);		
	}
	
	function get($template_id){ // FUNCTION FOR AJAX
		if(!is_numeric($template_id)){
			echo 'Template ID not given';
			return true;
		}
		
		$template=$this->model_templates->get($template_id);
		
		$return_data=array('subject'  =>$template['subject'],
						   'text_body'=>$template['text_body'],
						   'html_body'=>$template['html_body']);
		
		echo json_encode($return_data);
	}
	
	function add(){
		if($this->input->post()!==false){
			$this->form_validation->set_rules('subject', 'Subject', 'required|xss_clean|max_length=50');
			$this->form_validation->set_rules('html_body','HTML Body','callback_check_body');
			if($this->form_validation->run() == FALSE){
				$this->getFormData();
				$this->data['title']='Add template';
				$this->data['form_action']='add';
				$this->data['content']='template_form';
				$this->load->view('admin/layout',$this->data);				
			}else{
				try{
					$data=$this->input->post();
					$this->model_templates->add($data);
					$this->data['message']='Template was successfully added';
					$this->index();			
				}catch(Exception $e){
					$this->data['errors']=$e->getMessage();
					$this->data['form_action']='add';
					$this->data['title']='Add template';
					$this->data['content']='template_form';
					$this->load->view('admin/layout',$this->data);
				}
			}
		}else{
			try{
				$this->data['subscribers_group']=$this->model_templates->get();
				$this->data['title']='Add template';		
			}catch(Exception $e){
				$this->data['errors']=$e->getMessage();
			}
			$this->data['template']=$this->model_templates->get();
			$this->data['form_action']='add';
			$this->data['content']='template_form';
			$this->load->view('admin/layout',$this->data);
		}		
	}
	
	function edit($template_id){
		if(!is_numeric($template_id)){
			$this->data['errors']='Template ID not given';
			$this->index();
			return true;
		}
		if($this->input->post()!==false){
			$this->form_validation->set_rules('subject', 'Subject', 'required|xss_clean|max_length=50');
			$this->form_validation->set_rules('text_body', 'Text Body', 'required|xss_clean|max_length=10000');			
			$this->form_validation->set_rules('html_body', 'HTML Body', 'required|xss_clean|max_length=10000');
			
			if($this->form_validation->run() == FALSE){
				$this->getFormData();
				$this->data['title']='Edit template';
				$this->data['form_action']='edit/'.$template_id;
				$this->data['content']='template_form';
				$this->load->view('admin/layout',$this->data);				
			}else{
				try{
					$data=$this->input->post();
					$data['template_id']=$template_id;
					$this->model_templates->edit($data);
					$this->data['message']='Template was successfully changed';
					$this->index();			
				}catch(Exception $e){
					$this->data['errors']=$e->getMessage();
					$this->data['form_action']='edit/'.$template_id;
					$this->data['title']='Edit template';
					$this->data['content']='template_form';
					$this->load->view('admin/layout',$this->data);
				}
			}
		}else{
			try{
				$this->data['template']=$this->model_templates->get($this->uri->segment(4));
				$this->data['title']='Edit template';		
			}catch(Exception $e){
				$this->data['errors']=$e->getMessage();
			}
			$this->data['form_action']='edit/'.$template_id;
			$this->data['content']='template_form';
			$this->load->view('admin/layout',$this->data);
		}		
	}
	
	function delete($template_id=null){
		if(!is_numeric($this->uri->segment(4))&&$this->input->post('template_id')===false){
			$this->data['errors']='IDs undefined';
			$this->index();
			return false;
		}elseif(is_numeric($this->uri->segment(4)))
			$template_id=$this->uri->segment(4);
		else
			$template_id=$this->input->post('template_id');

		try{
			if(is_numeric($template_id))
				$this->model_templates->delete($template_id);
			else
				foreach($template_id as $id)
					$this->model_templates->delete($id);
			$this->data['message']='Template(s) was(were) successfully deleted';
			$this->index();
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
	}
	
	function check_body($str){
		if($this->input->post('text_body')==''&&strip_tags($this->input->post('html_body'))==''){
			$this->form_validation->set_message('check_body','Newsletter message not given');
			return false;
		}else return true;
	}	
	
	function setDefault(){
		if(!is_numeric($this->input->post('template_id'))){
			$this->data['errors']='Template ID undefined';
			$this->index();
			return false;
		}

		try{
			$this->model_templates->setDefault($this->input->post('template_id'));
			$this->data['message']='Default template successfully set';
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
		$this->index();
	}	
	
	private function getFormData(){
		if($this->input->post()===false) return false;
		$data=$this->input->post();
		$this->data['template']['template_id']=$this->uri->segment(4);
		$this->data['template']['subject']=$data['subject'];
		$this->data['template']['text_body']=$data['text_body'];
		$this->data['template']['html_body']=$data['html_body'];
	}	
}