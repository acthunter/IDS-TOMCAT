<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xwf_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query($tabel, $column_search)
    {
        $this->db->from($tabel);
		$i = 0;
     
        foreach ($column_search as $item) // loop column 
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
 
                if(count($column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
    }	
	public function getMyWorkList($myid){
		$idpattern = "%${myid}%";
		//$selector = array('currActor like' => $idpattern, 'doneActor not like' => $idpattern);
		//$this->db->where($selector);
		$accoffice = $_SESSION['pengguna']->accoffice;
		
/* 		$query = $this->db->query('select vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xw.targetScore, xr.cdate 
		from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid
		where xw.currActor like ? and xw.accoffice = ? and xw.stage in (1,2)', array($idpattern, $accoffice)); */
		/* $this->db->select('vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xw.targetScore, xr.cdate');
		$this->db->from('xwfparam xw');
		$this->db->join('xreviewpos xr', 'xw.id = xr.wfid');
		$this->db->join('v_login_name vlm', 'xw.initiator = vlm.loginid');
		$this->db->like('xw.currActor', $myid);
		$this->db->where('xw.accoffice', $accoffice);
		$this->db->where('xw.stage in (1,2)');
				if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query1 = $this->db->get()->result();
		
		$this->db->select('vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xw.targetScore, xr.order_time as cdate');
		$this->db->from('xwfparam xw');
		$this->db->join('xrequest xr', 'xw.id = xr.reqid');
		$this->db->join('v_login_name vlm', 'xw.initiator = vlm.loginid');
		$this->db->like('xw.currActor', $myid);
		$this->db->where('xw.accoffice', $accoffice);
		$this->db->where('xw.stage in (1,2)');
				if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']); */
	//if($_POST['length'] != -1)
		$query = $this->db->query("(SELECT vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xw.targetScore, xr.order_time as cdate FROM jbpm.xwfparam xw join xrequest xr on xw.id = xr.reqid join v_login_name vlm on xw.initiator = vlm.loginid
 WHERE xw.currActor LIKE '%".$myid."%' AND xw.accoffice = '".$accoffice."' AND  xw.stage in ('1','2')) union ALL
(SELECT vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xw.targetScore, xr.cdate FROM jbpm.xwfparam xw join xreviewpos xr on xw.id = xr.wfid join v_login_name vlm on xw.initiator = vlm.loginid
 WHERE xw.currActor LIKE '%".$myid."%' AND xw.accoffice = '".$accoffice."' 
 AND  xw.stage in ('1','2')) union ALL (SELECT vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xw.targetScore, xr.lasttime as cdate FROM jbpm.xwfparam xw join xqueue xr on xw.id = xr.wfid join v_login_name vlm on xw.initiator = vlm.loginid
 WHERE xw.currActor LIKE '%".$myid."%' AND xw.accoffice = '".$accoffice."' 
 AND  xw.stage in ('1','2')) LIMIT ".$_POST['start'].",".$_POST['length']." ");
	
		$result = $query->result();
		//var_dump($result);
		/* $query = $this->db->query($query1 . ' UNION ALL ' . $query2);
		$result =  $query->result(); */
		//$result = array_merge($query1, $query2);
		
		log_message('debug', print_r(array("myjob"=>$this->db->last_query()), TRUE)); 
		
		return $result;
	}
	
	public function getMyWorkListGeneral(){
		$tabel ="xwfparam";
		$column_order = array('id','stage','mode','doneActor','currScore'); //set column field database for datatable orderable
		$column_search = array('id','stage','mode','doneActor','currScore');

		$this->_get_datatables_query($tabel, $column_search);	
		$quer = $this->db->get();
		$result =  $quer->result();
		log_message('debug', print_r(array("myjob"=>$this->db->last_query()), TRUE)); 
		return $result;
	}
	
	
	public function getXreviewPos(){
		$tabel ="xreviewpos";
		//$query = $this->db->query('select id, wfid, type,procStat, status, loginid,data from xreviewpos where accoffice=' . $accoffice);
		$column_order = array('id','wfid','type','accoffice','procStat','status','data'); //set column field database for datatable orderable
		$column_search = array('id','wfid','type','accoffice','procStat','status','data');

		$this->_get_datatables_query($tabel, $column_search);	
		$quer = $this->db->get();
		$result =  $quer->result();
		log_message('debug', print_r(array("myjob"=>$this->db->last_query()), TRUE)); 
		return $result;
	}
	
	public function getnotes($refid, $type){
		$query = $this->db->query("select * from xnotes where ntype=? and refid=? order by ndate desc limit 2", array($type, $refid));
		
		log_message('debug', print_r(array("last-q" =>$this->db->last_query()), TRUE)); 
		return $query->result();
	}
	
	public function getwfinfo($wfid){
		$wf = $this->db->query("select id, initiator,pname, doneActor, currActor, currScore, targetScore, accOffice, mode,lockActor, DATE_FORMAT(lockDate,'%H:%i') as lockDate, stage from xwfparam wf where id=?", array(intval($wfid)))->row(); 
		
		if (isset($wf)){
			$wf->currActor = json_decode($wf->currActor, false); 
			$cdone = $wf->doneActor;
			
			if ($cdone == null || strlen($cdone) < 2 ){
					$wf->doneActor = [];
			} else {
					$wf->doneActor = explode(",", $cdone);
			}
		}
		return $wf;
	}

	public function getposearch($pattern){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$data = $this->db->query("select * from xposition where accOffice = ".$accoffice." AND name like '%" . $pattern . "%'");
		$crow = $data->result();
		return $crow;
	}
	
	public function getposearch_wf($pattern){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$data = $this->db->query("select initiator, stage from xwfparam where  id like '%" . $pattern . "%'");
		$crow = $data->result();
		return $crow;
	}
	
	public function getsearchadm($pattern){
		$data = $this->db->query("select loginid  from xreviewpos where id like '%" . $pattern . "%'");
		$crow = $data->result();
		return $crow;
	}
	
	public function createnew($wfpp){
		$this->load->model('xwf_param', 'wfparam');
		
		$wfp = (object) array();
		
		log_message('debug', print_r(array("wfpp"=>$wfpp), TRUE)); 
		$pparam = $this->wfparam->wfinit($wfpp->mode, $wfpp->accoffice);
		$wfp->param = json_encode($pparam);
		$wfp->initiator = $wfpp->initiator;
		$wfp->accoffice = $wfpp->accoffice;
		$wfp->mode = $wfpp->mode;
		
		$ustr = $this->db->insert_string('xwfparam', $wfp);
		$this->db->query($ustr);
		
		$wfid = $this->db->insert_id();
		
		$this->initstage($wfid, '1', null);
		return $wfid;
	}
	
	public function createnew2($wfpp){
		$wfp = (object) array();
		log_message('debug', print_r(array("wfpp"=>$wfpp), TRUE)); 
		//$wfp->param = json_encode($pparam);
		$wfp->accoffice = $wfpp->accoffice;
		$wfp->type = $wfpp->mode;
		
		$ustr = $this->db->insert_string('xreviewpos', $wfp);
		$this->db->query($ustr);
		
		$wfid = $this->db->insert_id();
		
		$this->initstage($wfid, '1', null);
		return $wfid;
	}
	
	public function initstage($wfid, $stage, $poutput){
		$wf = $this->getwfinfo($wfid);
		log_message('debug', print_r(array("init.ustr.wf"=>$wf), TRUE));
		$row = $this->db->query("select * from xwfparam where id=" . $wfid)->row();
		log_message('debug', print_r(array("init.stage.wfid"=>$wfid, "stage"=>$stage), TRUE)); 
		if ($row != null){
			$wparam = json_decode($row->param, true);
		log_message('debug', print_r(array("init.stage.wfparam"=>$wparam), TRUE)); 
			$nrow = (object) array();
			$nrow->stage = $stage;
			
			if (isset($wparam[$stage]['target'])){
				$nrow->targetScore = $wparam[$stage]['target'];
				$nrow->currActor = $wparam[$stage]['actor'];
				$nrow->pname = $wparam[$stage]['name'];
				$nrow->lockActor = null;
				$nrow->lockDate = null;
				if (isset($poutput)){
				//SoD
					/*foreach ($poutput->doneActor as $cactor ){
						log_message('debug', print_r(array("initstage.org"=>$nrow->currActor,
							"cidx"=>$nrow->currActor[$cactor], "cactor"=>$cactor), TRUE)); 
						unset($nrow->currActor[$cactor]);
					}*/
					unset($nrow->currActor[end($poutput->doneActor)]); 
				}
				$nrow->currActor = json_encode($nrow->currActor);
			} else {
				if ($stage >= 3){
					$uarr = array("procStat"=>'P', "status"=>'I');
					if (isset($wparam['finish'])){
						$uarr = $wparam['finish']['xreview'];
						$ustr = $this->db->update_string("xwfparam", $wparam['finish']['wf'], "id=" . $wfid);
						log_message('debug', print_r(array("init.ustr"=>$ustr), TRUE)); 
						$this->db->query($ustr);
					} 
					$ustr = $this->db->update_string("xreviewpos", $uarr, "wfid=" . $wfid);
					$this->db->query($ustr);
				}
				$nrow->pname = null;
			} 
	
			$nrow->currScore = 0;
			//$nrow->doneActor = null;
			$doneactor = array($wf->doneActor);
			log_message('debug', print_r(array("init.ustr.doneactor"=>$doneactor), TRUE)); 
			
			//$nrow->doneActor = array($wf->doneActor);

			$ustr = $this->db->update_string('xwfparam', $nrow, 'id=' . $wfid );
			log_message('debug', print_r(array("init.nrow.1"=>$nrow), TRUE));
			log_message('debug', print_r(array("init.ustr.1"=>$ustr), TRUE)); 
			$this->db->query($ustr);
			return $this->getwfinfo($wfid);
		}
		
	}
	
	public function action($actor, $wfid, $isForward, $notes){
		$wf = $this->getwfinfo($wfid);
		
		log_message('debug', print_r(array("wfinfo"=>$wf), TRUE)); 
		if (isset($wf->currActor)){
			$isDoneActor = in_array($actor, $wf->doneActor);
			$isValidActor = isset($wf->currActor->$actor);
			
			$pinput = (object) array ("validActor"=>$isValidActor, "doneActor"=>$isDoneActor,
				"cscore"=>$wf->currScore, "tscore"=>$wf->targetScore, "stage"=>$wf->stage,
				"direction"=>$isForward);
			log_message('debug', print_r(array("pinput"=>$pinput), TRUE)); 
			
			if ($isValidActor && !$isDoneActor){
				$change = $wf->currActor->$actor;
				log_message('debug', print_r(array("change"=>$change), TRUE)); 
				
				$wf->doneActor[] = $actor;
				if ($isForward < 0 ) {
						$wf->currScore -= $change;
						//$wf->doneActor = null
						if ($wf->currScore < 0)
							$wf->currScore = 0;
						if ($wf->stage == 2){
							$wf->stage--;
							$currScore = 0;
						}
				} else {
					$wf->currScore += $change;
					if ($wf->currScore >= $wf->targetScore){
						$wf->stage++;
						$wf->currScore = 0;
					}
				}
			}
		
			$poutput = (object) array ("validActor"=>$isValidActor, "doneActor"=>$wf->doneActor,
				"cscore"=>$wf->currScore, "tscore"=>$wf->targetScore, "stage"=>$wf->stage);
			log_message('debug', print_r(array("poutput"=>$poutput), TRUE)); 
			
			$isupdate = true;
			if ($pinput->stage != $poutput->stage){
				//change stage
				$this->initstage($wfid, $wf->stage, $poutput);
			} else if ($pinput->cscore != $poutput->cscore){
				$udata = array('currScore'=>$wf->currScore, 'doneActor'=>implode(",", $wf->doneActor));
				$ustr = $this->db->update_string('xwfparam', $udata, 'id=' . $wfid );
				log_message('debug', print_r(array("ustr"=>$ustr, "notes"=>$notes), TRUE));
				$this->db->query($ustr);
			} else 
				$isupdate = false;
			
			if ($isupdate){
				$this->load->library('slog');
				$this->slog->write_log('info', print_r(array('wfm.action.update'=>$poutput),TRUE));
				//if (strlen($notes) > 2){
					$this->db->query("insert into xnotes(refid, ntype, loginid, stage, notes) values (?,'A',?,?,?)",array($wfid, $actor, $pinput->stage, $notes));
				//}
			}
		}
		$this->releasejob($actor, $wfid);
		return $wf;
	}
	
	public function lockjob($myid, $jobid){
		
		$query = $this->db->query('update xwfparam set lockActor=?, lockDate=DATE_ADD(now(), INTERVAL ? MINUTE) where id=? and (lockDate < now() or lockDate is null or lockActor=?)', array($myid, 15, intval($jobid), $myid));
		
		$ret = ($this->db->affected_rows() > 0);
		log_message('debug', print_r(array("sql"=>$this->db->last_query(), "rows"=>$this->db->affected_rows()), TRUE));
		return $ret;
	}
	
	public function releasejob($myid, $jobid){
		
		$query = $this->db->query('update xwfparam set lockActor=null, lockDate=null where id=? and lockActor=?', array(intval($jobid), $myid));
		
		$ret = ($this->db->affected_rows() > 0);
		log_message('debug', print_r(array("sql"=>$this->db->last_query(), "rows"=>$this->db->affected_rows()), TRUE));
		return $ret;
	}
	
	public function cancel($jobid){
		$query = $this->db->query('update xwfparam set stage=0 where id=?', array(intval($jobid)));
		
		$ret = ($this->db->affected_rows() > 0);
		log_message('debug', print_r(array("sql"=>$this->db->last_query(), "rows"=>$this->db->affected_rows()), TRUE));
		return $ret;
	}
	public function get_autocomplete($search_data)
        {
                $this->db->select('initiator');
                $this->db->like('initiator', $search_data);

                return $this->db->get('xwfparam', 10)->result();
        }
	public function getposunit($pattern){
		$data = $this->db->query("select *  from xentitas where name like '%" . $pattern . "%'");
		$crow = $data->result();
		return $crow;
	}
		public function count_all($myid)
	{
		$idpattern = "%${myid}%";
		$accoffice = $_SESSION['pengguna']->accoffice;
		//$this->_get_datatables_query();
				$this->db->select('*');
		$this->db->from('xwfparam');
		$this->db->like('currActor', $myid);
		$this->db->where('accoffice', $accoffice);
		$this->db->where('stage in (1,2)');
		//$this->db->query('select * from xwfparam where currActor like ? and accoffice = ? and stage in (1,2)', array($idpattern, $accoffice));
		return $this->db->count_all_results();
	}
		function count_filtered($myid)
	{
		$idpattern = "%${myid}%";
		$accoffice = $_SESSION['pengguna']->accoffice;
		//$this->_get_datatables_query();
		//$query = $this->db->query('select * from xwfparam where currActor like ? and accoffice = ? and stage in (1,2)', array($idpattern, $accoffice));
		//return $query->num_rows();
		
		$this->db->from('xwfparam');
		$this->db->like('currActor', $myid);
		$this->db->where('accoffice', $accoffice);
		$this->db->where('stage in (1,2)');
		$query = $this->db->get();
		return $query->num_rows();
	}
	private function _get_datatables_query2($column_search, $column_order)
    {
        $this->db->from('xwfparam');
		$this->db->join('xreviewpos', 'xwfparam.id = xreviewpos.wfid');
		$this->db->join('v_login_name', 'xwfparam.initiator = v_login_name.loginid');
		if($this->input->post('pemohon'))
        {
            $this->db->where('initiator', $this->input->post('pemohon'));
        }
        if($this->input->post('date'))
        {
            $this->db->like('cdate', $this->input->post('date'));
        }
        if($this->input->post('req'))
        {
            $this->db->like('data', $this->input->post('req'));
        }
		$i = 0;
     
        foreach ($column_search as $item) // loop column 
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
 
                if(count($column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
    }
	    public function count_adm()
    {
		$column_order = array('id','Proses','Tanggal Permohonan','Pemohon','Status','Request'); //set column field database for datatable orderable
		$column_search = array('id','Proses','Tanggal Permohonan','Pemohon','Status','Request');
		
		$this->_get_datatables_query2( $column_search, $column_order);	
		//$this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_alladm()
    {
        $this->db->from('xreviewpos');
        return $this->db->count_all_results();
    }
	public function getadm(){
		$column_order = array('id','Proses','Tanggal Permohonan','Pemohon','Status','Request'); //set column field database for datatable orderable
		$column_search = array('id','Proses','Tanggal Permohonan','Pemohon','Status','Request');
		
		$this->_get_datatables_query2( $column_search, $column_order);	
		$this->db->limit($_POST['length'], $_POST['start']);
		$quer = $this->db->get();
		$result =  $quer->result();
		log_message('debug', print_r(array("myjob"=>$this->db->last_query()), TRUE)); 
		return $result;
	}
	public function gethistory(){
		if($this->input->post('pemohon')||$this->input->post('date')||$this->input->post('req'))
        {
		$this->history();
				
		//if($_POST['length'] != -1)
		//$this->db->limit($_POST['length'], $_POST['start']);
		$quer = $this->db->get();
		$result =  $quer->result();
		}else{
			$result = 0;
		}
		log_message('debug', print_r(array("myjob"=>$this->db->last_query()), TRUE)); 
		return $result;
	}
	public function history(){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$this->db->from('xwfparam');
		$this->db->join('xreviewpos', 'xwfparam.id = xreviewpos.wfid');
		$this->db->join('v_login_name', 'xwfparam.initiator = v_login_name.loginid');
		$this->db->where('xreviewpos.accoffice', $accoffice);
		$this->db->where_in('xreviewpos.type', array('CP','CU','CT','RQ'));
		if($this->input->post('pemohon'))
        {
            $this->db->like('xwfparam.initiator', $this->input->post('pemohon'));
        }
        if($this->input->post('date'))
        {
            //$this->db->like('xreviewpos.cdate', $this->input->post('date'));
			//$this->db->where("xreviewpos.cdat BETWEEN '" .$this->input->post('date')."' AND '" .$this->input->post('edate')."'");
			if($this->input->post('date') == $this->input->post('edate')|| $this->input->post('edate') == ""){
				$this->db->like('xreviewpos.cdate', $this->input->post('date'));
			}else{
				$this->db->where('xreviewpos.cdate >=', $this->input->post('date'));
				$this->db->where('xreviewpos.cdate <=', date('Y-m-d', strtotime($this->input->post('edate') . ' +1 day')));
			}
		}
        if($this->input->post('req'))
        {
            $this->db->like('xreviewpos.data', $this->input->post('req'));
        }
	}
		public function count_history()
    {
		$this->history();
        $query = $this->db->get();
        return $query->num_rows();
    }
} 