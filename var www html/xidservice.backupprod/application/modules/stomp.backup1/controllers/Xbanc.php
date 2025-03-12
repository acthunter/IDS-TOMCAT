<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xbanc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
		$this->load->model('xbanc_model', 'mxbanc');
		$this->load->model('xpriv_model', 'mxpriv');
	}

	public function index()
	{	
		$this->load->library('cas');
		$this->cas->force_auth();
		$userAttr = $this->cas->user()->attributes;
		cassession($this->session, $userAttr);
		
		$this->load->helper('url');
		$this->page->view('v_banc_iq', array (
			'add' => $this->page->base_url('/add')
		));
	}
	
	private function setPriviledge($privstrid, $privval){
		$this->session->set_userdata('priv_' . $privstrid, $privval);
	}
	
	private function get_init_priv(){
		$idm = $this->session->userdata('pengguna')->idm;
		return $idm % 10;
	}
	
	private function get_appr_priv(){
		$idm = $this->session->userdata('pengguna')->idm;
		return ($idm / 10) % 10;
	}
	
	public function v_query1()
	{
		$myid = $this->cas->getmycas_login(array('idm_super'));
		$this->load->helper('url');

			$this->page->template('admin_tpl');
			$this->page->header('templates/admin_header_tpl');
			$this->page->view('v_banc1');
	}

	public function v_gchart1()
	{
		$this->load->helper('url');
		$this->page->view('v_gchart1', array (
			'add' => $this->page->base_url('/add')
		));
	}
	
	public function query_id()
	{
		//$row = array("nama"=>"abcde", "mobileNumber"=>"active");
		$fmdata = $this->input->post();
		
		$row = $this->mxbanc->get_banc_login($fmdata['npp']);
		
		echo json_encode($row);
	}

	// add new ryanda
	
	public function load_form_iq()
	{
		//$this->page->view('v_banc_iq');
		
		$this->load->helper('url');
		$this->page->view('v_banc_iq', array (
			'add' => $this->page->base_url('/add')
		));
		
		//$fmdata = $this->input->post();
		
		//redirect('stomp/xbanc/update_kewenangan');
		
		//$row = $this->mxbanc->update_kewenangan($fmdata['npp']);
		
		//echo json_encode($row);
	}
	
	public function query_id_dmy()
	{
		//$this->page->view('v_banc');
		
		$fmdata = $this->input->post();
		
		$row = $this->mxbanc->inquiry_dmy($fmdata['npp']);
		
		echo json_encode($row);
		
	}
	
	public function query_tellparam()
	{
		
		$fmdata = $this->input->post();
		if ($fmdata['reqtype'] == 'tellparam'){
			$row = $this->mxbanc->get_tellparam($fmdata['npp'], $fmdata['effDate']);
		} else if ($fmdata['reqtype'] == 'tellinq'){
			$row = $this->mxbanc->get_banc_login($fmdata['npp']);
		}
		
		echo json_encode($row);
		
	}
	
	public function ubah_level()
	{
		
		$fmdata = $this->input->post();
		
		$row = $this->mxbanc->ubah_level($fmdata['npp']);
		
		echo json_encode($row);
		
	}
	
	public function save_priv()
	{
		
		$fmdata = $this->input->post();
		
		$this->mxpriv->npp = $fmdata['npp'];
		$this->mxpriv->requestor = 'dumm_user';
		$this->mxpriv->cpos = $fmdata['cposid'];

		$row = $this->mxpriv->save();
		echo json_encode($row);
		
	}
	
	public function test_rest()
	{
		$myconfig = array();
		$this->load->library('restclient', $myconfig);
		
		$row = $this->restclient->post('http://172.18.2.80:8080/chgpos/test2', ['v1'=>'v']);
		//$row = $this->restclient->get('http://10.29.4.252:8080/cas/admindate/test2', ['v1'=>'v']); 
		echo json_encode($row);
		
	}
	
	public function sys_admin(){
		$this->load->helper('url');
		$this->page->template('simple_tpl');
		$this->page->view('v_sysadmin', array (
			'add' => $this->page->base_url('/add')
		));
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
	
	
	
	public function gen_gchart()
	{
		$row = array(["name"=>"Sprint 0", "desc"=>"Analysis", 
		"values"=>array(["from" =>"/Date(1320192000000)/",
						"to" =>"/Date(1322401600000)/",
						"label" => "Requirement Gathering",
						"customClass" => "ganttRed"])],
						["name"=>"Sprint 1", "desc"=>"Analysis", 
		"values"=>array(["from" =>"/Date(1320192000000)/",
						"to" =>"/Date(1322401600000)/",
						"label" => "Requirement Gathering",
						"customClass" => "ganttRed"])]
						);
		echo json_encode($row);
	}
	
	public function gen_gchart_db()
	{
		
		log_message('debug', print_r($this->config->item('cas_url'), TRUE)); 
		$row = $this->mxbanc->get_tcpos('51981');
		
		echo json_encode($row);
	}
	// add new ryanda
} 