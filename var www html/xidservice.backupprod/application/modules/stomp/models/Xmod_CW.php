<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_CW extends CI_Model {

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
				log_message('debug', print_r(array('ua.wfdetail.rpos'=>$rpos), TRUE));
				if (isset($rpos->data)){
					$dataarr = json_decode($rpos->data, false);
					log_message('debug', print_r(array('ua.wfdetail.dataarr'=>$dataarr), TRUE));
					$posrow = $this->db->query('select name from xposition where positionid=?', array ($dataarr->tpos))->row();
					$listrow = $this->db->query('select name, positionid, posname from v_login_name where loginid=?', array ($dataarr->loginid))->row();
					if(isset($posrow->data)){
						if(isset($listrow->data)){
					$dataarr->nama = $listrow->name;
					$dataarr->cposname = $listrow->posname;
					$dataarr->cposid = $listrow->positionid;
					$dataarr->pname = $posrow->name;
					}}
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
	
	public function createnew(){
		$myid = $_SESSION['pengguna']->loginid;
		$acc = $_SESSION['pengguna']->accoffice;
		$mode = 'CW';	
		
		$wfpp = (object) array('mode'=>$mode, 'accoffice'=>$acc, 'initiator'=>$myid);
		
		$wfid = $this->wfmodel->createnew($wfpp); 
		
		$xcp = array('wfid' => $wfid);
		$ustr = $this->db->insert_string('xreviewpos', $xcp);
		$this->db->query($ustr);
		log_message('debug', print_r(array('createnew'=>$ustr), TRUE));
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
				//lock
			}
		}
		return $eligable;
	}

	public function wfaction(){
		$fdt = $this->input->post();
		$wfid = $fdt['wfid'];
		$reqtype = $fdt['reqtype'];
		$myid = $_SESSION['pengguna']->loginid;
		
		if (preg_match('/save/',$fdt['reqtype'])){
			$wfdetail = $this->createnew();
			$wfid = $wfdetail->id;
			$sdat = $fdt['sdate'];
			$jam = $fdt['jam'];
			$sdate =  "$sdat $jam";			
			log_message('debug', print_r(array("ua.wfaction.wfdetail"=>$wfdetail), TRUE)); 
			$dataarr = array('loginid'=>$fdt['loginid'], 'mode'=>$fdt['mode'], 'positionid'=>$fdt['cposid'], 'pname'=>$fdt['cposname'], 'nama'=>$fdt['nama'], 
				'sdate'=> date('Y-m-d G:i',strtotime($sdate)), 
			);
			$datastr = json_encode($dataarr);
			$accoffice = $_SESSION['pengguna']->accoffice;
			$xcp = array('type'=>'CW', 'accoffice'=>$accoffice,'status'=>'I',
					'data'=> $datastr);			
			$ustr = $this->db->update_string('xreviewpos', $xcp, 'id=' . $wfdetail->detail->id  );
			$ret = $this->db->query($ustr);
			log_message('debug', print_r(array('save.xcp'=>$ustr), TRUE));
		}
		
		
		$direction = 0;
		
		if (preg_match('/submit/',$fdt['reqtype'])){
			$wf = $this->wfmodel->getwfinfo($wfid);
			$initiator = $wf->initiator;
			$id_office= $wf->id;
			log_message('debug', print_r(array('wfaction.wf.wf'=>$wf), TRUE));
			log_message('debug', print_r(array('wfaction.wf.wf'=>$id_office), TRUE));
			$direction = 1;
			$dt_usr = $this->db->query("SELECT rp.NPP as npp, rp.Name as name FROM xemployee rp WHERE rp.NPP = " . $fdt['loginid']);
			$dt_init = $this->db->query("SELECT rp.NPP as npp, rp.Name as name FROM xemployee rp WHERE rp.NPP = " . $initiator);
			$dt_office = $this->db->query("SELECT xr.id, xr.wfid, xe.name as name, xr.accoffice as code FROM xreviewpos xr JOIN xwfparam xw ON xr.wfid = xw.id 
											JOIN xentitas xe ON xr.accoffice = xe.accOffice WHERE xr.wfid = " . $id_office );
			$name_usr = $dt_usr->row()->name;
			$name_init = $dt_init->row()->name;
			$name_office = $dt_office->row()->name;
			$code_office = $dt_office->row()->code;
			$npp_usr = $fdt['loginid'];
			$npp = "test_npp";
			$cpos = $fdt['cposname'];
			$tpos = $fdt['tposname'];
			$sdat = $fdt['sdate'];
			$jam = $fdt['jam'];
			$sdate = date('Y-m-d G:i',strtotime("$sdat $jam") );	
			
			$edate = "test";
			$unit = 'test_unit';
			$target = "Perubahan Posisi Permanen";
			$name = "test_approval";
			$reqid = $wf->id;
			//$test = $wf[0];
			log_message('debug', print_r(array('wfaction.submit.target'=>$target), TRUE));
			$this->load->library('sendmail');
			$this->sendmail->submit_rqst($target, $name, $reqid, $name_usr, $npp_usr, $cpos, $tpos, $unit,  
							$sdate, $edate, $initiator, $name_init, $name_office, $code_office);
		}
		
		if (preg_match('/approve/',$fdt['reqtype'])){
			$myid_apprv = $_SESSION['pengguna']->loginid;
			log_message('debug', print_r(array('wfaction.apprv.myidapprv'=>$myid_apprv), TRUE));
			$wf = $this->wfmodel->getwfinfo($wfid);
			$initiator = $wf->initiator;
			$id_office= $wf->id;
			log_message('debug', print_r(array('wfaction.wf.wf'=>$wf), TRUE));
			$direction = 1;
			$dt_usr = $this->db->query("SELECT rp.NPP as npp, rp.Name as name FROM xemployee rp WHERE rp.NPP = " . $fdt['loginid']);
			$dt_init = $this->db->query("SELECT rp.NPP as npp, rp.Name as name FROM xemployee rp WHERE rp.NPP = " . $initiator);
			$dt_appr = $this->db->query("SELECT rp.NPP as npp, rp.Name as name FROM xemployee rp WHERE rp.NPP = " . $myid_apprv);
			$dt_office = $this->db->query("SELECT xr.id, xr.wfid, xe.name as name, xr.accoffice as code FROM xreviewpos xr JOIN xwfparam xw ON xr.wfid = xw.id 
											JOIN xentitas xe ON xr.accoffice = xe.accOffice WHERE xr.wfid = " . $id_office );
			$npp_appr = $myid_apprv;
			$name_appr = $dt_appr->row()->name;
			$name_usr = $dt_usr->row()->name;
			$name_init = $dt_init->row()->name;
			$name_office = $dt_office->row()->name;
			$code_office = $dt_office->row()->code;
			$npp_usr = $fdt['loginid'];
			$npp = "test_npp";
			$cpos = $fdt['cposname'];
			$tpos = $fdt['tposname'];
			$sdat = $fdt['sdate'];
			$jam = $fdt['jam'];
			$sdate = date('Y-m-d G:i',strtotime("$sdat $jam") );	
			$edate = "test";
			$unit = 'test_unit';
			$target = "Perubahan Posisi Permanen";
			$name = $dt_init->row()->name;
			$reqid = $wf->id;
			//$test = $wf[0];
			log_message('debug', print_r(array('wfaction.submit.target'=>$target), TRUE));
			$this->load->library('sendmail');
			$this->sendmail->submit_apprv($target, $name, $reqid, $name_usr, $npp_usr, $cpos, $tpos, $unit,  
							$sdate, $edate, $initiator, $name_init, $name_office, $code_office, $name_appr, $npp_appr);
		}
		
		$sdat = $fdt['sdate'];
		$jam = $fdt['jam'];
		$sdate =  "$sdat $jam";
		$dataarr = array('loginid'=>$fdt['loginid'], 'mode'=>$fdt['mode'], 'positionid'=>$fdt['cposid'], 'pname'=>$fdt['cposname'], 'nama'=>$fdt['nama'], 
			'sdate'=> date('Y-m-d G:i',strtotime($sdate)), 
		); 
		$datastr = json_encode($dataarr);
		$accoffice = $_SESSION['pengguna']->accoffice;
		$xcp = array('type'=>'CW', 'accoffice'=>$accoffice,'status'=>'I',
				'data'=> $datastr);			
		$ustr = $this->db->update_string('xreviewpos', $xcp, 'wfid=' . $fdt['wfid']  );
		$this->db->query($ustr);
			
		if (preg_match('/reject/',$fdt['reqtype']))
			$direction = -1;

		if ($direction == 0){
			if (preg_match('/(release)/',$fdt['reqtype'])){
				$ret = $this->wfmodel->releasejob($myid,$wfid);
				log_message('debug', print_r(array("RET ATAS"=>$ret), TRUE));
			}
		} else {
			$myid = $this->session->userdata('pengguna')->loginid;
			//log_message('debug', print_r(array("CP.wfaction.ret.wfid"=>$wfid, "dir"=>$direction, "myid"=>$myid), TRUE));
			$ret = $this->wfmodel->action($myid,$wfid, $direction, $fdt['notes']);
			//log_message('debug', print_r(array("CP.wfaction.ret.2"=>$ret), TRUE));
		}
		return $ret;
	}
} 