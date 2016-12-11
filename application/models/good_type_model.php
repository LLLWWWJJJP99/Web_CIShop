<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Good_type_model extends CI_Model{
	const TL_Good_type = "ci_goods_type";
	/*admin user*/
	public function insert($data){
		return $this->db->insert(self::TL_Good_type,$data);
	}
	public function count_good_types(){
		return $this->db->count_all_results(self::TL_Good_type);
	}
	public function list($limit,$offset){
		$query = $this->db->limit($limit,$offset)->get(self::TL_Good_type);
		return $query->result_array();
	}
	public function get_all(){
	$query = $this->db->get(self::TL_Good_type);
	return $query->result_array();
	}
	public function update($data){
		return $this->db->where('type_id',$data['type_id'])->update(self::TL_Good_type,$data);
	}
	public function get($type_id){
		$query = $this->db->where('type_id',$type_id)->get(self::TL_Good_type);

		return $query->row_array();
	}
	public function delete($type_id){
		return $this->db->where('type_id',$type_id)->delete(self::TL_Good_type);
	}
	/*normal user*/
}