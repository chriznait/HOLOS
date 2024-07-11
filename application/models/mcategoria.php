<?php 
	
	class Mcategoria extends CI_Model
	{
		

		function __construct()
		{
			parent::__construct();

		}

		public function getCat($s){
			$s = $this->db->get_where('Categorias', array('estado'=>$s));
			return $s->result();
		


		}

	}