<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xwf_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	public function getreqappr(){		
		$this->req_appr();
		$quer = $this->db->get();
		
		$result =  $quer->result();
		log_message('debug', print_r(array("myjob"=>$this->db->last_query()), TRUE)); 
		return $result;
	}
	public function count_allreq2()
    {
        $this->req_appr();
        return $this->db->count_all_results();
    }
	public function req_appr(){
		$this->db->select('xwfparam.id, xrequest.doc_date as tglsrt, xrequest.key1 as nosrt, xrequest.order_time as tglreq, xwfparam.initiator as requestor, v_login_name.name as name, xwfparam.stage');
		$this->db->from('xrequest');
		$this->db->join('xwfparam', 'xrequest.reqid = xwfparam.id');
		$this->db->join('v_login_name', 'v_login_name.NPP = xwfparam.initiator');
		$this->db->where('stage !=', '0'); 
		$this->db->where('stage <', '3'); 
		
		$i = 0;

		$column_search = array('xrequest.key1','xwfparam.initiator','xrequest.doc_date');
        foreach ($column_search as $item) // loop column 
        {
			
            if($this->input->post('request')) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('request'));
                }
                else
                {
                    $this->db->or_like($item, $this->input->post('request'));
                }
 
                if(count($column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
		
		//$this->_get_datatables_query2( $column_search, $column_order);
		$this->db->order_by('xwfparam.id', 'DESC');
		$this->db->limit($_POST['length'], $_POST['start']);
	}
	public function listreq(){
		//$this->db->select('GROUP_CONCAT(transitRepo.stat) as sendpass, xrequest.changed_time as tgl_kirim, xrequest.key1,xrequest`.`srctype` as typereq, xrequest.order_time, xrequest.doc_date, transitRepo.qid, transitRepo.dateReceived, transitRepo.loginid, xrequest.accOffice, xrequest.status,    transitRepo.id as idpass,xrequest.id as reqid, GROUP_CONCAT(transitRepo.target) as apps, GROUP_CONCAT(transitRepo.reqtype) as req');
		$this->db->select('transitRepo.status as sendpass,transitRepo.userid as userlock, `xrequest`.`key1`, `xrequest`.`srctype` as `typereq`, `xrequest`.`order_time`, `xrequest`.`doc_date`, `transitRepo`.`qid`, `transitRepo`.`lastRetry` as tgl_kirim , `transitRepo`.`dateReceived`, `transitRepo`.`loginid`, `xrequest`.`accOffice`, `xrequest`.`status`, `transitRepo`.`id` as `idpass`, `xrequest`.`id` as `reqid`, transitRepo.target apps, transitRepo.reqtype as req');
		$this->db->from('transitRepo');
		$this->db->join('xrequest', 'xrequest.id = transitRepo.reqid');
		$this->db->join('xentitas', 'xrequest.accOffice = xentitas.accOffice');
		$this->db->not_like('xrequest.status', 'X'); 
		
		/* $this->db->where('xentitas.accOffice', $_SESSION['pengguna']->accoffice); */
		$i = 0;
		if($this->input->post('request')){
			$column_search = array('xrequest.key1','transitRepo.loginid','xrequest.doc_date');
			foreach ($column_search as $item) // loop column 
			{
				
				if($this->input->post('request')) // if datatable send POST for search
				{
					  
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, $this->input->post('request'));
					}
					else
					{
						$this->db->or_like($item, $this->input->post('request'));
					}
	 
					if(count($column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
		}else{
			$column_search2 = array('xrequest.status','transitRepo.qid');
			foreach ($column_search2 as $item2) // loop column 
			{
				
				if($this->input->post('status') and $this->input->post('typereq')){
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						if($this->input->post('status') == 'T'){
							$this->db->not_like($item2, 'S');
							$this->db->or_not_like($item2, 'T');
							
						}else if($this->input->post('status') == ''){
						}else{
							$this->db->like($item2, $this->input->post('status'));
							$this->db->where('transitRepo.qid ', NULL, FALSE);
						}
						
						if($this->input->post('typereq') == 'cm'){
							$this->db->where('srctype', 'cm');
							
						}else if($this->input->post('typereq') == 'sr'){
							$this->db->where('srctype', 'sr');
						}else if($this->input->post('typereq') == 'rm'){
							$this->db->where('srctype', 'rm');
						}else{
							$this->db->where('srctype', 'ss');
							
						}
						
					}
	 
					if(count($column_search2) - 1 == $i) //last loop
						$this->db->group_end();
				}else if($this->input->post('status')) // if datatable send POST for search
				{
					 
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						if($this->input->post('status') == 'T'){
							$this->db->not_like($item2, 'S');
							$this->db->not_like('transitRepo.status', 'T');
						}else if($this->input->post('status') == 'P'){
							$this->db->or_not_like($item2, 'S');
							$this->db->like('transitRepo.status', 'T');
						}else{
							$this->db->like($item2, $this->input->post('status'));
							$this->db->where('transitRepo.qid ', NULL, FALSE);
							
						}
						
					}
					else
					{
						
							$this->db->or_like($item2, $this->input->post('status'));
						
						
					}
	 
					if(count($column_search2) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}else if($this->input->post('typereq')){
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						if($this->input->post('typereq') == 'cm'){
							$this->db->where('srctype', 'cm');
							
						}else if($this->input->post('typereq') == 'sr'){
							$this->db->where('srctype', 'sr');
						}else if($this->input->post('typereq') == 'rm'){
							$this->db->where('srctype', 'rm');
						}else{
							$this->db->where('srctype', 'ss');
							
						}
						
					}
	 
					if(count($column_search2) - 1 == $i) //last loop
						$this->db->group_end();
				}
				$i++;
			}
		}
		//$this->_get_datatables_query2( $column_search, $column_order);	
		
		//$this->db->group_by(array("transitRepo.loginid", "transitRepo.reqid"));
		$this->db->order_by('transitRepo.id', 'DESC');
	}
	public function getreq(){
/* 		$column_order = array('id','Proses','Tanggal Permohonan','Pemohon','Status','Request'); //set column field database for datatable orderable
		$column_search = array('id','Proses','Tanggal Permohonan','Pemohon','Status','Request'); */
		/* $this->db->select('xrequest.key1, xrequest.id, xrequest.doc_date, transitRepo.lastRetry, transitRepo.loginid,transitRepo.qid, xrequest.accOffice, xwfparam.initiator');
		$this->db->from('xwfparam'); 
		$this->db->join('xrequest', 'xwfparam.id = xrequest.reqid');
		$this->db->join('transitRepo', 'transitRepo.reqid = xrequest.id');
		$this->db->join('xentitas', 'xrequest.accOffice = xentitas.accOffice');
		$this->db->where('xrequest.status', 'S'); 
		$this->db->where('xrequest.req_flag', 'A');
		$this->db->where('xrequest.req_stat', 'P');
		$i = 0;
		$column_search = array('xrequest.key1','transitRepo.loginid','xwfparam.initiator');
        foreach ($column_search as $item) // loop column 
        {
			
            if($this->input->post('request')) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('request'));
                }
                else
                {
                    $this->db->or_like($item, $this->input->post('request'));
                }
 
                if(count($column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
/* 		if($this->input->post('request'))
        {
            $this->db->like('key1', $this->input->post('request'));
        } */
		
		//$this->_get_datatables_query2( $column_search, $column_order);	
 		/* $this->db->limit($_POST['length'], $_POST['start']);
		$this->db->order_by('xwfparam.id', 'ASC');
		$quer = $this->db->get();  */
		$this->listreq();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$quer = $this->db->get();
		
		$result =  $quer->result();
		log_message('debug', print_r(array("myjob"=>$this->db->last_query()), TRUE)); 
		return $result;
	}
	public function count_allreq()
    {
       /*  $this->db->from('xwfparam');
		$this->db->join('xrequest', 'xwfparam.id = xrequest.reqid');
		$this->db->join('xentitas', 'xrequest.accOffice = xentitas.accOffice');
		$this->db->where('xrequest.status', 'S');
		$this->db->where('xrequest.req_flag', 'A');
		$this->db->where('xrequest.req_stat', 'P');
		if($this->input->post('request'))
        {
            $this->db->like('key1', $this->input->post('request'));
        }
        return $this->db->count_all_results(); */
		 $this->listreq();
        return $this->db->count_all_results();
    }
	public function resendmail($loginid, $reqid){		
/* 		$quer = $this->db->query("update jbpm.xrequest set status = 'R' where id = '".$wfid."'");
 */	
		$quer2 = $this->db->query("select reqid from jbpm.transitRepo where id = '".$reqid."'");		
		$res = $quer2->row(); 

		$res_quer = json_decode(json_encode($res), True);
		$quer = $this->db->query("update jbpm.transitRepo set resendEmail = 1 where reqid = '".$res_quer['reqid']."' and loginid = '".$loginid."'");

		if ($this->db->affected_rows() > 0)
		{
			$output = array(  
				'status' =>"success",
            );        
		}
		else
		{
			$output = array(  
				'status' =>"fail",
            );
		}
		return $output;
	}
	public function reloadlist($loginid, $reqid){		
/* 		$quer = $this->db->query("update jbpm.xrequest set status = 'R' where id = '".$wfid."'");
 */	
		$quer2 = $this->db->query("select reqid from jbpm.transitRepo where id = '".$reqid."'");		
		$res = $quer2->row(); 

		$res_quer = json_decode(json_encode($res), True);
		$quer = $this->db->query("update jbpm.transitRepo set locked = NULL, retryNum = 0,lastRetry = NULL where reqid = '".$res_quer['reqid']."' and loginid = '".$loginid."'  and status != 'T'");

		if ($this->db->affected_rows() > 0)
		{
			$output = array(  
				'status' =>"success",
            );        
		}
		else
		{
			$output = array(  
				'status' =>"fail",
            );
		}
		return $output;
	}
	public function reloadval($loginid, $reqid){		
/* 		$quer = $this->db->query("update jbpm.xrequest set status = 'R' where id = '".$wfid."'");
 */	
		$quer2 = $this->db->query("select id from jbpm.transitRepo where id = '".$reqid."' and loginid = '".$loginid."' ");		
		$res = $quer2->row(); 
		$res_quer = json_decode(json_encode($res), True);
		$quer3 = $this->db->query("select qid from jbpm.xvalidation where trid in ( '".$res_quer['id']."')");		
		$res2 = $quer3->row(); 
		$res_quer3 = json_decode(json_encode($res2), True);
		$quer4 = $this->db->query("select status from jbpm.xqueue where id = '".$res_quer3['qid']."'");		
		$res3 = $quer4->row(); 
		$res_quer4 = json_decode(json_encode($res3), True);
		if($res_quer4['status'] != 'P'){
		$quer = $this->db->query("update jbpm.xqueue set status = 'I' where id = '".$res_quer3['qid']."'");

		if ($this->db->affected_rows() > 0)
		{
			$output = array(  
				'status' =>"success",
            );        
		}
		else
		{
			$output = array(  
				'status' =>"fail",
            );
		}
		}else{
			$output = array(  
				'status' =>"fail",
            );
		}
		return $output;
	}
	
		public function processpass($loginid, $reqid){		
/* 		$quer = $this->db->query("update jbpm.xrequest set status = 'R' where id = '".$wfid."'");
 */		$log_user = $_SESSION['pengguna']->loginid;
		$quer2 = $this->db->query("select reqid from jbpm.transitRepo where id = '".$reqid."'");		
		$res = $quer2->row(); 

		$res_quer = json_decode(json_encode($res), True);
		$quer = $this->db->query("update jbpm.transitRepo set userid = '".$log_user."' where id = '".$reqid."' and loginid = '".$loginid."'");

		if ($this->db->affected_rows() > 0)
		{
			$output = array(  
				'status' =>"success",
            );        
		}
		else
		{
			$output = array(  
				'status' =>"fail",
            );
		}
		return $output;
	}
	
	public function nextpass($id){		
/* 		$quer = $this->db->query("update jbpm.xrequest set status = 'R' where id = '".$wfid."'");
 */		//$log_user = $_SESSION['pengguna']->loginid;
 
		$quer2 = $this->db->query("select userid from jbpm.transitRepo where id = '".$reqid."'");		
		$res = $quer2->row(); 
		
		if ($res['userid'] === NULL){
		$quer = $this->db->query("update jbpm.transitRepo set userid = null where id = '".$id."'");
			if ($this->db->affected_rows() > 0)
			{
				$output = array(  
					'status' =>"success",
				);        
			}
			else
			{
				$output = array(  
					'status' =>"fail",
				);
			}
		}else
		{
			$output = array(  
				'status' =>"fail",
            );
		}
		
		return $output;
	}
		/*------------------------------------ Monitoring update data SSO ----------------------------------*/

	public function getlog(){
		$this->listlog();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$quer = $this->db->get();
		
		$result =  $quer->result();
		//log_message('debug', print_r(array("myjob"=>$this->db->last_query()), TRUE)); 
		return $result;
	}	
	
	public function listlog(){
		$this->db->select("xl.*,JSON_UNQUOTE(JSON_EXTRACT(xl.reqdata,'$.nama')) as namauser, JSON_UNQUOTE(JSON_EXTRACT(xl.reqdata,'$.loginid'))as loginid,JSON_UNQUOTE(JSON_EXTRACT(xl.reqdata,'$.nama'))as Nama");
		$this->db->from('xlogupdate xl');
		//$this->db->join('xemployee xe', 'xl.userid = xe.NPP');
		$i = 0;
		if($this->input->post('request')){
			$column_search = array("JSON_UNQUOTE(JSON_EXTRACT(`xl`.`reqdata`, '$.loginid'))","`xl`.`userid`");
			foreach ($column_search as $item) // loop column 
			{
				
				if($this->input->post('request')) // if datatable send POST for search
				{
					  
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, $this->input->post('request'));
					}
					else
					{
						$this->db->or_like($item, $this->input->post('request'));
					}
	 
					if(count($column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
		}
		$this->db->order_by('xl.id', 'DESC');
	}
	public function getdetail($id){
		$this->db->select("xl.*");
		$this->db->from('xlogupdate xl');
		$this->db->where('xl.id', $id);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$quer = $this->db->get();
		
		$result =  $quer->result();
		//log_message('debug', print_r(array("myjob"=>$this->db->last_query()), TRUE)); 
		return $result;
	}
	public function getnamepos($posid){
		$this->db->select("xp.name");
		$this->db->from('xposition xp');
		$this->db->where('xp.positionid', $posid);
		$quer = $this->db->get();
		
		$result =  $quer->row();
		//log_message('debug', print_r(array("myjob"=>$this->db->last_query()), TRUE)); 
		return $result->name;
	}
	public function getnameunit($unitcode){
		$this->db->select("xe.name");
		$this->db->from('xentitas xe');
		$this->db->where('xe.accOffice', $unitcode);
		$quer = $this->db->get();
		
		$result =  $quer->row();
		//log_message('debug', print_r(array("myjob"=>$this->db->last_query()), TRUE)); 
		return $result->name;
	}
	public function count_alllog()
    {
		 $this->listlog();
        return $this->db->count_all_results();
    }
	
		/* -------------------------------------------- List Request Resign ----------------------------------- */
	
	
		 private function _get_datatables_queryresign()
    {

		$column_search_res = array('NPP');
		$this->db->select('xreviewpos.wfid as id, v_login_name.posname as posisi, xreviewpos.reqmodify as reqmodify, xreviewpos.loginid as NPP, v_login_name.name as nama, xreviewpos.accOffice as kodeunit, xreviewpos.sdate as sdate, xreviewpos.reqassignee as assignee, v_login_name.positionid as poscode, xreviewpos.reqstatus as stage');
		$this->db->from('xreviewpos');
		$this->db->join('v_login_name', 'v_login_name.NPP = xreviewpos.loginid');
		//$this->db->join('xposition', 'xposition.positionid = xreviewpos.posid');
		$this->db->not_like('v_login_name.posname', 'KSY-');
		$this->db->where('xreviewpos.procStat', 'A'); 
		$this->db->where('xreviewpos.status', 'K'); 
		$this->db->like('xreviewpos.posid', '999888');
		$this->db->where('xreviewpos.sdate >=', '2022-07-01 00:00:00');
		$this->db->where('xreviewpos.sdate <=', 'NOW()', FALSE);
		
		//$this->db->join('xentitas', 'xrequest.accOffice = xentitas.accOffice');
 
        $i = 0;
     
        foreach ($this->column_search_res as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
		if($this->input->post('status')){
			if ( in_array($this->input->post('status'), array('P', 'T', 'V')) ) {
				if($this->input->post('status') == 'P'){
					$this->db->where('xreviewpos.reqassignee is NULL', NULL, FALSE);
					$this->db->where('xreviewpos.reqmodify is NULL', NULL, FALSE);
				}else if($this->input->post('status') == 'T'){
					$this->db->where('xreviewpos.reqassignee is NOT NULL', NULL, FALSE);
					$this->db->where('xreviewpos.reqmodify is NULL', NULL, FALSE);
				}else if($this->input->post('status') == 'V'){
					$this->db->where('xreviewpos.reqassignee is NOT NULL', NULL, FALSE);
					$this->db->where('xreviewpos.reqmodify is NOT NULL', NULL, FALSE);
					$this->db->not_like('v_login_name.positionid', '999888');
					$this->db->not_like('xreviewpos.reqstatus', 'X'); 
				}
				//
			}else{
				
					$this->db->where('xreviewpos.reqassignee is NOT NULL', NULL, FALSE);
					$this->db->where('xreviewpos.reqmodify is NOT NULL', NULL, FALSE);
					$this->db->where('xreviewpos.reqstatus is NOT NULL', NULL, FALSE);
					
				
			}

		}else{
			$this->db->where('xreviewpos.reqmodify is NULL', NULL, FALSE);
		}
		
		if($this->input->post('request')){
			$this->db->where('xreviewpos.loginid', $this->input->post('request'));
		}
		
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
		$this->db->order_by('xreviewpos.sdate', 'DESC');
    }
	
	public function count_allreqres()
    {
        $this->_get_datatables_queryresign();
        return $this->db->count_all_results();
    }
	
	public function getreqresign(){
		$this->_get_datatables_queryresign();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$querres = $this->db->get();
		
		$resultres =  $querres->result();
		//log_message('debug', print_r(array("myjob"=>$this->db->last_query()), TRUE)); 
		return $resultres;
	}
	
	public function processdel($loginid, $reqid){		
		//$log_user = $_SESSION['pengguna']->loginid;
		date_default_timezone_set("Asia/Jakarta");
		$date_del = date('Y-m-d H:i:s');
		$quer = $this->db->query("update jbpm.xreviewpos set reqassignee = '".$loginid."',  reqmodify = '".$date_del."'  where wfid = '".$reqid."'");

		if ($this->db->affected_rows() > 0)
		{
			$output = array(  
				'status' =>"success",
            );        
		}
		else
		{
			$output = array(  
				'status' =>"fail",
            );
		}
		return $output;
	}
	
	public function processlock($loginid, $reqid){		
		//$log_user = $_SESSION['pengguna']->loginid;
		/* date_default_timezone_set("Asia/Jakarta");
		$date_del = date('Y-m-d H:i:s'); */
		$querlock = $this->db->query("update jbpm.xreviewpos set reqassignee = '".$loginid."',  reqmodify = NULL  where wfid = '".$reqid."'");

		if ($this->db->affected_rows() > 0)
		{
			$output = array(  
				'status' =>"success",
            );        
		}
		else
		{
			$output = array(  
				'status' =>"fail",
            );
		}
		return $output;
	}
	
	public function cancelreq($loginid, $reqid){		
		//$log_user = $_SESSION['pengguna']->loginid;
		/* date_default_timezone_set("Asia/Jakarta");
		$date_del = date('Y-m-d H:i:s'); */
		date_default_timezone_set("Asia/Jakarta");
		$date_del = date('Y-m-d H:i:s');
		$querlock = $this->db->query("update jbpm.xreviewpos set reqassignee = '".$loginid."', reqmodify = '".$date_del."', reqstatus = 'X' where wfid = '".$reqid."'");

		if ($this->db->affected_rows() > 0)
		{
			$output = array(  
				'status' =>"success",
            );        
		}
		else
		{
			$output = array(  
				'status' =>"fail",
            );
		}
		return $output;
	}
	
   	public function randompass($loginid, $reqid){		
		$log_user = $_SESSION['pengguna']->loginid;
		$quer2 = $this->db->query("select status from jbpm.transitRepo where id = '".$reqid."'");		
		$res = $quer2->row();
		$res_quer = json_decode(json_encode($res), True);	
		
		if ($res_quer['status'] != 'T'){
		$quer = $this->db->query("update jbpm.transitRepo set `status`='G', `hashPass`=NULL where id = '".$reqid."' and loginid = '".$loginid."'");

			if ($this->db->affected_rows() > 0)
			{
				$output = array(  
					'status' =>"success",
				);        
			}
			else
			{
				$output = array(  
					'status' =>"fail",
				);
			}
		}else
		{
			$output = array(  
				'status' =>"fail",
            );
		}
		//$res_quer = json_decode(json_encode($res), True);
		
		return $output;
	}
	
	public function batalreq($loginid, $reqid){		
		$log_user = $_SESSION['pengguna']->loginid;
		$quer2 = $this->db->query("select reqid from jbpm.transitRepo where id = '".$reqid."'");		
		$res = $quer2->row();
		$res_quer = json_decode(json_encode($res), True);	
		
		if ($res_quer['reqid'] != null){
			//var_dump ($res_quer['reqid']);
			$qdelxreq = $this->db->query("UPDATE `jbpm`.`transitRepo` SET lastRetry= now(), locked = '".$log_user."', `status` = 'X' WHERE id = '".$reqid."'");

			if ($this->db->affected_rows() > 0)
			{
				$qupdxreq = $this->db->query("update jbpm.xrequest set `status`='X' where id = '".$res_quer['reqid']."'");

				if ($this->db->affected_rows() > 0)
				{
					$output = array(
						'status' =>"success",
					);
				}else{
					$output = array(  
						'status' =>"fail",
					);
				}
			}else{
				$output = array(  
					'status' =>"fail",
				);
			}
		}else{
			$output = array(  
					'status' =>"fail",
				);
		}
		
		return $output;
	}
	
} 