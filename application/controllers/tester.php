<?php
class tester extends ci_Controller{
	function index(){
		
		print_r($this->messages_model->check_owner());
		
	}

}
?>