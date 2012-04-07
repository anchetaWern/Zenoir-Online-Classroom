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
	
	function access($user_type, $strict){//returns true of the current user can access the page, 
		//if this returns false user will be redirected to login page
		//because links are already hidden if users does not have the privilege
		//its most likely that the user is malicious if the user type validation springs into action
		//thats why the user is redirected to login page
		$current_type = $this->session->userdata('usertype');
		$ret = false;
		/*
		user types:
		1-admin
		2-teacher
		3-student
		1-strict - the specified usertype is the only one who can access it
		0-non-strict - users who are higher than the specified user type can also access it
		*/
		if($strict == 0){
			if($current_type <= $user_type){
				$ret = true;
			}
		}else if($strict == 1){
			if($current_type == $user_type){
				$ret = true;
			}
		}
		return $ret;
	}
	

	
	function destroy_userdata(){
		$this->load->model('users');
		$this->users->logout();//sets log in status to 0
		$this->session->sess_destroy();
		session_destroy();
		redirect('../loader/view/login_form');
	}
	
	function selector($page){
		$_SESSION['user_page'] = $_SERVER["REQUEST_URI"];
		switch($page){
			case 'class_home':
				//load class info - number of unread stuff, etc.
				$this->load->model('post');
				$this->load->model('sessions_model');
				$unread['posts'] =  $this->post->unread_posts();
				$unread['sessions'] = $this->sessions_model->session_count(); 
				return $unread;
			break;
		
			case 'subjects'://admin only
				if($this->access(1, 1) == false){
					redirect('../loader/view/login_form');
				}
				$this->load->model('subjects_model');
				$subjects = $this->subjects_model->select_subjects();
				return $subjects;
			break;
			
			case 'land'://teacher + student
				$user['classes'] = array();
				$user['invites'] = array();
				$user['grp_invites'] = array();
				$user['unreads'] = array();
				$this->load->model('classusers_model');
				$this->load->model('users');
				
				
				$user['classes'] 	= $this->classusers_model->user_classes();
				$user['people']		= $this->users->people();
				$user['old_classes']= $this->classusers_model->user_oldclasses();
				$user['invites']	= $this->classusers_model->list_invites();//count
				$user['grp_invites']= $this->classusers_model->list_groupinvites();//count
				$user['expired']	= $this->classusers_model->expired_classes();
				$user['unreads']	= $this->users->unread_post();//count
				
				return $user;
			break;
			
			case 'assignments'://teacher + student
				$this->load->model('classrooms_model');
				if($this->classrooms_model->module_status(1) == 0){
					redirect('../class_loader/view/class_home');
				}
			
				$this->load->model('assignments_model');
				$assignments = $this->assignments_model->list_all();
				return $assignments;
			break;
			
			case 'handouts'://teacher + student
				$this->load->model('classrooms_model');
				if($this->classrooms_model->module_status(3) == 0){
					redirect('../class_loader/view/class_home');
				}
			
				$this->load->model('handouts_model');
				$handouts = $this->handouts_model->list_all();
				return $handouts;
			break;
			
			case 'messages'://teacher + student
				$this->load->model('classrooms_model');
				if($this->classrooms_model->module_status(4) == 0){
					redirect('../class_loader/view/class_home');
				}
			
				$this->load->model('messages_model');
				$messages = $this->messages_model->messages();
				return $messages;
			break;
			
			case 'quizzes'://teacher + student
				$this->load->model('classrooms_model');
				if($this->classrooms_model->module_status(2) == 0){
					redirect('../class_loader/view/class_home');
				}
			
				$this->load->model('quizzes_model');
				$quizzes = $this->quizzes_model->list_all();
				return $quizzes;
			break;
			
			case 'view_quiz'://teacher
				if($this->access(2, 1) == false){
					redirect('../loader/view/login_form');
				}
				$this->load->model('logs_model');
				$this->logs_model->lag(5, 'QZ');
			
				$this->load->model('quizzes_model');
				$quiz = $this->quizzes_model->view();
				return $quiz;
			break;
			
			case 'take_quiz'://student
				if($this->access(3, 1) == false){
					redirect('../loader/view/login_form');
				}
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
			
			case 'view_scores'://teacher
				if($this->access(2, 1) == false){
					redirect('../loader/view/login_form');
				}
				$this->load->model('post');
				$this->post->unset_all('QR');
			
				$this->load->model('quizzes_model');
				$scores = $this->quizzes_model->scores();
				return $scores;
			break;
			
			case 'sessions'://teacher + student
				$this->load->model('classrooms_model');
				if($this->classrooms_model->module_status(5) == 0){
					redirect('../class_loader/view/class_home');
				}
			
				$this->load->model('sessions_model');
				$sessions = $this->sessions_model->list_all();
				return $sessions;
			break;
			
			case 'reports'://teacher
				
				if($this->session->userdata('usertype') == 3){
					redirect('../class_loader/view/class_home');
				}
				$this->load->model('classusers_model');
				$students = $this->classusers_model->class_users();
				
				return $students;
			break;
			
			case 'teachers'://teacher
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
				
				//email notifs events
				$this->load->model('emailnotifs_model');
				$classes['events'] = $this->emailnotifs_model->list_events();
				
				//exports
				$classes['exports'] = $this->classusers_model->user_classes(); 
				return $classes;
			break;
			
			
			case 'session'://teacher + student
				if($this->access(3, 0) == false){
					redirect('../loader/view/login_form');
				}
				$this->load->model('sessions_model');
				$join 	 = $this->sessions_model->check($_GET['sid']);
				if($join == 0){
					
					redirect("../class_loader/view/sessions");
				}
				$user_id = $this->session->userdata('user_id');
				$_SESSION['user_id']		= $user_id;
				$_SESSION['session_id']		= $_GET['sid'];
				$_SESSION['user_name']		= $this->session->userdata('user_name');
			break;
			
			case 'view_noquiz':
				$this->load->model('post');
				$this->load->model('quizzes_model');
				$quiz['students'] = $this->post->no_quiz();
				$quiz['details'] = $this->quizzes_model->quiz_details($_SESSION['current_id']);
				return $quiz;
			break;
			
			case 'view_noquizresponse':
				$this->load->model('post');
				$this->load->model('quizzes_model');
				$quiz['students'] = $this->post->no_quizresponse();
				$quiz['details'] = $this->quizzes_model->quiz_details($_SESSION['current_id']);
				return $quiz;
			break;
			
			case 'list_quizreplies':
				$this->load->model('quizzes_model');
				$replies = $this->quizzes_model->list_replies();
				return $replies;
			break;
			
			case 'view_quizreply':
				$this->load->model('quizzes_model');
				$reply = $this->quizzes_model->view_reply();
				return $reply;
			break;
			
		}
	}

}
?>