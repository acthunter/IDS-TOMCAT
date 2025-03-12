<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banclib {
		
		private $ci;
		
        public function __construct($param)
        {

			$this->ci = &get_instance();
        }
		
		
		public function getLoginDetail($loginid){
			
			$uniqid = uniqid("");
			$myparam = array('loginid' => $loginid,
							'reqtype' => "tellinq",
							);
			
			$this->ci->load->library('restclient', array());
			$dest_url = $this->ci->config->item('cas_url') . 'chgpos/telDetail';
			log_message('debug', print_r($dest_url, TRUE)); 
			$breply = $this->ci->restclient->post($dest_url, $myparam);
			return $breply;
		}
		
		
		public function getLoginParam($loginid, $effDate){
			
			$uniqid = uniqid("");
			$myparam = array('loginid' => $loginid,
							'reqtype' => "tellerparam",
							'effdate'=>$effDate);
			
			
			$this->ci->slog->write_log('DEBUG',print_r(array("glp.1-a"=>"aa"), TRUE)); 
			$this->ci->load->library('restclient', array());
			$dest_url = $this->ci->config->item('cas_url') . 'chgpos/telStatus';
			$this->ci->slog->write_log('DEBUG', array("glp.1"=>print_r($dest_url, TRUE))); 
			$breply = $this->ci->restclient->post($dest_url, $myparam);
			$this->ci->slog->write_log('DEBUG', array("glp.1"=>print_r($myparam, TRUE))); 
			return $breply;
		}
}