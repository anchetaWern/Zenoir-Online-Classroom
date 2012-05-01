<?php
class groups_model extends ci_Model{
	
	function create(){
		$user_id	= $this->session->userdata('user_id');
		$user_name		= $this->session->userdata('user_name');
		$class_id	= $_SESSION['current_class'];
		
		$group_name	= $this->input->post('group_name');
		$members 	= $this->input->post('members');
		
		$group_data = array($class_id, $group_name, $user_id);
		
		$create_group 	= $this->db->query("INSERT INTO tbl_groups SET class_id=?, group_name=?, group_creator=?", $group_data);
		$group_id		= $this->db->insert_id();
		
		
		
	
		
		foreach($members as $member_id){
			$member_id = $member_id['value'];
			$this->db->query("INSERT INTO tbl_grouppeople SET group_id='$group_id', user_id='$member_id'");
			
			//send emails to members if the email notification is enabled for group invites
			if($this->emailnotifs_model->status(11) == 1){
			
				$email_address = $this->users->user_email($member_id);
				if($email_address != ''){
					$body = "<strong>Notification Type:</strong>Group Invite<br/>
							<strong>Sender:</strong>". $user_name . "<br/>" . 
							"<strong>Group : </strong>" . $group_name . "<br/>" .
							"<strong>Message:</strong><br/>You have been invited to join " . $group_name . 
							"<br/>login to your account to accept or decline the invitation";
					
					$this->email->send($email_address, "Group Invite - $group_name" , $body);
				}
				
			}
		}
		
		//group creator
		$this->db->query("INSERT INTO tbl_grouppeople SET group_id='$group_id', user_id='$user_id', status=1");
		
	
		
		$this->logs_model->nlag(17, 'CG', $group_id);
	}
	
	function update(){
		$user_id	= $this->session->userdata('user_id');
		$user_name	= $this->session->userdata('user_name');
		$group_id	= $_SESSION['current_id'];
		
		$group_name	= $this->input->post('group_name');
		$members 	= $this->input->post('members');
		
		$group_data = array($group_name, $group_id);
		
		$update_group = $this->db->query("UPDATE tbl_groups SET group_name=? WHERE group_id=?", $group_data);
		
	
		
		
		
		
		foreach($members as $member_id){
			$member_id = $member_id['value'];
			$this->db->query("INSERT INTO tbl_grouppeople SET group_id='$group_id', user_id='$member_id'");
			
			//send emails to members if the email notification is enabled for group invites
			if($this->emailnotifs_model->status(11) == 1){
			
				$email_address = $this->users->user_email($member_id);
				if($email_address != ''){
					$body = "<strong>Notification Type:</strong>Group Invite<br/>
							<strong>Sender:</strong>". $user_name . "<br/>" . 
							"<strong>Group : </strong>" . $group_name . "<br/>" .
							"<strong>Message:</strong><br/>You have been invited to join " . $group_name . 
							"<br/>login to your account to accept or decline the invitation";
					
					$this->email->send($email_address, "Group Invite - $group_name" , $body);
				}
				
			}
		}
		
		
		$this->logs_model->nlag(18, 'UG', $group_id);
	}
	
