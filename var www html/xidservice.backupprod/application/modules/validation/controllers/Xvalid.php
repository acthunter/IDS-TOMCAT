<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xvalid extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->uapps_filter = array(
			"54086"=>"banc,b24,periskop,eis",
			"21303"=>"banc,b24,periskop,eis",
			"55720"=>"banc,b24,periskop,eis",
			"37559"=>"banc,b24,periskop,eis",
			"3176"=>"banc,b24,periskop,eis",
			"25311"=>"banc,b24,periskop,eis",
			"20495"=>"banc,b24,periskop,eis",
			"23409"=>"banc,b24,periskop,eis",
			"93702"=>"banc,b24,periskop,eis"
		);		
	}
	
	private function initparam(){
		$this->uapps_filter = array(
				"25246"=>"banc,b24,periskop,eis",
				"21303"=>"banc,b24,periskop,eis",
				"3176"=>"banc,b24,periskop,eis"
			);
	}
	
	/* public function form_valid()
	{	
		$this->page->template('site_tpl');
		$this->page->view("v_valid");
	} */
	public function index(){
		$myid = $this->cas->getmycas_login(array('idm_idadmin'));
		if ($this->input->method(TRUE) == 'GET'){
		$fmdata = $this->input->get();
		return $this->show_form($myid);
		}else {
				$fmdata = $this->input->post();
				$sdata_new = array("reqtype"=>'resetPass', "actor"=>$myid, "detail"=>'test');
				$this->load->library('restclient', array());
				$dest_url = $this->config->item('cas_url') . 'bqueue/pickup';
				$breply = $this->restclient->post($dest_url, $sdata_new);
				if(isset($breply['status'])){
				if ($breply['status'] == 'no more resources'){
					$breply = array(
						"vlist" => 0,
						"queue" => 0,
						
					);
				}}
				
				echo json_encode($breply);
				
			//}
		}
	}
	public function validate()
	{	
		$fmdata = $this->input->post();
		if($fmdata['req'] == "validate"){
			$status = "K";
		}else{
			$status = "L";
		}
		
		$xcp = array('detail' => $fmdata['detail'] , 'status' => $status);
		
		//$where = "trid = 1 AND status = 'active'"; 
		$ustr = $this->db->update_string('xvalidation', $xcp, 'trid="'.$fmdata['trid'].'" AND id= "'.$fmdata['id'].'"');
		$ret = $this->db->query($ustr);
		if ($ret != null){
					$breply = array("resp" => "true");
				}else{
					$breply = array("resp" => "false");
				}
				echo json_encode($breply);
		
	}
	
	public function processed()
	{	
		$fmdata = $this->input->post();
		
		
		/* $this->load->model('M_validation', 'xmod');
		$actret = $this->xmod->wfaction(); */
		//$arr = array_shift($actret);
		//var_dump($actret-> id);
		$xcp = array('status' => 'P');
		$ustr = $this->db->update_string('xqueue', $xcp, 'id="'.$fmdata['id'].'"');
		$ret = $this->db->query($ustr);
		echo json_encode($ret);
	}
	public function show_form($myid)
	{	
		$appfilter = $this->uapps_filter[$myid];
		$this->page->template('site_tpl');
		//$appfilter = array_key_exists($myid, $this->uapps_filter) ? $this->uapps_filter[$myid] : "";
		//var_dump($appfilter);
		$this->page->view("v_valid", array('appfilter'=>$appfilter));
	}
	
	
}