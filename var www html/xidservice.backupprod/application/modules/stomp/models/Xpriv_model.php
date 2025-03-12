<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xpriv_model extends CI_Model {
	public $requestor='';
	public $npp='';
	public $loginid='';
	public $cpos=0;
	public $tpos=0;
	public $clevel=0;
	public $tlevel=0;
	public $sdate;
	public $edate;
	
	public function __construct()
	{
		parent::__construct();
		//$this->load->database();
	}
	
	public function calculate_edate($duration){
		//$edate = ??
	}
	
	public function save(){
		
		
		$this->db->insert('xxpriv', $this);
		return $this->db->insert_id();
	}
} 