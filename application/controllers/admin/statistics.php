<?php
class Statistics extends Admin_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('model_statistics');
		$this->load->library('form_validation');
	}
	
	function index(){
		if($this->input->post()!==false){
			$this->form_validation->set_rules('from','From','callback_check_from_date');
			$this->form_validation->set_rules('to','To','callback_check_to_date');
			if($this->form_validation->run()==true)
				$this->form_validation->set_rules('submit','Submit','callback_check_dates');
			if($this->form_validation->run()==FALSE){
				$this->data['subscribers_cnt']=$this->model_statistics->getSubscribersCnt();
				$this->data['new_subscribers_cnt']=$this->model_statistics->getSubscribersCnt('status="new"');
				$this->data['active_subscribers_cnt']=$this->model_statistics->getSubscribersCnt('status="subscribed"');
				$this->data['deleted_subscribers_cnt']=$this->model_statistics->getSubscribersCnt('status="deleted"');
				$this->data['from']=$this->input->post('from');
				$this->data['to']=$this->input->post('to');
				$this->data['title']='Statistics';
				$this->data['content']='statistics';
				$this->load->view('admin/layout',$this->data);
			}else{
				$this->data['subscribers_cnt']=$this->model_statistics->getSubscribersCnt();
				$this->data['new_subscribers_cnt']=$this->model_statistics->getSubscribersCnt('status="new" AND added_datetime BETWEEN "'.$this->formatDate($this->input->post('from')).'" AND "'.$this->formatDate($this->input->post('to')).'"');
				$this->data['active_subscribers_cnt']=$this->model_statistics->getSubscribersCnt('status="subscribed" AND activated_datetime BETWEEN "'.$this->formatDate($this->input->post('from')).'" AND "'.$this->formatDate($this->input->post('to')).'"');
				$this->data['deleted_subscribers_cnt']=$this->model_statistics->getSubscribersCnt('status="deleted" AND deleted_datetime BETWEEN "'.$this->formatDate($this->input->post('from')).'" AND "'.$this->formatDate($this->input->post('to')).'"');
				$this->data['from']=$this->input->post('from');
				$this->data['to']=$this->input->post('to');
				$this->data['title']='Statistics';
				$this->data['content']='statistics';
				$this->load->view('admin/layout',$this->data);
			}
		}else{
			$this->data['subscribers_cnt']=$this->model_statistics->getSubscribersCnt();
			$this->data['new_subscribers_cnt']=$this->model_statistics->getSubscribersCnt('status="new"');
			$this->data['active_subscribers_cnt']=$this->model_statistics->getSubscribersCnt('status="subscribed"');
			$this->data['deleted_subscribers_cnt']=$this->model_statistics->getSubscribersCnt('status="deleted"');
			$this->data['title']='Statistics';
			$this->data['content']='statistics';
			$this->load->view('admin/layout',$this->data);
		}
	}
	
	function check_from_date(){
		$date=$this->input->post('from');
		if(empty($date)){
			$this->form_validation->set_message('check_from_date','"From" date not set');
			return false;
		}
		
			preg_match('/(\d{2})\/(\d{2})\/(\d{4})/',$date,$matches);
			if(empty($matches)){
				$this->form_validation->set_message('check_from_date','"From" date has wrong format');
				return false;
			}
			$date=strtotime($matches[3].'-'.$matches[2].'-'.$matches[1].' 00:00:00');
			if($date>strtotime(date('Y-m-d H:i:s'))){
				$this->form_validation->set_message('check_from_date','"From" date must be in past');
				return false;
			}		
		
		return true;
	}

	function check_to_date(){
		$date=$this->input->post('to');
		if(empty($date)){
			$this->form_validation->set_message('check_to_date','"To" date not set');
			return false;
		}
		
			preg_match('/(\d{2})\/(\d{2})\/(\d{4})/',$date,$matches);
			if(empty($matches)){
				$this->form_validation->set_message('check_to_date','"To" date has wrong format');
				return false;
			}
			$date=strtotime($matches[3].'-'.$matches[2].'-'.$matches[1].' 00:00:00');
			if($date>strtotime(date('Y-m-d H:i:s'))){
				$this->form_validation->set_message('check_to_date','"To" date must be in past');
				return false;
			}		
		
		return true;
	}		
	
	function check_dates(){
		$from=preg_match('/(\d{2})\/(\d{2})\/(\d{4})/',$this->input->post('from'),$matches);
		$from=strtotime($matches[3].'-'.$matches[2].'-'.$matches[1].' 00:00:00');		
		$to=preg_match('/(\d{2})\/(\d{2})\/(\d{4})/',$this->input->post('to'),$matches);
		$to=strtotime($matches[3].'-'.$matches[2].'-'.$matches[1].' 00:00:00');		
		if($from>$to){
			$this->form_validation->set_message('check_dates','"From" date must be after "To" date');
			return false;
		}			
		
		return true;
	}
	
	private function formatDate($date){
		preg_match('/(\d{2})\/(\d{2})\/(\d{4})/',$date,$matches);
		if(empty($matches))
			return false;
		else
			return $matches[3].'-'.$matches[2].'-'.$matches[1];
	}
}