<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Brand extends AdminController{
	public function __construct(){
		parent::__construct();
		$this->load->model('brand_model');
		$this->load->library('upload');
		$this->load->library('pagination');
		$this->load->library('form_validation');
	}
	public function add(){
		$this->load->view('brand_add.html');
	}
	public function index($offset=""){

		$config['uri_segment']=4;
		$config['per_page'] =2;
		$config['base_url'] = site_url('admin/brand/index');
		$config['total_rows'] = $this->brand_model->count_brands();

		$config['num_links'] = 2;
		$config['first_link'] = '&nbsp;First&nbsp;';
		$config['last_link'] = '&nbsp;Last&nbsp;';
		$config['prev_link'] = '&nbsp;Previous&nbsp;';
		$config['next_link'] = '&nbsp;Next&nbsp;';

		$this->pagination->initialize($config);
		$limits = $config['per_page'];
		$data['pageinfo'] = $this->pagination->create_links();
		$data["brands"] = $this->brand_model->list($limits,$offset);
		
		$this->load->view('brand_list.html',$data);
	}
	public function insert(){
		$this->form_validation->set_rules('brand_name','Brand_name','trim|required');
		if(!$this->form_validation->run()){
			$data['url'] = site_url('admin/brand/add');
			$data['message'] = validation_errors(); 
			$data['wait'] = 3;
			$this->load->view('message.html',$data);
		}else{
			if(!$this->upload->do_upload('logo')){
				$data['url'] = site_url('admin/brand/add');
				$data['message'] = $this->upload->display_errors(); 
				$data['wait'] = 3;
				$this->load->view('message.html',$data);
			}else{
				$file_info = $this->upload->data();
				$data['logo'] = $file_info['file_name'];
				$data['brand_name'] = $this->input->post('brand_name');
				$data['brand_desc'] = $this->input->post('brand_desc');
				$data['brand_name'] = $this->input->post('brand_name');
				$data['url'] = $this->input->post('url');
				$data['sort_order'] = $this->input->post('sort_order');
				if($this->brand_model->insert($data)){
					$data['url'] = site_url('admin/brand/index');
					$data['message'] = 'Add Successfully'; 
					$data['wait'] = 3;
					$this->load->view('message.html',$data);
				}else{
					$data['url'] = site_url('admin/brand/add');
					$data['message'] = 'Add Unsuccessfully'; 
					$data['wait'] = 3;
					$this->load->view('message.html',$data);
				}
			}
		}
	}
	public function delete($brand_id){
		if($this->brand_model->delete($brand_id)){
			$data['url'] = site_url('admin/brand/index');
			$data['message'] = 'Delete Successfully'; 
			$data['wait'] = 3;
			$this->load->view('message.html',$data);
		}else{
			$data['url'] = site_url('admin/brand/index');
			$data['message'] = 'Delete Unsuccessfully'; 
			$data['wait'] = 3;
			$this->load->view('message.html',$data);
		}
		
	}
	public function edit($brand_id){
		

		$data['cur_brand'] = $this->brand_model->get($brand_id);
		$this->load->view('brand_edit.html',$data);
	}
	public function update(){

		$this->form_validation->set_rules('brand_name','Brand_name','trim|required');

			if($this->form_validation->run()){
				if($this->upload->do_upload('logo')){
					$data['brand_id'] = $this->input->post('brand_id');
					$data['is_show'] = $this->input->post('is_show');
					$file_info = $this->upload->data();
					$data['logo'] = $file_info['file_name'];
					$data['url'] = $this->input->post('url');
					$data['brand_desc'] = $this->input->post('brand_desc');
					$data['brand_name'] = $this->input->post('brand_name');
					if($this->brand_model->update($data)){
						$data['url'] = site_url('admin/brand/index');
						$data['message'] = 'update Successfully'; 
						$data['wait'] = 3;
						$this->load->view('message.html',$data);
					}else{
						$data['url'] = site_url('admin/brand/index');
						$data['message'] = 'update Unsuccessfully'; 
						$data['wait'] = 3;
						$this->load->view('message.html',$data);
					}
				}else{
					$data['url'] = site_url('admin/brand/index');
					$data['message'] = $this->upload->display_errors(); 
					$data['wait'] = 3;
					$this->load->view('message.html',$data);
				}
			}else{
				$data['url'] = site_url('admin/brand/index');
				$data['message'] = validation_errors(); 
				$data['wait'] = 3;
				$this->load->view('message.html',$data);
			}
	}
}