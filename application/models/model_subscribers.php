<?php
class Model_subscribers extends MY_records{
	var $subscriber_id 	    = NULL;
	var $name		  	    = NULL;
	var $email		  	    = NULL;
	var $content_type 	    = NULL;
	var $added_datetime 	= NULL;
	var $activated_datetime = NULL;
	var $deleted_datetime   = NULL;
	var $status		  	    = NULL;
	var $verification_code  = NULL;
	
	function __construct(){
		parent::__construct();
		$this->setTable('subscribers');
	}
	
// SETTERS
	function setAttrs(array $data){
		$this->emptyAttrs();
		if(isset($data['subscriber_id'])) $this->setId($data['subscriber_id']);
		if(isset($data['name'])) $this->setName($data['name']);
		if(isset($data['email'])) $this->setEmail($data['email']);		
		if(isset($data['content_type'])) $this->setContentType($data['content_type']);
		if(isset($data['added_datetime'])) $this->setAddedDateTime($data['added_datetime']);
		if(isset($data['activated_datetime'])) $this->setActivatedDateTime($data['activated_datetime']);
		if(isset($data['deleted_datetime'])) $this->setDeletedDateTime($data['deleted_datetime']);
		if(isset($data['status'])) $this->setStatus($data['status']);
		if(isset($data['verification_code'])) $this->setVerCode($data['verification_code']);

		return true;
	}
	
	function setId($value){
		if(empty($value)||!is_numeric($value)) return false;
		
		$this->subscriber_id=$value;
	}
	
	function setName($value){
		if(empty($value)) return false;

		$this->name=$value;
	}
	
	function setEmail($value){
		if(empty($value)) return false;

		$this->email=$value;
	}
	
	function setContentType($value){
		if(empty($value)) return false;

		$this->content_type=$value;
	}
	
	function setAddedDateTime($value){
		if(empty($value)) return false;
		
		preg_match('/\d{4}\-\d{2}\-\d{2}/',$value,$matches);
		if(empty($matches)){
			preg_match('/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}:\d{2}:\d{2})/',$value,$matches);
			if(empty($matches))
				throw new Exception('Wrong date format');
			$this->added_datetime=$matches[3].'-'.$matches[2].'-'.$matches[1].' '.$matches[4];
		}else
			$this->added_datetime=$value;			
	}
	
	function setActivatedDateTime($value){
		if(empty($value)) return false;
		
		preg_match('/\d{4}\-\d{2}\-\d{2}/',$value,$matches);
		if(empty($matches)){
			preg_match('/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}:\d{2}:\d{2})/',$value,$matches);
			if(empty($matches))
				throw new Exception('Wrong date format');
			$this->activated_datetime=$matches[3].'-'.$matches[2].'-'.$matches[1].' '.$matches[4];
		}else
			$this->activated_datetime=$value;			
	}

	function setDeletedDateTime($value){
		if(empty($value)) return false;
		
		preg_match('/\d{4}\-\d{2}\-\d{2}/',$value,$matches);
		if(empty($matches)){
			preg_match('/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}:\d{2}:\d{2})/',$value,$matches);
			if(empty($matches))
				throw new Exception('Wrong date format');
			$this->deleted_datetime=$matches[3].'-'.$matches[2].'-'.$matches[1].' '.$matches[4];
		}else
			$this->deleted_datetime=$value;			
	}	
	
	function setStatus($value){
		if(empty($value)) return false;
		
		$this->status=$value;
	}
	
	function setVerCode($value){
		if(empty($value)) return false;

		$this->verification_code=$value;
	}
	
