<?php
class usert extends ci_Controller{
	function update_user(){
		$this->load->model('users');
		$this->users->update_user();
	}
}
?>