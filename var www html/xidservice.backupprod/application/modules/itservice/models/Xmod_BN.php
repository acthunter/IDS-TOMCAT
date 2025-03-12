<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_BN extends CI_Model {

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
				$rpos = $this->db->query("select * from xreviewpos xr where xr.wfid = ?", array(intval($id)))->row();
				if (isset($rpos->data)){
					$dataarr = json_decode($rpos->data, false);
					
					
					$posrow = $this->db->query('select name from xposition where positionid=?', array ($dataarr->positionid))->row();
					
					if(isset($posrow)){
					$dataarr->pname = $posrow->name;
					}
					$rpos->data = $dataarr;
				}
				$wf->detail = $rpos;
			}
		} else {
			$wf = (object) array();
			log_message('debug', print_r(array('else.wfdetail.wf'=>$wf), TRUE));
		}
		return $wf;
	}
	
	public function createnew($app){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$mode = 'BN';

		$myid = $_SESSION['pengguna']->loginid;
		
		$wfpp = (object) array('mode'=>$mode, 'accoffice'=>$accoffice, 'initiator'=>$myid);
		
		$wfid = $this->wfmodel->createnew($wfpp); 
		
		$xcp = array('wfid' => $wfid);
		
		$ustr = $this->db->insert_string('xreviewpos', $xcp);
		$this->db->query($ustr);
		
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
				if ($wf->stage == 1){
					$eligable[] = "submit";
					$eligable[] = "cancel";
				} else {
					$eligable[] = "approve";
					$eligable[] = "reject";
				}
			}
		}
		return $eligable;
	}

	public function wfaction(){
		$fdt = $this->input->post();
		$wfid = $fdt['wfid'];
		$reqtype = $fdt['reqtype'];
		$myid = $_SESSION['pengguna']->loginid;
		log_message('debug', print_r(array("xcp.wfaction"=>$myid), TRUE));
		if (preg_match('/submit/',$fdt['tipe_btn'])){
			$wfdetail = $this->createnew($app);
			$wfid = $wfdetail->id;
			
			
			$dataarr = array('npp'=>trim($fdt['npp']), 'mode'=>trim($fdt['mode']), 'nloginid'=>$fdt['bloginid'], 'nama'=>trim(strtoupper($fdt['nama'])), 'unit'=>$fdt['unit'], 'unit_name'=>$fdt['unit_name'],
			'positionid'=>$fdt['positionid'],'pname'=>trim($fdt['pname']), 'email'=>trim($fdt['email']), 'mobileNumber'=>trim($fdt['nohp']), 'surat'=>trim($fdt['surat'])
			);
			
			$datastr = json_encode($dataarr);
			$accoffice = $_SESSION['pengguna']->accoffice;
			$xcp = array('type'=>'BN', 'accoffice'=>$accoffice,'status'=>'I',
					'data'=> $datastr);			
					
			$ustr = $this->db->update_string('xreviewpos', $xcp, 'id=' . $wfdetail->detail->id  );
			$ret = $this->db->query($ustr);
		}
		$direction = 1;		
			
		if (preg_match('/reject/',$fdt['reqtype']))
			$direction = -1;

		if ($direction == 0){
			if (preg_match('/(release)/',$fdt['reqtype'])){
				$ret = $this->wfmodel->releasejob($myid,$wfid);
				log_message('debug', print_r(array("RET ATAS"=>$ret), TRUE));
			}
		} else {
			$myid = $this->session->userdata('pengguna')->loginid;
			log_message('debug', print_r(array("CT.wfaction.ret.wfid"=>$direction), TRUE));
			$ret = $this->wfmodel->action($myid,$wfid, $direction, $fdt['notes']);
			log_message('debug', print_r(array("CT.wfaction.ret.2"=>$ret), TRUE));
		}
		return $ret;
	}
} 