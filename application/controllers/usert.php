<?php
//main controller for the user
class usert extends ci_Controller{
	function update_user(){
		$this->load->model('users');
		$this->users->update_user();
	}
	
	function create_user(){
		$this->load->model('users');
		$this->users->create_user();
	}
}
?>