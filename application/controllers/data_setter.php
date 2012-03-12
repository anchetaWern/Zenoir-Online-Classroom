<?php
class data_setter extends ci_Controller{
//this class is used to set the current id to the
//selected item in a table

	function sets(){
		$value = $this->input->post('current_id');
		$this->session->set_userdata('current_id', $value);
		echo $this->session->userdata('current_id');
	}
}
?>