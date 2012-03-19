<?php
class data_setter extends ci_Controller{
//this class is used to set the current id to the
//selected item in a table

	function sets(){//sets current id; primarily used to track id to be viewed or updated
		$value = $this->input->post('current_id');
		
		$this->session->unset_userdata('current_id');
		
		$this->session->set_userdata('current_id', $value);
		echo $this->session->userdata('current_id');
	}
	
	
	function set_class(){
		$class_id = $this->input->post('class_id');
		$this->session->unset_userdata('current_class');
		$this->session->set_userdata('current_class', $class_id);
		
		$this->load->model('classrooms_model');
		$classroom_info = $this->classrooms_model->select_classinfo();
		
		$this->session->set_userdata('classroom_info', $classroom_info);
		
		echo $this->session->userdata('current_class');
	}
	
	function set_message(){//sets a session of the message that the user has viewed
		$message_id = $this->input->post('msg_id');
		$this->session->set_userdata('msg_id', $message_id);
		
	}
}
?>