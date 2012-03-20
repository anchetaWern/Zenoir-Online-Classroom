<?php
class groups_model extends ci_Model{
	
	function create(){
		$user_id	= $this->session->userdata('user_id');
		$class_id	= $this->session->userdata('current_class');
		
		$group_name	= $this->input->post('group_name');
		$members 	= $this->input->post('members');
		
		$group_data = array($class_id, $group_name, $user_id);
		
		$create_group 	= $this->db->query("INSERT INTO tbl_groups SET class_id=?, group_name=?, group_creator=?", $group_data);
		$group_id		= $this->db->insert_id();
		
		foreach($members as $member_id){
			$member_id = $member_id['value'];
			$this->db->query("INSERT INTO tbl_grouppeople SET group_id='$group_id', user_id='$member_id'");
		}
		
		$this->db->query("INSERT INTO tbl_grouppeople SET group_id='$group_id', user_id='$user_id'");
		
	
	}
	
	function list_all(){//lists all the groups where the current user belongs
		$user_id	= $this->session->userdata('user_id');
		
		$groups_r 	= array();
		$users_group=$this->db->query("SELECT group_id, group_name, CONCAT_WS(', ', UPPER(lname), fname) AS creator FROM tbl_groups 
										LEFT JOIN tbl_userinfo ON tbl_groups.group_creator = tbl_userinfo.user_id");
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
	
	
}
?>