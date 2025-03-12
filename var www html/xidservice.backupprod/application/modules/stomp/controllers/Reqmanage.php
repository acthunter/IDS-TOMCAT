<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reqmanage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->initparam();
		$this->load->library('session');
        if(!$this->session->userdata('pengguna')){
           redirect('log_out', 'refresh');
        }
	}
		private function initparam(){
		$this->apps_list = array(
				/* "icons"=>array("target"=>"banc", "desc"=>"apps core banking", "delivery"=>"online"),
				"idminit"=>array("target"=>"ldapAccount_oid", "desc"=>"OID (WEBMAIL)", "delivery"=>"online"),
				"prsk"=>array("target"=>"periskop", "desc"=>"Periskop", "delivery"=>"manual"),
				"psn"=>array("target"=>"Email", "desc"=>"Email bni.co.id", "delivery"=>"pinmailer"), */
				"globs"=>array("apps"=>"globs", "app_num"=>"1"),
				"epurse"=>array("apps"=>"epurse", "app_num"=>"2"),
				"opbg"=>array("apps"=>"opbg", "app_num"=>"3"),
				"tiplus"=>array("apps"=>"tiplus", "app_num"=>"4"),
				"oase"=>array("apps"=>"oase", "app_num"=>"5"),
				"banc"=>array("apps"=>"banc", "app_num"=>"6"),
				"ibank"=>array("apps"=>"ibank", "app_num"=>"7"),
				"webmail"=>array("apps"=>"webmail", "app_num"=>"8"),
				"prsk"=>array("apps"=>"prsk", "app_num"=>"9"),
				"icons"=>array("apps"=>"icons", "app_num"=>"10"),
				"ska_icons"=>array("apps"=>"ska_icons", "app_num"=>"11"),
				"crm"=>array("apps"=>"crm", "app_num"=>"12"),
				"srp"=>array("apps"=>"srp", "app_num"=>"13"),
				"bar"=>array("apps"=>"bar", "app_num"=>"14"),
				"bisss_jitu"=>array("apps"=>"bisss_jitu", "app_num"=>"15"),
				"bisss_depox"=>array("apps"=>"bisss_depox", "app_num"=>"16"),
				"svsonline"=>array("apps"=>"svsonline", "app_num"=>"17"),
				"irs_online"=>array("apps"=>"irs_online", "app_num"=>"18"),
				"cmod"=>array("apps"=>"cmod", "app_num"=>"19"),
				"gotrade"=>array("apps"=>"gotrade", "app_num"=>"20"),
			);
	}
	public function index()
	{	
		//$myid = $this->cas->getmycas_login(array('killbanc'));
		$this->page->template('site_tpl');
			$this->page->view('v_resetmanage');

	}

	public function popup()
	{
		$response = $this->load->view('v_confirmreqmanage');
		echo($response);

	}
	public function list_popup()
	{
		$fdt = $this->input->post();
		$app    = $fdt['app'];
		$val   = $fdt['val_app'];
		$vallog   = $fdt['slog'];
		//$position = [];
		foreach( $app as $index => $apps ) {
			if($vallog[$index] == 'null'){
				$val_log = $this->session->userdata('pengguna')->loginid;			
			} else {
				$val_log = $vallog[$index];				
			}
		   $position[]= array(
                'app' => $apps, 
				'val_app' => $val[$index],
				'val_log' => $vallog[$index]
		   );
		}
		echo json_encode($position);

	}
	public function lookup_user()
	{	
		$pattern =  $this->session->userdata('pengguna')->accoffice;
		$r = $this->db->query("select *  from xentitas where accOffice = " . $pattern )->row();
		
		$sdata_new = array("loginid"=>$this->session->userdata('pengguna')->loginid, "accOffice"=>$this->session->userdata('pengguna')->accoffice);

		$this->load->library('restclient', array());
		$dest_url = $this->config->item('cas_url') . 'batchfe/lookupUserSS';
				 
		$breply = $this->restclient->post($dest_url, $sdata_new);
		
		if ($breply == false){
			$breply = array("resp" => "false");
		}else{
			$i=0;
			foreach($breply as $element) {
			   //check the property of every element

			   /* if(($element['apps'] == 'prsk') or ($element['apps'] == 'eis') or ($element['apps'] == 'icons') or ($element['apps'] == 'webmail') or ($element['apps'] == 'globs')){
				   unset($breply[$i]);
			   } */
			   //$app = array('prsk', 'eis', 'icons', 'webmail','skcdm','wom','skcdm','oase','smpk','wic','bar','crm','bisss_jitu'); 
			   $app = array('prsk', 'eis', 'icons', 'webmail','skcdm','wom','skcdm','oase','smpk','wic','bar','crm'); 
			   if(in_array($element['apps'], $app, TRUE)){
				   unset($breply[$i]);
			   } 
			   $i++;
			}
			$breply = array_values($breply);
		}
		$ret = array("opts"=>$breply, 'pname' => $r->name, 'accOffice' => $r->accOffice);
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
	public function wfaction(){
		$fdt = $this->input->post();
		$app    = $fdt['app'];
		$val   = $fdt['val_app'];
		//$position = [];
		//$position = array_merge($position, $app);
		foreach( $app as $index => $apps ) {
			if($apps == "webmail"){
				$apps = "ldapAccount_oid";			
			} else if($apps == "icons"){
				$apps = "banc";			
			}
		   $data_app[$apps]=$val[$index];
		}
		$opts[$this->session->userdata('pengguna')->loginid] = $data_app;
		$detail = json_encode($opts);
		$date = new DateTime();
		$dataarr = array('srctype'=>'ss', 'detail'=>$detail,'doc_date'=> $date->format('Y-m-d'),'accoffice'=>$this->session->userdata('pengguna')->accoffice, 'req_stat'=>'I', 'req_flag'=>'P', 'key1'=> 'self service');
		$ustr = $this->db->insert_string('xrequest', $dataarr);
		$this->db->query($ustr);
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
			 /* $query = $this->db->query("SELECT * FROM jbpm.xrequest where JSON_EXTRACT(detail, 
			'$.\"".$npp."\".".$r."') is not null and JSON_EXTRACT(detail, 
			'$.\"".$npp."\".".$r."') = 'rst' and ( status not in ('X','S') or status is null) ORDER BY id DESC LIMIT 1;");  */
			
			$query = $this->db->query("SELECT * FROM jbpm.xrequest where detail is not null and
			detail like '%".$r.":\"rst\"%' and
			detail like '%\"".$npp."\"%' 
			and ( status not in ('X','S') or status is null) ORDER BY id DESC LIMIT 1;");
			$res = $query->row();
			if (isset($res)){
			$dat_val[] = array(   
                'time' => $res->doc_date, 
				'accOffice' => $res->accOffice,
				'apps' => $r
            );
			}
			
        } 
		
		echo json_encode($dat_val);		
    }
	
	public function filter_sentpass() //pencarian data posisi bedasarkan inputan hal v_kewenangan
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
			$query = $this->db->query("SELECT  xr.* FROM jbpm.xrequest xr JOIN jbpm.transitRepo tr on xr.id = tr.reqid  where JSON_EXTRACT(xr.detail, 
			'$.\"".$npp."\".".$r."') is not null and (JSON_EXTRACT(xr.detail, 
			'$.\"".$npp."\".".$r."') = 'rst' or JSON_EXTRACT(xr.detail,
			'$.\"".$npp."\".".$r."') = 'new') and ( (xr.req_flag = 'P' and xr.srctype = 'ss' ) or xr.status in ('S','P') ) and tr.qid is null and tr.loginid = '".$npp."' and xr.order_time > '2019-06-20' ORDER BY id DESC LIMIT 1;");
			

/* 			$query = $this->db->query("SELECT * FROM jbpm.xrequest where detail is not null and (detail like '%".$r.":\"rst\"%' or detail like '%".$r.":\"new\"%') 
			and detail like '%\"".$npp."\"%' and ( (req_flag = 'P' and srctype = 'ss' ) or status in ('S','P') )and order_time > '2019-06-20' ORDER BY id DESC LIMIT 1;"); */
			$res = $query->row();
			if (isset($res)){
			$dat_val2[] = array(   
                'time' => $res->doc_date, 
				'accOffice' => $res->accOffice,
				'apps' => $r
            );
			}
			
        } 
		echo json_encode($dat_val2);		
    }

/* 	public function filter_data() //pencarian data posisi bedasarkan inputan hal v_kewenangan
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
			} */
			/* $query = $this->db->query("SELECT * FROM jbpm.xrequest where JSON_EXTRACT(detail, 
			'$.\"".$npp."\".".$r."') = 'rst' ORDER BY id DESC LIMIT 1;"); */
			/* $query = $this->db->query("SELECT * FROM jbpm.xrequest where JSON_EXTRACT(detail, 
			'$.\"".$npp."\".".$r."') is not null and JSON_EXTRACT(detail, 
			'$.\"".$npp."\".".$r."') = 'rst' and ( (status != 'S' and status != 'X') or status is null) ORDER BY id DESC LIMIT 1;");
			$res = $query->row(); 
			if (isset($res)){
			$dat_val[] = array(   
                'time' => $res->doc_date, 
				'accOffice' => $res->accOffice,
				'apps' => $r
            );
			}
			
        } 
		
		echo json_encode($dat_val);		
    } */
	public function popup2()
	{
		$response = $this->load->view('v_confirmduplicate',true);
		echo($response);

	}
	public function popupsent()
	{
		$response = $this->load->view('v_confirmreqhassent',true);
		echo($response);

	}
	
} 