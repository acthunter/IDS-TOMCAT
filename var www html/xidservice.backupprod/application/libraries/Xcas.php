<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xcas {
	
	public function __construct(){
		 $this->ci =& get_instance();
	}
	
    public function force_auth()
    {
    	return $this->ci->login();
    }
    public function user()
    {
    }
	
	public function logout($url = ''){
		unset($_SESSION['pengguna']);
	}
	 
	function cassession($userAttr)
	{
		if (!isset($_SESSION['pengguna'])){
			$pengguna = (object) array();
			$pengguna->nama=$userAttr['username'];
			$pengguna->loginid=$userAttr['loginid'];
			$pengguna->accoffice=$userAttr['accoffice'];
			$pengguna->enduser=$userAttr['oid'];
			$pengguna->icons=$userAttr['icons'];
			$idmrole = $userAttr['idm'];
			
			if (isset($idmrole)){
				$pengguna->idm_init = $idmrole % 10;
				$pengguna->idm_appr =  ($idmrole / 10) % 10;
				$pengguna->idm_super =  ($idmrole / 100) % 10;
				$pengguna->idm_ithde =  ($idmrole / 1000) % 10;
				$pengguna->idm_idadmin =  ($idmrole / 10000) % 10;
			}
			$_SESSION['pengguna'] = $pengguna;
		}
		return true;
	}

	function casattr(){
		$test = $_SESSION['pengguna']->accoffice;
	}
	
	public function login(){
		if(!isset($_SESSION['pengguna'])){
			$fdt = $this->ci->input->post();
			
			if (!isset($fdt['loginid'])){
				$this->ci->load->library('page');
				$this->ci->page->template('simple_tpl');
				$this->ci->page->view('templates/cloginform');
			} 
			else {
				
				if ($fdt['loginid'] == $fdt['passwd']){
					$userAttr = $this->ci->db->query("select vlp.idminit, vln.* from v_login_previlegde1 vlp inner join v_login_name vln on vln.loginid = vlp.loginid where vln.loginid=?", array($fdt['loginid']))->row();
					
					$pengguna = (object) array();
					$pengguna->nama=$userAttr->name;
					$pengguna->loginid=$fdt['loginid'];
					$pengguna->accoffice=$userAttr->accoffice;
					$pengguna->enduser=$userAttr->enduser;
					$pengguna->icons=$userAttr->icons;
					$idmrole = $userAttr->idminit;
					if (isset($idmrole)){
						$pengguna->idm_init = $idmrole % 10;
						$pengguna->idm_appr =  ($idmrole / 10) % 10;
						$pengguna->idm_super =  ($idmrole / 100) % 10;
						$pengguna->idm_ithde =  ($idmrole / 1000) % 10;
						$pengguna->idm_idadmin =  ($idmrole / 10000) % 10;
					}
					$_SESSION['pengguna'] = $pengguna;
					
					$urlorg = $_SESSION['cas_org_uri'];
					$psite_url = preg_quote(site_url(''),'/');
					$use_org = false;
					
					if (isset($urlorg)){
						$use_org = !preg_match("/$psite_url$/", $urlorg);
					}
					unset ($_SESSION['cas_org_uri']);
					if (!$use_org){
						if ($pengguna->idm_idadmin == 3 )
							redirect ("endsession");
						else if ($pengguna->idm_idadmin == 4 )
							redirect ("itservice");
						else if ($pengguna->idm_ithde > 0 )
							redirect ("itservice");
						else if ($pengguna->idm_super > 0 )
							redirect ("sysadmin");
						else 
							redirect ("home");
					} else {
						redirect($urlorg);
					}
				} else {
					redirect("login");
				}
			}
		}
	}
	
	function allow_login($rule){
		$myid = $this->getmycas_login();
		$apriv  = $_SESSION['pengguna']->$rule ;
		if ($apriv <=0 ){
			redirect("");
		}
		return $myid;
	}
	
	function getmycas_login($roles){ //roles = array of 
		if (!isset($_SESSION['pengguna'])){	
			//log_message('debug', print_r(array("xcas.login._server"=>$_SERVER), TRUE));
			$_SESSION['cas_org_uri'] = $_SERVER['REDIRECT_QUERY_STRING'];
			redirect('login');
		} 
		
		$mydata = $_SESSION['pengguna'];
		$eligable = false;
		//if ($roles )
		foreach($roles as $crole){
			if ($mydata->$crole > 0 ){
				$eligable = true;
				break;
			}
		}
		
		if (!$eligable)
			redirect("invalid");
		
		$myid = $mydata->loginid;
		log_message('debug', print_r(array('ua.getmycsalogin.wf'=>$_SESSION['pengguna']), TRUE));
		return $myid;
	}
}
?>