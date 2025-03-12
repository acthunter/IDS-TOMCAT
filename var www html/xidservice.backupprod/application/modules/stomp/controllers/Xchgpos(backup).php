<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xchgpos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
		$this->load->model('xwf_model', 'wfmodel');
	}

	public function index()
	{	
		$this->page->view('v_ctest');
	}
	
	public function wfaction(){
		$fdt = $this->input->post();
		$wfid = $fdt['wfid'];
		$reqtype = $fdt['reqtype'];
		$myid = $this->cas->getmycas_login($this->cas);
		log_message('debug', print_r(array("xcp.wfaction"=>$fdt), TRUE)); 
		
		if (preg_match('/submit/',$fdt['reqtype'])){
			$xcp = array('loginid'=>$fdt['loginid'], 'tpos'=>$fdt['tposid'],
				'sdate'=> date('Y-m-d h:i',strtotime($fdt['sdate'])), 
				'edate'=> date('Y-m-d h:i',strtotime($fdt['edate'])), 
			);
			
			//log_message('debug', print_r(array('arr.xcp'=>$xcp), TRUE));
			$ustr = $this->db->update_string('xchgpos', $xcp, 'id=' . $fdt['id']  );
			$this->db->query($ustr);
			log_message('debug', print_r(array('save.xcp'=>$ustr), TRUE));
		}
		
		
		$direction = 0;
		if (preg_match('/(submit|approve)/',$fdt['reqtype']))
			$direction = 1;
		if (preg_match('/(reject|cancel)/',$fdt['reqtype']))
			$direction = -1;
		if ($direction == 0){
			if (preg_match('/(release)/',$fdt['reqtype'])){
				$ret = $this->wfmodel->releasejob($myid,$wfid);
			}
		} else {
			$myid = $this->session->userdata('pengguna')->loginid;
			$ret = $this->wfmodel->action($myid,$wfid, $direction, $fdt['notes']);
		}
		echo json_encode($ret);
	}
	 
} 