<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xgpass extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
		$this->load->library('session');		
	}
	
	public function index()
	{	
		$this->page->template('euser_tpl');
		$this->page->view('v_pass');
	}
		public function showpass()
	{	
		/* $this->page->template('euser_tpl');
		$this->page->view('v_password'); */
		$response = $this->load->view('v_password',true);
		echo($response);
	}

	public function otp()
	{	
		/* $this->page->template('euser_tpl');
		$this->page->view('v_otp'); */
		$response = $this->load->view('v_otp',true);
		echo($response);
	}
	public function getpass(){
		$fmdata = $this->input->post();
		if ($fmdata['type'] == 'validateUser'){
			$rdetail = array("reqtype"=>"validateReq","loginid"=>$fmdata['loginid'], "reqid"=>$fmdata['reqid'], "fp"=>$fmdata['fp']);
			$sdata = array("reqtype"=>'validateReq', "detail"=>json_encode($rdetail));
			$this->load->library('restclient', array());
			$dest_url = $this->config->item('cas_url') . 'frontend/target';
			$breply = $this->restclient->post($dest_url, $sdata);
			echo json_encode($breply);
		} else {
			$rdetail = array("reqtype"=>"submitToken", "loginid"=>$fmdata['loginid'], "fp"=>$fmdata['fp'], "otp"=>$fmdata['otp'], "reqid"=>$fmdata['reqid']);
			$sdata = array("reqtype"=>'submitToken', "detail"=>json_encode($rdetail));
			$this->load->library('restclient', array());
			$dest_url = $this->config->item('cas_url') . 'frontend/target';
			$breply = $this->restclient->post($dest_url, $sdata);
			echo json_encode($breply);
		}
		
	}
	
	public function save(){
		$fmdata = $this->input->post();
		$xcp = array('qid' => 1);
		$ustr = $this->db->update_string('transitRepo', $xcp, 'loginid="'.$fmdata['loginid'].'" AND reqid="'.$fmdata['reqid'].'"');
		$ret = $this->db->query($ustr);
		echo json_encode($ret);
	}
}