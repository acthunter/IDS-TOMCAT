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
					$listrow = $this->db->query('select name, positionid, posname from v_login_name where loginid=?', array ($dataarr->loginid))->row();
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
		$accoffice = $fdt['accOffice'];
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
		$accoffice = $fdt['accOffice'];
		$id = $fdt['id'];
		$loginid = $fdt['loginid'];
		$myid = $_SESSION['pengguna']->loginid;
		log_message('debug', print_r(array("xcp.wfaction"=>$myid), TRUE)); 
		
		if (preg_match('/save/',$fdt['tipe_btn'])){
			$wfdetail = $this->createnew();
			$wfid = $wfdetail->id;	
			//log_message('debug', print_r(array("ua.wfaction.wfdetail"=>$wfdetail), TRUE)); 
			$data = $this->db->query("select xe.Name as nama, xe.DOB, xe.email, xe.mobileNumber, vl.positionid, vl.name from xemployee xe join v_login_previlegde1 vl on xe.npp = vl.loginid where  xe.npp ='".$fdt['loginid']."'");
			$crow = $data->row();
			$array = json_decode(json_encode($crow), True);
			if(isset($array)){
				/* var_dump($crow['nama']);
				var_dump($crow->nama);
				var_dump($crow); */
				$dataarr = array('npp'=>$fdt['loginid'], 'nama'=>$array['nama'], 'DOB'=>$array['DOB'], 'email'=>$array['email'], 'mobileNumber'=>$array['mobileNumber'], 'positionid'=>$array['positionid'], 'pname'=>$array['name']);
			}else{
				$dataarr = array('npp'=>$fdt['loginid'], 'nama'=>NULL, 'DOB'=>NULL, 'email'=>NULL, 'mobileNumber'=>NULL, 'positionid'=>NULL, 'pname'=>NULL);
			}
			//var_dump($dataarr);
			$datastr = json_encode($dataarr);
			//$accoffice = $_SESSION['pengguna']->accoffice;
			//$xcp = array('type'=>'UC', 'accoffice'=>$accoffice, 'status'=>'I', 'data'=> $datastr);
			$xcp = array('trid'=>$id, 'srctype'=>'UC', 'accOffice'=>$accoffice, 'status'=>'I', 'detail'=> $datastr);
			//log_message('debug', print_r(array('arr.xcp'=>$xcp), TRUE));
			$ustr = $this->db->update_string('xrequest', $xcp, 'reqid=' . $wfdetail->id  );
			$ret = $this->db->query($ustr);
			log_message('debug', print_r(array('save.xcp'=>$ustr), TRUE));
		}		
		
		$direction = 0;
		
		if (preg_match('/submit/',$fdt['tipe_btn'])){
			$wfdetail = $this->createnew();
			//var_dump($wfdetail);
			$wfid = $wfdetail->id;
			//var_dump($wfid);
			$str = json_decode($fdt ['app'],true);
			foreach($str as $key => $value){
				$opts[$value["npp"]] = array_combine(explode(",",$value["apps"]), explode(",",$value["req"])) ;
			}
			$detail = json_encode($opts);
			foreach($str as $key => $value){
				$e[$value["npp"]] = array("email"=>$value["email"]);
			}
			$edetail = json_encode($e);
			//var_dump($edetail);
			
			if($reqtype == 'sr'){
				$dataarr = array('srctype'=>$fdt ['reqtype'], 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$nosr, 'det_mail'=>$edetail);
			} else {
				$dataarr = array('srctype'=>$fdt ['reqtype'], 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$inc, 'det_mail'=>$edetail);
			}
			$ustr = $this->db->update_string('xrequest', $dataarr, 'reqid =' . $wfdetail->id  );
			$ret = $this->db->query($ustr);
			log_message('debug', print_r(array('save.xcp'=>$ustr), TRUE));
		}
		$direction = 1;		
			
		if (preg_match('/reject/',$fdt['tipe_btn']))
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