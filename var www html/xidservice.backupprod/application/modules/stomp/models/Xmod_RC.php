<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_RC extends CI_Model {

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
				$rpos = $this->db->query("select * from xrequest xr where xr.reqid = ?", array(intval($id)))->row();
				log_message('debug', print_r(array('ua.wfdetail.rpos'=>$rpos), TRUE));
				if (isset($rpos->detail)){
					$dataarr = json_decode($rpos->detail, false);
					foreach($dataarr as $key => $value){		
						$apps = [];
						$ca[]= $value;
						$val=[];
						
						foreach($value as $k => $v){
/* 							$val[]= $v;
							$apps[] = $k; */
							$req_rc[]= array(
								'app' => $k, 
								'val_app' => $v
						   );
						}
						/* $list [] = array("",$key, $ap ,$isi); */

					}
					$data2 = $this->db->query("select vl.DOB as dob, vp1.icons,vl.name , vp1.name as nama, vp1.positionid, vp1.accOffice  from v_login_previlegde1 vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid
			where vl.loginid =?", array($key))->row();
					$rpos->nama = $data2->name;	
					$rpos->pname = $data2->nama;	
					$rpos->loginid = $key;	
					$rpos->positionid = $data2->positionid;	
					//$rpos->isi = $req_rc;	
					//var_dump($apps);
					//$a = array_pop($dataarr);
					//var_dump(json_encode($list));
					
					$rpos->data = $req_rc;
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
		$mode = 'RC';
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
					$eligable[] = "add";
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
		$str = json_decode($fdt ['data'],true);
			$app = $str["apps"]; 
			$val   = $str["req"];
			
			foreach( $app as $index => $apps ) {
				if($apps == "webmail"){
					$apps = "ldapAccount_oid";			
				} else if($apps == "icons"){
					$apps = "banc";			
				}
			   $data_app[$apps]=$val[$index];
			}
		$opts[$fdt['loginid']] = $data_app;
		$detail = json_encode($opts);
		if (preg_match('/save/',$fdt['reqtype'])){
			$wfdetail = $this->createnew();
			//var_dump($wfdetail);
			$wfid = $wfdetail->id;

			//var_dump($detail);
			// $dataarr = array('srctype'=>$fdt ['srctype'], 'detail'=>$detail, 'doc_date'=>$fdt ['doc_date'], 'accoffice'=>$accoffice, 'key1'=>$fdt ['nosr']);
			
			$dataarr = array('srctype'=>'ss', 'accoffice'=>$accoffice, 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'doc_date'=>$doc_date, 'key1'=>$inc);
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
			if($reqtype == 'sr'){
				$dataarr = array('srctype'=>$fdt ['reqtype'],'accoffice'=>$accoffice, 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$nosr);
			} else {
				$dataarr = array('srctype'=>$fdt ['reqtype'], 'accoffice'=>$accoffice,'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$inc);
			}
			//$dataarr = array('srctype'=>$fdt ['srctype'], 'detail'=>$detail, 'doc_date'=>$fdt ['doc_date'], 'key1'=>$fdt ['nosr']);
		log_message('debug', print_r(array("Direction"=>$wfid), TRUE));
/* 		$datastr = json_encode($dataarr);
		$accoffice = $_SESSION['pengguna']->accoffice;
		$xcp = array('type'=>'RS', 'accoffice'=>$accoffice,'status'=>'I',
				'data'=> $datastr);			
 */		$ustr = $this->db->update_string('xrequest', $dataarr, 'reqid=' . $fdt['id']  );
		$this->db->query($ustr);
		
		if (preg_match('/submit/',$fdt['reqtype'])){
			// $dataarr = array('req_stat'=>'I', 'detail'=>$detail, 'doc_date'=>$fdt ['doc_date'], 'key1'=>$fdt ['nosr'], 'srctype'=>$fdt ['srctype']);
			$dataarr = array('srctype'=>'ss', 'detail'=>$detail, 'reqid'=>$wfid, 'accoffice'=>$accoffice, 'req_stat'=>'I', 'doc_date'=>$doc_date, 'key1'=>$inc);
			
			$ustr = $this->db->update_string('xrequest', $dataarr, 'reqid=' . $wfid  );
			$this->db->query($ustr);
			$wf = $this->wfmodel->getwfinfo($wfid);
						$direction = 1;
		}	
		if (preg_match('/approve/',$fdt['reqtype'])){
			
			$dataarr = array('req_flag'=>'P');
			$ustr = $this->db->update_string('xrequest', $dataarr, 'reqid=' . $wfid  );
			$this->db->query($ustr);
			$myid_apprv = $_SESSION['pengguna']->loginid;
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