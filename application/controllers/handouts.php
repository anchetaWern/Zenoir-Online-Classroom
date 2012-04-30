<?php
class handouts extends ci_Controller{
	function create(){
		
		$this->handouts_model->create();
	}

}
?>