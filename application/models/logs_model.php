<?php
class logs_model extends ci_Model{//for logging teacher and student activity
	/*
	activities:
	1- login
	2- logout
	3- enter classroom
	4- view assignment
	5- view quiz
	6- view handout
	7- download file
	8- create session
	9- create assignment
	10- create handout
	11- create quiz
	12- responded to assignment
	13- responded to quiz
	14- view assignment response
	15- view quiz scores
	16- take quiz(student is viewing quiz but hasn't actually answered yet)
	
	*/

	function lag($act_id, $prefix){
		$user_id 	=	$this->session->userdata('user_id'); 
		$class_id	=	$_SESSION['current_class']; 
		$act_details=	$prefix.$_SESSION['current_id'];
		
		$this->db->query("INSERT INTO tbl_activitylog SET user_id='$user_id', class_id='$class_id', activity_id='$act_id', activity_details='$act_details'");
	}
	
	
}
?>