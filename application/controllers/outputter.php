<?php
class outputter extends ci_Controller{
	function index(){
		echo $_SESSION['assignment_id'];
	}
}
?>