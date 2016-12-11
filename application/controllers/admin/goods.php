<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends AdminController{
	public function __construct(){
		parent::__construct();
		$this->load->model('category_model');
		$this->load->model('good_type_model');
		$this->load->model('brand_model');
		$this->load->model('category_model');
		$this->load->model('attribute_model');
		$this->load->model('goods_model');
		$this->load->library('pagination');
		$this->load->library('cart');
	}
	public function index($offset=""){

		$data['cates'] = $this->category_model->list();
		$data['brands'] = $this->brand_model->list();
		$config['base_url'] = site_url('admin/goods/index');
		$config['per_page'] = 10;
		$config['uri_segment'] = 4;
		$config['total_rows'] = $this->goods_model->count_goods();
		$config['num_links'] = 2;

		$config['first_link'] = '&nbsp;First&nbsp;';
		$config['last_link'] = '&nbsp;Last&nbsp;';
		$config['prev_link'] = '&nbsp;Previous&nbsp;';
		$config['next_link'] = '&nbsp;Next&nbsp;';

		$this->pagination->initialize($config);

		$data['pageinfo'] = $this->pagination->create_links();
		$limits = $config['per_page'];
		$data['goods'] = $this->goods_model->admin_index($limits,$offset);
		
		$this->load->view('goods_list.html',$data);
	}
	public function add(){
		$data['goodtypes'] = $this->good_type_model->get_all();
		$data['cates'] = $this->category_model->list();
		$data['brands'] = $this->brand_model->list();
		$this->load->view('goods_add.html',$data);
	}
	public function insert(){
		$data['goods_name'] = $this->input->post('goods_name');
		$data['cat_id'] = $this->input->post('cat_id');
		$data['brand_id'] = $this->input->post('brand_id');
		$data['shop_price'] = $this->input->post('shop_price');
		$data['goods_number'] = $this->input->post('goods_number');
		$data['type_id'] = $this->input->post('type_id');
		$data['is_best'] = $this->input->post('is_best');
		$data['is_new'] = $this->input->post('is_new');
		$data['is_hot'] = $this->input->post('is_hot');
		$config['upload_path'] = './public/uploads';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '500';
		$this->load->library('upload',$config);
		if($this->upload->do_upload('goods_img')){
			$res = $this->upload->data();
			$config_img['image_libary'] = 'gd2';
			$config_img['source_image'] = './public/uploads/'.$res['file_name'];
			$config_img['create_thumb'] = TRUE;
			$config_img['maintain_ratio'] = TRUE;
			$config_img['width'] = '160';
			$config_img['height'] = '160';
			$this->load->library('image_lib',$config_img);
			if($this->image_lib->resize() ){
				$data['goods_img'] = $res['file_name'];
				$data['goods_thumb'] = $res['raw_name'].$this->image_lib->thumb_marker.$res['file_ext'];
				if($goods_id = $this->goods_model->insert($data)){
					$attr_ids = $this->input->post('attr_id_list');
					$attr_values = $this->input->post('attr_value_list');
					if(!empty($attr_values)){
						foreach ($attr_values as $key => $value) {
							if(!empty($value)){
								$data2['goods_id'] = $goods_id;
								$data2['attr_id'] = $attr_ids[$key];
								$data2['attr_value'] = $value;
								$this->db->insert('goods_attr',$data2);
							}
						}
					}
					$data['message'] = 'Insert Successfully';
					$data['wait'] = 3;
					$data['url'] = site_url('admin/goods/index');
					$this->load->view('message.html',$data);
				}else{
					$data['message'] = 'Insert Unsuccessfully';
					$data['wait'] = 3;
					$data['url'] = site_url('admin/goods/add');
					$this->load->view('message.html',$data);
				}
			}else{
				$data['message'] = $this->image_lib->display_errors();
				$data['wait'] = 3;
				$data['url'] = site_url('admin/goods/add');
				$this->load->view('message.html',$data);
			}
		}else{
			$data['message'] = $this->upload->display_errors();
			$data['wait'] = 3;
			$data['url'] = site_url('admin/goods/add');
			$this->load->view('message.html',$data);
		}
	}
	public function find_GoodAttribute(){
		$index = $this->input->get("type_id");
		$data['attributes'] = $this->attribute_model->get($index);

		$html = "";
		foreach ($data['attributes'] as $attr) {
			$html .="<tr><td class ='label'>".$attr['attr_name']."</td>";
			$html .= "<td>";
			$html .= "<input type='hidden' name='attr_id_list[]' value='".$attr['attr_id']."'/>";
			switch ($attr['attr_input_type']) {
				case 0:
					$html.= "<input type='text' name='attr_value_list[]'>".$attr['attr_value']."</input>";
					break;
				case 1:
					$attr_values = explode(PHP_EOL, $attr['attr_value']);
					$html .= "<select name='attr_value_list[]'>";
					$html .= "<option value=''>Please Select...</option>";
					foreach ($attr_values as $v) {
						$html .= "<option value='$v'>".$v."</option>";
					}
					$html .= "</select>";
					break;
				case 2:
					break;
				default:
					# code...
					break;
			}
			$html .="</td>";
			$html .= "</tr>";
		}
		echo $html;
	}
	public function cart_delte($goods_id){
		$data['rowid'] = $goods_id;
		$data['qty'] =0;
		$b = $this->cart->update($data);
	}
	public function delete($goods_id){
		$this->cart_delte($goods_id);
		if($this->goods_model->delete($goods_id)){
			
			$data['message'] = "Delete Successfully";
			$data['wait'] = 3;
			$data['url'] = site_url('admin/goods/index');
			$this->load->view('message.html',$data);
		}else{
			$data['message'] = "Delete Unsuccessfully";
			$data['wait'] = 3;
			$data['url'] = site_url('admin/goods/index');
			$this->load->view('message.html',$data);
		}
	}
	public function edit($good_id){
		//$good_id = $this->input->post('good_id');
		$data['cur_good'] = $this->goods_model->get($good_id);
		$data['brands'] = $this->brand_model->list();
		$data['cates'] = $this->category_model->list();
		$data['goodtypes'] = $this->good_type_model->get_all();

		$this->load->view('goods_edit.html',$data);
	}
	public function update(){
		$is_onsale = $this->input->post('is_onsale');
		$data['is_onsale'] = 0;
		foreach ($is_onsale as $k) {
			if(isset($k)){
				$data['is_onsale'] = $k;
			}
		}
		$data['goods_id'] = $this->input->post('goods_id');
		$data['goods_name'] = $this->input->post('goods_name');
		$data['cat_id'] = $this->input->post('cat_id');
		$data['brand_id'] = $this->input->post('brand_id');
		$data['shop_price'] = $this->input->post('shop_price');
		$data['goods_number'] = $this->input->post('goods_number');
		$data['type_id'] = $this->input->post('type_id');
		$data['is_best'] = $this->input->post('is_best');
		$data['is_new'] = $this->input->post('is_new');
		$data['is_hot'] = $this->input->post('is_hot');
		$config['upload_path'] = './public/uploads';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '500';
		$this->load->library('upload', $config);
		if($this->upload->do_upload('goods_img')){
			$res = $this->upload->data();
			$config_img['image_libary'] = 'gd2';
			$config_img['source_image'] = './public/uploads/'.$res['file_name'];
			$config_img['create_thumb'] = TRUE;
			$config_img['maintain_ratio'] = TRUE;
			$config_img['width'] = '160';
			$config_img['height'] = '160';

			$this->load->library('image_lib', $config_img); 

			if($this->image_lib->resize()){

				$data['goods_img'] = $res['file_name'];
				$data['goods_thumb'] = $res['raw_name'].$this->image_lib->thumb_marker.$res['file_ext'];
				if($this->goods_model->update($data)){
					$data['message'] = "Update Successfully";
					$data['wait'] = 3;
					$data['url'] = site_url('admin/goods/index');
					$this->load->view('message.html',$data);
				}else{
					$data['message'] = "Update Unsuccessfully";
					$data['wait'] = 3;
					$data['url'] = site_url('admin/goods/index');
					$this->load->view('message.html',$data);
				}
			}else{
				$data['message'] = $this->image_lib->display_errors();
				$data['wait'] = 3;
				$data['url'] = site_url('admin/goods/index');
				$this->load->view('message.html',$data);
			}
		}else{
			$data['message'] = $this->upload->display_errors();
			$data['wait'] = 3;
			$data['url'] = site_url('admin/goods/index');
			$this->load->view('message.html',$data);
		}
	}
	public function search($offset=""){
		$data2['cat_id'] = $this->input->post('cat_id');
		$data2['brand_id'] = $this->input->post('brand_id');
		$data2['keyword'] = $this->input->post('keyword');

		$data['cates'] = $this->category_model->list();
		$data['brands'] = $this->brand_model->list();

		$config['base_url'] = site_url('admin/goods/index');
		$config['per_page'] = 2;
		$config['uri_segment'] = 4;		
		$config['num_links'] = 2;
		$config['first_link'] = '&nbsp;First&nbsp;';
		$config['last_link'] = '&nbsp;Last&nbsp;';
		$config['prev_link'] = '&nbsp;Previous&nbsp;';
		$config['next_link'] = '&nbsp;Next&nbsp;';
		$limits = $config['per_page'];
		$config['total_rows'] = $this->goods_model->count_search_goods($data2);
		$this->pagination->initialize($config);
		$data['pageinfo'] = $this->pagination->create_links();
		$data['goods'] = $this->goods_model->search($data2,$limits,$offset);

		$this->load->view('goods_list.html',$data);
	}
}