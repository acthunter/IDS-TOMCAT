<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Casclient {
		protected $queue  = '/queue/cas.banc';
		
		private $ci;
		  public function __construct($param)
        {
			$this->ci = &get_instance();
        }
		
		public function initClientSession(){
			$this->ci->load->library('cas');
			$this->cas->force_auth();
			
			$cuserlogin = $this->cas->user()->userlogin;
			$userAttr = $this->cas->user()->attributes;
			$pengguna = $this->session->userdata('pengguna');
			
			if (!isset($pengguna)){
				$pengguna = (object)array();
				$pengguna->nama=$userAttr['username'];
				$pengguna->loginid=$this->cas->user()->userlogin;
				$pengguna->id_pengguna_grup="1";
				$pengguna->id="12";
				$pengguna->foto="";
				$idmrole = $userAttr['idm'];
				if (isset($idmrole)){
					$pengguna->idm_init = $idmrole % 10;
					$pengguna->idm_appr =  ($idmrole / 10) % 10;
					$pengguna->idm_super =  ($idmrole / 100) % 10;
				}
				
				$this->session->set_userdata('pengguna', $pengguna);
			}
			
		}
}