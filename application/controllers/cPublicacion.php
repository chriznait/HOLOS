<?php 

/**
 * 
 */
class Cpublicacion extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mpublicacion');
		$this->load->model('mlogin');

	}

	public function index(){
		
		$this->load->view('publicacion/publicacion');

	}
	public function guardar(){
		$param['idCategoria'] = $this->input->post('txtCategoria');
		$param['titulo'] = $this->input->post('txtTitulo');
		$param['resumen'] = $this->input->post('txtResumen');
		$param['contenido'] = $this->input->post('txtContenido');
		$param['imagen'] = $this->input->post('txtImagen');
		$this->mpublicacion->guardar($param);


	}
	public function panelcito(){
		$this->load->view('layout/header');
		$this->load->view('layout/menu');
		$this->load->view('publicacion/panel');
		$this->load->view('layout/footer');
		// if (!$this->session->userdarta('s_idusuario')) {
		// 	redirect('publicacion/publicacion');
		// }
	}
	public function form(){
		$this->load->view('layout/header');
		$this->load->view('layout/menu');
		$this->load->view('publicacion/form');
		$this->load->view('layout/footer');
	}

	public function getPubliPanel(){
			$textoBuscado = $this->input->post('texto');
			$estado= $this->input->post('estado');


			echo json_encode($this->mpublicacion->getPubliPanel($estado,$textoBuscado));
	}
	public function getPubliPanelList(){
			

			echo json_encode($this->mpublicacion->getPubliPanelList());
	}

}
 ?>