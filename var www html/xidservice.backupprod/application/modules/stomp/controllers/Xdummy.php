<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xdummy extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
	}

	public function index()
	{	
		
	$note=<<<XML
	<note>
	<to>Tove</to>
	<from>Jani</from>
	<heading>Reminder</heading>
	<body>Don't forget me this weekend!</body>
	</note>
XML;

	$xml=simplexml_load_string($note);
	log_message('debug', print_r(array("xdmy.index.xml"=>$xml), TRUE));
	
		
} 
