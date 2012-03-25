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
				
				$datalist = $_GET['dl'];//1 if browser supports datalist; 2 if not
				
				return array('subjects'=>$subjects, 'users'=>$users, 'courses'=>$courses, 'datalist'=>$datalist);
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
				$this->load->model('post');
				$this->post->unset_post('PO');
			
				$this->load->model('messages_model');
				$message = $this->messages_model->view();
				
				$_SESSION['page']= $_SERVER['REQUEST_URI'];
				
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
				$this->load->model('post');
				$this->post->unset_post('HO');
				
				$this->load->model('logs_model');
				$this->logs_model->lag(6, 'HO');
			
				$this->load->model('handouts_model');
				$handout = $this->handouts_model->view();
				
				$_SESSION['page']= $_SERVER['REQUEST_URI'];
				return $handout;
			break;
			
			case 'view_assignment':
				$this->load->model('post');
				$this->post->unset_post('AS');
				
				$this->load->model('logs_model');
				$this->logs_model->lag(4, 'AS');
			
				$this->load->model('assignments_model');
				$assignment = $this->assignments_model->view();
				
				$_SESSION['page']= $_SERVER['REQUEST_URI'];
				return $assignment;
			break;
			
			case 'view_assignmentreply':
				$this->load->model('post');
				$this->post->unset_post('AR');
				
				$this->load->model('logs_model');
				$this->logs_model->lag(14, 'AR');
			
				$this->load->model('assignments_model');
				$assignment = $this->assignments_model->view_reply();
				
				$_SESSION['page']= $_SERVER['REQUEST_URI'];
				return $assignment;
			break;
			
			case 'assignment_reply':
				
				$this->load->model('assignments_model');
				$reply = $this->assignments_model->check();
				if($reply == 0){
					redirect('../ajax_loader/view/view_assignment');
				}
				$assignment = $this->assignments_model->reply_details();
				return $assignment;
			break;
			
			case 'list_assignmentreplies':
				$this->load->model('assignments_model');
				$assignment_reply = $this->assignments_model->list_replies();
				return $assignment_reply;
			break;
			
			case 'new_group':
				$this->load->model('classusers_model');
				$class_users = $this->classusers_model->class_users();
				return $class_users;
			break;
			
			case 'groups':
				$this->load->model('groups_model');
				$groups = $this->groups_model->list_all();
				return $groups;
			break;
			
			case 'new_classsession':
				$session_type = $this->session->userdata('session_type');
				$session['title'] = '';
				if($session_type == 1){//masked
					$session['title'] = 'Masked';
					
				}else if($session_type == 2){//class
					$session['title'] = 'Class';
				}else if($session_type == 3){//team session - load groups
					$session['title'] = 'Team';
					$this->load->model('groups_model');
					$session['groups'] =  $this->groups_model->list_all();
					
				}
				
				return $session;
			break;
			
			case 'join_session':
				$this->load->model('sessions_model');
				
				$session = $this->sessions_model->view($_GET['sesid']);
				return $session;
			break;		
			
			case 'user_logs':
				$user['user_info']	= array();
				$user['logs']	= array();
				
				$this->load->model('users');
				$user['user_info'] = $this->users->user_information();
			
				$this->load->model('classusers_model');
				$user['logs']	= $this->classusers_model->user_logs();
				
				return $user;
			break;
			
			case 'session':
				$this->load->model('sessions_model');
				$content = $this->sessions_model->content();
				return $content;
			break;
			
			case 'view_file':
				$this->load->model('files');
				$filedata = $this->files->data($_GET['fid']);
				return $filedata;
			break;
			
			case 'dl_file':
				$this->load->model('files');
				$filedata = $this->files->data($_GET['fid']);
				return $filedata;
			break;
		}
	}
}
?>