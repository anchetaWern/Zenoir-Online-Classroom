<?php
class files extends ci_Model{
	function saves($filename, $filedata){
		$post_id = $this->session->userdata('post_id');
		$this->db->query("INSERT INTO tbl_files SET file_data='$filedata', filename='$filename', postid='$post_id'");
	}
	
	function view($post_id){//view files associated to a specific post
		$file_r= array();
		$files = $this->db->query("SELECT filename, file_id FROM tbl_files WHERE postid='$post_id'");
		if($files->num_rows() > 0){
			foreach($files->result() as $row){
				$file_id  = $row->file_id;
				$filename = $row->filename;
				$file_r[]   = array('file_id'=>$file_id, 'filename'=>$filename);
			}
		}
		return $file_r;
	}
}
?>