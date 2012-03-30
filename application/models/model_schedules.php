<?php
class Model_schedules extends MY_records{
	var $schedule_id;
	var $title;
	var $newsletter_id;
	var $time_rules;
	var $send_datetime;
	var $status;
	
	function __construct(){
		parent::__construct();
		$this->setTable('schedule');
	}	
	
// SETTERS

	function setAttrs(array $data){
		$this->emptyAttrs();
		if(isset($data['schedule_id'])) $this->setId($data['schedule_id']);
		if(isset($data['title'])) $this->setTitle($data['title']);
		if(isset($data['newsletter_id'])) $this->setNewsletterId($data['newsletter_id']);
		if(isset($data['time_rules'])) $this->setTimeRules($data['time_rules']);
		if(isset($data['send_date'])&&isset($data['send_hour'])&&isset($data['send_minute'])){
			if(empty($data['send_date']))
				$data['send_date']='0000-00-00';
			if(empty($data['send_hour']))
				$data['send_hour']='00';
			if(empty($data['send_minute']))
				$data['send_minute']='00';
								
			$this->setSendDateTime($data['send_date'].' '.$data['send_hour'].':'.$data['send_minute'].':00');
		}elseif(isset($data['send_datetime']))
			$this->setSendDateTime($data['send_datetime']);
		if(isset($data['status'])) $this->setStatus($data['status']);
		return true;		
	}
	
	function setId($value){
		if(empty($value)||!is_numeric($value)) return false;
		
		$this->schedule_id=$value;		
	}
	
	function setTitle($value){
		if(empty($value)) return false;
		
		$this->title=$value;				
	}	
	
	function setNewsletterId($value){
		if(empty($value)||!is_numeric($value)) return false;
		
		$this->newsletter_id=$value;		
	}
	
	function setTimeRules($value){
		if($value==NULL) $this->time_rules='';
		
		$this->time_rules=$value;				
	}
	
	function setSendDateTime($value){
		if(empty($value)) return false;
		preg_match('/\d{4}\-\d{2}\-\d{2}/',$value,$matches);
		if(empty($matches)){
			preg_match('/(\d{2})\/(\d{2})\/(\d{4}) (\d{1,2}:\d{1,2}:\d{1,2})/',$value,$matches);
			if(empty($matches))
				throw new Exception('Wrong date format');
			$this->send_datetime=$matches[3].'-'.$matches[2].'-'.$matches[1].' '.$matches[4];
		}else
			$this->send_datetime=$value;		
	}
	
	function setStatus($value){
		if(empty($value)) return false;
		
		$this->status=$value;				
	}
	
	function emptyAttrs(){	
		$this->schedule_id	 	   = NULL;
		$this->newsletter_id	   = NULL;
		$this->time_rules		   = NULL;
		$this->send_datetime	   = NULL;
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
		if(!is_null($this->schedule_id)) $attrs['schedule_id']=$this->schedule_id;
		if(!is_null($this->title)) $attrs['title']=$this->title;
		if(!is_null($this->newsletter_id)) $attrs['newsletter_id']=$this->newsletter_id;
		if(!is_null($this->time_rules)) $attrs['time_rules']=$this->time_rules;
		if(!is_null($this->send_datetime)) $attrs['send_datetime']=$this->send_datetime;
		if(!is_null($this->status)) $attrs['status']=$this->status;
		
		if(!empty($attrs))
			return $attrs;
		else return false;
	}
	
	function getDate($value=null){
		if(is_null($value)&&is_null($this->send_datetime)||$this->send_datetime=='0000-00-00 00:00:00') return '';
		
		elseif(is_null($value)){
			$datetime=$this->send_datetime;
		}
		else $datetime=$value;
		
		preg_match('/(\d{4})\-(\d{2})\-(\d{2})/',$datetime,$matches);
		
		if(empty($matches)) return false;
		
		return $matches[3].'/'.$matches[2].'/'.$matches[1];
	}
	
	function getHour($value=null){
		if(is_null($value)&&is_null($this->send_datetime)) return '';
		
		elseif(is_null($value)){
			$datetime=$this->send_datetime;
		}
		else $datetime=$value;
		preg_match('/(\d{2}):\d{2}:\d{2}/',$datetime,$matches);
		
		if(empty($matches)) return false;
		
		return $matches[1];
	}

