<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_validation extends CI_Model {
		public function __construct()
	{
		parent::__construct();
		$this->initparam();
	}
	
	private function initparam(){
		$this->wfparam = (object) array(
			"VL"=>'{"1": {"name":"review", "target":1}, "2":{"name":"approval", "target":2},  "finish": { "xreview": {"procStat": "P", "status" : "J", "tflag" : "3"}, "wf":{"stage" : 2}}}'
		);
	}
	public function createdata(){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$mode = 'VL';
		$myid = $_SESSION['pengguna']->loginid;		
		$wfpp = (object) array('mode'=>$mode, 'accoffice'=>$accoffice, 'initiator'=>$myid);
		$wfid = $this->createnew($wfpp); 
		//$wfdetail = $wfid;
		$wfdetail = $this->getwfinfo($wfid);
		//$wfdetail->eaction = $this->possibleAction($wfdetail, $myid);
		return $wfdetail;
	}
	
	public function wfaction(){
		$fdt = $this->input->post();
		//$wfid = $fdt['wfid'];
		$wfdetail = $this->createdata();
		$wfid = $wfdetail->id;
		$notes = '';
		$direction = 1;
			$myid = $this->session->userdata('pengguna')->loginid;
			log_message('debug', print_r(array("CT.wfaction.ret.wfid"=>$direction), TRUE));
			$ret = $this->action($myid,$wfid, $direction, $notes);
			log_message('debug', print_r(array("CT.wfaction.ret.2"=>$ret), TRUE));
		return $ret;
	}
	
	public function createnew($wfpp){
		//$this->load->model('xwf_param', 'wfparam');
		$wfp = (object) array();
		
		log_message('debug', print_r(array("wfpp"=>$wfpp), TRUE)); 
		$pparam = $this->wfinit($wfpp->mode, $wfpp->accoffice);
		$wfp->param = json_encode($pparam);
		$wfp->initiator = $wfpp->initiator;
		$wfp->accoffice = $wfpp->accoffice;
		$wfp->mode = $wfpp->mode;
		
		$ustr = $this->db->insert_string('xwfparam', $wfp);
		$this->db->query($ustr);
		
		$wfid = $this->db->insert_id();
		
		$this->initstage($wfid, '1', null);
		return $wfid;
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
	public function wfparam($pname){
		return $this->wfparam->$pname;
	}
	
	public function action($actor, $wfid, $isForward, $notes){
		$wf = $this->getwfinfo($wfid);
		
		log_message('debug', print_r(array("wfinfo"=>$wf), TRUE)); 
		if (isset($wf->currActor)){
			$isDoneActor = in_array($actor, $wf->doneActor);
			$isValidActor = isset($wf->currActor->$actor);
			
			$pinput = (object) array ("validActor"=>$isValidActor, "doneActor"=>$isDoneActor,
				"cscore"=>$wf->currScore, "tscore"=>$wf->targetScore, "stage"=>$wf->stage,
				"direction"=>$isForward);
			log_message('debug', print_r(array("pinput"=>$pinput), TRUE)); 
			
			if ($isValidActor && !$isDoneActor){
				$change = $wf->currActor->$actor;
				log_message('debug', print_r(array("change"=>$change), TRUE)); 
				
				$wf->doneActor[] = $actor;
				if ($isForward < 0 ) {
						$wf->currScore -= $change;
						//$wf->doneActor = null
						if ($wf->currScore < 0)
							$wf->currScore = 0;
						if ($wf->stage == 2){
							$wf->stage--;
							$currScore = 0;
						}
				} else {
					$wf->currScore += $change;
					if ($wf->currScore >= $wf->targetScore){
						$wf->stage++;
						$wf->currScore = 0;
					}
				}
			}
		
			$poutput = (object) array ("validActor"=>$isValidActor, "doneActor"=>$wf->doneActor,
				"cscore"=>$wf->currScore, "tscore"=>$wf->targetScore, "stage"=>$wf->stage);
			log_message('debug', print_r(array("poutput"=>$poutput), TRUE)); 
			
			$isupdate = true;
			if ($pinput->stage != $poutput->stage){
				//change stage
				$this->initstage($wfid, $wf->stage, $poutput);
			} else if ($pinput->cscore != $poutput->cscore){
				$udata = array('currScore'=>$wf->currScore, 'doneActor'=>implode(",", $wf->doneActor));
				$ustr = $this->db->update_string('xwfparam', $udata, 'id=' . $wfid );
				log_message('debug', print_r(array("ustr"=>$ustr, "notes"=>$notes), TRUE));
				$this->db->query($ustr);
			} else 
				$isupdate = false;
			
			if ($isupdate){
				$this->load->library('slog');
				$this->slog->write_log('info', print_r(array('wfm.action.update'=>$poutput),TRUE));
				//if (strlen($notes) > 2){
					$this->db->query("insert into xnotes(refid, ntype, loginid, stage, notes) values (?,'A',?,?,?)",array($wfid, $actor, $pinput->stage, $notes));
				//}
			}
		}
		//$this->releasejob($actor, $wfid);
		return $wf;
	}
	public function getwfinfo($wfid){
		$wf = $this->db->query("select id, initiator,pname, doneActor, currActor, currScore, targetScore, accOffice, mode,lockActor, DATE_FORMAT(lockDate,'%H:%i') as lockDate, stage from xwfparam wf where id=?", array(intval($wfid)))->row(); 
		//var_dump($wf);
		if (isset($wf)){
			$wf->currActor = json_decode($wf->currActor, false); 
			$cdone = $wf->doneActor;
			
			if ($cdone == null || strlen($cdone) < 2 ){
					$wf->doneActor = [];
			} else {
					$wf->doneActor = explode(",", $cdone);
			}
		}
		return $wf;
	}
		public function initstage($wfid, $stage, $poutput){
		$wf = $this->getwfinfo($wfid);
		log_message('debug', print_r(array("init.ustr.wf"=>$wf), TRUE));
		$row = $this->db->query("select * from xwfparam where id=" . $wfid)->row();
		log_message('debug', print_r(array("init.stage.wfid"=>$wfid, "stage"=>$stage), TRUE)); 
		if ($row != null){
			$wparam = json_decode($row->param, true);
		log_message('debug', print_r(array("init.stage.wfparam"=>$wparam), TRUE)); 
			$nrow = (object) array();
			$nrow->stage = $stage;
			
			if (isset($wparam[$stage]['target'])){
				$nrow->targetScore = $wparam[$stage]['target'];
				$nrow->currActor = $wparam[$stage]['actor'];
				$nrow->pname = $wparam[$stage]['name'];
				$nrow->lockActor = null;
				$nrow->lockDate = null;
				if (isset($poutput)){
				//SoD
					/*foreach ($poutput->doneActor as $cactor ){
						log_message('debug', print_r(array("initstage.org"=>$nrow->currActor,
							"cidx"=>$nrow->currActor[$cactor], "cactor"=>$cactor), TRUE)); 
						unset($nrow->currActor[$cactor]);
					}*/
					unset($nrow->currActor[end($poutput->doneActor)]); 
				}
				$nrow->currActor = json_encode($nrow->currActor);
			} else {
				if ($stage >= 3){
					$uarr = array("procStat"=>'P', "status"=>'I');
					if (isset($wparam['finish'])){
						$uarr = $wparam['finish']['xreview'];
						$ustr = $this->db->update_string("xwfparam", $wparam['finish']['wf'], "id=" . $wfid);
						log_message('debug', print_r(array("init.ustr"=>$ustr), TRUE)); 
						$this->db->query($ustr);
					} 
					$ustr = $this->db->update_string("xreviewpos", $uarr, "wfid=" . $wfid);
					$this->db->query($ustr);
				}
				$nrow->pname = null;
			} 
	
			$nrow->currScore = 0;
			//$nrow->doneActor = null;
			$doneactor = array($wf->doneActor);
			log_message('debug', print_r(array("init.ustr.doneactor"=>$doneactor), TRUE)); 
			
			//$nrow->doneActor = array($wf->doneActor);

			$ustr = $this->db->update_string('xwfparam', $nrow, 'id=' . $wfid );
			log_message('debug', print_r(array("init.nrow.1"=>$nrow), TRUE));
			log_message('debug', print_r(array("init.ustr.1"=>$ustr), TRUE)); 
			$this->db->query($ustr);
			return $this->getwfinfo($wfid);
		}
		
	}
	
} 