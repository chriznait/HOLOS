<?php 

/**
 * 
 */
class Cie10 extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mcie10');


	}

	public function index(){
		$this->load->view('layout/header_librares');
		$this->load->view('cie10/list');
		$this->load->view('layout/footer_librares');

	}

	public function getCatalogo(){
			

			$textoBuscado = $this->input->post('txtdirectorio');

			echo json_encode($this->mcie10->getCatalogo($textoBuscado));
	}

	


}
 ?>