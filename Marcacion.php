<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marcacion extends CI_Controller {
	function __construct() {
        parent::__construct();
        //if(!$this->session->userdata('authorized') || $this->session->userdata('tipo') == 3){
        if(!$this->session->userdata('authorized')){
            redirect(base_url()."login");
        }
        if($this->session->userdata('tipo') == 3)
        	redirect(base_url()."solicitudes/listado");
		$this->controller = $this->router->fetch_class();
		$this->load->model("Model_general");
		$this->user_id = $this->session->userdata('authorized');
		$this->tipo_nombre = $this->Model_general->getTipoNombre($this->session->userdata('tipo'));
		$this->image_profile = $this->general->getImageProfile();
		$this->load->model('Model_menu');
		$this->menu = $this->Model_menu->generarMenu();
    }
	function index() {
		redirect(base_url()."direcciones");
	}
	
	public function getRoles(){
		$personal = $this->db->where("pers_id", $this->user_id)->get("personal")->row();

		$ups = $personal->pers_ups;

		$this->db->select("DATE_FORMAT(fechaSubida, '%d/%m/%Y %h:%i %p') fecha,
							CONCAT(pers_paterno,' ',pers_materno,', ',pers_nombres) personal,
							estado, comentario, archivo, idRol");
		$this->db->from("rol", $ups);
		$this->db->join("personal", "pers_id = idJefeUps", "LEFT");
		$this->db->where("idUps", $ups);
		$this->db->order_by("idRol", "DESC");
		$roles = $this->db->get()->result();

		$html = "";

		if(COUNT($roles) > 0){
			foreach ($roles as $item) {
				$class = "";
				$txt = "";
                switch ($item->estado) {
                	case 0: $class = "label-warning";	$txt = "PENDIENTE";	break;
                    case 1: $class = "label-success"; 	$txt = "APROBADO";  break;
                    case 2: $class = "label-danger"; 	$txt = "RECHAZADO"; break;
                    case 3: $class = "bg-purple"; 		$txt = "ANULADO"; break;
                }
                
                $archivo = "<span class='label ".$class."'>".$txt."</span>";
                if($item->estado == 0)
                	$boton = "<a class='btn btn-danger btn-xs delete' href='".base_url()."rol/delete/".$item->idRol."'><i class='fa fa-trash'></i></a>";
                else
                	$boton = "";

				$html .= "<tr>";
				$html .= "<td>".$boton."</td>";
				$html .= "<td>".$item->fecha."</td>";
				$html .= "<td>".$item->personal."</td>";
				$html .= "<td><a href='".base_url()."rol/descargar_modelo/".$item->archivo."'><i class='fa fa-download'></i> Archivo</a></td>";
				$html .= "<td>".$archivo."</td>";
				$html .= "<td>".$item->comentario."</td>";
				$html .= "</tr>";
			}
		}else{
			$html .= "<tr>";
			$html .= "<td colspan='6' align='center'>No se encontraron datos</td>";
			$html .= "</tr>";
		}
		echo json_encode(array("html" => $html));
	}
	public function gestion(){
		if(!$this->verificaPermiso("ver"))
			redirect(base_url("rol"));
		$this->load->helper('Functions');
        $this->load->library('Ssp');
        $this->load->library('Cssjs');
        $json = isset($_GET['json']) ? $_GET['json'] : false;

        $nombre = "CONCAT(pers_paterno,' ', pers_materno,', ',pers_nombres)";
        $subida = "DATE_FORMAT(fechaSubida, '%d/%m/%Y %h:%i %p')";

        $tipo = "UPPER(tipo_denominacion)";
        $ups = "(SELECT ups_nombre FROM ups WHERE ups_id = pers_ups)";
        $columns = array(
            array('db' => 'idRol',		'dt' => 'ID',			"field" => "idRol"),
            array('db' => $subida,		'dt' => 'FECHA',  		"field" => $subida),
            array('db' => 'ups_nombre', 'dt' => 'UPS', 			"field" => "ups_nombre"),
            array('db' => $nombre,      'dt' => 'RESPONSABLE',  "field" => $nombre),
            array(
                    'db' => 'estado',    
                    'dt' => 'ESTADO',       
                    "field" => 'estado',
                    "formatter" => function($data, $row){
                        $class = "";
                        $txt = "";
                        switch ($data) {
                            case 0: $class = "btn-vk";		$txt = "PENDIENTE";		break;
                            case 1: $class = "bg-green";  	$txt = "APROBADO"; 		break;
                            case 2: $class = "bg-red";      $txt = "RECHAZADO"; 	break;
                            case 3: $class = "bg-gray";     $txt = "ANULADO"; 		break;
                            default: $class = ""; 			$txt = "";				break;
                        }
                        return "<span class='label ".$class."'>".$txt."</span>";
                    }
                ),
            array('db' => 'idRol',		'dt' => 'DT_RowId', 	"field" => "idRol"),
            array('db' => 'estado',		'dt' => 'DT_RowEstado', "field" => "estado"),
            array('db' => 'bloqrol',	'dt' => 'DT_RowBloqueo',"field" => "bloqrol")
        );

        if ($json) {

            $json = isset($_GET['json']) ? $_GET['json'] : false;

            $table = 'rol';
            $primaryKey = 'idRol';

            $sql_details = array(
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            );

            $condiciones = array();
            $joinQuery = "FROM rol
                            LEFT JOIN personal ON pers_id = idJefeUps
                            LEFT JOIN ups ON ups_id = idUps";
            $where = "";

            if (!empty($_POST['anio']))
                $condiciones[] = "date_format(fechaSubida, '%Y') = '".$_POST['anio']."'";
            if (!empty($_POST['mes']))
                $condiciones[] = "date_format(fechaSubida, '%c') = '".$_POST['mes']."'";
            if (!empty($_POST['ups']))
                $condiciones[] = "idUps = '".$_POST['ups']."'";
                        
            $where = count($condiciones) > 0 ? implode(' AND ', $condiciones) : "";
            echo json_encode(
                    $this->ssp->simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where)
            );
            exit(0);
        }
        
        $datos['columns'] = $columns;
        $datos['titulo'] = "Roles";
        $datos["upss"] = $this->Model_general->getOptions('ups', array("ups_id", "ups_nombre"),'* Todas las UPS');
        $datos['dates'] = $this->getMesAnio();

		$this->cssjs->add_js(base_url() . "assets/js/rol/gestion.js",false,false);
		$this->load->view('header');
		$this->load->view($this->router->fetch_class()."/gestion", $datos);
		$this->load->view('footer');
	}
	public function detalle($rol){

		$this->db->select("estado, ups_nombre ups, anio, mes, idRol id");
		$this->db->where("idRol", $rol);
		$this->db->join("ups", "ups_id = idUps");
		$this->db->from("rol");
		$inf = $this->db->get()->row();

		$tabla = $this->getTableRol($inf->anio, $inf->mes, $rol, "");

		$mes = $this->getMesAnio()['meses'][$inf->mes];

		$data["titulo"] = "Detalle de rol";
		$data["tabla"] = $tabla["table"];
		$data["rol"] = $inf;
		$data["mes"] = $mes;
		$estado = "";
		switch ($inf->estado) {
			case 0: $estado = "Pendiente"; break;
			case 1: $estado = "Aprobado"; break;
			case 2: $estado = "Rechazado"; break;
		}
		$data["detestado"] = $estado;

		$this->load->library('Cssjs');
		$this->cssjs->add_js(base_url() . "assets/js/rol/detalle.js",false,false);
	    $this->load->view('header');
		$this->load->view($this->router->fetch_class().'/detalle', $data);
		$this->load->view('footer');		
	}
	public function getTableRol($anio, $mes, $rol, $personal){
		$dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
		
		$this->db->where("idRol", $rol);
		if($personal != "")
			$this->db->where("idPersonal", $personal);
		$detalles = $this->db->get("rol_detalle")->result();

		$table = "";
		$table .= "<thead>";
          	$table .= "<tr>";
	            $table .= "<th rowspan='2'>DNI</th>";
	            $table .= "<th rowspan='2'>NOMBRES</th>";
	            $table .= "<th rowspan='2'>CARGO</th>";
	            for ($i = 1; $i <= $dias_mes; $i++) {
	            	$table .= "<th>".$i."</th>";
	            }
          	$table .= "</tr>";
          	$table .= "<tr>";
	            for ($i = 1; $i <= $dias_mes; $i++) {
	            	$table .= "<th>".substr($this->saber_dia($anio,$mes,$i), 0,1) ."</th>";
	            }
          	$table .= "</tr>";
        $table .= "</thead>";
        $table .= "<tbody>";
		foreach ($detalles as $number => $item) {
			$table .= "<tr>";
			$table .= "<td class='nwp'>".$item->dni."</td>";
			$table .= "<td class='nwp'>".$item->nombres."</td>";
			$table .= "<td class='nwp'>".$item->cargo."</td>";
			for ($i = 1; $i <= $dias_mes; $i++) { 
				$this->db->where("idRolDetalle", $item->idDetalle);
				$this->db->where("dia", $i);
				$dia_existe = $this->db->get("rol_dias");

				if($dia_existe->num_rows() > 0){
					$valor = $dia_existe->row()->idTurno;
					if($valor == 'V')
						$classc = "bg-gray text-center";
					else
						$classc = "bg-red text-center";
				}else{
					$valor = "";
					$classc = "";
				}

				$table .= "<td class='".$classc."'>".$valor."</td>";
			}
			$table .= "</tr>";
		}
		$table .= "</tbody>";
		$data["table"] = $table;

		return $data;
	}
	public function saber_dia($anio, $mes, $dia) {
		if($dia < 10)
			$dia = "0".$dia;
		if($mes < 10)
			$mes = "0".$mes;

		$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
		$sel_dia = date('N', strtotime($anio."-".$mes."-".$dia));
		$fecha = $dias[($sel_dia-1)];
		return $fecha;
	}
	public function actualizaEstado($estado = ""){
       	$data["estado"] = $estado;
		$this->load->view($this->router->fetch_class()."/comentario",$data);
	}
	public function saveEstado(){
		if(!$this->verificaPermiso("editar")){
			$resp["exito"] = false;
            $resp["mensaje"] = "No tiene los permisos requeridos para realizar la acción";
            $this->general->dieMsg($resp);
		}
		$this->db->select("pers_esjefe jefe, pers_essuperjefe superjefe, pers_ups ups");
		$this->db->where("pers_id", $this->user_id);
		$this->db->from("personal");
		$permisos = $this->db->get()->row();

		$estado = $this->input->post("estado");
		$rol = $this->input->post("rol");
		$comentario = $this->input->post("comentario");

		$actual = $this->db->where("idRol", $rol)->get("rol")->row();

		//if($permisos->superjefe == 1){
			if($actual->estado == $estado){
				$resp["exito"] = false;
				$resp["mensaje"] = "...";
			}else{
				$table = "rol";
				$data = array("estado" => $estado, 
								"comentario" => $comentario, 
								"revision" => $this->user_id
							);

				$condition = array("idRol" => $rol);

				$this->db->trans_start();

				$this->Model_general->update_data($table,$data,$condition);
				$this->Model_general->update_data("ups",["ups_bloqueorol" => 1],["ups_id" => $permisos->ups]);

				$this->db->trans_complete();
				
				if($this->db->trans_status() === false){
					$resp["exito"] = false;
					$resp["mensaje"] = "Error, intentelo más tarde";
				}else{
					$resp["exito"] = true;
					$resp["mensaje"] = "Actualizado con exito";
				}
			}
			/*
		}else{
			$resp["exito"] = false;
			$resp["mensaje"] = "No tiene los permisos necesarios";
		}
		*/
		echo json_encode($resp);
	}
	public function habilita($rol){
		if(!$this->verificaPermiso("editar")){
			$resp["exito"] = false;
            $resp["mensaje"] = "No tiene los permisos requeridos para realizar la acción";
            $this->general->dieMsg($resp);
		}
		$tabla = "rol";
		$data = array("bloqrol" => 0, "idHabilitador" => $this->user_id, "estado" => 3);
		$condicion = array("idRol" => $rol);

		$this->db->trans_start();		
		$this->Model_general->update_data($tabla, $data, $condicion);
		$this->db->trans_complete();
				
		if($this->db->trans_status() === false){
			$resp["exito"] = false;
			$resp["mensaje"] = "Error, intentelo más tarde";
		}else{
			$resp["exito"] = true;
			$resp["mensaje"] = "Habilitado con exito, ya puede subir un nuevo ROL";
		}
		echo json_encode($resp);
	}
	public function delete($id=''){
		if(!$this->verificaPermiso("editar")){
			$resp["exito"] = false;
            $resp["mensaje"] = "No tiene los permisos requeridos para realizar la acción";
            $this->general->dieMsg($resp);
		}
		$table = "rol";
		$condition = array("idRol" => $id);

		$rol = $this->db->where("idRol", $id)->get("rol")->row();

		if($rol->estado == 0){

			$this->db->trans_start();
			$this->Model_general->delete_data($table,$condition);

			$linkfile = realpath(APPPATH.'../public/files/roles/'.$rol->archivo);
	        $this->eliminaArchivo($linkfile);

			$this->db->trans_complete();

			if($this->db->trans_status() === false){
				$resp["exito"] = false;
				$resp["mensaje"] = "Error, intentelo más tarde";
			}else{
				$resp["exito"] = true;
				$resp["mensaje"] = "ROL eliminado exitosamente";
			}
		}else{
			$resp["exito"] = false;
			$resp["mensaje"] = "Solo se puede eliminar un ROL que este pendiente";
		}

		echo json_encode($resp);
	}
}
