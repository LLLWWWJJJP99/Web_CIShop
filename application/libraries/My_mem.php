<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_mem{
	private static $_mem =null;
	public function get_mem(){
		if(is_null(self::$_mem)){
			self::$_mem = new Memcache();
			self::$_mem -> connect('localhost',11211);
		}
		return self::$_mem;
	}
}