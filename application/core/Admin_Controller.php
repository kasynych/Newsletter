<?php
class Admin_Controller extends CI_Controller{
	var $data=array('errors'=>array(),
					'message'=>'');
		
	function __construct(){
		parent::__construct();
		error_reporting(E_ERROR | E_WARNING);
		$this->load->model('model_admin');
		if(!$this->model_admin->logged_in()&&($this->uri->segment(3)==''||$this->uri->segment(3)=='index'))
			$this->output->set_header('Location: '.base_url().'index.php/admin/home/login');
		
		$this->load->library('form_validation');
		$this->load->model('model_settings');
		try{
			$this->load->model('model_sites');
		}catch(Exception $e){}
		$this->data['base_url']=base_url();
		$this->model_settings->get();
		if($this->session->userdata('site_id')===false){
			$site=$this->model_sites->get('site_id="'.$this->uri->segment(4).'"');
			$this->session->set_userdata('site_id',$site['site_id']);
		}elseif($this->uri->segment(2)=='home'&&is_numeric($this->uri->segment(4))){
			$this->session->unset_userdata('site_id');
			try{
				$site=$this->model_sites->get('site_id="'.$this->uri->segment(4).'"');
			}catch(Exception $e){throw new exception('Site ID is wrong');}
			$this->session->set_userdata('site_id',$site['site_id']);
		}

		$site=$this->model_sites->get('site_id="'.$this->session->userdata('site_id').'"');

		$this->data['site_title']=$site['title'];
	}
}