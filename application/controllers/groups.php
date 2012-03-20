<?php
class groups extends ci_Controller{
	function create(){
		$this->load->model('groups_model');
		$this->groups_model->create();
	}
}
?>