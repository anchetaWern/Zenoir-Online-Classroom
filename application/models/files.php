<?php
class files extends ci_Model{
	function saves($filename, $filedata){
		$post_id = $this->session->userdata('post_id');
		$this->db->query("INSERT INTO tbl_files SET file_data='$filedata', filename='$filename'");
		$file_id = $this->db->insert_id();
		
		$this->db->query("INSERT INTO tbl_filepost SET post_id='$post_id', file_id='$file_id'");
	}
	
	function view($post_id){//view files associated to a specific post
		$file_r= array();
		$files = $this->db->query("SELECT filename, tbl_filepost.file_id 
								FROM tbl_filepost
								LEFT JOIN tbl_files ON tbl_filepost.file_id = tbl_files.file_id
								WHERE tbl_filepost.post_id='$post_id'");
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