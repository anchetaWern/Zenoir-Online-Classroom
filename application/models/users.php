<?php
class users extends ci_Model{
	
	function validate($user_id, $password){
		
		$user_credentials = array($user_id, $password);
		$exists = $this->db->query("SELECT user_id FROM tbl_users WHERE user_id=? AND hashed_password=?", $user_credentials);
		if($exists->num_rows == 1){
			return true;
		}
	}
	
	function usertype($user_id){
		$user_data = array($user_id);
		$get_user = $this->db->query("SELECT user_type FROM tbl_users WHERE user_id=?", $user_data);
		
		if ($get_user->num_rows() > 0){
		   $row = $get_user->row(); 
		   return $row->user_type;
		}
	}
}
?>