<?php
class Model_newsletters extends MY_records{
	var $newsletter_id;
	var $template_id;
	var $group_id;
	var $subject;
	var $text_body;
	var $html_body;
	var $charset;
	var $status;
	var $created;
	var $updated;

	function __construct(){
		parent::__construct();
		$this->setTable('newsletters');
	}
	
// SETTERS

	function setAttrs(array $data){
		$this->emptyAttrs();
		if(isset($data['newsletter_id'])) $this->setId($data['newsletter_id']);
		if(isset($data['template_id'])) $this->setTemplateId($data['template_id']);
		if(isset($data['subject'])) $this->setSubject($data['subject']);
		if(isset($data['text_body'])) $this->setTextBody($data['text_body']);		
		if(isset($data['html_body'])) $this->setHtmlBody($data['html_body']);
		if(isset($data['charset'])) $this->setCharset($data['charset']);
		if(isset($data['status'])) $this->setStatus($data['status']);
		if(isset($data['created'])) $this->setCreated($data['created']);
		if(isset($data['updated'])) $this->setUpdated($data['updated']);

		return true;
	}
	
	function setId($value){
		if(empty($value)||!is_numeric($value)) return false;
		
		$this->newsletter_id=$value;		
	}
	
	function setTemplateId($value){
		if($value==NULL||!is_numeric($value)) return false;
		
		$this->template_id=$value;		
	}	
	
	function setSubject($value){
		if(empty($value)) return false;
		
		$this->subject=$value;		
	}
	
	function setTextBody($value){
		if($value===null) return false;
		
		$this->text_body=$value;		
	}
	
	function setHtmlBody($value){
		if($value===null) return false;
		
		$this->html_body=$value;		
	}
	
	function setCharset($value){
		if(empty($value)) return false;
		
		$this->charset=$value;		
	}	
	
	function setStatus($value){
		if(empty($value)) return false;
		
		$this->status=$value;		
	}
	
	function setCreated($value){
		if(empty($value)) return false;
		
		$this->created=$value;		
	}
	
	function setUpdated($value){
		if(empty($value)) return false;
		
		$this->updated=$value;		
	}
	
