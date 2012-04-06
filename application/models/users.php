<?php
class users extends ci_Model{
	
	function validate($user_id, $password){
		
		$user_credentials = array($user_id, $password);
		//user cannot log in if he is already logged in somewhere else
		$exists = $this->db->query("SELECT user_id FROM tbl_users WHERE user_id=? AND hashed_password=? AND logged_in=0", $user_credentials);
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
			
			$user_data = array('user_id'=>$uid, 'fname'=>$row->fname, 'mname'=>$row->mname, 'lname'=>$row->lname, 'auto_bio'=>$row->autobiography, 'email'=>$row->email);
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
		
		$email = $this->input->post('email');
		$autobiography = $this->input->post('autobiography');
		
		
		$user_data = array($fname, $mname, $lname, $email, $autobiography, $user_id);
		
		if(!empty($password)){
			$password = md5($this->input->post('pword'));
			$password = array($password, $user_id);
			
			$update_accountinfo = $this->db->query("UPDATE tbl_userinfo SET fname=?, mname=?, lname=?, email=?, autobiography=? WHERE user_id=?", $user_data);
			$update_password = $this->db->query("UPDATE tbl_users SET hashed_password=? WHERE user_id=?", $password);
			
			$user_id = 'UI'.$user_id;
			$_SESSION['post_id'] =  $user_id;
		}else{
		
			$update_accountinfo = $this->db->query("UPDATE tbl_userinfo SET fname=?, mname=?, lname=?, email=?, autobiography=? WHERE user_id=?", $user_data);
			
			
			$user_id = 'UI'.$user_id;
			$_SESSION['post_id'] = $user_id;
		}
		
		$_SESSION['user_name'] = $user_name;
		
		
		$this->load->model('logs_model');
		$this->logs_model->nlag(19, 'UA', $this->session->userdata('user_id'));
		
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
		$user_id = $_SESSION['current_id'];
		
		$userinfo_array = array();
		$query = $this->db->query("SELECT * FROM tbl_userinfo WHERE user_id=?", $user_id);
		if($query->num_rows > 0){
			$row = $query->row();
			$fname		= $row->fname;
			$mname		= $row->mname;
			$lname		= $row->lname;
			$auto_bio	= $row->autobiography;
			$email 		= $row->email;
			$image_id = $this->users->user_img($user_id);
			$userinfo_array = array($fname, $mname, $lname, $auto_bio,  $user_id, $image_id, $email);
		}
		return $userinfo_array;
	}
	
	
	function unread_post(){//selects all the unread post from all the classes
		$user_id = $this->session->userdata('user_id');
		$unreads = $this->db->query("SELECT post_from, class_code, class_description, post_type, post_time, post_id FROM tbl_poststatus 
									LEFT JOIN tbl_classes ON tbl_poststatus.class_id = tbl_classes.class_id
									WHERE post_to='$user_id' AND tbl_poststatus.status=1 AND post_type != 7");
		$this->load->model('post');
		$this->load->model('assignments_model');
		
		$unread_r = array();
		if($unreads->num_rows() > 0){
			foreach($unreads->result() as $row){
				$class_code			= $row->class_code;
				$class_description	= $row->class_description;
				$post_type_id		= $row->post_type;
				$post_id			= $row->post_id;
				$post_from			= $row->post_from;
				$post_type 			= $this->post->post_type($post_type_id);
				$post_time			= $row->post_time;
				
				if($post_type_id == 3){//assignment response
					$post_id = $this->assignments_model->responseid($row->post_from, substr($post_id, 2, strlen($post_id)));
				}
				
				$post_title			= $this->post->post_title($post_type_id, $post_id);
				$unread_r[]			= array('type_id'=>$post_type_id,'post_id'=>$post_id, 'class_code'=>$class_code,'class_description'=>$class_description,
											'post_type'=>$post_type, 'post_time'=>$post_time, 'post_title'=>$post_title);
			}
		}
		return $unread_r;
	}
	
	function recent_activities(){//selects all the activities from all the classes in the past  week - SELECT DATE_ADD(NOW(), INTERVAL -1 WEEK) 
		$user_id = $_SESSION['current_id'];
	} 
	
	function previous_classes(){//selects all the previous classes attended by the current user
		$user_id = $_SESSION['current_id'];
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
				$query = $this->db->query("SELECT DISTINCT logged_in, fname, lname, mname, class_code, class_description, tbl_classpeople.user_id FROM tbl_classpeople
										LEFT JOIN tbl_userinfo ON tbl_classpeople.user_id = tbl_userinfo.user_id
										LEFT JOIN tbl_classes ON tbl_classpeople.class_id = tbl_classes.class_id
										LEFT JOIN tbl_users ON tbl_userinfo.user_id = tbl_users.user_id
										WHERE tbl_classpeople.class_id='$class_id'");
				if($query->num_rows() > 0){
					foreach($query->result() as $in_row){
						$online = $in_row->logged_in;
						$fname	= $in_row->fname;
						$mname	= $in_row->mname;		
						$lname	= $in_row->lname;
						$id		= $in_row->user_id;
						$class_code			= $in_row->class_code;
						$class_description	= $in_row->class_description;
						$people[]=array('online'=>$online, 'fname'=>$fname,'mname'=>$mname,'lname'=>$lname,'id'=>$id,'class_code'=>$class_code,'class_description'=>$class_description,'class_id'=>$class_id);
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
	
	
	function user_list($user_type){//returns a list of a specific group of users (Eg. list of all teachers, admins, students)
		$list 	= array();
		$query 	= $this->db->query("SELECT tbl_users.user_id, fname, mname, lname FROM tbl_users 
								LEFT JOIN tbl_userinfo ON tbl_users.user_id = tbl_userinfo.user_id WHERE user_type = '$user_type'");
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$fname		= $row->fname;
				$mname		= $row->mname;
				$lname		= $row->lname;
				$user_id	= $row->user_id;
				
				$list[] = array('fname'=>$fname,'mname'=>$mname,'lname'=>$lname, 'user_id'=>$user_id); 
			}
		}
		return $list;
	}
	
	function user_email($user_id){
		$email = 0;
		$query = $this->db->query("SELECT email FROM tbl_userinfo WHERE user_id='$user_id'");
		if($query->num_rows() > 0){
			$row 	= $query->row();
			$email	= $row->email;
			
		}
		return $email;
	}
	
	function login(){
		$user_id = $this->session->userdata('user_id');
		$this->db->query("UPDATE tbl_users SET logged_in=1 WHERE user_id='$user_id'");
	}
	
	function logout(){
		$user_id = $this->session->userdata('user_id');
		$this->db->query("UPDATE tbl_users SET logged_in=0 WHERE user_id='$user_id'");
	}
	
	function enable(){//enable accounts which cannot logged in because they forgot to logout
		$user_id = $this->input->post('user_id');
		$this->db->query("UPDATE tbl_users SET logged_in=0 WHERE user_id='$user_id'");
	}
	
	
	
}
?>