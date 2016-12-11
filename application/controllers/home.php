<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends HomeController{
	public function __construct(){
		parent::__construct();
		$this->load->model('category_model');
		$this->load->model('good_type_model');
		$this->load->model('brand_model');
		$this->load->model('category_model');
		$this->load->model('attribute_model');
		$this->load->model('goods_model');
	}
	public function index(){
		$data["hot_goods"] = $this->goods_model->hot_goods();
		$data["new_goods"] = $this->goods_model->new_goods();
		$data["best_goods"] = $this->goods_model->best_goods();
		$data["cates"] = $this->category_model->front_cates();
		/*$data["ranks"] = $this->goods_model->rank_goods_top3();*/
		$data["ranks"] = $this->goods_model->rank_goods();
		/*var_dump($data['cates']); exit();*/
		$data["brands"] = $this->brand_model->list();
		$data["all_goods"] = $this->goods_model->index();
		$this->load->view('index.html',$data);
	}
}