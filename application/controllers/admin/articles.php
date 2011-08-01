<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends CI_Controller {

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

		$this->load->model('admin/articles_model');
		
		if($this->users_model->Secure(array('type_2' => 'developer')) || $this->users_model->Secure(array('type_2' => 'admin'))
			|| $this->users_model->Secure(array('type_2' => 'manager'))){
		}else{
			$this->session->flashdata('flasherror', $this->lang->line('you_must_logged'));
			redirect('admin/login');
		}
	}

	// LIST CATEGORIES
	public function index($selectedcat = 0, $offset = 0){
		
		//load dependencies
		$this->load->library('pagination');
		$this->load->model('admin/category_model');
		
		if(!empty($_POST['by_cat']) && $_POST['by_cat'] != 0){
			$selectedcat = $this->input->post('by_cat');
		}
		
		$perpage = 10;
		
		$config['base_url'] 		= base_url() . 'index.php/admin/articles/index/' . $selectedcat;
		$config['per_page']			= $perpage;
		$config['uri_segment']  	= 5;
		$config['first_link'] 		= true;
		$config['last_link'] 		= true;
		$config['next_link'] 		= $this->lang->line('next').' »';
		$config['prev_link'] 		= '« '.$this->lang->line('previous');
		$config['anchor_class']		= "class='number' ";
		
		if($selectedcat != 0){
			$config['total_rows'] 	= $this->articles_model->GetArticles(array('idcategory' => $selectedcat, 'count' => true));
			$data['records'] 		= $this->articles_model->GetArticles(array('sortBy' => 'order_of', 'sortDirection' => 'ASC', 'idcategory' => $selectedcat, 'limit' => $perpage, 'offset' => $offset));
		}
		elseif ($selectedcat == 0){
			$config['total_rows'] 	= $this->articles_model->GetArticles(array('count' => true));
			$data['records'] 		= $this->articles_model->GetArticles(array('sortBy' => 'order_of', 'sortDirection' => 'ASC', 'limit' => $perpage, 'offset' => $offset));	
		}
		$this->pagination->initialize($config); 		
		$data['pagination'] = $this->pagination->create_links();
		
		$data['selectedcat']	= $selectedcat;
		$data['categories'] 	= $this->category_model->GetCategories();
		$data['main_content'] 	= 'admin/articles_view';
		$data['action'] 		= 'list';
		$data['current_page'] 	= 'articles';
		$this->load->view('admin/template/template', $data);
		
	}
	
	// ADD CATEGORY
	public function add(){
		
		//load dependencies
		$this->load->library('form_validation');
		$this->load->model('admin/articles_model');
		$this->load->model('admin/category_model');
		
		//validate form
		$this->form_validation->set_error_delimiters('<span class="input-notification error png_bg">', '</span>');
		$this->form_validation->set_rules('articletitle', $this->lang->line('title'), 'trim|required');
		$this->form_validation->set_rules('articleintro', $this->lang->line('intro'), 'trim|required|min_length[5]');
		//$this->form_validation->set_rules('articledescription', 'Descrição', 'trim|required|min_length[5]');
		
		if ($this->form_validation->run()) {
			
			$new_article = $this->articles_model->AddArticle($_POST, $_FILES);
			
			if ($new_article) {
				$this->session->set_flashdata('flashConfirm', $this->lang->line('article_created'));
				redirect('admin/articles');
			}
			else {
				$this->session->set_flashdata('flashError', $this->lang->line('article_nocreated'));
				redirect('admin/articles');
			}
		}
		else{
			$data['records'] 	= $this->articles_model->GetArticles();
			$data['categories'] = $this->category_model->GetCategories(); 
			$data['action'] = 'add';
			$data['current_page'] = 'articles';
			$data['main_content'] = 'admin/articles_view';
			$this->load->view('admin/template/template', $data);
		}
		
	}
	
	
	// EDIT CATEGORY 
	public function edit($idarticle){
		
		//load dependencies
		$this->load->model('admin/articles_model');
		$this->load->model('admin/category_model');
		$this->load->library('form_validation');
		
		$data['article'] 	= $this->articles_model->GetArticles(array('idarticle' => $idarticle));
		$data['categories'] = $this->category_model->GetCategories();
		if(!$data['article']) redirect('admin/articles');
		
		//validate form
		$this->form_validation->set_error_delimiters('<span class="input-notification error png_bg">', '</span>');
		$this->form_validation->set_rules('articletitle', $this->lang->line('title'), 'trim|required');
		$this->form_validation->set_rules('articleintro', $this->lang->line('intro'), 'trim|required|min_length[5]');
		
		if ($this->form_validation->run()) {
			//validation passes
			$_POST['idarticle'] = $idarticle;
			if ($this->articles_model->UpdateArticle($_POST, $_FILES)) {
				$this->session->set_flashdata('flashConfirm', $this->lang->line('article_edited'));
				redirect('admin/articles');
			}
			else {
				$this->session->set_flashdata('flashError', $this->lang->line('article_noedited'));
				redirect('admin/articles');
			}
		}
		$data['current_page'] = 'articles';
		$data['action'] = 'edit';
		$data['main_content'] = 'admin/articles_view';
		$this->load->view('admin/template/template', $data);
	}
	
	
	// DELETE CATEGORY
	public function delete($idarticle){
		
		//load dependencies
		$this->load->model('admin/articles_model');
		$this->load->model('admin/menus_model');
		
		$data['article'] = $this->articles_model->GetArticles(array('idarticle' => $idarticle));
		
		if(!$data['article']) redirect('admin/articles');
		
		$active_article = $this->menus_model->GetMenus(array('idarticle' => $idarticle));
		
		if (!empty($active_article)){
			
			$this->session->set_flashdata('flashError', $this->lang->line('article_nodeleted')); 
			redirect('admin/articles');
			
		} 
		
		$this->articles_model->UpdateArticle(array(
				'idarticle' 	=> $idarticle,
				'articlestatus'	=> 'deleted'
			));
		$this->session->set_flashdata('flashConfirm', $this->lang->line('article_deleted'));
		redirect('admin/articles');
	}
	
	
	// ACTIONS TO ALL SELECTED ON THE LIST
	public function all() {
		
		//load dependencies
		$this->load->model('admin/articles_model');
		
		foreach ($_POST['check'] as $key => $value){	
			if($_POST['dropdown'] == 'publish'){
				$this->articles_model->UpdateArticle(array('idarticle' => $value, 'articlestatus' => 'active'));	
			}
			elseif($_POST['dropdown'] == 'unpublish'){
				$this->articles_model->UpdateArticle(array('idarticle' => $value, 'articlestatus' => 'inactive'));	
			}
			elseif($_POST['dropdown'] == 'delete'){
				$this->articles_model->UpdateArticle(array('idarticle' => $value, 'articlestatus' => 'deleted'));	
			}	
		}
		redirect('admin/articles');
	}
	
	
	// RE-ORDER PRODUCTS
	public function order($idcategory = 0){

		//load dependencies
		$this->load->library('pagination');
		$this->load->model('admin/category_model');
		
		$data['selectedcat']	= $idcategory;
		$data['records'] 		= $this->articles_model->GetArticles(array('sortBy' => 'order_of', 'sortDirection' => 'ASC', 'idcategory' => $idcategory));
			
		$data['selectedcat']	= $idcategory;
		$data['new_order']		= TRUE;
		$data['categories'] 	= $this->category_model->GetCategories();
		$data['main_content'] 	= 'admin/articles_view';
		$data['action'] 		= 'list';
		$data['current_page'] 	= 'articles';
		$this->load->view('admin/template/template', $data);
		
	}
	
	
	//Re-order elements
	public function reorder(){
		
		$reorder = $this->articles_model->ReOrder();
		
		if(!$reorder){
			echo $this->lang->line('no_reorder');
		}
		
	}
	
}