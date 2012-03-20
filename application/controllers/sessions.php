<?php
class sessions extends ci_Controller{
	function create(){

		$this->load->model('sessions_model');
		$this->sessions_model->create();
	}

}
?>