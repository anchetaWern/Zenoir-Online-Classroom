<?php
class classrooms extends ci_Controller{
	
	function create_class(){
	
		$this->load->model('classrooms_model');
		$this->classrooms_model->create_class();	
	}
	
	function add_people(){
		$this->load->model('classrooms_model');
		$this->classrooms_model->add_people();
	}
	
	function invites(){
		$this->load->model('classusers_model');
		$this->classusers_model->invites();
	}
	
	function accept(){
		$this->load->model('classusers_model');
		$this->classusers_model->accept();
	}
	
	function decline(){
		$this->load->model('classusers_model');
		$this->classusers_model->decline();
	}
	
	function enable(){
		$this->load->model('classrooms_model');
		$this->classrooms_model->enable();
		
	}
	
	function disable(){
		$this->load->model('classrooms_model');
		$this->classrooms_model->disable();
	}
	
	function module_status(){
		$this->load->model('classrooms_model');
		$this->classrooms_model->module_status();
	}
	
	function export(){
		$this->load->model('classrooms_model');
		$this->classrooms_model->export();
	}
	
	function remove(){
		$this->load->model('classusers_model');
		$this->classusers_model->remove();
	}
}
?>