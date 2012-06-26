<?php

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index()
	{
		$this->load->view('upload_form', array('error' => ' ' ));
	}

	function do_upload()
	{
		$config['upload_path'] = './uploads/'; //only works on windows if linux change it to: uploads
		$config['allowed_types'] = 'gif|jpg|png|zip|avi|rar|7z|mp3|pdf|jpeg|pdf|ogv|mp4|ogg|webm|html|htm|ppt|pptx|doc|docx|xls|xlsx';
		
		$config['max_size']	= '10240';//10Mb
		
		$config['max_width']  = '0';
		$config['max_height']  = '0';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			echo '<div id="status">error</div>';
			echo '<div id="message">'. $this->upload->display_errors() .'</div>';
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			echo '<div id="status">success</div>';
			//then output your message (optional)
			echo '<div id="message">'. $data['upload_data']['file_name'] .' Successfully uploaded.</div>';
			//pass the data to js
			echo '<div id="upload_data">'. json_encode($data) . '</div>';
			
			
			
			$filename = $data['upload_data']['file_name'];
			$file_data = mysql_real_escape_string(file_get_contents($data['upload_data']['full_path'])); //doesn't work on some server, still need to enable escaping of strings
			
			
			$this->files->saves($filename, $file_data);
			echo $data['upload_data']['full_path'];
		}
	}
}
?>