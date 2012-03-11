<?php
class user_home extends ci_Controller{

	function __construct(){
		parent::__construct();
		$this->is_logged_in();
	}

	function index($page = 'site_index'){
		if (!file_exists('application/views/'.$page.'.php')){

			show_404();
		}
		
		$data['title'] = ucfirst($page); 

		$this->load->view('templates/header', $data);
		$this->load->view($page, $data);
	}
	
	function is_logged_in(){
		$logged_in = $this->session->userdata('logged_in');
		if(!isset($logged_in) || $logged_in != true){
			redirect('../loader/view/login_form');
		}
	}
	
	function destroy_userdata(){
		$this->session->sess_destroy();
	}
}
?>