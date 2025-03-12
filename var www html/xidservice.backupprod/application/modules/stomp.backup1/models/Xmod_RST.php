<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_RST extends CI_Model {

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
		$myid = $_SESSION['pengguna']->loginid;
		log_message('debug', print_r(array("xcp.wfaction"=>$myid), TRUE)); 
		
		if (preg_match('/save/',$fdt['reqtype'])){
			$wfdetail = $this->createnew();
			$wfid = $wfdetail->id;
			$str = json_decode($fdt ['app'],true);
			foreach($str as $key => $value){
				$opts[$value["npp"]] = array_combine(explode(",",$value["apps"]), explode(",",$value["req"])) ;
			}
			$detail = json_encode($opts);
			$dataarr = array('srctype'=>$fdt ['reqtype'],'reqid'=>$this->session->userdata('pengguna')->loginid, 'detail'=>$detail);
			$datastr = json_encode($dataarr);
			$accoffice = $_SESSION['pengguna']->accoffice;
			$xcp = array('type'=>'RST', 'accoffice'=>$accoffice,'status'=>'I',
					'data'=> $datastr);			
			$ustr = $this->db->update_string('xreviewpos', $xcp, 'id=' . $wfdetail->detail->id  );
			$ret = $this->db->query($ustr);
			log_message('debug', print_r(array('save.xcp'=>$ustr), TRUE));
		}
		$direction = 0;		
			$str = json_decode($fdt ['app'],true);
			foreach($str as $key => $value){
				$opts[$value["npp"]] = array_combine(explode(",",$value["apps"]), explode(",",$value["req"])) ;
			}
			$detail = json_encode($opts);
			$dataarr = array('srctype'=>$fdt ['reqtype'],'reqid'=>$this->session->userdata('pengguna')->loginid, 'detail'=>$detail);
		log_message('debug', print_r(array("Direction"=>$wfid), TRUE));
		$datastr = json_encode($dataarr);
		$accoffice = $_SESSION['pengguna']->accoffice;
		$xcp = array('type'=>'RST', 'accoffice'=>$accoffice,'status'=>'I',
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
			log_message('debug', print_r(array("CT.wfaction.ret.wfid"=>$direction), TRUE));
			$ret = $this->wfmodel->action($myid,$wfid, $direction, $fdt['notes']);
			log_message('debug', print_r(array("CT.wfaction.ret.2"=>$ret), TRUE));
		}
		return $ret;
	}
} 