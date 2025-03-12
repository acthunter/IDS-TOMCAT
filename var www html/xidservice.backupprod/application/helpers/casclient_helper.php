

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	function cassession($userAttr)
	{
		if (!isset($_SESSION['pengguna'])){
			$pengguna = (object) array();
			$pengguna->nama=$userAttr->username;
			$pengguna->loginid=$userAttr['loginid'];
			$pengguna->accoffice=$userAttr['accoffice'];
			$idmrole = $userAttr['idm'];
			if (isset($idmrole)){
				$pengguna->idm_init = $idmrole % 10;
				$pengguna->idm_appr =  ($idmrole / 10) % 10;
				$pengguna->idm_super =  ($idmrole / 100) % 10;
			}
			
			$_SESSION['pengguna'] = $pengguna;
		}
		return true;
	}

	function casattr(){
		$test = $_SESSION['pengguna']->accoffice;
	}
	
	function getmycas_login($cas){
		$cas->force_auth();
		//echo json_encode($_SESSION);
		if (!isset($_SESSION['pengguna'])){
			 cassession($_SESSION, $cas->user()->attributes);
		}
		$myid = $_SESSION['pengguna']->loginid; 
		return $myid;
	}

