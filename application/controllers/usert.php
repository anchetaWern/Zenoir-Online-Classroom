<?php
//main controller for the user
class usert extends ci_Controller{
	function update_user(){
		
		$this->users->update_user();
	}
	
	function create_user(){
		
		$this->users->create_user();
	}
	
	function enable(){
		
		$this->users->enable();
	}
}
?>