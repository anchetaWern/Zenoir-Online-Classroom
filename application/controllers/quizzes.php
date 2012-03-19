<?php
class quizzes extends ci_Controller{
	
	function cache(){//temporarily saves the quiz details into session
		$title		= $this->input->post('quiz_title'); 
		$body		= $this->input->post('quiz_body'); 	
		$start_time	= date('Y-m-d G:i:s', strtotime($this->input->post('start_time'))); 
		$end_time	= date('Y-m-d G:i:s', strtotime($this->input->post('end_time'))); 
		
		$quiz_data = array('title'=>$title,'body'=>$body,'start_time'=>$start_time, 'end_time'=>$end_time);
		
		$this->session->set_userdata('quiz', $quiz_data);
	}
	
	function create(){
		$this->load->model('quizzes_model');
		$this->quizzes_model->create();
	}
	
	function submit(){
		$this->load->model('quizzes_model');
		$this->quizzes_model->submit();
	}	

}
?>