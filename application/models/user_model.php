<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model{
	const TL_USER = 'ci_user';
	const TL_ORDER = 'ci_order';
	public function insert($data){
		return $this->db->insert(self::TL_USER,$data);
	}
	public function get($username,$password){
		$condition['user_name'] = $username;
		$condition['password'] = md5($password);
		$query = $this->db->where($condition)->get(self::TL_USER);
		return $query->row_array();
	}
	public function findByEmail(){
		$email = $this->input->get("email");
		$condition['email'] = $email;
		$query = $this->db->where($condition)->get(self::TL_USER);
		/*var_dump($query);
		exit();*/
		return $query->row_array();
	}
	public function findByName(){
		$user_name = $this->input->get("user_name");
		$condition['user_name'] = $user_name;
		$query = $this->db->where($condition)->get(self::TL_USER);
		return $query->row_array();
	}
	//!!
	public function view_order($userid)
	{
		
		//select ci_user.user_name,ci_order.quantity, ci_order.shop_price from ci_order join ci_user on ci_user.user_id = ci_order.user_id , join ci_goods on ci_goods.goods_id = ci_order.goods_id where ci_user.user_id =1;
		//$sql = 'select user_name,quantity,shop_price from ci_order join ci_user on ci_user.user_id = ci_order.user_id join ci_goods on ci_goods.goods_id = ci_order.goods_id where ci_user.user_id ='.$userid;
		$this->db->select('order_id,user_name,quantity,shop_price, goods_name');
		$this->db->from('ci_order');
		$this->db->join('ci_user','ci_user.user_id = ci_order.user_id');
		$this->db->join('ci_goods','ci_goods.goods_id = ci_order.goods_id');
		$this->db->where('ci_user.user_id',$userid);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public function insert_order($data){
		return $this->db->insert('ci_order',$data);
	}
	public function delete_order($order_id){
		return $this->db->where("order_id",$order_id)->delete(self::TL_ORDER);
	}
}
