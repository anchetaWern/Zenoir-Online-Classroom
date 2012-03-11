<?php
class loader extends ci_Controller{
	public function view($page = 'site_index'){
	
		if (!file_exists('application/views/'.$page.'.php')){
		
			show_404();
		}
		$data['title'] = ucfirst($page); 

		$this->load->view('templates/header', $data);
		$this->load->view($page, $data);
		
	}

}
?>