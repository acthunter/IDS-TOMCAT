<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xwf_param extends CI_Model {

	private $wfparam = null;
	
	public function __construct()
	{
		parent::__construct();
		$this->initparam();
	}
	
	private function initparam(){
		$this->wfparam = (object) array(
			"RP"=>'{"1": {"name":"review", "target":1}, "2":{"name":"approval", "target":2}, "finish": { "xreview": {"procStat": "", "status" : "I", "tflag" : "3"}, "wf":{"stage" : 2}}}',
			"CP"=>'{"1": {"name":"review", "target":1}, "2":{"name":"approval", "target":2},  "finish": { "xreview": {"procStat": "P", "status" : "I", "tflag" : "3"}, "wf":{"stage" : 2}}}',
			"CT"=>'{"1": {"name":"review", "target":1}, "2":{"name":"approval", "target":2},  "finish": { "xreview": {"procStat": "P", "status" : "I", "tflag" : "3"}, "wf":{"stage" : 2}}}',
			"CU"=>'{"1": {"name":"review", "target":1}, "2":{"name":"approval", "target":2},  "finish": { "xreview": {"procStat": "P", "status" : "I", "tflag" : "3"}, "wf":{"stage" : 2}}}',
			"UA"=>'{"1": {"name":"review", "target":1}, "2":{"name":"approval", "target":2},  "finish": { "xreview": {"procStat": "P", "status" : "J", "tflag" : "3"}, "wf":{"stage" : 2}}}',
			"CM"=>'{"1": {"name":"review", "target":1}, "2":{"name":"approval", "target":2},  "finish": { "xreview": {"procStat": "P", "status" : "J", "tflag" : "3"}, "wf":{"stage" : 2}}}',
			"BN"=>'{"1": {"name":"review", "target":1}, "2":{"name":"approval", "target":2},  "finish": { "xreview": {"procStat": "P", "status" : "J", "tflag" : "3"}, "wf":{"stage" : 2}}}',
			"RS"=>'{"1": {"name":"review", "target":1}, "2":{"name":"approval", "target":1},  "finish": { "xreview": {"procStat": "P", "status" : "I", "tflag" : "3"}, "wf":{"stage" : 2}}}'
		);
	}
	public function wfparam($pname){
		return $this->wfparam->$pname;
	}
	
	
	private function getauthmap($accoffice){
		$rmap = $this->db->query("select * from v_idmauth where accOffice = ? and idm > 0", array($accoffice))->result();
		$minit =   array();
		$mappr =   array();
		
		foreach($rmap as $crow){
			if ($crow->s1 > 0) $minit[$crow->loginid] = $crow->s1;
			if ($crow->s2 > 0) $mappr[$crow->loginid] = $crow->s2;
		
		}
		return (object) array('init'=>$minit, 'appr'=>$mappr);
	}
	
	public function wfinit($pname, $accoffice){
		$pparam = $this->wfparam->$pname;
		$ret = null;
		if (isset($pparam)){
			$ret = json_decode($pparam, true);
			
			$authmap = $this->getauthmap($accoffice);
			
			$ret['1']['actor'] = $authmap->init;
			$ret['2']['actor'] = $authmap->appr;
			log_message('debug', print_r(array("cparam"=>$ret), TRUE));
		}
		return $ret;
	}

} 