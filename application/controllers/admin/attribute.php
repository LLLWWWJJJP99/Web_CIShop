<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute extends AdminController{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('attribute_model');
		$this->load->model('good_type_model');
		$this->load->library('pagination');
	}

	public function index($offset=""){

		$config['base_url'] = site_url('admin/attribute/index');
		$config['total_rows'] = $this->attribute_model->count_attrs();
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
		$data['attrs'] = $this->attribute_model->list($limits,$offset);
			
		$this->load->view('attribute_list.html',$data);
	}
	public function add(){

		$data['goods'] = $this->good_type_model->get_all();
		
		$this->load->view('attribute_add.html',$data);
	}
	public function insert(){
		$this->form_validation->set_rules('attr_name','trim|required');
		if($this->form_validation->run()==false){
			$data['attr_name'] = $this->input->post('attr_name');
			$data['attr_input_type'] = $this->input->post('attr_input_type');
			$data['attr_value'] = $this->input->post('attr_value');
			$data['attr_type'] = $this->input->post('attr_type');
			//$data['sort_order'] = $this->input->post('sort_order');
			$data['type_id'] = $this->input->post('type_id');
			$data['deleted'] = $this->input->post('deleted');
			if($this->attribute_model->insert($data)){

				$data['message'] = 'Insert Successfully';
				$data['wait'] = 3;
				$data['url'] = site_url('admin/attribute/index');
				$this->load->view('message.html',$data);
			}else{
				$data['message'] = 'Insert Unsuccessfully';
				$data['wait'] = 3;
				$data['url'] = site_url('admin/attribute/add');
				$this->load->view('message.html',$data);
			}
		}else{
			$data['message'] = validation_errors();
			$data['wait'] = 3;
			$data['url'] = site_url('admin/attribute/add');
			$this->load->view('message.html',$data);
		}
	}
	public function edit($attribute_id){
		$data['goods'] = $this->good_type_model->get_all();
		$data['cur_attribute'] = $this->attribute_model->getByAttributeId($attribute_id);
		$this->load->view('attribute_edit.html',$data);
	}
	public function update(){
		$this->form_validation->set_rules('attr_name','trim|required');
		if($this->form_validation->run()==false){
			$data['attr_id'] = $this->input->post('attr_id');
			$data['attr_name'] = $this->input->post('attr_name');
			$data['attr_input_type'] = $this->input->post('attr_input_type');
			$data['attr_value'] = $this->input->post('attr_value');
			$data['attr_type'] = $this->input->post('attr_type');
			//$data['sort_order'] = $this->input->post('sort_order');
			$data['type_id'] = $this->input->post('type_id');
			$data['deleted'] = $this->input->post('deleted');
			if($this->attribute_model->update($data)){
				$data['message'] = 'Update Successfully';
				$data['wait'] = 3;
				$data['url'] = site_url('admin/attribute/index');
				$this->load->view('message.html',$data);
			}else{
				$data['message'] = 'Update Unsuccessfully';
				$data['wait'] = 3;
				$data['url'] = site_url('admin/attribute/index');
				$this->load->view('message.html',$data);
			}
		}else{
			$data['message'] = validation_errors();
			$data['wait'] = 3;
			$data['url'] = site_url('admin/attribute/index');
			$this->load->view('message.html',$data);
		}
	}
	public function delete($attribute_id){
		if($this->attribute_model->delete($attribute_id)){
			$data['url'] = site_url('admin/attribute/index');
			$data['message'] = 'Delete Successfully'; 
			$data['wait'] = 3;
			$this->load->view('message.html',$data);
		}else{
			$data['url'] = site_url('admin/attribute/index');
			$data['message'] = 'Delete Unsuccessfully'; 
			$data['wait'] = 3;
			$this->load->view('message.html',$data);
		}
		
	}
}