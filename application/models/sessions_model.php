<?php
class sessions_model extends ci_Model{

	function create(){
		/*
		session types:
		1- Masked
		2- Class	
		3- Team
		*/
		$class_id	= $this->session->userdata('current_class');
		$ses_type 	= $this->session->userdata('session_type');
		
		$ses_title	= $this->input->post('ses_title');
		$ses_desc	= $this->input->post('ses_body');
		$infinite	= $this->input->post('infinite'); //if session is infinitely accessible. 1 if infinite 2 if limited
		
		$time_from	= date('Y-m-d G:i:s', strtotime($this->input->post('time_from')));
		$time_to	= date('Y-m-d G:i:s', strtotime($this->input->post('time_to')));
		$member_grp	= $this->input->post('members');
		
		
		
		$session_data = array($class_id, $ses_type, $ses_title, $ses_desc, $infinite, $time_from, $time_to);
		
		$create_session = $this->db->query("INSERT INTO tbl_sessions SET class_id=?, ses_type=?, ses_title=?, ses_description=?, infinite=?, time_from=?, time_to=?", $session_data);
		$session_id		= $this->db->insert_id();
		
		
		
		if($member_grp == 0){//class and masked session
			$this->load->model('classusers_model');
			$class_members = $this->classusers_model->class_users();
			foreach($class_members as $row){
				$member_id = $row['id'];
				$this->db->query("INSERT INTO tbl_sessionspeople SET session_id='$session_id', user_id='$member_id'");
			}
		
		}else{//team session
			$this->load->model('groups_model');
			
			foreach($member_grp as $groups){
				$group_id = $groups['value'];
				echo $group_id;
				$group_members = $this->groups_model->group_members($group_id);
				
				foreach($group_members as $member_id){
					if($this->exists($member_id, $session_id) == 0){
						$this->db->query("INSERT INTO tbl_sessionspeople SET session_id='$session_id', user_id='$member_id'");
					}
				}//inner loop	
			}//outer loop
		}
		
	}
	
	function exists($user_id, $session_id){//checks if a person is already added in a specific session
		$existing = 0;
		$query = $this->db->query("SELECT user_id FROM tbl_sessionspeople WHERE session_id='$session_id' AND user_id='$user_id'");
		if($query->num_rows() > 0){
			$existing = 1;
		}
		return $existing;
	}
	
	function list_all(){//list all the sessions where the current user has been invited or participated
		$user_id	= $this->session->userdata('user_id');
		$sessions	= array();
		$query 		= $this->db->query("SELECT tbl_sessions.session_id, ses_title, ses_description, time_from, time_to, ses_type, infinite FROM tbl_sessions
						LEFT JOIN tbl_sessionspeople ON tbl_sessions.session_id = tbl_sessionspeople.session_id
						WHERE tbl_sessionspeople.user_id='$user_id'");
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$id				= $row->session_id;
				$title			= $row->ses_title;
				$description	= $row->ses_description;
				$from			= $row->time_from;
				$to				= $row->time_to;
				$type			= $row->ses_type;
				$infinite		= $row->infinite;
				
				$sessions[] = array('id'=>$id, 'title'=>$title, 'description'=>$description, 'from'=>$from,'to'=>$to, 'type'=>$type, 'infinite'=>$infinite);
			}
		}
		return $sessions;
	}
	
	
	function view(){//view the conversation in a session
	
	}
}
?>