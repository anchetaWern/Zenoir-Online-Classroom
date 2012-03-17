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
			
			case 'view_subjects':
				$this->load->model('classrooms_model');
				$data = $this->classrooms_model->select_classsubject();
				return $data;
			break;
			
			case 'view_courses':
				$this->load->model('classrooms_model');
				$data = $this->classrooms_model->select_classcourse();
				return $data;
			break;
			
			case 'view_user':
				$this->load->model('users');
				$user_info = $this->users->user_information();
				return $user_info;
			break;
			
			case 'add_people':
				$this->load->model('users');
				$users = $this->users->select_users();
				
				$this->load->model('classrooms_model');
				$class_code = $this->classrooms_model->select_coursecode();
				
				return array('users'=>$users, 'class_code'=>$class_code);
			break;
			
			
			case 'edit_subject':
				$this->load->model('subjects_model');
				$subject = $this->subjects_model->get_subject();
				return $subject;
			break;
			
			case 'edit_course':
				$this->load->model('courses_model');
				$course = $this->courses_model->get_course();
				return $course;
			break;
			
		}
	}
}
?>