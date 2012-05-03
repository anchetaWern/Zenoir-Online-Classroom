<?php
class tester extends ci_Controller{
	function index(){
		
		
		$pendings = $this->groups_model->pendings();
		$members = array();
		foreach($pendings as $key){
			$members[] = $key['user_id'];
		}
		print_r($members);
	}

}
?>