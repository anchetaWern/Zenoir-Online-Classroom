<?php
class classrooms extends ci_Controller{
	
	function create_class(){
	
		$this->load->model('classrooms_model');
		$this->classrooms_model->create_class();	
	}
}
?>