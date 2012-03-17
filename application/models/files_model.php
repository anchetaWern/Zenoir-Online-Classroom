<?php
class files_model extends ci_Model{

	function create(){
		if (!empty($_FILES)){
		$name2 = mysql_real_escape_string($_FILES['Filedata']['name']);
		$mime2 = mysql_real_escape_string($_FILES['Filedata']['type']);
		$data2 = mysql_real_escape_string(file_get_contents($_FILES['Filedata']['tmp_name']));
		$size2 = intval($_FILES['Filedata']['size']);

		$post_id = '12';
		
		$this->db->query("INSERT INTO tbl_files SET post_id='$post_id', filename='$name2', file_data='$data2', mime_type_id='$mime2'");


		}
	}
}
?>