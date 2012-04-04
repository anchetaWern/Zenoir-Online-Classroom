<?php
class notifs extends ci_Controller{
	/*
	function index(){
		$this->load->model('emailnotifs_model');
		$this->emailnotifs_model->build();
	}
	*/
	
	function change_status(){
		
		$this->load->model('emailnotifs_model');
		$this->emailnotifs_model->change_status();
	}
}
?>