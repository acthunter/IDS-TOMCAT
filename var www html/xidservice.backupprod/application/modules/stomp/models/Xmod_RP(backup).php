<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_RP extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('xwf_model', 'wfmodel');
		$this->load->model('xwf_param', 'wfparam');
	}
	
	public function wfdetail($wfid){
		$wf = $this->wfmodel->getwfinfo($wfid);
		
		if (isset($wf)){
			$wf->detail = $this->db->query("select * from xreviewpos where wfid=?", array($wfid))->row();	
			//$query = $this->db->query("select * from revdraft where reqid=?", array(		$id));
			//$rp->revdraft = $query->result(); 
		} else {
			$wf = (object) array();
			log_message('debug', print_r(array('else.wfdetail.wf'=>$wf), TRUE));
		}
		return $wf;
	}
	
	public function initiate(){	
		return $this->createnew();
	}
	
	public function jobitemlist(){
		$fdt = $this->input->post();
		$wfdetail = $this->createnew();

		$query = $this->db->query("select rd.*, vln.name, vln.posname from revdraft rd left join v_login_name vln on vln.loginid = rd.loginid where rd.reqid=?", $wfdetail->detail->id);
		log_message('debug', print_r(array('jobitemlist'=>$query), TRUE));
		$output = array(
            "recordsTotal" => 1,
            "recordsFiltered" => 1,
            "data" => $query->result()
        );
		return $output;
	}
	public function createnew(){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$mode = 'RP';
		$periode = date('Ym');
		$type = 'RQ';	
		$myid = $this->cas->getmycas_login($this->cas);
		
		//check if exists
		$row = $this->db->query("select * from xreviewpos where accoffice=? and key1=? and type=?",
				array($accoffice, $periode, $type))->row();
		$wfid = null;
		if (!isset($row)){
			$wfpp = (object) array('mode'=>$mode, 'accoffice'=>$accoffice, 'initiator'=>$myid);
			$wfid = $this->wfmodel->createnew($wfpp); 
			$xrev = array ('wfid'=>$wfid, 'type'=>$type, 'accoffice'=>$accoffice, 
				'key1'=>$periode);
			$istr = $this->db->insert_string("xreviewpos", $xrev);
			$query = $this->db->query($istr);
			$rpid  = $this->db->insert_id();
			
			$query = $this->db->query("insert into revdraft(type, reqid, loginid, mobileNumber, positionid) 
				select '${type}', ${rpid}, loginid, mobileNumber, positionid from v_review_pos where accOffice = ${accoffice} limit 5");
			
		} else {
			$wfid = $row->wfid;
		}
		
		return $this->wfdetail($wfid);
	}
/* 	public function createnew(){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$mode = 'RP';
		$periode = date('Ym');
		$type = 'Q';	
		$myid = $this->cas->getmycas_login($this->cas);
		
		//check if exists
		$row = $this->db->query("select * from xreviewpos where accoffice=? and periode=? and type=?",
				array($accoffice, $periode, $type))->row();
		$wfid = null;
		if (!isset($row)){
			$wfpp = (object) array('mode'=>$mode, 'accoffice'=>$accoffice, 'initiator'=>$myid);
			$wfid = $this->wfmodel->createnew($wfpp); 
			$xrev = array ('wfid'=>$wfid, 'type'=>$type, 'accoffice'=>$accoffice, 
				'periode'=>$periode);
			$istr = $this->db->insert_string("xreviewpos", $xrev);
			$query = $this->db->query($istr);
			$rpid  = $this->db->insert_id();
			
			$query = $this->db->query("insert into revdraft(type, reqid, loginid, mobileNumber, positionid) 
				select '${type}', ${rpid}, loginid, mobileNumber, positionid from v_review_pos where accOffice = ${accoffice} limit 5");
			
		} else {
			$wfid = $row->wfid;
		}
		
		return $this->wfdetail($wfid);
	} */
	
	public function possibleAction($wf, $actor){
		$eligable = array();
		
		log_message('debug', print_r(array('wf'=>$wf), TRUE));
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
		$myid = $this->cas->getmycas_login($this->cas);
		log_message('debug', print_r(array("xcp.wfaction"=>$fdt), TRUE)); 
		
		
		$direction = 0;
		if (preg_match('/(submit|approve|save)/',$fdt['reqtype']))
			$direction = 1;
		if (preg_match('/(reject|cancel)/',$fdt['reqtype']))
			$direction = -1;
		if ($direction == 0){
			if (preg_match('/(release)/',$fdt['reqtype'])){
				$ret = $this->wfmodel->releasejob($myid,$wfid);
			}
		} else {
			$myid = $this->session->userdata('pengguna')->loginid;
			$ret = $this->wfmodel->action($myid,$wfid, $direction, $fdt['notes']);
		}
		return $ret;
	}
	
	private function rpositemdetail($id){
		$row = $this->db->query("select rd.*, vln.name, vln.posname from revdraft rd left join v_login_name vln on vln.loginid = rd.loginid where rd.id=?", array($id))->row();
		return $row;
	}
	
	public function rpositem(){
		$fdt = $this->input->post();
		$row = null;
		if (preg_match('/(readitem)/',$fdt['reqtype'])){
			$row = $this->rpositemdetail($fdt['id']);
		} else if (preg_match('/(save)/',$fdt['reqtype'])){
			$uarr = array('loginid'=>$fdt['loginid'], 'positionid'=>$fdt['positionid'], 
				'mobileNumber'=>$fdt['mobileNumber'], 'status'=>'U');
			$ustr = $this->db->update_string("revdraft", $uarr, "id=".$fdt['id']);
			$this->db->query($ustr);
			
			$row = $this->rpositemdetail($fdt['id']);
		}
		return $row;
	}
} 