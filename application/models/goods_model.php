<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Goods_model extends CI_Model{
	const TL_goods= 'ci_goods';
	public function __construct(){
		parent::__construct();
	}
	public function best_goods(){
		$condition['is_best'] = 1;
		$query = $this->db->limit(4)->where($condition)->get(self::TL_goods);
		return $query->result_array();
	}
	public function new_goods(){
		$condition['is_new'] = 1;
		$query = $this->db->limit(4)->where($condition)->get(self::TL_goods);
		return $query->result_array();
	}
	public function hot_goods(){
		$condition['is_hot'] = 1;
		$query = $this->db->limit(4)->where($condition)->get(self::TL_goods);
		return $query->result_array();
	}
	public function insert($data){
		$query = $this->db->insert(self::TL_goods,$data);
		return $query? $this->db->insert_id() : false;
	}
	public function get($goods_id){
		$query = $this->db->where('goods_id='.$goods_id)->get(self::TL_goods);
		return $query->row_array();
	}
	public function rank_goods(){
		/*->where("count(*)<3")*/
		$query = $this->db->where('is_onsale',1)->limit(8)->order_by("click_count","asec")->get(self::TL_goods);
		return $query->result_array();
	}
	public function index(){
		$query = $this->db->where('is_onsale',1)->get(self::TL_goods);
		return $query->result_array();
	}
	public function set_num($data){

		return $this->db->set('goods_number',$data['goods_number'])->where('goods_id',$data['goods_id'])->update(self::TL_goods);
	}
	public function front_search($data,$limits,$offset){
		$condition = " 1 = 1 ";
		if(strlen($data['keyword'])!=0){
			$condition.=" and goods_name like '%".$data['keyword']."%' or goods_desc like '%".$data['keyword']."%' or goods_brief like '%".$data['keyword']."%'";
		}
		$condition.=" and is_onsale = 1";
		return $this->db->where($condition)->limit($limits,$offset)->get(self::TL_goods)->result_array();
	}
	public function count_onsale_goods(){
		return $this->db->where('is_onsale',1)->count_all_results(self::TL_goods);
	}
	public function searchByCat($cat_id,$limits,$offset){
		//$query = $this->db->where('goods_id='.$goods_id)->get(self::TL_goods);
		return $this->db->where('cat_id',$cat_id)->limit($limits,$offset)->get(self::TL_goods)->result_array();
	}
	/*normal user*/
	/*admin user*/
	public  function admin_index($limits,$offset){
		$query = $this->db->limit($limits,$offset)->get(self::TL_goods);
		return $query->result_array();
	}
	public function update($data){
		return $this->db->where("goods_id =".$data['goods_id'])->update(self::TL_goods,$data);
	}
	public function delete($goods_id){
		return $this->db->where('goods_id',$goods_id)->set("is_onsale",0)->update(self::TL_goods);
		 //$this->db->where('goods_id',$goods_id)->delete(self::TL_goods);
	}
	public function count_goods(){
		return $this->db->count_all_results(self::TL_goods);
	}
	public function search($data,$limits,$offset){
		/*$condition = "cat_id=".$data['cat_id']." "*/
		$condition = " 1 = 1 ";
		if($data['cat_id']!=0){
			$condition.=" and cat_id =".$data['cat_id'];
		}
		if($data['brand_id']!=0){
			$condition.=" and brand_id =".$data['brand_id'];
		}
		if(strlen($data['keyword'])!=0){
			$condition.=" and goods_name like '%".$data['keyword']."%' or goods_desc like '%".$data['keyword']."%' or goods_brief like '%".$data['keyword']."%'";
		}
		return $this->db->where($condition)->limit($limits,$offset)->get(self::TL_goods)->result_array();
	}
	public function count_search_goods($data){
		$condition = " 1 = 1 ";
		if($data['cat_id']!=0){
			$condition.=" and cat_id =".$data['cat_id'];
		}
		if($data['brand_id']!=0){
			$condition.=" and brand_id =".$data['brand_id'];
		}
		if(strlen($data['keyword'])!=0){
			$condition.=" and goods_name like '%".$data['keyword']."%' or goods_desc like '%".$data['keyword']."%' or goods_brief like '%".$data['keyword']."%'";
		}
		$result = $this->db->where($condition)->get(self::TL_goods)->result_array();
		return count($result);
	}
}