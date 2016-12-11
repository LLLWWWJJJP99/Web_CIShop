<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends AdminController{
	public function index(){
		$this->load->view('index.html');
	}
	public function top(){
		$this->load->view('top.html');
	}
	public function menu(){
		$this->load->view('menu.html');
	}
	public function drag(){
		$this->load->view('drag.html');
	}
	public function content(){
		$this->load->view('main.html');
	}
}