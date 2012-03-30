<?php
class Settings extends Admin_Controller{
	function __construct(){
		parent::__construct();
	}
	function index(){
		if($this->input->post()!==false){
			$this->form_validation->set_rules('from','From Email','required|xss_clean|valid_email|max_length=40');
			$this->form_validation->set_rules('from_name','From Name','required|xss_clean|max_length=50');
			$this->form_validation->set_rules('attachment_max_size','Attachment Max Size','required|xss_clean|max_length=10|integer');
			$this->form_validation->set_rules('attachment_allowed_exts','Attachment Allowed extensions','required|xss_clean|max_length=100');
			$this->form_validation->set_rules('attachment_max_filename_length','Attachment Max Filename Length','required|xss_clean|max_length=50|integer');
			$this->form_validation->set_rules('tmp_path','Temp path','required|xss_clean|max_length=100');
			$this->form_validation->set_rules('mailer','Mailer','required|xss_clean|max_length=20');
			$this->form_validation->set_rules('newsletters_per_page','Newsletters Per Page','required|xss_clean|max_length=10|integer');
			$this->form_validation->set_rules('subscribers_per_page','Subscribers Per Page','required|xss_clean|max_length=10|integer');
			$this->form_validation->set_rules('schedules_per_page','Schedules Per Page','required|xss_clean|max_length=10|integer');
			
			if($this->form_validation->run()===FALSE){
				$this->data['settings']=$this->input->post();
				$this->data['content']='settings_form';
				$this->load->view('admin/layout',$this->data);
				
			}else{
				try{
					$this->model_settings->store($this->input->post());
				}catch(Exception $e){
					$this->data['errors']=$e->getMessage();
					$this->data['settings']=$this->input->post();
					$this->data['content']='settings_form';
					$this->load->view('admin/layout',$this->data);					
				}
				
				$this->data['message']='Settings successfully stored';
				try{	
					$this->data['settings']=$this->model_settings->get();
				}catch(Exception $e){
					$this->data['errors']='Error getting settings';
					$this->data['content']='settings_form';
					$this->load->view('admin/layout',$this->data);
					return true;
				}
			
				$this->data['content']='settings_form';
				$this->load->view('admin/layout',$this->data);	
			}
		}else{
			try{	
				$this->data['settings']=$this->model_settings->get();
			}catch(Exception $e){
				$this->data['errors']='Error getting settings';
				$this->data['content']='settings_form';
				$this->load->view('admin/layout',$this->data);
				return true;
			}
		
			$this->data['content']='settings_form';
			$this->load->view('admin/layout',$this->data);
		}
	}
}