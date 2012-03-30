<?php
error_reporting(0);
class Test extends CI_Controller{
	function index(){
		$this->load->library('email');
		$config['mailtype']='html';
		$this->email->initialize($config);
		
		$this->email->from('noreply@eveisk.ru', 'Maxim');
		$this->email->to('maxim.botezatu3@gmail.com');   
		
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class with image.<img src="test.png" />');
		$this->email->attach('application/images/test.png');
		$this->email->send();
		
		echo $this->email->print_debugger();
	}
}