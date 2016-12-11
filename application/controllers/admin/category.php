<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends AdminController{
	public function __construct(){
		parent::__construct();
		$this->load->model("category_model");
		$this->output->enable_profiler(FALSE);
		$this->load->library('form_validation');
		$this->load->library('pagination');

	}

	public function search(){//未完
		$this->load->view("cat_list.html");
	}
	public function index($offset=""){

		$config['uri_segment']=4;
		$config['per_page'] =20;
		$config['base_url'] = site_url('admin/category/index');
		$config['total_rows'] = $this->category_model->count_cates();

		$config['num_links'] = 2;
		$config['first_link'] = '&nbsp;First&nbsp;';
		$config['last_link'] = '&nbsp;Last&nbsp;';
		$config['prev_link'] = '&nbsp;Previous&nbsp;';
		$config['next_link'] = '&nbsp;Next&nbsp;';

		$this->pagination->initialize($config);
		$limits = $config['per_page'];
		$data['pageinfo'] = $this->pagination->create_links();

		$data["cates"] = $this->category_model->list($pid =0,$limits,$offset);
			
		
		$this->load->view("cat_list.html",$data);
	}
	public function add(){


		$data["cates"] = $this->category_model->list();
			
		$this->load->view("cat_add.html",$data);
	}
	public function delete($cat_id){
		if($this->category_model->delete($cat_id)){
			$data['message'] = "Delete Successfully";
			$data['wait'] = 3;
			$data['url'] = site_url('admin/category/index');
			$this->load->view('message.html',$data);
		}else{
			$data['message'] = "Delete Unsuccessfully";
			$data['wait'] = 3;
			$data['url'] = site_url('admin/category/index');
			$this->load->view('message.html',$data);
		}
	}
	public function edit($cat_id){
		$data["cates"] = $this->category_model->list();
		$data['cur_cat'] = $this->category_model->get($cat_id);
		//var_dump( $data['cur_cat']);
		$this->load->view("cat_edit.html",$data);
	}
	public function insert(){
		$this->form_validation->set_rules('cat_name','CategoryName','required|trim');
		if(!$this->form_validation->run()){
			$data['url'] = site_url('admin/category/add');
			$data['message'] = validation_errors(); 
			$data['wait'] = 3;
			$this->load->view('message.html',$data);
		}else{
			$data['cat_name'] = $this->input->post('cat_name');
			$data['parent_id'] = $this->input->post('parent_id');
			$data['cat_desc'] = $this->input->post('cat_desc');
			$data['sort_order'] = $this->input->post('sort_order');
			$data['unit'] = $this->input->post('unit');
			$data['is_show'] = $this->input->post('is_show');
			if($this->category_model->add($data)){
				$data['message'] = 'Add Successfully';
				$data['wait'] = 3;
				$data['url'] = site_url('admin/category/index');
				$this->load->view('message.html',$data);
			} else{
				$data['url'] = site_url('admin/category/add');
				$data['message'] = "Fail to add"; 
				$data['wait'] = 3;
				$this->load->view('message.html',$data);
			}
		}
	}
		public function update(){
		$cat_id = $this->input->post('cat_id');
		$sub_cates = $this->category_model->list($cat_id);
		$sub_ids = array();
		foreach($sub_cates as $v){
			$sub_ids[] = $v['cat_id'];
		}
		$parent_id = $this->input->post('parent_id');
		#var_dump($sub_cates);
		if($parent_id==$cat_id||in_array($parent_id,$sub_ids)){
			$data['message'] ='Dont place current class as the child of itself or its children';
			$data['wait'] = 3;
			$data['url'] = site_url('admin/category/edit').'/'.$cat_id;
			$this->load->view('message.html',$data);
		}else{
			$this->form_validation->set_rules('cat_name','CategoryName','required|trim');
			if ($this->form_validation->run() == false) {
				$data['message'] = validation_errors(); 
				$data['wait'] = 3;
				$data['url'] = site_url('admin/category/edit').'/'.$cat_id;
				$this->load->view('message.html',$data);
			} else {
				$data['cat_name'] = $this->input->post('cat_name');
				$data['parent_id'] = $this->input->post('parent_id');
				$data['cat_desc'] = $this->input->post('cat_desc');
				$data['sort_order'] = $this->input->post('sort_order');
				$data['unit'] = $this->input->post('unit');
				$data['is_show'] = $this->input->post('is_show');
				if($this->category_model->update($data,$cat_id)){
					$data['message'] = 'Update Successfully'; 
					$data['wait'] = 3;
					$data['url'] = site_url('admin/category/index');
					$this->load->view('message.html',$data);
				}else{
					$data['message'] = 'Update Abortively'; 
					$data['wait'] = 3;
					$data['url'] = site_url('admin/category/edit').'/'.$cat_id;
					$this->load->view('message.html',$data);
				}
			}
		}
	}
}