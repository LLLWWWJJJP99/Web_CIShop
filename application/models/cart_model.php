<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model{
	const TL_Cart ='ci_cart';
	public function insert($data){
		return $this->db->insert(self::TL_Cart,$data);
	}
	public function list(){
		 $query = $this->db->get(self::TL_Cart);
		 return $query->result_array();

	}
	public function delete($cart_id){
		return $this->db->where('cart_id=',$cart_id)->delete(self::TL_Cart);
	}
	public function update($data){
		return $this->db->where('cart_id=',$data['cart_id'])->update(self::TL_Cart,$data);
	}
	public function get($cart_id){
		$query = $this->db->where("cart_id=",$cart_id)->get(self::TL_Cart);
		return $query->row_array();
	}
}