<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends HomeController{
	public function __construct(){
		parent::__construct();
		$this->load->model('category_model');
		$this->load->model('good_type_model');
		$this->load->model('brand_model');
		$this->load->model('category_model');
		$this->load->model('attribute_model');
		$this->load->model('goods_model');
		$this->load->library('pagination');

	}
	public function index($goods_id){
		$data["goods"] = $this->goods_model->get($goods_id);
		$this->load->view('goods.html',$data);
	}
	public function search($offset=""){
		/*$data2['cat_id'] = $this->input->post('cat_id');
		$data2['brand_id'] = $this->input->post('brand_id');*/
		$data['keyword'] = $this->input->post('keyword');
		//$data['cates'] = $this->category_model->list();
		//$data['brands'] = $this->brand_model->list();
		$config['base_url'] = site_url('goods/search');
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;		
		$config['num_links'] = 2;
		$config['first_link'] = '&nbsp;First&nbsp;';
		$config['last_link'] = '&nbsp;Last&nbsp;';
		$config['prev_link'] = '&nbsp;Previous&nbsp;';
		$config['next_link'] = '&nbsp;Next&nbsp;';
		$limits = $config['per_page'];
		$config['total_rows'] = $this->goods_model->count_onsale_goods();
		$this->pagination->initialize($config);
		$data['pageinfo'] = $this->pagination->create_links();
		$data['goods'] = $this->goods_model->front_search($data,$limits,$offset);
		$data["cates"] = $this->category_model->front_cates();
		$this->load->view('search.html',$data);
	}
	public function cates_search($cat_id,$offset=""){

		//$data['cates'] = $this->category_model->list();
		//$data['brands'] = $this->brand_model->list();
		$config['base_url'] = site_url('goods/search');
		$config['per_page'] = 20;
		$config['uri_segment'] = 5;		
		$config['num_links'] = 2;
		$config['first_link'] = '&nbsp;First&nbsp;';
		$config['last_link'] = '&nbsp;Last&nbsp;';
		$config['prev_link'] = '&nbsp;Previous&nbsp;';
		$config['next_link'] = '&nbsp;Next&nbsp;';
		$limits = $config['per_page'];
		$config['total_rows'] = $this->goods_model->count_onsale_goods();
		$this->pagination->initialize($config);
		$data['pageinfo'] = $this->pagination->create_links();
		$data['cur_cate'] = $this->category_model->get($cat_id);
		$data['goods'] = $this->goods_model->searchByCat($cat_id,$limits,$offset);
		$data["cates"] = $this->category_model->front_cates();
		$this->load->view('category.html',$data);
	}
}