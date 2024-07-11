<?php 
	
	class Mcalendario extends CI_Model
	{
		

		function __construct()
		{
			parent::__construct();

		}

		public function getMarcacion(){
			

			$this->db->select('idMarcacion id,Marcacion title, fechaMarcacion start');
			$this->db->order_by('Marcacion',);	$this->db->from('marcacion');

			$s=$this->db->get();

			return $s->result();
		


		}

	}