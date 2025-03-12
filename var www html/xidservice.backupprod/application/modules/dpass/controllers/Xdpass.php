<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xdpass extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
		$this->load->library('session');
		$this->load->model('xwf_model', 'wfmodel');
	}
	
	public function index()
	{	
		$this->page->template('site_tpl');
		$this->page->view('v_dpass');
	}
	
	public function getpass(){
		//$query = $this->db->query("SELECT reqid, id, count(*) as resource FROM transitRepo WHERE status = 'L' GROUP BY reqid");
		$query = $this->db->query("SELECT tr.loginid, tr.reqid, tr.id, xr.accOffice FROM jbpm.transitRepo tr JOIN jbpm.xrequest xr ON tr.reqid = xr.id WHERE tr.status = 'X' ORDER BY tr.loginid");
		$list = $query->result();		
		$output = array(
			"recordsFiltered" => 1,
			"data" => $list,
		);
		echo json_encode($output);
	}
	
	public function detail(){
		$fdata = $this->input->post();
		$reqid = $fdata['reqid'];
		$query = $this->db->query("SELECT id, reqid, loginid, target, status FROM transitRepo WHERE reqid = ".$reqid."");
		$list = $query->result();		
		$output = array(
			"recordsFiltered" => 1,
			"data" => $list,
		);
		echo json_encode($output);
	}
	
	public function wfaction(){
		$fdt = $this->input->post();
		$id = $fdt['id'];
		$this->load->model('Xmod_UC', 'xmod');
		$actret = $this->xmod->wfaction();
		echo json_encode($actret);
		
		$xcp = array('status'=>'Y');
		$ustr = $this->db->update_string('transitRepo', $xcp, 'id=' . $id);
		$ret = $this->db->query($ustr);
	}
	/* public function rp_mark(){
		$fdt = $this->input->post();
		
		if (preg_match('/proses/',$fdt['mtype']))
			$uarr = array('status'=>'U');
		if (preg_match('/tolak/',$fdt['mtype']))
			$uarr = array ('status'=>'K');
			
		foreach ($fdt['ids'] as $id){
			$ustr = $this->db->update_string("transitRepo", $uarr, "id=".$id);
			$this->db->query($ustr);
		}
		echo json_encode($fdt['ids']);
	} */
}