<?php
class Home extends CI_Controller{
	var $data=array('errors'=>array(),
					'message'=>'');
	function __construct(){
		parent::__construct();
		$this->load->model('model_subscribers');
		$this->load->model('model_settings');
		$this->load->library('form_validation');
		$this->model_settings->get();		
		$this->data['base_url']=base_url();	
	}
	function index(){
        header('Location: '.$this->data['base_url'].'index.php/admin/home');exit;
		if($this->input->post()){
			$this->form_validation->set_rules('name', 'Name', 'required|xss_clean|max_length=100');
			$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email|max_length=100');
			
			if(!$this->form_validation->run()){
				$this->data['subscriber']=$this->input->post();
				$this->load->view('subscription_form',$this->data);
			}else{
				try{
					$this->load->model('model_subscribers_groups');
					$data=$this->input->post();					
					$default_group=$this->model_subscribers_groups->getDefault();
					$data['group_id']=array($default_group['group_id']);
					if($this->config->item('send_activation_email')=='Yes'){
						$data['verification_code']=md5(rand(100000,999999));
						$data['status']='unverified';
					}else
						$data['status']='new';
					$this->model_subscribers->add($data);
					if($this->config->item('send_activation_email')=='Yes'){
						try{
							$this->model_subscribers->sendActivationEmail($data);
							$this->data['message']=' Please follow activation link sent to Your email to start subscription';
						}catch(Exception $e){
							$this->data['errors']=$e->getMessage();
							$this->data['subscriber']=$this->input->post();
							$this->load->view('subscription_form',$this->data);							
						}
					}
					$this->load->view('thank_you',$this->data);
				}catch(Exception $e){
					$this->data['errors']=$e->getMessage();
					$this->data['subscriber']=$this->input->post();
					$this->load->view('subscription_form',$this->data);					
				}
			}
		}else{
			$this->data['subscriber']['name']='';
			$this->data['subscriber']['email']='';
			$this->data['subscriber']['content_type']='html';
			$this->load->view('subscription_form',$this->data);
		}
	}
	
	function activate($verification_code){
		try{
			$subscriber=$this->model_subscribers->get('`verification_code`="'.$verification_code.'" AND `status`="unverified"');
			if(is_null($subscriber['subscriber_id']))
				$this->data['errors']='Error activating account';
			else{
				$this->model_subscribers->setStatus('new');
				try{
					$this->model_subscribers->edit($this->model_subscribers->getAttrs());
					$this->data['message']='Your subscriber account was successfully activated!';
				}catch(Exception $e){
					$this->data['errors']='Error activating account';
				}
			}
		}
		catch(Exception $e){
			$this->data['errors']='Error activating account';
		}
		
		$this->load->view('result',$this->data);
	}
	
	function unsubscribe($subscriber_id){
		if(!is_numeric($subscriber_id)){
			$this->data['errors']='Subscriber ID undefined';
			$this->load->view('result',$this->data);
			return false;
		}
		try{		
			$email=urldecode($this->uri->segment(4));
			try{
				$subscriber=$this->model_subscribers->get('`subscriber_id`="'.$subscriber_id.'" AND `email`="'.$email.'"');
			}catch(Exception $e){
				$this->data['errors']='Subscriber not found';
				$this->load->view('result',$this->data);
				return true;
			}
			$this->model_subscribers->setId($subscriber_id);
			$this->model_subscribers->setStatus('deleted');
			$this->model_subscribers->edit();
			$this->data['message']='Your account was successfully unsubscribed';
			$this->load->view('result',$this->data);
		}catch(Exception $e){
			$this->data['errors']=$e->getMessage();
			$this->load->view('result',$this->data);
		}
		
	}
}