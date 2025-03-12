<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xids extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$_SESSION['pengguna']){
			redirect($this->cas->cas_server_url . "/login");
		}
		$this->load->database();		
		$this->load->model('xwf_model', 'wfmodel');
	}

	public function index()
	{	
		
		//$myid = $this->cas->allow_login('idm_appr OR idm_init');
		//$myid = $this->cas->allow_login2();
		//$myid = $this->cas->allow_logindynmodal();
		$myid = $this->cas->getmycas_login(array('idm_init', 'idm_appr'));
		log_message('debug', print_r(array("xids.index.pengguna"=>$_SESSION['pengguna']), TRUE));
		$data['myid'] = $this->session->userdata('pengguna');
		$this->page->view('v_ctest');
	}
	
		public function faq()
	{			
		$this->page->view('v_faq');
	}
	public function loadform(){
		$fdt = $this->input->post();
		$fdata = array ("modal_id" => $fdt['modal_id'], "mode"=>$fdt['mode']);
		$ret = null;
		if (preg_match('/^(CP|RP|RI|UA|A|AI|AF|EM|CT|CU|CM|ADT|RS|VL|HS|US|SC|UC)/',$fdt['mode'])){
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
/* 		var_dump($myid);
		var_dump($fdt['mode']); */
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
		if($mode == 'UC')
			$wfid = $fdt['reqid'];
		else
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
	
	public function pos_search2() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  $this->input->post()['pattern'];
		$crow = $this->wfmodel->getposearch($pattern);
		//var_dump($crow);
		foreach( $crow as $r )  
        {  
		   $position[] = array(  
				'accOffice' =>$r->accOffice,
				'subbranch' =>$r->jobseq,
                'pname' => $r->name, 
				'positionid' => $r->positionid
            );
        }  
		echo json_encode($position);
    }
	 public function search() //pencarian data posisi bedasarkan inputan hal v_kewenangan
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
				$myid = $this->db->query("Select vlm.name, xw.id, xr.data, xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
				from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid
				where xw.id = " . $data );
				//var_dump($data);
			}else if ($mode == 'npp'){
				//var_dump($dat);
				$dat = json_decode($data);
				//$array=explode("','", $data);
				$array = implode("','",(array)$dat);
				//var_dump($array);
				$myid = $this->db->query("Select vlm.name, xw.id,  xr.data, xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
				from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid
				where xw.id IN ('".$array."')");
				//var_dump($data);
			}else{
				$myid = $this->db->query("Select vlm.name, xw.id, xr.data, xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
				from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid
				where xw. IN ('".$array."')");
			}
		}else{
			$myid = $this->db->query("Select vlm.name, xw.id, xr.data, xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
		from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid");
		}
		//$list = $myid->result();
		foreach ($myid->result() as $row){
			$dat = json_decode(($row->data),true);
			$aa[] = array(
				'list_npp'=>$dat['loginid'],
				'id' => $row->id,
				'mode' => $row->mode,
				'name' => $row->name,
				'cdate' => $row->cdate,
				'currActor'=> $row->currActor,
				'initiator'=>$row->initiator
			);
			//var_dump($dat['loginid']);
			/* foreach($dat as $key){
			$a = $key;
				var_dump($a);
			} */
		}
		$list = $aa;
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
	}
	
	
	public function getadm2(){
		$fmdata = $this->input->post();
		$data = $fmdata['id'];
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
	
	public function getadm_test(){
		$list = $this->wfmodel->getadm();
		//var_dump($list);
		foreach ($list as $row){
			$dat = json_decode(($row->data),true);
			$aa[] = array(
				'list_npp'=>$dat['loginid'],
				'id' => $row->wfid,
				'mode' => $row->mode,
				'name' => $row->name,
				'cdate' => $row->cdate,
				'currActor'=> $row->currActor,
				'initiator'=>$row->initiator,
				'stage'=>$row->stage
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
            "recordsTotal" => $this->wfmodel->count_alladm(),
            "recordsFiltered" => $this->wfmodel->count_adm(),
            "data" => $list
        );
		}else{
			$output = array(
            "data" => 0
        );
		}
		echo json_encode($output);
	}
	
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
					$def = $dat['cposname'];
					$change = $dat['pname'];
					if($row->mode === 'CT'){
						$date = $dat['sdate']."  s/d  ".$dat['edate'];
					}else{
						$date = $dat['sdate'];
					}
				}
			$aa[] = array(
				'list_npp'=>$dat['loginid'],
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
				'stage'=>$row->stage
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
	public function query(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		
		$query = $this->db->query("select vl.name , vp1.name as nama, vp1.positionid, vp1.accOffice, vl.mobileNumber from v_login_previlegde1 vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid
			where vl.accOffice=? and vl.loginid =?", array($accoffice, $npp));
		
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
		$query = $this->db->query("Select x.npp, x.name, x.accOffice, y.name as uname from v_login_name x join xentitas y ON x.accOffice = y.accOffice where x.NPP = ". $npp);
		echo json_encode($query->row());
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
	public function getaudit(){
		$list = $this->wfmodel->getaudit();
		
		foreach ($list as $row){
			//$dat = json_decode(($row->data),true);
			$aa[] = array(
				'id_rd'=>$row->id_rd,
				'loginid_target' => $row->loginid_target,
				'mn_target' => $row->mn_target,
				'position_target' => $row->position_target,
				'reviewer' => $row->reviewer,
				'periode'=> $row->periode,
				'adm_initiator'=>$row->adm_initiator,
				'appr'=>$row->appr
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
            "recordsTotal" => $this->wfmodel->count_allaudit(),
            "recordsFiltered" => $this->wfmodel->count_audit(),
            "data" => $list
        );
		}else{

			$output = array(
            "recordsTotal" => $this->wfmodel->count_allaudit(),
            "recordsFiltered" => $this->wfmodel->count_audit(),
            "data" => 0
        );
		}
		echo json_encode($output);
	}
	public function sess_user(){
		if ($this->session->userdata('pengguna')){
				$output = "valid";		
		}else{}
	}
} 