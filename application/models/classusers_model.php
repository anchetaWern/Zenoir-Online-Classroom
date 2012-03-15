<?php
class classusers_model extends ci_Model{

	
	function user_classes(){//get the classes to which the current user belongs
		
		$user_id = $this->session->userdata('user_id');
		$classes_array = array();
		$query = $this->db->query("SELECT class_code, course_description, subject_description, class_description, status, tbl_classes.class_id
								FROM tbl_classpeople 
								LEFT JOIN tbl_classes ON tbl_classpeople.class_id = tbl_classes.class_id
								LEFT JOIN tbl_subject ON tbl_classes.subject_id = tbl_subject.subject_id
								LEFT JOIN tbl_courses ON tbl_classes.course_id = tbl_courses.course_id
								WHERE user_id='$user_id'");
		
		
		if($query->num_rows > 0){
			foreach($query->result() as $row){
				$status = $this->class_status($row->status);
				$classes_array[] = array($row->class_code, $row->class_description, $row->subject_description, $row->course_description, $status, $row->class_id);
			}
		}
		return $classes_array;
	}
	
	
	function unread_posts(){//gets the number of unread post per module for the currently logged in user
		$user_id  = $this->session->userdata('user_id');
		$class_id = $this->session->userdata('current_class');
		$posts 	  = array();
		/*
		post types:
		1- Assignments
		2- Messages
		3- Quizzes
		4- Session
		5- Handouts
		*/
		
		/*
		post status:
		1- Unread
		0- Read
		*/
		
		for($x = 1; $x <= 5; $x++){
			$post_type = $x;
			$posts[$x] = $this->db->query("SELECT post_id FROM tbl_poststatus 
				WHERE post_type = '$post_type' AND post_to='$user_id' AND class_id='$class_id' AND status = 1");
		}

		return $posts;
			
	}
	
	
	function class_status($status){
		$stat = 'LOCKED';
		if($status == 1){
			$stat = 'ACTIVE';
		}
		return $stat;
	}

}
?>