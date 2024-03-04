<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notfound extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->output->set_header("X-Frame-Options: sameorigin");
		$this->output->set_header("X-XSS-Protection: 1; mode=block");
		$this->output->set_header("X-Content-Type-Options: nosniff");
		$this->output->set_header("Strict-Transport-Security: max-age=31536000");
	}

	public function index()
	{
		if (!$this->session->userdata('user_id'))
			redirect(base_url() . 'login');

		$page_data['page_title']	=	'404';
		$page_data['page_name'] 	= 	'404';
		$this->load->view('index', $page_data);
	}
}
