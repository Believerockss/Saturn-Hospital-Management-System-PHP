<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Modal extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->output->set_header("X-Frame-Options: sameorigin");
        $this->output->set_header("X-XSS-Protection: 1; mode=block");
        $this->output->set_header("X-Content-Type-Options: nosniff");
        $this->output->set_header("Strict-Transport-Security: max-age=31536000");

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT+6');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Wed, 28 Feb 1990 04:20:00 GMT+6');
    }

    public function index()
    {
    }

    function popup($page_name = '', $param2 = '', $param3 = '')
    {
        $page_data['param2']        =    $param2;
        $page_data['param3']        =    $param3;

        $this->load->view($page_name . '.php', $page_data);
    }
}
