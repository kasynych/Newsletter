<?php
class Delivery extends CI_Controller{
	var $data=array('errors'=>array(),
					'message'=>'');

	function __construct(){
		parent::__construct();
		$this->load->model('model_newsletters');
		$this->load->model('model_schedules');
		$this->load->model('model_subscribers');
		$this->load->model('model_subscribers_groups');
		$this->load->model('model_settings');
		$this->data['base_url']=base_url();
		$this->model_settings->get();		
	}
	function index(){
		$schedules=$this->model_schedules->getList('sch.status="pending" OR sch.status="sending" OR sch.status="send_asap"');
		$schedules_to_be_sent=array();
		if(!empty($schedules)){
			foreach($schedules as $schedule){
				if($this->model_schedules->toDeliver($schedule['schedule_id']))
					$schedules_to_be_sent[]=$schedule;
			}
			$deliveries=array();
			$delivery_object_names=array();
			foreach($schedules_to_be_sent as $delivery_index=>$schedule){
				$delivery_object_names[$delivery_index]='delivery'.$delivery_index;
				$receivers=$this->model_schedules->getReceivers($schedule['schedule_id']);
				$this->load->model('model_delivery',$delivery_object_names[$delivery_index]);
				try{
					$this->$delivery_object_names[$delivery_index]->setAttrs(array('schedule_id'=>$schedule['schedule_id'],
															 'newsletter_id'=>$schedule['newsletter_id'],
											  				 'receivers'=>$receivers,
															 'datetime'=>date('Y-m-d H:i:s'),
															 'status'=>'started'));
					$this->$delivery_object_names[$delivery_index]->deliver();					
				}catch(Exception $e){
						echo $e->getMessage();
				}
			}
//			foreach($delivery_object_names as $delivery_object_name){
//				$this->$delivery_object_name->store();
//			}
		}
		else echo 'No email to deliver';
	}
}