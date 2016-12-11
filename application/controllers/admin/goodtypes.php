<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goodtypes extends AdminController{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('good_type_model');
		$this->load->library('pagination');
	}

	public function index($offset = ''){


		$config['base_url'] = site_url('admin/goodtypes/index');
		$config['total_rows'] = $this->good_type_model->count_good_types();
		$config['per_page'] = 2; 
		$config['uri_segment'] = 4;
		//$config['use_page_numbers'] = TRUE;
		$config['num_links'] = 2;

		$config['first_link'] = '&nbsp;First&nbsp;';
		$config['last_link'] = '&nbsp;Last&nbsp;';
		$config['prev_link'] = '&nbsp;Previous&nbsp;';
		$config['next_link'] = '&nbsp;Next&nbsp;';

		$this->pagination->initialize($config); 

		$data['pageinfo'] = $this->pagination->create_links();
		$limits = $config['per_page'];

			$data['goodtypes'] = $this->good_type_model->list($limits,$offset);
			
		$this->load->view('goods_type_list.html',$data);
	}
	public function add(){
		$this->load->view('goods_type_add.html');
	}
	public function insert(){
		
		$this->form_validation->set_rules('type_name','trim|required');
		if($this->form_validation->run()==false){
			$data['type_name'] = $this->input->post('type_name');
			$data['deleted'] = $this->input->post('deleted');
			if($this->good_type_model->insert($data)){
				
				$data['message'] = 'Insert Successfully';
				$data['wait'] = 3;
				$data['url'] = site_url('admin/goodtypes/index');
				$this->load->view('message.html',$data);
			}else{
				$data['message'] = 'Insert Unsuccessfully';
				$data['wait'] = 3;
				$data['url'] = site_url('admin/goodtypes/add');
				$this->load->view('message.html',$data);
			}
		}else{
			$data['message'] = validation_errors();
			$data['wait'] = 3;
			$data['url'] = site_url('admin/goodtypes/add');
			$this->load->view('message.html',$data);
		}
	}
	public function delete($type_id){
		
		if($this->good_type_model->delete($type_id)){
			
			$data['message'] = 'Delete Successfully';
			$data['wait'] = 3;
			$data['url'] = site_url('admin/goodtypes/index');
			$this->load->view('message.html',$data);
		}else{
			$data['message'] = 'Delete Unuccessfully';
			$data['wait'] = 3;
			$data['url'] = site_url('admin/goodtypes/index');
			$this->load->view('message.html',$data);
		}
	}
	public function update(){

		$data['type_id'] = $this->input->post('type_id');
		$data['type_name'] = $this->input->post('type_name');
		$data['deleted'] = $this->input->post('deleted');
		if($this->good_type_model->update($data)){

			$data['message'] = 'Update Successfully';
			$data['wait'] = 3;
			$data['url'] = site_url('admin/goodtypes/index');
			$this->load->view('message.html',$data);
		}else{
			$data['message'] = 'Update Successfully';
			$data['wait'] = 3;
			$data['url'] = site_url('admin/goodtypes/edit');
			$this->load->view('message.html',$data);
		}
		
	}
	public function edit($type_id){
		$data['goods_type'] = $this->good_type_model->get($type_id);
		/*var_dump($goods_type);
		exit();*/
		$this->load->view('goods_type_edit.html',$data);
	}
}