<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_VL extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('xwf_model', 'wfmodel');
	}
	
	public function wfdetail($id){
		if ($id!=null){
			$wf = $this->wfmodel->getwfinfo($id);
			log_message('debug', print_r(array('ua.wfdetail.wf'=>$wf), TRUE));
			if ($wf != null){
				$rpos = $this->db->query("select * from xqueue xr where xr.wfid = ?", array(intval($id)))->row();
				log_message('debug', print_r(array('ua.wfdetail.rpos'=>$rpos), TRUE));
				if (isset($rpos)){
					//$dataarr = json_decode($rpos->data, false);
					//log_message('debug', print_r(array('ua.wfdetail.dataarr'=>$dataarr), TRUE));
					
					$posrow = $this->db->query('select xq.id as id, xv.trid, xr.loginid, xr.target, xv.type FROM xqueue xq JOIN xvalidation xv ON xq.id = xv.qid JOIN transitRepo xr ON xv.trid = xr.id WHERE xq.status = "K" and xv.status = "J" and xq.wfid = ?',array(intval($id)));
						$a = $posrow -> result();
						
						 foreach($a as $key){
							 $opts[]= array(
								"id" => $key->id,
								"trid" => $key->trid,
								"loginid" => $key->loginid,
								"target" => $key->target,
								"type" => $key->type
							); 
							
						} 
						//var_dump($opts);
					/* $rpos->id = $posrow->id;
					$rpos->trid = $posrow->trid;
					//$dataarr->loginid = $posrow->loginid;
					$rpos->target = $posrow->target; */
					
					$rpos->data = $opts;
				}
				$wf->detail = $rpos;
			}
		} else {
			$wf = (object) array();
			log_message('debug', print_r(array('else.wfdetail.wf'=>$wf), TRUE));
		}
		return $wf;
	}
	
	public function createnew(){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$mode = 'VL';
		//$myid = $this->cas->getmycas_login($this->cas);
		$myid = $_SESSION['pengguna']->loginid;
		
		$wfpp = (object) array('mode'=>$mode, 'accoffice'=>$accoffice, 'initiator'=>$myid);
		
		$wfid = $this->wfmodel->createnew($wfpp); 
		
		$xcp = array('wfid' => $wfid);
		$ustr = $this->db->insert_string('xqueue', $xcp);
		$this->db->query($ustr);
		//log_message('debug', print_r(array('createnew'=>$ustr), TRUE));
		$wfdetail = $this->wfdetail($wfid);
		$wfdetail->eaction = $this->possibleAction($wfdetail, $myid);
		return $wfdetail;
	}
	
	public function possibleAction($wf, $actor){
		$eligable = array();
		
		log_message('debug', print_r(array('wf.pa'=>$wf), TRUE));
		if ($wf->stage == 1 or $wf->stage == 2){
			$currActor = $wf->currActor;
			
			$isDoneActor = in_array($actor, $wf->doneActor);
			$isValidActor = isset($currActor->$actor);
			log_message('debug', print_r(array("isdoneActor"=>$isDoneActor, "isValidActor"=>$isValidActor, "currActor"=>$currActor), TRUE)); 
			if ($isValidActor && !$isDoneActor){
				//if ($wf->stage == 1 && $wf->currScore == 0){
				if ($wf->stage == 1){
					$eligable[] = "submit";
					$eligable[] = "cancel";
				} else {
					$eligable[] = "approve";
					$eligable[] = "reject";
				}
				//lock
			}
		}
		return $eligable;
	}

	public function wfaction(){
		$fdt = $this->input->post();
		$wfid = $fdt['wfid'];
		$reqtype = $fdt['reqtype'];
		$token_id = $fdt['token_id'];
		
		$myid = $_SESSION['pengguna']->loginid;
		log_message('debug', print_r(array("xcp.wfaction"=>$myid), TRUE)); 
	
		if (preg_match('/approve/',$fdt['reqtype'])){
			$dataarr = array('status'=>'P');
			$dtar = array('status' => 'K');
			$ustr = $this->db->update_string('xqueue', $dataarr, 'wfid=' . $wfid);
			$ustrr = $this->db->update_string('xvalidation', $dtar, 'qid=' . $token_id);
			$this->db->query($ustr);
			$this->db->query($ustrr);
			$myid_apprv = $_SESSION['pengguna']->loginid;
						$wf = $this->wfmodel->getwfinfo($wfid);
						$direction = 1;
		}	
		if (preg_match('/reject/',$fdt['reqtype']))
			$direction = -1;

		if ($direction == 0){
			if (preg_match('/(release)/',$fdt['reqtype'])){
				$ret = $this->wfmodel->releasejob($myid,$wfid);
				log_message('debug', print_r(array("RET ATAS"=>$ret), TRUE));
				//var_dump($ret);
			}
		} else {
			$myid = $this->session->userdata('pengguna')->loginid;
			log_message('debug', print_r(array("CT.wfaction.ret.wfid"=>$direction), TRUE));
			$ret = $this->wfmodel->action($myid,$wfid, $direction, $fdt['notes']);
			log_message('debug', print_r(array("CT.wfaction.ret.2"=>$ret), TRUE));
		}
		//var_dump($ret)
;		return $ret;
	}
} 