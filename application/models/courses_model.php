<?php
class courses_model extends ci_Model{
	function create_course(){
		$course_code	= $this->input->post('course_code');
		$description	= $this->input->post('course_desc');
		$data 			= array($course_code, $description);
		
		$this->db->query("INSERT INTO tbl_courses SET course_code=?, course_description=?", $data);
	}
	
	function update_course(){
		$course_id		= $_SESSION['current_id'];
		$course_code	= $this->input->post('course_code');
		$description	= $this->input->post('course_desc');
		
		$data			= array($course_code, $description, $course_id);
		
		$this->db->query("UPDATE tbl_courses SET course_code=?, course_description=? WHERE course_id=?", $data);
	}
	
	function get_course(){
		$course_info	= array();
		$course_id 		= $_SESSION['current_id'];
		$course 		= $this->db->query("SELECT * FROM tbl_courses WHERE course_id='$course_id'");
		if($course->num_rows() > 0){
			$row 			= $course->row();
			$course_code	= $row->course_code;
			$course_desc	= $row->course_description;
			$course_info = array('course_code'=>$course_code, 'course_desc'=>$course_desc);
		}
		return $course_info;
	}
	
	function course_code($course_id){
		$query = $this->db->query("SELECT course_code FROM tbl_courses WHERE course_id='$course_id'");
		$course_code = 0;
		if($query->num_rows() > 0){
			$row = $query->row();
			$course_code = $row->course_code;
		}
		return $course_code;
	}
	
	function select_courses(){
		$courses_array = array();
		$courses = $this->db->get("tbl_courses");
		if($courses->num_rows() > 0){
			foreach($courses->result() as $row){
				$courses_array[] = array($row->course_code, $row->course_description, $row->course_id);
			}
		}
		return $courses_array;
	}
}
?>