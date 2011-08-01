<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus extends CI_Controller {

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
		$this->load->model('admin/menus_model');
		
	}
	

	// LIST MENUS
	public function index($offset = 0){
		
		$data['records'] = $this->menus_model->GetMenus();
		
		$data['main_content'] = 'admin/menu_view';
		$data['action'] = 'list';
		$data['current_page'] = 'menus';
		$this->load->view('admin/template/template', $data);
		
	}
	
	// ADD MENU
	public function add(){
		
		//load dependencies
		$this->load->library('form_validation');
		$this->load->model('admin/menus_model');
		$this->load->model('admin/articles_model');
		$this->load->model('admin/category_model');
		
		//validate form
		$this->form_validation->set_error_delimiters('<span class="input-notification error png_bg">', '</span>');
		$this->form_validation->set_rules('menuname', $this->lang->line('name'), 'trim|required');
		$this->form_validation->set_rules('menudescription', $this->lang->line('description'), 'trim|required|min_length[5]');
		
		if ($this->form_validation->run()) {
			//validation passes
			$new_menu = $this->menus_model->AddMenu($_POST);
			
			if ($new_menu) {
				$this->session->set_flashdata('flashConfirm', $this->lang->line('menu_created'));
				redirect('admin/menus');
			}
			else {
				$this->session->set_flashdata('flashError', $this->lang->line('menu_nocreated'));
				redirect('admin/menus');
			}
		}
		else{
			$data['categories'] = $this->category_model->GetCategories(array('categorystatus' => 'active'));
			$data['articles'] = $this->articles_model->GetArticles(array('idcategory' => '0', 'articlestatus' => 'active'));
			$data['menus'] = $this->menus_model->GetMenus(array('menustatus' => 'active'));
			$data['records'] = $this->menus_model->GetMenus();
			$data['action'] = 'add';
			$data['current_page'] = 'menus';
			$data['main_content'] = 'admin/menu_view';
			$this->load->view('admin/template/template', $data);
		}
		
	}
	
	
	// EDIT MENU 
	public function edit($idmenu){
		
		//load dependencies
		$this->load->model('admin/menus_model');
		$this->load->library('form_validation');
		
		$data['menu'] = $this->menus_model->GetMenus(array('idmenu' => $idmenu));
		if(!$data['menu']) redirect('admin/menus');
		
		//validate form
		$this->form_validation->set_error_delimiters('<span class="input-notification error png_bg">', '</span>');
		$this->form_validation->set_rules('menuname', $this->lang->line('name'), 'trim|required');
		$this->form_validation->set_rules('menudescription', $this->lang->line('description'), 'trim|required|min_length[5]');
		
		if ($this->form_validation->run()) {
			//validation passes
			$_POST['idmenu'] = $idmenu;
			if ($this->menus_model->UpdateMenu($_POST)) {
				$this->session->set_flashdata('flashConfirm', $this->lang->line('menu_edited'));
				redirect('admin/menus');
			}
			else {
				$this->session->set_flashdata('flashError', $this->lang->line('menu_noedited'));
				redirect('admin/menus');
			}
		}
		$data['current_page'] = 'menus';
		$data['action'] = 'edit';
		$data['main_content'] = 'admin/menu_view';
		$this->load->view('admin/template/template', $data);
	}
	
	// DELETE MENU
	public function delete($idmenu){
		
		//load dependencies
		$this->load->model('admin/menus_model');
		
		$data['menu'] = $this->menus_model->GetMenus(array('idmenu' => $idmenu));
		if(!$data['menu']) redirect('admin/menus');
		
		$this->menus_model->UpdateMenu(array(
				'idmenu' 		=> $idmenu,
				'menustatus'	=> 'deleted'
			));
		$this->session->set_flashdata('flashConfirm', $this->lang->line('deleted'));
		redirect('admin/menus');
	}
	
}