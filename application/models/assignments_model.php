<?php
class assignments_model extends ci_Model{
		
		
		
		function create(){
			
			$user_name		= $this->session->userdata('user_name');
			
			$class_id	= $_SESSION['current_class'];
			$title		= $this->input->post('as_title');
			$body		= $this->input->post('as_body');
			$deadline	= $this->input->post('as_deadline');
			
			$data 		= array($title, $body, $class_id, $deadline);
			$this->db->query("INSERT INTO tbl_assignment SET as_title=?, as_body=?, class_id=?, date=CURDATE(), deadline=?", $data);
			
			$assignment_id = $this->db->insert_id();
			$assignment_id = 'AS'.$assignment_id;
			$_SESSION['post_id'] = $assignment_id;
			
			//set assignment read status to all of the students in the class
			$this->load->model('post');
			$this->load->model('classusers_model');
			$this->load->model('email');
			$this->load->model('emailnotifs_model');
			$this->load->model('classrooms_model');
			
			$class_details= $this->classrooms_model->select_classinfo();
			$class_description= $class_details['class_desc'];	
			
			
			$this->post->class_post($assignment_id , 1);
			
			//send emails
			if($this->emailnotifs_model->status(1) == 1){
			$class_users = $this->classusers_model->class_users();
				foreach($class_users as $row){
					$email = $row['email'];
					if($email != ''){
						$body = "<strong>Notification Type:</strong>New Assignment<br/>
								<strong>Deadline: </strong>" . $deadline . "<br/>" .
								"<strong>Sender:</strong>". $user_name . "<br/>" . 
								"<strong>Class : </strong>" . $class_description . "<br/>" .
								"<strong>Message:</strong><br/>". $body;
					
						$this->email->send($email, $title, $body);
					}
				}
			}
		}
		
		function delete(){
			$assignment_id = $this->input->post('as_id');
			$this->db->query("UPDATE tbl_assignment SET status=0 WHERE assignment_id='$assignment_id'");
		}
		
