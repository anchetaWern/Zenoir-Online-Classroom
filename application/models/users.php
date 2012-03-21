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
		$uid = $user_id;
		$user_id = array($user_id);
		$get_user = $this->db->query("SELECT * FROM tbl_userinfo WHERE user_id=?", $user_id);
		
		
		
		if($get_user->num_rows() > 0){
			$row = $get_user->row();
			
			$user_data = array('user_id'=>$uid, 'fname'=>$row->fname, 'mname'=>$row->mname, 'lname'=>$row->lname, 'auto_bio'=>$row->autobiography);
		}
		return $user_data;
	}
	
	function create_user(){
		$user_id 	= $this->input->post('user_id');
		$password	= md5($this->input->post('user_id'));
		$user_type 	= $this->input->post('user_type');
		$fname		= $this->input->post('fname');
		$mname		= $this->input->post('mname');
		$lname		= $this->input->post('lname');
		
		$account	= array($user_id, $password, $user_type);
		$info		= array($user_id, $fname, $mname, $lname);
		
		$create_account = $this->db->query("INSERT INTO tbl_users SET user_id=?, hashed_password=?, user_type=?", $account);
		$create_info	= $this->db->query("INSERT INTO tbl_userinfo SET user_id=?, fname=?, mname=?, lname=?", $info);
		
	}
	
	function update_user(){
		//only the user who is currently logged in can update their own information
		$user_id = $this->session->userdata('user_id'); 
		$fname = $this->input->post('fname');
		$mname = $this->input->post('mname');
		$lname = $this->input->post('lname');
		
		$user_name = $fname . ' ' . $lname;
		
		$password = md5($this->input->post('pword'));
		$autobiography = $this->input->post('autobiography');
		
		
		$user_data = array($fname, $mname, $lname, $autobiography, $user_id);
		
		if(!empty($password)){
			
			$password = array($password, $user_id);
			
			$update_accountinfo = $this->db->query("UPDATE tbl_userinfo SET fname=?, mname=?, lname=?, autobiography=? WHERE user_id=?", $user_data);
			$update_password = $this->db->query("UPDATE tbl_users SET hashed_password=? WHERE user_id=?", $password);
			
			$user_id = 'UI'.$user_id;
			$this->session->set_userdata('post_id', $user_id);
		}else{
		
			$update_accountinfo = $this->db->query("UPDATE tbl_userinfo SET fname=?, mname=?, lname=?, autobiography=? WHERE user_id=?", $user_data);
			
			
			$user_id = 'UI'.$user_id;
			$this->session->set_userdata('post_id', $user_id);
		}
		
		$this->session->set_userdata('user_name', $user_name);
		
		
	}
	
	function select_users(){
		$users_array = array();
		
		$this->db->select('fname, mname, lname, tbl_users.user_id, user_type');
		$this->db->from('tbl_users');
		$this->db->join('tbl_userinfo', 'tbl_users.user_id = tbl_userinfo.user_id');
		$users = $this->db->get();
		
		if($users->num_rows() > 0){
			foreach($users->result() as $row){
				$user_type = $this->get_usertype($row->user_type);
				$users_array[] = array($row->fname, $row->mname, $row->lname, $user_type, $row->user_id);
			}
		}
		return $users_array;
	}
	
	function get_usertype($type_id){
		switch($type_id){
			case 1:
				return 'Administrator';
			break;
			
			case 2:
				return 'Teacher';
			break;
			
			case 3:
				return 'Student';
			break;
		}
	}
	
	
	function user_information(){
		$user_id = $this->session->userdata('current_id');
		$user = array($this->session->userdata('current_id'));
		$userinfo_array = array();
		$query = $this->db->query("SELECT * FROM tbl_userinfo WHERE user_id=?", $user);
		if($query->num_rows > 0){
			$row = $query->row();
			$fname		= $row->fname;
			$mname		= $row->mname;
			$lname		= $row->lname;
			$auto_bio	= $row->autobiography;
			$userinfo_array = array($fname, $mname, $lname, $auto_bio, $user_id);
		}
		return $userinfo_array;
	}
	

	
	
	
}
?>