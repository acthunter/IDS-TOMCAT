<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class XMain extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->initparam();		
	}
	private function initparam(){
		$this->apps_list = array(
				"icons"=>array("target"=>"banc", "desc"=>"apps core banking", "delivery"=>"online"),
				"idminit"=>array("target"=>"ldapAccount_oid", "desc"=>"OID (WEBMAIL)", "delivery"=>"online"),
				"prsk"=>array("target"=>"periskop", "desc"=>"Periskop", "delivery"=>"manual"),
				"psn"=>array("target"=>"Email", "desc"=>"Email bni.co.id", "delivery"=>"pinmailer"),
			);
		$this->apps_list_default = array(
				"otp"=>array("target"=>"otp", "desc"=>"CAS OTP Token", "delivery"=>"manual"),
		); //ini yang beda
	}
	public function index()
	{	
		$myid = $this->cas->getmycas_login(array('idm_ithde','idm_appr','idm_init','idm_super','idm_idadmin'));
		$this->page->template('enduser_tpl');
		$this->page->view('v_resetpass');
	}
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
			/* if ($fmdata['reqtype'] == 'setPass' ){ */
			if ($fmdata['reqtype'] == 'setPass' || $fmdata['reqtype'] == 'getQrSeed'){ // ini yang beda
				$isQrSeed = ($fmdata['reqtype'] == 'getQrSeed'); // ini yang beda
				$this->load->library("tfahandler", array());
				$stparam = $this->session->userdata('stparam');
				$udata = $this->tfahandler->getSessionData();
				log_message('debug', print_r(array("xmain.handle.udata"=>$udata), TRUE));
				if (!$this->tfahandler->bypassChallenge()){
					$vcres = $this->tfahandler->validateChallenge($fmdata['cresponse']);
					if ($vcres){
						$udata = array("mobileNumber" =>$stparam['mobileNumber'] );
						$this->tfahandler->storeSessionData($udata);
					}
				} 
				$tokenRes = $this->tfahandler->isLevelValid(false); // ini yang beda
				/* if ($this->tfahandler->isLevelValid()){ */
				if ($tokenRes->valid){ // ini
					if ($isQrSeed){
						$breply=array("resp"=>"scanQrSeed");
				} else { //sampai sini	
				
					log_message('debug', print_r(array("xmain.handle.stdata_1"=>$stparam), TRUE));
					
					$rdetail = array("npp"=>$stparam['npp'], "target"=>$stparam['target'], "mobileNumber"=>$udata['mobileNumber'], "pass"=>$fmdata['pass'],"userclass"=>'casuser');
					log_message('debug', print_r(array("rdetail "=>$rdetail), TRUE));
					$sdata = array("reqtype"=>$fmdata['reqtype'], "detail"=>json_encode($rdetail));
					$this->load->library('restclient', array());
					$dest_url = $this->config->item('cas_url') . 'frontend/target';
					$breply = $this->restclient->post($dest_url, $sdata);
					log_message('debug', print_r(array("breply "=>$breply), TRUE));
					}
				} else {
					$breply=array("resp"=>"invalid auth");
				}
				
			} if ($fmdata['reqtype'] == 'verifyForPassword' ) {
				$this->load->library("tfahandler", array());
				$rdetail = array('npp'=>$fmdata['npp'],  'target'=>$fmdata['target'], 'mobileNumber'=>$fmdata['mobileNumber']);
				if ($this->tfahandler->isLevelValidCheck()){
					$udata = $this->tfahandler->getSessionData();
					$rdetail["mobileNumber"]=$udata["mobileNumber"];
				}
				
				
				$myparam = array("reqtype"=>$fmdata['reqtype'], 
					"detail"=> json_encode($rdetail));
				log_message('debug', print_r(array("getpass.myparam.1"=>$myparam), TRUE));			

				$this->session->unset_userdata('stparam');
				
				$this->load->library('restclient', array());
				$dest_url = $this->config->item('cas_url') . 'frontend/target';
				log_message('debug', print_r(array("getpass.input.2"=>$dest_url), TRUE));
				$breply = $this->restclient->post($dest_url, $myparam);
				if ($breply != null && array_key_exists("resp", $breply)){
					$this->session->set_userdata('stparam', $rdetail);
					log_message('debug', print_r(array("xmain.handle.save"=>$_SESSION['stparam']), TRUE));
					
					//set token
					$this->load->library("tfahandler", array());
					$mres = $this->tfahandler->isLevelValid(TRUE);
					log_message('debug', print_r(array("xmain.verify.1"=>$mres), TRUE));
					
					if (!$mres->valid){
						$breply["msg"]=$mres->msg;
					} else { // ini tambahan
							if ($fmdata['target'] == "otp"){
							$breply['form'] = 'getQrOTP';
					} 
					} // sampai sini 
				}
				log_message('debug', print_r(array("getpass.user_h"=>$breply), TRUE));
				
				
			} 
			  
			echo json_encode($breply);
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
				$breply = $this->ci->restclient->post($dest_url, $rdetail);
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
			where loginid =?", array($loginid));
		$opts = array();
		$cpriv = $query->row();
		
		if ($cpriv != null){
			foreach($this->apps_list as $capps => $cval ){
				if (array_key_exists($capps, $cpriv) && $cpriv->$capps != null){
					$opts[$capps] = $cval;
				}
			}
			foreach($this->apps_list_default as $capps => $cval ){ //ini tambahan
				$opts[$capps] = $cval;
			} //sampai sini
		}
		$this->load->library("tfahandler", array());

		$ret = array("opts"=>$opts,"npp"=>$loginid, "authorize"=>$this->tfahandler->isLevelValidCheck());
		echo json_encode($ret);
	}
	
} 