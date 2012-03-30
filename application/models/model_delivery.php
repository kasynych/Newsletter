<?php
class Model_delivery extends MY_records{
	var $delivery_id;
	var $schedule_id;
	private $receivers;
	var $datetime;
	var $status;
	
	function __construct(){
		parent::__construct();
		$this->setTable('delivery');
	}
	
// SETTERS

	function setAttrs(array $data){
		$this->emptyAttrs();
		if(isset($data['delivery_id'])) $this->setId($data['delivery_id']);
		try{
			if(isset($data['schedule_id'])) $this->setSchedule($data['schedule_id']);
			if(isset($data['newsletter_id'])) $this->setNewsletter($data['newsletter_id']);
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
		if(isset($data['receivers'])) $this->setReceivers($data['receivers']);
		if(isset($data['datetime'])) $this->setDateTime($data['datetime']);		
		if(isset($data['status'])) $this->setStatus($data['status']);
		return true;
	}
	
	function setSchedule($schedule_id){
		if(empty($schedule_id)||!is_numeric($schedule_id)) return false;		
		$this->load->model('model_schedules');
		try{
			$this->model_schedules->get($schedule_id);
			$this->schedule_id=$schedule_id;
		}catch(Exception $e){
			throw new Exception('Error implementing schedule model (schedule_id='.$schedule_id.')');
		}
	}
	
	function setNewsletter($newsletter_id){
		if(empty($newsletter_id)||!is_numeric($newsletter_id)) return false;		
		$this->load->model('model_newsletters');
		try{
			$this->model_newsletters->get($newsletter_id);
		}catch(Exception $e){
			throw new Exception('Error implementing newsletter model (newsletter_id='.$newsletter_id.')');
		}
	}	
	
	function setReceivers($receivers){
		if(!is_array($receivers)||empty($receivers))
			throw new Exception('No receivers given',14);
			
		$this->receivers=$receivers;
	}

	function setDateTime($value){
		if(empty($value)) return false;
		
		preg_match('/\d{4}\-\d{2}\-\d{2}/',$value,$matches);
		if(empty($matches)){
			preg_match('/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}:\d{2}:\d{2})/',$value,$matches);
			if(empty($matches))
				throw new Exception('Wrong date format');
			$this->datetime=$matches[3].'-'.$matches[2].'-'.$matches[1].' '.$matches[4];
		}else
			$this->datetime=$value;		
	}	
	
	function setStatus($value){
		if(empty($value)) return false;
		
		$this->status=$value;				
	}
	
	function emptyAttrs(){	
		$this->delivery_id	 	   = NULL;
		$this->datetime	   		   = NULL;
		$this->status 			   = NULL;
		return true;				
	}

// GETTERS

	function get($conditions=null){
		if(empty($conditions)) return get_object_vars($this);
		try{
			$data=parent::get($conditions);
			$this->setAttrs($data);
		}catch(Exception $e){
			throw new Exception('Error getting data', 11);
		}
		
		return $this->getAttrs();
	}
	
	function getAttrs(){
		$attrs=array();
		if(!is_null($this->delivery_id)) $attrs['delivery_id']=$this->delivery_id;
		if(!is_null($this->schedule_id)) $attrs['schedule_id']=$this->schedule_id;
		if(!is_null($this->datetime)) $attrs['datetime']=$this->datetime;
		if(!is_null($this->status)) $attrs['status']=$this->status;
		
		if(!empty($attrs))
			return $attrs;
		else return false;
	}
	
// ACTIONS

	function deliver(){
		
		$this->load->library('email');
		$attachments=$this->model_newsletters->getAttachments($this->model_newsletters->newsletter_id);
		foreach($this->receivers as $receiver){
			$config['protocol']='sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['wordwrap'] = TRUE;
			$config['charset'] = $this->model_newsletters->charset;
			if($receiver['content_type']=='text'&&empty($this->model_newsletters->text_body))
				$config['mailtype'] = 'html';
			elseif($receiver['content_type']=='html'&&empty($this->model_newsletters->html_body))
				$config['mailtype'] = 'text';
			elseif($receiver['content_type']=='html')
				$config['mailtype'] = 'html';
			elseif($receiver['content_type']=='text')
				$config['mailtype'] = 'text';			
			
			$this->email->initialize($config);
			
			$this->email->from($this->config->item('from'), $this->config->item('from_name'));
			$this->email->to($receiver['email']); 
			$this->email->subject($this->model_newsletters->subject);
			
			if(empty($this->model_newsletters->text_body)&&empty($this->model_newsletters->html_body))
				throw new Exception('Newsletter body is empty');
				
			foreach($receiver as $field=>$value){
				if(is_array($value)) continue;
				if($field=='email')
					$value=urlencode($value);
				$this->model_newsletters->subject=str_replace('%'.$field.'%',$value,$this->model_newsletters->subject);
				$this->model_newsletters->text_body=str_replace('%'.$field.'%',$value,$this->model_newsletters->text_body);
				$this->model_newsletters->html_body=str_replace('%'.$field.'%',$value,$this->model_newsletters->html_body);				
			}
			
			if($receiver['content_type']=='text'&&empty($this->model_newsletters->text_body))
				$this->email->message($this->model_newsletters->html_body);
			elseif($receiver['content_type']=='html'&&empty($this->model_newsletters->html_body))
				$this->email->message($this->model_newsletters->text_body);
			elseif($receiver['content_type']=='html')
				$this->email->message($this->model_newsletters->html_body);
			elseif($receiver['content_type']=='text')
				$this->email->message($this->model_newsletters->text_body);

			if(!empty($attachments)){
				foreach($attachments as $attachment){
					$f=fopen($this->config->item('tmp_path').$attachment['filename'],'w+');
					fwrite($f,$attachment['file'],strlen($attachment['file']));
					fclose($f);
					$this->email->attach($this->config->item('tmp_path').$attachment['filename']);
					
				}
			}
			if(!$this->email->send()){
				$this->setStatus('failed');
				return false;
			}
			else{
				if($this->model_schedules->time_rules==NULL||$this->model_schedules->time_rules==''){
					$this->model_schedules->setStatus('sent');
					$this->model_newsletters->setStatus('sent');
					$this->setStatus('sent');
				}
				else{
					$this->model_schedules->setStatus('sending');
					$this->model_newsletters->setStatus('sent');
					$this->setStatus('sending');
				}
			}
			if(!empty($attachments))
				foreach($attachments as $attachment)
					unlink($this->config->item('tmp_path').$attachment['filename']);
					
			echo 'mail sent:<br>';
			echo 'Subscriber ID: '.$receiver['subscriber_id'].'</br>';
			echo 'Subscriber name: '.$receiver['name'].'</br>';
			echo 'Subscriber email: '.$receiver['email'].'</br>';
//			echo $this->email->print_debugger();
			echo 'Newsletter ID: '.$this->model_newsletters->newsletter_id.'</br></br>-------------</br></br>';
			$this->email->clear(TRUE);						
		}
		$this->store();
		return true;		
	}
	
	function store(){
		try{
			$this->setDateTime(date('Y-m-d H:i:s'));
			parent::add($this->getAttrs());
			$this->model_schedules->edit();
			$this->model_newsletters->edit();				
		}catch(Exception $e){
			return false;
		}
		return true;
	}
}