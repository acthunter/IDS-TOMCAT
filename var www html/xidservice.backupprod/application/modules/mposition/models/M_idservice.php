<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_idservice extends CI_Model {
	
	var $table2 = 'xapproval';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function getCode2($where)//dipake
	{
		$hasil = $this->db->query("SELECT id FROM xapproval WHERE reqtype = 'P'");
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		}		
	}
	
	function getCode()//dipake
	{
		$this->db->select_max('id');
		$hasil = $this->db->get('xapproval');
			
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		}		
	}
	
	public function getid()
	{			  
		$this->db->select_min('reqid');
		$hasil = $this->db->get('revdraft');
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		}		
	}
		public function count_prop()
	{
		$this->db->from($this->table2);
		$this->db->where("status = 'P'");
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function count_appr()
	{
		$this->db->from($this->table2);
		$this->db->where("status = 'A'");
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function count_reject()
	{
		$this->db->from($this->table2);
		$this->db->where("status = 'R'");
		$query = $this->db->get();
		
		return $query->num_rows();
	}
}