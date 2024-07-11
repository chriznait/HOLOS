<?php 
/**
 * 
 */
class Mdirectorio extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

	}

	public function getDirectorio($textoBuscado){
		$this->db->select('anexo,area,ambiente,sector,senalitica');
		$this->db->from('directorio');
		
		$this->db->like('anexo',$textoBuscado,'both');
		$this->db->or_like('area',$textoBuscado,'both');
		$this->db->or_like('ambiente',$textoBuscado,'both');
			
		$r=$this->db->get();
		return $r->result();
	}
}

 ?>