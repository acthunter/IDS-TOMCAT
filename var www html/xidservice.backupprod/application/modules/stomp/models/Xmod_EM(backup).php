<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_EM extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('xwf_model', 'wfmodel');
	}
	public function wfaction(){
		$fdt = $this->input->post();
		
		if (preg_match('/save/',$fdt['reqtype'])){
			$wfid = $fdt['npp'];
			$xcp = array('NPP'=>$fdt['npp'], 'email'=>$fdt['email'],'Name'=>$fdt['Name'], 'accOffice'=>$fdt['accOffice'], 'manager'=>$fdt['manager'],
				 'password'=>$fdt['password'], 
				 'nextAllowedAttempt'=>$fdt['naa'], 'failCount'=>$fdt['failcount'],'mobileNumber'=>$fdt['mn'],
				'DOB'=> date('Y-m-d',strtotime($fdt['DOB'])), 
				'enabled'=> intval(str_replace(" ", "", $fdt['enabled'])),
				'cpwd'=> intval(str_replace(" ", "", $fdt['cpwd'])),
				'active'=> intval(str_replace(" ", "", $fdt['active'])),
				'locked'=> intval(str_replace(" ", "", $fdt['locked'])),
				'passwordExpired'=> date('Y-m-d h:i',strtotime($fdt['passwordExpired'])), 
			); 
			$xcl = array('NPP'=>$fdt['nl'], 'positionid'=>$fdt['positionid'], 'fpositionid'=>$fdt['fpositionid'], 'active'=>intval(str_replace(" ", "", $fdt['al'])),
						 'enabled'=>intval(str_replace(" ", "", $fdt['el'])), 'basePositionid'=>$fdt['bpi'],
						 'expired'=> date('Y-m-d',strtotime($fdt['expxl'])),				 
			);
				$ustr = $this->db->update_string('xemployee', $xcp, 'NPP=' .  $wfid );
				$ustr2 = $this->db->update_string('xlogin', $xcl, 'NPP=' .  $wfid );
				$ret = $this->db->query($ustr);
				$this->db->query($ustr2);
				return $ret;
		}
	}
}