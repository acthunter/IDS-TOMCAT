<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('M_idservice', 'ids');
		$this->load->library('cas');
	}
	
	public function index() {
		$this->load->library('cas');
		$this->cas->force_auth();
		$userAttr = $this->cas->user()->attributes;
		//cassession($this->session, $userAttr);
		$npp = $userAttr['loginid'];
		
		$data['pending'] = $this->ids->count_prop();	
		$data['approve'] = $this->ids->count_appr();
		$data['reject'] = $this->ids->count_reject();
		$this->page->view('v_approval', $data);
	}
	
	public function home_list($ptype) {	 //untuk menampilkan halaman approval berdasarkan status
		$accoffice = $_SESSION['pengguna']->accoffice;
		log_message('debug', print_r($accoffice, TRUE)); 
		$sql = "select xa.*, nn.loginid as nlogin, nn.notes, nn.ndate from
        xapproval xa left join (select max(ndate) as mdate, refid as rid from xnotes where ntype='A' OR ntype='R' OR ntype='T'  group by refid) 
			xn on xn.rid = xa.id 
			left join xnotes nn on  nn.ndate = xn.mdate
			where status=? and accoffice=?";
        $query = $this->db->query($sql, array($ptype, $accoffice));

		$output = array(
            "recordsTotal" => 1,
            "recordsFiltered" => 1,
            "data" => $query->result(),
        );
        echo json_encode($output);
	}
	
	
	
	public function apprbyid($id){ // untuk menampilkan datatable posisi pada v_approval
		$accoffice = $_SESSION['pengguna']->accoffice;
		$sql = "select xa.* from xapproval xa where xa.id=?";
        $query = $this->db->query($sql, array($id));
		
        $row = $query->row();		
		if (isset($row)){
			$query = $this->db->query("select * from xnotes xn where xn.refid=? 
									and xn.ntype=? order by xn.ndate DESC limit 3", array($row->id, 'A'));
			$row->notes=$query->result();
			
			if ($row->reqtype=='K'){
				$query = $this->db->query("select * from xxpriv xx where xx.reqid = ? ", array($row->id));
				$row->tpos = $query->row();
			} else {
				$query = $this->db->query("select * from revdraft rd where rd.reqid = ? ", array($row->id));
				$row->refdraft = $query->result();
			}
		}
		
		$ret = (object) array();
		log_message('debug', print_r($ret, TRUE));
		if ($row->reqtype=='K'){
			$ret->data = $row->tpos;
			$ret->recordsTotal = 1;
			$ret->recordsFiltered = 1;
			$ret->notes=$row->notes;
		} else {
			$ret->data = $row->refdraft;
			$ret->recordsTotal = 1;
			$ret->recordsFiltered = 1;
			$ret->notes=$row->notes;
		}
		echo json_encode($ret);
	}
	
	public function propose() { // untuk merubah status dr R menjadi P pada hal v_approval
		$this->load->library('cas');
		$this->cas->force_auth();
		$userAttr = $this->cas->user()->attributes;
		cassession($this->session, $userAttr);
		
		$fpost = $this->input->post();
		$reqid = $fpost['reqid'];
		$npp = $userAttr['loginid'];
		
		$fpost = $this->input->post();
		$reqid = $fpost['reqid'];
		$tposid = $fpost['tposid'];
		$query = $this->db->query("UPDATE xapproval SET apptime = null, status = 'P' WHERE id = ". $reqid);
		$query2 = $this->db->query("INSERT INTO xnotes (notes,refid,ntype,loginid) 
					VALUES ('".$fpost['note']."','".$reqid."','A','".$npp."')");
		if ($fpost['reqtype'] == 'K'){
			$query1 = $this->db->query("UPDATE xxpriv SET tpos = '".$tposid."', sdate = '".date('Y-m-d h:i',strtotime($fpost['trx_dt']))."', edate = '".date('Y-m-d h:i',strtotime($fpost['ex_dt']))."' WHERE id = ". $fpost['id']);
		} else {
			$query1 = $query ;
		}
		
		
		echo json_encode($query1);
	}
	
	public function approve() { //untuk mengapprove pada hal v_approval
		$fpost = $this->input->post();
		$reqid = $fpost['reqid'];
		$query = $this->db->query("UPDATE xapproval SET status = 'A' WHERE id = " . $reqid);
		echo json_encode($query);
	}
	
	public function reject() { // untuk mereject pada hal . v_approval
		
		$this->load->library('cas');
		$this->cas->force_auth();
		$userAttr = $this->cas->user()->attributes;
		cassession($this->session, $userAttr);
		
		$fpost = $this->input->post();
		$reqid = $fpost['reqid'];
		$npp = $userAttr['loginid'];
		
		$query = $this->db->query("UPDATE xapproval SET status = 'R' WHERE id = " . $reqid);
		$query2 = $this->db->query("INSERT INTO xnotes (notes,refid,ntype,loginid) 
					VALUES ('".$fpost['note']."','".$reqid."','A','".$npp."')");
		echo json_encode($query);
	}
	
	public function cancel() { //untuk cancel pada hal . v_approval
		$fpost = $this->input->post();
		$reqid = $fpost['reqid'];
		
		$query = $this->db->query("UPDATE xapproval SET apptime = null, status = 'C' WHERE id = ". $reqid);
		
		echo json_encode($query);
	}
	
	
}