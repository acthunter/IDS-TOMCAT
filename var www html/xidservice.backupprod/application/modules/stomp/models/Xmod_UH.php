<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_UH extends CI_Model {

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
		$mode = 'UH';
		$status_init = 'N';
		
		$wfpp = (object) array('mode'=>$mode, 'accoffice'=>$acc, 'initiator'=>$myid);
		
		$wfid = $this->wfmodel->createnew($wfpp); 
		
		$xcp = array('wfid' => $wfid, 'status'=>$status_init);
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
			$dataarr = array('loginid'=>$fdt['loginid'], 'mode'=>$fdt['mode'], 'nohp'=>$fdt['old'], 'nohp_baru'=>$fdt['new'], 'nama'=>$fdt['nama'], 'cposname'=>$fdt['cposname']
			);
			$datastr = json_encode($dataarr);
			$accoffice = $_SESSION['pengguna']->accoffice;
			$xcp = array('type'=>'UH', 'accoffice'=>$accoffice,'status'=>'I',
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
		}
		
		if (preg_match('/approve/',$fdt['reqtype'])){
			$myid_apprv = $_SESSION['pengguna']->loginid;
			$wf = $this->wfmodel->getwfinfo($wfid);
			$initiator = $wf->initiator;
			$id_office= $wf->id;
			log_message('debug', print_r(array('wfaction.wf.wf'=>$wf), TRUE));
			$direction = 1;
			$date = new DateTime();
				$date->setTimezone(new DateTimeZone('Asia/Jakarta'));
			$time = $date->format('Y-m-d H:i:s');
			$xcpp = array('approval'=>$myid_apprv, 'dateappr'=> $time);					
			$ustr1 = $this->db->update_string('xwfparam', $xcpp, 'id=' . $fdt['wfid']  );
			$this->db->query($ustr1);
/* 			$dataarr = array('id'=>$wfid, 'status'=>'F', 'nohp_baru'=>$fdt['new']);
			$wf = $this->wfmodel->getprocess($wfid); */
		}
		

		$sdat = $fdt['sdate'];
		$jam = $fdt['jam'];
		$sdate =  "$sdat $jam";		
		$dataarr = array('loginid'=>$fdt['loginid'], 'mode'=>$fdt['mode'],'nohp'=>$fdt['old'], 'nohp_baru'=>$fdt['new'], 'nama'=>$fdt['nama'], 'cposname'=>$fdt['cposname'],
			'sdate'=> date('Y-m-d G:i',strtotime($sdate)), 
		);
		$datastr = json_encode($dataarr);
		$accoffice = $_SESSION['pengguna']->accoffice;
		$xcp = array('type'=>'UH', 'accoffice'=>$accoffice,'status'=>'I',
				'data'=> $datastr);			
		$ustr = $this->db->update_string('xreviewpos', $xcp, 'wfid=' . $fdt['wfid']  );
		$this->db->query($ustr);
/* 		$datastr = json_encode($dataarr);
		$accoffice = $_SESSION['pengguna']->accoffice;
				
		$ustr = $this->db->update_string('xreviewpos', $xcp, 'wfid=' . $fdt['wfid']  ); */
				
		//$this->db->query($ustr);

			
		if (preg_match('/reject/',$fdt['reqtype']))
			$direction = -1;

		if ($direction == 0){
			if (preg_match('/(release)/',$fdt['reqtype'])){
				$ret = $this->wfmodel->releasejob($myid,$wfid);
				log_message('debug', print_r(array("RET ATAS"=>$ret), TRUE));
			}
		} else {
			
			$myid = $this->session->userdata('pengguna')->loginid;
			$ret = $this->wfmodel->action($myid,$wfid, $direction, $fdt['notes']);
		}
		$dataarray = array( 'NPP'=>$fdt['loginid'], 'mobileNumber'=>$fdt['new']);
		$this->wfmodel->getprocess($dataarray, $fdt['wfid']);
		return $ret;
	}
} 