	function list_all(){//lists all the groups where the current user belongs
		$user_id	= $this->session->userdata('user_id');
		$class_id	= $_SESSION['current_class'];
		
		$groups_r 	= array();
		$users_group=$this->db->query("SELECT tbl_groups.group_id, group_name, CONCAT_WS(', ', UPPER(lname), fname) AS creator FROM tbl_groups 
										LEFT JOIN tbl_userinfo ON tbl_groups.group_creator = tbl_userinfo.user_id
										LEFT JOIN tbl_grouppeople ON tbl_groups.group_id = tbl_grouppeople.group_id
										WHERE tbl_grouppeople.user_id='$user_id' AND class_id='$class_id' AND status = 1");
		if($users_group->num_rows() > 0){
			foreach($users_group->result() as $row){
				$group_id	= $row->group_id;
				$name 		= $row->group_name;
				$creator	= $row->creator;
				$groups_r[] = array('group_id'=>$group_id, 'name'=>$name, 'creator'=>$creator);
			}
		}
		return $groups_r;
	}
	
	function group_owner(){//returns the id of the group owner of the current group
		$group_id = $this->uri->segment(4);
		$creator_id = 0;
		$query = $this->db->query("SELECT group_creator FROM tbl_groups WHERE group_id='$group_id'");
		if($query->num_rows() > 0){
			$row = $query->row();
			$creator_id = $row->group_creator;
		}
		return $creator_id;
	}
	
	function view(){
		$group_id = $this->uri->segment(4);
		$group = $this->db->query("SELECT group_people_id, group_name , tbl_grouppeople.user_id, fname, mname, lname
									FROM tbl_groups
									LEFT JOIN tbl_grouppeople ON tbl_groups.group_id = tbl_grouppeople.group_id
									LEFT JOIN tbl_userinfo ON tbl_grouppeople.user_id = tbl_userinfo.user_id
									WHERE tbl_grouppeople.group_id=? AND tbl_grouppeople.user_id != tbl_groups.group_creator AND status=1", $group_id);
		$group_data = array();
		
		$details = $this->group_details();
		$grp_name= $details['group_name'];
		$c_fname = $details['fname'];
		$c_lname = $details['lname'];
		
		$group_data['group'] = array('group_id'=>$group_id, 'group_name'=>$grp_name, 'cfname'=>$c_fname, 'clname'=>$c_lname);
		$group_data['invited'] =  $this->non_members($group_id);
		
		if($group->num_rows() > 0){
			foreach($group->result() as $row){
				$group_people_id = $row->group_people_id;
				$member_id  = $row->user_id;
				$fname		= $row->fname;
				$mname		= $row->mname;
				$lname		= $row->lname;
				$group_name = $row->group_name;
				
				$group_data['members'][] = array('group_people_id'=>$group_people_id ,'member_id'=>$member_id, 'fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname);
				
			}	
		}
		
	
		return $group_data;
	}
	
	function group_details(){
		$group_id = $this->uri->segment(4);
		
		$details = array();
		$query = $this->db->query("SELECT group_name, fname, mname, lname FROM tbl_groups
								LEFT JOIN tbl_userinfo ON tbl_groups.group_creator = tbl_userinfo.user_id
								WHERE group_id = '$group_id'");
								
		if($query->num_rows() > 0){
			$row = $query->row();
			
			$group_name = $row->group_name;
			$fname		= $row->fname;
			$mname		= $row->mname;
			$lname		= $row->lname;
			
			$details = array('group_name'=>$group_name, 'fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname);
		}
		return $details;
	}
	
	function group_members($group_id){//returns all the ids of the group members of a specific group
		$query 		= $this->db->query("SELECT user_id FROM tbl_grouppeople WHERE group_id='$group_id' AND status = 1");
		$member_r	= array();
		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$member_id 	= $row->user_id;
				$member_r[] = $member_id; 
			
			}
		}
		
		return $member_r;
	}
	
	function del_member($group_people_id){//remove member from the group
		$user_name		= $this->session->userdata('user_name');
	
		
		
		$member_id = $this->member_id($group_people_id);
		$group_name = $this->group_name($group_people_id);
		
	
	
		//send emails to the member that has been removed from the group
		if($this->emailnotifs_model->status(13) == 1){
		
			$email_address = $this->users->user_email($member_id);
			if($email_address != ''){
				$body = "<strong>Notification Type:</strong>Group member removal<br/>
						<strong>Sender:</strong>". $user_name . "<br/>" . 
						"<strong>Group : </strong>" . $group_name . "<br/>" .
						"<strong>Message:</strong><br/>You have been removed from " . $group_name . 
						"<br/>please approach the group owner if you think this is a mistake";
				
				$this->email->send($email_address, "Group Invite - $group_name" , $body);
				$this->db->query("DELETE FROM tbl_grouppeople WHERE group_people_id=?", $group_people_id);
			}
			
		}
	
	}
	
	function group_name($group_people_id){//returns group name from group people id
		$query = $this->db->query("SELECT group_name FROM tbl_grouppeople 
								LEFT JOIN tbl_groups ON tbl_grouppeople.group_id = tbl_groups.group_id
								WHERE group_people_id='$group_people_id'");
		$group_name = '';
		if($query->num_rows() > 0){
			$row = $query->row();
			$group_name = $row->group_name;
		}
		return $group_name;
	}
	
	function member_id($group_people_id){//returns the member id from the group people id
		$member = 0;
		$query = $this->db->query("SELECT user_id FROM tbl_grouppeople WHERE group_people_id = '$group_people_id'");
		if($query->num_rows() > 0){
			$row = $query->row();
			$member = $row->user_id;
		}
		return $member;
	}
	
	function non_members($group_id){//select members of the class who are not members of the group yet
		$class_id = $_SESSION['current_class'];
		$group_members = $this->group_members($group_id);
		$invite_members = array();
		$query = $this->db->query("SELECT tbl_classpeople.user_id, fname, lname FROM tbl_classpeople 
									LEFT JOIN tbl_userinfo ON tbl_classpeople.user_id = tbl_userinfo.user_id
									WHERE class_id='$class_id'");
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$user_id = $row->user_id;
				$fname	= $row->fname;
				$lname	= $row->lname;
				if(!in_array($user_id, $group_members)){//exclude users who are already members of the group
					$invite_members[] = array('user_id'=>$user_id, 'fname'=>$fname, 'lname'=>$lname);
				}
			}
		}
		return $invite_members;
	}
	
	function pendings(){//returns pending members of a specific group
		$class_id = $_SESSION['current_class'];
		$group_id = $this->uri->segment(4);
		
		$pending_members = array();
		$query = $this->db->query("SELECT tbl_grouppeople.user_id, fname, lname FROM tbl_grouppeople
									LEFT JOIN tbl_groups ON tbl_grouppeople.group_id = tbl_groups.group_id
									LEFT JOIN tbl_userinfo ON tbl_grouppeople.user_id = tbl_userinfo.user_id
									WHERE status = 0 AND tbl_grouppeople.group_id = '$group_id' AND class_id='$class_id'");
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$user_id = $row->user_id;
				$fname	= $row->fname;
				$lname	= $row->lname;
				
				$pending_members[] = array('user_id'=>$user_id, 'fname'=>$fname, 'lname'=>$lname);
				
			}
		}
		return $pending_members;
	}
	
	function accept(){
		$group_id	= $this->input->post('group_id');
		$user_id	= $this->input->post('user_id');
			
		$this->db->query("UPDATE tbl_grouppeople SET status = 1 WHERE group_id='$group_id' AND user_id='$user_id'");
		
		
		$this->logs_model->nlag(20, 'AG', $group_id);
	}
	
	function decline(){
		$group_id	= $this->input->post('group_id');
		$user_id	= $this->input->post('user_id');
		
		$this->db->query("DELETE FROM tbl_grouppeople WHERE group_id='$group_id' AND user_id='$user_id'");
		
		
		$this->logs_model->nlag(21, 'DG', $group_id);
	}
	
	
}
?>