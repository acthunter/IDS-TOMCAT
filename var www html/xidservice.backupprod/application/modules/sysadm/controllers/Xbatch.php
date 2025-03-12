<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xbatch extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
	}

	public function index()
	{	
		$myid = $this->cas->getmycas_login(array('idm_super'));
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$this->page->view('v_sysadmin');
	}
	
	public function batchctl(){
		//$myid = $this->cas->getmycas_login(array('idm_super'));
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$this->page->view('v_batchctl');
	}
	
	public function sysrequest(){
		$myid = $this->cas->getmycas_login(array('idm_super'));
		$fdt = $this->input->post();
		if (!isset($fdt['reqtype'])){
			$this->page->template('admin_tpl');
			$this->page->header('templates/admin_header_tpl');
			$this->page->view('v_sysrequest');
		} else {
			if (preg_match('/dispatchReview/',$fdt['reqtype'])){
				$this->db->query("update xlogin xl inner join revdraft rd on xl.loginid = rd.loginid 	inner join xreviewpos xr on xr.id = rd.reqid 	set xl.positionid = rd.positionid, xl.fpositionid = rd.positionid where xr.id = ?", array(8));
				
				$this->db->query("update xemployee xe inner join xlogin xl on xl.NPP = xe.NPP inner join revdraft rd on xl.loginid = rd.loginid inner join xreviewpos xr on xr.id = rd.reqid	set xe.mobileNumber = rd.mobileNumber where xr.id=?", array(8));
				echo json_encode("OK");
			} else {
				$this->load->library('restclient', array());
				$dest_url = $this->config->item('cas_url') . 'frontend/sysreq';
				log_message('debug', print_r($dest_url, TRUE)); 
				$breply = $this->restclient->post($dest_url, $fdt);
				echo json_encode($breply);
			}
		}
	}
	
	public function rscsrc_list(){
		//$this->db = $this->load->database('jbpm', true);
		$tabel ="xrscsync ";
		$column_search = array('id','refid','effDate','endDate','batchFlag','procStatus','systemId','mode');
		$column_order = array('id','refid','effDate','endDate','batchFlag','procStatus','systemId','mode');
		$order = array('id' => 'asc');
		
		$this->_get_datatables_query($tabel, $column_search, $column_order, $order);
		/* if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);	 */	
		$quer = $this->db->get();
		$list = $quer->result();
       
        $output = array(
            "recordsTotal" => 1,
            "recordsFiltered" => 1,
            "data" => $list,
        );
        echo json_encode($output);
	}
	
	private function _get_datatables_query($tabel, $column_search, $column_order, $order)
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
		if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	
	
	public function rscsrc_mark(){
		$fmdata = $this->input->post();
		log_message('debug', print_r($fmdata, TRUE));
		$mode = $fmdata['mtype'];
		
		$iids = array_map('intval', explode(',', implode(',',$fmdata['ids'] )));
		
	
		$elm1 = "";
		if ($mode == 'pending'){
			$elm1 = "batchFlag='P'";
		} else if ($mode == 'active'){
			$elm1 = "batchFlag='A'";
		} else if ($mode == 'finish'){
			$elm1 = "procStatus='P'";
		} else if ($mode == 'init'){
			$elm1 = "procStatus='I'";
		}
		//$this->db = $this->load->database('jbpm', true);
		log_message('debug', print_r($iids, TRUE));
		$this->db->query("update xrscsync set " . $elm1 . " where id in (?)", $iids);
		//$this->db->update_string('xrscsync', $udata);
        echo json_encode($fmdata);
	}
	
	public function rscsrc_detail($rid){
		//$this->db = $this->load->database('jbpm', true);
		
		$query = $this->db->query("select reqStr from xrscsync where id = ?", $rid);
        echo $query->row()->reqStr;
	}
	
	
	

	public function rp_mark(){ //mtype, ids
		$fdt = $this->input->post();
		$stage = '1';
		
		if (preg_match('/pending/',$fdt['mtype']))
			$uarr = array('procStat'=>'P');
		if (preg_match('/active/',$fdt['mtype']))
			$uarr = array ('procStat'=>'A');
		if (preg_match('/start/',$fdt['mtype']))
			$uarr = array('status'=>'I');
		if (preg_match('/resource/',$fdt['mtype']))
			$uarr = array('status'=>'J');
		if (preg_match('/finish/',$fdt['mtype']))
			$uarr = array('status'=>'P');
		foreach ($fdt['ids'] as $id){
			$ustr = $this->db->update_string("xreviewpos", $uarr, "id=".$id);
			$this->db->query($ustr);
		}
		echo json_encode($fdt['ids']);
	}	

	public function param_batchctl(){
		$fdt = $this->input->post();
		$r_sys = $this->db->query("select value from xsysparam where name='batch'")->row();
		$bparam = $r_sys->value;
		$xparam= simplexml_load_string($bparam);	
		$parray = $xparam;
		
		if (preg_match('/save/',$fdt['reqtype'])){
			
			unset($xparam->batchMode);
			unset($xparam->generateResource);
			unset($xparam->dispatchResource);
			
			if(isset($fdt["batchMode"]))
				foreach ($fdt["batchMode"] as $c){
					$xparam->addChild("batchMode", $c);
				}
			
			if(isset($fdt["generateResource"]))
				foreach ($fdt["generateResource"] as $c){
					$xparam->addChild("generateResource", $c);
				}
			
			if(isset($fdt["dispatchResource"]))
				foreach ($fdt["dispatchResource"] as $c){
					$xparam->addChild("dispatchResource", $c);
				}

			$this->db->query("update xsysparam set value=? where name='batch'", array($xparam->asXML()));
			
		}
		log_message('debug', print_r(array("param_batchctl.xparam"=>$xparam), TRUE));
		//$fparam = array("batchMode"=>array($xparam->batchMode), "generateResource"=>array($xparam->generateResource, "dispatchResource"=>array($xparam->dispatchResource)));
		
		//log_message('debug', print_r(array("param_batchctl.fparam"=>$fparam), TRUE));
		echo json_encode($xparam);
	}
	
	public function query_em(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$fmdata = $this->input->post();
		$id = $fmdata['loginid'];
		$sid = $fmdata['sloginid'];
		//var_dump($id);
		//var_dump($sid);
		
		/* if($id != ""){
			if($id > 70000){
				$query = $this->db->query("select xe.*,xl.sloginid,  MD5(xe.passwordHistory) as passwordHistory, xl.positionid, xl.fpositionid, xl.active as activexl, xl.enabled as enabledxl, xl.created as createdxl, xl.basePositionid, xl. expired as expiredxl, xl.loginExpired, xl.snpp   
		from xemployee xe join xlogin xl ON xe.NPP = xl.loginid where xl.loginid < 79999 and xl.loginid > 70000 and xl.loginid = ". $id);
			}else{
				$query = $this->db->query("select xe.*,xl.sloginid,  MD5(xe.passwordHistory) as passwordHistory, xl.positionid, xl.fpositionid, xl.active as activexl, xl.enabled as enabledxl, xl.created as createdxl, xl.basePositionid, xl. expired as expiredxl, xl.loginExpired, xl.snpp   
		from xemployee xe join xlogin xl ON xe.NPP = xl.loginid where xl.loginid = ". $id);
			}

		}else{
			$query = $this->db->query("select xe.*,xl.sloginid, xl.loginid,  MD5(xe.passwordHistory) as passwordHistory,  xl.positionid, xl.fpositionid, xl.active as activexl, xl.enabled as enabledxl, xl.created as createdxl, xl.basePositionid, xl. expired as expiredxl, xl.loginExpired, xl.snpp   
		from  xlogin xl join xemployee xe ON xe.NPP = xl.loginid where xl.sloginid = ". $sid);	
			
		} */
		$query = $this->db->query("select xe.*,xl.sloginid,  MD5(xe.passwordHistory) as passwordHistory, xl.positionid, xl.fpositionid, xl.active as activexl, xl.enabled as enabledxl, xl.created as createdxl, xl.basePositionid, xl. expired as expiredxl, xl.loginExpired, xl.snpp   
		from xemployee xe join xlogin xl ON xe.NPP = xl.loginid where xl.loginid = ". $id);
		
        echo json_encode($query->row());	 
	}
	public function query_em2(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$fmdata = $this->input->post();
		$id = $fmdata['loginid'];
		$sid = $fmdata['sloginid'];
/* 		$query = $this->db->query("select xe.NPP, xe.Name, xe.email
		from xemployee xe join xlogin xl ON xe.NPP = xl.loginid where xl.loginid = ". $id);
 */				$query = $this->db->query("select xe.NPP, xe.Name, xe.email from xemployee xe join v_login_previlegde1 xl ON xe.NPP = xl.loginid 
		where xl.accOffice < 900 and xl.accOffice >= 800 and xl.loginid = ". $id);
		
        echo json_encode($query->row());	
	}
	public function employee(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$this->page->view('v_employee');
	}	
	public function update_employee(){
		$fdt = $this->input->post();
		$wfid = $fdt['loginid'];
		$xcp = array('NPP'=>$fdt['loginid'], 'email'=>$fdt['email'],'Name'=>$fdt['Name'], 'accOffice'=>$fdt['accOffice'], 'manager'=>$fdt['manager'],
			'password'=>$fdt['password'], 'failCount'=>$fdt['failcount'],'mobileNumber'=>$fdt['mn'],
			'DOB'=> date('Y-m-d',strtotime($fdt['DOB'])), 
			'enabled'=> intval(str_replace(" ", "", $fdt['enabled'])),
			'cpwd'=> intval(str_replace(" ", "", $fdt['cpwd'])),
			'active'=> intval(str_replace(" ", "", $fdt['active'])),
			'locked'=> intval(str_replace(" ", "", $fdt['locked'])),
			'passwordExpired'=> date('Y-m-d h:i',strtotime($fdt['passwordExpired'])),
			'nextAllowedAttempt'=> date('Y-m-d h:i',strtotime($fdt['naa'])),
		); 
		//var_dump($xcp);
		$xcl = array('NPP'=>$fdt['loginid'], 'positionid'=>$fdt['positionid'], 'fpositionid'=>$fdt['fpositionid'], 'active'=>intval(str_replace(" ", "", $fdt['al'])), 'enabled'=>intval(str_replace(" ", "", $fdt['el'])), 'basePositionid'=>$fdt['bpi'],
			'expired'=> date('Y-m-d',strtotime($fdt['expxl'])),				 
		);
		$ustr = $this->db->update_string('xemployee', $xcp, 'NPP="' . $wfid.'"' ); 
		$ustr2 = $this->db->update_string('xlogin', $xcl, 'NPP="' .  $wfid.'"' );
		$crow1 = $this->db->query($ustr);
		$crow2 = $this->db->query($ustr2);
		$ret = array($crow1,$crow2); 
		echo json_encode($ret);
	}
	public function update_employee2(){
		$fdt = $this->input->post();
		$wfid = $fdt['loginid'];
		$xcp = array( 'email'=>$fdt['email'] 
		); 
		/* $xcp = array('NPP'=>$fdt['loginid'], 'email'=>$fdt['email'],'Name'=>$fdt['Name'], 'accOffice'=>$fdt['accOffice'], 'manager'=>$fdt['manager'],
			'password'=>$fdt['password'], 'failCount'=>$fdt['failcount'],'mobileNumber'=>$fdt['mn'],
			'DOB'=> date('Y-m-d',strtotime($fdt['DOB'])), 
			'enabled'=> intval(str_replace(" ", "", $fdt['enabled'])),
			'cpwd'=> intval(str_replace(" ", "", $fdt['cpwd'])),
			'active'=> intval(str_replace(" ", "", $fdt['active'])),
			'locked'=> intval(str_replace(" ", "", $fdt['locked'])),
			'passwordExpired'=> date('Y-m-d h:i',strtotime($fdt['passwordExpired'])),
			'nextAllowedAttempt'=> date('Y-m-d h:i',strtotime($fdt['naa'])),
		); 
		//var_dump($xcp);
		$xcl = array('NPP'=>$fdt['loginid'], 'active'=>intval(str_replace(" ", "", $fdt['al'])), 'enabled'=>intval(str_replace(" ", "", $fdt['el'])), 
			'expired'=> date('Y-m-d',strtotime($fdt['expxl'])),				 
		); */
		$ustr = $this->db->update_string('xemployee', $xcp, 'NPP="' . $wfid.'"' ); 
		//$ustr2 = $this->db->update_string('xlogin', $xcl, 'NPP="' .  $wfid.'"' );
		$crow1 = $this->db->query($ustr);
		//$crow2 = $this->db->query($ustr2);
		//$ret = array($crow1,$crow2); 
		$ret = $crow1; 
		echo json_encode($ret);
	}
		public function previledge(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$this->page->view('v_previledge');
	}

	public function reviewupdate(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$this->page->view('v_revupdate');
	}
	
	public function call_reviewupdate(){
		$fdt = $this->input->post();
		$accofc = $fdt['accOffice'];
		$stored_procedure = "CALL update_review(?)";
		$crow1 = $this->db->query($stored_procedure,array('accofc'=>$accofc));
		$ret = array($crow1);
		log_message('debug', print_r(array("call_rev"=>$ret), TRUE)); 
		echo json_encode($ret);
	}
	
	public function query_prev(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$fmdata = $this->input->post();
		$id = $fmdata['loginid'];
		
		$query = $this->db->query("select xp.*,  xpos.name as name 
		from xpreviledge xp join xlogin xl ON xp.positionid = xl.positionid join xposition xpos ON xp.positionid = xpos.positionid where xl.loginid = ". $id);
		
        echo json_encode($query->row());	
	}
	public function update_prev(){
		$fdt = $this->input->post();
		$wfid = $fdt['positionid'];
		$xcp = array('previledgeid'=>$fdt['previledgeid'], 'positionid'=>$fdt['positionid'],'icons'=>$fdt['icons'], 'sco'=>$fdt['sco'], 'eis'=>$fdt['eis'],
					'idminit'=>$fdt['idminit'], 'prsk'=>$fdt['prsk'], 'f1m'=>$fdt['f1m'],'forum'=>$fdt['forum'],'ims'=>$fdt['ims'], 'internet'=>$fdt['internet'], 'psn'=>$fdt['psn'],'sec'=>$fdt['sec'],
					'ska'=>$fdt['ska'], 'fsep'=>$fdt['fsep'], 'ibank'=>$fdt['ibank'],'nska'=>$fdt['nska'], 'opbg'=>$fdt['opbg'], 'srp'=>$fdt['srp'], 'svs'=>$fdt['svs'],'tplus'=>$fdt['tplus'],
					'wms'=>$fdt['wms'], 'idm'=>$fdt['idm'], 'idmapprove'=>$fdt['idmapprove'],'crm'=>$fdt['crm'], 'cst'=>$fdt['cst'], 'bar'=>$fdt['bar'], 'smpk'=>$fdt['smpk'],'jabatan'=>$fdt['jabatan']
					); 
		$ustr = $this->db->update_string('xpreviledge', $xcp, 'positionid =' .  $wfid );
		$crow1 = $this->db->query($ustr);
		$ret = array($crow1);
		echo json_encode($ret);
	}
	
	//jumlah request perubahan
	public function chg_req(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_chg_req';
		$this->page->view('v_monitoring',$data);
	}
	
	public function chg_req_list(){
		$query_submit = $this->db->query("select xrp.accoffice, xent.name, count(*) as jumlah from xreviewpos xrp 
											join xentitas xent on xrp.accoffice = xent.accOffice 
											where xent.wave = 3 and xrp.type <> 'RQ' group by xrp.accoffice, xent.name") ;
									 
		$cpriv1 = $query_submit->result();
		$ret = array('data'=>$cpriv1);
		echo json_encode($ret);
	}
	
	public function chg_req_list2(){
		$query_submit = $this->db->query("select xrp.accoffice, xent.name, count(*) as jumlah from xreviewpos xrp 
											join xentitas xent on xrp.accoffice = xent.accOffice 
											where xent.wave = 2 and xrp.type <> 'RQ' group by xrp.accoffice, xent.name") ;
									 
		$cpriv1 = $query_submit->result();
		$ret = array('data'=>$cpriv1);
		echo json_encode($ret);
	}
	//jumlah request perubahan
	
	//jumlah login
	public function login_sum(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_login_sum';
		$this->page->view('v_monitoring',$data);
	}
	
	public function login_sum_list2(){
/* 		$query_submit = $this->db->query("select xemp.accOffice, xent.name, xent.hierarchy, count(*) as jumlah from xemployee xemp
											join xentitas xent on xemp.accOffice = xent.accOffice
											join v_login_previlegde1 vlp on xemp.NPP = vlp.loginid
											where xemp.password is not null group by xemp.accOffice, xent.name, xent.hierarchy") ; */
									 
		$this->db->select('xemp.accOffice, xent.name, xent.hierarchy, count(*) as jumlah');
		$this->db->from('xemployee xemp');
		$this->db->join('xentitas xent', 'xemp.accOffice = xent.accOffice');
		$this->db->join('v_login_previlegde1 vlp', 'v_login_previlegde1 vlp on xemp.NPP = vlp.loginid');
		$this->db->where('xemp.password IS NOT NULL', null, false);
		$this->db->group_by(array("xemp.accOffice", "xent.name", "xent.hierarchy")); 
		foreach ($this->column_search as $item) // loop column 
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
		  
		//$cpriv1 = $query_submit->result();
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
		 $query = $this->db->get();
	 	$ret = array('data'=>$query->result());
		echo json_encode($ret);
	}
	
	public function login_sum_list3(){
		$query_submit = $this->db->query("select xemp.accOffice, xent.name, count(*) as jumlah from xemployee xemp
											join xentitas xent on xemp.accOffice = xent.accOffice
											join v_login_previlegde1 vlp on xemp.NPP = vlp.loginid
											where xemp.password is not null and xent.wave = 3 group by xemp.accOffice, xent.name") ;
									 
		$cpriv1 = $query_submit->result();
		$ret = array('data'=>$cpriv1);
		echo json_encode($ret);
	}
	
	public function login_sum_list4(){
		$query_submit = $this->db->query("select xemp.accOffice, xent.name, count(*) as jumlah from xemployee xemp
											join xentitas xent on xemp.accOffice = xent.accOffice
											join v_login_previlegde1 vlp on xemp.NPP = vlp.loginid
											where xemp.password is not null and xent.wave = 4 group by xemp.accOffice, xent.name") ;
									 
		$cpriv1 = $query_submit->result();
		$ret = array('data'=>$cpriv1);
		echo json_encode($ret);
	}
	//jumlah login
	
	public function monitoring(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_suspect';
		$this->page->view('v_monitoring',$data);
	}	
	public function suspect(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_suspect';
		$this->page->view('v_monitoring',$data);
	}
	public function wappr(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_wappr';
		$this->page->view('v_monitoring',$data);
	}
	public function reqsuccess(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_reqsuccess';
		$this->page->view('v_monitoring',$data);
	}
	public function wreq(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_wrequest';
		$this->page->view('v_monitoring',$data);
	}
	public function audit(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_audit';
		$this->page->view('v_monitoring',$data);
	}
	public function history_login(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_historylogin';
		$this->page->view('v_monitoring',$data);
	}
	public function res_not_create(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_resnotcreate';
		$this->page->view('v_monitoring',$data);
	}
	public function review_update(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_revupdate_data';
		$this->page->view('v_monitoring',$data);
	}
	
	public function review_update_submit(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_revupdate_data_submit';
		$this->page->view('v_monitoring',$data);
	}
	
	public function revupdate_list(){
		$tabel ="v_revupdate_list";
		$column_search = array('id','status','reqid','accOffice','loginid','name','posname','posnew','mobileNumber','mobilenew');
		$column_order = array('id','status','reqid','accOffice','loginid','name','posname','posnew','mobileNumber','mobilenew');
		$order = array('reqid' => 'desc');
		
		$this->_get_datatables_query($tabel, $column_search, $column_order, $order);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);		
		$quer = $this->db->get();
		$list = $quer->result();
		$filter =  $this->db->count_all($tabel);
		
		$output = array(
					"recordsFiltered" => $filter,
					"data" => $list,
				);
        echo json_encode($output);
	}
	
	public function revupdate_list_submit(){
		$tabel ="v_revupdate_list_submit";
		$column_search = array('id','status','reqid','accOffice','loginid','name','posname','posnew','mobileNumber','mobilenew');
		$column_order = array('id','status','reqid','accOffice','loginid','name','posname','posnew','mobileNumber','mobilenew');
		$order = array('reqid' => 'desc');
		
		$this->_get_datatables_query($tabel, $column_search, $column_order, $order);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);		
		$quer = $this->db->get();
		$list = $quer->result();
		$filter =  $this->db->count_all($tabel);
		
		$output = array(
					"recordsFiltered" => $filter,
					"data" => $list,
				);
        echo json_encode($output);
	}
	
	public function suspect_list(){
		$tabel ="v_xrsc_suspect";
		$column_search = array('id','refid','effDate','procStatus','systemId');
		$column_order = array('id','refid','effDate','procStatus','systemId');
		$order = array('id' => 'desc');
		
		$this->_get_datatables_query($tabel, $column_search, $column_order, $order);
		$this->db->where('procStatus','H');
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);		
		$quer = $this->db->get();
		$list = $quer->result();
		$filter =  $this->db->count_all($tabel);
		
		$output = array(
					"recordsFiltered" => $filter,
					"data" => $list,
				);
        echo json_encode($output);
	}
	public function wappr_list(){
		$tabel ="wait_approval";
		$column_search = array('id','loginid','procStat','sdate','edate','status','cdate','accOffice','type','details');
		$column_order = array('id','loginid','procStat','sdate','edate','status','cdate','accOffice','type','details');
		$order = array('id' => 'desc');
		
		$this->_get_datatables_query($tabel, $column_search, $column_order, $order);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);		
		$quer = $this->db->get();
		$list = $quer->result();
		$filter =  $this->db->count_all($tabel);
		$output = array(
					"recordsFiltered" => 1,
					"data" => $list,
				);
        echo json_encode($output);
	}
	public function reqsuccess_list(){
		$fdt = $this->input->post();
		if($fdt['target'] == "all"){
			$quer = $this->db->query("select xrs.id, xrs.refid, xrs.tflag, xrs.effDate, xrs.systemId, xrs.batchFlag, xrs.procStatus
					from xrscsync xrs where(xrs.batchFlag = 'A' and xrs.procStatus = 'P')and
					xrs.effDate > date_sub(now(), interval 1 day)");
		}else{
			$quer = $this->db->query("select xrs.id, xrs.refid, xrs.tflag, xrs.effDate, xrs.systemId, xrs.batchFlag, xrs.procStatus from 
					xrscsync xrs where (xrs.batchFlag = 'A' and xrs.procStatus = 'P') and xrs.effDate > date_sub(now(), interval 1 day) and
					xrs.systemID = ?",array($fdt['target']));
		}
			$list = $quer->result();		
			$output = array(
						"recordsFiltered" => 1,
						"data" => $list,
					);
			echo json_encode($output);
	}
	
	public function wreq_list(){
		//$quer = $this->db->query("select xrs.id, xrs.refid, xrs.tflag, xrs.effDate, xrs.systemId, xrs.batchFlag, xrs.procStatus, xrev.accoffice, xrev.loginid 
				//from xrscsync as xrs inner join xreviewpos as xrev on xrs.effDate = xrev.sdate or xrs.effDate = xrev.edate where xrs.effDate > NOW()");
		
		$tabel ="v_future_request";
		$column_search = array('id','effDate','batchFlag','procStatus','systemId','mode','refid');
		$column_order = array('id','effDate','batchFlag','procStatus','systemId','mode','refid');
		$order = array('id' => 'desc');
		
		$this->_get_datatables_query($tabel, $column_search, $column_order, $order);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);		
		$quer = $this->db->get();
		$list = $quer->result();
		$filter =  $this->db->count_all($tabel);
		$output = array(
					"recordsFiltered" => $filter,
					"data" => $list,
				);
		echo json_encode($output);
		
	}
	
	public function audit_list(){
		
		$db2 = $this->load->database('jbaudit', TRUE);
		$this->load->database('jbaudit', TRUE);
		$this->db->select('*')->from('v_login_previlegde1');
		$this->db->join('jbaudit.login6hrs', ' jbaudit.login6hrs.AUD_USER = jbpm.v_login_previlegde1.loginid');
		$this->db->join('jbpm.xemployee', ' jbpm.xemployee.NPP = jbpm.v_login_previlegde1.loginid');
		$query = $this->db->get();
		$list = $query -> result();
		
		/* $quer = $DB2->query("Select * from login6hrs");
		$array1=$quer ->result_array();
		$arr = array_map (function($value){
			return $value['AUD_USER'];
		} , $array1);
		//var_dump ($arr);
		$data = implode("','",$arr);
		$query = $this->db->query("select accOffice from xemployee where NPP IN ('".$data."')");
		$list = $quer -> result(); */
			//$a = $query -> result();
			//var_dump($a);
			/* $ar=$query ->result_array();
			$arra = array_map (function($value){
			return $value['accOffice'];
			} , $ar); */
			//$list -> accOffice = $ar ;
			
			
			
		
		
		
		
		$filter =  $db2->count_all('login6hrs');
		
		$output = array(
					"recordsFiltered" => $filter,
					"data" => $list,
				);
        echo json_encode($output);
	}
	function count_list()
    {
        $tabel ="revdraft";
		$column_search = array('AUD_USER');
		$column_order = array('AUD_DATE','User','Name','Acc Office','Client','Resource');
		$order = array('id' => 'desc');
		
		$a = $this->tabel_query($wfdetail, $tabel, $column_search, $column_order, $order);
        $query = $this->db->get();
        return $query->num_rows();
    }
	public function history_list(){
		
		$tabel ="revdraft";
		$column_search = array('AUD_USER');
		$column_order = array('AUD_DATE','User','Name','Acc Office','Client','Resource');
		$order = array('id' => 'desc');
		
		$a = $this->tabel_query($wfdetail, $tabel, $column_search, $column_order, $order);
		
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
		
		$query = $this->db->get();
		$list = $query -> result();
		$filter = $this->count_list();
		$output = array(
				"recordsFiltered" => $filter,
				"data" => $list,
		);
        echo json_encode($output);
	}
	private function tabel_query($wfdetail, $tabel, $column_search, $column_order, $order)
    {
        $db2 = $this->load->database('jbaudit', TRUE);
		$this->load->database('jbaudit', TRUE);
		$this->db->select('*')->from('jbpm.xemployee');
		$this->db->join('jbaudit.COM_AUDIT_TRAIL', ' jbaudit.COM_AUDIT_TRAIL.AUD_USER = jbpm.xemployee.NPP');
		$this->db->order_by("jbaudit.COM_AUDIT_TRAIL.AUD_DATE", "desc");
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
    }
	public function resnotcreate_list(){
		$tabel ="rsch_not_created";
		$column_search = array('id','effDate','batchFlag','procStatus','systemId','mode');
		$column_order = array('id','effDate','batchFlag','procStatus','systemId','mode');
		$order = array('id' => 'desc');
		
		$this->_get_datatables_query($tabel, $column_search, $column_order, $order);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);		
		$quer = $this->db->get();
		$list = $quer->result();
		$filter =  $this->db->count_all($tabel);
		$output = array(
					"recordsFiltered" => 1,
					"data" => $list,
				);
        echo json_encode($output);
	}
	public function wreq_detail(){	

		$fdt = $this->input->post();
		$quer = $this->db->query("select  ExtractValue(reqStr, '/banc/npp') AS npp, 
				ExtractValue(reqStr, '/banc/attr/value[1]') AS nama,
				ExtractValue(reqStr, '/banc/attr/value[3]') AS posname,
				ExtractValue(reqStr, '/banc/attr/value[2]') AS positionid, mode from jbpm.xrscsync where 
				id = ? and systemId = 'banc';",array($fdt['id']));
		$list = $quer->result();
		$output = array(
					"recordsFiltered" => 1,
					"data" => $list,
				);
		echo json_encode($output);
	}
	
	public function audit_detail(){
		$DB2 = $this->load->database('jbaudit', TRUE);	
		$fdt = $this->input->post();
		$quer = $DB2->query("SELECT * FROM COM_AUDIT_TRAIL WHERE AUD_CLIENT_IP = ? and
								  AUD_DATE > date_sub(now(), interval 23 hour)",array($fdt['client']));
		$list = $quer->result();
		$output = array(
					"recordsFiltered" => 1,
					"data" => $list,
				);
		echo json_encode($output);
	}
	public function wappr_detail(){
		$fdt = $this->input->post();
		$quer = $this->db->query("select id, currActor, currScore, targetScore from xwfparam where 
				id = ?",array($fdt['id']));
		$list = $quer->result(); 

		$output = array(
					"recordsFiltered" => 1,
					"data" => $list,
				);
		echo json_encode($output);
	}
	public function reqsuccess_detail(){	

		$fdt = $this->input->post();
			$quer = $this->db->query("select  ExtractValue(reqStr, '/banc/npp') AS npp, 
				ExtractValue(reqStr, '/banc/attr/value[1]') AS nama,
				ExtractValue(reqStr, '/banc/attr/value[3]') AS posname,
				ExtractValue(reqStr, '/banc/attr/value[2]') AS positionid, mode from jbpm.xrscsync where 
				refid = ? and systemId = 'banc';",array($fdt['id']));
				
		$list = $quer->result();

		$output = array(
					"recordsFiltered" => 1,
					"data" => $list,
				);
		
		echo json_encode($output);
	}
	
	public function accOffice(){
		//$fmdata = $this->input->post();
		//$loginid = $this->session->userdata('pengguna')->loginid;
		
		$query = $this->db->query("select xr.accoffice from xreviewpos xr JOIN xwfparam xw ON xr.wfid = xw.id join revdraft rd on rd.reqid = xr.wfid where xr.type = 'RQ' and xr.key1 = DATE_FORMAT(now(), '%Y%m') and xw.stage >= 3 and rd.status <> 'finish' group by xr.wfid, xr.accoffice") ;		//$opts = array();
		$cpriv = $query->result();	
		echo json_encode($cpriv);
	}
	
	public function sys_login(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_sys_login';
		$this->page->view('v_monitoring',$data);
	}
	
	public function sys_login_list(){
		$this->load->library('restclient', array());
		$dest_url = $this->config->item('cas_url') . 'frontend/sysstatus';
		log_message('debug', print_r($dest_url, TRUE)); 
		//$breply = $this->restclient->post($dest_url);
		$breply = file_get_contents('http://192.168.98.53:12004/frontend/sysstatus');
		echo $breply;
	}
		public function test_list(){
		$tabel ="xrscsync";
		//$column_search = array('id','refid','reqStr');
		//$column_order = array('id','refid','reqStr');
		//$order = array('id' => 'desc');
		
		//$this->_get_datatables_query($tabel, $column_search, $column_order, $order);
		//if($_POST['length'] != -1)
		$this->db->from($tabel);	
		$this->db->where('procStatus','H');
		//$this->db->limit($_POST['length'], $_POST['start']);		
		$quer = $this->db->get();
		$list = $quer->result();
		//var_dump($list);
		if ($list != null){
		foreach($list as $key=>$value){
			//$opts[] = array($value->reqStr);
			$a = $value->reqStr;
			$xml = simplexml_load_string($a);
			$json = json_encode($xml);
			$array = array(json_decode($json,TRUE));
			$arr = json_encode($array);
/* 			*/
			foreach($array as $key => $val){
				$opts[] = array(
					"mode" => $val['mode'],
					"npp" => $val['npp'],
					"branch" => $val['branch'],
					"status"=>  $value->procStatus,
					"id" => $value->id,
					"refid" => $value->refid);			
			}
			/*  */
		}}
		else{
			$opts = 0;

		}
		//var_dump($array);
		//var_dump($opts);
/* 		$xml = simplexml_load_string($xml_string);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE); */
		$filter =  $this->db->count_all($tabel);
		$output = array(
					"recordsFiltered" => 1,
					"data" => $opts,
				);
        echo json_encode($output);
		
	}
		public function test(){
		$this->page->template('admin_tpl');
		$this->page->header('templates/admin_header_tpl');
		$data['main'] = 'v_notdis';
		$this->page->view('v_monitoring',$data);
	}
		function update_list(){
		$fdt = $this->input->post();
		$uarr = array('procStatus'=>'I');
		foreach ($fdt['ids'] as $id){
			$ustr = $this->db->update_string("xrscsync", $uarr, "id=".$id);
			$this->db->query($ustr);
		}
		echo json_encode($fdt['ids']);
	}
} 
