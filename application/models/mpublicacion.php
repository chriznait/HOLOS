<?php 
/**
 * 
 */
class Mpublicacion extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function guardar($param){
		$campos = array(
			'idCategoria' => $param['idCategoria'],
			'titulo' => $param['titulo'],
			'resumen' => $param['resumen'],
			'contenido' => $param['contenido'],
			'imagen' => $param['imagen'],
		);
		$this->db->insert('publicaciones',$campos);
	}
	public function getPubliPanel($estado,$textoBuscado){
		$this->db->select('p.titulo,p.resumen, p.fechaPublicacion,p.imagen,c.descripcion');
		$this->db->from('publicaciones p');
		$this->db->join('categorias c', 'p.idCategoria=c.idCategoria');
		$this->db->where('p.estado',$estado);
		
		$this->db->like('resumen',$textoBuscado,'both');
		$this->db->or_like('titulo',$textoBuscado,'both');
		$this->db->or_like('descripcion',$textoBuscado,'both');
			
		$r=$this->db->get();
		return $r->result();
	}
	public function getPubliPanelList(){
		$this->db->select('p.titulo,p.resumen, p.fechaPublicacion,p.imagen,c.descripcion');
		$this->db->from('publicaciones p');
		$this->db->join('categorias c', 'p.idCategoria=c.idCategoria');
		$this->db->where('p.estado',1);
		
			
		$r=$this->db->get();
		return $r->result();
	}
}

 ?>