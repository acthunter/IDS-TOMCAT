<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Temppos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
		$this->load->model('m_idservice', 'ids');
	}

	public function index()
	{
		$idm_init = $_SESSION['pengguna']->idm_init;
		$idm_appr = $_SESSION['pengguna']->idm_appr;
		
		if ($idm_init > 0) {
			$this->load->helper('url');
			$this->page->view('v_kewenangan', array (
			'add' => $this->page->base_url('/add')
		));
		} else {
			redirect('mposition/');
		}
	}
	
	public function tpos($id) //untuk menampilkan halaman posisi pada approval 
	{	
		$query = $this->db->query("select xxp.*, vlp2.name as tposname, vl.name, vlp.name as posname from xxpriv xxp 
            inner join xapproval app on app.id = xxp.reqid
			inner join v_login_name vl on xxp.loginid = vl.loginid
			inner join v_login_previlegde1 as vlp on xxp.loginid = vlp.loginid
            left join v_login_previlegde1 as vlp2 on xxp.tpos = vlp2.previledgeid
            where xxp.reqid =".$id);
        $crow = $query->row();
		if ($crow != null){
			$query = $this->db->query("select * from xnotes xn inner join v_login_name vl on vl.loginid = xn.loginid where xn.refid = ${id} and xn.ntype='T'" );
			$crow->notes = $query->result();
		  echo json_encode($crow);
		}
	}
	public function query(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$fmdata = $this->input->post();
		$npp = $fmdata['npp'];
		
		$query = $this->db->query("select vl.name , vp1.name as nama, vp1.positionid, vp1.accOffice  from v_login_previlegde1 vp1
				inner join v_login_name vl on vp1.loginid = vl.loginid
			where vl.accOffice = '746' and vl.loginid = ". $npp);
		
        echo json_encode($query->row());	
	}
	
	public function query_wf(){ //untuk menampilkan hasil query setelah dienter pada hal v_kewenangan 
		$fmdata = $this->input->post();
		$id = $fmdata['id'];
		
		$query = $this->db->query("Select vlm.name, xw.id,  xw.stage, xw.mode, xw.initiator, xw.currActor, xw.doneActor, xw.currScore, xr.cdate 
		from xwfparam xw JOIN xreviewpos xr ON xw.id = xr.wfid JOIN v_login_name vlm ON xw.initiator = vlm.loginid
		where xw.id = " . $id);
		
        echo json_encode($query->row());	
	}
	
	public function add(){ //untuk menyimpan data baru pada hal v_kewenangan
		$this->load->library('cas');
		$this->cas->force_auth();
		$userAttr = $this->cas->user()->attributes;
		cassession($this->session, $userAttr);
		$npp = $userAttr['loginid'];
		$fmdata = $this->input->post();
		//var_dump($fmdata);
		$test = $fmdata['tposid'];
		$query = $this->db->query("INSERT INTO xapproval (requestor, accOffice, reqtype,approval,status) values ('".$npp."','746','K','51982','P')");			
		//var_dump($query);
		$kode = $this->ids->getCode();
		$query2 = $this->db->query("INSERT INTO xxpriv (reqid, loginid, tpos, sdate,edate) values ('".$kode['id']."','".$fmdata['npp']."','".$fmdata['tposid']."','".date('Y-m-d h:i',strtotime($fmdata['trx_dt']))."','".date('Y-m-d h:i',strtotime($fmdata['ex_dt']))."')");
		$query3 = $this->db->query("INSERT INTO xnotes (refid, ntype, notes, loginid) VALUES ('".$kode['id']."', 'T', '".$fmdata['notes']."', '".$npp."')");
        echo json_encode($query3);	
	}
	
	public function pos_search() //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		$pattern =  $this->input->post()['pattern'];
		
		$data = $this->db->query("select *  from xposition where name like '%" . $pattern . "%'");
		$crow = $data->result();
		
		foreach( $crow as $r )  
        {  
		   $position[] = array(   
                'pname' => $r->name, 
				'positionid' => $r->positionid
            );
        }  
		echo json_encode($position);
    }
	
	public function pos_search_wf($pattern) //pencarian data posisi bedasarkan inputan hal v_kewenangan
	{   
		//$pattern =  $this->input->post()['pattern'];
		
		$data = $this->db->query("select *  from xwfparam where accOffice like '%".$accoffice."%' AND name like '%" . $pattern . "%'");
		$crow = $data->result();
		
		foreach( $crow as $r )  
        {  
		   $position[] = array(   
                'initiator' => $r->initiator, 
				'stage' => $r->stage
            );
        }  
		echo json_encode($position);
    }
	
} 