<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function invalid()
	{
		$this->load->view('invalid_messages');
	}
	
	public function faq()
	{
		$this->page->template('simple_tpl');
		$this->page->view('v_faq');
	}
	
	public function nfeature()
	{
		$this->page->template('simple_tpl');
		$this->page->view('v_nfeature');
	}
	
	public function redirect()
	{
		$this->load->view('redirect_login');
	}
	
	public function testmail()
	{
		$this->load->view('pwdMail2-online');
	}
	
	public function mailmanual()
	{
		$this->load->view('pwdMail2-manual');
	}
	
	public function back()
	{
		$pengguna = $_SESSION['pengguna'];
		if ($pengguna ->idm_init > 0 or $pengguna->idm_appr > 0){
				redirect('home');
			}else if ($pengguna ->idm_idadmin > 0){
				redirect('idadmin');
			}else if ($pengguna->idm_ithde > 0){
				redirect('enduser');
			} else {
				redirect('login');
			}
	}
	
	public function sys_mon(){
		$this->page->template('simple_tpl');
		//$this->page->header('templates/admin_header_tpl');
		//$data['main'] = 'welcome_message';
		$this->page->view('v_cashub_mon');
	}
	
	public function sys_login_list(){
		$this->load->library('restclient', array());
		$dest_url = $this->config->item('cas_url') . 'frontend/sysstatus';
		log_message('debug', print_r($dest_url, TRUE)); 
		$breply = file_get_contents('http://192.168.98.53:12004/frontend/sysstatus');
		echo $breply;
	}
	public function sumreq(){
		$myid = $this->session->userdata('pengguna')->loginid;
		$idpattern = "%${myid}%";
		$accoffice = $_SESSION['pengguna']->accoffice;
		//$this->_get_datatables_query();
				$this->db->select('*');
		$this->db->from('xwfparam');
		$this->db->like('currActor', $myid);
		$this->db->where('accoffice', $accoffice);
		if ($_SESSION['pengguna']->idm_init > 0 and $_SESSION['pengguna']->idm_appr > 0    ){
		$this->db->where('stage in (1,2)');
		}else if ($_SESSION['pengguna']->idm_appr > 0){
			$this->db->where('stage in (2)');
		}else{
			$this->db->where('stage in (1)');
		}
		//$this->db->query('select * from xwfparam where currActor like ? and accoffice = ? and stage in (1,2)', array($idpattern, $accoffice));
		$result = $this->db->count_all_results();
		echo json_encode($result);
	}
	
	
	
}
