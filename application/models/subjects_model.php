<?php
class subjects_model extends ci_Model{
	function create_subject(){
		$subject_code	= $this->input->post('subject_code');
		$description	= $this->input->post('description');
		$data 			= array($subject_code, $description);
		
		$create = $this->db->query("INSERT INTO tbl_subject SET subject_code=?, subject_description=?", $data);
	}
	
	function update_subject(){
		$subject_id		= $this->input->post('subject_id');
		$subject_code	= $this->input->post('subject_code');
		$description	= $this->input->post('description');
		$data 			= array($subject_code, $description, $subject_id);
		
		$update = $this->db->query("UPDATE tbl_subject SET subject_code=?, subject_description=? WHERE subject_id=?", $data);
	}
	
	function select_subjects(){
		$subject_array = array();
		$subjects = $this->db->get("tbl_subject");
		if($subjects->num_rows > 0){
			foreach($subjects->result() as $row){
				$subject_array[] = array($row->subject_code, $row->subject_description, $row->subject_id);
			}
		}
		return $subject_array;
	}
}
?>