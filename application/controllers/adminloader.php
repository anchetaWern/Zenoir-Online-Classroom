<?php
class adminloader extends ci_Controller{
	
	function __construct(){
		parent::__construct();
		$this->is_logged_in();
		$this->is_admin();
	}
	
	function view($page = 'admin_home'){
		if (!file_exists('application/views/'.$page.'.php')){
			show_404();
		}
		
		$data['title'] = ucfirst($page); 
		
		$this->load->view('templates/admin_header', $data);
		
		
		$data['table'] = $this->selector($page); //loads the list of data for the table
		
		$this->load->view($page, $data);
	}
	
	function is_logged_in(){//checks if a session is created
		$logged_in = $this->session->userdata('logged_in');
		if(!isset($logged_in) || $logged_in != true){
			redirect('../loader/view/login_form');
		}
	}
	
	function is_admin(){//checks if the user accessing the page is an admin
		$user_type = $this->session->userdata('usertype');
		if($user_type != 1){
			redirect('../class_loader/view/class_home');
		}
	}
	
	function destroy_userdata(){
		
		$this->users->logout();//sets log in status to 0
		$this->session->sess_destroy();
		redirect('../loader/view/login_form');
	}
	
	function selector($page){
		switch($page){
			case 'subjects':
				
				$subjects = $this->subjects_model->select_subjects();
				return $subjects;
			break;
			
			case 'users':
				
				$users = $this->users->select_users();
				return $users;
			break;
			
			case 'courses':
				
				$courses = $this->courses_model->select_courses();
				return $courses;
			break;
			
			case 'classes':
				
				$classes = $this->classrooms_model->select_classes();
				return $classes;
			break;
			
		}
	}
	
	
}
?>