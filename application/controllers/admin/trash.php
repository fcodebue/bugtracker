<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trash extends CI_Controller {

	function __construct() {
		parent::__construct();
		
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
			$this->session->flashdata('flasherror', 'You must be logged into a valid admin account to access the admin area.');
			redirect('admin/login');
		}
	
	}


	// LIST ARTICLES
	public function index($offset = 0){
		
		//load dependencies
		$this->load->library('pagination');
		$this->load->model('admin/articles_model');
		$this->load->model('admin/category_model');
		$this->load->model('admin/users_model');
		
		$perpage = 10;

		$config['per_page']			= $perpage;
		$config['uri_segment']  	= 5;
		$config['first_link'] 		= true;
		$config['last_link'] 		= true;
		$config['next_link'] 		= 'Seguinte »';
		$config['prev_link'] 		= '« Anterior';
		$config['anchor_class']		= "class='number' ";
		
		$type = $this->input->post('type');
		switch ($type) {
			case 'articles':
				$config['base_url'] 		= base_url() . 'index.php/admin/trash/index/';
				$config['total_rows'] 		= $this->articles_model->GetArticles(array('count' => true, 'articlestatus' => 'deleted'));		
				$data['records'] 			= $this->articles_model->GetArticles(array('articlestatus' => 'deleted', 'limit' => $perpage, 'offset' => $offset));
				$data['type']				= 'articles';			
			break;
			case 'category':
				$config['base_url'] 		= base_url() . 'index.php/admin/trash/category/';
				$config['total_rows'] 		= $this->category_model->GetCategories(array('count' => true, 'categorystatus' => 'deleted'));		
				$data['records'] 			= $this->category_model->GetCategories(array('categorystatus' => 'deleted', 'limit' => $perpage, 'offset' => $offset));
				$data['type']				= 'category';
			break;
			case 'users':
				$config['base_url'] 		= base_url() . 'index.php/admin/trash/users/';
				$config['total_rows'] 		= $this->users_model->GetUsers(array('count' => true, 'userstatus' => 'deleted'));		
				$data['records'] 			= $this->users_model->GetUsers(array('userstatus' => 'deleted', 'limit' => $perpage, 'offset' => $offset));
				$data['type']				= 'users';
			break;
			default:
				$config['base_url'] 		= base_url() . 'index.php/admin/trash/index/';
				$config['total_rows'] 		= $this->articles_model->GetArticles(array('count' => true, 'articlestatus' => 'deleted'));		
				$data['records'] 			= $this->articles_model->GetArticles(array('articlestatus' => 'deleted', 'limit' => $perpage, 'offset' => $offset));
				$data['type']				= 'articles';
			break;
		}
		
		$this->pagination->initialize($config); 		
		$data['pagination'] = $this->pagination->create_links();
		
		$data['categories'] 	= $this->category_model->GetCategories();
		$data['main_content'] 	= 'admin/trash_view';
		$data['action'] 		= 'list';
		$data['current_page'] 	= 'trash';
		$this->load->view('admin/template/template', $data);
		
	}

	
	
	// LIST CATEGORIES
	public function category($offset = 0){
		
		//load dependencies
		$this->load->library('pagination');
		$this->load->model('admin/articles_model');
		$this->load->model('admin/category_model');
		$this->load->model('admin/users_model');
		
		$perpage = 10;
		
		$config['base_url'] 		= base_url() . 'index.php/admin/trash/index/';
		$config['per_page']			= $perpage;
		$config['uri_segment']  	= 5;
		$config['first_link'] 		= true;
		$config['last_link'] 		= true;
		$config['next_link'] 		= $this->lang->line('next').' »';
		$config['prev_link'] 		= '« '.$this->lang->line('previous');
		$config['anchor_class']		= "class='number' ";

		$config['total_rows'] 		= $this->category_model->GetCategories(array('count' => true, 'categorystatus' => 'deleted'));		
		
		$data['records'] 			= $this->category_model->GetCategories(array('categorystatus' => 'deleted', 'limit' => $perpage, 'offset' => $offset));
		$data['type']				= 'category';

		$this->pagination->initialize($config); 		
		$data['pagination'] = $this->pagination->create_links();
		
		$data['categories'] 	= $this->category_model->GetCategories();
		$data['main_content'] 	= 'admin/trash_view';
		$data['action'] 		= 'list';
		$data['current_page'] 	= 'trash';
		$this->load->view('admin/template/template', $data);
		
	}
	
	
	// LIST USERS
	public function users($offset = 0){
		
		//load dependencies
		$this->load->library('pagination');
		$this->load->model('admin/articles_model');
		$this->load->model('admin/category_model');
		$this->load->model('admin/users_model');
		
		$perpage = 10;
		
		$config['base_url'] 		= base_url() . 'index.php/admin/trash/index/';
		$config['per_page']			= $perpage;
		$config['uri_segment']  	= 5;
		$config['first_link'] 		= true;
		$config['last_link'] 		= true;
		$config['next_link'] 		= $this->lang->line('next').' »';
		$config['prev_link'] 		= '« '.$this->lang->line('previous');
		$config['anchor_class']		= "class='number' ";

		$config['base_url'] 		= base_url() . 'index.php/admin/trash/users/';
		$config['total_rows'] 		= $this->users_model->GetUsers(array('count' => true, 'userstatus' => 'deleted'));		
				
		$data['records'] 			= $this->users_model->GetUsers(array('userstatus' => 'deleted', 'limit' => $perpage, 'offset' => $offset));
		$data['type']				= 'users';

		$this->pagination->initialize($config); 		
		$data['pagination'] = $this->pagination->create_links();
		
		$data['categories'] 	= $this->category_model->GetCategories();
		$data['main_content'] 	= 'admin/trash_view';
		$data['action'] 		= 'list';
		$data['current_page'] 	= 'trash';
		$this->load->view('admin/template/template', $data);
		
	}
	
}