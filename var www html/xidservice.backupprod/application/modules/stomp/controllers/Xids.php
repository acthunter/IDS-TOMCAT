<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xids extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
		$this->load->model('xwf_model', 'wfmodel');
		$this->load->library('session');
        if(!$this->session->userdata('pengguna')){
           redirect('log_out', 'refresh');
        }
	}

	public function index()
	{	
		
		//$myid = $this->cas->allow_login('idm_appr OR idm_init');
		//$myid = $this->cas->allow_login2();
		//$myid = $this->cas->allow_logindynmodal();
		//$myid = $this->cas->getmycas_login(array('idm_init', 'idm_appr'));
		log_message('debug', print_r(array("xids.index.pengguna"=>$_SESSION['pengguna']), TRUE));
		
		$this->page->view('v_ctest');
	}
	
	public function loadform(){
		$fdt = $this->input->post();
		$fdata = array ("modal_id" => $fdt['modal_id'], "mode"=>$fdt['mode']);
		$ret = null;
		if (preg_match('/^(CP|RP|RI|UA|A|AI|AF|EM|CT|CU|RS|UC|HS|KL|IU|SY|CI|UH|RC|CL|CW|BN|UL)/',$fdt['mode'])){
			$ret =  $this->loadform_wf($fdata);
		}
		return $ret;
	}
	
	private function loadform_wf($fdata){
		
		$fmode = $fdata['mode'];
		$pmodule = $fmode;
		
		if (preg_match('/(RI)/',$pmodule))
			$pmodule = 'RP';
		
		$this->config->load("formtype", TRUE);
		$ftype = "wfjob." .$fmode;
		
		$fname = $this->config->item('formtype')[$ftype];
		$this->load->view('templates/' . $fname, $fdata);
	}
	
	public function jobbyid(){
		$fdt = $this->input->post();
		$myid = $this->session->userdata('pengguna')->loginid;
		return $this->getjobdetail($myid, $fdt['id'], $fdt['mode']);
	}
	

	public function initiate($module){
		$this->load->model('xmod_' . $module, 'xmod');
		$ret = $this->xmod->initiate();
		$myid = $this->session->userdata('pengguna')->loginid;
		//echo json_encode($ret);
		return $this->getjobdetail($myid, $ret->id, $module);
	}

	
	public function createnew($module){
		$this->load->model('xmod_' . $module, 'xmod');
		$ret = $this->xmod->createnew();
		log_message('debug', print_r(array("createnew "=>$ret), TRUE));
		$myid = $this->session->userdata('pengguna')->loginid;
		//echo json_encode($ret);
		return $this->getjobdetail($myid, $ret->id, $module);
	}
	
	
	public function getjobdetail($myid, $jobid, $mode){
		$this->load->model('xmod_' . $mode, 'xmod');
		$rdetail = $this->xmod->wfdetail($jobid);
		
		if (isset($rdetail->id)){
			$rdetail->eaction = $this->xmod->possibleAction($rdetail, $myid);
			$rdetail->notes = $this->wfmodel->getnotes($jobid,'A');
			
			if (sizeof($rdetail->eaction) > 0){
				if (!$this->wfmodel->lockjob($myid, $jobid)){
					$rdetail->locked = true;
					$rdetail->eaction = array();
				} else {
					$rdetail->eaction[] = 'release';
				}
			}
		} else {
			$rdetail->reqtype = 'new';
			$rdetail->eaction = array('save');
		}
		log_message('debug', print_r(array("rdetail"=>$rdetail), TRUE));
		echo json_encode($rdetail);
	}
	
	public function jobitemlist(){
		$fdt = $this->input->post();
		$module = $fdt['mode'];
		log_message('debug', print_r(array("jobsitemlist"=>$module), TRUE));
		$this->load->model('xmod_' . $module, 'xmod');
		echo json_encode($this->xmod->jobitemlist());
	}
	
	public function getMyJob(){
		$myid = $this->session->userdata('pengguna')->loginid;
		$this->getJobbyid($myid);
	}
	
	public function getJobbyid($myid){
		$fdt = $this->input->post();
		
		if (isset($fdt['stype'])){
			if (preg_match('/general/',$fdt['stype']))
				$result = $this->wfmodel->getMyWorkListGeneral();
			if (preg_match('/xreviewpos/',$fdt['stype']))
				$result = $this->wfmodel->getXreviewPos();
		} else {
			$result = $this->wfmodel->getMyWorkList($myid);
		}
		log_message('debug', print_r($result, TRUE)); 
		
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->wfmodel->count_all($myid), 
            "recordsFiltered" => $this->wfmodel->count_filtered($myid),
            "data" => $result,
        );
		echo json_encode($output);
	}
	
	public function rpositem(){
		$fdt = $this->input->post();
		$module = $fdt['mode'];
		if (preg_match('/(readitem|save)/',$fdt['reqtype']))
			$module = 'RP';
		$this->load->model('xmod_' . $module, 'xmod');
		$row =  $this->xmod->rpositem();
		echo json_encode($row);
	}
	
	public function wfaction(){
		$fdt = $this->input->post();
		$mode = $fdt['mode'];
		$wfid = $fdt['wfid'];
		log_message('debug', print_r(array("xids.data.wfaction"=>$fdt), TRUE));
		if (preg_match('/cancel/',$fdt['reqtype'])){
			$actret = $this->wfmodel->cancel($wfid);
			log_message('debug', print_r(array("actret.wfmodel"=>$actret), TRUE)); 
		} else {
			$this->load->model('xmod_' . $mode, 'xmod');
			$actret = $this->xmod->wfaction();
			log_message('debug', print_r(array("actret.wfaction"=>$actret), TRUE)); 
		}
		echo json_encode($actret);
	}
	
	public function pos_search() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  $this->input->post()['pattern'];
		$crow = $this->wfmodel->getposearch($pattern);
		
		foreach( $crow as $r )  
        {  
		   $position[] = array(  
				'accOffice' =>$r->accOffice,
                'pname' => $r->name, 
				'positionid' => $r->positionid
            );
        }  
		echo json_encode($position);
    }
	public function pos_searchdata() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  $this->input->post()['pattern'];
		$loginid =  $this->input->post()['loginid'];
		if($this->input->post('mode'))
        {
			$mode =  $this->input->post()['mode'];
		}else{
			$mode =  null;
		}
		$crow = $this->wfmodel->getposbina($pattern, $loginid, $mode);
		
		foreach( $crow as $r )  
        {  
		   $position[] = array(  
				'accOffice' =>$r->accOffice,
                'pname' => $r->name, 
				'positionid' => $r->positionid
            );
        }  
		echo json_encode($position);
    }
	public function pos_search_test() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  $this->input->post()['pattern'];
		$crow = $this->wfmodel->getposearch_test($pattern);
		
		foreach( $crow as $r )  
        {  
		   $position[] = array(  
				'accOffice' =>$r->accOffice,
                'pname' => $r->name, 
				'positionid' => $r->positionid
            );
        }  
		echo json_encode($position);
    }
