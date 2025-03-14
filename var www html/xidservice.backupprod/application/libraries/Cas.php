<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
function cas_show_config_error(){
	show_error("CAS authentication is not properly configured.<br /><br />
	Please, check your configuration for the following file:
	<code>config/cas.php</code>
	The minimum configuration requires:
	<ul>
	   <li><em>cas_server_url</em>: the <strong>URL</strong> of your CAS server</li>
	   <li><em>phpcas_path</em>: path to a installation of
	       <a href=\"https://wiki.jasig.org/display/CASC/phpCAS\">phpCAS library</a></li>
	    <li>and one of <em>cas_disable_server_validation</em> and <em>cas_ca_cert_file</em>.</li>
	</ul>
	");
}
class Cas {
	public function __construct(){
		if (!function_exists('curl_init')){
			show_error('<strong>ERROR:</strong> You need to install the PHP module
				<strong><a href="http://php.net/curl">curl</a></strong> to be able
				to use CAS authentication.');
		}
		$CI =& get_instance();
		$this->CI = $CI;
		$CI->config->load('cas');
		$this->phpcas_path = $CI->config->item('phpcas_path');
		$this->cas_server_url = $CI->config->item('cas_server_url');
		if (empty($this->phpcas_path) 
			or filter_var($this->cas_server_url, FILTER_VALIDATE_URL) === FALSE) {
			cas_show_config_error();
		}
		$cas_lib_file = $this->phpcas_path . '/CAS.php';
		if (!file_exists($cas_lib_file)){
			show_error("<strong>ERROR:</strong> Could not find a file <em>CAS.php</em> in directory
				<strong>$this->phpcas_path</strong><br /><br />
				Please, check your config file <strong>config/cas.php</strong> and make sure the
				configuration <em>phpcas_path</em> is a valid phpCAS installation.");
		}
		require_once $cas_lib_file;
		if ($CI->config->item('cas_debug')) {
			phpCAS::setDebug();
		}
		// init CAS client
		$defaults = array('path' => '', 'port' => 443);
		$cas_url = array_merge($defaults, parse_url($this->cas_server_url));
		phpCAS::client(CAS_VERSION_2_0, $cas_url['host'],
			$cas_url['port'], $cas_url['path']);
		// configures SSL behavior
		if ($CI->config->item('cas_disable_server_validation')){
			phpCAS::setNoCasServerValidation();
		} else {
			$ca_cert_file = $CI->config->item('cas_server_ca_cert');
			if (empty($ca_cert_file)) {
				cas_show_config_error();
			}
			phpCAS::setCasServerCACert($ca_cert_file);
		}
	}
	/**
	  * Trigger CAS authentication if user is not yet authenticated.
	  */
    public function force_auth()
    {
    	phpCAS::forceAuthentication();
    }
    /**
     *  Return 
     */
    public function user()
    {
    	if (phpCAS::isAuthenticated()) {
	    	$userlogin = phpCAS::getUser();
	    	$attributes = phpCAS::getAttributes();
	    	return (object) array('userlogin' => $userlogin,
	    		'attributes' => $attributes);
    	} else {
    		show_error("User was not authenticated yet.");
    	}
    }
    /**
     *  Logout and redirect to the main site URL,
     *  or to the URL passed as argument
     */
    public function logout($url = '')
    {
    	if (empty($url)) {
    		$this->CI->load->helper('url');
    		$url = base_url();
		}
    	phpCAS::logoutWithRedirectService($url);
    }
    public function is_authenticated()
    {
    	return phpCAS::isAuthenticated();
    }
	
	function cassession($userAttr)
	{
		if (!isset($_SESSION['pengguna'])){
			$pengguna = (object) array();
			$pengguna->nama=$userAttr['username'];
			$pengguna->loginid=$userAttr['loginid'];
			$pengguna->accoffice=$userAttr['accoffice'];
			$idmrole = $userAttr['idm'];
			$pengguna->killbanc=$userAttr['killbanc'];
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
				if ($pengguna->idm_init > 0 or $pengguna->idm_appr > 0 )
					redirect ("home");
				else if ($pengguna->idm_idadmin == 3 )
					redirect ("endsession");
				else if ($pengguna->idm_idadmin == 4 )
					redirect ("itservice");
				else if ($pengguna->idm_ithde > 0 )
					redirect ("endsession");
				else if ($pengguna->idm_super > 0 )
					redirect ("sysadmin");
				else if ($pengguna->killbanc > 0 )
					redirect ("killuser");
				else 
					redirect ("https://psso1.bni.co.id/xidservice/info");
					//redirect ("home");
			} else {
				redirect($urlorg);
			}
		}
		return true;
	}

	function casattr(){
		$test = $_SESSION['pengguna']->accoffice;
	}
	
	function getmycas_login($xroles){
		phpCAS::forceAuthentication();
		if (!isset($_SESSION['pengguna'])){	
			 $this->cassession(phpCAS::getAttributes());
		}
		$myid = $_SESSION['pengguna']->loginid;
		
		log_message('debug', print_r(array("xids.index.pengguna"=>$_SESSION['pengguna']), TRUE));
		//log_message('debug', print_r(array("xids.index.roles"=>$xroles), TRUE));
		$mydata = $_SESSION['pengguna'];
		
		foreach($xroles as $crole){
			if ($mydata->$crole > 0 ){
				$eligable = true;
				break;
			}
		}
		
		if (!$eligable)
			redirect("invalid");
		
		return $myid;
	}
}
?>