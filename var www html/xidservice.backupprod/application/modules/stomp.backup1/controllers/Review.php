<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		

	}

	public function index()
	{	
		
        $query = $this->db->query("select xa.*, xn.notes,xn.loginid as nloginid from xapproval xa inner join xnotes xn on xn.refid = xa.id where  xn.id = (select id from xnotes xz where xz.refid = xa.id order by xz.ndate desc limit 1)");
        echo json_encode($query->result());
	}
	
	public function add(){
		$userData = $this->session->userdata('pengguna');
		log_message('debug', print_r($userData, TRUE)); 
		$accoffice = $userData->accoffice;
		
		//find current month job review 
		$query = $this->db->query("select id from xapproval where accoffice = ${accoffice} and month(now()) = month(reqtime) 
			and year(now()) = year(reqtime)");
		
		$xapprCount = $query->num_rows();
		if ($xapprCount==0){
			$this->db->trans_start();
			//create approval
			$tdata = array ('reqtype'=>'P', 'accoffice'=>$accoffice);
			$this->db->insert('xapproval', $tdata); 
			
			$refId = $this->db->insert_id();
			
			$query = $this->db->query("insert into revdraft(reqid, loginid, mobileNumber, positionid) 
				select ${refId}, loginid, mobileNumber, positionid from v_review_pos where accOffice = ${accoffice} limit 5");
			//$qresult = $query->result();
			$this->db->trans_complete();
			echo json_encode("create new");
		} else {
			echo json_encode("reuse");
		}
		 
		//log_message('debug', print_r($userData, TRUE)); 
		//import all loginid in current pos
		
	}
	
	
	public function xtest1($id)
	{	
		$this->db->where('id',$id);
        $query = $this->db->get("xapproval");
        $crow = $query->row();
		if ($crow != null){
			/*$this->db->where('refid',$id);
			$this->db->order_by('ndate', 'DESC');
			$this->db->join('v_login_name', ')
			$query = $this->db->get("xnotes xn");
			$crow->notes = $query->result();
			*/
			$query = $this->db->query("select * from xnotes xn inner join v_login_name vl on vl.loginid = xn.loginid where xn.refid = ${id}");
			$crow->notes = $query->result();
		  echo json_encode($crow);
		}
	}
	
	public function apprbytype($ptype){
		$accoffice = $_SESSION['pengguna']->accoffice;
		log_message('debug', print_r($accoffice, TRUE)); 
		$sql = "select xa.*, nn.loginid as nlogin, nn.notes, nn.ndate from
        xapproval xa left join (select max(ndate) as mdate, refid as rid from xnotes where ntype='A' group by refid) 
			xn on xn.rid = xa.id 
			left join xnotes nn on  nn.ndate = xn.mdate
			where status=? and accoffice=?";
        $query = $this->db->query($sql, array($ptype, $accoffice));
        echo json_encode($query->result());
	}

	public function apprbyid($id){
		$accoffice = $_SESSION['pengguna']->accoffice;
		$sql = "select xa.* from xapproval xa where xa.id=?";
        $query = $this->db->query($sql, array($id));
		
        $row = $query->row();
		if (isset($row)){
			$query = $this->db->query("select * from xnotes xn where xn.refid = ? order by xn.ndate desc", array($row->id));
			$row->notes=$query->result();
		}
		 echo json_encode($row);
	}
} 