/* 	 public function search() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$fmdata = $this->input->post();
		$search = $fmdata['srch-term'];
		$mode = $fmdata['mode2'];
		
		//var_dump($search);
		//log_message('debug', print_r(array("search1"=>$search), TRUE));
		if ($mode == 'id'){
		$id = $this->db->query("Select id from xwfparam where id =". $search );
		$list = $id->row(); 
		log_message('debug', print_r(array("id.getadm"=>$id), TRUE));
		}else if($mode == 'npp'){
			$id = $this->db->query("Select id from xwfparam where initiator =". $search);		
			log_message('debug', print_r(array("initiator.getadm"=>$id), TRUE));
			$crow = $id->result(); 
			foreach( $crow as $r )  
			{  
			   $list[] = $r->id;
			} 
		
		//var_dump($list);
		}else if($mode == 'date'){
			$id = $this->db->query("Select wfid from xreviewpos where  cdate >= '".date('Y-m-d',strtotime($fmdata['stime']))."' and cdate <= '".date('Y-m-d',strtotime($fmdata['etimee']))."'");	
			$crow = $id->result(); 
			//var_dump($crow);
			foreach( $crow as $r )  
			{  
			   $list[] = $r->wfid;
			} 
		}
		
		log_message('debug', print_r(array("search2"=>$list), TRUE));
		echo json_encode($list);
    } 

	public function getadm(){
		$fmdata = $this->input->post();
		$data = $fmdata['id'];
		
		//var_dump($data);
		if($data != "0"){
			$mode = $fmdata['mode'];
			if($mode == 'id'){
				$myid = $this->db->query("Select vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
				from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid
				where xw.id = " . $data );
				//var_dump($data);
			}else if ($mode == 'npp'){
				//var_dump($dat);
				$dat = json_decode($data);
				//$array=explode("','", $data);
				$array = implode("','",(array)$dat);
				//var_dump($array);
				$myid = $this->db->query("Select vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
				from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid
				where xw.id IN ('".$array."')");
				//var_dump($data);
			}else{
				$myid = $this->db->query("Select vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
				from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid
				where xw. IN ('".$array."')");
			}
		}else{
			$myid = $this->db->query("Select vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
		from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid");
		}
		$list = $myid->result();
		if ($list != null){
		//log_message('debug', print_r(array("data.getadm"=>$list), TRUE)); 
		$output = array(
            "recordsTotal" => 1,
            "recordsFiltered" => 1,
            "data" => $list,
        );
		}
		else {
			$output = array(
            "recordsTotal" => 1,
            "recordsFiltered" => 1,
        );
		}
        echo json_encode($output);
		//echo json_encode($myid);
	} */
	public function getadm_test(){
		if($this->input->post('pemohon')||$this->input->post('date')||$this->input->post('req'))
        {
			$list = $this->wfmodel->getadm();
		}else{
			$list = 0;
		}
		
		//var_dump($list);
		foreach ($list as $row){
			$dat = json_decode(($row->data),true);
			if ($row->mode == 'UA'){
				$list_npp = $dat['nloginid'];
			}else{
				$list_npp = $dat['loginid'];
			}
			$aa[] = array(
				'list_npp'=>$list_npp,
				'id' => $row->wfid,
				'mode' => $row->mode, 
				'name' => $row->name,
				'cdate' => $row->cdate,
				'currActor'=> $row->currActor,
				'initiator'=>$row->initiator,
				'stage'=>$row->stage,
				'apv'=>$row->approval,
				'dateapv'=>$row->dateappr
			);
			//var_dump($dat['loginid']);
			/* foreach($dat as $key){
			$a = $key;
				var_dump($a);
			} */
			
		}
		if (isset ($aa)){
		$list = $aa;
		//var_dump($list);
		$output = array(
            "recordsTotal" => $this->wfmodel->count_adm(),
            "recordsFiltered" => $this->wfmodel->count_adm(),
            "data" => $list
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
	
	public function getadm2($data){
		if($data != 0){
		$myid = $this->db->query("Select vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
		from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid
		where xw.initiator = " . $data );
		}else{
			$myid = $this->db->query("Select vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
		from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid");
		}
		$list = $myid->result(); 
		//log_message('debug', print_r(array("data.getadm"=>$list), TRUE)); 
		$output = array(
            "recordsTotal" => 1,
            "recordsFiltered" => 1,
            "data" => $list,
        );
		
        echo json_encode($output);
		//echo json_encode($myid);
	}
	
	public function query_nbranch(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		$flag = 'finish';
		$key1 = date('Ymd');
		$query = $this->db->query("select vl.name , vp1.name as nama, vp1.positionid, vp1.accOffice  from v_login_previlegde1 vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid
				where vl.accOffice=? and vl.loginid =?", array($accoffice, $npp));
		
		$query2 = $this->db->query("select xe.NPP, xe.Name, xe.accOffice from xemployee xe
									join revdraft rv on rv.loginid = xe.NPP
									join xreviewpos xrv on xrv.id = rv.reqid
									join xwfparam xwf on xwf.id = xrv.wfid
									where rv.flag =? and xrv.key1 =? and xe.NPP =?", array($flag, $key1, $npp));
				
		$list = $query->result();
		$list2 = $query2->result();
		log_message('debug', print_r(array("query.query2"=>$query2), TRUE)); 
		$output = array(
            "xemp" => $list,
			"xemp_rp" => $list2,
        );
        echo json_encode($output);
		//echo json_encode($query->row());
	}
	
	public function query_gen(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		
		$query = $this->db->query("select vl.name , vp1.name as nama, vp1.positionid, vp1.accOffice  from v_login_previlegde1 vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid
			where vl.accOffice=? and vl.loginid =?", array($accoffice, $npp));
		
        echo json_encode($query->row());	
	}
	
	public function query(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		
		$query = $this->db->query("select vl.name , vp1.name as nama, vp1.positionid, vp1.accOffice  from v_login_previlegde1 vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid
			where vl.accOffice=? and vl.NPP =?", array($accoffice, $npp))->row();
		$jobid = substr($query->positionid, -8, 6);  
		if($jobid == '999888'  ){ 
			$stat = -1;
		}else{
			$stat = 0;
		}
		if(isset($query)){
			$query->stat_pos = $stat;
		}
        echo json_encode($query);	
	}
	public function query_test(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		
		$query = $this->db->query("select vl.name , vp1.name as nama, vp1.positionid, vp1.accOffice  from v_login_previlegde1 vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid
			where  vl.loginid =?", array( $npp));
		
        echo json_encode($query->row());	
	}
	public function query_npp(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		//log_message('debug', print_r(array("fmdata"=>$fmdata), TRUE));
		//log_message('debug', print_r(array("query"=>$query), TRUE));
		$query = $this->db->query("select x.npp, DATE_FORMAT( x.DOB, '%d-%m-%Y ') as DOB, x.name, x.mobileNumber, vl.posname, vl.positionid from xemployee x join v_login_name vl ON x.npp = vl.npp where x.npp=" . $npp);
        echo json_encode($query->row());	
	}
	public function query_unit(){
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		$accoffice = $_SESSION['pengguna']->accoffice;
		$query = $this->db->query("Select x.npp, x.name, x.accOffice, y.name as uname from v_login_name x join xentitas y ON x.accOffice = y.accOffice where y.accOffice= ? and x.loginid = ?  and x.loginid = x.NPP", array($accoffice, $npp))->row();
		$query2 = $this->db->query("select vp1.positionid from v_login_previlegde1 vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid
			where vl.accOffice=? and vl.NPP =?", array($accoffice, $npp))->row();
		$jobid = substr($query2->positionid, -8, 6);  
		if($jobid == '999888'  ){ 
			$stat = -1;
		}else{
			$stat = 0;
		}
		if(isset($query)){
			$query->stat_pos = $stat;
		}
		echo json_encode($query);
		//echo json_encode($query->row());
	}
	public function query_em(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$fmdata = $this->input->post();
		$id = $fmdata['loginid'];
		
		$query = $this->db->query("select xe.*, xl.NPP as NPPxl, xl.positionid, xl.fpositionid, xl.active as activexl, xl.enabled as enabledxl, xl.created as createdxl, xl.basePositionid, xl. expired as expiredxl, xl.loginExpired, xl.snpp   
		from xemployee xe join xlogin xl ON xe.NPP = xl.NPP where xl.loginid = ". $id);
		
        echo json_encode($query->row());	
	}
	
	public function pos_unit() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  $this->input->post()['pattern'];
		$crow = $this->wfmodel->getposunit($pattern);
		
		foreach( $crow as $r )  
        {  
		   $position[] = array(   
                'pname' => $r->name, 
				'accOffice' => $r->accOffice
            );
        }  
		echo json_encode($position);
    }
	
	public function cek(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $this->input->post()['npp'];
		//log_message('debug', print_r(array("fmdata"=>$fmdata), TRUE));
		//log_message('debug', print_r(array("query"=>$query), TRUE));
		$query = $this->db->query("select npp from xemployee where npp like '%".$npp."%'");
        echo json_encode($query->row());	
	}
	/* public function query_id(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$fmdata = $this->input->post();
		$id = $fmdata['loginid'];
		
		$query = $this->db->query("select xl.positionid, xp.name as pname  from xlogin xl join xposition xp ON xl.positionid = xp.positionid   where xl.loginid = ". $id);
		
        echo json_encode($query->row());	
	} */
	
	public function gethistory(){
		$list = $this->wfmodel->gethistory();
		//var_dump($list);
		if($list != 0){
		foreach ($list as $row){
			$dat = json_decode(($row->data),true);
			//var_dump($dat["pname"]);
			if($row->mode === 'CU'){
					$def = $dat['unit'];
					$change = $dat['unitbaru'];
					$date = $dat['sdate'];
				}else{
					
					if($row->mode === 'CT'){
						$def = $dat['cposname'];
						$change = $dat['pname'];
						$date = $dat['sdate']."  s/d  ".$dat['edate'];
					}else if($row->mode === 'CP'){
						$def = $dat['cposname'];
						$change = $dat['pname'];
						$date = $dat['sdate'];
					}else{
						$def = "";
						$change = "";
						$date = "";
					}
				}
				if ($row->mode == 'UA'){
					$list_npp = $dat['nloginid'];
				}else{
					$list_npp = $dat['loginid'];
				}
				if ($row->stage > 1){
					$note = $dat['note'];
				}else{
					$note = '';
				}
			$aa[] = array(
				'list_npp'=>$list_npp,
				'id' => $row->wfid,
				'def'=>$def,
				'change'=>$change,
				'mode' => $row->mode,
				'nama' => $dat['nama'],
				'nama_init' =>  $row->name,
				'cdate' => date('d-M-Y', strtotime($row->cdate)),
				'efektifdate' => $date,
				'currActor'=> $row->currActor,
				'initiator'=>$row->initiator,
				'stage'=>$row->stage,
				'apv'=>$row->approval,
				'dateapv'=>$row->dateappr,
				'note'=>$note
			);
			
			//var_dump($dat['loginid']);
			/* foreach($dat as $key){
			$a = $key;
				var_dump($a);
			} */
			
		}
		}
		if (isset ($aa)){
		$list = $aa;
		//var_dump($list);
		$output = array(
            "recordsTotal" => $this->wfmodel->count_alladm(),
            "recordsFiltered" => $this->wfmodel->count_history(),
            "data" => $list
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
	public function querykill(){  
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		$date = $fmdata['date'];
		
/* 		$query = $this->db->query("SELECT distinct AUD_CLIENT_IP FROM jbaudit.COM_AUDIT_TRAIL where AUD_USER = ? and AUD_CLIENT_IP !=''", array($npp));
 */	
		$query = $this->db->query("SELECT distinct AUD_DATE, AUD_CLIENT_IP FROM jbaudit.COM_AUDIT_TRAIL where AUD_USER = ? and AUD_CLIENT_IP != '' and AUD_DATE like '%".$date."%' and AUD_ACTION = 'SERVICE_TICKET_CREATED' order by id DESC limit 1", array($npp));
		$val = $query->result();
        echo json_encode($val);	
	}
	/* public function proseskill(){  
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		$tanggal = $fmdata['tanggal'];
		$ipaddress = $fmdata['ipaddress']; */
		//var_dump($npp,$tanggal,$ipaddress);
	/* 	$data = array('AUD_CLIENT_IP' => '', 'AUD_SERVER_IP' => '', 'AUD_RESOURCE' => '', 'AUD_ACTION' => '', 'APPLIC_CD' => '');
		$where = "WHERE AUD_USER='".$npp."' and AUD_DAT like '%".$tanggal."%' and AUD_CLIENT_IP = '".$ipaddress."'";
		
		$this->db->update_string('jbaudit.COM_AUDIT_TRAIL', $data, $where); */
		
		/* $query = $this->db->query("UPDATE jbaudit.COM_AUDIT_TRAIL SET AUD_CLIENT_IP='', 
		AUD_SERVER_IP='', AUD_RESOURCE='', AUD_ACTION='', APPLIC_CD='' WHERE AUD_USER='".$npp."' and AUD_DATE like '%".$tanggal."%' and AUD_CLIENT_IP = '".$ipaddress."' ");
		//var_dump($query);
		if($query == FALSE)
		{
			$val = null;//without error even no row updated
		} else {
			$val = "done";
		}

        echo json_encode($val);	
	} */
	
	public function proseskill(){  
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		$tanggal = $fmdata['tanggal'];
		$ipaddress = $fmdata['ipaddress'];
		
		
		$quer2 = $this->db->query("select AUD_SERVER_IP from jbaudit.COM_AUDIT_TRAIL WHERE AUD_USER='".$npp."' and AUD_DATE like '%".$tanggal."%' and AUD_CLIENT_IP = '".$ipaddress."'");		
		$res = $quer2->row(); 
		$res_quer = json_decode(json_encode($res), True);
		$query = $this->db->query("UPDATE jbaudit.COM_AUDIT_TRAIL SET AUD_CLIENT_IP='', 
		AUD_SERVER_IP='', AUD_RESOURCE='', AUD_ACTION='', APPLIC_CD='' WHERE AUD_USER='".$npp."' and AUD_DATE like '%".$tanggal."%' and AUD_SERVER_IP = '".$res_quer['AUD_SERVER_IP']."' ");
		if($query == FALSE)
		{
			$val = null;//without error even no row updated
		} else {
			$val = "done";
		}

        echo json_encode($val);	
	}
	public function querykill2(){  
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		$date = $fmdata['date'];
		$query2 = $this->db->query("SELECT accOffice FROM jbpm.v_login_previlegde1 where loginid = ? ", array($npp));
		$filter = $query2->row();
		if ($filter->accOffice == $accoffice){
			
			$query = $this->db->query("SELECT distinct AUD_DATE, AUD_CLIENT_IP FROM jbaudit.COM_AUDIT_TRAIL where AUD_USER = ? and AUD_CLIENT_IP != '' and AUD_DATE like '%".$date."%' and AUD_ACTION = 'SERVICE_TICKET_CREATED' order by id DESC limit 1", array($npp));
			//$this->db->query("SELECT distinct AUD_DATE, AUD_CLIENT_IP FROM jbaudit.COM_AUDIT_TRAIL where AUD_USER = ? and AUD_CLIENT_IP != '' and AUD_DATE like '%".$date."%' and AUD_ACTION = 'SERVICE_TICKET_CREATED' order by id DESC limit 1", array($npp));
			$val = json_decode(json_encode($query->result()));
			if(empty($val)){
				$query3 = $this->db->query("SELECT distinct AUD_CLIENT_IP FROM jbaudit.COM_AUDIT_TRAIL where AUD_USER = ? and AUD_DATE like '%".$date."%' and AUD_ACTION = 'SERVICE_TICKET_VALIDATED' order by id DESC limit 1", array($npp));
				$filter2 = json_decode(json_encode($query3->row()));
				if(empty($filter2)){
					$error = 0;  
				}else{
					$error = 1;
				}
				
			}else{
				$error = 2;
			}
		}else{
			$val = [];
			$error = -1;
		}
		$ret = array("opts"=>$val, "error"=>$error);
        echo json_encode($ret);	
	}
	public function searchuser(){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		$pengguna = $_SESSION['pengguna'];
		//var_dump ($npp);
		if (!empty($npp)) {			
			$this->db->select('xe.npp as npp, xe.name as nama, xp.name as pos_name, xp.accOffice, xl.bloginid, xl.sloginid, xen.name as nama_unit');
			$this->db->from('xlogin xl');
			$this->db->join('xemployee xe', 'xl.loginid = xe.NPP');
			$this->db->join('xposition xp', 'xl.positionid = xp.positionid');
			$this->db->join('xentitas xen', 'xp.accOffice = xen.accOffice');
/* 			if ($pengguna ->idm_init > 0 && $pengguna->idm_appr > 0 && $pengguna ->idm_idadmin > 0 && $pengguna->idm_ithde > 0){
				}else{
					$this->db->where('xp.accOffice', $accoffice);
				} */
			
			if (is_numeric($npp)) {
				
				$this->db->where('xe.NPP', $npp);
				$this->db->or_where('xl.bloginid', $npp);
				$this->db->or_where('xl.sloginid', $npp);
			} else {
				$this->db->like('xe.name', $npp, 'both');
			}
			
			
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
	
	public function searchuser2(){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		$pengguna = $_SESSION['pengguna'];
		//var_dump ($npp);
		if (!empty($npp)) {		
			if (!empty($npp)) {	
				$this->db->select("xe.email as email, xe.npp as npp,xe.mobileNumber as nohp, xe.name as nama, xp.name as pos_name, xp.accOffice, xl.bloginid as sloginid, xen.name as nama_unit, (SELECT GROUP_CONCAT(apps SEPARATOR ', ') FROM jbpm.v_uamuser where loginid = xe.npp) as apps");
			}else{
				$this->db->select('xe.npp as npp, xe.name as nama, xp.name as pos_name, xp.accOffice, xl.bloginid as sloginid, xen.name as nama_unit');
			}
			
			$this->db->from('xlogin xl');
			$this->db->join('xemployee xe', 'xl.loginid = xe.NPP');
			$this->db->join('xposition xp', 'xl.positionid = xp.positionid');
			$this->db->join('xentitas xen', 'xp.accOffice = xen.accOffice');
/* 			if ($pengguna ->idm_init > 0 && $pengguna->idm_appr > 0 && $pengguna ->idm_idadmin > 0 && $pengguna->idm_ithde > 0){
				}else{
					$this->db->where('xp.accOffice', $accoffice);
				} */
			if ( $accoffice >= 800){
				$where_sya = " xp.accOffice < 900 and xp.accOffice >= 800";
				$this->db->where($where_sya);
			}
			if (is_numeric($npp)) {
				
				$this->db->where('xe.NPP', $npp);
				$this->db->or_where('xl.bloginid', $npp);
			} else {
				$this->db->like('xe.name', $npp, 'both');
			}
			
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
		public function query_sco(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		//log_message('debug', print_r(array("fmdata"=>$fmdata), TRUE));
		//log_message('debug', print_r(array("query"=>$query), TRUE));
		$query = $this->db->query("select xe.name, xl.sloginid from xlogin xl join xposition xp on xl.positionid = xp.positionid join xemployee xe on xl.loginid = xe.npp where xl.loginid=?", array ($npp))->row();
	  if(is_null($query->sloginid) ){
			$unit = null;
			$pname = null;
			$posid = null;
		}else{
			$query2 = $this->db->query("select xp.accOffice, xp.positionid, xp.name from xlogin xl join xposition xp on xl.positionid = xp.positionid where xl.loginid=" . $query->sloginid)->row();
			$unit = $query2->accOffice;
			$pname = $query2->name;
			$posid = $query2->positionid;
		}
		$data = array(   
                'nama' => $query->name, 
				'snpp' => $query->sloginid,
				'unit' => $unit,
				'pname' =>$pname,
				'posid' => $posid
            );
		echo json_encode($data);	
	}
	public function quer_pos() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  $this->input->post()['pattern'];
		$accoffice = $this->input->post()['accoffice'];
		$data = $this->db->query("select * from xposition where accOffice = ".$accoffice." AND name like '%" . $pattern . "%'");
		$crow = $data->result();
		
		foreach( $crow as $r )  
        {  
		   $position[] = array(  
				'accOffice' =>$r->accOffice,
                'pname' => $r->name, 
				'positionid' => $r->positionid
            );
        }  
		echo json_encode($position);
    }
	public function save_sco() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$fmdata = $this->input->post();
		$time = '2019-08-01 00:00:00';
		
		$xp = array('sloginid'=>$fmdata['sco']);
		$query = $this->db->query("select xl.sloginid from xlogin xl join xposition xp on xl.positionid = xp.positionid join xemployee xe on xl.loginid = xe.npp where xl.loginid=?", array ($fmdata['npp']))->row();
		if(isset($query)){
			$xcp = array('loginid'=>$fmdata['sco'], 'NPP'=>$fmdata['npp'],'positionid'=>$fmdata['posid'],
					'expired'=> date('Y-m-d H:i',strtotime($time)));
			$ustr2 = $this->db->insert_string('xlogin', $xcp);
		}else{
			$xcp = array('loginid'=>$fmdata['sco'], 'NPP'=>$fmdata['npp'],'positionid'=>$fmdata['posid']);
			$ustr2 = $this->db->update_string('xlogin',$xcp,'loginid='. $fmdata['sco'] );
		}
		$ustr = $this->db->update_string('xlogin',$xp,'loginid='. $fmdata['npp']  );
		$this->db->query($ustr);
		$this->db->query($ustr2);
		if ($this->db->affected_rows() > 0)
		{
			$output = array(  
				'status' =>"success",
            );
			echo json_encode($output);
           
		
		}
		else
		{
		  return FALSE;  
		}
    }
			public function get_number() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$npp =  $this->input->post()['npp'];
		$data = $this->db->query("select mobileNumber as hp from xemployee where npp = '".$npp."'");
		$crow = $data->row();
		
		echo json_encode($crow);
    }
		public function load_infouser()
	{	
		//$myid = $this->cas->getmycas_login(array('idm_idadmin', 'idm_appr'));
		$this->page->template('site_tpl');
		$this->page->view('templates/infousersso');
	}
		public function load_adm()
	{	
		$myid = $this->cas->getmycas_login(array('idm_idadmin'));
		$this->page->template('site_tpl');
		$this->page->view('templates/adm_history');
	}
	public function popup()
	{
		$response = $this->load->view('templates/v_app','');
		echo($response);
	}
	public function query_level(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		$loginid = $_SESSION['pengguna']->loginid;
		$cek = $this->db->query("select xp.accOffice2 as acc from xlogin xl join xposition xp on xl.positionid = xp.positionid where xl.loginid = ".$loginid)->row();
		
		if(isset($cek->acc)){
			$accoffice = $cek->acc;
			$unit = accOffice2;
			$acc3 = not;
		}else{
			$accoffice = $_SESSION['pengguna']->accoffice;
			$unit = accOffice;
			$acc3 = '';
		} 
		

		 
		$query = $this->db->query("select vl.DOB as dob, vp1.icons,vl.name , vp1.name as nama, vp1.positionid, vp1.accOffice  from v_login_previlegde1 vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid
			where vp1.accOffice2 is ".$acc3." null and vp1.".$unit."=? and vl.loginid =?", array($accoffice, $npp))->row();
		
		if($query->accOffice == '89' OR $query->accOffice == '22' ){
			$max = '15';
		}else if($query->accOffice == '709' ){
			$max = '16';
		}else if($query->accOffice < 600){
			$max = '14';
		}else{
			$max = substr($query->icons, 2, -6);
		}  
		$output = array(
            "name" => $query->name,
			"nama" => $query->nama,
			"dob" => $query->dob,
			"positionid" => $query->positionid,
			"accOffice" => $query->accOffice,
			"level" => substr($query->icons, 2, -6),
			"maxlvl" => $max
        );
        echo json_encode($output);	   
	}
	
	public function query_bina(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		//$accoffice = $_SESSION['pengguna']->accoffice; 
		$fmdata = $this->input->post(); 
		$npp = $fmdata['npp'];
		//log_message('debug', print_r(array("fmdata"=>$fmdata), TRUE));
		//log_message('debug', print_r(array("query"=>$query), TRUE));
		$query = $this->db->query("select npp, status from xpool where nppORG = '" . $npp . "'");
		$res = $query->row();
		if ($res->status == 'RESERVED'){
			$query2 = $this->db->query("select x.npp, DATE_FORMAT( x.DOB, '%d-%m-%Y ') as DOB, x.name, x.mobileNumber, vl.posname, vl.positionid from xemployee x join v_login_name vl ON x.npp = vl.npp where x.npp=" . $res->npp);
			$result = $query2->row();
		}else{
			$result = $query->row();
		}
        echo json_encode($result);	
	}
	
	public function query_mobile(){ //untuk menampilkan hasil query no hp double 
		$fmdata = $this->input->post();
		$mobile = $fmdata['mobileNumber'];
		$type = $fmdata['type'];
		$accOffice = $_SESSION['pengguna']->accoffice;
			
		if (substr($mobile, 0, 2) == 62){
			$mobile2 = "0".substr(trim($mobile),2);
		}else if(substr($mobile, 0, 1) == 0){
			$mobile2 = "62".substr(trim($mobile),1);
		}
		//var_dump($mobile2);
		if (($type == 'UA') OR ($type == 'UH')){
			$nama = $fmdata['nama'];
//			$query = $this->db->query("select vl.npp, vl.mobileNumber, xp.jobid from v_login_name vl join xposition xp on vl.positionid = xp.positionid  where vl.name like '".$nama."%' and vl.mobileNumber = '" . $mobile . "' or vl.mobileNumber = '".$mobile2."'");
			$query = $this->db->query("select vl.NPP, vl.mobileNumber, xp.jobid from v_login_name vl join xposition xp on vl.positionid = xp.positionid  where vl.mobileNumber = '" . $mobile . "' or vl.mobileNumber = '".$mobile2."'");
			$check = $query->row();
			if($check->NPP > 80000 and $check->jobid == '999888'){
				$res = NULL;
			}else if($accOffice > 800 and $accOffice < 900 and $check->jobid == '999888' ){
				$res = NULL;
			}else{
				//$query = $this->db->query("select mobileNumber from xemployee where mobileNumber like '%" . $mobile . "%' or mobileNumber like '%".$mobile2."%'");
				$query = $this->db->query("select mobileNumber from xemployee where mobileNumber = '" . $mobile . "' or mobileNumber = '".$mobile2."'");
				$row = $query->row();
				if(isset($row)){
					$res = $row;
				}else{
					$res = $check->mobileNumber;
				}
			}
			
		}else{
			//$query = $this->db->query("select mobileNumber from xemployee where mobileNumber like '%" . $mobile . "%' or mobileNumber like '%".$mobile2."%'");
			$query = $this->db->query("select mobileNumber from xemployee where mobileNumber = '" . $mobile . "' or mobileNumber = '".$mobile2."'");
			$res = $query->row();
		}
		
		
		
        echo json_encode($res);	
	}
	
	public function query_mail(){ //untuk menampilkan hasil query email double
		$fmdata = $this->input->post();
		$email = $fmdata['email'];
		/* $query = $this->db->query("select email from xemployee where email like '" . $email ."%'");
		$res = $query->row(); */
		$query = $this->db->query("select vl.NPP, vl.email, xp.jobid from v_login_name vl join xposition xp on vl.positionid = xp.positionid where vl.email like '" . $email ."%'");
		$check = $query->row();
		if($check->NPP > 80000 and $check->jobid == '999888'){
			$res = NULL;
		}else{
			$res = $check;
		}
		
        echo json_encode($res);	
	}
	
	public function usr_unlock(){
		if($this->input->post('request'))
        {
			//$res = $this->db->query("select xe.NPP as npp,xe.Name as nama, vl.accOffice as unit, xe.locked  from v_login_previlegde1 vl join xemployee xe on vl.loginid = xe.NPP
			//where loginid =?", array($this->input->post('request')));
			$accoffice = $_SESSION['pengguna']->accoffice;
			$res = $this->db->query("SELECT xe.NPP as npp,xe.Name as nama, xp.accOffice as codeunit, xe.locked, xen.name as unit
			from xemployee xe 
			join xlogin xl on xl.loginid = xe.NPP
			join xposition xp on xl.positionid = xp.positionid
			join xentitas xen on xp.accOffice = xen.accOffice
			where xe.NPP =? and  xp.accOffice =?", array($this->input->post('request'),$accoffice));

			$aa = $res->row();
			if($aa->npp == null){
				$list = 0;
			}else{
			$list[] = array(
				'npp'=>$aa->npp,
				'nama' => $aa->nama,
				'code_unit' => $aa->codeunit, 
				'unit' => $aa->unit, 
				'locked' => $aa->locked
			);
			}
		}else{
			$list = 0;
		}
			

		if ($list != 0){
		$output = array(
            "recordsTotal" => 1,
            "recordsFiltered" => 1,
            "data" => $list
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
	
	public function unlock_cas()
	{
		$query = $this->db->query('UPDATE `jbpm`.`xemployee` SET `locked`=0, `nextAllowedAttempt`=NULL, `failCount`=NULL WHERE `NPP`=?', array($this->input->post('npp')));
			if($this->db->affected_rows() >=0){
				$response = 1;
			}else{
				$response = 0;
			}
		echo json_encode($response);
	}
	
} 