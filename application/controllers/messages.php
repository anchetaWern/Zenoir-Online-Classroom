<?php
class messages extends ci_Controller{

	function create(){
		$this->load->model('messages_model');
		$this->messages_model->create();
	}
	
	function reply(){
		$this->load->model('messages_model');
		$this->messages_model->reply();
	}
	
	function history(){
		$this->load->model('messages_model');
		$this->messages_model->history();
	}
}
?>