<?php
class sessions extends ci_Controller{
	function create(){

		$this->load->model('sessions_model');
		$this->sessions_model->create();
	}
	
	function join(){
		$this->load->model('logs_model');
		$this->logs_model->lag(22, 'JS');
	}
}
?>