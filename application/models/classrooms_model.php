<?php
class classrooms_model extends ci_Model{
	
	function create_class(){
		$class_code		= $this->input->post('class_code');	
		$class_desc 	= $this->input->post('class_desc');
		$subject_id	    = $this->input->post('subject_id');
		$teacher_id     = $this->input->post('teacher_id');	
		$course_id		= $this->input->post('course_id');
		
		//additional details
		$date_created	= $this->input->post('date_created');
		$date_lock		= $this->input->post('date_to');
		$details		= $this->input->post('details');
		
		$data_class 	= array($subject_id, $course_id, $class_code, $class_desc, $date_created, $date_lock, $details);
		
		
		$class_info = $this->db->query("INSERT INTO tbl_classes SET subject_id=?, course_id=?, class_code=?, class_description=?, date_created=?, date_lock=?, addl_notes=?", $data_class);
		$class_id	= $this->db->insert_id();
		
		//class teacher
		$data_teacher	= array($teacher_id, $class_id);
		$class_teacher 	= $this->db->query("INSERT INTO tbl_classteachers SET teacher_id=?, class_id=?", $data_teacher);
		
		//class modules - all modules in the class are enabled by default
		$modules		= $this->db->query("SELECT module_id FROM tbl_modules");
		if($modules->num_rows() > 0){
			foreach($modules->result() as $row){
				$module_id 		= $row->module_id;
				$this->db->query("INSERT INTO tbl_classmodules SET module_id='$module_id', class_id='$class_id'");
			}
		}
		
	}
	
	
	function add_people(){//adds people to the selected class
		$class_id 	= $this->session->userdata('current_id');
		$user_id	= $this->input->post('user_id');
		
		foreach($user_id as $v){
			$data = array($class_id, $v);
			$this->db->query("INSERT INTO tbl_classpeople SET class_id=?, user_id=?", $data);
		}	
	}
	
	
	function select_classes(){
		$classes_array = array();
		$this->db->select("class_code, class_description, subject_description, fname, mname, lname, tbl_classes.class_id");
		$this->db->from("tbl_classes");
		$this->db->join("tbl_subject", "tbl_classes.subject_id = tbl_subject.subject_id");
		$this->db->join("tbl_classteachers", "tbl_classes.class_id = tbl_classteachers.class_id");
		$this->db->join("tbl_userinfo", "tbl_classteachers.teacher_id = tbl_userinfo.user_id");
		$classes = $this->db->get();
		
		
		if($classes->num_rows > 0){
			foreach($classes->result() as $row){
				$classes_array[] = array($row->fname, $row->mname, $row->lname, $row->class_description, $row->class_code, $row->subject_description, $row->class_id);
			}
		}
		return $classes_array;	
	}
	
	
	function select_classsubject(){//selects the courses associated with the selected subject
		$classes_array = array();
		$this->db->select("class_code, class_description, subject_description, fname, mname, lname");
		$this->db->from("tbl_classes");
		$this->db->join("tbl_subject", "tbl_classes.subject_id = tbl_subject.subject_id");
		$this->db->join("tbl_classteachers", "tbl_classes.class_id = tbl_classteachers.class_id");
		$this->db->join("tbl_userinfo", "tbl_classteachers.teacher_id = tbl_userinfo.user_id");
		
	
			$subject_id = $this->session->userdata('current_id');
			$this->db->where('tbl_classes.subject_id', $subject_id);
			
			
			$classes = $this->db->get();
			if($classes->num_rows > 0){
				foreach($classes->result() as $row){
					$classes_array[] = array($row->fname, $row->mname, $row->lname, $row->class_description, $row->class_code, $row->subject_description);
				}
			}
		return $classes_array;	
	}


