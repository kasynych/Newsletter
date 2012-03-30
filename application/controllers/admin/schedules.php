<?php
class Schedules extends Admin_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('model_schedules');
	}
	
	function index(){
		try{
			$schedules = $this->model_schedules->getPagedList(null,is_numeric($this->uri->segment(5))?$this->uri->segment(5):0);
		}catch(Exception $e){
			$this->data['errors']='Empty result';
		}
		$this->data['schedules']=$schedules['result'];
		$this->data['pagination']=$schedules['pagination'];
		$this->data['title']='Schedules';
		$this->data['content']='schedules';
		$this->load->view('admin/layout',$this->data);		
	}
	
	function showDetails(){
		if(!is_numeric($this->uri->segment(4))){
			$this->data['errors']='No ID given';
			$this->index();
			return true;			
		}
		try{
			$this->load->model('model_newsletters');
			$this->data['schedule']=$this->model_schedules->get('schedule_id="'.$this->uri->segment(4).'"');
			try{
				$this->data['newsletter']=$this->model_newsletters->get('newsletter_id="'.$this->data['schedule']['newsletter_id'].'"');
				$this->data['show_newsletter']=true;
			}catch(Exception $e){}
			$this->data['schedule']['subscribers']=$this->model_schedules->getReceivers($this->data['schedule']['schedule_id']);			
			
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
		$this->data['content']='schedule_details';
		$this->data['title']='Schedule Details';
		$this->load->view('admin/layout',$this->data);				
	}
		
	function add(){
		$this->load->model('model_newsletters');
		$this->load->model('model_subscribers');
		$this->load->model('model_subscribers_groups');
		try{
			$this->data['newsletters']=$this->model_newsletters->getList();
		}catch(Exception $e){
			$this->data['newsletters']=array();
		}
		
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
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean|max_length=50');
			$this->form_validation->set_rules('newsletter_id', 'Newsletter', 'integer|required|xss_clean|max_length=10');
			$this->form_validation->set_rules('submit', 'Subscribers', 'callback_check_subscribers');
			$this->form_validation->set_rules('time_rules', 'Time rules', 'callback_check_time_rules');			
			if($this->form_validation->run() == FALSE){
				$this->getFormData();						
				$this->data['title']='Add schedule';
				$this->data['form_action']='add';
				$this->data['content']='schedule_form';
				$this->load->view('admin/layout',$this->data);				
			}
			else{
				try{
					$this->model_schedules->add($this->input->post());
					$this->data['message']='Schedule was successfully added';
					$this->index();	
				}catch(Exception $e){
					$this->getFormData();
					$this->data['errors']=$e->getMessage();
					$this->data['title']='Add schedule';
					$this->data['form_action']='add';
					$this->data['content']='schedule_form';
					$this->load->view('admin/layout',$this->data);
				}
			}
		}else{
			$this->data['schedule']=$this->model_schedules->get(); // getting empty data to avoid errors
			$this->data['schedule']['groups']=array();
			$this->data['schedule']['subscribers']=array();
			$this->data['schedule']['time_rules']='';
			$this->data['schedule']['send_date']='';
			$this->data['schedule']['send_hour']='00';// setting it here, not in $this->model_schedules->get(), because send_date attribute contains time
			$this->data['schedule']['send_minute']='00';;// setting it here, not in $this->model_schedules->get(), because send_date attribute contains time
			$this->data['title']='Add schedule';			
			$this->data['form_action']='add';
			$this->data['content']='schedule_form';
			$this->load->view('admin/layout',$this->data);
		}
	}
	
	function edit($schedule_id=null){
		$this->load->model('model_newsletters');
		$this->load->model('model_subscribers');
		$this->load->model('model_subscribers_groups');
		try{
			$this->data['newsletters']=$this->model_newsletters->getList();
		}catch(Exception $e){
			$this->data['newsletters']=array();
		}		
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
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean|max_length=50');
			$this->form_validation->set_rules('newsletter_id', 'Newsletter', 'integer|required|xss_clean|max_length=10');
			$this->form_validation->set_rules('submit', 'Subscribers', 'callback_check_subscribers');
			$this->form_validation->set_rules('time_rules', 'Time rules', 'callback_check_time_rules');			
			if($this->form_validation->run() == FALSE){
				$this->getFormData();						
				$this->data['title']='Edit schedule';
				$this->data['form_action']='edit/'.$schedule_id;
				$this->data['content']='schedule_form';
				$this->load->view('admin/layout',$this->data);				
			}
			else{
				try{
					$data=$this->input->post();
					$data['schedule_id']=$schedule_id;
					$this->model_schedules->edit($data);
					$this->data['message']='Schedule was successfully added';
					$this->index();	
				}catch(Exception $e){
					$this->getFormData();
					$this->data['errors']=$e->getMessage();
					$this->data['title']='Add schedule';
					$this->data['form_action']='add';
					$this->data['content']='schedule_form';
					$this->load->view('admin/layout',$this->data);
				}
			}
		}else{
			if(!is_numeric($schedule_id)){
				$this->data['errors']='No ID given';
				$this->index();
				return true;
			}
			$this->data['schedule']=$this->model_schedules->get(array('schedule_id'=>$schedule_id)); // getting empty data to avoid errors
			$this->data['schedule']['subscribers']=$this->model_schedules->getSubscribersIds($schedule_id);
			$this->data['schedule']['groups']=$this->model_schedules->getSubscribersGroupsIds($schedule_id);
			if(!isset($this->data['schedule']['time_rules']))
				$this->data['schedule']['time_rules']='';
			$this->data['schedule']['send_date']=$this->model_schedules->getDate();
			$this->data['schedule']['send_hour']=$this->model_schedules->getHour();
			$this->data['schedule']['send_minute']=$this->model_schedules->getMinute();
			$this->data['title']='Edit schedule';			
			$this->data['form_action']='edit/'.$schedule_id;
			$this->data['content']='schedule_form';
			$this->load->view('admin/layout',$this->data);
		}		
	}
	
	function delete($schedule_id=null){
		if(!is_numeric($schedule_id)&&$this->input->post('schedule_id')===false){
			$this->data['errors']='No ID given';
			$this->index();
			return true;
		}elseif(is_numeric($this->uri->segment(4)))
			$schedule_id=$this->uri->segment(4);
		else
			$schedule_id=$this->input->post('schedule_id');
		
		try{
			if(is_numeric($schedule_id))
				$this->model_schedules->delete($schedule_id);
			else
				foreach($schedule_id as $id)
					$this->model_schedules->delete($id);
			$this->data['message']='Schedule was successfully deleted';
			$this->index();
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
			$this->index();
		}
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
			if(!is_numeric($send_hour)){
				$this->form_validation->set_message('check_time_rules','Sending hour must be numeric');
				return false;
			}
			
			if($send_hour>23&&$send_hour<0){
				$this->form_validation->set_message('check_time_rules','Sending hour must between 0 and 23');
				return false;
			}

			if(!is_numeric($send_minute)){
				$this->form_validation->set_message('check_time_rules','Sending minute must be numeric');
				return false;
			}
			
			if($send_minute>59&&$send_minute<0){
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
	
	function getFormData(){
		if($this->input->post()===false) return false;
		$data=$this->input->post();
		if(!isset($data['subscriber_id'])) $data['subscriber_id']=array();
		if(!isset($data['subscriber_group_id'])) $data['subscriber_group_id']=array();
		
		$this->data['schedule']['schedule_id']=$this->uri->segment(4);
		$this->data['schedule']['title']=$data['title'];
		$this->data['schedule']['newsletter_id']=$data['newsletter_id'];
		$this->data['schedule']['groups']=$data['subscriber_group_id'];
		$this->data['schedule']['subscribers']=$data['subscriber_id'];		
		$this->data['schedule']['time_rules']=$data['time_rules'];
		$this->data['schedule']['send_date']=isset($data['send_date'])?$data['send_date']:NULL;
		$this->data['schedule']['send_hour']=isset($data['send_hour'])?$data['send_hour']:NULL;
		$this->data['schedule']['send_minute']=isset($data['send_minute'])?$data['send_minute']:NULL;
		$this->data['schedule']['status']='pending';	
		$this->model_subscribers->setAttrs($this->data['schedule']);
	}
	
	// AJAX
	
	function getServerDate(){
		$date=array('day'=>date('d'),
					'month'=>date('m'),
					'year'=>date('Y'),
					'hour'=>date('H'),
					'minute'=>date('i'),
					'second'=>date('s')
					);
					
		echo json_encode($date);
	}
}