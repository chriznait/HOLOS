<?php 
	
	class Categoria extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->model('mcategoria');

		}

		public function getCat(){
			$s = $this->input->post('estado');
			$rs=$this->mcategoria->getCat($s);

			echo json_encode($rs);
		}
	}