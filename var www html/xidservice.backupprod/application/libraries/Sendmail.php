<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Sendmail {
	protected $CI;

        // We'll use a constructor, as you can't directly call a function
        // from a property definition.
        public function __construct(){
		 $this->ci =& get_instance();
	}
	
	function htmlmail($type, $npp, $target, $name, $mail_addr)
	{
		$config = Array(    
			'protocol' => 'sendmail',
			'smtp_host' => 'cas.bni.co.id',
			'smtp_port' => 25,
			'smtp_user' => '',
			'smtp_pass' => '',
			'smtp_timeout' => '4',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1'
		);
		
		$this->ci->load->library('email', $config);
		
		$this->ci->email->set_newline("\r\n");
		$this->ci->email->from('CASSystemAdministrator@bni.co.id', 'Konfirmasi Perubahan Password');
		$data = array(
				'userName'=> $name,
				'npp' => $npp,
				'target' => $target,
			);
		if($type == 'setPass'){
			$view = 'guser/v_mnotif5';
			$subject = 'IDS - Notifikasi Perubahan Password';
		}else{	
			$view = 'guser/v_mconf4';
			$subject = 'IDS - Konfirmasi Perubahan Password';
		}
		
		$this->ci->email->to($mail_addr);
		$this->ci->email->subject($subject);

		$body = $this->ci->load->view($view, $data, TRUE);

		$this->ci->email->message($body); 
		$this->ci->email->send();
	
	}
	
	
	
	function submit_rqst($target, $name, $reqid, $name_usr, $npp_usr, $cpos, $tpos, $unit,
							$sdate, $edate, $initiator, $name_init, $name_office, $code_office)
	{
		$config = Array(    
			'protocol' => 'sendmail',
			'smtp_host' => 'cas.bni.co.id',
			'smtp_port' => 25,
			'smtp_user' => '',
			'smtp_pass' => '',
			'smtp_timeout' => '4',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1'
		);
		
		$this->ci->load->library('email', $config);
		
		$this->ci->email->set_newline("\r\n");
		$this->ci->email->from('identityservice@bni.co.id', 'IDentity Service (IDS)');
		$data = array(
				'target' => $target,
				'userName'=> $name,
				'reqid'=> $reqid,
				'name_usr'=> $name_usr,
				'npp_usr'=> $npp_usr,
				'cpos_mail'=> $cpos,
				'tpos_mail'=> $tpos,
				'unit_mail'=> $unit,
				'sdate_mail'=> $sdate,
				'edate_mail'=> $edate,
				'initiator'=> $initiator,
				'name_init'=> $name_init,
				'name_office'=> $name_office,
				'code_office'=> $code_office,
			);
		$view = 'guser/submit';
		$subject = 'IDS - Permohonan Approvval';	
		$this->ci->email->to('ReportCAS@bni.co.id');
		$this->ci->email->subject($subject);

		$body = $this->ci->load->view($view, $data, TRUE);

		$this->ci->email->message($body); 
		$this->ci->email->send();
	}
	
function submit_apprv($target, $name, $reqid, $name_usr, $npp_usr, $cpos, $tpos, $unit,
							$sdate, $edate, $initiator, $name_init, $name_office, $code_office, $name_appr, $npp_appr)
	{
		$config = Array(    
			'protocol' => 'sendmail',
			'smtp_host' => 'cas.bni.co.id',
			'smtp_port' => 25,
			'smtp_user' => '',
			'smtp_pass' => '',
			'smtp_timeout' => '4',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1'
		);
		
		$this->ci->load->library('email', $config);
		
		$this->ci->email->set_newline("\r\n");
		$this->ci->email->from('identityservice@bni.co.id', 'IDentity Service (IDS)');
		$data = array(
				'target' => $target,
				'userName'=> $name,
				'reqid'=> $reqid,
				'name_usr'=> $name_usr,
				'npp_usr'=> $npp_usr,
				'cpos_mail'=> $cpos,
				'tpos_mail'=> $tpos,
				'unit_mail'=> $unit,
				'sdate_mail'=> $sdate,
				'edate_mail'=> $edate,
				'initiator'=> $initiator,
				'name_init'=> $name_init,
				'name_office'=> $name_office,
				'code_office'=> $code_office,
				'name_appr'=> $name_appr,
				'npp_appr'=> $npp_appr,
			);
		$view = 'guser/approve';
		$subject = 'IDS - Notifikasi Persetujuan';	
		$this->ci->email->to('ReportCAS@bni.co.id');
		$this->ci->email->subject($subject);

		$body = $this->ci->load->view($view, $data, TRUE);

		$this->ci->email->message($body); 
		$this->ci->email->send();
	}
	
}