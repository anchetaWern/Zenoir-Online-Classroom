<?php
class truncator extends ci_Controller{
	function index(){
		$this->load->model('truncator_model');
		$this->truncator_model->truncates();
	}
}
?>