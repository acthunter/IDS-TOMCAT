<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xmod_RP extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('xwf_model', 'wfmodel');
		$this->load->model('xwf_param', 'wfparam');
	}
	
	public function wfdetail($wfid){
		$wf = $this->wfmodel->getwfinfo($wfid);
		
		if (isset($wf)){
			$wf->detail = $this->db->query("select * from xreviewpos where wfid=?", array($wfid))->row();	
			//$query = $this->db->query("select * from revdraft where reqid=?", array(		$id));
			//$rp->revdraft = $query->result(); 
		} else {
			$wf = (object) array();
			log_message('debug', print_r(array('else.wfdetail.wf'=>$wf), TRUE));
		}
		return $wf;
	}
	
	public function initiate(){	
		return $this->createnew();
	}
	
	public function jobitemlist(){
		$fdt = $this->input->post();
		$wfdetail = $this->createnew();
		$data = $wfdetail->detail->id;
		
		
		$tabel ="revdraft";
		$column_search = array('id','reqid','rd.loginid','xpos.name','rd.mobileNumber');
		$column_order = array('id','reqid','loginid','name','positionid','mobileNumber');
		//$order = array('id' => 'desc');
		
		//$this->_get_datatables_query($wfdetail, $tabel, $column_search, $column_order);
		//if($_POST['length'] != -1)
		//$this->db->limit($_POST['length'], $_POST['start']);	
		$this->db->select("rd.*, vln.name, vln.posname, xpos.name as posnew, vln.mobileNumber as mobilenew");
		$this->db->from('revdraft rd');
		$this->db->join('xposition xpos','rd.positionid = xpos.positionid');
		$this->db->join('v_login_name vln','vln.loginid = rd.loginid');
		$this->db->where('rd.reqid', $wfdetail->detail->id);
		
		$query = $this->db->get();
		$this->db->where('reqid =',$wfdetail->detail->id);
		$this->db->from('revdraft');
		$filter = $this->db->count_all_results();
		$output = array(
			"recordsTotal" => $query->num_rows(),
            "recordsFiltered" => $filter ,
            "data" => $query->result()
        );
		return $output;
	}
	/* private function _get_datatables_query($wfdetail, $tabel, $column_search, $column_order)
    {
        $this->db->select("rd.*, vln.name, vln.posname, xpos.name as posnew, vln.mobileNumber as mobilenew");
		$this->db->from('revdraft rd');
		$this->db->join('xposition xpos','rd.positionid = xpos.positionid');
		$this->db->join('v_login_name vln','vln.loginid = rd.loginid');
		$this->db->where('rd.reqid', $wfdetail->detail->id);
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
		if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    } */
	public function counts(){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$this->db->select("*");
		$this->db->from('revdraft rd');
		$this->db->join('v_login_name vln','vln.loginid = rd.loginid');
		$this->db->where('vln.accoffice',$accoffice);
		return $this->db->count_all_results();
	}
	public function createnew(){
		$accoffice = $_SESSION['pengguna']->accoffice;
		
		$periode = date('Ymd');
		$type = 'RQ';	
		//$myid = $this->cas->getmycas_login($this->cas);
		$mode = 'RP';
		$status_init = 'N';
		$status_submit = 'I';
		$status_approve = 'P';
		//check if exists
		$row = $this->db->query("select * from xreviewpos where (status=? or status=? or status=?) and accoffice=? and key1=? and type=?",
				array($status_init, $status_submit, $status_approve, $accoffice, $periode, $type))->row();
		log_message('debug', print_r(array('createnew.row'=>$row), TRUE));
		$wfid = null;
		if (!isset($row)){
			$myid = $_SESSION['pengguna']->loginid;
			$wfpp = (object) array('mode'=>$mode, 'accoffice'=>$accoffice, 'initiator'=>$myid);
			$wfid = $this->wfmodel->createnew($wfpp); 
			$xrev = array ('wfid'=>$wfid, 'type'=>$type, 'accoffice'=>$accoffice, 
				'key1'=>$periode, 'status'=>$status_init);
			$istr = $this->db->insert_string("xreviewpos", $xrev);
			$query = $this->db->query($istr);
			$rpid  = $this->db->insert_id();
			
			$query = $this->db->query("insert into revdraft(type, reqid, loginid, mobileNumber, positionid) 
				select '${type}', ${rpid}, loginid, mobileNumber, positionid from v_login_name where accOffice = ${accoffice}");
			
		} else {
			$wfid = $row->wfid;
			$initiator = 'null';
			$row = $this->db->query("select * from xwfparam where id=? and initiator=?",
				array($wfid, $periode))->row();
			$initiator = $_SESSION['pengguna']->loginid;
			$updateData=array("initiator"=>$initiator);
			$this->db->where("(id=${wfid})");
			$this->db->where("(initiator is null)");
			//$this->db->where("id",$wfid);
			$this->db->update('xwfparam', $updateData);
			
			//$initiator = $_SESSION['pengguna']->loginid;
			//log_message('debug', print_r(array('createnew.wfid'=>$wfid), TRUE));
			//$query = $this->db->query("update xwfparam set initiator = {$initiator} where id = {$wfid} and initiator = null");
			//return $query;			
		}
		
		return $this->wfdetail($wfid);
	}
	
/* 	public function createnew(){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$mode = 'RP';
		$periode = date('Ym');
		$type = 'Q';	
		$myid = $this->cas->getmycas_login($this->cas);
		
		//check if exists
		$row = $this->db->query("select * from xreviewpos where accoffice=? and periode=? and type=?",
				array($accoffice, $periode, $type))->row();
		$wfid = null;
		if (!isset($row)){
			$wfpp = (object) array('mode'=>$mode, 'accoffice'=>$accoffice, 'initiator'=>$myid);
			$wfid = $this->wfmodel->createnew($wfpp); 
			$xrev = array ('wfid'=>$wfid, 'type'=>$type, 'accoffice'=>$accoffice, 
				'periode'=>$periode);
			$istr = $this->db->insert_string("xreviewpos", $xrev);
			$query = $this->db->query($istr);
			$rpid  = $this->db->insert_id();
			
			$query = $this->db->query("insert into revdraft(type, reqid, loginid, mobileNumber, positionid) 
				select '${type}', ${rpid}, loginid, mobileNumber, positionid from v_review_pos where accOffice = ${accoffice} limit 5");
			
		} else {
			$wfid = $row->wfid;
		}
		
		return $this->wfdetail($wfid);
	} */
	
	public function possibleAction($wf, $actor){
		$eligable = array();
		
		log_message('debug', print_r(array('wf'=>$wf), TRUE));
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
		//$myid = $this->cas->getmycas_login($this->cas);
		log_message('debug', print_r(array("xcp.wfaction"=>$fdt), TRUE)); 
		
		
		$direction = 0;
		if (preg_match('/(submit|approve|save)/',$fdt['reqtype']))
			$direction = 1;
		
			//$myid = $_SESSION['pengguna']->loginid;
			//$wfpp = (object) array('initiator'=>$myid);
			//$wfid = $this->wfmodel->createnew($wfpp);
			
			//$wfid = $fdt['id'];
			$periode = date('Ymd');
			$accoffice = $_SESSION['pengguna']->accoffice;
			$xcp = array('type'=>'RQ', 'accoffice'=>$accoffice, 'key1'=>$periode, 'status'=>'I');
			$ustr = $this->db->update_string('xreviewpos', $xcp, 'wfid=' .  $fdt['wfid'] );
			$this->db->query($ustr);
			
		if (preg_match('/(reject)/',$fdt['reqtype']))
			$direction = -1;
		
		if (preg_match('/batal/',$fdt['reqtype'])){
			$direction = -1;
			//$wfid = $fdt['id'];
			$reviewer = $_SESSION['pengguna']->loginid;
			log_message('debug', print_r(array("ua.wfaction.cancel"=>$wfid), TRUE));
			//$query = $this->db->query("delete from xreviewpos where id = ${wfid}");
			//$query1 = $this->db->query("delete from xwfparam where id = ${wfid}");
			//$query2 = $this->db->query("delete from revdraft where reqid = ${wfid}");
			$query3 = $this->db->query("update xwfparam set pname='cancel', stage=0, initiator=null, lockactor=null, lockdate=null where id=${wfid}");
			$query3 = $this->db->query("update xreviewpos set status = 'C', key1='cancel' where wfid=${wfid}");
			$query4 = $this->db->query("update revdraft rd inner join xlogin xl on rd.loginid = xl.loginid
										set rd.positionid = xl.positionid, rd.flag = 'cancel' where rd.reviewer = ${reviewer}");
			return $query3;
			return $query4;
			//return $query;
			//return $query1;
			//return $query2;
		}	
		
		if ($direction == 0){
			if (preg_match('/(release)/',$fdt['reqtype'])){
				$myid = $this->session->userdata('pengguna')->loginid;
				$ret = $this->wfmodel->releasejob($myid,$wfid);
			}
		} else {
			$myid = $this->session->userdata('pengguna')->loginid;
			$ret = $this->wfmodel->action($myid,$wfid, $direction, $fdt['notes']);
		}
		return $ret;
	}
	
	private function rpositemdetail($id){
		$row = $this->db->query("select rd.*, vln.name, vln.posname from revdraft rd left join v_login_name vln on vln.loginid = rd.loginid where rd.id=?", array($id))->row();
		return $row;
	}
	
	public function rpositem(){
		$fdt = $this->input->post();
		$row = null;
		$id = $fdt['id'];
		$loginid = $fdt['loginid'];
		$positionid = $fdt['positionid'];
		$mobilenumber = $fdt['mobileNumber'];
		//var_dump ($fdt['mobileNumber']);
		$reviewer = $_SESSION['pengguna']->loginid;
		if (preg_match('/(readitem)/',$fdt['reqtype'])){
			$row = $this->rpositemdetail($fdt['id']);
		} else if (preg_match('/(save)/',$fdt['reqtype'])){
			$query_diff = $this->db->query("update revdraft rd inner join v_login_name vln on vln.loginid = rd.loginid
										set rd.loginid = {$loginid}, rd.positionid = {$positionid}, rd.mobileNumber = '" . $mobilenumber. "', rd.status = 'position_phone', reviewer = {$reviewer} where rd.id = {$id}");
			$query_notedit = $this->db->query("update revdraft rd inner join v_login_name vln on vln.loginid = rd.loginid
										set rd.loginid = {$loginid}, rd.positionid = {$positionid}, rd.mobileNumber = '" . $mobilenumber. "', rd.status = 'not_edit', reviewer = {$reviewer} where rd.id = {$id} and rd.positionid = vln.positionid and rd.mobileNumber = vln.mobileNumber");
			$query_diffphone = $this->db->query("update revdraft rd inner join v_login_name vln on vln.loginid = rd.loginid
										set rd.loginid = {$loginid}, rd.positionid = {$positionid}, rd.mobileNumber = '" . $mobilenumber. "', rd.status = 'phone', reviewer = {$reviewer} where rd.id = {$id} and rd.positionid = vln.positionid and rd.mobileNumber <> vln.mobileNumber");
			$query_diffpos = $this->db->query("update revdraft rd inner join v_login_name vln on vln.loginid = rd.loginid
										set rd.loginid = {$loginid}, rd.positionid = {$positionid}, rd.mobileNumber = '" . $mobilenumber. "', rd.status = 'position', reviewer = {$reviewer} where rd.id = {$id} and rd.positionid <> vln.positionid and rd.mobileNumber = vln.mobileNumber");
			//$ustr = $this->db->update_string("revdraft", $uarr, "id=".$fdt['id']);
			//$this->db->query($ustr);
			return $query_notedit;
			return $query_diffphone;
			return $uery_diffpos;
			return $query_diff;
			$row = $this->rpositemdetail($fdt['id']);
		}
		return $row;
	}
	
	
	public function rpositem1(){
		$fdt = $this->input->post();
		$row = null;
		$reviewer = $_SESSION['pengguna']->loginid;
		if (preg_match('/(readitem)/',$fdt['reqtype'])){
			$row = $this->rpositemdetail($fdt['id']);
		} else if (preg_match('/(save)/',$fdt['reqtype'])){
			$uarr = array('loginid'=>$fdt['loginid'], 'positionid'=>$fdt['positionid'], 
				'mobileNumber'=>$fdt['mobileNumber'], 'status'=>'U', 'reviewer'=>$reviewer);
			$ustr = $this->db->update_string("revdraft", $uarr, "id=".$fdt['id']);
			$this->db->query($ustr);
			
			$row = $this->rpositemdetail($fdt['id']);
		}
		return $row;
	}
}