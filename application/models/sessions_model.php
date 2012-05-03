<?php
class sessions_model extends ci_Model{

	function create(){
		$user_id = $this->session->userdata('user_id');
		$user_name		= $this->session->userdata('user_name');
		/*
		session types:
		1- Masked
		2- Class	
		3- Team
		*/
		$class_id	= $_SESSION['current_class'];
		$ses_type 	= $_SESSION['session_type'];
		
		$ses_title	= $this->input->post('ses_title');
		$ses_desc	= $this->input->post('ses_body');
		$infinite	= $this->input->post('infinite'); //if session is infinitely accessible. 1 if infinite 2 if limited
		
		$time_from	= date('Y-m-d G:i:s', strtotime($this->input->post('time_from')));
		$time_to	= date('Y-m-d G:i:s', strtotime($this->input->post('time_to')));
		
		$ses_date 		= date('Y-m-d', strtotime($time_from));
		$ses_timefrom	= date('g:i:s A', strtotime($time_from));	
		$ses_timeto		= date('g:i:s A', strtotime($time_to));
		
		$member_grp	= $this->input->post('members');
		
		
		
		$session_data = array($class_id, $ses_type, $ses_title, $ses_desc, $infinite, $time_from, $time_to);
		
		$create_session = $this->db->query("INSERT INTO tbl_sessions SET class_id=?, ses_type=?, ses_title=?, ses_description=?, infinite=?, time_from=?, time_to=?", $session_data);
		$session_id		= $this->db->insert_id();
		
		
		
		
		$notif_status = $this->emailnotifs_model->status(5);
		
		
		
		
		$class_details= $this->classrooms_model->select_classinfo();
		$class_description= $class_details['class_desc'];
		
		$this->logs_model->lag(8, 'CS');
		
		if($member_grp == 0){//class and masked session
			
			
			
			
				$class_members = $this->classusers_model->class_users();
				foreach($class_members as $row){
					$member_id = $row['id'];
					$email = $row['email'];
					
					$this->db->query("INSERT INTO tbl_sessionspeople SET session_id='$session_id', user_id='$member_id'");
					if($notif_status == 1){
						if($email != ''){
						
							if($infinite == 2){
								$body = "<strong>Notification Type:</strong>New Session<br/>".
										"<strong>Session Type: </strong> Class Session<br/>" . 
										"<strong>Session Date: </strong>" . $ses_date . "<br/>" .
										"<strong>Start Time: </strong>" . $ses_timefrom . "<br/>" .
										"<strong>End Time: </strong>" . $ses_timeto . "<br/>" .
										"<strong>Sender:</strong>". $user_name . "<br/>" .
										"<strong>Class : </strong>" . $class_description . "<br/>" .
										"<strong>Message:</strong><br/>". $ses_desc;
							}else{
								$body = "<strong>Notification Type:</strong>New Session<br/>".
										"<strong>Session Type: </strong> Class Session<br/>" . 
										"<strong>Sender:</strong>". $user_name . "<br/>" .
										"<strong>Class : </strong>" . $class_description . "<br/>" .
										"<strong>Message:</strong><br/>". $ses_desc;
							}	
							
							$this->email->send($email, 'New Class Session: '. $ses_title, $body);
						}
					}
				}
			
			
			$this->db->query("INSERT INTO tbl_sessionspeople SET session_id='$session_id', user_id='$user_id'");
		
		}else{//team session
			
			
			foreach($member_grp as $groups){
				$group_id = $groups['value'];
				
				$group_members = $this->groups_model->group_members($group_id);
			
				
				foreach($group_members as $member_id){
					if($this->exists($member_id, $session_id) == 0){
						
						if($notif_status == 1){
							$email_address = $this->users->user_email($member_id);
							if($email_address != ''){
								if($infinite == 2){
									$body = "<strong>Notification Type:</strong>New Session<br/>".
											"<strong>Session Type: </strong> Team Session<br/>" .
											"<strong>Session Date: </strong>" . $ses_date . "<br/>" .
											"<strong>Start Time: </strong>" . $ses_timefrom . "<br/>" .
											"<strong>End Time: </strong>" . $ses_timeto . "<br/>" .
											"<strong>Sender:</strong>". $user_name . "<br/>" .
											"<strong>Class : </strong>" . $class_description . "<br/>" .
											"<strong>Message:</strong><br/>". $ses_desc;
								}else{
									$body = "<strong>Notification Type:</strong>New Session<br/>".
											"<strong>Session Type: </strong> Team Session<br/>" . 
											"<strong>Sender:</strong>". $user_name . "<br/>" .
											"<strong>Class : </strong>" . $class_description . "<br/>" .
											"<strong>Message:</strong><br/>". $ses_desc;
								}	
								$this->email->send($email_address, 'New Team Session: '.$ses_title, $body);	
							}
						}
						
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
		$class_id	= $_SESSION['current_class'];
		$sessions	= array();
		$query 		= $this->db->query("SELECT tbl_sessions.session_id, ses_title, ses_description, 
						DATE(time_from) AS date, time_from, time_to, ses_type, infinite 
						FROM tbl_sessions
						LEFT JOIN tbl_sessionspeople ON tbl_sessions.session_id = tbl_sessionspeople.session_id
						WHERE tbl_sessionspeople.user_id='$user_id' AND class_id='$class_id'
						ORDER BY date DESC");
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$id				= $row->session_id;
				$title			= $row->ses_title;
				$description	= $row->ses_description;
				$date			= $row->date;
				$from			= $row->time_from;
				$to				= $row->time_to;
				$type			= $row->ses_type;
				$infinite		= $row->infinite;
				$status			= $this->check($id);
				
				$sessions[] = array('status'=>$status, 'id'=>$id, 'title'=>$title, 'description'=>$description, 'date'=>$date, 'from'=>$from,'to'=>$to, 'type'=>$type, 'infinite'=>$infinite);
			}
		}
		return $sessions;
	}
	
	
	function view($session_id){//view basic info of a selected session
		
		$session_info = array();
		
		$query = $this->db->query("SELECT ses_title, ses_description, ses_type, DATE(time_from) AS date, infinite, time_from, time_to FROM tbl_sessions WHERE session_id=?", $session_id);
		if($query->num_rows() > 0){
			$row 			= $query->row();
			
			$title			= $row->ses_title;
			$description	= $row->ses_description;
			$date			= $row->date;
			$from			= $row->time_from;
			$to				= $row->time_to;
			$type			= $row->ses_type;
			$infinite		= $row->infinite;
			
			$session_info	= array('id'=>$session_id, 'title'=>$title, 'description'=>$description, 'date'=>$date, 'from'=>$from,'to'=>$to, 'type'=>$type, 'infinite'=>$infinite);
			$_SESSION['ses'] = $session_info;
		}
		return $session_info;
	}
	
	function check($session_id){
		//if infinite can access everytime
		$limited = $this->db->query("SELECT infinite FROM tbl_sessions WHERE session_id=? AND infinite=0 AND NOW() BETWEEN time_from AND time_to", $session_id);
		
		$infinite = $this->db->query("SELECT infinite FROM tbl_sessions WHERE session_id=? AND infinite=1", $session_id);
		
		if($limited->num_rows() == 1 || $infinite->num_rows() == 1){
			return 1;
		}else{
			return 0;
		}
	}
	
	function content(){//loads all the content of a specific content 
		if($this->uri->segment(4) == 'id'){
			$session_id 	= $this->uri->segment(5); 
			$_SESSION['ses']['title'] = $this->uri->segment(6);
		}else{
			$session_id 	= $_SESSION['ses']['id']; 
		}
		$session_content= array();
		$conversation	= $this->db->query("SELECT mask_name, message, time_sent FROM tbl_sessioncontent WHERE session_id=?", $session_id);
		if($conversation->num_rows() > 0){
			foreach($conversation->result() as $row){
				$mask_name	= $row->mask_name;
				$message	= $row->message;
				$time		= $row->time_sent;
				$session_content[] = array('mask'=>$mask_name, 'msg'=>$message, 'time'=>$time);
			}
		}
		return $session_content;
	}
	
	
	function session_count(){//returns the number of active sessions for the current class
		$class_id 	= $_SESSION['current_class'];
		$query		= $this->db->query("SELECT session_id FROM tbl_sessions WHERE class_id='$class_id' AND (time_to >= NOW() OR infinite = 1)");
		return $query->num_rows();
	}
}
?>