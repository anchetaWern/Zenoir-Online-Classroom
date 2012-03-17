<?php
class handouts extends ci_Controller{
	function create(){
		$this->load->model('handouts_model');
		$this->handouts_model->create();
	}

}
?>