<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getpass extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
	}

	public function show_form()
	{	
		$this->page->template('euser_tpl');
		$this->page->view('v_getpass');
	}
	
	public function index(){
		
		if ($this->input->method(TRUE) == 'GET'){
			$fmdata = $this->input->get();
			if (array_key_exists('ehash', $fmdata)){
				$ehash = $fmdata['ehash'];
				$mode = "mail";
				if (array_key_exists('mode', $fmdata))
					$mode = $fmdata['mode'];
				$this->session->set_userdata('passRetMode', array('mode'=>$mode, 'ehash'=>$ehash, 'npp'=>$fmdata['npp'], 'apps'=>$fmdata['t']));
			} else {
				$this->session->unset_userdata('passRetMode');
			}
			return $this->show_form();
		}
		else {
			$fmdata = $this->input->post();
			log_message('debug', print_r(array("getpass.user_h.1"=>$fmdata), TRUE));
			$uniqid = uniqid("");
			if ($fmdata['reqtype'] == 'setPass' || $fmdata['reqtype'] == 'getPass'){
				//input target, token
				
				$myparam = array("reqtype"=>$fmdata['reqtype'], 'npp'=>$fmdata['npp'], 'mhash'=>$fmdata['token'], 'target'=>$fmdata['target'],"userclass"=>'xcasuser');
				
				if ($fmdata['reqtype'] == 'setPass')
					$myparam['pass'] = $fmdata['pass'];
				
				$sesdata = $this->session->userdata('passRetMode');
				log_message('debug', print_r(array("getpass.passRetMode"=>$sesdata), TRUE));
				$mode = "gsm";
				if ($sesdata != null){
					$mode = $sesdata['mode'];
					if ($sesdata['ehash'] != null)
						$myparam['ehash'] = $sesdata['ehash'];
				}
				$myparam['mode'] = $sesdata['mode'];
				
				log_message('debug', print_r(array("getpass.input.1"=>$myparam), TRUE));
				
				//$finalParam = array("reqtype"=>$fmdata['reqtype'], 'detail'=>json_encode($myparam));
				$this->load->library('restclient', array());
				//$dest_url = $this->config->item('cas_url') . 'frontend/target';
				$dest_url = $this->config->item('xcas_url') . 'cas/idm';
				//$dest_url = "http://172.18.2.80:8082/cas/idm";
				log_message('debug', print_r(array("getpass.input.2"=>$dest_url), TRUE));
				$breply = $this->restclient->get($dest_url, $myparam);
				
				log_message('debug', print_r(array("getpass.user_h"=>$breply), TRUE));
				
				
				if ($breply['status'] == 'ok'){
					if ($fmdata['reqtype'] == 'getPass'){
						if ($this->config->item('show_qr_pass')){
						$this->load->library('ciqrcode');
						$config['cacheable']	= false;
						$this->ciqrcode->initialize($config);
						$qr['data'] = sprintf("apps : %s\n Amankan sesuai SOP\n\n IDS Service\n\n Pass : %s\n",$fmdata['target'], $breply['pass']) ;
						ob_start();
						$this->ciqrcode->generate($qr);
						$xpng = ob_get_contents();
						ob_end_clean();
						$breply['qrpass'] = base64_encode($xpng);
						}
						if (!$this->config->item('show_bare_pass')){
							unset($breply['pass']);
						}
					} else {
						//redirect('mail');
						$breply['status'] = "set Password OK";
						//$this->htmlmail();
						//$myid = $this->cas->htmlmail();
						//$dt = $this->db->query("SELECT rp.userid as npp, rp.target as target, xe.Name as name FROM transitRepo rp JOIN xemployee xe ON rp.userid = xe.npp WHERE rp.userid = " . $fmdata['npp']);
						$dt = $this->db->query("SELECT rp.NPP as npp, rp.Name as name, rp.email as email FROM xemployee rp WHERE rp.NPP = " . $fmdata['npp']);
						log_message('debug', print_r(array("email.properties"=>$dt), TRUE));
						$npp = $dt->row()->npp;
						$mail_addr = $dt->row()->email;
						log_message('debug', print_r(array("email.properties.npp"=>$npp), TRUE));
						log_message('debug', print_r(array("email.properties.email"=>$mail_addr), TRUE));
						$target = $fmdata['target'];
						$name = $dt->row()->name;
						$type= $fmdata['reqtype'];
						log_message('debug', print_r(array("email.properties.type"=>$type), TRUE));
						$this->load->library('sendmail');
						$this->sendmail->htmlmail($type, $npp, $target, $name, $mail_addr);
						
						//send confirmation mail
					}
					
				} 
				echo json_encode($breply);
			}
		}
	}
} 