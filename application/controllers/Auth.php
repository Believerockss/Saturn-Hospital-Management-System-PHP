<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
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

	function signin()
	{
		$email				=	$this->input->post('email', TRUE);
		$password			=	$this->input->post('password', TRUE);

		// MATCHES WITH THE USER TABLE
		if ($this->security->xss_clean($this->db->get_where('user', array('email' => $email, 'status' => 1))->num_rows()) > 0) {
			$db_password	=	$this->security->xss_clean($this->db->get_where('user', array('email' => $email))->row()->password);

			if (password_verify($password, $db_password)) {
				$permissions = $this->security->xss_clean($this->db->get_where('staff_category', array('staff_category_id' => $this->security->xss_clean($this->db->get_where('user', array('email' => $email, 'status' => 1))->row()->staff_category_id)))->row()->permissions);
				$this->session->set_userdata('user_id', $this->security->xss_clean($this->db->get_where('user', array('email' => $email, 'status' => 1))->row()->user_id));
				$this->session->set_userdata('user_type', "staff");
				$this->session->set_userdata('permissions', explode(",", $permissions));

				redirect(base_url(), 'refresh');
			} else {
				$this->session->set_flashdata('warning', 'Incorrect password, Try again.');

				redirect(base_url() . 'login', 'refresh');
			}
		} elseif ($this->security->xss_clean($this->db->get_where('patient', array('email' => $email))->num_rows()) > 0) { 
			$db_password	=	$this->security->xss_clean($this->db->get_where('patient', array('email' => $email))->row()->password);

			if (password_verify($password, $db_password)) {
				$this->session->set_userdata('user_id', $this->security->xss_clean($this->db->get_where('patient', array('email' => $email))->row()->patient_id));
				$this->session->set_userdata('user_type', "patient");
				$this->session->set_userdata('permissions', explode(",", "2,3,4,5,6,7,8,10,12,14,15,39,42,43,51,52,54,55"));

				redirect(base_url('occupancies'), 'refresh');
			} else {
				$this->session->set_flashdata('warning', 'Incorrect password, Try again.');

				redirect(base_url() . 'login', 'refresh');
			}
		} else {
			$this->session->set_flashdata('warning', 'Incorrect email, Try again.');

			redirect(base_url() . 'login', 'refresh');
		}
	}

	function logout()
	{
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_type');
		$this->session->unset_userdata('permissions');

		$this->session->set_flashdata('success', 'You have successfully logged out, Thank you.');

		redirect(base_url()  . 'login', 'refresh');
	}
}
