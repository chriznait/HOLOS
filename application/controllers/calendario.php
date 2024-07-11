<?php 
	
	class Calendario extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			//$this->load->model('mcalendario');

		}
		public function index(){
			$this->load->view('calendario/list');
		}

		public function getMarcacion(){
			//$r=$this->db->get('marcacion');
			//$s = $this->input->post('estado');

			$this->db->select('idMarcacion id,Marcacion title, fechaMarcacion start, color color');
			$this->db->order_by('idMarcacion');
			$this->db->from('marcacion');

              $s=$this->db->get();
            $this->db->select('idRolHorario id,turno title, fechaTurno start, color color');
			$this->db->from('rol_horario');

                 $r=$this->db->get();

                // return $s->result();
                // $r=$this->mcalendario->getMarcacion();
                 $p=array_merge($s->result(),$r->result());

                echo json_encode($p);


		}
		public function getData(){
		$db2 = $this->load->database('sisgalen', TRUE);
		$this->db2->select('ApellidoPaterno ,ApellidoMaterno,PrimerNombre');
		$this->db2->from('Pacientes');
		// $db2->select('tabla,accion');
		// $db2->from('auditoria');
		        $ss=$db2->get();
                echo json_encode($ss->result());

		}


	}