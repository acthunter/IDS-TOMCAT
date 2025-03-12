<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class XMain extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('xwf_model', 'wfmodel');
		$this->initparam();		
	}
	private function initparam(){
		$this->apps_list = array(
				"icons"=>array("target"=>"banc", "desc"=>"ICONS", "delivery"=>"online")
				/*"idminit"=>array("target"=>"idminit", "desc"=>"apps Identity Management", "delivery"=>"online"),
				"prsk"=>array("target"=>"periskop", "desc"=>"Periskop", "delivery"=>"manual"),
				"psn"=>array("target"=>"Email", "desc"=>"Email bni.co.id", "delivery"=>"pinmailer"),*/
			);
	}
	public function index()
	{	
		$myid = $this->cas->getmycas_login(array('idm_idadmin'));
		//$getpass = json_decode(json_encode($myid, true));
		$this->page->template('site_tpl');
		if($myid > 0){
			$this->page->view('v_resetpass');
		} else{
			$this->page->view('v_reseticon');
		}
	}
		//$this->page->template('enduser_tpl');
		//$this->page->view('v_resetpass');
	function npp(){
		$myid = $this->session->userdata('pengguna')->loginid;
		echo json_encode($myid);
	}
	public function handle(){
		$fmdata = $this->input->post();
		if ($fmdata == null){
			return $this->index();
		} else {
			$uniqid = uniqid("");
			if ($fmdata['reqtype'] == 'resetPass'){
				//input target, npp, mobileNumber
/* 				if($_SESSION['pengguna']->idm_idadmin == 4){
					$pwd = 'endsession_full';
				}else{ */
					$pwd = 'endsession_full';
				/* } */
				//var_dump($_SESSION['pengguna']->idm_idadmin);
				$loginid = $fmdata['npp'];
				if (strlen($loginid) > 5 ){
					$queryuser = $this->db->query("select bloginid from v_login_previlegde1
						where loginid =?", array($loginid));
					$cpriv = $queryuser->row();
					if ($cpriv != null){
						$userid = $cpriv->bloginid;
					}else{
						$userid = $loginid;
					}
				}else{
					$userid = $loginid;
				}
				
				$rdetail = array("username"=>$userid, 
					"target"=>$fmdata['target'], "password" => $pwd, "terminal" => $fmdata['terminal']);
				
				//$rdetail = array("username"=>$fmdata['npp'],"target"=>$fmdata['target'], "password" => $pwd, "terminal" => $fmdata['terminal']);
				$sdata = array("reqtype"=>$fmdata['reqtype'], "detail"=>json_encode($rdetail));
				$this->load->library('restclient', array());
				$dest_url = $this->config->item('cas_url') . 'frontend/target';
				log_message('debug', print_r(array("cas.url"=>$dest_url), TRUE));
				log_message('debug', print_r(array("handle.sdata"=>$sdata), TRUE));

				
				$breply = $this->restclient->post($dest_url, $sdata);

				log_message('debug', print_r(array("handle.breply "=>$breply), TRUE));
				//$breply = array("res":"ok");
				//$breply = array("res"=>"err mobile number tidak ada", "data"=>$fmdata);
				echo json_encode($breply);
			} 
		}
	}
	
	public function euser_handle(){
		$fmdata = $this->input->post();
		if ($fmdata == null){
			return $this->index();
		} else {
			$uniqid = uniqid("");
			if ($fmdata['reqtype'] == 'showPassword'){
				//input target, token
				/*$this->ci->load->library('restclient', array());
				$dest_url = $this->ci->config->item('cas_url') . 'idmlink';
				log_message('debug', print_r($dest_url, TRUE)); 
				$breply = $this->ci->restclient->post($dest_url, $myparam);
				return $breply;*/
				$breply = array("res"=>"ok", "pass"=>"abcd");
				echo json_encode($breply);
			}
		}
	}
	public function valid_priv(){
		$fmdata = $this->input->post();
		$loginid = $this->session->userdata('pengguna')->loginid;
		$query = $this->db->query("select * from v_login_previlegde1
			where loginid =?", array($fmdata['npp']));
		$opts = array();
		$cpriv = $query->row();
		
		if ($cpriv != null){
			foreach($this->apps_list as $capps => $cval ){
				if (array_key_exists($capps, $cpriv) && $cpriv->$capps != null){
					$opts[$capps] = $cval;
				}
			}
		}
		
		$ret = array("opts"=>$opts,"npp"=>$loginid);
		echo json_encode($ret);
	}
	public function getval(){
		if($this->input->post('request'))
        {
			$res = $this->db->query("select xe.NPP as npp,xe.Name as nama, vl.accOffice as unit, xe.locked  from v_login_previlegde1 vl join xemployee xe on vl.loginid = xe.NPP
			where loginid =?", array($this->input->post('request')));
			$aa = $res->row();
			$list[] = array(
				'npp'=>$aa->npp,
				'nama' => $aa->nama,
				'unit' => $aa->unit, 
				'locked' => $aa->locked
			);
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
		public function unlocked()
	{
		$query = $this->db->query('UPDATE `jbpm`.`xemployee` SET `locked`=0, `nextAllowedAttempt`=NULL, `failCount`=NULL WHERE `NPP`=?', array($this->input->post('npp')));
			if($this->db->affected_rows() >=0){
				$response = 1;
			}else{
				$response = 0;
			}
		echo json_encode($response);
	}
	public function locked()
	{	
		$myid = $this->cas->getmycas_login(array('killbanc'));
		//$myid2 = $this->cas->getmycas_login(array('idminit'));
		$this->page->template('site_tpl');
			$this->page->view('v_locked');
	}
	public function killusersso()
	{	
		$myid = $this->cas->getmycas_login(array('killbanc'));
		//$myid2 = $this->cas->getmycas_login(array('idminit'));
		$this->page->template('site_tpl');
			$this->page->view('v_killuser');
	}
	
	public function querykill(){  
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		$date = $fmdata['date'];
		$query = $this->db->query("SELECT distinct AUD_DATE, AUD_CLIENT_IP FROM jbaudit.COM_AUDIT_TRAIL where AUD_USER = ? and AUD_CLIENT_IP != '' and AUD_DATE like '%".$date."%' and AUD_ACTION = 'SERVICE_TICKET_CREATED' order by id DESC limit 1", array($npp));
		$val = $query->result();
        echo json_encode($val);	
	}
	public function querykill2(){  
		$accoffice = $_SESSION['pengguna']->accoffice;
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		$date = $fmdata['date'];
		$query2 = $this->db->query("SELECT accOffice FROM jbpm.v_login_previlegde1 where loginid = ? ", array($npp));
		$filter = $query2->row();
		if ($_SESSION['pengguna']->idm_idadmin == 4 ){
			//var_dump("aa");
			$query = $this->db->query("SELECT distinct AUD_DATE, AUD_CLIENT_IP FROM jbaudit.COM_AUDIT_TRAIL where AUD_USER = ? and AUD_CLIENT_IP != '' and AUD_DATE like '%".$date."%'  order by id DESC limit 1", array($npp));
			//$this->db->query("SELECT distinct AUD_DATE, AUD_CLIENT_IP FROM jbaudit.COM_AUDIT_TRAIL where AUD_USER = ? and AUD_CLIENT_IP != '' and AUD_DATE like '%".$date."%' and AUD_ACTION = 'SERVICE_TICKET_CREATED' order by id DESC limit 1", array($npp));
			$val = $query->result();
			//var_dump(json_decode(json_encode($query->result())));
			if(empty($val)){
				$error = 0;
			}else{
				$error = 1;
			}
		}else if (($filter->accOffice == $accoffice) or ($_SESSION['pengguna']->idm_init > 0)){
			$query = $this->db->query("SELECT distinct AUD_DATE, AUD_CLIENT_IP FROM jbaudit.COM_AUDIT_TRAIL where AUD_USER = ? and AUD_CLIENT_IP != '' and AUD_DATE like '%".$date."%' and AUD_ACTION = 'SERVICE_TICKET_CREATED' order by id DESC limit 1", array($npp));
			//$this->db->query("SELECT distinct AUD_DATE, AUD_CLIENT_IP FROM jbaudit.COM_AUDIT_TRAIL where AUD_USER = ? and AUD_CLIENT_IP != '' and AUD_DATE like '%".$date."%' and AUD_ACTION = 'SERVICE_TICKET_CREATED' order by id DESC limit 1", array($npp));
			$val = $query->result();
			//var_dump(json_decode(json_encode($query->result())));
			if(empty($val)){
				$error = 0;
			}else{
				$error = 1;
			}	
		}else{
			$val = null;
			$error = -1;
		}
		$ret = array("opts"=>$val, "error"=>$error);
        echo json_encode($ret);	
	}
	
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
		/*------------------------------------ update data SSO ----------------------------------*/
	
	public function updatedata()
	{	
		$myid = $this->cas->getmycas_login(array('idm_idadmin'));
		$this->page->template('site_tpl');
		$this->page->view('v_updatedata');
	}
	public function inq_user()
	{	
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		
		$query = $this->db->query("select xe.name as nama_unit, vl.name, vl.email , vp1.name as nama, vp1.positionid, vp1.accOffice as unit  from v_login_previlegde1 vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid
				inner join xentitas xe on xe.accOffice = vl.accOffice
			where vl.NPP =?", array($npp))->row();
		$jobid = substr($query->positionid, -8, 6); 
		if($jobid == '999888'  ){
			$stat = -1;
		}else{
			$stat = 0;
		}
		if(isset($query)){
			$query->stat = $stat;
		}
		echo json_encode($query);	
	}
	
	public function pos_search() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  $this->input->post()['pattern'];
		$unit =  $this->input->post()['unit'];
		$crow = $this->wfmodel->getposearch($pattern, $unit);
		
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
	
	public function pos_unit() //pencarian data unit bedasarkan inputan hal v_kewenangan
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
	public function proses() //proses untuk penginputan log dan update data
	{   
		$pstdata =  $this->input->post();
		$loginid = $this->session->userdata('pengguna')->loginid;
		$namauserid = $this->session->userdata('pengguna')->nama;
		if ($pstdata['email_old'] == $pstdata['email_']){
			$pstdata['email_'] = "";
		}
		if ($pstdata['unit_old'] == $pstdata['unit_new']){
			$pstdata['unit_new'] = "";
		}
		if ($pstdata['posisi_old'] == $pstdata['posisi_new']){
			$pstdata['posisi_new'] = "";
		}
		$rdetail = array("loginid"=>$pstdata['npp'],"nama"=>$pstdata['nama'], 
					"email_old"=>$pstdata['email_old'], "email_new" => $pstdata['email_'],
					"unit_old"=>$pstdata['unit_old'], "unit_new" => $pstdata['unit_new'],
					"posisi_old"=>$pstdata['posisi_old'], "posisi_new" => $pstdata['posisi_new']);
		$wfpp = (object) array('userid'=>$loginid,'namauserid'=>$namauserid,'ket'=>$pstdata['keterangan'], 'reqdata'=>json_encode($rdetail));
		$ustr = $this->db->insert_string('xlogupdate', $wfpp);
		$this->db->query($ustr);
		if ((!empty($pstdata['email_'])) && (!empty($pstdata['posisi_new']))){
			$crow1 = $this->wfmodel->update_mail($pstdata['email_'],$pstdata['npp']);
			$crow2 = $this->wfmodel->update_pos($pstdata['posisi_new'],$pstdata['npp']);
			if ($crow1){
				if ($crow2){
					$crow = true;
				}
			}
		}else if (!empty($pstdata['email_'])){
			$crow = $this->wfmodel->update_mail($pstdata['email_'],$pstdata['npp']);
		}else if (!empty($pstdata['unit_new']) && !empty($pstdata['posisi_new']) ){
			
			$crow = $this->wfmodel->update_pos($pstdata['posisi_new'],$pstdata['npp']);
			if ($crow){
				$crow2 = $this->wfmodel->update_apps($pstdata['unit_new'],$pstdata['npp']);
			}
			
		}else if (!empty($pstdata['unit_new']) || !empty($pstdata['posisi_new']) ){
			//$crow = $this->wfmodel->update_pos($pstdata['posisi_new'],$pstdata['npp']);
				$crow = $this->wfmodel->update_pos($pstdata['posisi_new'],$pstdata['npp']);
			
		}else{
			$crow = 0;
		}
		
		if ($crow) {
			$breply ='TRUE';
		}else if ( $crow === 0){
			$breply =0;
		}else{
			$breply ='FALSE';
		}
		echo json_encode($breply);
    }
} 