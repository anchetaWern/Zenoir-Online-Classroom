<?php
class assignments_model extends ci_Model{
		
		
		
		function create(){
			
			$class_id	= $this->session->userdata('current_class');
			$title		= $this->input->post('as_title');
			$body		= $this->input->post('as_body');
			$deadline	= $this->input->post('as_deadline');
			
			$data 		= array($title, $body, $class_id, $deadline);
			$this->db->query("INSERT INTO tbl_assignment SET as_title=?, as_body=?, class_id=?, date=CURDATE(), deadline=?", $data);
			
			$assignment_id = $this->db->insert_id();
			$assignment_id = 'AS'.$assignment_id;
			$this->session->set_userdata('post_id', $assignment_id);
		}
		
		function delete(){
			$assignment_id = $this->input->post('as_id');
			$this->db->query("UPDATE tbl_assignment SET status=0 WHERE assignment_id='$assignment_id'");
		}
		
		function list_all(){
			$class_id	= $this->session->userdata('current_class');
			//even teachers and admins cannot see assignments that are deleted
			$assignments = array();
			$query = $this->db->query("SELECT assignment_id, as_title, as_body, date, deadline FROM tbl_assignment WHERE class_id='$class_id' AND status=1"); 
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$assignments[] = array('assignment_id'=>$row->assignment_id, 'title'=>$row->as_title, 'date'=>$row->date, 'deadline'=>$row->deadline);
				}
			}
			return $assignments;
		}
		
		
		function view(){//view a single assignment
			$assignment_id = $this->session->userdata('current_id');
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
			$assignment_id = $this->session->userdata('current_id');
			$assignment_details = array();
			$assignment = $this->db->query("SELECT as_title FROM tbl_assignment WHERE assignment_id = '$assignment_id'");
			
			if($assignment->num_rows() > 0){
				$row = $assignment->row();
				$as_title = $row->as_title;
				$assignment_details = array('as_title'=>$as_title);
			}
			return $assignment_details;
		}
		
		function reply(){
			$user_id		= $this->session->userdata('user_id');
			$assignment_id 	= $this->session->userdata('current_id'); //assignment you're replying to
			$reply_title	= $this->input->post('reply_title');
			$reply_body		= $this->input->post('reply_body');
			
			$reply_data 	= array($assignment_id, $user_id, $reply_title, $reply_body);
			
			$reply 			= $this->db->query("INSERT INTO tbl_assignmentresponse SET assignment_id=?, user_id=?, res_title=?, res_body=?", $reply_data);
			$reply_id 		= $this->db->insert_id();
			$reply_id		= 'AR'.$reply_id; //assignment response prefix
			
			$this->session->set_userdata('post_id', $reply_id);
		}
		
		function list_replies(){//loads the replies to a specific assignment
			$assignment_id 	= $this->session->userdata('current_id');
			$replies_r['replies'] 		= array();
			$replies_r['as_title']		= array();
			$replies 		= $this->db->query("SELECT asresponse_id, CONCAT_WS(', ', UPPER(lname), fname) AS sender, res_title, response_datetime
											FROM tbl_assignmentresponse 
											LEFT JOIN tbl_userinfo ON tbl_assignmentresponse.user_id = tbl_userinfo.user_id
											WHERE assignment_id='$assignment_id'");
			$assignment		= $this->db->query("SELECT assignment_id, as_title FROM tbl_assignment WHERE assignment_id='$assignment_id'");
			if($assignment->num_rows() > 0){
				$row = $assignment->row();
				$replies_r['as_title'] = $row->as_title;
				$replies_r['as_id'] = $row->assignment_id;
			}
			
			if($replies->num_rows() > 0){
				foreach($replies->result() as $row){
					$res_id		= $row->asresponse_id;
					$res_title	= $row->res_title;
					$res_date	= $row->response_datetime;
					$sender		= $row->sender;
					
					$replies_r['replies'][] = array('res_id'=>$res_id, 'res_title'=>$res_title, 'res_date'=>$res_date, 'sender'=>$sender);
				}
			}
			return $replies_r;
		}
		
		function view_reply(){//view a specific reply to an assignment
		
			$reply_id = $this->session->userdata('current_id');
			$reply = array();
			$reply_details = $this->db->query("SELECT tbl_assignmentresponse.assignment_id, CONCAT_WS(UPPER(lname), fname) AS sender, res_title, res_body, response_datetime
											FROM tbl_assignmentresponse 
											LEFT JOIN tbl_userinfo ON tbl_assignmentresponse.user_id = tbl_userinfo.user_id
											LEFT JOIN tbl_assignment ON tbl_assignmentresponse.assignment_id = tbl_assignment.assignment_id
											WHERE asresponse_id='$reply_id'");
			
			if($reply_details->num_rows() > 0){
				$row = $reply_details->row();
				
				$assignment_id=$row->assignment_id;
				$res_title	= $row->res_title;
				$res_body	= $row->res_body;
				$res_date	= $row->response_datetime;
				$sender		= $row->sender;
			
				$reply = array('as_id'=>$assignment_id, 'res_title'=>$res_title, 'res_date'=>$res_date, 'res_body'=>$res_body, 'sender'=>$sender);
			}
			return $reply;
		}
	
}
?>