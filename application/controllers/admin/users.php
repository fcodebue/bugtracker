<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

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
			$this->session->flashdata('flasherror',  $this->lang->line('you_must_logged'));
			redirect('admin/login');
		}

	}
	
	
	// LIST USERS
	public function index($offset = 0){
		
		//load dependencies
		$this->load->library('pagination');
		
		$user_type 	= $this->session->userdata('type_2');
		$perpage 	= 10;
		
		$config['base_url'] 		= base_url() . 'index.php/admin/users/index/';
		
		$config['per_page']			= $perpage;
		$config['uri_segment']  	= 4;
		$config['first_link'] 		= false;
		$config['last_link'] 		= false;
		$config['next_link'] 		= $this->lang->line('next').' »';
		$config['prev_link'] 		= '« '.$this->lang->line('previous');
		$config['anchor_class']		= "class='number' ";
		
		switch ($user_type) {
			case 'developer':
				$config['total_rows'] 	= $this->users_model->GetUsers(array('count' => true, 'user' => 'developer'));
				$data['records'] 		= $this->users_model->GetUsers(array('limit' => $perpage, 'offset' => $offset));
			break;
			case 'admin':
				$config['total_rows'] 	= $this->users_model->GetUsers(array('count' => true, 'user' => 'admin'));
				$data['records'] 		= $this->users_model->GetUsers(array('limit' => $perpage, 'offset' => $offset, 'user' => 'admin'));
			break;
			case 'manager':
				$config['total_rows'] 	= $this->users_model->GetUsers(array('count' => true, 'user' => 'manager'));
				$data['records'] 		= $this->users_model->GetUsers(array('limit' => $perpage, 'offset' => $offset, 'user' => 'manager'));
			break;
		}
		
		$this->pagination->initialize($config); 
		$data['pagination'] = $this->pagination->create_links();
		
		$data['main_content'] = 'admin/users_view';
		$data['action'] = 'list';
		$data['current_page'] = 'users';
		$this->load->view('admin/template/template', $data);
		
	}
	
	// ADD USER
	public function add(){
		
		//load dependencies
		$this->load->library('form_validation');
		
		//validate form
		$this->form_validation->set_error_delimiters('<span class="input-notification error png_bg">', '</span>');
		$this->form_validation->set_rules('username', $this->lang->line('username') , 'trim|required');
		$this->form_validation->set_rules('ec_password', $this->lang->line('password') , 'trim|required|min_length[6]');
		$this->form_validation->set_rules('email', $this->lang->line('email') , 'trim|required|valid_email');
		$this->form_validation->set_rules('name', $this->lang->line('name') , 'trim|required');
		$this->form_validation->set_rules('surname', $this->lang->line('surname') , 'trim|required');
		
		if ($this->form_validation->run()) {
			//validation passes
			$new_user = $this->users_model->AddUser($_POST);
			
			if ($new_user) {
				$this->session->set_flashdata('flashConfirm', $this->lang->line('user_created'));
				redirect('admin/users');
			}
			else {
				$this->session->set_flashdata('flashError', $this->lang->line('user_nocreated'));
				redirect('admin/users');
			}
		}
		else{
			$data['records'] = $this->users_model->GetUsers();
			$data['action'] = 'add';
			$data['current_page'] = 'users';
			$data['main_content'] = 'admin/users_view';
			$this->load->view('admin/template/template', $data);
		}
		
	}
	
	// EDIT USER 
	public function edit($iduser){
		
		$data['user'] = $this->users_model->GetUsers(array('iduser' => $iduser));
		if(!$data['user']) redirect('admin/users');
		//load dependencies
		$this->load->library('form_validation');
		
		//validate form
		$this->form_validation->set_error_delimiters('<span class="input-notification error png_bg">', '</span>');
		$this->form_validation->set_rules('username', $this->lang->line('username') , 'trim|required');
		$this->form_validation->set_rules('ec_password', $this->lang->line('password') , 'trim|min_length[6]');
		$this->form_validation->set_rules('email', $this->lang->line('email') , 'trim|required|valid_email');
		$this->form_validation->set_rules('name', $this->lang->line('name') , 'trim|required');
		$this->form_validation->set_rules('surname', $this->lang->line('surname') , 'trim|required');
		
		if ($this->form_validation->run()) {
			//validation passes
			$_POST['iduser'] = $iduser; 
			if(empty($_FILES['ec_password'])) unset($_FILES['ec_password']);
			if ($this->users_model->UpdateUser($_POST)) {
				$this->session->set_flashdata('flashConfirm', $this->lang->line('user_edited'));
				redirect('admin/users');
			}
			else {
				$this->session->set_flashdata('flashError', $this->lang->line('user_noedited'));
				redirect('admin/users/');
			}
		}
		$data['current_page'] = 'users';
		$data['action'] = 'edit';
		$data['main_content'] = 'admin/users_view';
		$this->load->view('admin/template/template', $data);
	}
	
	// DELETE USER
	public function delete($iduser){
		
		$data['user'] = $this->users_model->GetUsers(array('iduser' => $iduser));
		if(!$data['user']) redirect('admin/users');
		
		$this->users_model->UpdateUser(array(
				'iduser' 		=> $iduser,
				'userstatus'	=> 'deleted'
			));
		$this->session->set_flashdata('flashConfirm', $this->lang->line('deleted'));
		redirect('admin/users');
	}
	
	
	//ADD MESSAGE
	public function addmessage(){
	
	}
	
}