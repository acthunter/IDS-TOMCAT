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
				"bancs"=>array("apps"=>"bancs","app_num"=>"31"),
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
				$rpos = $this->db->query("select * from xrequest xr where xr.reqid = ?", array(intval($id)))->row();
				log_message('debug', print_r(array('ua.wfdetail.rpos'=>$rpos), TRUE));
				if (isset($rpos->data)){
					$dataarr = json_decode($rpos->data, false);
					log_message('debug', print_r(array('ua.wfdetail.dataarr'=>$dataarr), TRUE));
					/*$posrow = $this->db->query('select name from xposition where positionid=?', array ($dataarr->tpos))->row();
					$listrow = $this->db->query('select name, positionid, posname, mobileNumber from v_login_name where loginid=?', array ($dataarr->loginid))->row();
					if(isset($posrow->data)){
						if(isset($listrow->data)){
					$dataarr->nama = $listrow->name;
					$dataarr->cposname = $listrow->posname;
					$dataarr->cposid = $listrow->positionid;
					$dataarr->mobileNumber = $listrow->mobileNumber;
					$dataarr->pname = $posrow->name;
					}}*/
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
		$mode = 'RS';
		//var_dump($app);
		$user = json_decode($app);
		foreach($user as $udata)
		{
			$query = $this->db->query("select * from v_login_previlegde1
			where loginid =?", array($udata->npp));
			$opts = array();
			$cpriv = $query->row();
			if ($cpriv == null){
				//var_dump($checkarr);
				$arry = explode(",",$udata->apps);
				//var_dump($arry);
				foreach($arry as $checkarr)
				{
					
					$pparam = $this->apps_list[$checkarr];
					$uxcp = array('NPP'=>$udata->npp, 'refid'=>$accoffice, 'sloginid'=>$udata->npp, 'apps'=>$pparam['app_num']);
					$datastr = $this->db->insert_string('appsuser', $uxcp);
					$this->db->query($datastr);
				}
			}
			

		} 
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
		$wfid = $fdt['reqid'];
		$reqtype = $fdt['reqtype'];
		$accoffice = $fdt['accoffice'];
		//$email = $fdt['email'];
		$doc_date = $fdt['doc_date'];
		$nosr = $fdt['nosr'];
		$inc = $fdt['inc'];
		$app = $fdt['app'];
		$myid = $_SESSION['pengguna']->loginid;
		//var_dump($myid);
		log_message('debug', print_r(array("xcp.wfaction"=>$myid), TRUE)); 
		
		/* if (preg_match('/submit/',$fdt['reqtype'])){ */
		if (preg_match('/submit/',$fdt['tipe_btn'])){
			$wfdetail = $this->createnew($app);
			$wfid = $wfdetail->id;
			$str = json_decode($fdt['app'],true);
			foreach($str as $key => $value){
				$opts[$value["npp"]] = array_combine(explode(",",$value["apps"]), explode(",",$value["req"]));			
				/* foreach($this->apps_list as $capps => $cval ){
					if (array_key_exists($capps, $cpriv) && $cpriv->$capps != null){
						$opts[$capps] = $cval;
					}
				} */
				foreach (array_combine(explode(",",$value["apps"]), explode(",",$value["user"])) as $rslt => $appsval) {
					$appuserarr = array('NPP'=>$value["npp"], 'refid'=>$fdt['accoffice'], 'sloginid'=>$appsval, 'priviledgeid'=>date('ymd'), 'iduser'=>((int)$value["npp"] * pow(10, 4))+  (int)$this->apps_list[$rslt]["app_num"], 'apps'=>NULL);					  
					//var_dump($appuserarr);
					$sql = $this->db->insert_string('appsuser', $appuserarr) . ' ON DUPLICATE KEY UPDATE priviledgeid='.date('ymd');
					$this->db->query($sql);
					$id = $this->db->insert_id();
				}
				
				
				/* $res = $arrp2.filter(function (el) {
				  return $arrp.indexOf(el) >= 0; 
				});
				var_dump($res); */
				/* foreach ( explode(",",$value["apps"]) as $appsval){
					$pparam = $this->apps_list->$appsval;
					var_dump($appsval);
					var_dump($pparam);
				} */
				
				
			}
			$detail = json_encode($opts);
			/* foreach($str as $key => $value){
				$e[$value["npp"]] = array("email"=>$value["email"]);
			}
			$edetail = json_encode($e); */
			//var_dump($edetail);
			 
			if($reqtype == 'sr'){
				$dataarr = array('srctype'=>$fdt ['reqtype'], 'key0'=>$fdt ['req'], 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$nosr);
			} else {
				$dataarr = array('srctype'=>$fdt ['reqtype'],'key0'=>$fdt ['req'], 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$inc);
			}
			$ustr = $this->db->update_string('xrequest', $dataarr, 'reqid =' . $wfdetail->id  );
			$ret = $this->db->query($ustr);
			log_message('debug', print_r(array('save.xcp'=>$ustr), TRUE));
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