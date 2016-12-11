<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends HomeController{
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->load->helper('captcha');
		$this->load->library('email');
		//$this->load->library('email');
	}
	public function register(){
		$this->load->view('register.html');
	}
	public function login(){
		$this->load->view('login.html');
	}
	public function signin(){
		$captcha = $this->input->post('captcha');
  		$captcha2 = $this->session->userdata('code2');
  		if($captcha==$captcha2){
  			$username = $this->input->post("username");
			$password = $this->input->post("password");
			if($user = $this->user_model->get($username,$password)){

				$this->session->set_userdata("user",$user);
				redirect('home/index');
			}else{
				$data['message'] = "Login Unsuccessfully";
				$data['wait'] = 3;
				$data['url'] = site_url('home/index');
				$this->load->view('message.html',$data);
			}
  		}else{
  			$data['message'] = "Unfortunatly! Please input a valid captcha";
			$data['wait'] = 3;
			$data['url'] = site_url('user/login');
			$this->load->view('message.html',$data);
  		}


	}
	public function insert(){
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|md5');
  		$this->form_validation->set_rules('repwd', 'Password Confirmation', 'trim|required|md5|matches[password]');
  		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
  		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[10]');

  		$captcha = $this->input->post('captcha');
  		$captcha2 = $this->session->userdata('code2');
  		if($captcha==$captcha2){
  			if(!$this->form_validation->run()){
	  			$data['message'] = validation_errors();
	  			$data['wait'] = 3;
	  			$data['url'] = site_url('user/register');
	  			$this->load->view('message.html',$data);
	  		}else{
	  			$data['user_name'] = $this->input->post('username');
	  			$data['password'] = $this->input->post('password');
	  			$data['email'] = $this->input->post('email');
	  			$data['reg_time'] = time();
	  			//$this->sendEmail($data);
	  			if($this->user_model->insert($data)){
	  				$data['message'] = "Congradulation! Register Successfully And Please Confirm Your registration In Your Email";
	  				$data['wait'] = 8;
	  				$data['url'] = site_url('home/index');
	  				$this->load->view('message.html',$data);
	  			}else{
	  				$data['message'] = "Unfortunatly! register unsuccessfully";
	  				$data['wait'] = 3;
	  				$data['url'] = site_url('user/register');
	  				$this->load->view('message.html',$data);
	  			}
	  		}
  		}else{
  			$data['message'] = "Unfortunatly! Please input a valid captcha";
			$data['wait'] = 3;
			$data['url'] = site_url('user/register');
			$this->load->view('message.html',$data);
  		}
	}
	public function signout(){
		$this->session->unset_userdata('user');
		redirect("home/index");
	}
	public function findByEmail($email=""){
		$result = $this->user_model->findByEmail($email);
		if(count($result)>0){
			echo "no";
		}else{
			echo "yes";
		}
	}
	public function findByName($username=""){
		$result = $this->user_model->findByName($username);
		if(count($result)>0){
			echo "no";
		}else{
			echo "yes";
		}
	}
	public function code(){
		$vars = array(
				'word_length' =>4
			);
		$code = create_captcha($vars);
		$this->session->set_userdata("code2",$code);
	}
	public function sendEmail($data){
		$to = $data['email'];
		$subject = "Confirmation For Your Registeration";
		$url = site_url('home/index');
		$txt = "Dear ".$data['user_name']." :\r\n";
		$txt .= "Please Click the link below to confirm your register, ".$url." This would redirect you to the home page";
		$headers = "From: wxl163530@gmail.com\r\n";
		$headers .="Content-Type:text/plain; charset=utf8";
		$headers .="\r\nReaply-To:wxl163530@gmail.com";

		mail($to,$subject,$txt,$headers);
		/*$this->email->from('wxl163530@gmail.com', 'wenjieli');
		$this->email->to('wxl163530@utdallas.edu,wl8791522@gmail.com');
		/*$this->email->cc('another@another-example.com');
		$this->email->bcc('them@their-example.com');
		$url = site_url('home/index');
		$this->email->subject('Confirmation For Your Registeration');
		$this->email->message('Please Click the link below to confirm your register, {unwrap}"'.$url.'"{/unwrap} This would redirect you to the home page');

		$this->email->send();
		echo $this->email->print_debugger();*/
	}
	//!!!
	public function order()
	{
		$login=$this->session->userdata('user');
			$user_id = $login['user_id'];
			$data['userid'] = $login['user_id'];

			#check wether user has logged in(if not, session will return null for user id)
			if($user_id == "") {
				$this->load->view('order.html',$data);
			}
			else
			{

				$data['history'] = $this->user_model->view_order($user_id);
				$this->load->view('order.html',$data);
			}
	}
	public function delete_order($order_id){
		if($this->user_model->delete_order($order_id)){
			$data['message'] = "Delete Successfully";
			$data['wait'] = 3;
			$data['url'] = site_url('user/order');
			$this->load->view('message.html',$data);
		}else{
			$data['message'] = "Delete Unsuccessfully";
			$data['wait'] = 3;
			$data['url'] = site_url('user/order');
			$this->load->view('message.html',$data);
		}
	}
	public function view_cat()
	{
		$this->load->view('category.html');
	}
	public function search_name()
	{
		$this->load->view('search.html');
	}
}
