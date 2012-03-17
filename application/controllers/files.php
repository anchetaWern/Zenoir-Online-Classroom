<?php
class files extends ci_Controller{
	function create(){
		$this->load->model('files_model');
		$this->files_model->create();
	}
}
?>