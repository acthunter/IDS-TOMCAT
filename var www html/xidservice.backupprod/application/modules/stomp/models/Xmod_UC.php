<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_UC extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('xwf_model', 'wfmodel');
	}
	
	public function wfdetail($id){
		if ($id != null){
			$wf = $this->wfmodel->getwfinfo($id);
			//log_message('debug', print_r(array('ua.wfdetail.wf'=>$wf), TRUE));
			if ($wf != null){
				$rpos = $this->db->query("select * from xrequest xr where xr.reqid = ?", array(intval($id)))->row();
				//log_message('debug', print_r(array('ua.wfdetail.rpos'=>$rpos), TRUE));
				if (isset($rpos->detail)){
					$dataarr = json_decode($rpos->detail, false);
					//log_message('debug', print_r(array('ua.wfdetail.dataarr'=>$dataarr), TRUE));
					$listrow = $this->db->query('select name, positionid, posname from v_login_name where loginid=?', array ($dataarr->npp))->row();
					if(isset($listrow->data)){
						$dataarr->nama = $listrow->name;
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
	
	public function createnew(){
		$fdt = $this->input->post();
		$accoffice = $_SESSION['pengguna']->accoffice;
		//var_dump($accoffice);
		$mode = 'UC';
		//var_dump($mode);
		//$myid = $this->cas->getmycas_login($this->cas);
		$init = $this->db->query("SELECT loginid, s1 FROM v_idmauth WHERE accOffice = ".$accoffice." AND s1 > 0");
		$myid = $init->row(0)->loginid;
		
		$wfpp = (object) array('mode'=>$mode, 'accoffice'=>$accoffice, 'initiator'=>$myid);
		
		$wfid = $this->wfmodel->createnew($wfpp); 
		
		$xcp = array('reqid' => $wfid);
		
		$ustr = $this->db->insert_string('xrequest', $xcp);
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
		$wfid = $fdt['reqid'];
		//$accoffice = $fdt['accOffice'];
		$id = $fdt['id'];
		//$loginid = $fdt['loginid'];
		$myid = $_SESSION['pengguna']->loginid;
		log_message('debug', print_r(array("xcp.wfaction"=>$myid), TRUE)); 
		
		if (preg_match('/save/',$fdt['reqtype'])){
			$wfdetail = $this->createnew();
			$wfid = $wfdetail->id;	
			
			$dataarr = array('loginid'=>$fdt['loginid'], 'nama'=>'', 'email'=>'', 'DOB'=>'', 'mobileNumber'=>'', 'positionid'=>'');
			$datastr = json_encode($dataarr);
			$xcp = array('trid'=>$id, 'srctype'=>'UC', 'accOffice'=>$fdt['accOffice'], 'status'=>'I', 'detail'=> $datastr);
			
			$ustr = $this->db->update_string('xrequest', $xcp, 'reqid=' . $wfdetail->id  );
			$ret = $this->db->query($ustr);
		}				
		$direction = 0;
		
		if (preg_match('/submit/',$fdt['reqtype'])){
			$wfid = $fdt['reqid'];

			$dataarr = array('npp'=>$fdt['loginid'], 'nama'=>$fdt['nama'], 'email'=>$fdt['email'], 'mobileNumber'=>$fdt['mobileNumber'], 'DOB'=>$fdt['DOB'],'positionid'=>$fdt['positionid'], 'pname'=>$fdt['pname'] );
			$datastr = json_encode($dataarr);
			$accoffice = $_SESSION['pengguna']->accoffice;
			$xcp = array('srctype'=>'UC', 'accoffice'=>$accoffice, 'req_stat'=>'I', 'detail'=> $datastr);
			$ustr = $this->db->update_string('xrequest', $xcp, 'reqid=' .  $wfid );

			$this->db->query($ustr);
			
			$wf = $this->wfmodel->getwfinfo($wfid);
			$direction = 1;
		}
		
		if (preg_match('/approve/',$fdt['reqtype'])){
			$dataarr = array('req_flag'=>'P');
			$ustr = $this->db->update_string('xrequest', $dataarr, 'reqid=' . $wfid  );
			$this->db->query($ustr);
			
			$wf = $this->wfmodel->getwfinfo($wfid);
			$direction = 1;
		}
			
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