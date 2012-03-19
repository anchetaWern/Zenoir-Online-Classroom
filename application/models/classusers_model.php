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
	
	

	
	function class_users(){//returns users in a specific class
		$current_user = $this->session->userdata('user_id');
		$class_id = $this->session->userdata('current_class');
		$class_user_r = array();
		$query = $this->db->query("SELECT tbl_userinfo.user_id, fname, mname, lname FROM tbl_userinfo
								LEFT JOIN tbl_classpeople ON tbl_userinfo.user_id = tbl_classpeople.user_id
								WHERE class_id = '$class_id' AND tbl_userinfo.user_id != '$current_user'");
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$id		= $row->user_id;
				$fname	= $row->fname;
				$mname  = $row->mname;
				$lname	= $row->lname;
				
				$class_user_r[] = array('id'=>$id, 'fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname);
			}
		}
		return $class_user_r;
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