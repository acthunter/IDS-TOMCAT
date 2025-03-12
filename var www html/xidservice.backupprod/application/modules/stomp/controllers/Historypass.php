<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historypass extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('xwf_model', 'wfmodel');
		$this->load->library('session');
        if(!$this->session->userdata('pengguna')){
           redirect('log_out', 'refresh');
        }

	}
	public function index()
	{	
		//$myid = $this->cas->getmycas_login(array('killbanc'));
		$this->page->template('site_tpl');
			$this->page->view('v_historypass');

	}
	public function getreq(){
		//$list = $this->wfmodel->getreq2(); 
		/* if($this->input->post('request'))
        {
			$list = $this->wfmodel->getreq2(); 
		}else{
			$list = 0; 
		} */
		$list = $this->wfmodel->getreq2(); 
		foreach ($list as $row){
			//var_dump($row);
			/* if ($row->req_stat == 'I' ){ */
			$app = explode(",",$row->apps);
			$val   = explode(",",$row->req);
			$data_app = [];
			foreach( $app as $index => $apps ) {
				if($apps == "ldapAccount_oid"){
					$apps = "webmail";			
				} else if($apps == "banc"){
					$apps = "icons";			
				}else if($apps == "prsk"){
					$apps = "Periskop";			
				}
				if ($val[$index] ="RST"){
					$val_req = 'Reset';
				}else{
					$val_req = 'Create';
				}
			  $data_app[] = $apps.' : '.$val_req;
			}
				$aa[] = array(
					'no_srt'=>$row->key1,
					'id'=>$row->id,
					'reqid'=>$row->reqid,
					'tgl_srt' => $row->doc_date,
					'user_req' => $row->loginid,
					'unit' => $row->accOffice,
					'status' => $row->status,
					'stat' => $row->qid,
					'apps' => implode('<br>',$data_app)
				);
			/* } */
			
			//var_dump($dat['loginid']);
			/* foreach($dat as $key){
			$a = $key;
				var_dump($a);
			} */
			
		}
		if (isset ($aa)){
		$list = $aa;
		//var_dump($list);
		$output = array(
            "recordsTotal" => $this->wfmodel->count_allreq(),
            "recordsFiltered" => $this->wfmodel->count_allreq(),
            "data" => $list
        );
		}else{
			$output = array(
			"recordsTotal" => $this->wfmodel->count_allreq(),
            "recordsFiltered" => 0,
            "data" => 0
        );
		}
		echo json_encode($output);
	}
	
	public function resend(){
		$fdt = $this->input->post();
		$loginid = $fdt['loginid'];
		$reqid = $fdt['reqid'];
		$list = $this->wfmodel->resendmail($loginid, $reqid);
		
		echo json_encode($list);
	}
	
} 