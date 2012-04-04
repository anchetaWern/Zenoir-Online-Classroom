<?php
class handouts_model extends ci_Model{
		
		
	function create(){
		$class_id	= $_SESSION['current_class'];
		$ho_title	= $this->input->post('ho_title');
		$ho_body	= $this->input->post('ho_body');
		
		$data = array($class_id, $ho_title, $ho_body);
		$this->db->query("INSERT INTO tbl_handouts SET class_id=?, ho_title=?, ho_body=?, date_posted=CURDATE()", $data);
	
		$handout_id = $this->db->insert_id();
		$handout_id = 'HO'.$handout_id;
		$_SESSION['post_id'] = $handout_id;
		
		$this->load->model('post');
		$this->load->model('classusers_model');
		$this->load->model('email');
		
		$this->post->class_post($handout_id , 2);
		
		$class_users = $this->classusers_model->class_users();
		foreach($class_users as $row){
			$email = $row['email'];
			if($email != ''){
				$this->email->send($email, $ho_title, $ho_body);
			}
		}
	}
	
	function list_all(){
		$class_id	= $_SESSION['current_class'];
		$handouts_r = array();
		$this->load->model('post');
		$handouts = $this->db->query("SELECT handout_id, ho_title, date_posted FROM tbl_handouts WHERE class_id='$class_id' AND status = 1 ORDER BY date_posted DESC");
		if($handouts->num_rows > 0){
			foreach($handouts->result() as $row){	
				$handout_id=$row->handout_id;
				$ho_title  = $row->ho_title;
				$ho_date   = $row->date_posted;
				
				$post_status = $this->post->status('HO'.$handout_id);
				$handouts_r[] = array('status'=>$post_status,'handout_id'=>$handout_id,'ho_title'=>$ho_title, 'date_posted'=>$ho_date);
			}
		}
		return $handouts_r;
	}
	
	function view(){//view the contents of a single handout
		$handout_id = $_SESSION['current_id'];
		$handout_details['handout'] = array();
		$handout_details['handout_files'] = array();
		
		$handout = $this->db->query("SELECT * FROM tbl_handouts WHERE handout_id='$handout_id'");
		if($handout->num_rows() > 0){
		
				$row = $handout->row();
				$ho_id	   = $row->handout_id;
				$file_ho_id= 'HO'.$ho_id;
				$ho_title  = $row->ho_title;
				$ho_body   = $row->ho_body;
				$ho_date   = $row->date_posted;
				$handout_details = array('ho_title'=>$ho_title, 'ho_body'=>$ho_body, 'ho_date'=>$ho_date);
				
				//load files attached to a handout
				$this->load->model('files');
				$handout_details['handout_files'] = $this->files->view($file_ho_id);
				
				
		}
		return $handout_details;
	}

}
?>