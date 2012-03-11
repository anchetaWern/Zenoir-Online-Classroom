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
	
	function user_name($user_id){
		$user_data = array($user_id);
		$get_user = $this->db->query("SELECT fname, lname FROM tbl_userinfo WHERE user_id=?", $user_data);
		if($get_user->num_rows() > 0){
			$row = $get_user->row();
			return $row->fname . ' ' . $row->lname;
		} 
	}
	
	function user_info($user_id){
		$user_data = array();
		$user_id = array($user_id);
		$get_user = $this->db->query("SELECT * FROM tbl_userinfo WHERE user_id=?", $user_id);
		if($get_user->num_rows() > 0){
			$row = $get_user->row();
			$user_data = array('fname'=>$row->fname, 'mname'=>$row->mname, 'lname'=>$row->lname, 'auto_bio'=>$row->autobiography);
		}
		return $user_data;
	}
	
	function update_user(){
		$user_id = $this->session->userdata('user_id');
		$fname = $this->input->post('fname');
		$mname = $this->input->post('mname');
		$lname = $this->input->post('lname');
		$password = md5($this->input->post('pword'));
		$autobiography = $this->input->post('autobiography');
		
		$user_data = array($fname, $mname, $lname, $autobiography, $user_id);
		
		if(!empty($password)){
			
			$password = array($password, $user_id);
			
			$update_accountinfo = $this->db->query("UPDATE tbl_userinfo SET fname=?, mname=?, lname=?, autobiography=? WHERE user_id=?", $user_data);
			$update_password = $this->db->query("UPDATE tbl_users SET hashed_password=? WHERE user_id=?", $password);
		}else{
			
			$update_accountinfo = $this->db->query("UPDATE tbl_userinfo SET fname=?, mname=?, lname=?, autobiography=? WHERE user_id=?", $user_data);
		}
	}
}
?>