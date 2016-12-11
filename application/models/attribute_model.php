<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Attribute_Model extends CI_Model{
	const TL_Attribute = "ci_attribute";
	public function insert($data){
		return $this->db->insert(self::TL_Attribute,$data);
	}
	public function list($limits,$offset){
	$query = $this->db->limit($limits,$offset)->get(self::TL_Attribute);
		return $query->result_array();
	}
	public function get($type_id){
		$where = "type_id='".$type_id."'";
		$query = $this->db->where($where)->get(self::TL_Attribute);
		return $query->result_array();
	}

	/*this getByAttributeId not the type_id*/
	public function getByAttributeId($attr_id){
		$where = "attr_id='".$attr_id."'";
		$query = $this->db->where($where)->get(self::TL_Attribute);
		return $query->row_array();
	}
	public function delete($attr_id){
		return $this->db->where('attr_id=',$attr_id)->delete(self::TL_Attribute);
	}
	public function update($data){
		return $this->db->where('attr_id=',$data['attr_id'])->update(self::TL_Attribute,$data);
	}
	public function count_attrs(){
		return $this->db->count_all_results(self::TL_Attribute);
	}
}