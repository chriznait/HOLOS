<?php 

/**
 * 
 */
class Directorio extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mdirectorio');


	}

	public function index(){
		$this->load->view('layout/header_librares');
		$this->load->view('directorio/list');
		$this->load->view('layout/footer_librares');

	}

	public function getDirectorio(){
			

			$textoBuscado = $this->input->post('txtdirectorio');

			echo json_encode($this->mdirectorio->getDirectorio($textoBuscado));
	}

	


}
 ?>