	function getMinute($value=null){
		if(is_null($value)&&is_null($this->send_datetime)) return '';
		
		elseif(is_null($value)){
			$datetime=$this->send_datetime;
		}
		else $datetime=$value;
		
		preg_match('/\d{2}:(\d{2}):\d{2}/',$datetime,$matches);
		
		if(empty($matches)) return false;
		
		return $matches[1];
	}		
	
	function getList($conditions='',$order=''){
		if(!empty($conditions)){
			if(is_array($conditions)){
				$where=array();
				foreach($conditions as $field=>$value)
					$where[]=''.$field.'="'.$value.'"';
				$where=implode(' AND ',$where);
			}
			else $where=$conditions;			
		}else $where='1';
		
		if(isset($this->site['site_id']));
			$where.=' AND sch.site_id='.$this->site['site_id'];		
		
		if(is_string($order)&&$order!='')
			$order='ORDER BY '.$order;
		else
			$order='ORDER BY sch.schedule_id DESC';
		
		$query=$this->db->query('SELECT sch.schedule_id,
										sch.title,
										sch.newsletter_id,
										sch.time_rules,
										sch.send_datetime,
										sch.status,
										n.subject,
										n.text_body,
										n.html_body,
										n.created,
										n.updated
									FROM
										schedule sch
									LEFT JOIN newsletters n ON n.newsletter_id=sch.newsletter_id
									WHERE '.$where.'
									'.$order);
		
		if ($query->num_rows()==0)
			throw new Exception('Empty result', 1);
		else
			return $query->result_array();			
	}
	
	function getPagedList($conditions='',$page=null,$order=''){
		if(!empty($conditions)){
			if(is_array($conditions)){
				$where=array();
				foreach($conditions as $field=>$value)
					$where[]=''.$field.'="'.$value.'"';
				$where=implode(' AND ',$where);
			}
			else $where=$conditions;			
		}else $where='1';
		
		if(isset($this->site['site_id']));
			$where.=' AND sch.site_id='.$this->site['site_id'];		
		
		if(is_string($order)&&$order!='')
			$order='ORDER BY '.$order;
		else
			$order='ORDER BY sch.schedule_id DESC';		
		
		$this->load->library('pagination');
		$config['base_url']=base_url().'index.php/admin/'.$this->uri->segment(2).'/index/page/';
		$config['total_rows']=$this->db->count_all($this->table);
		$config['per_page']=$this->config->item('schedules_per_page');
		$config['uri_segment']=5;
		$this->pagination->initialize($config); 		
		
		$query=$this->db->query('SELECT sch.schedule_id,
										sch.title,
										sch.newsletter_id,
										sch.time_rules,
										sch.send_datetime,
										sch.status,
										n.subject,
										n.text_body,
										n.html_body,
										n.created,
										n.updated
									FROM
										schedule sch
									LEFT JOIN newsletters n ON n.newsletter_id=sch.newsletter_id
									WHERE '.$where.'
									'.$order.'						    
									LIMIT '.$page.','.$this->config->item('schedules_per_page'));
		if ($query->num_rows()==0)
			throw new Exception('Empty result', 1);
		else
			return array('result'=>$query->result_array(),'pagination'=>$this->pagination->create_links());	
	}	
	
	function getReceivers($schedule_id=NULL){ // receivers combine subscribers and subscribers from groups
		if(is_null($schedule_id)&&$this->schedule_id===NULL)
			throw new Exception('No input data', 0);
			
		$receivers=array();
		$this->load->model('model_subscribers');			
		$receivers=$this->getSubscribers($schedule_id);
		if(empty($receivers_ids)){
			$subscribers_groups=$this->getSubscribersGroups($schedule_id);
			foreach($subscribers_groups as $group)
				$receivers=array_merge($receivers,$this->model_subscribers->getList('sg.group_id="'.$group['group_id'].'" AND s.status="subscribed"'));	
		}else{
			$receivers_ids=array();
			foreach($receivers as $receiver)
				$receivers_ids[]=$receiver['subscriber_id'];
			$receivers_cond='s.subscriber_id IN ('.implode(',',$receivers_ids).')';
			$receivers=$this->model_subscribers->getList($receivers_cond);
		}
		return $receivers;
	}	
	
	function getSubscribers($schedule_id=NULL){
		if(is_null($schedule_id)&&$this->schedule_id===NULL)
			throw new Exception('No input data', 0);
			
		if(is_null($schedule_id))
			$schedule_id=$this->schedule_id;
		
		$query=$this->db->query('SELECT s.subscriber_id,
										s.name,
										s.email,
										s.content_type,
										s.verification_code,
										s.status
									FROM subscribers s
									LEFT JOIN schedule_subscribers_rel ssr ON ssr.subscriber_id=s.subscriber_id
									LEFT JOIN schedule sch on sch.schedule_id=ssr.schedule_id
									WHERE sch.schedule_id="'.$schedule_id.'" AND 
										  s.status="subscribed"');
//		$subscribers=array();
//		foreach($query->result_array() as $subscriber)
//			$subscribers[]=$subscriber['subscriber_id'];					
		return $query->result_array();		
	} 
	
	function getSubscribersIds($schedule_id=NULL){
		$subscribers=$this->getSubscribers($schedule_id);
		$subscribers_ids=array();
		foreach($subscribers as $subscriber)
			$subscribers_ids[]=$subscriber['subscriber_id'];
					
		return $subscribers_ids;		
	} 	
	
	function getSubscribersGroups($schedule_id=NULL){
		if(is_null($schedule_id)&&$this->schedule_id===NULL)
			throw new Exception('No input data', 0);
			
		if(is_null($schedule_id))
			$schedule_id=$this->schedule_id;
		
		$query=$this->db->query('SELECT sg.group_id,
										sg.title,
										sg.description
									FROM subscribers_groups sg
									LEFT JOIN schedule_subscribers_groups_rel ssgr ON ssgr.group_id=sg.group_id
									LEFT JOIN schedule sch on sch.schedule_id=ssgr.schedule_id
									WHERE sch.schedule_id="'.$schedule_id.'"');
//		$groups=array();
//		foreach($query->result_array() as $group)
//			$groups[]=$group['group_id'];
		return $query->result_array();	
	}
	
	function getSubscribersGroupsIds($schedule_id=NULL){
		$subscribers_groups=$this->getSubscribersGroups($schedule_id);
		$subscribers_groups_ids=array();
		foreach($subscribers_groups as $group)
			$subscribers_groups_ids[]=$group['group_id'];					
		return $subscribers_groups_ids;		
	} 		
	
// ACTIONS
	
	function add($data=array()){
		if((empty($data)||!is_array($data))&&$this->getAttrs()===false)
			throw new Exception('No input data',0);
			
		try{
			if($data['send_date']=='Now'){
				$data['send_date']='0000-00-00 00:00:00';
				$data['status']='send_asap';
				$this->setAttrs($data);
			}else{
				$data['status']='pending';
				$this->setAttrs($data);
			}			
			
			if(is_null($this->title))
				$this->title='Schedule '.date('d/m/Y H:i');

			parent::add($this->getAttrs());
		}catch(Exception $e){
			throw new Exception('Error adding schedule');
		}
			
		if(isset($data['subscriber_id'])&&is_array($data['subscriber_id']))
			try{
				$this->load->model('model_relations');
				$this->model_relations->setTable('schedule_subscribers_rel');
				$this->model_relations->setRelations('schedule','subscribers');
				$this->schedule_id=$this->lastInsertId('schedule');
				$this->model_relations->add($this->schedule_id,$data['subscriber_id']);
			}catch(Exception $e){
				throw new Exception('Error adding relation between schedule and subscriber');
			}
		elseif(is_array($data['subscriber_group_id']))
			try{
				$this->load->model('model_relations');
				$this->model_relations->setTable('schedule_subscribers_groups_rel');
				$this->model_relations->setRelations('schedule','subscribers_groups');
				$this->schedule_id=$this->lastInsertId('schedule');
				$this->model_relations->add($this->schedule_id,$data['subscriber_group_id']);
			}catch(Exception $e){
				throw new Exception('Error adding relation berween schedule and subscribers group');
			}
		else throw new Exception('Neither subscriber nor subscribers group was chosen');

		return true;
	}

	function edit($data=array()){
		if((empty($data)||!is_array($data)))
			$data=$this->getAttrs();
			
		try{
			$this->setAttrs($data);
			if(is_null($this->status))			
				$this->setStatus('pending');
			parent::edit($this->getAttrs());
		}catch(Exception $e){
			throw new Exception('Error changing schedule');
		}
			
		if(isset($data['subscriber_id'])&&is_array($data['subscriber_id'])){
			try{
				$this->load->model('model_relations');
				$this->model_relations->setTable('schedule_subscribers_groups_rel');
				$this->model_relations->delete('schedule_id="'.$this->schedule_id.'"');
								
				$this->model_relations->setTable('schedule_subscribers_rel');
				$this->model_relations->setRelations('schedule','subscribers');
				$this->model_relations->edit($this->schedule_id,$data['subscriber_id']);
			}catch(Exception $e){
				throw new Exception('Error updating relation between schedule and subscriber');
			}
		}
		elseif(isset($data['subscriber_group_id'])&&is_array($data['subscriber_group_id'])){
			try{
				$this->load->model('model_relations');
				$this->model_relations->setTable('schedule_subscribers_rel');
				$this->model_relations->delete('schedule_id="'.$this->schedule_id.'"');
				
				$this->model_relations->setTable('schedule_subscribers_groups_rel');
				$this->model_relations->setRelations('schedule','subscribers_groups');
				$this->model_relations->edit($this->schedule_id,$data['subscriber_group_id']);
			}catch(Exception $e){
				throw new Exception('Error updating relation berween schedule and subscribers group');
			}
		}
		else throw new Exception('Neither updating nor subscribers group was chosen');

		return true;
	}
	
	function delete($schedule_id){
		try{
			parent::delete($schedule_id);
		}catch(Exception $e){
			throw new Exception('Error deleting schedule');
		}
		
		try{
			$this->load->model('model_relations');
			$this->model_relations->setTable('schedule_subscribers_rel');
			$this->model_relations->delete('schedule_id="'.$schedule_id.'"');
		}catch(Exception $e){
			throw new Exception('Error deleting relation with subscribers');
		}		
		
		try{
			$this->load->model('model_relations');
			$this->model_relations->setTable('schedule_subscribers_groups_rel');
			$this->model_relations->delete('schedule_id="'.$schedule_id.'"');
		}catch(Exception $e){
			throw new Exception('Error deleting relation with subscribers groups');
		}				
	}
	
// ADDITIONAL

	function toDeliver($schedule_id){
		if(!is_numeric($schedule_id)) return false;
		
		try{
			$schedule=$this->get($schedule_id);
		}catch(Exception $e){
			return false;
		}
		if($schedule['status']=='send_asap') return true;
		elseif(isset($schedule['time_rules'])&&!empty($schedule['time_rules'])){
			$elements=explode(' ',$schedule['time_rules']);
			return $this->checkTimeRules('i',$elements[0])&&
				   $this->checkTimeRules('H',$elements[1])&&
				   $this->checkTimeRules('d',$elements[2])&&
				   $this->checkTimeRules('m',$elements[3])&&
				   $this->checkTimeRules('Y',$elements[4]);
		}
		elseif(!empty($schedule['send_datetime']))
			return strtotime(date('Y-m-d H:i',strtotime($schedule['send_datetime'])))==strtotime(date('Y-m-d H:i'));
		else return false;		
	}
	
	private function checkTimeRules($el,$value){
		$now=date($el);
		$format=$this->formatTimeRule($value);
		switch($format['type']){
			case 0:
				return true;
				break;
			case 1:
				return $now==$format['value'];
				break;			
			case 2:
				return $now%(int)$format['value']==0;
				break;
			case 3:
				return $now>=(int)$format['value1']&&$now<=(int)$format['value2'];
		}
	}
	
	private function formatTimeRule($value){
		if($value=='*')
			return array('type'=>0);
		
		if(is_numeric($value))
			return array('type'=>1,'value'=>$value);
		
		preg_match("/\*\/(\d{1,5})/",$value,$matches);
		if(!empty($matches)>0)
			return array('type'=>2,'value'=>$matches[1]);
		
		preg_match('/([0-9]{1,4})\-([0-9]{1,4})/',$value,$matches);
		
		if(!empty($matches)>0)
			return array('type'=>3,'value1'=>$matches[1],'value2'=>$matches[2]);
			
		return false;
}	
}