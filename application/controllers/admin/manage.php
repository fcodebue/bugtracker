<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller {

	function __construct() {
		parent::__construct();
		//load dependecies
		$current_language = $this->session->userdata('language');
		switch ($current_language) {
			case 'pt':
				$this->lang->load('admin_base', 'portuguese');	
			break;
			case 'en':
				$this->lang->load('admin_base', 'english');
			break;
			default:
				$this->lang->load('admin_base', 'portuguese');
			break;
		}
		
		if($this->users_model->Secure(array('type_2' => 'developer')) || $this->users_model->Secure(array('type_2' => 'admin'))
			|| $this->users_model->Secure(array('type_2' => 'manager'))){			
		}else{
			$this->session->flashdata('flasherror', $this->lang->line('you_must_logged') );
			redirect('admin/login');
		}
	}
	
	public function index(){	
		$data['main_content'] = 'admin/home_view';
		$this->load->view('admin/template/template', $data);
	}
}