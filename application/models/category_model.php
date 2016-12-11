<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model{
	const TL_CAT ="ci_category";
	public function list($pid =0,$limit="",$offset=""){
		$query = $this->db->limit($limit,$offset)->get(self::TL_CAT);
		$cates = $query->result_array();
		return $this->_tree($cates,$pid,0);
	}
	private function _tree($arr,$pid,$level){
		static $tree = array();
		foreach ($arr as $v) {
			# code...
			if($v['parent_id']==$pid){
				$v['level'] = $level+1;
				$tree[] = $v;
				$this->_tree($arr,$v['cat_id'],$level+1);
			}
		}
		return $tree;
	}
	public function add($data){
		return $this->db->insert(self::TL_CAT,$data);
	}
	public function get($cat_id){
		$query = $this->db->where('cat_id', $cat_id)->get(self::TL_CAT);
		return $query->row_array();

	}
	public function update($data,$cat_id){
		return $this->db->update(self::TL_CAT, $data,"cat_id=".$cat_id); 

	}
	public function child($arr,$pid){
		$child = array();
		foreach ($arr as $k => $v) {
			if($v['parent_id']==$pid){
			$child[] = $v;
			}
		}
		return $child;
	}
	public function cate_list($arr,$pid=0){
		$child = $this->child($arr,$pid);
		if(empty($child)){
			return null;
		}
		foreach ($child as $k => $v) {
			$grandson = $this->cate_list($arr,$v['cat_id']);
			if(!empty($grandson)){
				$child[$k]['child'] = $grandson;
			}
		}
		return $child;
	}
	/*normal user*/
	public function front_cates(){
		$query = $this->db->get(self::TL_CAT);
		$cates = $query->result_array();
		return $this->cate_list($cates,$pid=0);
	}
	/*admin user*/
	public function delete($cat_id){
		return $this->db->where('cat_id',$cat_id)->delete(self::TL_CAT);
	}
	public function count_cates(){
		return $this->db->count_all(self::TL_CAT);
	}
}