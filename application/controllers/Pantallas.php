<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pantallas extends CI_Controller {
    function __construct() {
        parent::__construct();
               
        $this->controller = $this->router->fetch_class();
        $this->sisgalen = $this->load->database("sisgalen",TRUE);
    }

    public function index(){        
        $this->load->view($this->controller."/pantalla");
    }

    public function getCitas(){
        $query = "SELECT top 15 c.idEstadoCita,ac.idAtencion,s.Nombre ,p.ApellidoPaterno as ppaterno, p.ApellidoMaterno as pmaterno, p.PrimerNombre as pnombre1, p.SegundoNombre as pnombre2, p.TercerNombre as pnombre3, e.ApellidoPaterno as mpaterno, e.ApellidoMaterno as mmaterno, e.Nombres as mnombres from Citas c 
        inner join Pacientes p on p.IdPaciente =c.IdPaciente
        inner join Servicios s on s.IdServicio =c.IdServicio
        inner join Medicos m on m.IdMedico =c.IdMedico 
        inner join Empleados e on e.IdEmpleado = m.IdEmpleado
        inner join Atenciones a on a.IdAtencion =c.IdAtencion 
        left join SIGH_EXTERNA.dbo.atencionesCE ac on ac.idAtencion = a.IdAtencion 
        where CAST (c.FechaSolicitud as date) ='".date('Y-m-d')."'
        and c.IdEspecialidad not in (73,155,133,145,78,205)
        and IdEstadoCita != 2
        order by HoraSolicitud asc";
        $data["citas"] = $this->sisgalen->query($query)->result();

        echo json_encode($data);

        exit();
    }
}
?>