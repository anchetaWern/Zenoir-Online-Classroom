<?php
class messages_model extends ci_Model{
	
	function create(){//original message
		$current_user 	= $this->session->userdata('user_id');
		$user_name		= $this->session->userdata('user_name');
		
		$class_id		= $_SESSION['current_class'];
		$msg_title		= $this->input->post('msg_title');
		$msg_body		= $this->input->post('msg_body');
		
		$receivers		= $this->input->post('receivers');
		
		$receivers = explode(',', $receivers);
		
		
		
		$root_msg 		= $this->db->query("INSERT INTO tbl_messagesroot SET sender_id='$current_user'");
		
		$root_msg_id 	= $this->db->insert_id();
		
		$msg_data		= array($root_msg_id, $class_id, $msg_title, $msg_body, $current_user);
		
		$message 		= $this->db->query("INSERT INTO tbl_messages SET root_msg_id=?, class_id=?, msg_title=?, 
											msg_body=?, sender_id=?", $msg_data);
		$msg_id	 		= $this->db->insert_id();
		
		$_SESSION['post_id'] =  'PO'.$msg_id;
		
		$this->load->model('users');
		$this->load->model('email');
		$this->load->model('emailnotifs_model');
		$this->load->model('classrooms_model');
		
		$class_details= $this->classrooms_model->select_classinfo();
		$class_description= $class_details['class_desc'];
		$notif_status = $this->emailnotifs_model->status(2);
		
		foreach($receivers as $k=>$receiver){
		
			if($notif_status == 1){
				$email_address = $this->users->user_email($receiver);
				if($email_address != ''){
					$msg_body = "<strong>Notification Type:</strong>New Message<br/><strong>Sender:</strong>". $user_name . 
								"<br/><strong>Class : </strong>" . $class_description . "<br/><strong>Message:</strong><br/>". $msg_body;
					$this->email->send($email_address, $msg_title, $msg_body);	
				}
			}
			
			$receiver = $this->db->query("INSERT INTO tbl_messagereceiver SET message_id='$msg_id', receiver_id='$receiver'");
		}
		
		$this->load->model('post');
		$this->post->message_post('PO'.$msg_id, 5, $receivers);
		
	}
	
	
	function receiver_id(){//gets the receivers user id
		$user_id= '';
		$query	= $this->db->query("SELECT user_id FROM tbl_userinfo WHERE fname='$fname', mname='$mname', lname='$lname'");
		if($query->num_rows() > 0){
			$row	= $query->row();
			$user_id= $row->user_id;
			
		}
		return $user_id;
	}
	
	function reply(){//only one receiver for a reply
	
		$current_user 	= $this->session->userdata('user_id');
		$user_name		= $this->session->userdata('user_name');
		
		$class_id		= $_SESSION['current_class'];
		$msg_title		= $this->input->post('msg_title');
		$msg_body		= $this->input->post('msg_body');
		
		$receiver 		= $_SESSION['sender_id']; //set from reply_details() function
		$root_msg_id	= $_SESSION['root_msg_id'];
		
		$msg_data		= array($root_msg_id, $class_id, $msg_title, $msg_body, $current_user);
		
		$message 		= $this->db->query("INSERT INTO tbl_messages SET root_msg_id=?, class_id=?, msg_title=?, 
											msg_body=?, sender_id=?", $msg_data);
											
		$msg_id	 		= $this->db->insert_id();
		$_SESSION['post_id'] = 'PO'.$msg_id;
		
		$this->load->model('post');
		$this->post->message_post('PO'.$msg_id, 5, $receiver);
		
		$receiver = $this->db->query("INSERT INTO tbl_messagereceiver SET message_id='$msg_id', receiver_id='$receiver'");
		
		
		$this->load->model('users');
		$this->load->model('email');
		$this->load->model('emailnotifs_model');
		$this->load->model('classrooms_model');
		
		$notif_status = $this->emailnotifs_model->status(10);
		$class_details= $this->classrooms_model->select_classinfo();
		$class_description= $class_details['class_desc'];
		
		if($notif_status == 1){
			$email_address = $this->users->user_email($receiver);
			if($email_address != ''){
				$msg_body = "<strong>Notification Type:</strong>Message Response<br/><strong>Sender:</strong>". $user_name . 
								"<br/><strong>Class : </strong>" . $class_description . "<br/><strong>Message:</strong><br/>". $msg_body;
				$this->email->send($email_address, $msg_title, $msg_body);	
			}
		}
	}
	
	function messages(){
		$current_user = $this->session->userdata('user_id');
		$class_id	  = $_SESSION['current_class'];
		
		$messages_r['inbox']  = array();
		$messages_r['outbox'] = array();
		$inbox = $this->db->query("SELECT msg_title, datetime_sent, fname, lname, tbl_messages.message_id
									FROM tbl_messagereceiver 
									LEFT JOIN tbl_messages ON tbl_messagereceiver.message_id = tbl_messages.message_id
									LEFT JOIN tbl_userinfo ON tbl_messages.sender_id = tbl_userinfo.user_id
									WHERE receiver_id='$current_user' and class_id='$class_id' ORDER BY datetime_sent DESC");
		$inbox_count = $inbox->num_rows();
		
		
		$outbox =$this->db->query("SELECT msg_title, datetime_sent, fname, lname, tbl_messages.message_id
									FROM tbl_messages
									LEFT JOIN tbl_messagereceiver ON tbl_messages.message_id = tbl_messagereceiver.message_id
									LEFT JOIN tbl_userinfo ON tbl_messagereceiver.receiver_id = tbl_userinfo.user_id
									WHERE tbl_messages.sender_id='$current_user' AND class_id='$class_id' GROUP BY msg_title ORDER BY datetime_sent DESC");							
		$outbox_count = $outbox->num_rows();
		
		$this->load->model('post');
		
		if($inbox_count > 0){
			foreach($inbox->result() as $row){
				$message_id = $row->message_id;
				$msg_title	= $row->msg_title;
				$date_sent	= $row->datetime_sent;
				$fname		= $row->fname;
				$lname		= $row->lname;
				
				$post_status = $this->post->status('PO'.$message_id);
				$messages_r['inbox'][] = array('status'=>$post_status, 'msg_id'=>$message_id, 'msg_title'=>$msg_title,'date_sent'=>$date_sent, 'fname'=>$fname, 'lname'=>$lname);
			}
		}
		
		if($outbox_count > 0){
			foreach($outbox->result() as $row){
				$message_id = $row->message_id;
				$msg_title	= $row->msg_title;
				$date_sent	= $row->datetime_sent;
				$fname		= $row->fname;
				$lname		= $row->lname;
				$messages_r['outbox'][] = array('msg_id'=>$message_id, 'msg_title'=>$msg_title,'date_sent'=>$date_sent, 'fname'=>$fname, 'lname'=>$lname);
			}
		}
		
		return $messages_r;
		
	}
	
	
	function view(){//for viewing a message
		$current_user = $this->session->userdata('user_id');
		$message_id = $_SESSION['msg_id'];
		$file_message_id = 'PO'.$message_id;
		
		$message_data['message'] = array();
		$message_data['receivers'] = array();
		$message_data['files']	 = array();
		
		
		$message = $this->db->query("SELECT tbl_messages.message_id, tbl_messages.root_msg_id, tbl_messages.sender_id,
								msg_title, msg_body, datetime_sent, CONCAT_WS(', ', UPPER(lname), fname) AS sender
								FROM tbl_messages
								LEFT JOIN tbl_userinfo ON tbl_messages.sender_id = tbl_userinfo.user_id
								LEFT JOIN tbl_messagesroot ON tbl_messages.root_msg_id = tbl_messagesroot.msgroot_id
								WHERE message_id='$message_id'");
								
		$this->load->model('files');
		$files = $this->files->view($file_message_id);
		
		if($message->num_rows() > 0){
			$row = $message->row();
			$root_msgid= $row->root_msg_id;
			$msg_id	   = $row->message_id;
			$msg_title = $row->msg_title;
			$msg_body  = $row->msg_body;
			$date      = $row->datetime_sent;
			$from_id   = $row->sender_id;
			$from	   = $row->sender;
			
			if($current_user == $from_id){//select all the receivers of the current user's message
				$receivers = $this->db->query("SELECT CONCAT_WS(', ', UPPER(lname), fname) AS receiver 
											FROM tbl_messagereceiver
											LEFT JOIN tbl_userinfo ON tbl_messagereceiver.receiver_id = tbl_userinfo.user_id
											WHERE message_id='$message_id'");
									
				if($receivers->num_rows() > 0){
					foreach($receivers->result() as $row){
						$receiver = $row->receiver;
						$message_data['receivers'][] = array('receiver'=>$receiver);
					}
				}
				
				
				$message_data['message'] = array('msg_id'=>$msg_id, 'root_msg_id'=>$root_msgid,'msg_title'=>$msg_title, 'msg_body'=>$msg_body, 'date'=>$date);
								
				
			}else{
			
				$message_data['message'] = array('msg_id'=>$msg_id, 'root_msg_id'=>$root_msgid,'msg_title'=>$msg_title, 'msg_body'=>$msg_body, 'date'=>$date, 'from'=>$from);
			
			}
		}
		
		$message_data['files'] = $files;
		
		return $message_data;
	}
	
	function reply_details(){//for viewing reply details: Title of the message you're replying to and the Receiver
		$message_id = $_SESSION['current_id'];
		
		
		
		$message_data['message'] = array();
		
		$message = $this->db->query("SELECT tbl_messages.root_msg_id, tbl_messages.sender_id, msg_title, CONCAT_WS(', ', UPPER(lname), fname) AS sender
								FROM tbl_messages
								LEFT JOIN tbl_userinfo ON tbl_messages.sender_id = tbl_userinfo.user_id
								LEFT JOIN tbl_messagesroot ON tbl_messages.root_msg_id = tbl_messagesroot.msgroot_id
								WHERE tbl_messages.message_id='$message_id'");
		
		if($message->num_rows() > 0){
			$row = $message->row();
			$msg_title = $row->msg_title;
			$sender = $row->sender; //the person you're replying to
			$_SESSION['sender_id'] =  $row->sender_id; //set sender id for replying later
			$_SESSION['root_msg_id'] = $row->root_msg_id;
			$message_data['message'] = array('msg_id'=>$message_id,'msg_title'=>$msg_title, 'sender'=>$sender);
		}						
		return $message_data;						
	}
	
	
	function history(){//conversation history
		$root_message_id = $_SESSION['current_id'];
		$message_r = array();
		$message = $this->db->query("SELECT tbl_messages.message_id, tbl_messages.root_msg_id, tbl_messages.sender_id, 
								msg_title, CONCAT_WS(', ', UPPER(lname), fname) AS sender, 
								datetime_sent, msg_body
								FROM tbl_messages
								LEFT JOIN tbl_userinfo ON tbl_messages.sender_id = tbl_userinfo.user_id
								LEFT JOIN tbl_messagesroot ON tbl_messages.root_msg_id = tbl_messagesroot.msgroot_id
								WHERE tbl_messages.root_msg_id='$root_message_id' ORDER BY datetime_sent DESC");
								
		if($message->num_rows() > 0){
			foreach($message->result() as $row){
				$msg_id	   = $row->message_id;
				$msg_title = $row->msg_title;
				$msg_body  = $row->msg_body;
				$date      = $row->datetime_sent;
				$sender	   = $row->sender;
				
				
				
				$message_r[] = array('msg_title'=>$msg_title, 'sender'=>$sender, 'msg_body'=>$msg_body, 'date'=>$date);
			}
		}
		return $message_r;
	}
	
	
}
?>