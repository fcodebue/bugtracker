<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Issues extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		//load dependencies
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

		//$this->load->model('admin/articles_model');
		
		if($this->users_model->Secure(array('type_2' => 'developer')) || $this->users_model->Secure(array('type_2' => 'admin'))
			|| $this->users_model->Secure(array('type_2' => 'manager'))){
		}else{
			$this->session->flashdata('flasherror', $this->lang->line('you_must_logged'));
			redirect('admin/login');
		}
	}

	// LIST ISSUES
	public function index($idproject = 0, $offset = 0){
		
		//load dependencies
		$this->load->library('pagination');
		$this->load->model('admin/issues_model');
		$this->load->model('admin/projects_model');
		
		$perpage = 10;
		
		$config['base_url'] 		= base_url() . 'index.php/admin/issues/index/' . $idproject;
		$config['per_page']			= $perpage;
		$config['uri_segment']  	= 5;
		$config['first_link'] 		= true;
		$config['last_link'] 		= true;
		$config['next_link'] 		= $this->lang->line('next').' >>';
		$config['prev_link'] 		= '<< '.$this->lang->line('previous');
		$config['anchor_class']		= "class='number' ";
		
		$config['total_rows']	 	= $this->issues_model->GetIssues(array('count' => true));
		$data['active_issues'] 		= $this->issues_model->GetIssues(array('idproject' => $idproject, 'limit' => $perpage, 'offset' => $offset));	
		$this->pagination->initialize($config); 		
		$data['pagination'] = $this->pagination->create_links();
		
		$data['projects']		= $this->projects_model->GetProjects();
		$data['main_content'] 	= 'admin/listissues_view';
		$data['action'] 		= 'activeissues';
		$data['current_page'] 	= 'issues';
		$this->load->view('admin/template/template', $data);
		
	}

	
}