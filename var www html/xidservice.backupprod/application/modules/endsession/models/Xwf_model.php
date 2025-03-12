<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xwf_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function getposearch($pattern, $unit){
		//$cek = $this->db->query("select xp.accOffice2 as acc from xlogin xl join xposition xp on xl.positionid = xp.positionid where xl.loginid = ".$loginid)->row();
		$data = $this->db->query("select * from xposition where accOffice = ".$unit." AND name like '%" . $pattern . "%'");
		
		$crow = $data->result();
		return $crow;
	}

	public function getposunit($pattern){	
		$val_accoffice = $accoffice < 800  ; 
		$val_accoffice2 = $accoffice < 900  ; 

		/* if (($val_accoffice == TRUE)){
				$data = $this->db->query("select *  from xentitas where accOffice < 800 and name like '%" . $pattern . "%'");			
		}else{
			if($val_accoffice2 == TRUE){
				$data = $this->db->query("select *  from xentitas where accOffice > 800 and accOffice < 900  and name like '%" . $pattern . "%'");
			}else{
				$data = $this->db->query("select *  from xentitas where accOffice not in (select accOffice  from xentitas where accOffice > 800 and accOffice < 900) and name like '%" . $pattern . "%'");
			}
		} */
		$data = $this->db->query("select *  from xentitas where (accOffice < 900 or  accOffice > 1000) and name like '%" . $pattern . "%'");	
		$crow = $data->result();
		return $crow;
	}
	
	public function update_pos($posisi,$loginid){
		
		$query = $this->db->query('UPDATE `jbpm`.`xlogin` SET `positionid`=? WHERE `loginid`=?', array($posisi,$loginid));
		
		$ret = ($this->db->affected_rows() > 0);
		return $ret;
	}
	public function update_mail($mail,$loginid){
		
		$query = $this->db->query('UPDATE `jbpm`.`xemployee` SET `email`=? WHERE `NPP`=?', array($mail,$loginid));
		
		$ret = ($this->db->affected_rows() > 0);
		return $ret;
	}
	public function update_apps($unit,$loginid){
		$query = $this->db->query('UPDATE `jbpm`.`appsuser` SET `refid`=? WHERE `NPP`=?', array($unit,$loginid));
		
		$ret = ($this->db->affected_rows() > 0);
		return $ret;
	}
	
	
} 