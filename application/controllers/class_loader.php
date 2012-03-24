<?php
class class_loader extends ci_Controller{

	function __construct(){
		parent::__construct();
		$this->is_logged_in();
	}
	
	function view($page = 'class_home'){
		if (!file_exists('application/views/'.$page.'.php')){
			show_404();
		}
		
		$data['title'] = ucfirst($page); 
		
		$this->load->view('templates/class_header', $data);
		
		$data['table'] = $this->selector($page); //loads the list of data for the table
		
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
		redirect('../loader/view/login_form');
	}
	
	function selector($page){
		switch($page){
			case 'class_home':
				//load class info - number of unread stuff, etc.
				$this->load->model('post');
				$unread =  $this->post->unread_posts();
				return $unread;
			break;
		
			case 'subjects':
				$this->load->model('subjects_model');
				$subjects = $this->subjects_model->select_subjects();
				return $subjects;
			break;
			
			case 'land':
				$user['classes'] = array();
				$user['invites'] = array();
				$user['unreads'] = array();
				$this->load->model('classusers_model');
				$this->load->model('users');
				
				$user['classes'] 	= $this->classusers_model->user_classes();
				$user['old_classes']= $this->classusers_model->user_oldclasses();
				$user['invites']	= $this->classusers_model->list_invites();
				$user['unreads']	= $this->users->unread_post();
				
				return $user;
			break;
			
			case 'assignments':
				$this->load->model('classrooms_model');
				if($this->classrooms_model->module_status(1) == 0){
					redirect('../class_loader/view/class_home');
				}
			
				$this->load->model('assignments_model');
				$assignments = $this->assignments_model->list_all();
				return $assignments;
			break;
			
			case 'handouts':
				$this->load->model('classrooms_model');
				if($this->classrooms_model->module_status(3) == 0){
					redirect('../class_loader/view/class_home');
				}
			
				$this->load->model('handouts_model');
				$handouts = $this->handouts_model->list_all();
				return $handouts;
			break;
			
			case 'messages':
				$this->load->model('classrooms_model');
				if($this->classrooms_model->module_status(4) == 0){
					redirect('../class_loader/view/class_home');
				}
			
				$this->load->model('messages_model');
				$messages = $this->messages_model->messages();
				return $messages;
			break;
			
			case 'quizzes':
				$this->load->model('classrooms_model');
				if($this->classrooms_model->module_status(2) == 0){
					redirect('../class_loader/view/class_home');
				}
			
				$this->load->model('quizzes_model');
				$quizzes = $this->quizzes_model->list_all();
				return $quizzes;
			break;
			
			case 'view_quiz':
				$this->load->model('logs_model');
				$this->logs_model->lag(5, 'QZ');
			
				$this->load->model('quizzes_model');
				$quiz = $this->quizzes_model->view();
				return $quiz;
			break;
			
			case 'take_quiz':
				$this->load->model('quizzes_model');
				$take = $this->quizzes_model->check();
				if($take == 0){
					redirect('../class_loader/view/quizzes');
				}
				
				$this->load->model('post');
				$this->post->unset_post('QZ');
				
				$this->load->model('logs_model');
				$this->logs_model->lag(16, 'QZ');
			
				
				$quiz = $this->quizzes_model->view();
				return $quiz;
			break;
			
			case 'view_scores':
				$this->load->model('post');
				$this->post->unset_all('QR');
			
				$this->load->model('quizzes_model');
				$scores = $this->quizzes_model->scores();
				return $scores;
			break;
			
			case 'sessions':
				$this->load->model('classrooms_model');
				if($this->classrooms_model->module_status(5) == 0){
					redirect('../class_loader/view/class_home');
				}
			
				$this->load->model('sessions_model');
				$sessions = $this->sessions_model->list_all();
				return $sessions;
			break;
			
			case 'reports':
				if($this->session->userdata('usertype') == 3){
					redirect('../class_loader/view/class_home');
				}
				$this->load->model('classusers_model');
				$students = $this->classusers_model->class_users();
				return $students;
			break;
			
			case 'teachers':
				//invited students
				if($this->session->userdata('usertype') == 3){
					redirect('../class_loader/view/class_home');
				}
				$classes['invited'] = array();
				$classes['modules'] = array();
				$this->load->model('classusers_model');
				$classes['invited'] = $this->classusers_model->list_invited_students();
				
				//remove students
				$classes['remove'] = $this->classusers_model->class_users();
				
				//modules
				$this->load->model('classrooms_model');
				$classes['modules'] = $this->classrooms_model->class_modules();
				
				//exports
				$classes['exports'] = $this->classusers_model->user_classes(); 
				return $classes;
			break;
			
			
			case 'session':
				
				$user_id = $this->session->userdata('user_id');
				$_SESSION['user_id']		= $user_id;
				$_SESSION['session_id']		= $_GET['sid'];
			break;
			
		}
	}

}
?>