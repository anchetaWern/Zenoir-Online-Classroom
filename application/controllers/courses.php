<?php
class courses extends ci_Controller{
	function create_course(){
		
		$this->courses_model->create_course();
	}
	
	function update_course(){
		
		$this->courses_model->update_course();
	}
}
?>