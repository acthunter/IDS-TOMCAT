<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendmail extends CI_Controller {

	public function htmlmail()
	{
		$config = Array(    
			'protocol' => 'sendmail',
			'smtp_host' => 'cas.bni.co.id',
			'smtp_port' => 465,
			'smtp_user' => '',
			'smtp_pass' => '',
			'smtp_timeout' => '4',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1'
		);
		
		$this->load->library('email', $config);
		
		$this->email->set_newline("\r\n");
		$this->email->from('mail@gmail.com', 'Mail');

		$data = array(
			'userName'=> 'Susilo',
			'npp' => '26024',
			'target' => 'periskop'
		);
		
		$this->email->to('scr@bni.co.id');
		$this->email->subject('Email Test');

		$body = $this->load->view('v_mnotif3', $data);

		$this->email->message($body); 
		$this->email->send();
  }
}