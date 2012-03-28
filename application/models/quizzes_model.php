<?php
class quizzes_model extends ci_Model{
	
	function list_all(){
		//quizzes that has expired can still be viewed but cannot be taken
		//quizzes can only be opened for the first time , once its viewed student shoud take the quiz
		//the second time the student views the quiz its only viewable but not answerable
		$class_id = $this->session->userdata('current_class');
		$query = $this->db->query("SELECT quiz_id, DATE(start_time) AS qz_date, qz_title, start_time, end_time 
								FROM tbl_quiz WHERE class_id='$class_id' AND status=1 ORDER BY qz_date DESC");
		
		$this->load->model('post');
		
		$quiz = array();
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$quiz_id	= $row->quiz_id;
				$qz_title	= $row->qz_title;
				$qz_date	= $row->qz_date;
				$start_time	= $row->start_time;
				$end_time	= $row->end_time;
				$student_status = $this->post->status('QZ'.$quiz_id);
				$teacher_status = $this->post->status('QR'.$quiz_id);
				
				$quiz[] = array('teacher_status'=>$teacher_status, 'student_status'=>$student_status, 'quiz_id'=>$quiz_id, 'title'=>$qz_title, 
								'date'=>$qz_date, 'start_time'=>$start_time, 'end_time'=>$end_time);
			}
		}
		return $quiz;
	}
	
	function create(){
		$class_id 	= $this->session->userdata('current_class');
		$quiz = $this->session->userdata('quiz');
					
		$title		= $quiz['title'];
		$body		= $quiz['body'];
		$start_time	= $quiz['start_time'];
		$end_time	= $quiz['end_time'];
		
		$quiz_data	= array($class_id, $title, $body, $start_time, $end_time);
		
		$create_quiz = $this->db->query("INSERT INTO tbl_quiz SET class_id=?, qz_title=?, qz_body=?, start_time=?, end_time=?, date_created=CURDATE()", $quiz_data);
		$quiz_id = $this->db->insert_id();
		
		//set quiz read status to students
		$this->load->model('post');
		$this->post->class_post('QZ'.$quiz_id , 4);
		
		
		//questions, choices, and answers
		$questions 	= $this->input->post('questions');
		$choiceA	= $this->input->post('a');
		$choiceB	= $this->input->post('b');
		$choiceC	= $this->input->post('c');
		$choiceD	= $this->input->post('d');
		$answers	= $this->input->post('answers');
		
		foreach($questions as $k=>$q){
			$q	= $q['value'];
			$a	= $choiceA[$k]['value'];
			$b	= $choiceB[$k]['value'];
			$c	= $choiceC[$k]['value'];
			$d	= $choiceD[$k]['value'];
			$ans= $answers[$k]['value'];
			
			$items_data	= array($quiz_id, $q, $a, $b, $c, $d, $ans);
			
			$create_items = $this->db->query("INSERT INTO tbl_quizitems SET quiz_id=?, question=?, A=?, B=?, C=?, D=?, answer=?", $items_data);
		}
		
	}
	
	function view(){//returns quiz details and quiz items
		$quiz_id = $this->session->userdata('current_id');
		$quiz['quiz'] = array();
		$quiz['quiz_items'] = array();
		
		$query = $this->db->query("SELECT qz_title, qz_body, date_created, DATE(start_time) AS quiz_date, start_time, end_time FROM tbl_quiz WHERE quiz_id='$quiz_id'");
		if($query->num_rows() > 0){
			$row 			= $query->row();
			$title			= $row->qz_title;
			$body			= $row->qz_body;
			$date_created	= $row->date_created;
			$quiz_date		= $row->quiz_date;
			$start_time		= $row->start_time;
			$end_time		= $row->end_time;
			
			$quiz['quiz']	= array('quiz_id'=>$quiz_id, 'title'=>$title, 'body'=>$body, 'date'=>$date_created, 
									'quiz_date'=>$quiz_date, 'start_time'=>$start_time, 'end_time'=>$end_time);
		
		}
		
		$quiz_items	= $this->db->query("SELECT * FROM tbl_quizitems WHERE quiz_id='$quiz_id'");
		if($quiz_items->num_rows() > 0){
			foreach($quiz_items->result() as $row){
				$question	= $row->question;
				$a			= $row->A;
				$b			= $row->B;
				$c			= $row->C;
				$d			= $row->D;
				$answer		= $row->answer;
				
				$quiz['quiz_items'][] = array('question'=>$question, 'a'=>$a, 'b'=>$b, 'c'=>$c, 'd'=>$d, 'answer'=>$answer);
			}
		}
	
		return $quiz;
	}
	
	function submit(){//for submitting answers for a particular quiz
		$user_id	= $this->session->userdata('user_id');
		$class_id	= $this->session->userdata('current_class');
		$quiz_id	= $this->session->userdata('current_id');
		
		$answers	= $this->input->post('answers');
		$score		= 0;
		
		//load answers
		$real_answers = array();//answers set by the teacher
		$load_answers = $this->db->query("SELECT answer FROM tbl_quizitems WHERE quiz_id='$quiz_id'");
		if($load_answers->num_rows() > 0){
			foreach($load_answers->result() as $row){
				$real_answers[] = $row->answer;
			}
		}
		
		//compare answers to students answer
		foreach($answers as $key=>$ans){
			$student_answer 	= $ans['value'];
			$real_answer		= $real_answers[$key];
			echo $student_answer .' '. $real_answer;
			if($student_answer == $real_answer){
				$score = $score + 1; 
			}
		}
		
		$query		= $this->db->query("INSERT INTO tbl_quizresult SET quiz_id='$quiz_id', class_id='$class_id', user_id='$user_id', score='$score'");
		$quizresponse_id = $this->db->insert_id();
		
		//fetch teacher for the current class
		$class_id 		= $this->session->userdata('current_class');
		$query			= $this->db->query("SELECT teacher_id FROM tbl_classteachers WHERE class_id='$class_id'");
		if($query->num_rows() > 0){
			$row = $query->row();
			$teacher_id = $row->teacher_id;
			
			//set response status to unread
			$this->load->model('post');
			$this->post->message_post('QR'.$quiz_id, 7, $teacher_id);
		}
		
	}
	
	function scores(){
		$quiz_results['details'] = array();
		$quiz_results['result'] = array();
		$quiz_id	= $this->session->userdata('current_id');
		$quiz = $this->db->query("SELECT qz_title, DATE(start_time) AS quiz_date FROM tbl_quiz WHERE quiz_id='$quiz_id'");
		if($quiz->num_rows() > 0){
			$row = $quiz->row();
			$quiz_title = $row->qz_title;
			$quiz_date	= $row->quiz_date;
		
			$quiz_results['details'] = array('title'=>$quiz_title, 'date'=>$quiz_date);
			
			$query 		= $this->db->query("SELECT quizresult_id, CONCAT_WS(', ', UPPER(lname), fname) AS student, score FROM tbl_quizresult 
											LEFT JOIN tbl_userinfo ON tbl_quizresult.user_id = tbl_userinfo.user_id
											WHERE quiz_id='$quiz_id'");
			
			$this->load->model('post');							
			
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$result_id	= $row->quizresult_id;
					$student	= $row->student;
					$score		= $row->score;
					
					$post_status = $this->post->status('QR'.$quiz_id);
					$quiz_results['result'][] = array('status'=>$post_status, 'student'=>$student, 'score'=>$score);
				}
			}
		}
		return $quiz_results;
	}

	function check(){//checks if the quiz can already be taken by the student
		$user_id = $this->session->userdata('user_id');
		$quiz_id = $this->session->userdata('current_id');
		$post_quiz_id = 'QZ'.$quiz_id;
		$not_taken	= 1;
		//checks if the student has already opened the quiz
		$query = $this->db->query("SELECT status FROM tbl_poststatus WHERE post_id='$post_quiz_id' AND post_to='$user_id' AND status = 1");
		$not_taken = $query->num_rows();
		
		
		//checks if the current time is within the range of start_time and end time of the selected quiz
		$query = $this->db->query("SELECT quiz_id FROM tbl_quiz WHERE quiz_id='$quiz_id' AND NOW() BETWEEN start_time AND end_time");
		if($query->num_rows() == 1 && $not_taken == 1){
			return 1;//can take the quiz
		}else{
			return 0;//cannot take the quiz
		}
	}
}
?>