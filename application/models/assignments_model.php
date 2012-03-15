<?php
class assignments_model extends ci_Model{
		
		function create(){
			$title		= $this->input->post('as_title');
			$body		= $this->input->post('as_body');
			$class_id	= $this->session->userdata('current_class');
			$date		= $this->input->post('as_date');
			$deadline	= $this->input->post('as_deadline');
			
			$data 		= array($title, $body, $class_id, $date, $deadline);
			$this->db->query("INSERT INTO tbl_assignment SET as_title=?, as_body=?, class_id=?, date=?, deadline=?", $data);
		}
		
		function delete(){
			$assignment_id = $this->input->post('as_id');
			$this->db->query("UPDATE tbl_assignment SET status=0 WHERE assignment_id='$assignment_id'");
		}
		
		function list_all(){
			//even teachers and admins cannot see assignments that are deleted
			$assignments = array();
			$query = $this->db->query("SELECT * FROM tbl_assignment WHERE status=1"); 
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$assignments[] = array('title'=>$row->as_title, 'body'=>$row->as_body, 'date'=>$row->date, 'deadline'=>$row->deadline);
				}
			}
			return $assignments;
		}
	
}
?>