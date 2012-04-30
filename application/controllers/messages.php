<?php
class messages extends ci_Controller{

	function create(){
		
		$this->messages_model->create();
	}
	
	function reply(){
		
		$this->messages_model->reply();
	}
	
	function history(){
		
		$this->messages_model->history();
	}
}
?>