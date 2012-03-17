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
			$query = $this->db->query("SELECT as_title, as_body, date, deadline FROM tbl_assignment WHERE class_id='$class_id' AND status=1"); 
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$assignments[] = array('title'=>$row->as_title, 'date'=>$row->date, 'deadline'=>$row->deadline);
				}
			}
			return $assignments;
		}
	
}
?>