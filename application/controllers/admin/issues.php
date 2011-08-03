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
		
		/*
		$perpage = 10;
		
		$config_open['base_url'] 	= base_url() . 'index.php/admin/issues/index/' . $idproject;
		$config_open['per_page']	= $perpage;
		$config_open['uri_segment'] = 5;
		$config_open['first_link'] 	= true;
		$config_open['last_link'] 	= true;
		$config_open['next_link'] 	= $this->lang->line('next').' >>';
		$config_open['prev_link'] 	= '<< '.$this->lang->line('previous');
		$config_open['anchor_class']= "class='number' ";
		$config_open['total_rows']	= $this->issues_model->GetIssues(array('idproject' => $idproject, 'count' => TRUE));
		
		$this->pagination->initialize($config_open);

		$data['pagination_open'] = $this->pagination->create_links($config_open);
		
		$data['active_issues'] 	= $this->issues_model->GetIssues(
									array('idproject' => $idproject, 'limit' => $perpage, 'offset' => $offset, 'issuestatus' => 'open'));
		*/
		$data['active_issues'] 	= $this->issues_model->GetIssues(
									array(
										'idproject' => $idproject, 'issuestatus' => 'open', 
										'sortBy' => 'idissue', 'sortDirection' => 'DESC'
									));	
		$data['user_types'] 	= array(
									'client' 		=> 'Clt.',
									'account' 		=> 'Acc.',
									'manager'		=> 'Man',
									'webdesigner' 	=> 'Web',
									'webdeveloper'	=> 'Dev',
									'designer'		=> 'Des');							
		$data['users']			= $this->users_model->GetUsers();
		$data['projects']		= $this->projects_model->GetProjects();
		$data['active_project'] = $idproject;
		$data['main_content'] 	= 'admin/listissues_view';
		$data['action'] 		= 'activeissues';
		$data['current_page'] 	= 'issues';
		$this->load->view('admin/template/template', $data);
		
	}
	
	
	public function comment( $idissue ) {
		
		//load dependencies
		$this->load->library('pagination');
		$this->load->model('admin/issues_model');
		$this->load->model('admin/projects_model');
		
		
		$data['issue'] 			= $this->issues_model->GetIssues(array('idissue' => $idissue));
		$data['user']			= $this->users_model->GetUsers(array('iduser' => $data['issue']->iduser));
		$data['projects']		= $this->projects_model->GetProjects();
		$data['project']		= $this->projects_model->GetProjects(array('idproject' => $data['issue']->idproject));
		$data['active_project']	= $data['project']->idproject;
		$data['current_page'] 	= 'issues';
		$data['main_content']	= 'admin/issue_view';
		
		$this->load->view('admin/template/template', $data);
		
		
	}
	
	

	
}