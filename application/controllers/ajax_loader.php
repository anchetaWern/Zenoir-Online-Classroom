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
			
			case 'new_message':
				$this->load->model('classusers_model');
				$class_users = $this->classusers_model->class_users();
				return $class_users;
			break;
			
			case 'view_message':
				$this->load->model('messages_model');
				$message = $this->messages_model->view();
				return $message;
			break;
			
			
			case 'reply':
				$this->load->model('messages_model');
				$reply_details = $this->messages_model->reply_details();
				return $reply_details;
			break;
			
			case 'msg_history':
				$this->load->model('messages_model');
				$history = $this->messages_model->history();
				return $history;
			break;
			
			case 'view_handout':
				$this->load->model('handouts_model');
				$handout = $this->handouts_model->view();
				return $handout;
			break;
			
			case 'view_assignment':
				$this->load->model('assignments_model');
				$assignment = $this->assignments_model->view();
				return $assignment;
			break;
			
			case 'view_assignmentreply':
				$this->load->model('assignments_model');
				$assignment = $this->assignments_model->view_reply();
				return $assignment;
			break;
			
			case 'assignment_reply':
				$this->load->model('assignments_model');
				$assignment = $this->assignments_model->reply_details();
				return $assignment;
			break;
			
			case 'list_assignmentreplies':
				$this->load->model('assignments_model');
				$assignment_reply = $this->assignments_model->list_replies();
				return $assignment_reply;
			break;
			
		}
	}
}
?>