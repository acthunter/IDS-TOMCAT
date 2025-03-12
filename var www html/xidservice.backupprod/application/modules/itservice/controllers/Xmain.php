<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class XMain extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
		$this->initparam();
		$this->skcskm();
		$this->load->library('session');		
		$this->load->model('xwf_model', 'wfmodel');
		/* $this->load->model('Xmod_RS', 'xmod'); */
	}

/* 	public function loadform(){
		$fdt = $this->input->post();
		$fdata = array ("modal_id" => $fdt['modal_id'], "mode"=>$fdt['mode']);
		$ret = null;
		if (preg_match('/^(RS)/',$fdt['mode'])){
			$ret =  $this->loadform_wf($fdata);
		}
		return $ret;
	} */
	
	private function initparam(){
		/* $this->apps_list = array(
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
				"bps"=>array("apps"=>"bps","app_num"=>"40")

			); */
			
			$this->apps_list = array(
				"b24"=>array("apps"=>"b24","app_num"=>"1"),
				"ska_icons"=>array("apps"=>"ska_icons","app_num"=>"3"),
				"new_ska"=>array("apps"=>"new_ska","app_num"=>"5"),
				"skcdm"=>array("apps"=>"skcdm","app_num"=>"6"),
				"swift"=>array("apps"=>"swift","app_num"=>"7"),
				"srp"=>array("apps"=>"srp","app_num"=>"8"),
				"ibank"=>array("apps"=>"ibank","app_num"=>"10"),
				"tiplus"=>array("apps"=>"tiplus","app_num"=>"13"),
				"sar"=>array("apps"=>"sar","app_num"=>"15"),
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
	private function skcskm(){
		$this->listskcskm = array(
			"WBN"=>array("BDC","BDM","NUL","PGC","SKC"),
			"WJB"=>array("BGC","TCM","TGC","TGM"),
			"WJY"=>array("BKC","BKM","JAC","JMM","KGM","KRC"),
			"WBJ"=>array("BLM","BMC","BMM","POM"),
			"WDR"=>array("DPC","DPM"),
			"WJK"=>array("GEC","JKC","JKM","PCC","PJM","TJC"),
			"WSY"=>array("GPC","GRM","HRM","SBC","SBM","SJM","SPM"),
			"WJS"=>array("JDM","JPM","JRM","MRC","TAC"),
			"WPL"=>array("LAM","PLC","PLM"),
			"WMD"=>array("LOC","MDC","MDM"),
			"WMK"=>array("MKC","MKM","MPM"),
			"WPD"=>array("PAM","PBC","PKM","TAM"),
			"WYK"=>array("SLC","SLM","YGC"),
			"WSM"=>array("SMC","SMM"),
			"WMA"=>array("MAM"),
			"WMO"=>array("MNM"),
			"WPU"=>array("PPM")
		);
	}
	public function index()
	{	
		$myid = $this->cas->getmycas_login(array('idm_ithde','idm_idadmin'));
		$this->page->template('site_tpl');
		$this->page->view('v_reset');
	}
	
	public function query(){ 
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		
		$query = $this->db->query("SELECT email, name FROM xemployee WHERE NPP = ?", array($npp));
		
        echo json_encode($query->row());	
	}
	
	public function mail(){
		$fmdata = $this->input->post();
		$email = $fmdata['email'];
		
		$xcp = array('type'=>'CP', 'accoffice'=>$accoffice,'status'=>'I',
					'data'=> $datastr);			
			//log_message('debug', print_r(array('arr.xcp'=>$xcp), TRUE));
			$ustr = $this->db->update_string('xreviewpos', $xcp, 'id=' . $wfdetail->detail->id  );
			$ret = $this->db->query($ustr);
	}
	
	public function cek_user(){
		$fmdata = $this->input->post();
		$loginid = $fmdata['loginid'];
		$query = $this->db->query("select * from xlogin where loginid =?", array($loginid));
		$cpriv = $query->row();
		if ($cpriv == null){
			$query = $this->db->query("select * from appsuser atr join revdraft rv on atr.reqid = rv.id where atr.NPP =?", array($loginid));
			$cpriv = $query->row();
		}
		echo json_encode($cpriv);
	}
		/*public function query(){
		 $fmdata = $this->input->post();
		$accoffice = $fmdata['accoffice'];
		$query = $this->db->query("select deliverymode from xentitas where accOffice =?", array($accoffice));
		$res = $query->row();
		echo json_encode($res); 
		
	}*/
	
	public function valid_priv(){
		$fmdata = $this->input->post();
		$loginid = $fmdata['npp'];
		//
		//$ret = array("banc"=>"Core banking", "apps1"=>"new apps 1");
		
		
		
		$query = $this->db->query("select * from v_login_previlegde1
			where loginid =?", array($loginid));
		$opts = array();
		$cpriv = $query->row();
		//if (isset($cpriv)){
			if ($cpriv != null){
				foreach($this->apps_list as $capps => $cval ){
					if (array_key_exists($capps, $cpriv) && $cpriv->$capps != null){
						$opts[$capps] = $cval;
					}
				}
			}
			//var_dump($opts);
			
		//}else{
			$query = $this->db->query("select * from appsuser atr JOIN apps on apps.apps = atr.apps where atr.npp =?", array($loginid));	
			//var_dump($opts);
			$hasil = $query->result();
			/* foreach($this->apps_list as $capps => $cval ){
					if (array_key_exists($capps, $hasil) && $hasil->$capps != null){
						$opts[$capps] = $cval;
					}
				} */
			foreach ($hasil as $res){
				$opts[]= array(
				"kelas"=> "apps",
				"desc"=> $res->desc,
				"target"=> $res->name,
				"delivery" => "manual");
				
			}
			//$ret = array("opts"=>$opts);
		//}
					
		$ret = array("opts"=>$opts);
		echo json_encode($ret);
	}
	
	public function wfaction(){
		$fdt = $this->input->post();
		$mode = $fdt['mode'];
		$reqid = $fdt['reqid'];
		log_message('debug', print_r(array("xids.data.wfaction"=>$fdt), TRUE));
		if (preg_match('/cancel/',$fdt['reqtype'])){
			$actret = $this->wfmodel->cancel($reqid);
			log_message('debug', print_r(array("actret.wfmodel"=>$actret), TRUE)); 
		} else {
			//$x = $this->load->model('xmod_' . $mode, 'xmod');
			//var_dump($x);
			$this->load->model('xmod_' . $mode, 'xmod');
			$actret = $this->xmod->wfaction();
			log_message('debug', print_r(array("actret.wfaction"=>$actret), TRUE)); 
		}
		echo json_encode($actret);
	}
	
	public function handle(){
		$fmdata = $this->input->post();
		
		if (!isset($fmdata)){
			return $this->index();
		} else {
			
			$uniqid = uniqid("");
			if ($fmdata['reqtype'] == 'setPass'){
				//input target, npp, mobileNumber
				$rdetail = array("npp"=>$fmdata['npp'], 
					"target"=>$fmdata['target'], "mobileNumber"=>$fmdata['mobileNumber'],'delivery'=>$fmdata['delivery'], "userclass"=>'xcasuser');
				
				$sdata = array("reqtype"=>$fmdata['reqtype'], "detail"=>json_encode($rdetail));
				
				$this->load->library('restclient', array());
				$dest_url = $this->config->item('cas_url') . 'frontend/target';
				
				
				log_message('debug', print_r(array("handle.sdata"=>$sdata), TRUE));
				log_message('debug', print_r(array("handle.dest_url"=>$dest_url), TRUE));
				 
				$breply = $this->restclient->post($dest_url, $sdata);
				 
				//log_message('debug', print_r($breply, TRUE));
				//log_message('debug', print_r(array("breply "=>$breply), TRUE));
				//$breply = array("resp"=>"ok");
				if ($breply == false){
					$breply = array("resp" => "false");
				}
				//$breply = array("resp"=>"ok");
				//$breply = array("res"=>"err mobile number tidak ada", "data"=>$fmdata);
				echo json_encode($breply);
			} 
		}
	}
	
	public function lookup_user(){
		$fmdata = $this->input->post();	
		$sdata_new = array("loginid"=>$fmdata['loginid'], "accOffice"=>$fmdata['accoffice']);
		//var_dump($sdata_new);
		
		$this->load->library('restclient', array());
		$dest_url = $this->config->item('cas_url') . 'batchfe/lookupUserSS';
				 
		$breply = $this->restclient->post($dest_url, $sdata_new);
		$breply = array_values(array_filter($breply, function ($var) {
				return ($var['utype'] == 'U');
			}));
		if (($breply == false) or (count($breply)== 0) ){
			$query = $this->db->query("SELECT accOffice FROM jbpm.v_login_previlegde1 where loginid =".$fmdata['loginid']." and (accOffice = ".$fmdata['accoffice']." or accOffice = ".$fmdata['accoffice'].")")->row();
			if($query === NULL){
				$breply = array("resp" => "false");
			}else{
				$breply = array("resp" => "null");
			}
		}
		//var_dump($breply);
		$ret = array("opts"=>$breply);
		echo json_encode($ret);
	}
			
	public function lookup_apps(){
		foreach($this->apps_list as $capps => $cval ){
			$opts[] = $cval;
		}
		$ret = array("opts"=>$opts);
		//var_dump($opts);
		echo json_encode($ret);
	}
	
	public function lookup_user_test(){
				$fmdata = $this->input->post();
				$sdata_new = array("loginid"=>'39654', "accOffice"=>'718');
				//var_dump($sdata_new);
				$this->load->library('restclient', array());
				$dest_url = $this->config->item('cas_url') . 'batchfe/lookupUser';
				
				
				log_message('debug', print_r(array("handle.sdata"=>$sdata_new), TRUE));
				log_message('debug', print_r(array("handle.dest_url"=>$dest_url), TRUE));
				 
				$breply = $this->restclient->post($dest_url, $sdata_new);
				 
				log_message('debug', print_r(array("breply"=>$breply), TRUE));
				//log_message('debug', print_r(array("breply "=>$breply), TRUE));
				//$breply = array("resp"=>"ok");
				if ($breply == false){
					$breply = array("resp" => "false");
				}
				$ret = array("opts"=>$breply);
				//var_dump($a);
				//$breply = array("resp"=>"ok");
				//$breply = array("res"=>"err mobile number tidak ada", "data"=>$fmdata);
				echo json_encode($ret);
			}
	
	public function pickup(){
				$fmdata = $this->input->post();
				$last_time = date("Y-m-d h:i:s");
				$sdata_new = array("reqtype"=>'resetPass', "actor"=>'37559',"detail"=>'test');
				//$sdata_new = array("qid"=>'2', "status"=>'C', "detail"=>'test', "reqtype"=>'validate');
				//var_dump($sdata_new);
				$this->load->library('restclient', array());
				$dest_url = $this->config->item('cas_url') . 'bqueue/pickup';
				//$dest_url = $this->config->item('cas_url') . 'bqueue/mark';
				
				log_message('debug', print_r(array("handle.sdata"=>$sdata_new), TRUE));
				log_message('debug', print_r(array("handle.dest_url"=>$dest_url), TRUE));
				 
				$breply = $this->restclient->post($dest_url, $sdata_new);
				 
				log_message('debug', print_r(array("breply"=>$breply), TRUE));
				//log_message('debug', print_r(array("breply "=>$breply), TRUE));
				//$breply = array("resp"=>"ok");
				if ($breply == false){
					$breply = array("resp" => "false");
				}
				//$ret = array("opts"=>$breply);
				//var_dump($a);
				//$breply = array("resp"=>"ok");
				//$breply = array("res"=>"err mobile number tidak ada", "data"=>$fmdata);
				echo json_encode($breply);
			} 

			
	public function test_mark(){
				$fmdata = $this->input->post();
				//$sdata_new = array("reqtype"=>'resetPass', "actor"=>'37559',"detail"=>'test');
				//$sdata_new = array("qid"=>'2', "status"=>'C', "detail"=>'test', "reqtype"=>'validate');
				$sdata_new = array("reqtype"=>'resetPass', "actor"=>'37559',"detail"=>'test');
				//var_dump($sdata_new);
				$this->load->library('restclient', array());
				//$dest_url = $this->config->item('cas_url') . 'bqueue/pickup';
				//$dest_url = $this->config->item('cas_url') . 'bqueue/reset';
				//$dest_url = $this->config->item('cas_url') . 'bqueue/ok';
				$dest_url = $this->config->item('cas_url') . 'bqueue/pickGV';
				
				
				log_message('debug', print_r(array("handle.sdata"=>$sdata_new), TRUE));
				log_message('debug', print_r(array("handle.dest_url"=>$dest_url), TRUE));
				 
				$breply = $this->restclient->post($dest_url, $sdata_new);
				 
				log_message('debug', print_r(array("breply"=>$breply), TRUE));
				//log_message('debug', print_r(array("breply "=>$breply), TRUE));
				//$breply = array("resp"=>"ok");
				if ($breply == false){
					$breply = array("resp" => "false");
				}
				//$ret = array("opts"=>$breply);
				//var_dump($a);
				//$breply = array("resp"=>"ok");
				//$breply = array("res"=>"err mobile number tidak ada", "data"=>$fmdata);
				echo json_encode($breply);
	}
	
	public function pos_unit() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  strtoupper($this->input->post()['pattern']);
		//var_dump($pattern);
		$val =  $this->input->post()['valreq'];
	$pparamm = $this->listskcskm;
		if (strlen($pattern) > 3){
			$pat_cond = substr($pattern, 0, -1);
		}else{
			$pat_cond = $pattern;
		}
		foreach($pparamm as $k=>$arr)
		{
			//var_dump($nosr);
			if(in_array($pat_cond,$arr))
			{
				$pattern = $k;
				// "prints" fruits
			}
		}
		if (strpos($pattern, 'CLN') !== false) {
			$query = $this->db->query("SELECT accOffice FROM jbpm.v_login_previlegde1 where loginid =".$val)->row();
		}else{
			$query2 = $this->db->query("SELECT accOffice FROM jbpm.xentitas where rubrik like '%".$pattern."%'")->row();
			if($query2 === NULL){ 
				$query = $this->db->query("SELECT accOffice FROM jbpm.xentitas where rubrik like '%".substr($pattern, 0, -1)."%'")->row();

			}else{
				$query = $query2;
			}
		}
		
		$crow = $this->wfmodel->getposunit($query->accOffice);
		
		foreach( $crow as $r )  
        {  
		   $position = array(   
                'pname' => $r->name, 
				'accOffice' => $r->accOffice
            );
        }  
		echo json_encode($position);
	/* $pattern =  strtoupper($this->input->post()['pattern']);
	$val =  $this->input->post()['valreq'];
	$pparamm = $this->listskcskm;
		foreach($pparamm as $k=>$arr)
		{
			//var_dump($nosr);
			if(in_array($pattern,$arr))
			{
				$pattern = $k;
				// "prints" fruits
			}
		}
		
		if (strpos($pattern, 'CLN') !== false) {
			$query = $this->db->query("SELECT accOffice FROM jbpm.v_login_previlegde1 where loginid =".$val)->row();
		}else{
			$query = $this->db->query("SELECT accOffice FROM jbpm.xentitas where rubrik like '%".$pattern."%'")->row();
		}
		
		$crow = $this->wfmodel->getposunit($query->accOffice);
		
		foreach( $crow as $r )  
        {  
		   $position = array(   
                'pname' => $r->name, 
				'accOffice' => $r->accOffice
            );
        }  
		echo json_encode($position); */
    }
	public function pos_unit2() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  $this->input->post()['pattern'];
		$crow = $this->wfmodel->getposunit2($pattern);
		
		foreach( $crow as $r )  
        {  
		   $position[] = array(   
                'pname' => $r->name, 
				'accOffice' => $r->accOffice
            );
        }  
		echo json_encode($position);
    }
	
		public function query_req() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$fd = $this->input->post();
		$accOffice = strtoupper($fd['accOffice']);  
		$pparamm = $this->listskcskm;
		foreach($pparamm as $k=>$arr)
		{
			//var_dump($nosr);
			if(in_array($accOffice,$arr))
			{
				$accOffice = $k;
				// "prints" fruits
			}
		}
		if (strpos($accOffice, 'CLN') !== false) {
			$query = $this->db->query("SELECT vl.loginid, vl.accoffice, xe.rubrik, vl.name, vp1.position FROM jbpm.v_idmauth vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid inner join jbpm.xentitas xe on  vp1.accOffice = xe.accOffice WHERE  idm <= 3 and (xe.rubrik LIKE '%".$accOffice."%' or xe.hierarchy LIKE '%".$accOffice."%' ) ");
		}else{
			$query = $this->db->query("SELECT vl.loginid, vl.accoffice, xe.rubrik, vl.name, vp1.position FROM jbpm.v_idmauth vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid inner join jbpm.xentitas xe on  vp1.accOffice = xe.accOffice WHERE  idm <= 3 and xe.rubrik LIKE '%".$accOffice."%'");
		}
		
		$res = $query->result();
		echo json_encode($res);		
    }
	
	public function query_req2(){ 
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		
		$query = $this->db->query("select vl.name as name, vl.email as email from v_login_previlegde1 vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid
			where vl.NPP =?", array($npp));
		
        echo json_encode($query->row());	
	}
	
	public function query_srt() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$fd = $this->input->post();
		$nosr = $fd['nosr'];  
		$pparamm = $this->listskcskm;
		foreach($pparamm as $k=>$arr)
		{
			//var_dump($nosr);
			if(in_array($nosr,$arr))
			{
				$nosr = $k;
				// "prints" fruits
			}
		}
		$query = $this->db->query("SELECT xw.initiator, xr.order_time, vlm.name FROM jbpm.xrequest xr join xwfparam xw on xr.reqid = xw.id join v_login_name vlm on xw.initiator = vlm.loginid where xr.key1 = '".$nosr."' ORDER BY xw.id DESC LIMIT 1");
		$res = $query->row();
		echo json_encode($res);		
    }
	public function filter_data() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$fd = $this->input->post();
		$checkboxNameArry = $fd['checkboxNameArry'];  
		$checkboxValArry = $fd['checkboxValArry']; 
		$npp = $fd['npp'];
		$date_filter = date("Y-m-d", strtotime("-1 months"));
		foreach( $checkboxNameArry as $r )  
        {  
			if ($r == 'webmail'){
				$r = 'ldapAccount_oid';
			}
			$query = $this->db->query("SELECT * FROM jbpm.xrequest where JSON_EXTRACT(detail, 
			'$.\"".$npp."\".".$r."') = 'rst'  and srctype = 'ss' and doc_date >= '".$date_filter."' ORDER BY id DESC LIMIT 1;");
			$res = $query->row();
			if (isset($res)){
			$dat_val[] = array(   
                'time' => $res->doc_date, 
				'accOffice' => $res->accOffice,
				'apps' => $r
            );
			}
			 
        } 
		//var_dump($dat_val);
		
		echo json_encode($dat_val);		
    }
	public function popup()
	{
		$response = $this->load->view('v_confirmduplicate');
		echo ($response);

	}
	public function lookup_apps2(){
		$fd = $this->input->post();
		$npp = $fd['npp'];  
		$selects = array("f1m","ibank","nska","tplus");
		$sql="";
		$union_all="";
		//nilai positionidnya di dapet dari input post di depan
		foreach($selects as $select)
		{
		  $sql .= $union_all . "SELECT '".$select."' AS `apps` , `".$select."` AS `val` FROM `xpreviledge`where positionid = '1485033612400'";
		  $union_all=" UNION ALL ";
		}
		$query = $this->db->query("select * FROM  (".$sql.") as xprev where val is not null");
		$result =  json_decode(json_encode($query->result()), true);
		foreach ($result as $key => $value){
			if($value['apps'] == 'tplus'){
				$value['apps'] = 'tiplus';
			}
			$filter_xprev[] = $value['apps'];
		}
		$query2 = $this->db->query("select apps from v_uamuser where loginid =".$npp);
		$result2 =  json_decode(json_encode($query2->result()), true);
		foreach ($result2 as $key2 => $value2){
			$filter_xprev2[] = $value2['apps'];
		}
		foreach ($filter_xprev as $key3 ){
			if(!in_array($key3,$filter_xprev2)){
				/* foreach($this->apps_list as $capps => $cval ){ */
					if(array_key_exists($key3,$this->apps_list)){
						$opts[] = $this->apps_list[$key3];
					}
				/* } */
				//$filter_xprev3[] = $key3;
			}else{
				$filter_xprev4[] = $key3;
			}
		}
		/* var_dump($filter_xprev);
		var_dump($filter_xprev2);
		var_dump($filter_xprev3);
		var_dump($filter_xprev4);
		
		var_dump($opts); */
		if (isset($filter_xprev4)){
			$err = -1; 
		}else{
			$err = 0;
		}
		 $ret = array("opts"=>$opts, "error"=>$err);
		echo json_encode($ret);
	}
	
	public function load_admappr()
	{	
		
		$this->page->template('site_tpl');
		$this->page->view('v_admappr');
	}
	
	public function search_unit() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  $this->input->post()['pattern'];
		$crow = $this->wfmodel->getunit($pattern);
		
		foreach( $crow as $r )  
        {  
		   $position[] = array(   
                'pname' => $r->name, 
				'accOffice' => $r->accOffice
            );
        }  
		echo json_encode($position);
    }
		public function search_unitbina() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  $this->input->post()['pattern'];
		$crow = $this->wfmodel->getunitbina($pattern);
		
		foreach( $crow as $r )  
        {  
		   $position[] = array(  
                'unitname' => $r->unit, 
				'unit' => $r->accOffice,
				'posisi' => $r->posisi,
				'posid' => $r->positionid
            );
        }  
		echo json_encode($position);
    }
	public function searchauth(){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$unit = ltrim($fmdata['unit'], '0');
		$pengguna = $_SESSION['pengguna'];
		if (!empty($unit)) {			
			$this->db->select('vi.accOffice as kode, vi.loginid as npp, xe.name as nama,  vi.position as posisi, xen.name as nama_unit, vi.s2 as appr, vi.s1 as adm');
			$this->db->from('v_idmauth vi');
			$this->db->join('xemployee xe', 'vi.loginid = xe.NPP');
			$this->db->join('xentitas xen', 'vi.accOffice = xen.accOffice');
			$this->db->where('vi.accOffice', $unit);
			$where = '(s2 > 0 OR s1 > 0)';
			$this->db->where($where);
			
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			$result =  $query->result();
			
			$output = array(
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => $result
			);
		
		}else{
			$output = array(
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => 0
			); 
		}
		echo json_encode($output);
	}
	
		public function addappsso()
	{	
		
		$myid = $this->cas->getmycas_login(array('idm_idadmin', 'idm_super'));
		$this->page->template('site_tpl');
		$this->page->view('v_addappsso');
	}
	
	public function npp_search(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$fmdata = $this->input->post();
		$id = $fmdata['npp'];
		
		$query = $this->db->query("select vl.loginid, vm.name,  vl.accOffice,  xe.name as unit
		from v_login_previlegde1 vl 
		join v_login_name vm on vl.loginid = vm.loginid
		join xentitas xe on xe.accOffice = vl.accOffice
		where vl.loginid = ". $id);
		
        echo json_encode($query->row());
	}
	
	public function search_app() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  $this->input->post()['pattern'];
		$crow = $this->wfmodel->getapp($pattern);
		
		foreach( $crow as $r )  
        {  
		   $position[] = array(  
                'appname' => $r->desc, 
				'aplikasi' => $r->name,
				'id_app'=> $r->apps
            );
        }  
		echo json_encode($position);
    }
	
		public function proses() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pstdata =  $this->input->post();
		$loginid = $this->session->userdata('pengguna')->loginid;
		$iduser = ((pow(10, 4)*$pstdata['npp'])+$pstdata['appid']);
		$searchapps = $this->db->query("select id from appsuser where iduser =?", array($iduser));
		$result = $searchapps->row();
		if ($result == null){
			$rdetail = (object) array("apps"=>$pstdata['appid'],"NPP"=>$pstdata['npp'], 
					"refid"=>$pstdata['unit'], "priviledgeid"=>"999999", "sloginid" => $pstdata['user_app'],
					"iduser"=>$iduser, "initiator" => $loginid);
			$ustr = $this->db->insert_string('appsuser', $rdetail);
			$this->db->query($ustr);
			if ($this->db->affected_rows() > 0)
			{
				$breply['status'] = "success";		
			}
			else
			{
				$breply['status'] = "fail";
			}
			
		}else{
			$breply['status'] = "duplicate";
		}
		
		echo json_encode($breply);
    }
	
		/* ------------------------------------------------------- Add User Reus Bina-------------------------------------------------------------*/

	public function addbinareuse()
	{	
		
		//$myid = $this->cas->getmycas_login(array('idm_idadmin', 'idm_super'));
		$myid = $this->cas->getmycas_login(array('idm_idadmin', 'idm_super'));
		$this->page->template('site_tpl');
		$this->page->view('v_addbinareuse');
	}
	
	public function query_bina(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		//$accoffice = $_SESSION['pengguna']->accoffice; 
		$fmdata = $this->input->post(); 
		$nppuser = $fmdata['npp'];
		$buser = $fmdata['bnpp'];

		if ($buser == ""){
			$query = $this->db->query("select npp, loginid, status from xpool where nppORG = '" . $nppuser . "'");
		}else{
			$query = $this->db->query("select npp, loginid, status from xpool where npp = '" . $buser . "' and status = 'AVAIL'");			
		}
		$res = $query->row(); 

		if ($res->status == 'REUSE'){
			$query2 = $this->db->query("select x.npp, x.name, x.mobileNumber, vl.posname, vl.positionid from xemployee x join v_login_name vl ON x.npp = vl.npp where x.npp=" . $res->npp);
			$res2 = $query2->row(); 
			$result = array(  
                'npp' => $nppuser, 
				'bloginid' => $res->npp,
				'nama' => $res2->name,
				'nohp' => $res2->mobileNumber
            );

		}else{
			$result = $res;
		}
        echo json_encode($result);	
	}
			
} 