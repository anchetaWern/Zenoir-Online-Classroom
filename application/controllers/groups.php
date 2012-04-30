<?php
class groups extends ci_Controller{
	function create(){
		
		$this->groups_model->create();
	}
	
	function delmember(){
		$group_people_id = $this->input->post('member_id');
		
		$this->groups_model->del_member($group_people_id);
	}
	
	function non_members($group_id){
		
		$bengga = $this->groups_model->non_members($group_id);
		print_r($bengga);
	}
	
	function current_id(){
		echo $this->session->userdata('image_id');
	}
	
	function update(){
		
		$this->groups_model->update();
	}
	
	function accept(){
		
		$this->groups_model->accept();
	}
	
	function decline(){
			
		$this->groups_model->decline();
	}
	
	function index(){
		echo $_SERVER["REQUEST_URI"];
	}
}
?>