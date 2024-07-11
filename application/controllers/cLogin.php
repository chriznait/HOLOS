<?php 
	/**
	 * 
	 */
	class Clogin extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->model('mlogin');
		}

		public function index(){
			$data['mensaje']='';
			$this->load->view('vlogin',$data);


		}
		public function logear(){
			$usu=$this->input->post('txtUsuario');
			$pas=$this->input->post('txtClave');
		
			$res=$this->mlogin->logear($usu,$pas);

			if($res==1){
				$this->load->view('layout/header');
				$this->load->view('layout/menu');
				$this->load->view('publicacion/panel');
				$this->load->view('layout/footer');
				
			}else{
				$data['mensaje']='no logro iniciar sesion';
				$this->load->view('vlogin',$data);
			}
		}
	}
?>