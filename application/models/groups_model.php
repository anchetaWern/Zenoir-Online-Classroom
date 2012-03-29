<?php
class groups_model extends ci_Model{
	
	function create(){
		$user_id	= $this->session->userdata('user_id');
		$class_id	= $_SESSION['current_class'];
		
		$group_name	= $this->input->post('group_name');
		$members 	= $this->input->post('members');
		
		$group_data = array($class_id, $group_name, $user_id);
		
		$create_group 	= $this->db->query("INSERT INTO tbl_groups SET class_id=?, group_name=?, group_creator=?", $group_data);
		$group_id		= $this->db->insert_id();
		
		foreach($members as $member_id){
			$member_id = $member_id['value'];
			$this->db->query("INSERT INTO tbl_grouppeople SET group_id='$group_id', user_id='$member_id'");
		}
		
		//group creator
		$this->db->query("INSERT INTO tbl_grouppeople SET group_id='$group_id', user_id='$user_id'");
		
	
	}
	
	function update(){
		$user_id	= $this->session->userdata('user_id');
		$group_id	= $_SESSION['current_id'];
		
		$group_name	= $this->input->post('group_name');
		$members 	= $this->input->post('members');
		
		$group_data = array($group_name, $group_id);
		
		$update_group = $this->db->query("UPDATE tbl_groups SET group_name=? WHERE group_id=?", $group_data);
		
		foreach($members as $member_id){
			$member_id = $member_id['value'];
			$this->db->query("INSERT INTO tbl_grouppeople SET group_id='$group_id', user_id='$member_id'");
		}
	}
	
	function list_all(){//lists all the groups where the current user belongs
		$user_id	= $this->session->userdata('user_id');
		
		$groups_r 	= array();
		$users_group=$this->db->query("SELECT tbl_groups.group_id, group_name, CONCAT_WS(', ', UPPER(lname), fname) AS creator FROM tbl_groups 
										LEFT JOIN tbl_userinfo ON tbl_groups.group_creator = tbl_userinfo.user_id
										LEFT JOIN tbl_grouppeople ON tbl_groups.group_id = tbl_grouppeople.group_id
										WHERE tbl_grouppeople.user_id='$user_id'");
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
		$group_id = $_SESSION['current_id'];
		$creator_id = 0;
		$query = $this->db->query("SELECT group_creator FROM tbl_groups WHERE group_id='$group_id'");
		if($query->num_rows() > 0){
			$row = $query->row();
			$creator_id = $row->group_creator;
		}
		return $creator_id;
	}
	
	function view(){
		$group_id = $_SESSION['current_id'];
		$group = $this->db->query("SELECT group_people_id, group_name , tbl_grouppeople.user_id, fname, mname, lname
									FROM tbl_groups
									LEFT JOIN tbl_grouppeople ON tbl_groups.group_id = tbl_grouppeople.group_id
									LEFT JOIN tbl_userinfo ON tbl_grouppeople.user_id = tbl_userinfo.user_id
									WHERE tbl_grouppeople.group_id=? AND tbl_grouppeople.user_id != tbl_groups.group_creator", $group_id);
		$group_data = array();
		if($group->num_rows() > 0){
			foreach($group->result() as $row){
				$group_people_id = $row->group_people_id;
				$member_id  = $row->user_id;
				$fname		= $row->fname;
				$mname		= $row->mname;
				$lname		= $row->lname;
				$group_name = $row->group_name;
				
				$group_data['invited'] =  $this->non_members($group_id);
				$group_data['group'] = array('group_id'=>$group_id, 'group_name'=>$group_name);
				$group_data['members'][] = array('group_people_id'=>$group_people_id ,'member_id'=>$member_id, 'fname'=>$fname, 'mname'=>$mname, 'lname'=>$lname);
				
			}
			
			
		}
		return $group_data;
	}
	
	function group_members($group_id){//returns all the ids of the group members of a specific group
		$query 		= $this->db->query("SELECT user_id FROM tbl_grouppeople WHERE group_id='$group_id'");
		$member_r	= array();
		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$member_id 	= $row->user_id;
				$member_r[] = $member_id; 
			
			}
		}
		
		return $member_r;
	}
	
	function del_member($group_people_id){
		$this->db->query("DELETE FROM tbl_grouppeople WHERE group_people_id=?", $group_people_id);
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
	
	
}
?>