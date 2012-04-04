<?php
class emailnotifs_model extends ci_Model{
	
	function create($class_id){//create the events for the newly created class, by default notifications are enabled for every event
		
		$events = $this->db->query("SELECT event_id FROM tbl_events");
		if($events->num_rows() > 0){
			foreach($events->result() as $row){
				$event_id = $row->event_id;
				$query = $this->db->query("INSERT INTO tbl_notifyevent SET event_id='$event_id', class_id='$class_id', status=1");
			}
		}
		
		
	}
	
	function list_events(){//returns a list of all events covered by email notifications 
		$class_id = $_SESSION['current_class'];
		$query = $this->db->query("SELECT tbl_notifyevent.notifyevent_id, status, event_description FROM tbl_notifyevent 
									LEFT JOIN tbl_events ON tbl_notifyevent.event_id = tbl_events.event_id
									WHERE class_id='$class_id'");
		$class_events	= array();
		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$nevent_id 	= $row->notifyevent_id;
				$event_description 	= $row->event_description;
				$status				= $row->status;
				
				$class_events[] 	= array('nevent_id'=>$nevent_id, 'event'=>$event_description, 'status'=>$status);
			}
		}
		return $class_events;
		
	}
	
	
	function change_status(){
		$nevent_id 	= $this->input->post('nevent_id');
		$status 	= $this->input->post('status');
		$this->db->query("UPDATE tbl_notifyevent SET status='$status' WHERE notifyevent_id='$nevent_id'");
	}
	
	function build(){//used for building class events
		$classes 	= $this->db->query("SELECT * FROM tbl_classes");
		
		foreach($classes->result() as $row){
			$class_id = $row->class_id;
			
			$events		= $this->db->query("SELECT * FROM tbl_events");
			foreach($events->result() as $row2){
				$event_id = $row2->event_id;
				$this->db->query("INSERT INTO tbl_notifyevent SET event_id='$event_id', class_id='$class_id'");
			}
		}
	}
}
?>