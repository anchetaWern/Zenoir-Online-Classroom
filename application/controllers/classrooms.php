<?php
class classrooms extends ci_Controller{
	
	function create_class(){
	
		
		$this->classrooms_model->create_class();	
	}
	
	function add_people(){
		
		$this->classrooms_model->add_people();
	}
	
	function invites(){
		
		$this->classusers_model->invites();
	}
	
	function accept(){
		
		$this->classusers_model->accept();
	}
	
	function decline(){
		
		$this->classusers_model->decline();
	}
	
	function enable(){
		
		$this->classrooms_model->enable();
		
	}
	
	function disable(){
		
		$this->classrooms_model->disable();
	}
	
	function module_status(){
		
		$this->classrooms_model->module_status();
	}
	
	function export(){
		
		$this->classrooms_model->export();
	}
	
	function remove(){
		
		$this->classusers_model->remove();
	}
	
	function lock(){
		
		$this->classrooms_model->lock();
	}
	
	function unlock(){
		
		$this->classrooms_model->unlock();
	}
}
?>