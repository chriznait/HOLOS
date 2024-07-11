<?php 
/**
 * 
 */
class Mcie10 extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}

	public function getCatalogo($textoBuscado){
		$this->db->select('codigo,descripcion');
		$this->db->from('cie10');
		
		$this->db->like('codigo',$textoBuscado,'both');
		$this->db->or_like('descripcion',$textoBuscado,'both');
			
		$r=$this->db->get();
		return $r->result();
	}
}

 ?>