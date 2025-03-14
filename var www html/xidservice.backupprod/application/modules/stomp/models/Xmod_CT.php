<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_CT extends CI_Model {

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
		$accoffice = $_SESSION['pengguna']->accoffice;
		$mode = 'CT';
		//$myid = $this->cas->getmycas_login($this->cas);
		$myid = $_SESSION['pengguna']->loginid;
		
		$wfpp = (object) array('mode'=>$mode, 'accoffice'=>$accoffice, 'initiator'=>$myid);
		
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
		//$myid = $this->cas->getmycas_login(null);
		$myid = $_SESSION['pengguna']->loginid;
		log_message('debug', print_r(array("xcp.wfaction"=>$myid), TRUE)); 
		
		if (preg_match('/save/',$fdt['reqtype'])){
			$wfdetail = $this->createnew();
			$wfid = $wfdetail->id;
			/* if($fdt['same'] == 0){
				$sdate = $fdt['sdate'];
				$edate = $fdt['edate'];
			}else{			
				$sdat = $fdt['sdate2'];
				$edat = $fdt['edate2'];
				$jam = $fdt['jam'];
				$jam2 = $fdt['jam2'];
				$sdate =  "$sdat $jam";		
				$edate =  "$edat $jam2";;	
			} */
			$sdat = $fdt['sdate'];
			$edat = $fdt['edate'];
			$jam = $fdt['jam'];
			$jam2 = $fdt['jam2'];
			$sdate =  "$sdat $jam";		
			$edate =  "$edat $jam2";
			//log_message('debug', print_r(array("CT.wfaction.wfdetail"=>$wfdetail), TRUE));
			log_message('debug', print_r(array("ua.wfaction.wfdetail"=>$wfdetail), TRUE)); 
			$dataarr = array('loginid'=>$fdt['loginid'], 'tpos'=>$fdt['tposid'], 'pname'=>$fdt['tposname'], 'nama'=>$fdt['nama'], 'mode'=>$fdt['mode'], 'cposname'=>$fdt['cposname'],
				'sdate'=> date('Y-m-d G:i',strtotime($sdate)), 
				'edate'=> date('Y-m-d G:i',strtotime($edate)), 
				'note'=>$fdt['keterangan']
			);
			$datastr = json_encode($dataarr);
			$accoffice = $_SESSION['pengguna']->accoffice;
			$xcp = array('type'=>'CT', 'accoffice'=>$accoffice,'status'=>'I',
					'data'=> $datastr);			
			//log_message('debug', print_r(array('arr.xcp'=>$xcp), TRUE));
			$ustr = $this->db->update_string('xreviewpos', $xcp, 'id=' . $wfdetail->detail->id  );
			$ret = $this->db->query($ustr);
			log_message('debug', print_r(array('save.xcp'=>$ustr), TRUE));
		}
		$direction = 0;
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
			$date = new DateTime();
				$date->setTimezone(new DateTimeZone('Asia/Jakarta'));
			$time = $date->format('Y-m-d H:i:s');
			$xcpp = array('approval'=>$myid_apprv, 'dateappr'=> $time);					
			$ustr1 = $this->db->update_string('xwfparam', $xcpp, 'id=' . $fdt['wfid']  );
			$this->db->query($ustr1);
			/* if($fdt['same'] == 0){
				$sdate = $fdt['sdate'];
				$edate = $fdt['edate'];
			}else{
				$sdate = $fdt['sdate2'];
				$edate = $fdt['edate2'];
			} */
			$sdat = $fdt['sdate'];
				$edat = $fdt['edate'];
				$jam = $fdt['jam'];
				$jam2 = $fdt['jam2'];
				$sdate =  "$sdat $jam";		
				$edate =  "$edat $jam2";;
			/* $sdate = $sdate;
			$edate = $edate; */
			$unit = 'test_unit';
			$target = "Perubahan Posisi Sementara";
			$name = $dt_init->row()->name;
			$reqid = $wf->id;
			//$test = $wf[0];
			log_message('debug', print_r(array('wfaction.submit.target'=>$target), TRUE));
			$this->load->library('sendmail');
			//$this->sendmail->submit_apprv($target, $name, $reqid, $name_usr, $npp_usr, $cpos, $tpos, $unit,  
							//$sdate, $edate, $initiator, $name_init, $name_office, $code_office, $name_appr, $npp_appr);
		}
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
			/* if($fdt['same'] == 0){
				$sdate = $fdt['sdate'];
				$edate = $fdt['edate'];
			}else{
				$sdate = $fdt['sdate2'];
				$edate = $fdt['edate2'];
			}
			$sdate = $sdate;
			$edate = $edate; */
			$sdat = $fdt['sdate'];
				$edat = $fdt['edate'];
				$jam = $fdt['jam'];
				$jam2 = $fdt['jam2'];
				$sdate =  "$sdat $jam";		
				$edate =  "$edat $jam2";;
			$unit = 'test_unit';
			$target = "Perubahan Posisi Sementara";
			$name = "test_approval";
			$reqid = $wf->id;
			//$test = $wf[0];
			log_message('debug', print_r(array('wfaction.submit.target'=>$target), TRUE));
			$this->load->library('sendmail');
			//$this->sendmail->submit_rqst($target, $name, $reqid, $name_usr, $npp_usr, $cpos, $tpos, $unit,  
							//$sdate, $edate, $initiator, $name_init, $name_office, $code_office);
		}
		
	
		/* if($fdt['same'] == 0){
				$sdate = $fdt['sdate'];
				$edate = $fdt['edate'];
			}else{
				$sdat = $fdt['sdate2'];
				$edat = $fdt['edate2'];
				$jam = $fdt['jam'];
				$jam2 = $fdt['jam2'];
				$sdate =  "$sdat $jam";		
				$edate =  "$edat $jam2";;	
			}
			$sdate = $sdate;
			$edate = $edate; */
			$sdat = $fdt['sdate'];
				$edat = $fdt['edate'];
				$jam = $fdt['jam'];
				$jam2 = $fdt['jam2'];
				$sdate =  "$sdat $jam";		
				$edate =  "$edat $jam2";;
		//var_dump($edate);
		$dataarr = array('loginid'=>$fdt['loginid'], 'tpos'=>$fdt['tposid'], 'pname'=>$fdt['tposname'], 'nama'=>$fdt['nama'], 'cposname'=>$fdt['cposname'],
			'sdate'=> date('Y-m-d G:i',strtotime($sdate)), 
			'edate'=> date('Y-m-d G:i',strtotime($edate)),
			'note'=>$fdt['keterangan']
		);
		log_message('debug', print_r(array("Direction"=>$wfid), TRUE));
		$datastr = json_encode($dataarr);
		$accoffice = $_SESSION['pengguna']->accoffice;
		$xcp = array('type'=>'CT', 'accoffice'=>$accoffice,'status'=>'I',
				'data'=> $datastr);			
		$ustr = $this->db->update_string('xreviewpos', $xcp, 'wfid=' . $fdt['wfid']  );
		$this->db->query($ustr);
		
		/*if (preg_match('/(submit|approve)/',$fdt['reqtype'])){
			$direction = 1;
			$dt = $this->db->query("SELECT rp.NPP as npp, rp.Name as name FROM xemployee rp WHERE rp.NPP = " . $fdt['loginid']);
			$type= $fdt['reqtype'];
			$npp = $dt->row()->npp;
			$target = "test";
			$name = $dt->row()->name;
			//$this->load->library('sendmail');
			//$this->sendmail->htmlmail($type, $npp, $target, $name);
		}*/
			
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