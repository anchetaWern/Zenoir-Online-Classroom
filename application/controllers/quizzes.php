<?php
class quizzes extends ci_Controller{
	
	function cache(){//temporarily saves the quiz details into session
		$title		= $this->input->post('quiz_title'); 
		$body		= $this->input->post('quiz_body'); 	
		$start_time	= date('Y-m-d G:i:s', strtotime($this->input->post('start_time'))); 
		$end_time	= date('Y-m-d G:i:s', strtotime($this->input->post('end_time'))); 
		
		$quiz_data = array('title'=>$title,'body'=>$body,'start_time'=>$start_time, 'end_time'=>$end_time);
		
		$_SESSION['quiz'] = $quiz_data;
	}
	
	function create(){//create quiz with items
		$this->load->model('logs_model');
		$this->logs_model->lag(11, 'QZ');
	
		$this->load->model('quizzes_model');
		$this->quizzes_model->create();
	}
	
	function create_no(){//create a quiz with no items
		$this->load->model('logs_model');
		$this->logs_model->lag(11, 'QZ');
	
		$this->load->model('quizzes_model');
		$this->quizzes_model->create_no();
	}
	
	function submit(){//quiz with items/multiple choice quiz
		$this->load->model('logs_model');
		$this->logs_model->lag(13, 'QR');
	
		$this->load->model('quizzes_model');
		$this->quizzes_model->submit();
	}
	
	function reply(){//for essay type quiz or quiz without items
		$this->load->model('logs_model');
		$this->logs_model->lag(13, 'QR');
		
		$this->load->model('quizzes_model');
		$this->quizzes_model->reply();
	}



}
?>