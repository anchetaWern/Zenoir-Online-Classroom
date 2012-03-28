<?php
class truncator_model extends ci_Model{//this empties all the non-default content tables in the database 
	function truncates(){
		$this->db->query("TRUNCATE tbl_filepost");
		$this->db->query("TRUNCATE tbl_activitylog");
		$this->db->query("TRUNCATE tbl_assignment");
		$this->db->query("TRUNCATE tbl_assignmentresponse");
		$this->db->query("TRUNCATE tbl_classes");
		$this->db->query("TRUNCATE tbl_classmodules");
		$this->db->query("TRUNCATE tbl_classpeople");
		$this->db->query("TRUNCATE tbl_classteachers");
		$this->db->query("TRUNCATE tbl_courses");
		$this->db->query("TRUNCATE tbl_exports");
		$this->db->query("TRUNCATE tbl_files");
		$this->db->query("TRUNCATE tbl_grouppeople");
		$this->db->query("TRUNCATE tbl_groups");
		$this->db->query("TRUNCATE tbl_handouts");
		$this->db->query("TRUNCATE tbl_messagereceiver");
		$this->db->query("TRUNCATE tbl_messages");
		$this->db->query("TRUNCATE tbl_messagesroot");
		$this->db->query("TRUNCATE tbl_poststatus");
		$this->db->query("TRUNCATE tbl_quiz");
		$this->db->query("TRUNCATE tbl_quizitems");
		$this->db->query("TRUNCATE tbl_quizresult");
		$this->db->query("TRUNCATE tbl_sessioncontent");
		$this->db->query("TRUNCATE tbl_sessions");
		$this->db->query("TRUNCATE tbl_sessionspeople");
		$this->db->query("TRUNCATE tbl_filepost");
		$this->db->query("TRUNCATE tbl_subject");
		
	}
}
?>