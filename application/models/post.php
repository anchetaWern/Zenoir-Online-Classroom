<?php
class post extends ci_Model{
//everything related to the tracking of post status

	function message_post($post_id, $post_type, $receivers){//set message status for each receiver
		$post_from	= $this->session->userdata('user_id');
		$class_id 	= $_SESSION['current_class'];
		
		
		if(is_array($receivers)){
			foreach($receivers as $post_to){
				
				$set_status = $this->db->query("INSERT INTO tbl_poststatus SET class_id='$class_id', post_id='$post_id', 
							post_type='$post_type', post_from='$post_from', post_to='$post_to'");
			}
		}else{
			$post_to = $receivers;
			$set_status = $this->db->query("INSERT INTO tbl_poststatus SET class_id='$class_id', post_id='$post_id', 
						post_type='$post_type', post_from='$post_from', post_to='$post_to'");
		}
	}
	
	function class_post($post_id, $post_type){//set assignment, handouts and quizzes status for each member of the class excep the teacher
	/*
	post types:
	1-assignment(AS)
	2-handout(HO)
	3-assignment response(AR)
	4-quiz(QZ)
	5-message(PO)
	6-session(SS)
	7-quiz response(QR)
	*/	
	
	
		$post_from	= $this->session->userdata('user_id');
		$class_id 	= $_SESSION['current_class'];
		
		//select all people that belong to the specific class
		$people		= $this->db->query("SELECT * FROM tbl_classpeople WHERE class_id='$class_id'");
		if($people->num_rows() > 0){
			foreach($people->result() as $row){
				$post_to 	= $row->user_id;
				
				if($post_from != $post_to){
					$set_status = $this->db->query("INSERT INTO tbl_poststatus SET class_id='$class_id', post_id='$post_id', 
						post_type='$post_type', post_from='$post_from', post_to='$post_to'");
				}
				
			}
		}
		
		
	}
	
	function status($post_id){//returns the status of a specific post for a particular user
		$user_id	= $this->session->userdata('user_id');
		$state	= 0;
		$query	= $this->db->query("SELECT status FROM tbl_poststatus WHERE post_to='$user_id' AND post_id='$post_id'");
		if($query->num_rows() > 0){
			$row 	= $query->row();
			$state	= $row->status;
		}
		return $state;
	}
	
	function assignmentreply_status($post_id, $post_from){//quick fix refactor later
		$query = $this->db->query("SELECT status FROM tbl_poststatus WHERE post_id='$post_id' AND post_from='$post_from' AND status =1");
		$state = 0;
		if($query->num_rows() > 0){
			$row 	= $query->row();
			$state	= $row->status;
		}
		return $state;
	}
	
	function assignmentreply_count($post_id){//returns 0 if there are no unread responses to a specific assignment and 1 if there is an unread response
		$query = $this->db->query("SELECT status FROM tbl_poststatus WHERE post_id='$post_id' AND status=1");
		return $query->num_rows();
	}
	
	
	function unread_posts(){//loads the count of unread items per module
		$user_id 	= $this->session->userdata('user_id');
		$class_id	= $_SESSION['current_class'];
		$post_types = array('assignment', 'handout', 'assignment_response', 'quiz', 'message', 'session', 'quiz_response');
		$module_unread = array();
		
		for($x=1; $x <= 7; $x++){//status: 1 -unread, 0 -read
			$post_type = $x;
			$query = $this->db->query("SELECT post_id FROM tbl_poststatus WHERE post_to='$user_id' AND post_type='$post_type' AND class_id='$class_id' AND status=1");
			
				$unreads = $query->num_rows();
				$module_unread[$post_types[$x-1]] =  $unreads;
			
		}
		return $module_unread;
	}
	
	
	function unset_post($prefix){//unsets the read status of the post to the student
		$user_id 	= $this->session->userdata('user_id');
		$class_id	= $_SESSION['current_class'];
		$post_id	= $prefix.$_SESSION['current_id'];
		
		$this->db->query("UPDATE tbl_poststatus SET status=0 WHERE post_id='$post_id' AND post_to='$user_id'");
		
	}
	
	function unset_assignmentreply(){
		$post_status_id = $_SESSION['sid'];
		$this->db->query("UPDATE tbl_poststatus SET status=0 WHERE post_status_id='$post_status_id'");
	}
	
	function status_id($post_id, $post_from){
		$query = $this->db->query("SELECT post_status_id FROM tbl_poststatus WHERE post_id='$post_id' AND post_from='$post_from'");
		if($query->num_rows() > 0){
			$row = $query->row();
			return $row->post_status_id;
		}
	}
	
	function unset_all($prefix){//unsets all the status of scores of students in a quiz 
		$post_id	= $prefix.$_SESSION['current_id'];
		$this->db->query("UPDATE tbl_poststatus SET status=0 WHERE post_id='$post_id'");
	}
	
	function post_type($post_type){//returns the post type from a post_type id
		$post_types = array('assignment', 'handout', 'assignment_response', 'quiz', 'message', 'session', 'quiz_response');
		return $post_types[$post_type - 1];
	}
	
	function post_title($post_type, $post_id){//returns the post title from the post_type id and post_id
		$post_id_len	= strlen($post_id);
		$post_id		= substr($post_id, 2, $post_id_len);
		$tables 		= array('tbl_assignment', 'tbl_handouts', 'tbl_assignmentresponse', 'tbl_quiz', 'tbl_messages', 'tbl_sessions', 'tbl_quizresult');
		$fields_id 		= array('assignment_id', 'handout_id', 'asresponse_id', 'quiz_id', 'message_id', 'session_id', 'quizresult_id');
		$fields_title	= array('as_title', 'ho_title', 'res_title', 'qz_title', 'msg_title', 'ses_title', 'quiz_id');
		$field 			= '';
		$table			= $tables[$post_type - 1];
		$field_base		= $fields_id[$post_type - 1];
		$field_get		= $fields_title[$post_type - 1];
		
		$query = $this->db->query("SELECT $field_get FROM $table WHERE $field_base = '$post_id'");
		if($query->num_rows() > 0){
			$row 	= $query->row();
			$field  = $row->$field_get;
		}
		return $field;
	}
}
?>