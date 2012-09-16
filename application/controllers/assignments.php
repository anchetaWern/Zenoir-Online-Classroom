<?php
class assignments extends ci_Controller{
	
	function create_assignment(){
		
		$this->logs_model->lag(9, 'AS');
	
		
		$this->assignments_model->create();
	}
	
	function reply($assignment_id){
		
		$this->logs_model->lag(12, 'AR');
	
		
		$this->assignments_model->reply($assignment_id);
	}
}
?>