<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xbatch_edit extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
			
	}
	public function index()
	{	
		
		$this->page->template('site_tpl');
			$this->page->view('v_empy2');
	}
	
} 