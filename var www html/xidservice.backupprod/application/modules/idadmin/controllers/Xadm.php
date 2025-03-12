<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xadm extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		

	}
	public function index()
	{	
		$this->page->template('site_tpl');
		$this->page->view("v_adm");
	}
	
	
	public function search() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		//$accoffice = $this->session->userdata('accOffice');
		//var_dump($accOffice);
		$fmdata = $this->input->post();
		$search = $fmdata['srch-term'];
		$sdate = date('Y-d-m ',strtotime($fmdata['sdate']));
		$edate = date('Y-d-m',strtotime($fmdata['edate']));
		$mode = $fmdata['mode2'];
		$accOffice = $_SESSION['pengguna']->accoffice;
		
		
		//log_message('debug', print_r(array("search1"=>$search), TRUE));
		if ($mode == 'id'){
			if ($search != null){
				
				//var_dump($accOffice);
				$id = $this->db->query("Select id from xwfparam where accOffice=? and id =? ", array($accOffice, $search));
				$list = $id->row(); 
				//var_dump($list);
			}else{
				$list = 0 ; 
			}
		}else if($mode == 'date'){
			
					$id = $this->db->query('Select wfid from xreviewpos where accoffice=? and  DATE(cdate)  BETWEEN ? and ? ', array( $accOffice, $sdate, $edate));  
					$cek = $id->row();
					if (isset($cek)){
						$crow = $id->result();
						//var_dump($crw);
						foreach( $crow as $r )  
						{  					
						   $list [] =  $r->wfid;
						
						} 
					}else{
						$list = 0;
					}
					//var_dump($list);
				//$list = [].concat.apply([], $ar);
				//log_message('debug', print_r(array("mode.date"=>$list), TRUE));
		}else if ($mode == 'npp'){
			$id = $this->db->query("Select id from xwfparam where initiator =?",  array($search) );
			$crow = $id->result(); 
				foreach( $crow as $r )  
				{  
				   $list [] =  $r->id;
				} 	
		}
		
		//log_message('debug', print_r(array("id.getadm"=>$id), TRUE));
		//log_message('debug', print_r(array("search2"=>$list), TRUE));
		echo json_encode($list);
    } 

	public function getadm(){
		$fmdata = $this->input->post();
		$accOffice = $_SESSION['pengguna']->accoffice;
		if($fmdata['id'] == '0'){
			$myid = $this->db->query("Select vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
			from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid WHERE xw.accOffice=? ", array($accOffice));
		}else{
			//$a = join(',', $data);
			if ($fmdata['mode'] == 'date' || $fmdata['mode'] == 'npp'){
				$dcd_res = json_decode($fmdata['id']);
				$data = implode("','",$dcd_res);
			}else{
				$data = $fmdata['id'];
			}
			
			/* $myid = $this->db->query("Select vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
			from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid
			where xw.id IN ('".$data."')"); */
			
			$myid = $this->db->query("Select vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
			from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid
			where xw.accOffice =? and xw.id IN ('".$data."')", array($accOffice));
			
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
			"data" =>  $list,
        );
		}
        echo json_encode($output);
		//echo json_encode($myid);
	}
}