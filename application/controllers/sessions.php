<?php
class sessions extends ci_Controller{
	function create(){

		
		$this->sessions_model->create();
	}
	
	function join(){
		
		$this->logs_model->lag(22, 'JS');
	}
}
?>