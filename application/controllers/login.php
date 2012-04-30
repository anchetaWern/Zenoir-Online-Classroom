<?php
class login extends ci_Controller{
	
	function validate_user(){
		
		$user_id = $this->input->post('user_id');
		$hashed_password = md5($this->input->post('password'));
		
		
		
		$user_exists = $this->users->validate($user_id, $hashed_password);
		
		
		if($user_exists){
		
		$usertype = $this->users->usertype($user_id);
		$user_name = $this->users->user_name($user_id);
		$image_id	= $this->users->user_img($user_id);
		
		$_SESSION['user_name'] = $user_name;
		
			$user_data = array(
				'user_id'=>$this->input->post('user_id'), 
				'user_name'=>$user_name,
				'usertype'=>$usertype,
				'logged_in'=>true,
				'image_id'=>$image_id
			);
			
			$this->session->set_userdata($user_data);
			$this->users->login();//sets login status to 1
			
			$this->logs_model->lag(1, 'LI');
			
			if($usertype == 1){//admin
				redirect('../adminloader/view/admin_home');
			}else if($usertype == 2 || $usertype == 3){//teacher and student
				redirect('../class_loader/view/land');
			}
			
		}else{
			redirect('../loader/view/login_form');
		
		}
	}
}
?>