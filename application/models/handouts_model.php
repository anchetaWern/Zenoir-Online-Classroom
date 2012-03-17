<?php
class handouts_model extends ci_Model{
		
		
	function create(){
		$class_id	= $this->session->userdata('current_class');
		$ho_title	= $this->input->post('ho_title');
		$ho_body	= $this->input->post('ho_body');
		
		$data = array($class_id, $ho_title, $ho_body);
		$this->db->query("INSERT INTO tbl_handouts SET class_id=?, ho_title=?, ho_body=?, date_posted=CURDATE()", $data);
	
		$handout_id = $this->db->insert_id();
		$handout_id = 'HO'.$handout_id;
		$this->session->set_userdata('post_id', $handout_id);
	}
	
	function list_all(){
		$class_id	= $this->session->userdata('current_class');
		$handouts_r = array();
		$handouts = $this->db->query("SELECT ho_title, date_posted FROM tbl_handouts WHERE class_id='$class_id' AND status = 1");
		if($handouts->num_rows > 0){
			foreach($handouts->result() as $row){
				$handouts_r[] = array('ho_title'=>$row['ho_title'], 'date_posted'=>$row['date_posted']);
			}
		}
		return $handouts_r;
	}

}
?>