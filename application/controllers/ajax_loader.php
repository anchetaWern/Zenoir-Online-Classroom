<?php
class ajax_loader extends ci_Controller{
	function index(){

		$this->load->view('ajax/edit_account');
	}
	
	function view($page){
		$user_id = $this->session->userdata('user_id');
		
		$this->load->model('users');
		$data['user'] = $this->users->user_info($user_id);
		
		$data['page'] = $this->selector($page);
		
		$this->load->view('ajax/'.$page, $data);
	}
	
	function selector($page){
		switch($page){
			case 'new_class':
				$this->load->model('subjects_model');
				$subjects = $this->subjects_model->select_subjects();
				
				$this->load->model('users');
				$users = $this->users->select_users();
		
				$this->load->model('courses_model');
				$courses = $this->courses_model->select_courses();
				
				return array('subjects'=>$subjects, 'users'=>$users, 'courses'=>$courses);
			break;
			
			case 'view_classes':
				$this->load->model('classrooms_model');
				$data = $this->classrooms_model->select_classsubjectcourse('subject');
				return $data;
			break;
			
		}
	}
}
?>