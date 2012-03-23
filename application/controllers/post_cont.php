<?php
class post_cont extends ci_Controller{
	function post_type(){
		$post_type = 1;
		$post_id   = 'AS2';
		$this->load->model('post');
		echo $this->post->post_title($post_type, $post_id);
	}
	
	function alp(){
		$this->load->model('users');
		print_r($this->users->unread_post());
	}
}
?>