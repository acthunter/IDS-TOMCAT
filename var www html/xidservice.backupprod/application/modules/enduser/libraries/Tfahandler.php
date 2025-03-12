<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tfahandler {
		protected $url  = '';
		protected $timeout = 30;
		
		private $ci;
		
        public function __construct($param)
        {
			if (array_key_exists("url", $param)){
				$url = $param["url"];
			}
			$this->ci = &get_instance();
        }
		
		private function isValidToken($authToken, $penalty){
			$ret = false;
			log_message('debug', print_r(array("tfh.ivt.authToken.0"=>time()), TRUE));
			if ($authToken != null){
				log_message('debug', print_r(array("tfh.ivt.authToken"=>$authToken), TRUE));
				
				if ($authToken->life > 0 && time() < $authToken->expire){
					$ret = true;
					$authToken->life -= $penalty ;
/* 					$this->ci->session->set_userdata("authToken", $authToken);
					$test = "test"; */
/* 					log_message('debug', print_r(array("tfh.ivt.test"=>$test), TRUE));
					log_message('debug', print_r(array("tfh.ivt.authToken.1"=>$authToken), TRUE)); */
					$this->ci->session->set_userdata("authToken", $authToken); // tambahan
				}
			}
			return $ret;
			log_message('debug', print_r(array("tfh.ivt.ret"=>$ret), TRUE));
		}
		
		public function isLevelValidCheck(){
			$authToken = $this->ci->session->userdata('authToken');
			return $this->isValidToken($authToken, 0);
		}
		
		public function isLevelValid($isForce){
			log_message('debug', print_r(array("tfah.islv.isforce "=>$isForce), TRUE));
			$authToken = $this->ci->session->userdata('authToken');
			$user = $this->ci->session->userdata('pengguna');
			
			$mres = (object) array();
			
			$isValid = $this->isValidToken($authToken, 1);
			
			$res = false;
			/* if (!$isValid){ */
			if (!$isValid && $isForce){ //tambahan
				//$hash = "abcde";
				log_message('debug', print_r(array("tfah.islv.1 "=>$user), TRUE));
				$this->ci->load->library('restclient', array());
				$dest_url = $this->ci->config->item('xcas_url') . 'cas/idm';
				//$dest_url = "http://172.18.2.80:8083/cas/idm";
				
				//log_message('debug', print_r(array("tfah.islv.2"=>$dest_url), TRUE));
				//$sdata = array("npp"=>$user->loginid, "mode"=>"email", "reqtype"=>"createTFAToken");
				$sdata = array("npp"=>$user->loginid, "mode"=>null, "reqtype"=>"createTFAToken"); 
				
				//log_message('debug', print_r(array("sdata "=>$sdata), TRUE));
				
				$breply = $this->ci->restclient->get($dest_url, $sdata);
				log_message('debug', print_r(array("breply "=>$breply), TRUE));
				
				if ($breply != null && array_key_exists("hash", $breply)){
					$hash = $breply["hash"];
					$authTokenC = (object) array();
					$authTokenC->life = 3;
					$authTokenC->hash = $hash;
					$authTokenC->expire = time() + (5*60);
					$this->ci->session->set_userdata("authTokenC", $authTokenC);
					$mres->msg = "pls-input-challenge";
				}
				$mres->msg = "ok-next-setpassword";
			}
			
			if ($isValid)
				$res = true;
			
			$mres->valid = $res;
			//log_message('debug', print_r(array("tfah.res"=>$res), TRUE));
			return $mres;  
		}
		
		public function bypassChallenge(){
			$authToken = $this->ci->session->userdata('authToken');
			$res = false;
			if ($authToken != null && $authToken->life > time())
				$res = true;
			return $res;
		}
		
		public function storeSessionData($sdata){
			$authToken = $this->ci->session->userdata('authToken');
			$authToken->udata = $sdata;
			$this->ci->session->set_userdata('authToken', $authToken);
		}
		
		public function getSessionData(){
			$authToken = $this->ci->session->userdata('authToken');
			$sdata = ($authToken == null)? array() : $authToken->udata;
			return $sdata;
		}
		
		public function validateChallenge($response){
			$authTokenC = $this->ci->session->userdata('authTokenC');
			//log_message('debug', print_r(array("tfh.valC.resp"=>$response), TRUE));
			//log_message('debug', print_r(array("tfh.valC.authc"=>$authTokenC), TRUE));
			
			$res = false;
			if ($authTokenC != null){
				if ($authTokenC->hash == $response && $authTokenC->life > 0 && $authTokenC->expire > time()) {
					$this->ci->session->unset_userdata("authTokenC");
					$authToken = (object) array();
					$authToken->life = 3;
					$authToken->expire = time() + (10*60);
					$this->ci->session->set_userdata("authToken", $authToken);
					$res = true;
				}
			}
			return $res;
		}
		
}