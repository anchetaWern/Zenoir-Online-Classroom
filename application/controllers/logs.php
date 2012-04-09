<?php
class logs extends ci_Controller{
	function log_act(){
		$activity_id= $this->input->post('act_id');
		$prefix		= $this->input->post('prefix');
		$this->load->model('logs_model');
		
		$this->logs_model->lag($activity_id, $prefix);
	}
}
?>