<?php
class subjects extends ci_Controller{
	function create_subject(){
		$this->load->model('subjects_model');
		$this->subjects_model->create_subject();
	}
	
	function update_subject(){
		$this->load->model('subjects_model');
		$this->subjects_model->update_subject();
	}
	
}
?>