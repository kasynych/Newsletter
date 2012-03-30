<?php
class Newsletters extends Admin_Controller{
		
	function __construct(){
		parent::__construct();
		$this->load->model('model_admin');
		$this->load->model('model_newsletters');
		$this->load->model('model_newsletters_groups');	
	}
	
	function index($group_id=null){
		try{
			if(is_numeric($group_id)){
				$newsletters_list=$this->model_newsletters->getList(array('ng.group_id'=>$group_id));
				
			}
			else
				$newsletters_list=$this->model_newsletters->getPagedList(null,is_numeric($this->uri->segment(5))?$this->uri->segment(5):0);
		}catch(Exception $e){
			$this->data['errors'][]=$e->getMessage();		
		}
		
		if(!empty($newsletters_list)){
			$this->data['newsletters']=$newsletters_list['result'];
			$this->data['pagination']=$newsletters_list['pagination'];
		}
			
		$this->data['title']='Newsletters';
		$this->data['content']='newsletters';
		$this->load->view('admin/layout',$this->data);
	}
	
	function showDetails(){
		$this->load->model('model_schedules');
		
		try{
			$this->data['newsletter']=$this->model_newsletters->get($this->uri->segment(4));
			$this->data['newsletter']['groups']=$this->model_newsletters->getGroups($this->uri->segment(4));			
			$this->data['schedules']=$this->model_schedules->getList('n.newsletter_id="'.$this->uri->segment(4).'"');
			foreach($this->data['schedules'] as $index=>$schedule){
				try{
					$this->data['schedules'][$index]['subscribers']=$this->model_schedules->getReceivers($schedule['schedule_id']);
				}catch(Exception $e){
					$this->data['schedules'][$index]['subscribers']=array();
				}
			}
			
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
		$this->data['show_newsletter']=false;
		$this->data['content']='newsletter_details';
		$this->data['title']='Newsletter Details';
		$this->load->view('admin/layout',$this->data);				
	}	
	
	function add(){
		$this->load->model('model_templates');
		$this->load->model('model_schedules');
		$this->load->model('model_subscribers');
		$this->load->model('model_subscribers_groups');
		try{
			$this->data['subscribers']=$this->model_subscribers->getList('s.status="subscribed"');
		}catch(Exception $e){
			$this->data['subscribers']=array();
		}
		
		try{
			$this->data['subscribers_groups']=$this->model_subscribers_groups->getList();
		}catch(Exception $e){
			$this->data['subscribers_groups']=array();
		}		
		if($this->input->post()!==false){
			$this->form_validation->set_rules('subject', 'Subject', 'required|xss_clean|max_length=100');
			$this->form_validation->set_rules('group_id[]', 'Group', 'required|xss_clean|max_length=5');
			$this->form_validation->set_rules('html_body','HTML Body','callback_check_body');
			if($this->form_validation->run()==true)
				$this->form_validation->set_rules('submit','Submit','callback_do_add');
			if($this->form_validation->run() == FALSE){
				$this->getFormData();
				$this->data['groups']=$this->model_newsletters_groups->getList();
				$this->data['schedule']=$this->model_schedules->get(); // getting empty data to avoid errors
				$this->data['schedule']['groups']=array();
				$this->data['schedule']['subscribers']=array();
				$this->data['schedule']['time_rules']='';
				$this->data['schedule']['send_date']='';
				$this->data['schedule']['send_hour']='00';// setting it here, not in $this->model_schedules->get(), because send_date attribute contains time
				$this->data['schedule']['send_minute']='00';;// setting it here, not in $this->model_schedules->get(), because send_date attribute contains time
				$this->data['title']='Add issue';
				$this->data['form_action']='add';
				$this->data['content']='newsletter_form';
				$this->load->view('admin/layout',$this->data);				
			}else{
				$this->data['message']='Issue was successfully added';
				$this->index();			
			}
		}else{
			try{
				$this->data['groups']=$this->model_newsletters_groups->getList();
			}catch(Exception $e){
				$this->data['groups']=array();
			}
				
				$this->data['newsletter']=$this->model_newsletters->get(); // getting empty data, to avoid problems in view
				if(!is_numeric($this->uri->segment(5)))
					$this->data['newsletter']['groups']=array();
				else
					$this->data['newsletter']['groups']=array($this->uri->segment(5));
				$this->data['title']='Add issue';		
			
			try{
				$this->data['templates']=$this->model_templates->getList();
			}catch(Exception $e){
				$this->data['templates']=array();
			}				
			
			try{
				$default_template=$this->model_templates->getDefault();
			}catch(Exception $e){
				$default_template=array('template_id'=>'','subject'=>'','text_body'=>'','html_body'=>'');
			}				
			$this->data['newsletter']['template_id']=$default_template['template_id'];
			$this->data['newsletter']['subject']=$default_template['subject'];
			$this->data['newsletter']['text_body']=$default_template['text_body'];
			$this->data['newsletter']['html_body']=$default_template['html_body'];
			$this->data['schedule']=$this->model_schedules->get(); // getting empty data to avoid errors
			$this->data['schedule']['groups']=array();
			$this->data['schedule']['subscribers']=array();
			$this->data['schedule']['time_rules']='';
			$this->data['schedule']['send_date']='';
			$this->data['schedule']['send_hour']='00';// setting it here, not in $this->model_schedules->get(), because send_date attribute contains time
			$this->data['schedule']['send_minute']='00';;// setting it here, not in $this->model_schedules->get(), because send_date attribute contains time
			
			$this->data['form_action']='add';
			$this->data['content']='newsletter_form';
			$this->load->view('admin/layout',$this->data);
		}		
	}
	
	function edit($newsletter_id){
		if(!$newsletter_id){
			$this->data['errors']='Issue ID undefined';
			$this->index();
			return false;
		}
		
		$this->load->model('model_templates');
		if($this->input->post()!==false){
			$this->form_validation->set_rules('subject', 'Subject', 'required|xss_clean|max_length=100');
			$this->form_validation->set_rules('group_id[]', 'Group', 'required|xss_clean|max_length=50');
			$this->form_validation->set_rules('html_body','HTML Body','callback_check_body');			
			if($this->form_validation->run()==true)
				$this->form_validation->set_rules('submit','Submit','callback_do_edit');
			if($this->form_validation->run() == FALSE){
				$this->getFormData();
				$this->data['templates']=$this->model_templates->getList();
				$this->data['groups']=$this->model_newsletters_groups->getList();
				$this->data['newsletter']['attachments']=$this->model_newsletters->getAttachments();
				$this->data['title']='Edit newsletter';
				$this->data['form_action']='edit/'.$newsletter_id;
				$this->data['content']='newsletter_form';
				$this->load->view('admin/layout',$this->data);				
			}else{
				$this->data['message']='Newsletter data was successfully changed';
				$this->index();			
			}
		}else{
			try{
				try{
					$this->data['templates']=$this->model_templates->getList();
				}catch(Exception $e){
					$this->data['groups']=array();
				}				
				try{
					$this->data['groups']=$this->model_newsletters_groups->getList();
				}catch(Exception $e){
					$this->data['groups']=array();
				}

				$this->data['newsletter']=$this->model_newsletters->get(array('newsletter_id'=>$newsletter_id));				
				$this->data['newsletter']['groups']=$this->model_newsletters->getGroupsIds($newsletter_id);
				$this->data['newsletter']['attachments']=$this->model_newsletters->getAttachments();
				$this->data['title']='Edit issue';		
			}catch(Exception $e){
				$this->data['errors']=$e->getMessage();
			}
			$this->data['form_action']='edit/'.$newsletter_id;
			$this->data['content']='newsletter_form';
			$this->load->view('admin/layout',$this->data);
		}
	}
	
	function addAndDeliver(){
		$this->load->model('model_subscribers');
		$this->load->model('model_subscribers_groups');
		$this->data['subscribers']=$this->model_subscribers->getList();
		$this->data['subscribers_groups']=$this->model_subscribers_groups->getList();
		
		if($this->input->post()===false){
			$this->data['errors']='No data given';
			$this->add();
		}else{
			$this->form_validation->set_rules('subject', 'Subject', 'required|xss_clean|max_length=100');
			$this->form_validation->set_rules('group_id[]', 'Group', 'required|xss_clean|max_length=50');
			$this->form_validation->set_rules('submit', 'Subscribers', 'callback_check_subscribers');
			$this->form_validation->set_rules('time_rules', 'Time rules', 'callback_check_time_rules');
			$this->form_validation->set_rules('html_body','HTML Body','callback_check_body');		
			if($this->form_validation->run() == FALSE){
				$this->getFormData();
				$this->getScheduleFormData();
				$this->data['groups']=$this->model_newsletters_groups->getList();
				$this->data['title']='Add issue';
				$this->data['form_action']='add';
				$this->data['show_schedule_form']='1';
				$this->data['content']='newsletter_form';
				$this->load->view('admin/layout',$this->data);			
			}else{
				$this->load->model('model_schedules');
				try{
					$data=$this->input->post();
					$this->do_add('');
					$last_newsletter=$this->model_newsletters->lastInsertId('newsletters');
					$data['newsletter_id']=$last_newsletter;
					$data['title']=$data['subject'];
					$this->model_schedules->add($data);			
					$this->data['message']='Newsletter successfully saved';
					$this->index();							
				}catch(Exception $e){
					$this->data['errors']=$e->getMessage();
					$this->getFormData();
					$this->getScheduleFormData();
					$this->data['groups']=$this->model_newsletters_groups->getList();
					$this->data['title']='Add issue';
					$this->data['form_action']='add';
					$this->data['show_schedule_form']='1';
					$this->data['content']='newsletter_form';
					$this->load->view('admin/layout',$this->data);							
				}
			}
		}
	
	}
	
	function delete(){
		if(!is_numeric($this->uri->segment(4))&&$this->input->post('newsletter_id')===false){
			$this->data['errors']='IDs undefined';
			$this->index();
			return false;
		}elseif(is_numeric($this->uri->segment(4)))
			$newsletter_id=$this->uri->segment(4);
		else
			$newsletter_id=$this->input->post('newsletter_id');

		$this->load->model('model_relations');
		$this->model_relations->setTable('newsletters_groups_rel');
		$this->model_relations->setRelations('newsletters','newsletters_groups');
		$this->load->model('model_newsletters_attachments');
		
		try{
			if(is_numeric($newsletter_id)){
				$this->model_newsletters->delete($newsletter_id);
				$condition='newsletter_id='.$newsletter_id;
			}
			else{
				foreach($newsletter_id as $id)
					$this->model_newsletters->delete($id);
				$condition='newsletter_id IN ('.implode(',',$newsletter_id).')';
			}
			$this->model_relations	->delete($condition);
			$this->model_newsletters_attachments->delete($condition);
			$this->data['message']='Newsletter(s) was(were) successfully deleted';
			$this->index();
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
	}
		
	function deleteAttachment(){
		if(!is_numeric($this->uri->segment(4))||!is_numeric($this->uri->segment(5))){
			$this->data['errors']='IDs undefined';
			$this->index();
			return false;
		}
		
		$this->load->model('model_newsletters_attachments');
		try{
			$this->model_newsletters_attachments->delete($this->uri->segment(5));
			$this->data['message']='Attachment was successfully deleted';
		}catch(Exception $e){
			$this->data['errors']='Error deleting attachment';
		}
		$this->edit($this->uri->segment(4));
	}
	
	function check_body($str){
		if($this->input->post('text_body')==''&&strip_tags($this->input->post('html_body'))==''){
			$this->form_validation->set_message('check_body','Newsletter message not given');
			return false;
		}else return true;
	}
	
	function do_add($str){
		try{
			$data=array_merge($this->input->post(),$_FILES);
			$this->model_newsletters->add($data);
		}catch(Exception $e){
			$this->form_validation->set_message('do_add', $e->getMessage());
			return false;			
		}
		return true;
	}
	
	function do_edit($str){
		try{
			$data=array_merge($this->input->post(),$_FILES);
			$data['newsletter_id']=$this->uri->segment(4);
			$this->model_newsletters->edit($data);
		}catch(Exception $e){
			$this->form_validation->set_message('do_edit', $e->getMessage());
			return false;			
		}
		return true;
	}	
	
	function check_subscribers(){
		$subscriber_id=$this->input->post('subscriber_id');
		$subscriber_subscriber_group_id=$this->input->post('subscriber_group_id');
		if(!is_array($subscriber_id)&&!is_array($subscriber_subscriber_group_id)){
			$this->form_validation->set_message('check_subscribers','Neither subscriber nor subscribers groups were chosen');
			return false;
		}else return true;
	}
	
	function check_time_rules(){
		$time_rules=$this->input->post('time_rules');
		$send_date=$this->input->post('send_date');
		$send_hour=$this->input->post('send_hour');
		$send_minute=$this->input->post('send_minute');
		if(empty($time_rules)&&empty($send_date)){
			$this->form_validation->set_message('check_time_rules','Sending time rules not set');
			return false;
		}
		
		if(empty($time_rules)){
			if($send_date=='Now') return true;
			if(!is_numeric($send_hour)){
				$this->form_validation->set_message('check_time_rules','Sending hour must be numeric');
				return false;
			}
			
			if($send_hour>23||$send_hour<0){
				$this->form_validation->set_message('check_time_rules','Sending hour must between 0 and 23');
				return false;
			}

			if(!is_numeric($send_minute)){
				$this->form_validation->set_message('check_time_rules','Sending minute must be numeric');
				return false;
			}
			
			if($send_minute>59||$send_minute<0){
				$this->form_validation->set_message('check_time_rules','Sending minute must between 0 and 59');
				return false;
			}				
			
			preg_match('/(\d{2})\/(\d{2})\/(\d{4})/',$send_date,$matches);
			if(empty($matches)){
				$this->form_validation->set_message('check_time_rules','Sending date has wrong format');
				return false;
			}
			$date=strtotime($matches[3].'-'.$matches[2].'-'.$matches[1].' '.$send_hour.':'.$send_minute.':00');
			if($date<strtotime(date('Y-m-d H:i:s'))){
				$this->form_validation->set_message('check_time_rules','Sending date must be in future');
				return false;
			}		
		}
		
		return true;
	}	
	
	private function getFormData(){
		if($this->input->post()===false) return false;
		$data=$this->input->post();
		$this->data['newsletter']['newsletter_id']=$this->uri->segment(4);
		$this->data['newsletter']['template_id']=$data['template_id'];
		$this->data['newsletter']['subject']=$data['subject'];
		$this->data['newsletter']['text_body']=$data['text_body'];
		$this->data['newsletter']['html_body']=$data['html_body'];
		$this->data['newsletter']['groups']=isset($data['group_id'])?$data['group_id']:array();;
		$this->model_newsletters->setAttrs($this->data['newsletter']);		
	}
	
	function getScheduleFormData(){
		if($this->input->post()===false) return false;
		$data=$this->input->post();
		if(!isset($data['subscriber_id'])) $data['subscriber_id']=array();
		if(!isset($data['subscriber_group_id'])) $data['subscriber_group_id']=array();
		
		$this->data['schedule']['groups']=$data['subscriber_group_id'];
		$this->data['schedule']['subscribers']=$data['subscriber_id'];		
		$this->data['schedule']['time_rules']=$data['time_rules'];
		$this->data['schedule']['send_date']=isset($data['send_date'])?$data['send_date']:NULL;
		$this->data['schedule']['send_hour']=isset($data['send_hour'])?$data['send_hour']:NULL;
		$this->data['schedule']['send_minute']=isset($data['send_minute'])?$data['send_minute']:NULL;
		$this->data['schedule']['status']='pending';	
		$this->model_subscribers->setAttrs($this->data['schedule']);
	}	
}