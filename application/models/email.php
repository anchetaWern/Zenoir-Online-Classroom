<?php
class email extends ci_Model{
	function __construct(){
		parent::__construct();
	}
	
	function send($receiver, $subject, $message){
		$config = Array(
			'protocol'=>'smtp',
			'smtp_host'=>'ssl://smtp.googlemail.com',
			'smtp_port'=>465,
			'smtp_user'=>'zenoirsystem@gmail.com',
			'smtp_pass'=>'secretpassword11(*'
		);
		
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		
		$this->email->from('zenoirsystem@gmail.com','Zenoir System');
		$this->email->to($receiver);
		$this->email->subject($subject);
		$this->email->message($message);
		
		if($this->email->send()){
			return 1;
		}else{
			return 0;
		}
	}
}
?>