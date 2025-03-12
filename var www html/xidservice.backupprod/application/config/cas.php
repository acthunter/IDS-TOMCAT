<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
//$config['cas_server_url'] = 'https://psso1.bni.co.id/cas/';
$config['cas_server_url'] = 'https://psso1.bni.co.id/cas/';
$config['phpcas_path'] = '/var/www/html/CAST/';
$config['cas_disable_server_validation'] = TRUE;

$config['cas_debug'] = TRUE; // <--  use this to enable phpCAS debug mode
$config['cas_server_ca_cert'] = '/etc/ssl/certs/slapd-ca-cert.pem';
?>