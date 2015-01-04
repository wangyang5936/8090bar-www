<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends M_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->view('index');
	}

	public function error_404()
	{
		$this->load->view('error_404');
	}
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */
