<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('captcha');
		$this->load->library('form_validation');
		$this->load->model('admin_user_model');
	}
	public function login(){
		//$this->load->library('session');
		/*$vals = array(

				'img_path'=>'./data/captcha/',
				'img_url'=>base_url().'data/captcha/',
				'word'=>'1000-9999'
			);
		$data = create_captcha($vals);*/
		$this->load->view('login.html');
	}
	/*generate a captcha and save it in the session*/
	public function code(){
		$vars = array(
				'word_length' =>4
			);
		$code = create_captcha($vars);
		$this->session->set_userdata('code',$code);
		//$this->load->view('message.html');
	}
	/*verrify input 1.username,password required!*/
	public function signup(){

			$this->form_validation->set_rules("username","Username","required");
			$this->form_validation->set_rules("password","Password","required");

			$code = strtolower($this->session->userdata('code'));
			$val = strtolower($this->input->post('captcha'));
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if($this->form_validation->run()==false){
				$data["url"] = site_url("admin/signin/login");
				$data["message"] = validation_error();
				$data["wait"] = 3;
				$this->load->view("message.html",$data);
			}else{
				if($code===$val){
					$admin_info = $this->admin_user_model->find($username,$password);
					if(count($admin_info)==0){
						$data['message'] ="Please Input A Valid Username Or Password";
						$data['wait'] = 3;
						$data['url'] = site_url("admin/signin/login");
						$this->load->view('message.html',$data);
					}else{
						$this->session->set_userdata('username', $admin_info);
						redirect('admin/main/index');
					}
				}else{
					$data['message'] ="Please Input A Valid Captcha";
					$data['wait'] = 3;
					$data['url'] = site_url("admin/signin/login");
					$this->load->view('message.html',$data);
				}
			}
		
	}
	/*log out when users click sign out button*/
	public function signout(){
		
		$this->session->unset_userdata('username');
		$this->session->sess_destroy();
		redirect('admin/signin/login');
	}
}