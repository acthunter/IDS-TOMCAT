<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_RS extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->initparam();
		$this->load->model('xwf_model', 'wfmodel');
	}
	private function initparam(){
		$this->apps_list = array(
				"b24"=>array("apps"=>"b24","app_num"=>"1"),
				"icons"=>array("apps"=>"icons","app_num"=>"2"),
				"ska_icons"=>array("apps"=>"ska_icons","app_num"=>"3"),
				"skcdm_icons"=>array("apps"=>"skcdm_icons","app_num"=>"4"),
				"new_ska"=>array("apps"=>"new_ska","app_num"=>"5"),
				"skcdm"=>array("apps"=>"skcdm","app_num"=>"6"),
				"swift"=>array("apps"=>"swift","app_num"=>"7"),
				"srp"=>array("apps"=>"srp","app_num"=>"8"),
				"crm"=>array("apps"=>"crm","app_num"=>"9"),
				"ibank"=>array("apps"=>"ibank","app_num"=>"10"),
				"periskop"=>array("apps"=>"periskop","app_num"=>"11"),
				"tiplus"=>array("apps"=>"tiplus","app_num"=>"13"),
				"bar"=>array("apps"=>"bar","app_num"=>"14"),
				"sar"=>array("apps"=>"sar","app_num"=>"15"),
				"wom"=>array("apps"=>"wom","app_num"=>"16"),
				"bisss_jitu"=>array("apps"=>"bisss_jitu","app_num"=>"17"),
				"bisss_depox"=>array("apps"=>"bisss_depox","app_num"=>"18"),
				"svsonline"=>array("apps"=>"svsonline","app_num"=>"23"),
				"irs_online"=>array("apps"=>"irs_online","app_num"=>"24"),
				"cmod"=>array("apps"=>"cmod","app_num"=>"25"),
				"fund_separation"=>array("apps"=>"fund_separation","app_num"=>"26"),
				"cardlink"=>array("apps"=>"cardlink","app_num"=>"27"),
				"epurse"=>array("apps"=>"epurse","app_num"=>"28"),
				"cbest"=>array("apps"=>"cbest","app_num"=>"29"),
				"orchid"=>array("apps"=>"orchid","app_num"=>"30"),
				"bancss"=>array("apps"=>"bancss","app_num"=>"31"),
				"smpk"=>array("apps"=>"smpk","app_num"=>"32"),
				"oase"=>array("apps"=>"oase","app_num"=>"33"),
				"wic"=>array("apps"=>"wic","app_num"=>"34"),
				"gotrade"=>array("apps"=>"gotrade","app_num"=>"35"),
				"globs"=>array("apps"=>"globs","app_num"=>"36"),
				"skcrm_icons"=>array("apps"=>"skcrm_icons","app_num"=>"37"),
				"channel_manager"=>array("apps"=>"channel_manager","app_num"=>"38"),
				"tass"=>array("apps"=>"tass","app_num"=>"39"),
				"bps"=>array("apps"=>"bps","app_num"=>"40"),
				"mols"=>array("apps"=>"mols","app_num"=>"41"),
				"web_portal"=>array("apps"=>"web_portal","app_num"=>"42")
		);
	}
	
	public function wfdetail($id){
		if ($id!=null){
			$wf = $this->wfmodel->getwfinfo($id);
			log_message('debug', print_r(array('ua.wfdetail.wf'=>$wf), TRUE));
			if ($wf != null){
				$rpos = $this->db->query("select id,reqid,detail,srctype,key1, key0,doc_date from xrequest xr where xr.reqid = ?", array(intval($id)))->row();
				log_message('debug', print_r(array('ua.wfdetail.rpos'=>$rpos), TRUE));
				if (isset($rpos->detail)){
					$dataarr = json_decode($rpos->detail, false);
					foreach($dataarr as $key => $value){		
						$apps = [];
						$ca[]= $value;
						$val=[];
						$count = 1;
						
						foreach($value as $k => $v){
							$val[]= $v;
							$apps[] = $k;
							$iduser = (((int)$key * pow(10, 4))+  (int)$this->apps_list[$k]["app_num"]);
							$listrow = $this->db->query('select sloginid from appsuser where iduser=?', array ($iduser))->row();
							$list [] = array($count,$key, $listrow->sloginid, $k ,$v);
							
							
						}
						$count++;
					}
					$rpos->isi = $list;	
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
		$mode = 'RS';
		//$myid = $this->cas->getmycas_login($this->cas);
		$myid = $_SESSION['pengguna']->loginid;
		
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
		$wfid = $fdt['wfid'];
		$reqtype = $fdt['reqtype'];
		$accoffice = $fdt['accoffice'];
		$inc = $fdt['inc'];
		$doc_date = $fdt['doc_date'];
		$myid = $_SESSION['pengguna']->loginid;
		log_message('debug', print_r(array("xcp.wfaction"=>$myid), TRUE)); 
		
		if (preg_match('/save/',$fdt['reqtype'])){
			$wfdetail = $this->createnew();
			//var_dump($wfdetail);
			$wfid = $wfdetail->id;
			$str = json_decode($fdt ['app'],true);
			foreach($str as $key => $value){
				$opts[$value["npp"]] = array_combine(explode(",",$value["apps"]), explode(",",$value["req"])) ;
			}
			$detail = json_encode($opts);
			//var_dump($detail);
			// $dataarr = array('srctype'=>$fdt ['srctype'], 'detail'=>$detail, 'doc_date'=>$fdt ['doc_date'], 'accoffice'=>$accoffice, 'key1'=>$fdt ['nosr']);
			
			if($reqtype == 'sr'){
				$dataarr = array('srctype'=>$fdt ['reqtype'], 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$nosr, 'det_mail'=>$edetail);
			} else {
				$dataarr = array('srctype'=>$fdt ['reqtype'], 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$inc, 'det_mail'=>$edetail);
			}
			log_message('debug', print_r(array("data"=>$dataarr), TRUE));
			/* $datastr = json_encode($dataarr);
			$accoffice = $_SESSION['pengguna']->accoffice;
			$xcp = array('type'=>'RS', 'accoffice'=>$accoffice,'status'=>'I',
					'data'=> $datastr); */			
			$ustr = $this->db->update_string('xrequest', $dataarr, 'reqid =' . $wfdetail->id  );
			$ret = $this->db->query($ustr);
			log_message('debug', print_r(array('save.xcp'=>$ustr), TRUE));
		}
		
		$direction = 0;		
			$str = json_decode($fdt ['app'],true);
			foreach($str as $key => $value){
				$opts[$value["npp"]] = array_combine(explode(",",$value["apps"]), explode(",",$value["req"])) ;
			}
			$detail = json_encode($opts);
			/* foreach($str as $key => $value){
				$e[$value["npp"]] = array("email"=>$value["email"]);
				//var_dump($value["email"]);
			}
			$edetail = json_encode($e); */
/* 			if($reqtype == 'sr'){
				$dataarr = array('srctype'=>$fdt ['reqtype'], 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$nosr);
			} else {
				$dataarr = array('srctype'=>$fdt ['reqtype'], 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$inc);
			} */
			//$dataarr = array('srctype'=>$fdt ['srctype'], 'detail'=>$detail, 'doc_date'=>$fdt ['doc_date'], 'key1'=>$fdt ['nosr']);
		log_message('debug', print_r(array("Direction"=>$wfid), TRUE));
/* 		$datastr = json_encode($dataarr);
		$accoffice = $_SESSION['pengguna']->accoffice;
		$xcp = array('type'=>'RS', 'accoffice'=>$accoffice,'status'=>'I',
				'data'=> $datastr);			
 */		/* $ustr = $this->db->update_string('xrequest', $dataarr, 'reqid=' . $fdt['id']  );
		$this->db->query($ustr); */
		
		if (preg_match('/submit/',$fdt['reqtype'])){
			// $dataarr = array('req_stat'=>'I', 'detail'=>$detail, 'doc_date'=>$fdt ['doc_date'], 'key1'=>$fdt ['nosr'], 'srctype'=>$fdt ['srctype']);
			if($reqtype == 'sr'){
				$dataarr = array('srctype'=>$fdt ['reqtype'], 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$nosr, 'det_mail'=>$edetail);
			} else {
				$dataarr = array('srctype'=>$fdt ['reqtype'], 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$inc, 'det_mail'=>$edetail);
			}
			
			$ustr = $this->db->update_string('xrequest', $dataarr, 'reqid=' . $wfid  );
			$this->db->query($ustr);
			$wf = $this->wfmodel->getwfinfo($wfid);
			$direction = 1;
		}	
		if (strpos($fdt['reqtype'], 'approve') !== false){
			$xreq = $this->db->query("select id from xrequest xr where xr.reqid = ?", array($wfid))->row();

			$updtstring = array('req_flag'=>'P');
			$ustr = $this->db->update_string('xrequest', $updtstring, 'id=' . $xreq->id  );
			$this->db->query($ustr);
			
			$myid_apprv = $_SESSION['pengguna']->loginid;
			$date = new DateTime();
				$date->setTimezone(new DateTimeZone('Asia/Jakarta'));
			$time = $date->format('Y-m-d H:i:s');
			$xcpp = array('approval'=>$myid_apprv, 'dateappr'=> $time);			
			$ustr1 = $this->db->update_string('xwfparam', $xcpp, 'id=' . $fdt['wfid']  );
			$this->db->query($ustr1);
			
			foreach($str as $key => $value){
				foreach (array_combine(explode(",",$value["apps"]), explode(",",$value["user"])) as $rslt => $appsval) {
					$iduser = ((int)$value["npp"] * pow(10, 4))+  (int)$this->apps_list[$rslt]["app_num"];
					$idapp = (int)$this->apps_list[$rslt]["app_num"];
					$addapp = array('apps'=>(int)$this->apps_list[$rslt]["app_num"]);

					if($idapp == '17'){
						$this->db->delete('appsuser', array('iduser' => $iduser));
					}else{
						$sqladd = $this->db->update_string('appsuser', $addapp, 'iduser=' . $iduser  );
						$this->db->query($sqladd);
					}
					
					
				} 
			}
			$id = $this->db->insert_id();
			$detail = json_encode($opts);
			
			$myid_apprv = $_SESSION['pengguna']->loginid;
						$wf = $this->wfmodel->getwfinfo($wfid);
						$direction = 1;
		}	
		if (strpos($fdt['reqtype'], 'reject') !== false){
			/* $direction = -1;
 */			$updtparam = $this->db->query('UPDATE xwfparam SET stage = 0 WHERE id='. $wfid );
			$xreq = array('status'=> 'X', 'req_flag'=> null, 'req_stat'=> null);
			$updtxreq = $this->db->update_string('xrequest', $xreq, 'reqid=' . $wfid  );
			foreach($str as $key => $value){
				foreach (array_combine(explode(",",$value["apps"]), explode(",",$value["user"])) as $rslt => $appsval) {
					$iduser = ((int)$value["npp"] * pow(10, 4))+  (int)$this->apps_list[$rslt]["app_num"];
					$idapp = (int)$this->apps_list[$rslt]["app_num"];
					$addapp = array('apps'=>(int)$this->apps_list[$rslt]["app_num"]);
						$this->db->delete('appsuser', array('iduser' => $iduser,'apps' => null));
					
					
				} 
			}
			$this->db->query($updtxreq);
		
		}
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