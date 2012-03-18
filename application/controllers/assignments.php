<?php
class assignments extends ci_Controller{
	
	function create_assignment(){
		$this->load->model('assignments_model');
		$this->assignments_model->create();
	}
	
	function reply(){
		$this->load->model('assignments_model');
		$this->assignments_model->reply();
	}
}
?>