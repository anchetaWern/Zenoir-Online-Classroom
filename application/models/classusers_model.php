<?php
class classusers_model extends ci_Model{

	
	function user_classes(){//get the classes to which the current user belongs
		
		$user_id = $this->session->userdata('user_id');
		$classes_array = array();
		$query = $this->db->query("SELECT class_code, course_description, subject_description, class_description, tbl_classpeople.status, tbl_classes.class_id
								FROM tbl_classpeople 
								LEFT JOIN tbl_classes ON tbl_classpeople.class_id = tbl_classes.class_id
								LEFT JOIN tbl_subject ON tbl_classes.subject_id = tbl_subject.subject_id
								LEFT JOIN tbl_courses ON tbl_classes.course_id = tbl_courses.course_id
								WHERE user_id='$user_id' AND tbl_classpeople.status = 1 AND tbl_classes.date_lock > CURDATE() AND tbl_classes.status = 1");
		
		
		if($query->num_rows > 0){
			foreach($query->result() as $row){
				$status = $this->class_status($row->status);
				$classes_array[] = array($row->class_code, $row->class_description, $row->subject_description, $row->course_description, $status, $row->class_id);
			}
		}
		return $classes_array;
	}
	
	function user_oldclasses(){//get the classes that has already expired but was not locked by the teacher
		
		$user_id = $this->session->userdata('user_id');
		$classes_array = array();
		$query = $this->db->query("SELECT class_code, course_description, subject_description, class_description, tbl_classpeople.status, tbl_classes.class_id
								FROM tbl_classpeople 
								LEFT JOIN tbl_classes ON tbl_classpeople.class_id = tbl_classes.class_id
								LEFT JOIN tbl_subject ON tbl_classes.subject_id = tbl_subject.subject_id
								LEFT JOIN tbl_courses ON tbl_classes.course_id = tbl_courses.course_id
								WHERE user_id='$user_id' AND tbl_classpeople.status = 1 AND tbl_classes.date_lock <= CURDATE() AND tbl_classes.status = 1");
		
		
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
		$class_id = $_SESSION['current_class'];
		$class_user_r = array();
		$query = $this->db->query("SELECT tbl_userinfo.user_id, fname, mname, lname FROM tbl_userinfo
								LEFT JOIN tbl_classpeople ON tbl_userinfo.user_id = tbl_classpeople.user_id
								WHERE class_id = '$class_id' AND tbl_userinfo.user_id != '$current_user' AND tbl_classpeople.status = 1");
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
	
	
	function user_logs(){//lists all the activities performed of the selected student on the current class
		$user_id	= $_SESSION['current_id'];
		$class_id	= $_SESSION['current_class'];
		
		
		
		$log_info	= array();
		
		if($this->session->userdata('usertype') == 1){//admin -all classes
			$logs		= $this->db->query("SELECT DATE(act_datetime) AS date, act_datetime, activity, activity_details
											FROM tbl_activitylog 
											LEFT JOIN tbl_activities ON tbl_activitylog.activity_id = tbl_activities.activity_id
											WHERE user_id='$user_id' ORDER BY date DESC");
		}else{//teacher -class limited
			$logs		= $this->db->query("SELECT DATE(act_datetime) AS date, act_datetime, activity, activity_details
											FROM tbl_activitylog 
											LEFT JOIN tbl_activities ON tbl_activitylog.activity_id = tbl_activities.activity_id
											WHERE class_id='$class_id' AND user_id='$user_id' ORDER BY date DESC");
										
		}
		
		if($logs->num_rows() > 0){
			foreach($logs->result() as $row){
				
				$datetime	= $row->act_datetime;
				$activity	= $row->activity;
				$details	= $row->activity_details;
				
				$log_info[]	= array('datetime'=>$datetime, 'act'=>$activity, 'details'=>$details);
			}
		}
		return $log_info;
	}
	
	
	function list_invited_students(){//list of all students which are not already enrolled in the current class
		$class_id	= $_SESSION['current_class'];
		$query 		= $this->db->query("SELECT tbl_userinfo.user_id, fname, mname, lname FROM tbl_users
									LEFT JOIN tbl_userinfo ON tbl_users.user_id = tbl_userinfo.user_id
									WHERE tbl_users.user_id NOT IN(SELECT user_id FROM tbl_classpeople WHERE class_id = '$class_id') AND user_type != 1 AND user_type != 2");
		
		$invited 	= array();
		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$id			= $row->user_id;
				$fname		= $row->fname;
				$mname		= $row->mname;
				$lname		= $row->lname;
				
				$invited[] = array('fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname, 'id'=>$id);
			}
		}
		return $invited;
	
	}
	
	function invites(){//invites the student into the current class. Status of the student in the classroom is equal to 0 until student confirms invitation
		$class_id	= $_SESSION['current_class'];
		$student_id	= $this->input->post('student_id');
		$this->db->query("INSERT INTO tbl_classpeople SET status=0, class_id='$class_id', user_id='$student_id'");
	}
	
	function accept(){//student accepts teacher invite
		$student_id = $this->input->post('student_id');
		$class_id	= $this->input->post('class_id');
		$this->db->query("UPDATE tbl_classpeople SET status=1 WHERE class_id='$class_id' AND user_id='$student_id'");
	}
	
	function decline(){//student declines teachers invite
		$student_id = $this->input->post('student_id');
		$class_id	= $this->input->post('class_id');
		$this->db->query("DELETE FROM tbl_classpeople WHERE user_id='$student_id' AND class_id='$class_id'");
	}
	
	
	function list_invites(){//list all the classroom invites for the current user
		$user_id= $this->session->userdata('user_id');
		$classes= array();
		$query 	= $this->db->query("SELECT user_id, class_code, class_description, tbl_classes.class_id FROM tbl_classes
									LEFT JOIN tbl_classpeople ON tbl_classes.class_id = tbl_classpeople.class_id
									WHERE tbl_classpeople.user_id='$user_id' AND tbl_classpeople.status = 0"); 
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$student_id			= $row->user_id;
				$class_id			= $row->class_id;
				$class_code			= $row->class_code;
				$class_description	= $row->class_description;
				
				$teacher	= $this->teacher($class_id);
				$teacher_id	= $teacher['teacher_id'];
				$fname		= $teacher['fname'];
				$mname		= $teacher['mname'];
				$lname		= $teacher['lname'];
				
				$classes[] = array('student_id'=>$student_id, 'class_id'=>$class_id, 'class_code'=>$class_code, 'class_description'=>$class_description, 
									'fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname, 'teacher_id'=>$teacher_id);
			}
		}
		return $classes;
	}
	
	function teacher($class_id){//returns the teacher of a specific class
		$query = $this->db->query("SELECT teacher_id,  fname, mname, lname FROM tbl_classteachers
								LEFT JOIN tbl_userinfo ON tbl_classteachers.teacher_id = tbl_userinfo.user_id
								WHERE tbl_classteachers.class_id='$class_id'");
		$teacher_info = array();
		if($query->num_rows() > 0){
			$row = $query->row();
			$teacher_id	= $row->teacher_id;
			$fname		= $row->fname;
			$mname		= $row->mname;
			$lname		= $row->lname;
			
			$teacher_info = array('teacher_id'=>$teacher_id, 'fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname);
		}
		return $teacher_info;
	}
	
	function remove(){//removes a student from a class
		$student_id = $this->input->post('student_id');
		$class_id	= $_SESSION['current_class'];
		/*
		status:
		1-active
		2-removed
		0-invited
		*/
		$this->db->query("UPDATE tbl_classpeople SET status = 2 WHERE class_id='$class_id' AND user_id='$student_id'");
	}
	
	
	function class_status($status){
		$stat = 'LOCKED';
		if($status == 1){
			$stat = 'ACTIVE';
		}
		return $stat;
	}
	
	function expired_classes(){//returns all the classes handled by the current teacher which are already beyond their lock date
		$user_id = $this->session->userdata('user_id');
		$query = $this->db->query("SELECT class_code, class_description, date_lock, tbl_classes.class_id FROM tbl_classes
									LEFT JOIN tbl_classteachers ON tbl_classes.class_id = tbl_classteachers.class_id
									WHERE teacher_id = '$user_id' AND date_lock < CURDATE() AND status = 1");
		$expired_classes = array();
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$class_code			= $row->class_code;
				$class_description	= $row->class_description;
				$date_lock			= $row->date_lock;
				$class_id			= $row->class_id;
				$expired_classes[] = array("class_code"=>$class_code, 'class_description'=>$class_description, 'date_lock'=>$date_lock, 'class_id'=>$class_id);
			}
		}
		return $expired_classes;
	}

}
?>