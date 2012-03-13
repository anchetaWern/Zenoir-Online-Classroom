<?php
class login extends ci_Controller{
	
	function validate_user(){
		
		$user_id = $this->input->post('user_id');
		$hashed_password = md5($this->input->post('password'));
		$this->load->model('users');
		
		$user_exists = $this->users->validate($user_id, $hashed_password);
		if($user_exists){
		$usertype = $this->users->usertype($user_id);
		$user_name = $this->users->user_name($user_id);
		
			$user_data = array(
				'user_id'=>$this->input->post('user_id'), 
				'user_name'=>$user_name,
				'usertype'=>$usertype,
				'logged_in'=>true
			);
			
			$this->session->set_userdata($user_data);
			
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