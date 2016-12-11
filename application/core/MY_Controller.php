<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class AdminController extends CI_Controller
{
	
	function __construct()
	{

		parent::__construct();
		$this->load->switch_theme_off();
		if(!$this->session->userdata('username')){

			redirect('admin/signin/login');
		}
	}
	
}

/**
* 
*/
class HomeController extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->switch_theme_on();
		
	}
}