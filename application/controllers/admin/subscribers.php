<?php
class Subscribers extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('model_subscribers');
		$this->load->model('model_subscribers_groups');
	}
	
	function index($group_id=null){
		if($this->uri->segment(4)=='reset'){
			$this->session->unset_userdata('search_subscribers');
			$this->session->unset_userdata('order');
		}elseif($this->uri->segment(4)=='order'){
			if($this->session->userdata('order')===false)
				$this->session->set_userdata('order',($this->uri->segment(5)=='title'?'sg.':'s.').$this->uri->segment(5).' ASC');
			elseif(strpos($this->session->userdata('order'),$this->uri->segment(5))>0){
				if(strpos($this->session->userdata('order'),'ASC')>0){
					$order=$this->session->userdata('order');
					$this->session->unset_userdata('order');
					$this->session->set_userdata('order',str_replace('ASC', 'DESC', $order));
				}
				elseif(strpos($this->session->userdata('order'),'DESC')>0){
					$order=$this->session->userdata('order');
					$this->session->unset_userdata('order');
					$this->session->set_userdata('order',str_replace('DESC', 'ASC', $order));
				}
			}
			else
				$this->session->set_userdata('order',($this->uri->segment(5)=='title'?'sg.':'s.').$this->uri->segment(5).' ASC');
		}
		
		if($this->session->userdata('order')!==false)
			$order=$this->session->userdata('order');
		else $order='';

//		if(($this->uri->segment(3)=='index'||!$this->uri->segment(3))&&$this->uri->segment(4)!='page')
//			$this->session->unset_userdata('search_subscribers');		
		try{
			if(is_numeric($group_id)){
				$subscribers_list=$this->model_subscribers->getList(array('sg.group_id'=>$group_id));
				
			}
			else{
				$this->data['subscribers_groups']=$this->model_subscribers_groups->getList();
				if($this->session->userdata('search_subscribers')!==false)					
					$subscribers_list=$this->model_subscribers->getPagedList('(s.name LIKE "%'.$this->session->userdata('search_subscribers').'%" 
																			  OR s.email LIKE "%'.$this->session->userdata('search_subscribers').'%")',
																			 is_numeric($this->uri->segment(5))?$this->uri->segment(5):0,
																			 $order);					
				else
					$subscribers_list=$this->model_subscribers->getPagedList(null,is_numeric($this->uri->segment(5))?$this->uri->segment(5):0,$order);
			}
		}catch(Exception $e){
            $this->data['errors']=array();
			$this->data['errors'][]=$e->getMessage();		
		}
		
		if(!empty($subscribers_list['result'])){
			$this->data['subscribers']=$subscribers_list['result'];
			$this->data['pagination']=$subscribers_list['pagination'];
		}
			
		$this->data['title']='Subscribers';
		$this->data['content']='subscribers';
		$this->load->view('admin/layout',$this->data);
	}
	
	function search($reset=null){
		if($reset=='reset')
			$this->session->unset_userdata('search_subscribers');
		if($this->input->post()!==false){
			$this->form_validation->set_rules('search', 'Search', 'xss_clean|max_length=50');
			if($this->form_validation->run() == FALSE){
				$this->data['errors']='Error';
				$this->index();
			}else{
				if($this->session->userdata('search_subscribers')!==false)
					$this->session->unset_userdata('search_subscribers');
				
				$this->session->set_userdata('search_subscribers',$this->input->post('search'));
				$this->index();				
			}
		}
		else $this->index();
	}
	
	function showDetails(){
			if(!is_numeric($this->uri->segment(4))){
			$this->data['errors']='No ID given';
			$this->index();
			return true;			
		}		
		$this->data['subscriber']=$this->model_subscribers->get(array('subscriber_id'=>$this->uri->segment(4)));
		$this->data['subscriber']['groups']=$this->model_subscribers->getGroups($this->uri->segment(4));
		$this->data['title']='Subscriber Details';
		$this->data['content']='subscriber_details';
		$this->load->view('admin/layout',$this->data);
	
	}	
	
	function add(){
		if($this->input->post()!==false){
			$this->form_validation->set_rules('name', 'Name', 'required|xss_clean|max_length=50');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean|max_length=50');
			if($this->form_validation->run() == FALSE){
				$this->getFormData();
				$this->data['groups']=$this->model_subscribers_groups->getList();
				$this->data['title']='Add subscriber';
				$this->data['form_action']='add';
				$this->data['content']='subscriber_form';
				$this->load->view('admin/layout',$this->data);				
			}else{
				try{
					$data=$this->input->post();
					if(empty($data['group_id'])){
						$default_group=$this->model_subscribers_groups->getDefault();
						$data['group_id'][0]=$default_group['group_id']; // [0] because actually it is array of groups
					}	
					$this->model_subscribers->add($data);
					$this->data['message']='Subscriber was successfully added';
					$this->index();			
				}catch(Exception $e){
					$this->data['errors']=$e->getMessage();
					$this->data['form_action']='add';
					$this->data['content']='subscriber_form';
					$this->data['title']='Add subscriber';
					$this->load->view('admin/layout',$this->data);
				}
			}
		}else{
			try{
			
				$this->data['groups']=$this->model_subscribers_groups->getList();
				$this->data['subscriber']=$this->model_subscribers->get(); // getting empty data, to avoid problems in view
				if(!is_numeric($this->uri->segment(5))){
					$default_group=$this->model_subscribers_groups->getDefault();
					$this->data['subscriber']['groups'][0]=$default_group['group_id']; // [0] because actually it is array of groups
				}
				else
					$this->data['subscriber']['groups']=array($this->uri->segment(5));
				$this->data['title']='Add subscriber';		
			}catch(Exception $e){
				$this->data['errors']=$e->getMessage();
			}
			$this->data['form_action']='add';
			$this->data['content']='subscriber_form';
			$this->load->view('admin/layout',$this->data);
		}		
	}
	
	function edit(){
		if(!is_numeric($this->uri->segment(4))){
			$this->data['errors']='Subscriber ID undefined';
			$this->index();
			return false;
		}

		if($this->input->post()!==false){
			$this->form_validation->set_rules('name', 'Name', 'required|xss_clean|max_length=50');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean|max_length=50');			
			if($this->form_validation->run() == FALSE){
				$this->getFormData();
				$this->data['groups']=$this->model_subscribers_groups->getList();
				$this->data['title']='Edit subscriber';
				$this->data['form_action']='edit/'.$this->uri->segment(4);
				$this->data['content']='subscriber_form';
				$this->load->view('admin/layout',$this->data);				
			}else{
				try{
					$data=$this->input->post();
					if(empty($data['group_id'])){
						$default_group=$this->model_subscribers_groups->getDefault();
						$data['group_id'][0]=$default_group['group_id']; // [0] because actually it is array of groups
					}						
					$data['subscriber_id']=$this->uri->segment(4);
					$this->model_subscribers->edit($data);
					$this->data['message']='Subscriber data was successfully changed';
					$this->index();			
				}catch(Exception $e){
					$this->data['errors']=$e->getMessage();
					$this->data['form_action']='edit/'.$this->uri->segment(4);
					$this->data['content']='subscriber_form';
					$this->data['title']='Edit subscriber';
					$this->load->view('admin/layout',$this->data);
				}
			}
		}else{
			try{
				$this->data['groups']=$this->model_subscribers_groups->getList();
				$this->data['subscriber']=$this->model_subscribers->get(array('subscriber_id'=>$this->uri->segment(4)));
				$this->data['subscriber']['groups']=$this->model_subscribers->getGroupsIds($this->uri->segment(4));
				$this->data['title']='Edit subscriber';				
			}catch(Exception $e){
				$this->data['errors']=$e->getMessage();
			}
			$this->data['form_action']='edit/'.$this->uri->segment(4);
			$this->data['content']='subscriber_form';
			$this->load->view('admin/layout',$this->data);
		}
	}
	
	function delete(){
		if(!is_numeric($this->uri->segment(4))&&$this->input->post('subscriber_id')===false){
			$this->data['errors']='Subscriber(s) ID(s) undefined';
			$this->index();
			return false;
		}elseif(is_numeric($this->uri->segment(4)))
			$subscriber_id=$this->uri->segment(4);
		else 
			$subscriber_id=$this->input->post('subscriber_id');

		try{
			$this->model_subscribers->delete($subscriber_id);
			$this->data['message']='Subscriber(s) was(were) successfully deleted';
			$this->index();
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
	}
	
	function deleteForever(){
		if(!is_numeric($this->uri->segment(4))&&$this->input->post('subscriber_id')===false){
			$this->data['errors']='Subscriber(s) ID(s) undefined';
			$this->index();
			return false;
		}elseif(is_numeric($this->uri->segment(4)))
			$subscriber_id=$this->uri->segment(4);
		else 
			$subscriber_id=$this->input->post('subscriber_id');

		try{
			$this->model_subscribers->deleteForever($subscriber_id);
			$this->data['message']='Subscriber(s) was(were) successfully removed';
			$this->index();
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
	}	
	
	function setGroup(){
		$subscribers_ids=$this->input->post('subscriber_id');
		if(empty($subscribers_ids)){
			$this->data['errors']='Subscriber IDs undefined';
			$this->index();
			return false;			
		}
		
		try{
			$this->model_subscribers->setGroup($this->input->post());
			$this->data['message']='Subscriber(s) were successfully move to another group';			
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
		$this->index();
	}
	
	function copyToGroup(){
		$subscribers_ids=$this->input->post('subscriber_id');
		if(empty($subscribers_ids)){
			$this->data['errors']='Subscriber IDs undefined';
			$this->index();
			return false;			
		}
		
		try{
			$this->model_subscribers->addGroup($this->input->post());
			$this->data['message']='Subscriber(s) were successfully copied to another group';			
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}
		$this->index();
	}	
	
	function activate(){
			if(!is_numeric($this->uri->segment(4))){
			$this->data['errors']='Subscriber ID undefined';
			$this->index();
			return false;
		}

		try{
			$this->model_subscribers->activate($this->uri->segment(4));
			$this->data['message']='Subscriber was successfully activated';
			$this->index();
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
		}		
	}
	
	function export(){
		if($this->input->post()===false){
			$this->data['errors']='Subscriber IDs undefined';
			$this->index();
			return false;			
		}
		try{
			$ids=$this->input->post('subscriber_id');
			$this->model_subscribers->export($ids);
			$this->output->set_header("Content-type: application/vnd.ms-excel; charset=utf-8; header=present");
			$this->output->set_header("Content-Disposition: attachment; filename=\"export.csv\"");
			echo file_get_contents($this->config->item('tmp_path').'export.csv');		
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
			$this->index();
		}
	}
	
	function import(){
		if(!empty($_FILES)){
			$this->form_validation->set_rules('submit','Submit','callback_do_import');
			if ($this->form_validation->run() == FALSE){
				$this->data['title']='Import subscribers (CSV format)';
				$this->data['content']='subscribers_import_form';
				$this->load->view('admin/layout',$this->data);
			}else{
				$this->data['message']='Subscribers were successfully imported';
				$this->index();
			}
		}
		else{
			$this->data['title']='Import subscribers (CSV format)';
			$this->data['content']='subscribers_import_form';
			$this->load->view('admin/layout',$this->data);
		}				
	}
	
	public function do_import($str){
		try{
			$this->model_subscribers->import();
			return true;
		}catch (Exception $e){
			$this->form_validation->set_message('do_import', $e->getMessage());
			return false;
		}
	}
	
	private function getFormData(){
		if($this->input->post()===false) return false;
		$data=$this->input->post();
		$this->data['subscriber']['subscriber_id']=$this->uri->segment(4);
		$this->data['subscriber']['name']=$data['name'];
		$this->data['subscriber']['email']=$data['email'];
		$this->data['subscriber']['content_type']=$data['content_type'];
		$this->data['subscriber']['groups']=isset($data['group_id'])?$data['group_id']:array();;
		$this->data['subscriber']['status']=$data['status'];
		$this->model_subscribers->setAttrs($this->data['subscriber']);
	}
}