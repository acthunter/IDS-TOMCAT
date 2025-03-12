<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmain extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('xwf_model', 'wfmodel');
		$this->uapps_filter = array( 
				"54086"=>"skcdm_icons,skcdm,b24,new_ska,ska_icons,crm,prsk,eis",
				"37559"=>"bisss_depox",
				"21303"=>"skcdm_icons,skcdm,b24,new_ska,ska_icons,crm,prsk,eis",
				//"55720"=>"ska_iconsskcdm_icons,skcdm,b24,new_ska,ska_icons,crm,prsk,eis,banc,ldapAccount_oid,,crm,srp,bar",
				//"55720"=>"skcrm_icons,ska_icons,srp,tiplus,cardlink,bisss_jitu,bisss_depox,orchid,ibank,cmod,new_ska,gotrade,globs,bancss,epurse,b24",  
				"25311"=>"skcdm_icons,skcdm,b24,new_ska,ska_icons,crm,prsk,eis",
				//"3176"=>"swift,cbest,orchid,bancs,cardlink,epurse", 
				"60100"=>"web_portal,cardlinkv2,tass,b24,bisss_jitu,bisss_depox,cmod,ibank,fund_separation,swift,skcdm_icons,skcdm,new_ska,ska_icons,crm,prsk,eis,banc,tiplus,crm,srp,bar,irs_online,svsonline,sar,gotrade,globs,skcrm_icons,cbest,orchid,bancss,cardlink,epurse,channel_manager,bps",				
				//"94736"=>"bisss_jitu,bisss_depox,cmod,ibank,fund_separation,swift,skcdm_icons,skcdm,new_ska,ska_icons,crm,prsk,eis,banc,tiplus,crm,srp,bar,irs_online,svsonline,sar,gotrade,globs,skcrm_icons,cbest,orchid,bancs,cardlink,epurse,channel_manager,bps",				
				//"93702"=>"srp",
				//"94736"=>"cmod",
				"93702"=>"web_portal,tass,b24,bisss_jitu,bisss_depox,cmod,ibank,fund_separation,swift,skcdm_icons,skcdm,new_ska,ska_icons,crm,prsk,eis,banc,tiplus,crm,srp,bar,irs_online,svsonline,sar,gotrade,globs,skcrm_icons,cbest,orchid,bancs,cardlink,epurse,channel_manager,bps",				
				//"2911"=>"ibank,cmod,bisss_jitu,bisss_depox,b24,epurse,swift,cmod,gotrade,globs",
				"2911"=>"cardlink,b24,bisss_jitu,bisss_depox,cmod,ibank,fund_separation,swift,skcdm_icons,skcdm,new_ska,ska_icons,crm,prsk,eis,banc,tiplus,crm,srp,bar,irs_online,svsonline,sar,gotrade,globs,skcrm_icons,cbest,orchid,bancs,tass,epurse,channel_manager,bps",
				"94736"=>"srp",
				"65793"=>"cardlink,bancss,b24,web_portal,mols,bisss_depox,bisss_jitu,cmod,ibank,fund_separation,swift,skcdm_icons,skcdm,new_ska,ska_icons,crm,prsk,eis,banc,tiplus,crm,srp,bar,irs_online,svsonline,sar,gotrade,globs,skcrm_icons,cbest,orchid,bancs,tass,epurse,channel_manager,bps", 
				//"94736"=>"ibank, bisss_depox,bisss_jitu,gotrade,cmod",
				//"94736"=>"bisss_depox,epurse,b24,ibank,cmod,gotrade,globs,srp,bancss,tiplus,svsonline,irs_online,new_ska",  
				"57866"=>"web_portal,b24,cmod,bisss_jitu,bisss_depox",
				"61391"=>"web_portal,mols,svsonline,cardlink,cardlinkv2,b24,bisss_jitu,bisss_depox,cmod,ibank,fund_separation,swift,skcdm_icons,skcdm,new_ska,ska_icons,crm,prsk,eis,banc,tiplus,crm,srp,bar,irs_online,svsonline,sar,gotrade,globs,skcrm_icons,cbest,orchid,bancs,tass,epurse,channel_manager,bps",
				//"820649"=>"swift,ibank,srp,svsonline,cmod,mols,epurse,globs,gotrade,web_portal,tiplus,ska_icons,skcrm_icons",
				"822043"=>"ibank,srp,svsonline,cmod,mols,epurse,globs,gotrade,web_portal,tiplus,ska_icons,skcrm_icons",
				//"900028"=>"ibank,srp,svsonline,cmod,mols,epurse,globs,gotrade,web_portal,tiplus,ska_icons,skcrm_icons",
				"821945"=>"ibank,srp,cmod,mols,globs,gotrade,web_portal,tiplus,ska_icons,skcrm_icons",
				//"64626"=>"ibank,srp,svsonline,cmod,globs,gotrade,web_portal,tiplus",
				"64626"=>"web_portal,bisss_jitu,mols,bisss_depox,cardlink,skcrm_icons,channel_manager,epurse,swift,svsonline,skcdm_icons,ibank,skcdm,b24,new_ska,ska_icons,tiplus,crm,srp,bar,irs_online,cmod,new_ska,skcdm_icons,globs,gotrade",

				"23409"=>"b24,cardlinkv2,web_portal,mols,tass,bisss_jitu,bisss_depox,cmod,ibank,fund_separation,swift,skcdm_icons,skcdm,new_ska,ska_icons,crm,prsk,eis,banc,tiplus,crm,srp,bar,irs_online,svsonline,sar,gotrade,globs,skcrm_icons,cbest,orchid,bancs,cardlink,epurse,channel_manager,bps",
				//"23409"=>"cardlink,tiplus,channel_manager,ibank",
				"821416"=>"b24,web_portal,mols,cmod,ibank,fund_separation,swift,skcrm_icons,skcdm_icons,skcdm,new_ska,ska_icons,tiplus,srp,irs_online,svsonline,globs,gotrade,epurse,channel_manager,bps", 
				"67038"=>"cardlink,cardlinkv2,b24,web_portal,mols,cmod,ibank,fund_separation,swift,skcrm_icons,skcdm_icons,skcdm,new_ska,ska_icons,tiplus,srp,irs_online,svsonline,globs,gotrade,epurse,channel_manager,bps", 
				"94480"=>"web_portal,cmod,ibank,fund_separation,swift,skcrm_icons,skcdm_icons,skcdm,new_ska,ska_icons,tiplus,srp,irs_online,svsonline,globs,gotrade,epurse,channel_manager,bps", 
				"95457"=>"bancss,b24,web_portal,mols,bisss_depox,bisss_jitu,cmod,ibank,fund_separation,swift,skcdm_icons,skcdm,new_ska,ska_icons,crm,prsk,eis,banc,tiplus,crm,srp,bar,irs_online,svsonline,sar,gotrade,globs,skcrm_icons,cbest,orchid,bancs,tass,epurse,channel_manager,bps", 
				"900028"=>"bancss,b24,web_portal,mols,bisss_depox,bisss_jitu,cmod,ibank,fund_separation,swift,skcdm_icons,skcdm,new_ska,ska_icons,crm,prsk,eis,banc,tiplus,crm,srp,bar,irs_online,svsonline,sar,gotrade,globs,skcrm_icons,cbest,orchid,bancs,tass,epurse,channel_manager,bps", 
				"821338"=>"bancss,b24,web_portal,mols,bisss_depox,bisss_jitu,cmod,ibank,fund_separation,swift,skcdm_icons,skcdm,new_ska,ska_icons,crm,prsk,eis,banc,tiplus,crm,srp,bar,irs_online,svsonline,sar,gotrade,globs,skcrm_icons,cbest,orchid,bancs,tass,epurse,channel_manager,bps", 
				"900547"=>"web_portal,cmod,ibank,skcdm_icons,skcdm,new_ska,ska_icons,tiplus,crm,srp,svsonline,gotrade,globs,skcrm_icons,epurse", 
				"63641"=>"web_portal,mols,cardlink,cardlinkv2,b24,bisss_jitu,bisss_depox,cmod,ibank,fund_separation,swift,skcdm_icons,skcdm,new_ska,ska_icons,crm,prsk,eis,banc,tiplus,crm,srp,bar,irs_online,svsonline,sar,gotrade,globs,skcrm_icons,cbest,orchid,bancs,tass,epurse,channel_manager,bps",
				"62542"=>"web_portal,bisss_jitu,mols,bisss_depox,cardlink,cardlinkv2,skcrm_icons,channel_manager,epurse,swift,svsonline,skcdm_icons,ibank,skcdm,b24,new_ska,ska_icons,tiplus,crm,srp,bar,irs_online,cmod,new_ska,skcdm_icons,globs,gotrade",
				"94406"=>"web_portal,tiplus,swift",
				"821417"=>"web_portal,mols",
				
			);
	} 
	
	public function show_form($myid)
	{	
		$appfilter = array_key_exists($myid, $this->uapps_filter) ? $this->uapps_filter[$myid] : "";
		$this->page->template('site_tpl');
		$this->page->view("v_getpass", array('appfilter'=>$appfilter));
	}	
	
	public function index(){
		$myid = $this->cas->getmycas_login(array('idm_idadmin'));
		if ($this->input->method(TRUE) == 'GET'){
			$fmdata = $this->input->get();
			return $this->show_form($myid);
		}
		else {
			$fmdata = $this->input->post();
			log_message('debug', print_r(array("getpass.user_h.1"=>$fmdata), TRUE));
			$uniqid = uniqid("");
			if ($fmdata['reqtype'] == 'update'){
					
					$rdetail = array("filter"=>$fmdata['filter'],"actor"=>$myid, "next"=> $fmdata['next']);
									
					if (array_key_exists("repoid", $fmdata)){
						$rdetail['repoid'] = $fmdata['repoid'];
						$rdetail["status"] = $fmdata['status']; //0|1
						$rdetail["notes"]=$fmdata['notes'];
						if ($fmdata['status'] == '1'){
						$repoid = $fmdata['repoid'];
						$dt = $this->db->query("SELECT rp.userid as uid, rp.target as app, xe.Name as name FROM transitRepo rp JOIN xemployee xe ON rp.userid = xe.NPP WHERE rp.id = " . $repoid);
						$npp = $dt->row()->uid;
						$dt_mail = $this->db->query("SELECT email as mail_addr FROM xemployee xe WHERE xe.NPP = " . $npp);
						$mail_addr = $dt_mail->row()->mail_addr;
						log_message('debug', print_r(array("mail_address"=>$mail_addr), TRUE));
						$target = $dt->row()->app;
						$name = $dt->row()->name;
						$type = $fmdata['reqtype'];
						$this->load->library('sendmail');
						$this->sendmail->htmlmail($type, $npp, $target, $name, $mail_addr);
						}
					}
					$sdata = array("reqtype"=>'updateTransitRepo', "detail"=>json_encode($rdetail));
					$this->load->library('restclient', array());
					$dest_url = $this->config->item('cas_url') . 'frontend/target';
					$breply = $this->restclient->post($dest_url, $sdata);
					//$test = $breply;
					//$test1 = $test['rmap'];
					//log_message('debug', print_r(array("breply1"=>$test), TRUE));
					//log_message('debug', print_r(array("breply2"=>$test1), TRUE));

					/* $isSendMail = false;
					if (array_key_exists("update_result", $breply))
						$isSendMail = true;
					
					if ($isSendMail){
						$this->load->library('sendmail');
						$this->sendmail->htmlmail2();
					} */
					
					/* if ($test1['status'] != 'no more resources' ){
						
					} */
					$target = array_column($breply,'target');
					if (($target[0] == "cardlink") or ($target[0] == "b24") or ($target[0] == "bisss_jitu") or ($target[0] == "epurse")){
						$logid = array_column($breply,'loginid');
						$queryslog = $this->db->query("select sloginid from v_uamuser where loginid =? and apps =? ", array($logid, $target));	
						$rest = $queryslog->row();
						$breply['rmap']['loginid']= $rest->sloginid;
					}
					
					echo json_encode($breply);
				
			} else {
				$rdetail = array("filter"=>$fmdata['filter'],"actor"=>$myid, "next"=> $fmdata['next'], 
				"repoid"=> $fmdata['repoid'], "given_login"=> $fmdata['given_login'], 
				"given_trx"=> $fmdata['given_trx'], "waktu"=> $fmdata['waktu']);
				log_message('debug', print_r(array("rdetail"=>$rdetail), TRUE));
				$sdata = array("reqtype"=>'updateTransitRepo', "detail"=>json_encode($rdetail));
					$this->load->library('restclient', array());
					$dest_url = $this->config->item('cas_url') . 'frontend/target';
					$breply = $this->restclient->post($dest_url, $sdata);
					$target = array_column($breply,'target');
					if ($target[0] == "cardlink" or ($target[0] == "b24")){
						$logid = array_column($breply,'loginid');
						$queryslog = $this->db->query("select sloginid from v_uamuser where loginid =? and apps =? ", array($logid, $target));	
						$rest = $queryslog->row();
						$breply['rmap']['loginid']= $rest->sloginid;
					}
					echo json_encode($breply);
			}
		}
	}
	
	public function load_req()
	{	
		$myid = $this->cas->getmycas_login(array('idm_idadmin', 'idm_super'));
		$this->page->template('site_tpl');
		$this->page->view('v_request');
	}
	
	public function load_reqappr()
	{	
		$myid = $this->cas->getmycas_login(array('idm_idadmin', 'idm_super'));
		$this->page->template('site_tpl');
		$this->page->view('v_monitoringappr');
	}
	
	public function getreqappr(){
		$list = $this->wfmodel->getreqappr(); 
		foreach ($list as $row){
			$app = explode(",",$row->apps);
			$val   = explode(",",$row->req);
			$data_app = [];
			foreach( $app as $index => $apps ) {
				if($apps == "ldapAccount_oid"){
					$apps = "webmail";			
				} else if($apps == "banc"){
					$apps = "icons";			
				}else if($apps == "prsk"){
					$apps = "Periskop";			
				}
				if ($val[$index] ="RST"){
					$val_req = 'Reset';
				}else{
					$val_req = 'Create';
				}
			  $data_app[] = $apps.' : '.$val_req;
			}
				$aa[] = array(
					'id'=>$row->id,
					'nosrt'=>$row->nosrt,
					'tglsrt'=>$row->tglsrt,
					'tglreq' => $row->tglreq,
					'requestor' => $row->requestor,
					'name' => $row->name,
					'stage' => $row->stage
				);
			
		}
		if (isset ($aa)){
		$list = $aa;
		//var_dump($list);
		$output = array(
            "recordsTotal" => $this->wfmodel->count_allreq2(),
            "recordsFiltered" => $this->wfmodel->count_allreq2(),
            "data" => $list
        );
		}else{
			$output = array(
			"recordsTotal" => $this->wfmodel->count_allreq2(),
            "recordsFiltered" => $this->wfmodel->count_allreq2(),
            "data" => 0
        );
		}
		echo json_encode($output);
	}
	
	public function getreq(){
		$list = $this->wfmodel->getreq(); 
		
		foreach ($list as $row){
			$app = explode(",",$row->apps);
			$val   = explode(",",$row->req);
			$statpass   = explode(",",$row->sendpass);
			$data_app = [];
			foreach( $app as $index => $apps ) {
				if($apps == "ldapAccount_oid"){
					$apps = "webmail";			
				} else if($apps == "banc"){
					$apps = "icons";			
				}else if($apps == "prsk"){
					$apps = "Periskop";			
				}
				
				if ($val[$index] == 'RST'){
					$val_req = 'Reset';
				}else{
					$val_req = 'Create';
				}
				
			  $data_app = $apps.' : '.$val_req;
			  if ($row->idpass == null){
				  $aa = "";
			  }else{
					if ($row->tgl_kirim == null){
					  $tglkirim= "-";
					}else{
						$tglkirim=date('Y-m-d H:i',strtotime( $row->tgl_kirim ));
						}
				$aa[] = array(
					'no_srt'=>$row->key1,
					'id'=>$row->idpass,
					'reqid'=>$row->reqid,
					//'tgl_srt' => $row->doc_date,
					'tgl_srt' => $tglkirim,
					'tgl_request' =>  date('Y-m-d H:i',strtotime( $row->order_time )),
					'user_req' => $row->loginid,
					'unit' => $row->accOffice,
					'status' => $row->status,
					'stat' => $row->qid,
					'typereq' => $row->typereq,
					'apps' => $data_app,
					'statpass' =>  $statpass[$index],
					'userlock' =>  $row->userlock,
					'received' => date('Y-m-d H:i',strtotime( $row->dateReceived )) 
						
				);
			  }
			}
		}
		if (isset ($aa)){
		$list = $aa;
		//var_dump($list);
		$output = array(
            "recordsTotal" => $this->wfmodel->count_allreq(),
            "recordsFiltered" => $this->wfmodel->count_allreq(),
            "data" => $list
        );
		}else{
			$output = array(
			"recordsTotal" => $this->wfmodel->count_allreq(),
            "recordsFiltered" => $this->wfmodel->count_allreq(),
            "data" => 0
        );
		}
		echo json_encode($output);
	}
	public function resend(){
		/* $fdt = $this->input->post();
		$wfid = $fdt['id'];
		$list = $this->wfmodel->resendmail($wfid);
		
		echo json_encode($list); */
		$fdt = $this->input->post();
		$loginid = $fdt['loginid'];
		$reqid = $fdt['reqid'];
		$list = $this->wfmodel->resendmail($loginid, $reqid);
		echo json_encode($list);
	}
	public function process(){
		$fdt = $this->input->post();
		$loginid = $fdt['loginid'];
		$reqid = $fdt['reqid'];
		$list = $this->wfmodel->processpass($loginid, $reqid);
		echo json_encode($list);
	}
	public function nextpass(){
		$fdt = $this->input->post();
		//$loginid = $fdt['loginid'];
		$id = $fdt['id'];
		$list = $this->wfmodel->nextpass($id);
		echo json_encode($list);
	}
	public function reloadlist(){
		/* $fdt = $this->input->post();
		$wfid = $fdt['id'];
		$list = $this->wfmodel->resendmail($wfid);
		
		echo json_encode($list); */
		$fdt = $this->input->post();
		$loginid = $fdt['loginid'];
		$reqid = $fdt['reqid'];
		$list = $this->wfmodel->reloadlist($loginid, $reqid);
		echo json_encode($list);
	}
	public function reloadval(){
		$fdt = $this->input->post();
		$loginid = $fdt['loginid'];
		$reqid = $fdt['reqid'];
		$list = $this->wfmodel->reloadval($loginid, $reqid);
		echo json_encode($list);
	}
	
	public function randpass(){
		$fdt = $this->input->post();
		$loginid = $fdt['loginid'];
		$reqid = $fdt['reqid'];
		$list = $this->wfmodel->randompass($loginid, $reqid);
		echo json_encode($list);
	}
	
	 /* -------------------------------------------------------Log Update SSO -------------------------------------------------------------*/
	
	public function load_logupdt()
	{	
		$myid = $this->cas->getmycas_login(array('idm_idadmin', 'idm_super'));
		$this->page->template('site_tpl');
		$this->page->view('v_logupdate');
	}
	public function load_detail()
	{	
		$response = $this->load->view('v_detailupdate',true);
		echo($response);
	}
	public function getdetail(){
		$fdt = $this->input->post();
		$id = $fdt['id'];
		$list = $this->wfmodel->getdetail($id);
		foreach ($list as $row){
				$aa = json_decode($row->reqdata,true);
				$nameposold = $this->wfmodel->getnamepos($aa['posisi_old']);
				
				$nameuntold = $this->wfmodel->getnameunit($aa['unit_old']);
				if ($aa['unit_new'].length > 0){
				$nameuntnew = $this->wfmodel->getnameunit($aa['unit_new']);
				$aa['unit_new'] = $nameuntnew;
				}
				if ($aa['posisi_new'].length > 0){
				$nameposnew = $this->wfmodel->getnamepos($aa['posisi_new']);
				$aa['posisi_new'] = $nameposnew;
				$aa['unit_new'] = $nameuntnew;
				}
				$aa['ket'] = $row->ket;
				$aa['posisi_old'] = $nameposold;
				
				$aa['unit_old'] = $nameuntold;
				
		}
		echo json_encode($aa);
	}
	public function getlog(){
		$list = $this->wfmodel->getlog(); 

		foreach ($list as $row){
			//var_dump($row);
				$aa[] = array(
					'id'=>$row->id,
					'tgl_ubah'=>date('Y-m-d',strtotime( $row->date )),
					'userid' => $row->userid,
					'nama' => $row->namauserid,
					'npp_user' => $row->loginid,
					'nama_user' => $row->Nama
					
				);
			
		}
		if (isset ($aa)){
		$list = $aa;
		//var_dump($list);
		$output = array(
            "recordsTotal" => $this->wfmodel->count_alllog(),
            "recordsFiltered" => $this->wfmodel->count_alllog(),
            "data" => $list
        );
		}else{
			$output = array(
			"recordsTotal" => $this->wfmodel->count_alllog(),
            "recordsFiltered" => $this->wfmodel->count_alllog(),
            "data" => 0
        );
		}
		echo json_encode($output);
	}
			/* -------------------------------------------- List Request Resign ----------------------------------- */
	
	
		public function load_reqresign()
	{	
		$myid = $this->cas->getmycas_login(array('idm_idadmin', 'idm_super'));
		$this->page->template('site_tpl');
		$this->page->view('v_reqresign');
	}
	
	public function getreqresign(){
		$fdt = $this->input->post();
		$status = $fdt['status'];
		
		$list = $this->wfmodel->getreqresign(); 
		
		foreach ($list as $row){
		
			$modify = $row->reqmodify;
			if ($modify == null){
				$reqmodify = $row->reqmodify;
			}else{
				$reqmodify = date('Y-m-d',strtotime( $modify ));
			}
				if ($row->stage == 'X'){
					$stage = '0';
				}else if($row->stage == 'K'){
					$stage = '1';
				}
				
			  if ($row->NPP == null){
				  $list_resign = "";
			  }else{
				/* $list_resign[] = array(
					'id'=>$row->id,
					'NPP'=>$row->NPP,
					'nama'=>$row->nama,
					'posisi'=>$row->posisi,
					'kodeunit'=>$row->kodeunit,
					'reqmodify'=>$reqmodify,
					'assignee'=>$row->assignee,
					'tgl_request' =>  date('Y-m-d H:i',strtotime( $row->sdate ))

						
				); */
				
				$list_resign[] = array(
					'id'=>$row->id,
					'NPP'=>$row->NPP,
					'nama'=>$row->nama,
					'posisi'=>$row->posisi,
					'kodeunit'=>$row->kodeunit,
					'reqmodify'=>$reqmodify,
					'assignee'=>$row->assignee,
					'poscode'=>$row->poscode,
					'stage'=>$stage,
					'tgl_request' =>  date('Y-m-d H:i',strtotime( $row->sdate ))

						
				);
			  }
			}

		

		if (isset ($list_resign)){
		$output = array(
            "recordsTotal" => $this->wfmodel->count_allreqres(),
            "recordsFiltered" => $this->wfmodel->count_allreqres(),
            "data" => $list_resign
        );
		}else{
			$output = array(
			"recordsTotal" => $this->wfmodel->count_allreqres(),
            "recordsFiltered" => $this->wfmodel->count_allreqres(),
            "data" => 0
        );
		}
		
		echo json_encode($output);
	}
	public function process_delete(){
			$fdt = $this->input->post();
			$loginid = $fdt['loginid'];
			$reqid = $fdt['reqid'];
			$listdel = $this->wfmodel->processdel($loginid, $reqid);
			echo json_encode($listdel);
		
	}
	public function process_lock(){
		$fdt = $this->input->post();
		$loginid = $fdt['loginid'];
		$reqid = $fdt['reqid'];
		$listlock = $this->wfmodel->processlock($loginid, $reqid);
		echo json_encode($listlock);
	}
	public function cancelreq(){ 
		$fdt = $this->input->post();
		$loginid = $fdt['loginid'];
		$reqid = $fdt['reqid'];
		$listlock = $this->wfmodel->cancelreq($loginid, $reqid);
		echo json_encode($listlock);
	}
	
	
	public function deletereq(){
		$fdt = $this->input->post();
	
			$loginid = $fdt['loginid'];
			$reqid = $fdt['reqid'];
			$list = $this->wfmodel->batalreq($loginid, $reqid);
			echo json_encode($list);

	}
	
} 