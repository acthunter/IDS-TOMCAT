<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Target_model extends CI_Model {

	
	public function __construct()
	{
		parent::__construct();
		//$param = array('queue'=> '/queue/cas.banc', 'rqueue'=>'/queue/cas.repbanc', 'url'=>'tcp://172.18.2.80:61627','timeout'=>10000);
		//$param = array('queue'=> '/queue/cas.banc', 'rqueue'=>'/queue/cas.repbanc', 'url'=>'tcp://172.18.4.207:61627','timeout'=>10000);
		$this->load->library('bend', $param); 
		
		//$this->load->database();
	}
	
	
	
	function get_my_login($id)
	{
		$login = $this->get_cas_login($id); 
		$pengguna = (object)array();
		$pengguna->username = $id;
		$pengguna->nama=$login->nama;
		$pengguna->idm=$login->idm;
		
		return $pengguna;
	}
	
	private function get_cas_login($id){
		$ret = null;
		
		$this->db->from('v_login_previlegde1');
		$this->db->where('loginid', $id);
		$query = $this->db->get();
		$vlp = $query->row();
		
		
		if ($vlp != null){
			if ($ret == null) $ret = (object)array();
			$ret->idm = $vlp->idminit;
			$ret->cposname = $vlp->name;
			$ret->cposid = $vlp->positionid;
			
			$ret->tposname = $vlp->name;
			$ret->cposid = $vlp->positionid;
		}
		
		$this->db->from('v_login_name');
		$this->db->where('loginid', $id);
		$vln = $this->db->get()->row();
		if ($vln != null){
			if ($ret == null) $ret = (object)array();
			$ret->nama = $vln->name;
		}
		
		return $ret;
	}
	
	function get_banc_login($id)
	{
		//$breply = array('status'=> 'EXIST', 'NPP'=>$id, 'Capability'=>'4',
		//'TellerName'=>'Any Name', 'Branch'=>'718', 'UserSection'=>'AABBB','GroupTrx'=>'9');
		$breply = $this->bend->getLoginDetail($id);
		
		log_message('debug', print_r(array("xbanc_model.gbl.breply"=>$breply), TRUE));
		$filterStr = 'status,DefInteger4-npp,DefaultString1-name,BranchNo-branchcode,DefaultString2-loginStatus';
		
		$retreply = $this->filterBanc($breply, $filterStr);
		
		
		$detdb = $this->get_cas_login($id);
		if ($detdb != null){
			//$retreply['TellerName'] =  $detdb->nama;
			$retreply['cposname'] = $detdb->cposname;
			$retreply['cposid'] = $detdb->cposid;
		}
		return $retreply;
	}
	
	private function filterBanc($oarr, $filterStr){
		$tfilter = explode(",",$filterStr);
		$filter = array();
		
		foreach($tfilter as $cc){
			$tarr = explode("-", $cc);
			$dest = $cc;
			if (count($tarr) > 1){
				$cc = $tarr[0];
				$dest = $tarr[1];
			}
			$filter[$cc] = $dest;
		}
		
		//log_message('debug', print_r($filter, TRUE)); 
		$retreply = array();
		foreach($filter as $korg => $xlat ){
			if (array_key_exists($korg, $oarr)){
				$retreply[$xlat] = $oarr[$korg];
			}
		}
		
		return $retreply;
	}
	
	function get_tellparam($loginid, $effDate)
	{
		
		
		$breply = $this->bend->getLoginParam($loginid, $effDate);
		log_message('debug', print_r($breply, TRUE)); 
		
		//Banc-cas
		$filterStr = 'status,NPP-npp,TellerName-name,Branch-branchcode,Capability-lvlcap,UserSection,GroupTrx-grouptransc,EffDate-effDate';
		
		
		$retreply = $this->filterBanc($breply, $filterStr);
		
		$detdb = $this->get_cas_login($loginid);
		if ($detdb != null){
			//$retreply['TellerName'] =  $detdb->nama;
			$retreply['cposname'] = $detdb->cposname;
			$retreply['cposid'] = $detdb->cposid;
		}
		log_message('debug', print_r($retreply, TRUE)); 
		return $retreply;
	}
	function inquiry_dmy($id)
	{
		$breply = array('status'=> 'EXIST', 
						'TellerName'=>'Ryanda Pratama Herdwian Putra', 
						'brch_no'=>'718', 
						'npp'=>'54086', 
						'grp_no'=>'TEK', 
						'capable'=>'14',
						'transc_date'=>'07/13/2017',
						'transc_dur'=>' ',
						'access_secur_code'=>'00');
		return $breply;
	}
	
	function ubah_level($id)
	{
		$breply = array('status'=> 'EXIST', 
						'TellerName'=>'Ryanda Pratama Herdwian Putra', 
						'brch_no'=>'718', 
						'npp'=>'54086', 
						'grp_no'=>'TEK', 
						'capable'=>'16',
						'transc_date'=>'07/15/2017',
						'transc_dur'=>'2 jam',
						'access_secur_code'=>'00');
		return $breply;
	}
	
	function get_tcpos($id){
		$this->db->db_select('jbpm');
		$this->db->from('v_tpos');
		$this->db->where('npp', $id);
		$query = $this->db->get();
		$vlp = $query->result();
		
		$retreply = array();
		foreach($vlp as $crow ){
			$retreply[] = array('name'=>$crow->xpname . "(" . $crow->licons . ")", 
				'values'=>array(array('from'=>$crow->sdate,
						'to'=>$crow->edate,
						'label'=>$crow->npp,
						'dataObj'=>$crow->icons)));
		}
		return $retreply;
	}
} 