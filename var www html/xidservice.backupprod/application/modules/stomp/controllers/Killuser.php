<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Killuser extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->initparam();		
	}
	private function initparam(){
		$this->apps_list = array(
				"icons"=>array("target"=>"banc", "desc"=>"ICONS", "delivery"=>"online")
				/*"idminit"=>array("target"=>"idminit", "desc"=>"apps Identity Management", "delivery"=>"online"),
				"prsk"=>array("target"=>"periskop", "desc"=>"Periskop", "delivery"=>"manual"),
				"psn"=>array("target"=>"Email", "desc"=>"Email bni.co.id", "delivery"=>"pinmailer"),*/
			);
	}
	public function index()
	{	
		//$myid = $this->cas->getmycas_login(array('killbanc'));
		//$myid2 = $this->cas->getmycas_login(array('idminit'));
		//$getpass = json_decode(json_encode($myid, true));
		//$myid = $this->cas->getmycas_login(array('killbanc'));
		if (isset($_SESSION['pengguna'])){
			$this->page->template('site_tpl');
			$this->page->view('v_killuser');
		}else{ 
			redirect('log_out');
		}
		

	}
		//$this->page->template('enduser_tpl');
		//$this->page->view('v_resetpass');
	function npp(){
		$myid = $this->session->userdata('pengguna')->loginid;
		echo json_encode($myid);
	}
	public function handle(){
		$fmdata = $this->input->post();
		if ($fmdata == null){
			return $this->index();
		} else {
			$uniqid = uniqid("");
			if ($fmdata['reqtype'] == 'resetPass'){
				//input target, npp, mobileNumber
				$rdetail = array("username"=>$fmdata['npp'], 
					"target"=>$fmdata['target'], "password" => $fmdata['password'], "terminal" => $fmdata['terminal']);
				$sdata = array("reqtype"=>$fmdata['reqtype'], "detail"=>json_encode($rdetail));
				$this->load->library('restclient', array());
				$dest_url = $this->config->item('cas_url') . 'frontend/target';
				log_message('debug', print_r(array("cas.url"=>$dest_url), TRUE));
				log_message('debug', print_r(array("handle.sdata"=>$sdata), TRUE));

				
				$breply = $this->restclient->post($dest_url, $sdata);

				log_message('debug', print_r(array("handle.breply "=>$breply), TRUE));
				//$breply = array("res":"ok");
				//$breply = array("res"=>"err mobile number tidak ada", "data"=>$fmdata);
				echo json_encode($breply);
			} 
		}
	}
	
	public function euser_handle(){
		$fmdata = $this->input->post();
		if ($fmdata == null){
			return $this->index();
		} else {
			$uniqid = uniqid("");
			if ($fmdata['reqtype'] == 'showPassword'){
				//input target, token
				/*$this->ci->load->library('restclient', array());
				$dest_url = $this->ci->config->item('cas_url') . 'idmlink';
				log_message('debug', print_r($dest_url, TRUE)); 
				$breply = $this->ci->restclient->post($dest_url, $myparam);
				return $breply;*/
				$breply = array("res"=>"ok", "pass"=>"abcd");
				echo json_encode($breply);
			}
		}
	}
	public function valid_priv(){
		$fmdata = $this->input->post();
		$loginid = $this->session->userdata('pengguna')->loginid;
		$query = $this->db->query("select * from v_login_previlegde1
			where loginid =?", array($fmdata['npp']));
		$opts = array();
		$cpriv = $query->row();
		
		if ($cpriv != null){
			foreach($this->apps_list as $capps => $cval ){
				if (array_key_exists($capps, $cpriv) && $cpriv->$capps != null){
					$opts[$capps] = $cval;
				}
			}
		}
		
		$ret = array("opts"=>$opts,"npp"=>$loginid);
		echo json_encode($ret);
	}
	
} 