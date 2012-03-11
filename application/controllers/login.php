<?php
class login extends ci_Controller{
	
	function validate_user(){
		
		$user_id = $this->input->post('user_id');
		$hashed_password = md5($this->input->post('password'));
		$this->load->model('users');
		
		$user_exists = $this->users->validate($user_id, $hashed_password);
		if($user_exists){
		$usertype = $this->users->usertype($user_id);
		
			$user_data = array(
				'user_id'=>$this->input->post('user_id'), 
				'usertype'=>$usertype,
				'logged_in'=>true
			);
			
			$this->session->set_userdata($user_data);
			echo $this->session->userdata('user_id');
		}else{
			redirect('../loader/view/login_form');
		
		}
	}
}
?>