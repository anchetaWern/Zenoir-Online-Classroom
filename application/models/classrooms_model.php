<?php
class classrooms_model extends ci_Model{
	
	function create_class(){
		$class_code		= $this->input->post('class_code');	
		$class_desc 	= $this->input->post('class_desc');
		$subject_id	    = $this->input->post('subject_id');
		$teacher_id     = $this->input->post('teacher_id');	
		$course_id		= $this->input->post('course_id');
		
		$data_class 	= array($subject_id, $course_id, $class_code, $class_desc);
		
		
		$class_info = $this->db->query("INSERT INTO tbl_classes SET subject_id=?, course_id=?, class_code=?, class_description=?", $data_class);
		$class_id	= $this->db->insert_id();
		
		$data_teacher	= array($teacher_id, $class_id);
		$class_teacher = $this->db->query("INSERT INTO tbl_classteachers SET teacher_id=?, class_id=?", $data_teacher);
		
	}
	
	function select_classes(){
		$classes_array = array();
		$this->db->select("class_code, class_description, subject_description, fname, mname, lname");
		$this->db->from("tbl_classes");
		$this->db->join("tbl_subject", "tbl_classes.subject_id = tbl_subject.subject_id");
		$this->db->join("tbl_classteachers", "tbl_classes.class_id = tbl_classteachers.class_id");
		$this->db->join("tbl_userinfo", "tbl_classteachers.teacher_id = tbl_userinfo.user_id");
		$classes = $this->db->get();
		
		
		if($classes->num_rows > 0){
			foreach($classes->result() as $row){
				$classes_array[] = array($row->fname, $row->mname, $row->lname, $row->class_description, $row->class_code, $row->subject_description);
			}
		}
		return $classes_array;	
	}
	
	
	function select_classsubjectcourse($type){
		$classes_array = array();
		$this->db->select("class_code, class_description, subject_description, fname, mname, lname");
		$this->db->from("tbl_classes");
		$this->db->join("tbl_subject", "tbl_classes.subject_id = tbl_subject.subject_id");
		$this->db->join("tbl_classteachers", "tbl_classes.class_id = tbl_classteachers.class_id");
		$this->db->join("tbl_userinfo", "tbl_classteachers.teacher_id = tbl_userinfo.user_id");
		
		if($type == 'subject'){//selects classes associated to a subject
			$subject_id = $this->session->userdata('current_id');
			$this->db->where('tbl_classes.subject_id', $subject_id);
			
			
		}else if($type == 'course'){//selects classes associated to a course
			$course_id = $this->session->userdata('current_id');
			$this->db->where('tbl_classes.course_id', $course_id);
				
		}
		
			$classes = $this->db->get();
			if($classes->num_rows > 0){
				foreach($classes->result() as $row){
					$classes_array[] = array($row->fname, $row->mname, $row->lname, $row->class_description, $row->class_code, $row->subject_description);
				}
			}
		return $classes_array;	
	}

}
?>