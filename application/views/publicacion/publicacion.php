<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="viewport" content="width-device-width,initial-scale=1.0">
	<meta name="viewport" content="width=device-width, maximum-scale=1, user-scalable=no"/>
	<link rel="stylesheet" media="only screen and (max-width: 768px)" href="estilos.css">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Holos csai</title>
	<link rel="icon" type="image/png" href="<?= base_url();?>assets/dist/img/HOLOS.png"/>

	<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/style.css">
	
</head>

<body onload="javascript:showModal();" style="background-image: url('<?= base_url();?>assets/dist/img/logo.png'); ">
	<header>
		<h3>PLATAFORMA VIRTUAL HOLOS</h3>
	</header>

	<div class="container">

		<div class="box">
			<div class="icon">01</div>
			<div class="content">
				<h3>Solicitar Papeleta de salida</h3>
				<p>Se podrá solicitar papeleta de salida,
					para poder salir e ingresar del Centro de Salud
				</p>
				<a href="http://localhost/hospital2/public/permiso/">Ingresar</a>
			</div>
		</div>
		<div class="box">
			<div class="icon">02</div>
			<div class="content">
				<h3>Acceso a Sistemas</h3>
				<p>Sistema de permisos, sistema de Ticket(OTM,Actividades)
				</p>
				<a href="http://localhost/hospital2/public/login">Ingresar</a>
			</div>
		</div>
		<div class="box">
			<div class="icon">03</div>
			<div class="content">
				<h3>DIRECTORIO TELÉFONO IP - hsmpm</h3>
				<p>Aquí podremos buscar el número de anexo de los teléfonos Ip
				</p>
				<a href="http://localhost//directorio">Ingresar</a>
			</div>
		</div>
		<div class="box">
			<div class="icon">04</div>
			<div class="content">
				<h3>CIE 10</h3>
				<p>Aquí podremos realizar busqueda de los diagnosticos CIE10
				</p>
				<a href="http://localhost/holos/cie10">Ingresar</a>
			</div>
		</div>

		<div class="box">
			<div class="icon">05</div>
			<div class="content">
				<h3>Visor de Imagenes Rx</h3>
				<p>Permite visualizar imagenes de Rx de los pacientes 
				</p>
				<a href="/">Ingresar</a>
			</div>
		</div>
		<div class="box">
			<div class="icon">06</div>
			<div class="content">
				<h3>Calculo de ingreso de oxigeno</h3>
				<p></p>
				<a href="http://localhost/hsmpm/calOxigeno">Ver Listado</a>
			</div>
		</div>
		<div class="box">
			<div class="icon">07</div>
			<div class="content">
				<h3>Clasificador SIGA</h3>
				<p>	
				</p>
				<a href="https://sistemasyestrategias.com/catalogo/public/">Ingresar</a>
			</div>
		</div>
		<div class="box">
			<div class="icon">08</div>
			<div class="content">
				<h3>SIVENA 100 (Gestante y Niño)</h3>
				<p>	
				</p>
				<a href="">Ingresar</a>
			</div>
		</div>

		<div class="box">
			<div class="icon">10</div>
			<div class="content">
				<h3>Acceso al Sistema de Trámite Documentario</h3>
				<a href="https://sgd.regionarequipa.gob.pe/">Ingresar</a>
			</div>
		</div>

		<div class="box">
			<div class="icon">08</div>
			<div class="content">
				<h3>Actividades de Ing. Hospitalaria</h3>
				<p>	
				</p>
				<a href="https://localhost/hsmpm/assets/galeria">Ingresar</a>
			</div>
		</div>
		</div>

	
<!--modal-->
	    <!-- <div id="openModal" class="modalDialog">
			<div>
				<center>
					<a href="#close" title="Cerrar" class="close" onclick="javascript:CloseModal();">x</a>
					<h2>CRONOGRAMA DE TRAMITE DE FOTOCHECK 2DO BLOQUE</h2>
					<img class="banner" src="<?= base_url();?>assets/dist/img/cronograma.png"> -->

					<!-- <p class="ren">Test de Cursos para proponer en fortalecimiento de capacidades en el hsmpm</p>
					<a style="color: #fff;background-color: #587ea3;border-color: rgba(0,0,0,0.2);" href="https://docs.google.com/forms/d/e/1FAIpQLSfFjd0wsny6uAHFK0Qvv3NpSL3LLiS9uqjvVYfXE-jFZICJbA/viewform" target="_blank">Ingresar</a>
					<button id="closeModal" onclick="closeModal()" style="color: #000;background-color: #d2d6de !important;">Cerrar</button> -->
	<!-- 			</center>
			</div>
		</div> -->
         <!--      <div id="openModal" class="modalDialog">
			      <div>
				  	<center>
						<a href="#close" title="Cerrar" class="close" onclick="javascript:CloseModal();">x</a>
						<h2>Participa con tus respuestas en propuestas en CURSOS DE CAPACITACIÓN</h2>
							

						<p class="ren">Test de Cursos para proponer en fortalecimiento de capacidades en el hsmpm</p>
					</center>
			        
			        <img class="banner" src="<?= base_url();?>assets/dist/img/logo.png">
			      </div>
			    </div>
			-->
	</div>
	

	<footer>
		<h3>create by GSI - hsmpm </h3>
	</footer>


	<script type="text/javascript" >

		function closeModal(){
			document.getElementById('openModal').style.display = 'none';
		}

		function showModal() {
		  	document.getElementById('openModal').style.display = 'block';
		}

		function CloseModal() {
			document.getElementById('openModal').style.display = 'none';
		}
	</script>


</body>
</html>