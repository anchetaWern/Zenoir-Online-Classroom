<?php
class courses_model extends ci_Model{
	function create_course(){
		$course_code	= $this->input->post('course_code');
		$description	= $this->input->post('course_desc');
		$data 			= array($course_code, $description);
		
		$this->db->query("INSERT INTO tbl_courses SET course_code=?, course_description=?", $data);
	}
	
	function update_course(){
		$course_id		= $this->input->post('course_id');
		$course_code	= $this->input->post('course_code');
		$description	= $this->input->post('course_desc');
		
		$data			= array($course_code, $description, $course_id);
		
		$this->db->query("UPDATE tbl_courses SET course_code=?, course_description=? WHERE course_id=?", $data);
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