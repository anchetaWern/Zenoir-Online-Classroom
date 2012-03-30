<?php
class data_setter extends ci_Controller{
//this class is used to set the current id to the
//selected item in a table

	function sets(){//sets current id; primarily used to track id to be viewed or updated
		$value = $this->input->post('current_id');
		$_SESSION['current_id'] = $value;
	}
	
	function set_mask(){
		$masked_name = $this->input->post('masked_name');
		$_SESSION['user_name'] = $masked_name;
	}
	
	function set_name(){
		$this->load->model('users');
		$user_id = $this->session->userdata('user_id');
		$user_name = $this->users->user_name($user_id);
		$_SESSION['user_name']	= $user_name;
	}
	
	
	function set_class(){//sets the details for the class where the teacher or student entered
		$class_id = $this->input->post('class_id');
		
		$_SESSION['current_class'] = $class_id;
		
		$this->load->model('classrooms_model');
		$classroom_info = $this->classrooms_model->select_classinfo();
		
		$_SESSION['classroom_info'] = $classroom_info;
	}
	
	function set_message(){//sets a session of the message that the user has viewed
		$message_id = $this->input->post('msg_id');
		$_SESSION['msg_id'] = $message_id;
		
	}
	
	function set_sid(){//fix for assignment replies
		$_SESSION['sid'] = $this->input->post('sid');
	}
	
	function current_class(){
		return $_SESSION['current_class'];
	}
	
	function set_sessiontype(){//sets the session type whether masked, class, or team session
		/*
		session types:
		1-masked
		2-class
		3-team
		*/
		$session_type = $this->input->post('session_type');
		$_SESSION['session_type'] = $session_type;
	}
}
?>