<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xctest extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
		$this->load->model('xwf_model', 'wfmodel');
	}

	public function index()
	{	
		//$myid = $this->cas->allow_logindynmodal();
		$this->page->view('v_ctest');
	}
	
	public function testparam($procid){
		$this->load->model('xwf_param', 'wfparam');
		$cparam = $this->wfparam->wfparam($procid);
		log_message('debug', print_r(array("cparam"=>$cparam), TRUE));
		
		$ret = json_decode($cparam, false);
		log_message('debug', print_r(array("testparam"=>$ret), TRUE));
		
		echo json_encode($ret->s1);
	}
	
	public function testparam1($procid, $accoffice){
		$this->load->model('xwf_param', 'wfparam');
		$ret = $this->wfparam->wfinit($procid, $accoffice);
		echo json_encode($ret);
	}
	

	public function movetostage($wfid, $stage){
		echo json_encode($this->wfmodel->initstage($wfid, $stage, null));
	}
	
	
	public function logout(){
		$this->cas->logout();
		redirect('login');
	}
	

	public function loginlist(){
		
		$accoffice = '746';
		$accoffice2 = '259';
		$accoffice3 = '718';
		$accoffice4 = '24';
		$accoffice5 = '5';
		$accoffice6 = '8';
		$res = $this->db->query("select vln.name, vi.* from v_idmauth vi inner join v_login_name vln on vln.loginid = vi.loginid where vi.accoffice = ? OR vi.accoffice = ? OR vi.accoffice = ? OR vi.accoffice = ? OR vi.accoffice = ? OR vi.accoffice = ?", array($accoffice, $accoffice2, $accoffice3, $accoffice4, $accoffice5, $accoffice6))->result();
		echo json_encode(array("recordsTotal" => 1,
            "recordsFiltered" => 1,"data"=>$res));
	}	

	public function login(){
		$fdt = $this->input->post();
		
		if (!isset($fdt['loginid'])){
			if (isset($_SESSION['pengguna'])){
				redirect('invalid');
			}

		else{
			$this->page->template('simple_tpl');
			$this->page->view('templates/cloginform');
		
		}} else {
			$loginid = $fdt['loginid'];
			$this->cas->login();
		}
	}
	
	public function wf_mark(){ //mtype, ids
		$fdt = $this->input->post();
		$stage = '1';
		if (preg_match('/finish/',$fdt['mtype']))
			$stage = '3';
		foreach ($fdt['ids'] as $wfid){
			$this->wfmodel->initstage($wfid, $stage, null);
		}
		echo json_encode($fdt['ids']);
	}
	
} 
