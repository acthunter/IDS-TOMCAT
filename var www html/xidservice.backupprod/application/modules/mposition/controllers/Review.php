<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database();	
		$this->load->model('M_idservice', 'ids');
	}

	public function index(){		
		$idm_init = $_SESSION['pengguna']->idm_init;
		$idm_appr = $_SESSION['pengguna']->idm_appr;
		if ($idm_init > 0) {
			$this->load->helper('url');
			$this->page->view('v_posisi', array (
			'add' => $this->page->base_url('/add')
		));
		} else {
			redirect('mposition/');
		}
	}
	
/* 	public function index1() {		
        $query = $this->db->query("SELECT xa.*, xn.notes, xn.loginid as nloginid FROM
        xapproval xa INNER JOIN xnotes xn ON xn.refid = xa.id WHERE xn.id = (SELECT id FROM xnotes xz WHERE xz.refid = xa.id ORDER BY xz.ndate desc limit 1)");
        
		echo json_encode($query->result());
	} */
	
 	public function pos_list()
	{ // tampil list rpos
        $query = $this->db->query("SELECT re.* from revdraft re");
        $list = $query->result(); 
		
		$output = array(
            "recordsTotal" => 1,
            "recordsFiltered" => 1,
            "data" => $list,
        );
        echo json_encode($output);
	} 
	
/* 	public function create() {
		$userData = $this->session->userdata('pengguna');
		log_message('debug', print_r($userData, TRUE)); 
		$accoffice = $userData->accoffice;
		$query = $this->db->query("select id from xapproval where accoffice = ${accoffice} and month(now()) = month(reqtime) 
			and year(now()) = year(reqtime)");
		
		$xapprCount = $query->num_rows();
		if ($xapprCount==0){
			$this->db->trans_start();
			$tdata = array ('reqtype'=>'P', 'accoffice'=>$accoffice);
			$this->db->insert('xapproval', $tdata); 
			
			$refId = $this->db->insert_id();
			
			$query = $this->db->query("insert into revdraft(reqid, loginid, mobileNumber, positionid, pname) 
				select ${refId}, loginid, mobileNumber, positionid, pname from v_review_pos where accOffice = ${accoffice} limit 5");
			$this->db->trans_complete();
			echo json_encode("create new");
		} else {
			echo json_encode("reuse");
		} 
	}
	 
 	public function get($id) {	
		$this->db->where('id',$id);
        $query = $this->db->get("xapproval");
        $crow = $query->row();
		if ($crow != null){
			$query = $this->db->query("select * from xnotes xn inner join v_login_name vl on vl.loginid = xn.loginid where xn.refid = ${id} and xn.ntype='R'");
			$crow->notes = $query->result();
			echo json_encode($crow);
		}
	} */
	
	public function edit($id)
	{ // edit item rpos
        $query = $this->db->query("SELECT * FROM revdraft WHERE id = '$id'");
        $crow = $query->row();
		echo json_encode($crow);
	}
	
	public function add()
	{ // submit list rpos ke xapproval
		$this->load->library('cas');
		$this->cas->force_auth();
		$userAttr = $this->cas->user()->attributes;
		cassession($this->session, $userAttr);
		$npp = $userAttr['loginid'];
	
		$key = $this->ids->getid();
		$fmdata = $this->input->post();
		$notes = $fmdata['note'];
		if ($key['reqid'] == null) {
			$query = $this->db->query("INSERT INTO xapproval (reqtype, accOffice, requestor, approval, status) VALUES ('P','746','".$npp."','51982','P')");
			$kode = $this->ids->getCode();		
			$query3 = $this->db->query("INSERT INTO xnotes (refid, ntype, notes, loginid) VALUES ('".$kode['id']."', 'R', '".$notes."', '".$npp."')");
		}
		else {
			$query = $this->db->query("UPDATE xapproval SET reqtype = 'P', accOffice = '746', requestor = '".$npp."', approval = '51982', status = 'P' WHERE reqtype = 'P'");
			$kode = $this->ids->getCode2(array('reqtype' => 'P'));
			$query3 = $this->db->query("INSERT INTO xnotes (refid, notes, ntype, loginid) VALUES ('".$kode['id']."', '".$notes."', 'R', '".$npp."')");
		}
		$row = $this->db->query("UPDATE revdraft SET reqid = ". $kode['id']);
		
		echo json_encode($row);
	}
	
	public function update()
	{ 
		$this->load->library('cas');
		$this->cas->force_auth();
		$userAttr = $this->cas->user()->attributes;
		//cassession($this->session, $userAttr);
		$npp = $userAttr['loginid'];
		
		$fpost = $this->input->post();

/* 		$fldlist = array('name','positionid','pname','mobileNumber');
		$updatearr = (object) array();
		foreach ($fldlist as $cfld){
			if (isset($fpost[$cfld]))
				$updatearr->$cfld = $fpost[$cfld];
		}
		
		$ustr = $this->db->update_string("revdraft", $updatearr, "id=" . $fpost['0']);
		$query = $this->db->query($ustr);
		log_message('debug', print_r(array("testparam"=>$fpost), TRUE)); */
		//$fpost = filter_input_array(INPUT_POST);
		$query = $this->db->query("UPDATE revdraft SET  pname = '".$fpost['pname']."',  mobileNumber = '".$fpost['mobileNumber']."', flag = 'E' WHERE id = ". $fpost['0']);
		echo json_encode($query);
	}

/* 	public function flag() {  
		$fpost = $this->input->post();
		$id = $fpost['id'];
		
		$query = $this->db->query("UPDATE revdraft SET flag = '".$fpost['flag']."' WHERE id = ". $id);
		
		echo json_encode($query);
	} */
} 