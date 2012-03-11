<?php
class ajax_loader extends ci_Controller{
	function index(){

		$this->load->view('ajax/edit_account');
	}
	
	function view($page){
		$user_id = $this->session->userdata('user_id');
		$this->load->model('users');
		$user_data = $this->users->user_info($user_id);
		$this->load->view('ajax/edit_account', $user_data);
	}
}
?>