	function emptyAttrs(){
		$this->newsletter_id = NULL;
		$this->template_id   = NULL;
		$this->subject		 = NULL;
		$this->text_body	 = NULL;
		$this->html_body	 = NULL;
		$this->charset	     = NULL;
		$this->status		 = NULL;
		$this->created 		 = NULL;
		$this->updated 		 = NULL;
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
			$where.=' AND n.site_id='.$this->site['site_id'];		
		
		
		if(is_string($order)&&$order!='')
			$order='ORDER BY '.$order;
		else
			$order='ORDER BY n.newsletter_id DESC';				
		
		$query=$this->db->query('SELECT n.newsletter_id,
								 n.template_id,
								 n.subject,
								 n.text_body, 
								 n.html_body,  
								 n.status,
								 n.created,
								 n.updated,
								 GROUP_CONCAT(ng.title SEPARATOR \',<br>\') as group_title,
								 GROUP_CONCAT(ng.group_id SEPARATOR \',\') as group_id,
								 ng.description as group_description  
							FROM `'.$this->table.'` n
							LEFT JOIN newsletters_groups_rel ngl ON n.newsletter_id=ngl.newsletter_id
							LEFT JOIN newsletters_groups ng ON ng.group_id=ngl.group_id
							WHERE '.$where.' 
						    GROUP BY n.newsletter_id
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
			$where.=' AND n.site_id='.$this->site['site_id'];		
		
		if(is_string($order)&&$order!='')
			$order='ORDER BY '.$order;
		else
			$order='ORDER BY n.newsletter_id DESC';				
		
		$this->load->library('pagination');
		$config['base_url']=base_url().'index.php/admin/'.$this->uri->segment(2).'/index/page/';
		$config['total_rows']=$this->db->count_all($this->table);
		$config['per_page']=$this->config->item('newsletters_per_page');
		$config['uri_segment']=5;
		$this->pagination->initialize($config); 		
		
		$query=$this->db->query('SELECT n.newsletter_id,
								 n.template_id,
								 n.subject,
								 n.text_body, 
								 n.html_body,  
								 n.status,
								 n.created,
								 n.updated,
								 GROUP_CONCAT(ng.title SEPARATOR \',<br>\') as group_title,
								 GROUP_CONCAT(ng.group_id SEPARATOR \',\') as group_id,								 
								 ng.description as group_description  
							FROM `'.$this->table.'` n
							LEFT JOIN newsletters_groups_rel ngl ON n.newsletter_id=ngl.newsletter_id
							LEFT JOIN newsletters_groups ng ON ng.group_id=ngl.group_id
							WHERE '.$where.' 
						    GROUP BY n.newsletter_id
						    '.$order.'
						    LIMIT '.$page.','.$this->config->item('newsletters_per_page'));
		
		if ($query->num_rows()==0)
			throw new Exception('Empty result', 1);
		else
			return array('result'=>$query->result_array(),'pagination'=>$this->pagination->create_links());		
	}
	
	function getGroups($newsletter_id=null){
		if(!$newsletter_id&&!$this->newsletter_id)
			throw new Exception('No input data', 0);
		if(!$newsletter_id)
			$newsletter_id=$this->newsletter_id;
		
		
		$query=$this->db->query('SELECT ng.group_id, 
										ng.title,
										ng.description
									FROM newsletters_groups ng
									INNER JOIN newsletters_groups_rel ngl ON ng.group_id=ngl.group_id
									INNER JOIN newsletters n ON n.newsletter_id=ngl.newsletter_id
									WHERE n.newsletter_id="'.$newsletter_id.'"');
//		$groups=array();
//		foreach($query->result_array() as $group)
//			$groups[]=$group['group_id'];
		return $query->result_array();
	}
	
	function getGroupsIds($newsletter_id){
		if(!$newsletter_id&&!$this->newsletter_id)
			throw new Exception('No input data', 0);

		$groups=$this->getGroups($newsletter_id);
		
		$groups_ids=array();
		foreach($groups as $group)
			$groups_ids[]=$group['group_id'];
		return $groups_ids;		
	}	
	
	function getAttachments($newsletter_id=null){
		if(!$newsletter_id&&!$this->newsletter_id)
			throw new Exception('No input data', 0);
		if(!$newsletter_id)
			$newsletter_id=$this->newsletter_id;

		$this->load->model('model_newsletters_attachments');
		try{
			$attachments=$this->model_newsletters_attachments->getList(array('newsletter_id'=>$newsletter_id));
			return $attachments;
		}catch(Exception $e){
			return array();
		}
	}
	
	function getAttrs(){
		$attrs=array();
		if($this->newsletter_id!==null) $attrs['newsletter_id']=$this->newsletter_id;
		if($this->template_id!==null) $attrs['template_id']=$this->template_id;
		if($this->subject!==null) $attrs['subject']=$this->subject;
		if($this->text_body!==null) $attrs['text_body']=$this->text_body;
		if($this->html_body!==null) $attrs['html_body']=$this->html_body;
		if($this->charset!==null) $attrs['charset']=$this->charset;
		if($this->status!==null) $attrs['status']=$this->status;
		if($this->created) $attrs['created']=$this->created;
		if($this->updated!==null) $attrs['updated']=$this->updated;
		
		if(!empty($attrs))
			return $attrs;
		else return false;
	}	
	
// ACTIONS

	function add($data){
		if(empty($data)||!is_array($data))
			throw new Exception('No input data', 0);
		$files_exist=false;
		$files=array();
		if(isset($data['attachment']))
			foreach($data['attachment']['name'] as $index=>$filename){
				if($filename=='') continue;
				
				$ext=strtolower(str_replace('.','',strrchr($filename, '.')));
				if($data['attachment']['size'][$index]>$this->config->item('attachment_max_size'))
					throw new Exception('Filesize is too big (file: "'.$filename.'")');
				
				$exts=explode('|',$this->config->item('attachment_allowed_exts'));
				if($ext!='')
					if(!in_array($ext, $exts))
						throw new Exception('Unacceptable file extension (file: "'.$filename.'")');
						
				if($data['attachment']['error'][$index]!=0)
					throw new Exception($data['attachment']['error'][$index].' (file: "'.$filename.'")');
					
				if(strlen($filename)>$this->config->item('attachment_max_filename_length'))
					throw new Exception('The filname is too long (file: "'.$filename.'")');				
						
				$files_exist=true;
				$files[]=array('name'=>$filename,
							   'type'=>$data['attachment']['type'][$index],
							   'tmp_name'=>$data['attachment']['tmp_name'][$index],
							   'error'=>$data['attachment']['error'][$index],
							   'size'=>$data['attachment']['size'][$index]);		
			}
		
		try{
			$this->setAttrs($data);
			$this->setStatus('new');
			$this->setCreated(date('Y-m-d H:i:s'));
			$this->setUpdated(date('Y-m-d H:i:s'));
		}catch(Exception $e){
			throw new Exception('Error setting attributes',3);
		}
		
		// adding at first data to newsletters table
		try{
			parent::add($this->getAttrs());
			$this->setId($this->db->insert_id());
			$data['newsletter_id']=$this->newsletter_id;
		}catch(Exception $e){
			throw new Exception('Error adding record', 10);
		}
		
		// secondly adding data to newsletters_groups_rel table
		if(is_array($data['group_id'])){
			try{
				$this->load->model('model_relations');
				$this->model_relations->setTable('newsletters_groups_rel');
				$this->model_relations->setRelations('newsletters','newsletters_groups');
				$this->model_relations->add($data['newsletter_id'],$data['group_id']);
			}catch(Exception $e){
				throw new Exception('Error setting relations',9);
			}
		}
		// thirdly adding data to newsletters_attachments table
		if($files_exist)
		try{
			$this->addAttachments($files);
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
		return true;
	}
	
	function edit($data){
		if(empty($data)||!is_array($data))
			throw new Exception('No input data', 0);
					
			$files_exist=false;
		$files=array();
		
		if(isset($data['attachment']))		
			foreach($data['attachment']['name'] as $index=>$filename){
				if($filename=='') continue;
				
				$ext=strtolower(str_replace('.','',strrchr($filename, '.')));
				if($data['attachment']['size'][$index]>$this->config->item('attachment_max_size'))
					throw new Exception('Filesize is too big (file: "'.$filename.'")');
				
				$exts=explode('|',$this->config->item('attachment_allowed_exts'));
				if($ext!='')
					if(!in_array($ext, $exts))
						throw new Exception('Unacceptable file extension (file: "'.$filename.'")');
						
				if($data['attachment']['error'][$index]!=0)
					throw new Exception($data['attachment']['error'][$index].' (file: "'.$filename.'")');
					
				if(strlen($filename)>$this->config->item('attachment_max_filename_length'))
					throw new Exception('The filname is too long (file: "'.$filename.'")');				
						
				$files_exist=true;
				$files[]=array('name'=>$filename,
							   'type'=>$data['attachment']['type'][$index],
							   'tmp_name'=>$data['attachment']['tmp_name'][$index],
							   'error'=>$data['attachment']['error'][$index],
							   'size'=>$data['attachment']['size'][$index]);		
			}

		try{
			$this->setAttrs($data);
			$this->setUpdated(date('Y-m-d H:i:s'));			
		}catch(Exception $e){
			throw new Exception('Error setting attributes',3);
		}
		try{
			parent::edit($this->getAttrs());
		}catch(Exception $e){
			throw new Exception('Error editing record', 6);
		}
		
		try{
			$this->load->model('model_relations');
			$this->model_relations->setTable('newsletters_groups_rel');
			$this->model_relations->setRelations('newsletters','newsletters_groups');
			$this->model_relations->edit($data['newsletter_id'],$data['group_id']);
		}catch(Exception $e){
			throw new Exception('Error setting relations',9);
		}
		
		if($files_exist)
		try{
			$this->addAttachments($files);
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
		return true;		
	}
	
	function addAttachments($files){
		if(!is_array($files)||empty($files))
			throw new Exception('No input data', 0);
		
		foreach($files as $file){
			$filename=$this->config->item('tmp_path').urlencode($file['name']);
			if(!move_uploaded_file($file['tmp_name'],$filename))
				throw new Exception('Error storing file("'.$file['name'].'")');
				
			$fp      = fopen($filename, 'r');
			$content = fread($fp, filesize($filename));
			$content = addslashes($content);
			fclose($fp);
			unlink($filename);
			
			$this->load->model('model_newsletters_attachments');

			$this->model_newsletters_attachments->setNewsletterId($this->newsletter_id);
			$this->model_newsletters_attachments->setFilename($file['name']);
			$this->model_newsletters_attachments->setFile($content);
			
			try{
				$this->model_newsletters_attachments->add($this->model_newsletters_attachments->getAttrs());
			}catch(Exception $e){
				throw new Exception($e->getMessage());
			}
		}
		
		return true;
	}
}