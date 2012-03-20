<?php
class assignments extends ci_Controller{
	
	function create_assignment(){
		$this->load->model('logs_model');
		$this->logs_model->lag(9, 'AS');
	
		$this->load->model('assignments_model');
		$this->assignments_model->create();
	}
	
	function reply(){
		$this->load->model('logs_model');
		$this->logs_model->lag(12, 'AR');
	
		$this->load->model('assignments_model');
		$this->assignments_model->reply();
	}
}
?>