	function select_classcourse(){//selects the courses associated with the selected class
			$classes_array = array();
			$course_id = $this->session->userdata('current_id');
			$course = array($course_id);
			$classes = $this->db->query("SELECT class_code, class_description, subject_description, fname, mname, lname
										FROM tbl_classes 
										LEFT JOIN tbl_subject ON tbl_classes.subject_id = tbl_subject.subject_id
										LEFT JOIN tbl_classteachers ON tbl_classes.class_id = tbl_classteachers.class_id
										LEFT JOIN tbl_userinfo ON tbl_classteachers.teacher_id = tbl_userinfo.user_id
										WHERE tbl_classes.course_id = ?", $course);

			if($classes->num_rows > 0){
				foreach($classes->result() as $row){
					$classes_array[] = array($row->fname, $row->mname, $row->lname, $row->class_description, $row->class_code, $row->subject_description);
				}
			}
			return $classes_array;
			
	}
	
	function select_coursecode(){
		$code = 0;
		$class_id = $this->session->userdata('current_id');
		$query = $this->db->query("SELECT class_code FROM tbl_classes WHERE class_id='$class_id'");
		if($query->num_rows > 0){
			$row = $query->row();
			$code = $row->class_code;
		}
		return $code;
	}
	
	function select_classinfo(){
		$class_info = array();
		$class_id = $this->session->userdata('current_class');
		//only 1 teacher per class but a teacher can have many classes
		$query = $this->db->query("SELECT class_code, class_description, fname, mname, lname, addl_notes
								FROM tbl_classes
								LEFT JOIN tbl_classteachers ON tbl_classes.class_id = tbl_classteachers.class_id
								LEFT JOIN tbl_userinfo ON tbl_classteachers.teacher_id = tbl_userinfo.user_id
								WHERE tbl_classes.class_id='$class_id'");
								
		if($query->num_rows > 0){
			$row = $query->row();
			$class_code = $row->class_code;
			$class_desc	= $row->class_description;
			$fname		= $row->fname;
			$mname		= $row->mname;
			$lname		= $row->lname;
			$notes		= $row->addl_notes;
			$class_info = array('class_code'=>$class_code, 'class_desc'=>$class_desc, 'fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname, 'notes'=>$notes);
		}
		return $class_info;
		
	}
	
	
	function class_modules(){//lists all the modules in the class
		$class_id 	= $this->session->userdata('current_class');
		$modules 	= $this->db->query("SELECT classmodule_id, mod_title, mod_description, status FROM tbl_classmodules 
										LEFT JOIN tbl_modules ON tbl_classmodules.module_id = tbl_modules.module_id
										WHERE class_id='$class_id'");
		$module_r 	= array();
		
		if($modules->num_rows() > 0){
			foreach($modules->result() as $row){
				$classmodule_id		= $row->classmodule_id;
				$mod_title			= $row->mod_title;
				$mod_description	= $row->mod_description;
				$status				= $row->status;
				
				$module_r[] = array('classmodule_id'=>$classmodule_id, 'mod_title'=>$mod_title, 'mod_description'=>$mod_description, 'status'=>$status);
			}
		}
		return $module_r;
	}
	
	function enable(){//enables a specific module
		$classmodule_id = $this->input->post('cm_id');
		$this->db->query("UPDATE tbl_classmodules SET status=1 WHERE classmodule_id='$classmodule_id'");
		
	}
	
	function disable(){//disables a specific module
		$classmodule_id = $this->input->post('cm_id');
		$this->db->query("UPDATE tbl_classmodules SET status=0 WHERE classmodule_id='$classmodule_id'");
	}
	
	function module_status($module_id){//returns the status of a module whether enabled or disabled
		$class_id 	= $this->session->userdata('current_class');
		
		$query = $this->db->query("SELECT status FROM tbl_classmodules WHERE module_id='$module_id' AND class_id='$class_id'");
		if($query->num_rows() > 0){
			$row 	= $query->row();
			$status = $row->status;
		}
		return $status;
	}
	
	function export(){//exports class data to other classes (Eg. handout, student)
		//all handouts and students are being exported
		$class_id	= $this->session->userdata('current_class');
		$exp_class	= $this->input->post('export_class'); //class id to export to
		$exp_type	= $this->input->post('export_type');
		if($exp_type == 0){//student
			$decision = $this->exported($class_id, $exp_class, $exp_type);
			
			if($decision == 0){
				$export = $this->db->query("INSERT INTO tbl_exports SET source_class='$class_id', receiving_class='$exp_class', export_type='$exp_type'");
				
				$query_student = $this->db->query("SELECT user_id FROM tbl_classpeople WHERE class_id='$class_id' AND status = 1");
				if($query_student->num_rows() > 0){
					foreach($query_student->result() as $row){
						
						$user_id = $row->user_id;
						$transfer_students = $this->db->query("INSERT INTO tbl_classpeople SET user_id='$user_id', class_id='$exp_class'");
					}
				}
			}
			
		}else if($exp_type == 1){//handout
			$decision = $this->exported($class_id, $exp_class, $exp_type);
			
			if($decision == 0){
				$export = $this->db->query("INSERT INTO tbl_exports SET source_class='$class_id', receiving_class='$exp_class', export_type='$exp_type'");
				
				$query_handout = $this->db->query("SELECT handout_id, ho_title, ho_body FROM tbl_handouts WHERE class_id='$class_id'");
				if($query_handout->num_rows() > 0){
					foreach($query_handout->result() as $row){
						$ho_id	  = 'HO'.$row->handout_id;
						$ho_title = $row->ho_title;
						$ho_body  = $row->ho_body;
						
						$this->db->query("INSERT INTO tbl_handouts SET class_id='$exp_class', ho_title='$ho_title', ho_body='$ho_body', date_posted=CURDATE()");
						$new_ho_id = 'HO'.$this->db->insert_id();
						
						$handout_files = $this->db->query("SELECT post_id, file_id FROM tbl_filepost WHERE post_id='$ho_id'");
						if($handout_files->num_rows() > 0){
							foreach($handout_files->result() as $row){
								$post_id = $row->post_id;
								$file_id = $row->file_id;
								$this->db->query("INSERT INTO tbl_filepost SET post_id='$new_ho_id', file_id='$file_id'");
							}
						}
					}
				}
			}
		}
	}
	
	
	function exported($source, $receiver, $type){//returns 0 if not exported to class, 1 if already exported before
		$query = $this->db->query("SELECT export_id FROM tbl_exports WHERE source_class='$source' AND receiving_class='$receiver' AND export_type='$type'");
		if($query->num_rows() > 0){
			return 1;
		}else{
			return 0;
		}
	}
}
?>