<?php
class files extends ci_Model{
	function saves($filename, $filedata){
		$post_id = $this->session->userdata('post_id');
		$this->db->query("INSERT INTO tbl_files SET file_data='$filedata', filename='$filename'");
		$file_id = $this->db->insert_id();
		
		$prefix = substr($post_id, 0, 2);
		if($prefix == 'UI'){
			$this->db->query("DELETE FROM tbl_filepost WHERE post_id='$post_id'");
			$this->session->set_userdata('image_id', $file_id);
		}
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
	
	function data($file_id){//returns file data for a specific file(Eg. filename, data)
		$file_data	= array();
		$select_file= $this->db->query("SELECT filename, file_data FROM tbl_files WHERE file_id='$file_id'");
		if($select_file->num_rows() > 0){
			$row		= $select_file->row();
			$filename 	= $row->filename;
			$filedata	= $row->file_data;
			$ex_filename=explode('.',$filename);
			$ex_length	= count($ex_filename);
			$file_ext	= strtolower($ex_filename[$ex_length - 1]);
			$type_id	= $this->filetype_id($file_ext);
			$mimetype 	= $this->get_mime_type($filename, $mimePath = 'D:\wamp\www\zenoir\assets');
			
			
			
			$file_data	= array('file_id'=>$file_id, 'filename'=>$filename, 'filedata'=>$filedata, 'mime'=>$mimetype, 'file_ext'=>$file_ext, 'type_id'=>$type_id);
		}
		
		return $file_data;
	}
	
	function filetype_id($file_ext){//returns the filetype id from a file extension
		$file_extensions = array('htm','html','pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'ogv', 'mp4', 'webm','mp3', 'gif', 'jpg', 'jpeg', 'png');
		$index = array_search($file_ext, $file_extensions);
		if($index >= 0 && $index <= 8){
			$type_id = 0;
		}else if($index >= 9 && $index <= 11){
			$type_id = 1;
		}else if($index == 12){
			$type_id = 2;
		}else if($index >= 13 && $index <= 16){
			$type_id = 3;
		}
		return $type_id;
		
	}
	
	function get_mime_type($filename, $mimePath = '../../assets'){ 
		$fileext = substr(strrchr($filename, '.'), 1); 
		if (empty($fileext)) return (false); 
		$regex = "/^([\w\+\-\.\/]+)\s+(\w+\s)*($fileext\s)/i"; 
		$lines = file("$mimePath/mime.types"); 
		foreach($lines as $line){ 
			if (substr($line, 0, 1) == '#') continue; // skip comments 
			$line = rtrim($line) . " "; 
			if (!preg_match($regex, $line, $matches)) continue; // no match to the extension 
				return ($matches[1]); 
		} 
		return (false); // no match at all 
	} 
}
?>