	function emptyAttrs(){
		$this->subscriber_id	  = NULL;
		$this->name				  = NULL;
		$this->email			  = NULL;
		$this->content_type		  = NULL;
		$this->added_datetime	  = NULL;
		$this->activated_datetime = NULL;
		$this->deleted_datetime	  = NULL;
		$this->status			  = NULL;
		$this->verification_code  = NULL;

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
			$where.=' AND s.site_id='.$this->site['site_id'];		
		
		if(is_string($order)&&$order!='')
			$order='ORDER BY '.$order;
		else
			$order='ORDER BY s.subscriber_id DESC';
		
		$query=$this->db->query('SELECT s.subscriber_id, 
								 s.name, 
								 s.email, 
								 s.content_type, 
								 s.verification_code, 
								 s.status,
								 GROUP_CONCAT(sg.title SEPARATOR \',<br>\') as group_title,
								 GROUP_CONCAT(sg.group_id SEPARATOR \',\') as group_id
							FROM `'.$this->table.'` s
							LEFT JOIN subscribers_groups_rel sgl ON s.subscriber_id=sgl.subscriber_id
							LEFT JOIN subscribers_groups sg ON sg.group_id=sgl.group_id
							WHERE '.$where.' 
						    GROUP BY s.subscriber_id 
						    '.$order);
		if ($query->num_rows()==0)
			throw new Exception('Empty result', 1);
		else
			return $query->result_array();		
	}
	
	function getPagedList($conditions='',$page=null,$order=''){
		if($page===null) return $this->getList();
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
			$where.=' AND s.site_id='.$this->site['site_id'];		
		

		if(is_string($order)&&$order!='')
			$order='ORDER BY '.$order;
		else
			$order='ORDER BY s.subscriber_id DESC';		
		$query=$this->db->query('SELECT count(*) as cnt FROM subscribers s WHERE '.$where);
		$total_rows=$query->row();
		$total_rows=$total_rows->cnt;
		$this->load->library('pagination');
		$config['base_url']=base_url().'index.php/admin/'.$this->uri->segment(2).'/index/page/';
		$config['total_rows']=$total_rows;
		$config['per_page']=$this->config->item('subscribers_per_page');
		$config['uri_segment']=5;
		$this->pagination->initialize($config); 
		
		$query=$this->db->query('SELECT s.subscriber_id, 
								 s.name, 
								 s.email, 
								 s.content_type, 
								 s.verification_code, 
								 s.status,
								 GROUP_CONCAT(sg.title SEPARATOR \',<br>\') as group_title,
								 GROUP_CONCAT(sg.group_id SEPARATOR \',\') as group_id
							FROM `'.$this->table.'` s
							LEFT JOIN subscribers_groups_rel sgl ON s.subscriber_id=sgl.subscriber_id
							LEFT JOIN subscribers_groups sg ON sg.group_id=sgl.group_id
							WHERE '.$where.' 
						    GROUP BY s.subscriber_id 
						    '.$order.'
						    LIMIT '.$page.','.$this->config->item('subscribers_per_page'));
		if ($query->num_rows()==0)
			throw new Exception('Empty result', 1);
		else
			return array('result'=>$query->result_array(),'pagination'=>$this->pagination->create_links());		
	}
	
	function getGroups($subscriber_id){
		if(!$subscriber_id)
			throw new Exception('No input data', 0);
		
		$query=$this->db->query('SELECT sg.group_id, 
										sg.title,
										sg.description
									FROM subscribers_groups sg
									INNER JOIN subscribers_groups_rel sgl ON sg.group_id=sgl.group_id
									INNER JOIN subscribers s ON s.subscriber_id=sgl.subscriber_id
									WHERE s.subscriber_id="'.$subscriber_id.'"');
//		$groups=array();
//		foreach($query->result_array() as $group)
//			$groups[]=$group['group_id'];
		return $query->result_array();
	}
	
	function getGroupsIds($subscriber_id){
		if(!$subscriber_id&&!$this->subscriber_id)
			throw new Exception('No input data', 0);

		$groups=$this->getGroups($subscriber_id);
		$groups_ids=array();
		foreach($groups as $group)
			$groups_ids[]=$group['group_id'];
		return $groups_ids;		
	}	
	
	function getAttrs(){
		$attrs=array();
		if(!is_null($this->subscriber_id)) $attrs['subscriber_id']=$this->subscriber_id;
		if(!is_null($this->name)) $attrs['name']=$this->name;
		if(!is_null($this->email)) $attrs['email']=$this->email;
		if(!is_null($this->content_type)) $attrs['content_type']=$this->content_type;
		if(!is_null($this->added_datetime)) $attrs['added_datetime']=$this->added_datetime;
		if(!is_null($this->activated_datetime)) $attrs['activated_datetime']=$this->activated_datetime;
		if(!is_null($this->deleted_datetime)) $attrs['deleted_datetime']=$this->deleted_datetime;
		if(!is_null($this->status)) $attrs['status']=$this->status;
		if(!is_null($this->verification_code)) $attrs['verification_code']=$this->verification_code;
		
		if(!empty($attrs))
			return $attrs;
		else return false;
	}
	
// ACTIONS	
	function verify(){
		
	}
	
	function add($data){
		if(empty($data)||!is_array($data))
			throw new Exception('No input data', 0);
		
		try{
			$this->setAttrs($data);
		}catch(Exception $e){
			throw new Exception('Error setting attributes',3);
		}
		
		// adding at first data to subscribers table
		try{
			parent::add($this->getAttrs());
			$data['subscriber_id']=$this->db->insert_id();
		}catch(Exception $e){
			throw new Exception('Error adding record', 10);
		}
		
		// secondly adding data to subscribers_groups_rel table
		if(is_array($data['group_id'])){
			try{
				$this->load->model('model_relations');
				$this->model_relations->setTable('subscribers_groups_rel');
				$this->model_relations->setRelations('subscribers','subscribers_groups');
				$this->model_relations->add($data['subscriber_id'],$data['group_id']);
			}catch(Exception $e){
				throw new Exception('Error setting relations',9);
			}
		}
		return true;
	}
	
	function edit($data=array()){
		if(empty($data)||!is_array($data))
			$data=$this->getAttrs();
					
		try{
			$this->setAttrs($data);
		}catch(Exception $e){
			throw new Exception('Error setting attributes',3);
		}
		
		try{
			parent::edit($this->getAttrs());
		}catch(Exception $e){
			throw new Exception('Error editing record', 6);
		}
		
		if(isset($data['group_id'])&&is_array($data['group_id']))
			try{
				$this->load->model('model_relations');
				$this->model_relations->setTable('subscribers_groups_rel');
				$this->model_relations->setRelations('subscribers','subscribers_groups');
				$this->model_relations->edit($data['subscriber_id'],$data['group_id']);
			}catch(Exception $e){
				throw new Exception('Error setting relations',9);
			}
	}
	
	function delete($subscriber_id){
		if(!is_numeric($subscriber_id)&&!is_array($subscriber_id))
			throw new Exception('Wrong data given');
		try{
			if(is_numeric($subscriber_id))
				parent::edit(array('subscriber_id'=>$subscriber_id,
								   'status'=>'deleted',
								   'deleted_datetime'=>date('Y-m-d H:i:s'),
								   'activated_datetime'=>'0000-00-00 00:00:00'));
			elseif(is_array($subscriber_id))
				foreach($subscriber_id as $id)
					parent::edit(array('subscriber_id'=>$id,
									   'status'=>'deleted',
									   'deleted_datetime'=>date('Y-m-d H:i:s'),
									   'activated_datetime'=>'0000-00-00 00:00:00'));
			else 	throw new Exception('Wrong data given');
				
		}catch(Exception $e){
			throw new Exception('Error editing data', 6);
		}
	}
	
	function deleteForever($subscriber_id){
		if(!is_numeric($subscriber_id)&&!is_array($subscriber_id))
			throw new Exception('Wrong data given');
		try{
			$this->load->model('model_relations');
			$this->model_relations->setTable('subscribers_groups_rel');
		
			if(is_numeric($subscriber_id)){
				parent::delete('subscriber_id="'.$subscriber_id.'"');
				$this->model_relations->delete('subscriber_id="'.$subscriber_id.'"');
			}
			elseif(is_array($subscriber_id))
				foreach($subscriber_id as $id){
					parent::delete('subscriber_id="'.$id.'"');
					$this->model_relations->delete('subscriber_id="'.$id.'"');
				}
			else 	throw new Exception('Wrong data given');
				
		}catch(Exception $e){
			throw new Exception('Error editing data', 6);
		}		
	}
	
	function activate($subscriber_id){
		try{
			parent::edit(array('subscriber_id'=>$subscriber_id,
							   'status'=>'subscribed',
							   'activated_datetime'=>date('Y-m-d H:i:s'),
							   'deleted_datetime'=>'0000-00-00 00:00:00'));
		}catch(Exception $e){
			throw new Exception('Error editing data', 6);
		}
	}

	function setGroup($data){
		if(empty($data)||!is_array($data))
			throw new Exception('No input data', 0);
		
		$condition='subscriber_id IN('.implode(',',$data['subscriber_id']).')';
		try{
			$this->load->model('model_relations');
			$this->model_relations->setTable('subscribers_groups_rel');
			$this->model_relations->setRelations('subscribers','subscribers_groups');
			$this->model_relations->delete($condition);
			$this->model_relations->add($data['subscriber_id'],$data['group_id']);
		}catch(Exception $e){
			throw new Exception('Error setting relations',9);
		}		
	}
	
	function addGroup($data){
		if(empty($data)||!is_array($data))
			throw new Exception('No input data', 0);
		
		$condition='subscriber_id IN('.implode(',',$data['subscriber_id']).') AND group_id='.$data['group_id'];
		try{
			$this->load->model('model_relations');
			$this->model_relations->setTable('subscribers_groups_rel');
			$this->model_relations->setRelations('subscribers','subscribers_groups');
			$this->model_relations->delete($condition);
			$this->model_relations->add($data['subscriber_id'],$data['group_id']);
		}catch(Exception $e){
			throw new Exception('Error setting relations',9);
		}		
	}	
	
	function export($ids=array()){
		if(empty($ids)||!is_array($ids))
			throw new Exception('No input data', 0);

		$primary_key=$this->getPrimaryKey();
		
		$conditions='s.'.$primary_key.' IN ('.implode(',',$ids).')';
		$subscribers=$this->getList($conditions);	
		foreach($subscribers as $index=>$subscriber)
			$subscribers[$index]['group_title']=str_replace('<br>','',$subscribers[$index]['group_title']);
		$subscribers=array_merge(array(array_keys($subscribers[0])), // getting field names from last query
								 $subscribers);
		$fp = fopen($this->config->item('tmp_path').'export.csv', 'w');
		foreach ($subscribers as $row) {
		    fputcsv($fp, $row,';');
		}
		
		fclose($fp);		
	}
	
	function import(){
		$config['upload_path'] = $this->config->item('tmp_path');
		$config['file_name'] = 'import.csv';
		$config['allowed_types'] = 'csv';
		$config['max_size']	= '2000';
		$config['overwrite'] = TRUE;
		$this->load->model('model_subscribers_groups');
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('file'))
			throw new Exception($this->upload->display_errors());
			
		$f=fopen($this->config->item('tmp_path').'import.csv','r+');
		if($f===false) throw new Exception('Could not open file',13);
		
		$columns_names=fgetcsv($f, 9000, ";");
		$rows_cnt=0;
		while(($row = fgetcsv($f, 9000, ";")) !== FALSE){
			$subscriber=array();
			foreach($row as $index=>$value)
				if($columns_names[$index]!=$this->getPrimaryKey())
					$subscriber[$columns_names[$index]]=$value;
			if(!isset($subscriber['group_title'])||empty($subscriber['group_title'])){
				$group=$this->model_subscribers_groups->getDefault();
				$subscriber['group_id'][0]=$group['group_id'];
			}else{
				$groups=explode(',',$subscriber['group_title']);
				unset($subscriber['group_title']);
				$groups_cond=array();
				foreach($groups as $group)
					$groups_cond[]='title LIKE "%'.$group.'%"';
				
				try{
					$groups=$this->model_subscribers_groups->getList(implode(' OR ',$groups_cond));
				}catch(Exception $e){
					$group=$this->model_subscribers_groups->getDefault();
					$subscriber['group_id'][0]=$group['group_id'];					
				}
				foreach($groups as $group)
					$subscriber['group_id'][]=$group['group_id'];				
			}
			
			if(!isset($subscriber['content_type'])||empty($subscriber['content_type']))
				$subscriber['content_type']='html';
			if(!isset($subscriber['status'])||empty($subscriber['status']))
				$subscriber['status']='new';				
			
//			$this->setAttrs($subscriber); // setting and getting attributes, because this procedures, that only existant fields will be added
			try{
//				$data=$this->getAttrs();
				if(!isset($data['status'])) $data['status']='new';
				$this->add($subscriber);
			}catch(Exception $e){
				throw new Exception('Error adding record', 10);
			}
			$rows_cnt++;
		}
		
		if($rows_cnt==0)
			throw new Exception('File contains no records');
		return true;
	}
	
	function sendActivationEmail($data){
		if(empty($data))
			throw new Exception('No Input Data');

		$this->load->model('model_templates');
		$this->model_templates->load('Please activate Your account',$data);
		unset($this->email); // unsetting object attribute
		$this->load->library('email');
		$config['protocol']='sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		
		$this->email->from($this->config->item('from'), $this->config->item('from_name'));
		$this->email->to($data['email']); 
		$this->email->subject($this->model_templates->subject);
		if($data['content_type']=='text')		
			$this->email->message($this->model_templates->text_body);
		else
			$this->email->message($this->model_templates->html_body);			
		
		if(!$this->email->send()){
			throw new Exception('Could not send activation email');
		}
		
//		echo $this->email->print_debugger();
	}
}