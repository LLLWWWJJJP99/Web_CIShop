<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_user_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function find($username,$password){
		$sql = "select * from ci_admin_user where user_name ='".$username."' and password='".$password."';";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	public function add(){

	}
}