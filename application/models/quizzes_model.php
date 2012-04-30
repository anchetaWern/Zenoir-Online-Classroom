<?php
class quizzes_model extends ci_Model{
	
	function list_all(){
		//quizzes that has expired can still be viewed but cannot be taken
		//quizzes can only be opened for the first time , once its viewed student shoud take the quiz
		//the second time the student views the quiz its only viewable but not answerable
		$class_id = $_SESSION['current_class'];
		$query = $this->db->query("SELECT quiz_id, qz_type, DATE(start_time) AS qz_date, qz_title, start_time, end_time 
								FROM tbl_quiz WHERE class_id='$class_id' AND status=1 ORDER BY qz_date DESC");
		
		
		
		$quiz = array();
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$quiz_id	= $row->quiz_id;
				$quiz_type	= $row->qz_type;
				$qz_title	= $row->qz_title;
				$qz_date	= $row->qz_date;
				$start_time	= $row->start_time;
				$end_time	= $row->end_time;
				$student_status = $this->post->status('QZ'.$quiz_id);
				$teacher_status = $this->post->status('QR'.$quiz_id);
				$stat		= $this->check($quiz_id);
				
				$quiz[] = array('type'=>$quiz_type, 'stat'=>$stat,'teacher_status'=>$teacher_status, 'student_status'=>$student_status, 'quiz_id'=>$quiz_id, 'title'=>$qz_title, 
								'date'=>$qz_date, 'start_time'=>$start_time, 'end_time'=>$end_time);
			}
		}
		return $quiz;
	}
	
	
	function create_no(){
		$user_name		= $this->session->userdata('user_name');
	
		$class_id 	= $_SESSION['current_class'];
		
					
		$title		= $this->input->post('quiz_title');
		$body		= $this->input->post('quiz_body');
		$start_time	= date('Y-m-d G:i:s', strtotime($this->input->post('start_time'))); 
		$end_time	= date('Y-m-d G:i:s', strtotime($this->input->post('end_time'))); 
		
		$quiz_data	= array($class_id, 2,  $title, $body, $start_time, $end_time);
		
		$create_quiz = $this->db->query("INSERT INTO tbl_quiz SET class_id=?, qz_type=?, qz_title=?, qz_body=?, start_time=?, end_time=?, date_created=CURDATE()", $quiz_data);
		$quiz_id = $this->db->insert_id();
		
		$_SESSION['post_id'] = 'QZ'.$quiz_id;
		
		//set quiz read status to students
		
		
		
		
		$class_details= $this->classrooms_model->select_classinfo();
		$class_description= $class_details['class_desc'];
		
		$this->post->class_post('QZ'.$quiz_id , 4);
		
		if($this->emailnotifs_model->status(3) == 1){
			$class_users = $this->classusers_model->class_users();
			foreach($class_users as $row){
				$email = $row['email'];
				if($email != ''){
					$body = "<strong>Notification Type:</strong>New Quiz<br/>".
							"<strong>Quiz Date: </strong>" . date('Y-m-d', strtotime($start_time)) . "<br/>" .
							"<strong>Start Time: </strong>" . date('g:i:s A', strtotime($start_time)) . "<br/>" .
							"<strong>End Time: </strong>" . date('g:i:s A', strtotime($end_time)) . "<br/>" .
							"<strong>Sender:</strong>". $user_name . "<br/>" .
							"<strong>Class : </strong>" . $class_description . "<br/>" .
							"<strong>Message:</strong><br/>". $body;
				
					
					$this->email->send($email, $title, $body);
				}
			}
		}
	}
	
	function create(){
		$user_name		= $this->session->userdata('user_name');
	
		$class_id 	= $_SESSION['current_class'];
		$quiz = $_SESSION['quiz'];
					
		$title		= $quiz['title'];
		$body		= $quiz['body'];
		$start_time	= $quiz['start_time'];
		$end_time	= $quiz['end_time'];
		
		$quiz_data	= array($class_id, 1,  $title, $body, $start_time, $end_time);
		
		$create_quiz = $this->db->query("INSERT INTO tbl_quiz SET class_id=?, qz_type=?, qz_title=?, qz_body=?, start_time=?, end_time=?, date_created=CURDATE()", $quiz_data);
		$quiz_id = $this->db->insert_id();
		
		$_SESSION['post_id'] = 'QZ'.$quiz_id;
		
		//set quiz read status to students
		
		
		
		
		$class_details= $this->classrooms_model->select_classinfo();
		$class_description= $class_details['class_desc'];
		
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
		
		if($this->emailnotifs_model->status(3) == 1){
			$class_users = $this->classusers_model->class_users();
			foreach($class_users as $row){
				$email = $row['email'];
				if($email != ''){
					$body = "<strong>Notification Type:</strong>New Quiz<br/>".
							"<strong>Quiz Date: </strong>" . date('Y-m-d', strtotime($start_time)) . "<br/>" .
							"<strong>Start Time: </strong>" . date('g:i:s A', strtotime($start_time)) . "<br/>" .
							"<strong>End Time: </strong>" . date('g:i:s A', strtotime($end_time)) . "<br/>" .
							"<strong>Sender:</strong>". $user_name . "<br/>" .
							"<strong>Class : </strong>" . $class_description . "<br/>" .
							"<strong>Message:</strong><br/>". $body;
				
					
					$this->email->send($email, $title, $body);
				}
			}
		}
	}
	
	function view(){//returns quiz details and quiz items
		$quiz_id = $_SESSION['current_id'];
		$file_quiz_id = 'QZ'.$quiz_id;
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
		
		
		$quiz['files'] = $this->files->view($file_quiz_id);
	
		return $quiz;
	}
	
	function submit(){//for submitting answers for a particular quiz
		$user_id	= $this->session->userdata('user_id');
		$user_name	= $this->session->userdata('user_name');
		
		$class_id	= $_SESSION['current_class'];
		$quiz_id	= $_SESSION['current_id'];
		
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
		$class_id 		= $_SESSION['current_class'];
		$query			= $this->db->query("SELECT teacher_id FROM tbl_classteachers WHERE class_id='$class_id'");
		if($query->num_rows() > 0){
			$row = $query->row();
			$teacher_id = $row->teacher_id;
			
			//set response status to unread
			
			$this->post->message_post('QR'.$quiz_id, 7, $teacher_id);
			
			
			
			
			$class_details= $this->classrooms_model->select_classinfo();
			$class_description= $class_details['class_desc'];	
			
			//send emails
			if($this->emailnotifs_model->status(7) == 1){
				$quiz_details 	= $this->quiz_details($quiz_id);
				$quiz_title		= $quiz_details['title'];
				$quiz_body		= $quiz_details['body'];
					
				$email_address = $this->users->user_email($teacher_id);
				if($email_address != ''){
					$body = "<strong>Notification Type:</strong>Quiz Response<br/>
							<strong>Quiz Title: </strong>" . $quiz_title . "<br/>" .
							"<strong>Quiz Description: </strong>" .$quiz_body . "<br/>" .
							"<strong>Sender:</strong>". $user_name . "<br/>" . 
							"<strong>Class : </strong>" . $class_description . "<br/>" .
							"<strong>Message:</strong>". $user_name . " has submitted a response to a quiz entitled " . $quiz_title   ."<br/>";
				
					$this->email->send($email_address, "Quiz Response: " . $quiz_title , $body);
				}
				
			}
		}
		
	}
	
	function scores(){
		$quiz_results['details'] = array();
		$quiz_results['result'] = array();
		$quiz_id	= $_SESSION['current_quiz_id'];
		$quiz = $this->db->query("SELECT qz_title, DATE(start_time) AS quiz_date FROM tbl_quiz WHERE quiz_id='$quiz_id'");
		if($quiz->num_rows() > 0){
			$row = $quiz->row();
			$quiz_title = $row->qz_title;
			$quiz_date	= $row->quiz_date;
		
			$quiz_results['details'] = array('id'=>$quiz_id, 'title'=>$quiz_title, 'date'=>$quiz_date);
			
			$query 		= $this->db->query("SELECT quizresult_id, CONCAT_WS(', ', UPPER(lname), fname) AS student, score FROM tbl_quizresult 
											LEFT JOIN tbl_userinfo ON tbl_quizresult.user_id = tbl_userinfo.user_id
											WHERE quiz_id='$quiz_id'");
			
										
			
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

	function check($quizid = 0){//checks if the quiz can already be taken by the student
		$user_id = $this->session->userdata('user_id');
		
		if($quizid != 0){
			$quiz_id = $quizid;
		}else{
			$quiz_id = $_SESSION['current_id'];
		}
		
		$post_quiz_id = 'QZ'.$quiz_id;
		$not_taken	= 1;
		//checks if the student has already opened the quiz
		$query = $this->db->query("SELECT status FROM tbl_poststatus WHERE post_id='$post_quiz_id' AND post_to='$user_id' AND status = 1");
		$not_taken = $query->num_rows();
		
		
		//checks if the current time is within the range of start_time and end time of the selected quiz
		$query = $this->db->query("SELECT quiz_id FROM tbl_quiz WHERE quiz_id='$quiz_id' AND NOW() BETWEEN start_time AND end_time");
		if($query->num_rows() == 1 && $not_taken == 1){
			return 1;//can take the quiz
		}else if($query->num_rows() == 0 && $not_taken == 1){//locked
			return 2;
		}else{
			return 0;//cannot take the quiz
		}
	}
	
	
	
	
	function quiz_details($quiz_id){//returns general quiz details such as the title and the description
		$details = array();
		$query = $this->db->query("SELECT qz_title, qz_body FROM tbl_quiz WHERE quiz_id='$quiz_id'");
		if($query->num_rows() > 0){
			$row = $query->row();
			$quiz_title = $row->qz_title;
			$quiz_body	= $row->qz_body;
			$details = array('id'=>$quiz_id,'title'=>$quiz_title, 'body'=>$quiz_body);
		}
		return $details;
	}
	
	function reply(){//reply to a quiz
		$user_id=$this->session->userdata('user_id');
		$user_name = $this->session->userdata('user_name');
		
		$quiz_id=$_SESSION['current_id'];
		$title 	= $this->input->post('title'); 
		$body	= $this->input->post('body');
		
		$quiz_response = array($quiz_id, $user_id, $title, $body);
		$query = $this->db->query("INSERT INTO tbl_quizresponse SET quiz_id=?, student_id=?, res_title=?, res_body=?", $quiz_response);
		$quizresponse_id = $this->db->insert_id();
		
		$_SESSION['post_id'] = 'QR'.$quizresponse_id;
		
		//fetch teacher for the current class
		$class_id 		= $_SESSION['current_class'];
		$query			= $this->db->query("SELECT teacher_id FROM tbl_classteachers WHERE class_id='$class_id'");
		if($query->num_rows() > 0){
			$row = $query->row();
			$teacher_id = $row->teacher_id;
			
			//set response status to unread
			
			$this->post->message_post('QR'.$quiz_id, 7, $teacher_id);
			
			
		
			
			$class_details= $this->classrooms_model->select_classinfo();
			$class_description= $class_details['class_desc'];	
			
			//send emails
			if($this->emailnotifs_model->status(7) == 1){
				$quiz_details 	= $this->quiz_details($quiz_id);
				$quiz_title		= $quiz_details['title'];
				$quiz_body		= $quiz_details['body'];
					
				$email_address = $this->users->user_email($teacher_id);
				if($email_address != ''){
					$body = "<strong>Notification Type:</strong>Quiz Response<br/>
							<strong>Quiz Title: </strong>" . $quiz_title . "<br/>" .
							"<strong>Sender:</strong>". $user_name . "<br/>" . 
							"<strong>Class : </strong>" . $class_description . "<br/>" .
							"<strong>Message:<br/></strong>". $user_name . " has submitted a response to a quiz entitled " . $quiz_title   ."<br/>
							Login to your account to read the response";
							
					$this->email->send($email_address, "Quiz Response: " . $quiz_title , $body);
				}
				
			}
		}
	}
	
	function list_replies(){//returns a list of replies for a specific quiz
		$quiz_id = $_SESSION['current_quiz_id'];
		$replies = array();
		$query = $this->db->query("SELECT quizresponse_id, tbl_quizresponse.student_id, res_title, res_datetime, fname, mname, lname FROM tbl_quizresponse 
									LEFT JOIN tbl_userinfo ON tbl_quizresponse.student_id = tbl_userinfo.user_id
									WHERE quiz_id='$quiz_id'");
		
		
							
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
			
				$id			= $row->quizresponse_id;
				$post_from	= $row->student_id;
				$title 		= $row->res_title;
				$datetime	= $row->res_datetime;
				$fname		= $row->fname;
				$mname		= $row->mname;
				$lname		= $row->lname;
				
				
				$details 	= $this->quiz_details($quiz_id);
				$quiz_title	= $details['title'];
				
				
				$post_status 	= $this->post->quizreply_status('QR'.$quiz_id, $post_from);
				$status_id		= $this->post->status_id('QR'.$quiz_id, $post_from);
				
				$replies['quiz'] 		= array('quiz_id'=>$quiz_id, 'quiz_title'=>$quiz_title);
				$replies['replies'][] 	= array('status_id'=>$status_id, 'quiz_id'=>$quiz_id, 'status'=>$post_status, 'id'=>$id, 'title'=>$title, 'datetime'=>$datetime, 'fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname);
			}
		}
		return $replies;
	}
	
	function view_reply(){//returns a single reply for a specific quiz
		$quizresponse_id = $_SESSION['current_id'];
		$reply = array();
		$query = $this->db->query("SELECT quiz_id, res_title, res_body, res_datetime , fname, mname, lname FROM tbl_quizresponse 
									LEFT JOIN tbl_userinfo ON tbl_quizresponse.student_id = tbl_userinfo.user_id
									WHERE quizresponse_id='$quizresponse_id'");
		
		if($query->num_rows() > 0){
			$row 		= $query->row();
			
			$quiz_id	= $row->quiz_id;
			$details 	= $this->quiz_details($quiz_id);
			$quiz_title	= $details['title'];
			
			$id			= 'QR'.$quizresponse_id;
			$title 		= $row->res_title;
			$body		= $row->res_body;
			$datetime	= $row->res_datetime;
			$fname		= $row->fname;
			$mname		= $row->mname;
			$lname		= $row->lname;
			
			
			
			$reply['reply'] 	= array('quiz_id'=>$quiz_id, 'quiz_title'=>$quiz_title, 'res_title'=>$title, 'body'=>$body,
								'datetime'=>$datetime, 'fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname);
								
			
			$reply['files'] = $this->files->view($id);					
		}
		
		return $reply;
	}
	
	function score(){
		$student_id = $this->session->userdata('user_id');
		$quiz_id	= $_SESSION['current_id'];
		$item_count = 0;
		$score = 0;
		
		$details = $this->quiz_details($quiz_id);
		$quiz_title = $details['title'];
		
		$score_details = array();
		
		$over		= $this->db->query("SELECT COUNT(quiz_item_id) AS item_count FROM tbl_quizitems WHERE quiz_id='$quiz_id'");
		if($over->num_rows() > 0){
			$row = $over->row();
			$item_count = $row->item_count;
		}
		
		$query 		= $this->db->query("SELECT score FROM tbl_quizresult WHERE quiz_id='$quiz_id' AND user_id='$student_id'");
		if($query->num_rows() > 0){
			$row = $query->row();
			$score = $row->score;
		}
			
		$score_details = array('quiz_id'=>$quiz_id, 'title'=>$quiz_title, 'score'=>$score, 'itemcount'=>$item_count);
		
		return $score_details;
	}
	
	function student_reply(){
		$student_id = $this->session->userdata('user_id');
		$quiz_id	= $_SESSION['current_id'];
		
		$details 	= $this->quiz_details($quiz_id);
		$quiz_title	= $details['title'];
			
		$reply = array();
		$query = $this->db->query("SELECT quizresponse_id, quiz_id, res_title, res_body, res_datetime , fname, mname, lname FROM tbl_quizresponse 
									LEFT JOIN tbl_userinfo ON tbl_quizresponse.student_id = tbl_userinfo.user_id
									WHERE quiz_id='$quiz_id' AND student_id='$student_id'");
		
		if($query->num_rows() > 0){
			
			$row 		= $query->row();	
			$id			= 'QR'.$row->quizresponse_id;
			$title 		= $row->res_title;
			$body		= $row->res_body;
			$datetime	= $row->res_datetime;
			$fname		= $row->fname;
			$mname		= $row->mname;
			$lname		= $row->lname;
			
			$reply['reply'] 	= array('quiz_id'=>$quiz_id, 'quiz_title'=>$quiz_title, 'res_title'=>$title, 'body'=>$body,
								'datetime'=>$datetime, 'fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname);
			
			
			$reply['files'] = $this->files->view($id);
		
		}
		
		
		
		return $reply;
	}
	
	
		function responseid($user_id, $quiz_id){//quick fix; returns the response id for a specific quiz
			$query = $this->db->query("SELECT quizresponse_id FROM tbl_quizresponse WHERE student_id='$user_id' AND quiz_id='$quiz_id'");
			$responseid = 0;
			if($query->num_rows() >0){
				$row = $query->row();
				$responseid = $row->quizresponse_id;
			}
			return $responseid;
		}
	
	

}
?>