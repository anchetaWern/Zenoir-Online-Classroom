<?php
class notifs extends ci_Controller{
	
	
	function change_status(){
		
		
		$this->emailnotifs_model->change_status();
	}
}
?>