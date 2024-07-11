<?php 
class Mlogin extends CI_Model
{

		
	public function logear($usu,$clave){
		$this->db->select('u.idUsuario,e.idEmpleado, e.nombre,e.apellidos');
		$this->db->from('usuarios u');
		$this->db->join('empleados e', 'u.idEmpleado=e.idEmpleado');
		$this->db->where('u.nomUsuario',$usu);
		$this->db->where('u.clave',$clave);

		$resultado=$this->db->get();

		if($resultado->num_rows()==1){
			$r=$resultado->row();
			$s_usuario=array(
				's_idempleado'=>$r->idEmpleado,
				's_idusuario'=>$r->idUsuario,
				's_nomusuario'=>$r->nombre.", ".$r->apellidos
			);
			$this->session->set_userdata($s_usuario);
			return 1;
		}else{
			return 0; 
		}
	}	
}

 ?>
