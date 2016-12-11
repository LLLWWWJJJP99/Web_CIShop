<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand_model extends CI_Model{
	const TL_Brand ='ci_brand';
	public function insert($data){
		return $this->db->insert(self::TL_Brand,$data);
	}
	public function list($limit="",$offset=""){
		 $query = $this->db->limit($limit,$offset)->get(self::TL_Brand);
		 return $query->result_array();

	}
	public function delete($brand_id){
		return $this->db->where('brand_id=',$brand_id)->delete(self::TL_Brand);
	}
	public function update($data){
		return $this->db->where('brand_id=',$data['brand_id'])->update(self::TL_Brand,$data);
	}
	public function get($brand_id){
		$query = $this->db->where("brand_id=",$brand_id)->get(self::TL_Brand);
		return $query->row_array();
	}
	public function count_brands(){
		return $this->db->count_all_results(self::TL_Brand);
	}
}