<?php
class tester extends ci_Controller{
	function index(){
		$this->load->model('post');
		$boom = $this->post->post_title(7, '4');
		var_dump($boom);
	}

}
?>