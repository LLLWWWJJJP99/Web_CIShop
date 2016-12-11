<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends HomeController{
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('goods_model');
		$this->load->model('cart_model');
		$this->load->library('form_validation');
		//$this->load->library('form_validation');
	}
	public function index(){
		$data['carts'] = $this->cart->contents();
		$this->load->view('flow.html',$data);
	}
	public function add(){

		$data['goods_id'] = $this->input->post('goods_id');
		$good = $this->goods_model->get($data['goods_id']);
		if($good['goods_number']==0){
			$data['message'] = "Sorry This Goods Has Been Run Out,Add Next Time";
			$data['wait'] = 3;
			$data['url'] = site_url('home/index');
			$this->load->view('message.html',$data);
		}else{
			$data['goods_number'] = $this->input->post('good_nums');
			$difference = $good['goods_number'] - $data['goods_number'];
			if($difference<=0){
				$data['message'] = "Sorry The Number Of Goods You Purchase Exceeds The Stock";
				$data['wait'] = 3;
				$data['url'] = site_url('home/index');
				$this->load->view('message.html',$data);
			}else{
				$data['shop_price'] = $this->input->post('shop_price');
				$data['goods_name'] = $this->input->post('goods_name');
				$data['goods_thumb'] = $this->input->post('goods_thumb');
				$thumbs = array('thumbs' => $data['goods_thumb'] );
				$user = $this->session->userdata('user');
				$data['user_id'] = $user['user_id'];
				$_cart = array(
					'id' => $data['goods_id'],
					'price' => $data['shop_price'],
					'name' =>$data['goods_name'],
					'qty' =>$data['goods_number'],
					'options' => $thumbs
				);
				$carts = $this->cart->contents();
				if($this->cart->insert($_cart)){
						redirect('cart/index');
				}else{
					$data['message'] = "Add to Cart Unsuccessfully";
					$data['wait'] = 3;
					$data['url'] = site_url('cart/index');
					$this->load->view('message.html',$data);
				}
			}
		}
		
	}
	public function delete($id){
		$data['rowid'] = $id;
		$data['qty'] =0;
		
		$this->cart->update($data);
		redirect('cart/index');
	}
	public function pay(){

		$login=$this->session->userdata('user');
		$user_id = $login['user_id'];
		if(isset($user_id)){
			$order['user_id'] = $user_id;
			$goods = $this->input->post();
			foreach ($goods['qty'] as $good_id => $good_qty) {
				$good = $this->goods_model->get($good_id);
				$good['goods_number']-=$good_qty;
				$good['goods_id'] = $good_id;
				$this->goods_model->set_num($good);
				$order['goods_id'] = $good_id;
				$order['quantity'] = $good_qty;
				$this->user_model->insert_order($order);
			}
			$this->cart->destroy();
			$data['message'] = "CheckOut Successfully!!!";
			$data['wait'] = 4;
			$data['url'] = site_url('home/index');
			$this->load->view('message.html',$data);
		}else{
			$data['message'] = "Please Login Before You CheckOut";
			$data['wait'] = 5;
			$data['url'] = site_url('home/index');
			$this->load->view('message.html',$data);
		}
	}
}