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
		$password = $this->input->post('pword');
		
		$autobiography = $this->input->post('autobiography');
		
		
		$user_data = array($fname, $mname, $lname, $autobiography, $user_id);
		
		if(!empty($password)){
			$password = md5($this->input->post('pword'));
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
			$image_id = $this->users->user_img($user_id);
			$userinfo_array = array($fname, $mname, $lname, $auto_bio, $user_id, $image_id);
		}
		return $userinfo_array;
	}
	
	
	function unread_post(){//selects all the unread post from all the classes
		$user_id = $this->session->userdata('user_id');
		$unreads = $this->db->query("SELECT class_code, class_description, post_type, post_id FROM tbl_poststatus 
									LEFT JOIN tbl_classes ON tbl_poststatus.class_id = tbl_classes.class_id
									WHERE post_to='$user_id' AND tbl_poststatus.status=1 AND post_type != 7");
		$this->load->model('post');
		$unread_r = array();
		if($unreads->num_rows() > 0){
			foreach($unreads->result() as $row){
				$class_code			= $row->class_code;
				$class_description	= $row->class_description;
				$post_type_id		= $row->post_type;
				$post_id			= $row->post_id;
				$post_type 			= $this->post->post_type($post_type_id);
				$post_title			= $this->post->post_title($post_type_id, $post_id);
				$unread_r[]			= array('class_code'=>$class_code,'class_description'=>$class_description,'post_type'=>$post_type, 'post_title'=>$post_title);
			}
		}
		return $unread_r;
	}
	
	function recent_activities(){//selects all the activities from all the classes in the past  week - SELECT DATE_ADD(NOW(), INTERVAL -1 WEEK) 
		$user_id = $this->session->userdata('current_id');
	} 
	
	function previous_classes(){//selects all the previous classes attended by the current user
		$user_id = $this->session->userdata('current_id');
	}
	
	function user_img($user_id){
		$user_img_id = 'UI'.$user_id;
		$file_id = 0;
		$query = $this->db->query("SELECT tbl_files.file_id 
									FROM tbl_files 
									LEFT JOIN tbl_filepost ON tbl_files.file_id = tbl_filepost.file_id 
									WHERE post_id='$user_img_id'");
									
		if($query->num_rows() > 0){
			$row = $query->row();
			$file_id = $row->file_id; 
		}
		return $file_id;
	}
	
	
	function people(){//selects all the people from all the classes from which the user belongs
		$classes= $this->classes();
		$people	= array();
		if(!empty($classes)){
			foreach($classes as $row){
				$class_id = $row['class_id'];
				$query = $this->db->query("SELECT DISTINCT fname, lname, mname, class_code, class_description, tbl_classpeople.user_id FROM tbl_classpeople
										LEFT JOIN tbl_userinfo ON tbl_classpeople.user_id = tbl_userinfo.user_id
										LEFT JOIN tbl_classes ON tbl_classpeople.class_id = tbl_classes.class_id
										WHERE tbl_classpeople.class_id='$class_id'");
				if($query->num_rows() > 0){
					foreach($query->result() as $in_row){
						$fname	= $in_row->fname;
						$mname	= $in_row->mname;		
						$lname	= $in_row->lname;
						$id		= $in_row->user_id;
						$class_code			= $in_row->class_code;
						$class_description	= $in_row->class_description;
						$people[]=array('fname'=>$fname,'mname'=>$mname,'lname'=>$lname,'id'=>$id,'class_code'=>$class_code,'class_description'=>$class_description,'class_id'=>$class_id);
					}
				}
			}
		}
		return $people;
	}
	
	function classes(){//selects all the classes from which the current user belongs
		$user_id = $this->session->userdata('user_id');
		$class_r = array();
		$query = $this->db->query("SELECT class_id FROM tbl_classpeople WHERE user_id='$user_id'");
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$class_id = $row->class_id;
				$class_r[] = array('class_id'=>$class_id);
			}
			
		}
		return $class_r;
	}
	
	
	
}
?>