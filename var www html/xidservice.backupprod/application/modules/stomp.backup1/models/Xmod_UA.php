<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_UA extends CI_Model {

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
					
					$posrow = $this->db->query('select name from xposition where positionid=?', array ($dataarr->positionid))->row();
					if(isset($posrow->data)){
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

	public function initiate(){
		return $this->wfdetail(null);
	}
	
	public function createnew(){
		$fdt = $this->input->post();
		
		$accoffice = $_SESSION['pengguna']->accoffice;
		$mode = 'UA';
		//$myid = $this->cas->getmycas_login($this->cas);
		$myid = $_SESSION['pengguna']->loginid;
		$wfpp = (object) array('mode'=>$mode, 'accoffice'=>$accoffice, 'initiator'=>$myid);

		$wfid = $this->wfmodel->createnew($wfpp); 
		$xcp = array('wfid' => $wfid);
		log_message('debug', print_r(array('ua.createnew.xcp'=>$xcp), TRUE));
		$ustr = $this->db->insert_string('xreviewpos', $xcp);
		$this->db->query($ustr);
		
		$wfdetail = $this->wfdetail($wfid);
		$wfdetail->stage='1';
		log_message('debug', print_r(array('ua.cn.wfdetail'=>$wfdetail), TRUE));
		
		$wfdetail->eaction = $this->possibleAction($wfdetail, $myid);
		
		return $wfdetail;
	}
	
	public function possibleAction($wf, $actor){
		$eligable = array();
		
		log_message('debug', print_r(array('wf.pa'=>$wf), TRUE));
		if ($wf->stage == '1' or $wf->stage == '2'){
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
		$nik = $fdt['nik'];
		$reqtype = $fdt['reqtype'];
		//$myid = $this->cas->getmycas_login($this->cas);
		$myid = $_SESSION['pengguna']->loginid;
		log_message('debug', print_r(array("xcp.wfaction"=>$fdt), TRUE)); 
		
		if (preg_match('/save/',$fdt['reqtype'])){
			$wfdetail = $this->createnew();
			$wfid = $wfdetail->id;
			
			log_message('debug', print_r(array("ua.wfaction.wfdetail"=>$wfdetail), TRUE)); 
			$dataarr = array('npp'=>$fdt['npp'],'loginid'=>$fdt['loginid'], 'mode'=>$fdt['mode'], 'nama'=>$fdt['nama'], 'nik'=>$fdt['nik'], 'address'=>$fdt['address'], 
				'positionid'=>$fdt['positionid'], 'pname'=>$fdt['pname'],'email'=>$fdt['email'], 'mobileNumber'=>$fdt['mobileNumber'],
				'DOB'=> date('d-m-Y',strtotime($fdt['DOB'])),
				);
			$datastr = json_encode($dataarr);
			$accoffice = $_SESSION['pengguna']->accoffice;
			$xcp = array('type'=>'UA', 'accoffice'=>$accoffice, 'key1'=>$nik, 'status'=>'I',
					'data'=> $datastr);
			/*$xcp = array('loginid'=>$fdt['loginid'], 'tpos'=>$fdt['tposid'],
				'sdate'=> date('Y-m-d h:i',strtotime($fdt['sdate'])), 
				'edate'=> date('Y-m-d h:i',strtotime($fdt['edate'])), 
			); */
			
			log_message('debug', print_r(array('ua.wfaction.xcp'=>$xcp), TRUE));
			
			if (isset($wfdetail->detail)){
				$ustr = $this->db->update_string('xreviewpos', $xcp, 'id=' .  $wfdetail->detail->id );
			}
			$ret = $this->db->query($ustr);
			log_message('debug', print_r(array('save.xcp'=>$ustr), TRUE));
		}
		
		
		$direction = 0;
		if (preg_match('/(submit|approve)/',$fdt['reqtype']))
			$direction = 1;
			$wfid = $fdt['id'];
			//var_dump ($wfid);
			//log_message('debug', print_r(array("ua.wfaction.wfdetail"=>$wfdetail), TRUE)); 
			$dataarr = array('npp'=>$fdt['npp'],'loginid'=>$fdt['loginid'],'nama'=>$fdt['nama'], 'mode'=>$fdt['mode'], 'nik'=>$fdt['nik'], 'address'=>$fdt['address'], 
				'positionid'=>$fdt['positionid'], 'pname'=>$fdt['pname'],'email'=>$fdt['email'], 'mobileNumber'=>$fdt['mobileNumber'],
				'DOB'=> date('d-m-Y',strtotime($fdt['DOB'])),
				);
			$datastr = json_encode($dataarr);
			$accoffice = $_SESSION['pengguna']->accoffice;
			$xcp = array('type'=>'UA', 'accoffice'=>$accoffice, 'key1'=>$nik, 'status'=>'I',
					'data'=> $datastr);
			/*$xcp = array('loginid'=>$fdt['loginid'], 'tpos'=>$fdt['tposid'],
				'sdate'=> date('Y-m-d h:i',strtotime($fdt['sdate'])), 
				'edate'=> date('Y-m-d h:i',strtotime($fdt['edate'])), 
			); */
			
			log_message('debug', print_r(array('ua.wfaction.xcp'=>$xcp), TRUE));
			
			
				$ustr = $this->db->update_string('xreviewpos', $xcp, 'wfid=' .  $wfid );

			$this->db->query($ustr);
		if (preg_match('/reject/',$fdt['reqtype']))
			$direction = -1;
		if ($direction == 0){
			if (preg_match('/(release)/',$fdt['reqtype'])){
				$ret = $this->wfmodel->releasejob($myid,$wfid);
			log_message('debug', print_r(array('ret atas'=>$ret), TRUE));	
			}
		} else {
			$myid = $this->session->userdata('pengguna')->loginid;
			$ret = $this->wfmodel->action($myid,$wfid, $direction, $fdt['notes']);
			log_message('debug', print_r(array('ret bawah'=>$ret), TRUE));	
		}
		return $ret;
	}
} 