		function list_all(){
			$class_id	= $_SESSION['current_class'];
			//even teachers and admins cannot see assignments that are deleted
			$assignments = array();
			$query = $this->db->query("SELECT assignment_id, as_title, as_body, date, deadline FROM tbl_assignment WHERE class_id='$class_id' AND status=1 ORDER BY date DESC"); 
			
			$this->load->model('post');

			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$student_status = $this->post->status('AS'.$row->assignment_id);
					$teacher_status = $this->post->assignmentreply_count('AR'.$row->assignment_id);
					$assignments[] = array('teacher_status'=>$teacher_status, 'student_status'=>$student_status, 'assignment_id'=>$row->assignment_id, 'title'=>$row->as_title, 'date'=>$row->date, 'deadline'=>$row->deadline);
				}
			}
			return $assignments;
		}
		
		
		function view(){//view a single assignment
			$assignment_id = $_SESSION['current_id'];
			$assignment_details['assignment'] = array();
			$assignment_details['files'] = array();
			$assignment = $this->db->query("SELECT * FROM tbl_assignment WHERE assignment_id='$assignment_id'");
			if($assignment->num_rows > 0){
				$row = $assignment->row();
				$as_id		=	$row->assignment_id; 
				$file_as_id =   'AS'.$as_id;
				$as_title	=	$row->as_title;
				$as_body	=	$row->as_body;
				$date		=	$row->date;
				$deadline	=	$row->deadline;
				
				$this->load->model('files');
				$assignment_details['files'] = $this->files->view($file_as_id);
				$assignment_details['assignment'] = array('as_id'=>$as_id, 'as_title'=>$as_title, 'as_body'=>$as_body, 'date'=>$date, 'deadline'=>$deadline);
			}
			return $assignment_details;
		}
		
		function reply_details(){//get the details needed when replying to an assignment: title of the assignment you're replying to and assignment_id
			$assignment_id = $_SESSION['current_id'];
			$assignment_details = array();
			$assignment = $this->db->query("SELECT as_title, as_body FROM tbl_assignment WHERE assignment_id = '$assignment_id'");
			
			if($assignment->num_rows() > 0){
				$row = $assignment->row();
				$as_title = $row->as_title;
				$as_body  = $row->as_body;
				$assignment_details = array('as_title'=>$as_title, 'as_body'=>$as_body);
			}
			return $assignment_details;
		}
		
		function reply(){
			$user_id		= $this->session->userdata('user_id');
			$user_name		= $this->session->userdata('user_name');
			
			$assignment_id = $_SESSION['current_id']; //assignment you're replying to
			$reply_title	= $this->input->post('reply_title');
			$reply_body		= $this->input->post('reply_body');
			
			$reply_data 	= array($assignment_id, $user_id, $reply_title, $reply_body);
			
			$reply 			= $this->db->query("INSERT INTO tbl_assignmentresponse SET assignment_id=?, user_id=?, res_title=?, res_body=?", $reply_data);
			$reply_id 		= $this->db->insert_id();
			$reply_id		= 'AR'.$reply_id; //assignment response prefix
			
			
			
			$_SESSION['post_id'] =  $reply_id;
			
			
			//fetch teacher for the current class
			$class_id 		= $_SESSION['current_class'];
			$query			= $this->db->query("SELECT teacher_id FROM tbl_classteachers WHERE class_id='$class_id'");
			if($query->num_rows() > 0){
				$row = $query->row();
				$teacher_id = $row->teacher_id;
				
				//set response status to unread
				$this->load->model('post');
				$this->post->message_post($reply_id, 3, $teacher_id);
				
				
				$this->load->model('email');
				$this->load->model('emailnotifs_model');
				$this->load->model('classrooms_model');
				$this->load->model('users');
				
				$class_details= $this->classrooms_model->select_classinfo();
				$class_description= $class_details['class_desc'];	
				
				
				//send emails
				if($this->emailnotifs_model->status(6) == 1){
						$assignment_details = $this->reply_details();
						$as_title			= $assignment_details['as_title'];
						
						
						$email_address = $this->users->user_email($teacher_id);
						if($email_address != ''){
							$body = "<strong>Notification Type:</strong>Assignment Response<br/>
									<strong>Assignment Title: </strong>" . $as_title . "<br/>" .
									"<strong>Sender:</strong>". $user_name . "<br/>" . 
									"<strong>Class : </strong>" . $class_description . "<br/>" .
									"<strong>Message:</strong><br/>". $reply_body;
						
							$this->email->send($email_address, $reply_title, $body);
						}
					
				}
				
			}
			
			
		}
		
		function list_replies(){//loads the replies to a specific assignment
			$assignment_id 	= $_SESSION['current_id'];
			$replies_r['replies'] 		= array();
			$replies_r['as_title']		= array();
			$replies 		= $this->db->query("SELECT tbl_assignmentresponse.user_id, asresponse_id, CONCAT_WS(', ', UPPER(lname), fname) AS sender, res_title, response_datetime
											FROM tbl_assignmentresponse 
											LEFT JOIN tbl_userinfo ON tbl_assignmentresponse.user_id = tbl_userinfo.user_id
											WHERE assignment_id='$assignment_id'");
											
			$assignment		= $this->db->query("SELECT assignment_id, as_title FROM tbl_assignment WHERE assignment_id='$assignment_id'");
			if($assignment->num_rows() > 0){
				$row = $assignment->row();
				$replies_r['as_title'] = $row->as_title;
				$replies_r['as_id'] = $row->assignment_id;
			}
			
			$this->load->model('post');
			
			if($replies->num_rows() > 0){
				foreach($replies->result() as $row){
					$post_from	= $row->user_id;
					$res_id		= $row->asresponse_id;
					$res_title	= $row->res_title;
					$res_date	= $row->response_datetime;
					$sender		= $row->sender;
					
					$post_status 	= $this->post->assignmentreply_status('AR'.$assignment_id, $post_from);
					
					$status_id		= $this->post->status_id('AR'.$assignment_id, $post_from);
					
					$replies_r['replies'][] = array('status_id'=>$status_id, 'as_id'=>$assignment_id, 'status'=>$post_status, 'res_id'=>$res_id, 'res_title'=>$res_title, 'res_date'=>$res_date, 'sender'=>$sender);
				}
			}
			return $replies_r;
		}
		
		function view_reply(){//view a specific reply to an assignment
		
			$reply_id = $_SESSION['current_id'];
			$reply = array();
			$reply_details = $this->db->query("SELECT tbl_assignmentresponse.assignment_id, CONCAT_WS(UPPER(lname), fname) AS sender, res_title, res_body, response_datetime
											FROM tbl_assignmentresponse 
											LEFT JOIN tbl_userinfo ON tbl_assignmentresponse.user_id = tbl_userinfo.user_id
											LEFT JOIN tbl_assignment ON tbl_assignmentresponse.assignment_id = tbl_assignment.assignment_id
											WHERE asresponse_id='$reply_id'");
			
			if($reply_details->num_rows() > 0){
				$row = $reply_details->row();
				
				$assignment_id=$row->assignment_id;
				$file_as_id =   'AR'.$reply_id;
				$res_title	= $row->res_title;
				$res_body	= $row->res_body;
				$res_date	= $row->response_datetime;
				$sender		= $row->sender;
				
				$this->load->model('files');
				$reply['files'] = $this->files->view($file_as_id);
				$reply['reply'] = array('as_id'=>$assignment_id, 'res_title'=>$res_title, 'res_date'=>$res_date, 'res_body'=>$res_body, 'sender'=>$sender);
			}
			return $reply;
		}
		
		
		function response_id(){
		//check the reply of the current student for the currently viewed assignment. returns 0 if nothing has been returned, and returns the response id for the
		//specific assignment if the student has already replied to the assignment
			$user_id		= $this->session->userdata('user_id');
			$assignment_id 	= $_SESSION['current_id'];
			
			$query = $this->db->query("SELECT asresponse_id FROM tbl_assignmentresponse WHERE user_id='$user_id' AND assignment_id='$assignment_id'");
			if($query->num_rows() == 0){
				return 0;
			}else if($query->num_rows() > 0){
				$row = $query->row();
				return $row->asresponse_id;
			}
		}
		
		function responseid($user_id, $assignment_id){//quick fix; returns the response id for a specific assignment
			$query = $this->db->query("SELECT asresponse_id FROM tbl_assignmentresponse WHERE user_id='$user_id' AND assignment_id='$assignment_id'");
			$responseid = 0;
			if($query->num_rows() >0){
				$row = $query->row();
				$responseid = $row->asresponse_id;
			}
			return $responseid;
		}
		
		function check(){
		//checks if student can still reply to an assignment 
		//once the deadline becomes less than the current date the student cannot reply to the assignment anymore
			$assignment_id = $_SESSION['current_id'];
			$query = $this->db->query("SELECT as_title FROM tbl_assignment WHERE assignment_id='$assignment_id' AND deadline >= CURDATE()");
			
			return $query->num_rows();
		}
		
		function assignment_details(){
			$assignment_id = $_SESSION['current_id'];
			$details = array();
			$query = $this->db->query("SELECT as_title FROM tbl_assignment WHERE assignment_id='$assignment_id'");
			if($query->num_rows() > 0){
				$row = $query->row();
				$title = $row->as_title;
				$details = array('id'=>$assignment_id, 'title'=>$title);
			}
			return $details;
		}
	
}
?>