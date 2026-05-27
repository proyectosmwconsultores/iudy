<?php
include("php/estructura/session.php");
include("php/estructura/validationlogin.php");
require('php/clases/class.php');
require('php/clases/espacio.php');
require('php/clases/contenido.php');
require('php/clases/class_aula.php');
//require('php/clases/espcio.php');
$t = new Trabajo();
$espacio = new Espacio();
$contenido = new Contenido();
$aula = new Aula();
$configuracion = $t->get_configuracion();
$_config = $espacio->get_configuracion_campus($_SESSION['IdCampus']);
$infoPerfil = $espacio->get_infoPerfil($_SESSION['IdUsua']);
$mailActivo = $espacio->get_mailActivo($_SESSION['IdUsua'], $_SESSION['Permisos']);
$msjs = $espacio->get_msj($_SESSION['IdUsua']);
$lstmsjs = $espacio->get_lstmsj($_SESSION['IdUsua']);
$title = (isset($section)) ? $section : "Inicio";
$diaIngreso = $espacio->get_ingresoDia();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $title . ' | ' . $_config[0]["Campus"]; ?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="icon" href="assets/images/campus/<?php echo $_config[0]["Icono"]; ?>" type="image/x-icon">
	<meta name="description" content="IUDY es una plataforma de gestión para la Universidad, cuenta con módulos para el proceso de admisiones, finanzas, servicios escolares, académicos y seguimiento al desempeño, así cómo aula virtual para el docente y alumno." />
	<meta name="keywords" content="MWComenius" />
	<meta name="author" content="MWConsultores">

	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<script language="javascript" type="text/javascript" src="php/js/funciones.js"></script>
	<script language="javascript" type="text/javascript" src="php/js/modulo.js"></script>

	<!-- <script language="javascript" type="text/javascript" src="php/js/sweetalert2.min.js"></script> -->

	<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	<!-- <script src="assets/alert/dist/sweetalert-dev.js"></script> -->
	<!-- <link rel="stylesheet" href="assets/alert/dist/sweetalert.css"> -->
	<script src="bower_components/push/push.min.js"></script>
	<script src="assets/js/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">

	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css" />
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />

	<?php if ((isset($ajax)) && ($ajax == 1)) { ?>
		<script language="javascript" type="text/javascript" src="php/js/alertas.js"></script>
		<!-- Sweet Alerts V8.13.0 CSS file -->
		<link rel="stylesheet" href="php/js/sweetalert2.min.css">

		<!-- Sweet Alert V8.13.0 JS file-->
		<script src="php/js/sweetalert2.min.js"></script>
	<?php } else { ?>
		<script src="assets/alert/dist/sweetalert-dev.js"></script>
		<link rel="stylesheet" href="assets/alert/dist/sweetalert.css">
	<?php } ?>

	<link rel="stylesheet" type="text/css" href="dist/css/mensaje_alerta.css?v=1.0.4" />
	<link rel="stylesheet" type="text/css" href="dist/css/aula_virtual.css?v=1.0.4">
	<style>
		body {
			background-color: #f4f6f9;
		}

		/* Contenedor general */
		.content-wrapper {
			background: #f4f6f9;
		}

		/* Card principal */
		.box,
		.card,
		.nav-tabs-custom {
			border-radius: 10px;
			border: 1px solid #e5e7eb;
			box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
			background: #ffffff;
		}

		/* Header superior del alumno */
		.widget-user-header,
		.headx-hero {
			background: linear-gradient(135deg, #7c366c, #5a264e);
			color: #ffffff;
			padding: 20px;
		}

		.widget-user-username {
			font-size: 18px;
			font-weight: 700;
		}

		.widget-user-desc {
			font-size: 13px;
			opacity: .9;
		}


		/* Secciones internas */
		.bg-navy-active {
			background: #0b2239 !important;
			color: #fff;
			border-radius: 8px;
			font-weight: 700;
			letter-spacing: .3px;
		}

		/* Labels */
		.form-group label {
			font-size: 12px;
			font-weight: 700;
			color: #374151;
			text-transform: uppercase;
			letter-spacing: .4px;
		}

		/* Inputs */
		.form-control {
			border-radius: 8px;
			border: 1px solid #cbd5e1;
			height: 32px;
			font-size: 14px;
			box-shadow: none;
		}

		.form-control:focus {
			border-color: #7c366c;
			box-shadow: 0 0 0 3px rgba(124, 54, 108, .15);
		}

		/* Input group icon */
		.input-group-addon {
			background: #f8fafc;
			border-color: #cbd5e1;
			color: #475569;
			border-radius: 8px 0 0 8px;
		}

		/* Select2 */
		.select2-container--default .select2-selection--single {
			/* border-radius: 8px; */
			height: 38px;
			border-color: #cbd5e1;
		}

		.select2-selection__rendered {
			line-height: 34px !important;
			font-size: 14px;
		}

		.select2-selection__arrow {
			height: 36px !important;
		}

		/* Footer del formulario */
		.box-footer {
			border-top: 1px solid #e5e7eb;
			padding-top: 15px;
		}

		/* Emergencia / bloques importantes */
		.section-important {
			border-left: 4px solid #7c366c;
			padding-left: 14px;
		}

		/* Validaciones */
		.is-invalid,
		.is-invalid+.select2-container .select2-selection {
			border-color: #dc3545 !important;
			box-shadow: 0 0 0 3px rgba(220, 53, 69, .15);
		}

		/* Responsive */
		@media (max-width: 768px) {
			.widget-user-header {
				text-align: center;
			}
		}
	</style>
</head>