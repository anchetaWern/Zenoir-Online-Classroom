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
				$this->load->model('classusers_model');
				$unread =  $this->classusers_model->unread_posts();
				return $unread;
			break;
		
			case 'subjects':
				$this->load->model('subjects_model');
				$subjects = $this->subjects_model->select_subjects();
				return $subjects;
			break;
			
			case 'land':
				$this->load->model('classusers_model');
				$class_users = $this->classusers_model->user_classes();
				return $class_users;
			break;
			
			case 'assignments':
				$this->load->model('assignments_model');
				$assignments = $this->assignments_model->list_all();
				return $assignments;
			break;
			
			case 'handouts':
				$this->load->model('handouts_model');
				$handouts = $this->handouts_model->list_all();
				return $handouts;
			break;
			
			case 'messages':
				$this->load->model('messages_model');
				$messages = $this->messages_model->messages();
				return $messages;
			break;
			
		}
	}

}
?>