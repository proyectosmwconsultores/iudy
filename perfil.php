<?php $valor = 3;
//$ajax = 1;
$section = "Alumnos";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el buscador de alumnos');
}
if (isset($_GET["token"])) {
	$id = substr($_GET["token"], 10, 10);
	$alumno = $t->get_datAlumno($id);
    $pendIns = $espacio->get_proceso_inscripcion_id($id);
    
	$_mod = $t->get_mod_lista($_SESSION['IdUsua'], 1);
	$cal = $t->get_cal_all_us($id);

	$grpz = $alumno[0]["TipoCiclo"];
	if ($grpz == "C") {
		$grp = "CUATRIMESTRE";
	} elseif ($grpz == "S") {
		$grp = "SEMESTRE";
	} else {
		$grp = "TRIMESTRE";
	}
} else {
	$id = "";
}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Perfil de alumno</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumno</a></li>
					<li class="active">Perfil</li>
				</ol>
			</section>

			<section class="content" style="font-size: 13px;">
				<form name="frm" id="frm" action="perfil.php" method="POST" enctype="multipart/form-data">
					<input id="idToks" name="idToks" value="<?php if (isset($alumno[0])) { echo $alumno[0]['IdUsua']; } ?>" type="hidden" />
					<input id="token" name="token" value="<?php if (isset($_GET['token'])) { echo $_GET['token']; } ?>" type="hidden" />
					<input id="_grp" name="_grp" value="<?php if (isset($grp)) { echo $grp; } ?>" type="hidden" />
					<div class="row" id='_no_disponible' style="display: block;">
						<div class="col-md-12">
							<div class="box box-primary">
								<p style="text-align: center;">
									<button href="javascript:void(0);" class="btn btn-info btn-block view_buscar" type="button" class="btn btn-block btn-info btn-lg"><i class="fa fa-fw fa-search"></i>Buscar alumno</button>
									<img src="assets/images/campus/buscando.gif" style="width: 30%;">
								</p>
							</div>
						</div>
					</div>

					<div class="row" id='_disponible'>
						<div class="col-md-3">
							<div class="box box-primary">
								<p style="text-align: center; display: none;" id="img_cargar_0">
									<img src="assets/images/cargando.gif">
								</p>
								<div id="permisos_alumno_id"> </div>
							</div>
						</div>
						<div class="col-md-9">
						

							<div class="nav-tabs-custom">
							
								<ul class="nav nav-tabs">
									<li class="active"><a style="cursor: pointer;" onclick="cargar_informacion_alumno()" href="#activity" data-toggle="tab"><i class="fa fa-fw fa-info-circle"></i> Informaci&oacute;n</a></li>
									<?php if ((isset($_GET['token'])) && ($alumno[0]['IdEstatus'] <> 60)) { ?>
										<li><a style="cursor: pointer;" onclick="cargar_kardex_alumno()" href="#timeline" data-toggle="tab"><i class="fa fa-fw fa-mortar-board"></i> Kardex</a></li>
										<li><a style="cursor: pointer;" onclick="cargar_materias_asignadas()" href="#_materias" data-toggle="tab"><i class="fa fa-fw fa-flag"></i> Materias</a></li>
										<li><a style="cursor: pointer;" onclick="cargar_materias_pendientes(<?php echo $alumno[0]['IdEducativa']; ?>, <?php echo $alumno[0]['IdCampus']; ?>)" href="#_pendientes" data-toggle="tab"><i class="fa fa-fw fa-bell-slash-o"></i> Pendientes</a></li>
										<li><a style="cursor: pointer;" onclick="cargar_pagos_aprobados()" href="#timeline2" data-toggle="tab"><i class="fa fa-fw fa-file-pdf-o"></i> Pagos aprobados</a></li>
										<!--<li><a style="cursor: pointer;" onclick="enviar_correo_id(<?php echo $id; ?>)"><i class="fa fa-fw fa-file-pdf-o"></i> Enviar</a></li>-->
									<?php } ?>
									<li><a style="cursor: pointer;" onclick="cargar_segui(<?php echo $_SESSION['IdUsua']; ?>)" href="#seguimiento_us" data-toggle="tab"><i class="fa fa-fw fa-twitch"></i> Seguimiento</a></li>
								</ul>

								<?php if (isset($_GET['token'])) { ?>
									<div class="tab-content">
									<?php if ((isset($pendIns[0]['Valor'])) && ($pendIns[0]['Valor'] == 4)) { ?>
									<div class="bg-red-active color-palette" style="padding: 10px; text-align: center;"><span>EL ALUMNO NO HA SIDO MIGRADO</span></div><br>
									<?php } ?>

										<div class="active tab-pane" id="activity">
											<p style="text-align: center; display: none;" id="img_cargar_1">
												<img src="assets/images/cargando.gif">
											</p>
											<div id="informacion_gral_alumno"> </div>
										</div>
										<div class="tab-pane" id="timeline">
											<p style="text-align: center; display: none;" id="img_cargar_2">
												<img src="assets/images/cargando.gif">
											</p>
											<div id="lista_kardex_calificaciones">
											</div>
										</div>
										<div class="tab-pane" id="_materias">
											<p style="text-align: center; display: none;" id="img_cargar_3">
												<img src="assets/images/cargando.gif">
											</p>
											<div id="lista_materias_asig">
											</div>
										</div>
										<div class="tab-pane" id="_pendientes">
											<p style="text-align: center; display: none;" id="img_cargar_5">
												<img src="assets/images/cargando.gif">
											</p>
											<div id="lista_materias_pend">
											</div>
										</div>
										<div class="tab-pane" id="timeline2">
											<p style="text-align: center; display: none;" id="img_cargar_4">
												<img src="assets/images/cargando.gif">
											</p>
											<div id="lista_pagos_aprobados">
											</div>
										</div>

										<div class="tab-pane" id="seguimiento_us">
											<p style="text-align: center; display: none;" id="img_cargar_5">
												<img src="assets/images/cargando.gif">
											</p>
											<div id="list_seguimiento">
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</form>
			</section>
		</div>
		<div id="dataModal4" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-search"></i> Buscador de alumnos</h4>
					</div>
					<div class="modal-body" id="employee_detail4">

					</div>
				</div>
			</div>
		</div>
		<div id="dataModal3" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Configuración de beca</h4>
					</div>
					<div class="modal-body" id="employee_detail3">

					</div>
				</div>
			</div>
		</div>

		<div id="dataModal7" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-gears"></i> Detalle del concepto</h4>
					</div>
					<div class="modal-body" id="employee_detail7">

					</div>
				</div>
			</div>
		</div>
		<div id="dataModal7T" class="modal fade bs-example-modal-lg">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-diamond"></i> Realizar el cobro de conceptos</h4>
					</div>
					<div class="modal-body" id="employee_detail7T">

					</div>
				</div>
			</div>
		</div>

		<div id="dataModal8" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Configurar permisos del usuario</h4>
					</div>
					<div class="modal-body" id="employee_detail8">

					</div>
				</div>
			</div>
		</div>
		<div id="dataNewPago" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Agregar nuevos pagos</h4>
					</div>
					<div class="modal-body" id="employee_NewPago">

					</div>
				</div>
			</div>
		</div>

		<div id="dataGrp" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configuraciones generales</h4>
					</div>
					<div class="modal-body" id="employee_Grp">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalE" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-tags"></i> Ver resultados de la encuesta docente del alumno</h4>
					</div>
					<div class="modal-body" id="employee_detailE">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalC" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-tags"></i> Seguimiento de alumno</h4>
					</div>
					<div class="modal-body" id="employee_detailC">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModal_del" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar estatus del alumno en la Plataforma</h4>
					</div>
					<div class="modal-body" id="employee_detail_del">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModal_rec" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar materia al alumno en la Plataforma</h4>
					</div>
					<div class="modal-body" id="employee_detail_rec">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModal_per" class="modal fade bs-example-modal-lg">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-briefcase"></i> Configurar horario personalizado</h4>
					</div>
					<div class="modal-body" id="employee_detail_per">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModal_dip" class="modal fade bs-example-modal-lg">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-briefcase"></i> Configurar módulo (diplomado / curso)</h4>
					</div>
					<div class="modal-body" id="employee_detail_dip">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModal_asig" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-briefcase"></i> Configurar materia de Inglés al alumno</h4>
					</div>
					<div class="modal-body" id="employee_detail_asig">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModal_ssl" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-expeditedssl"></i> Datos de inicio de sesión</h4>
					</div>
					<div class="modal-body" id="employee_detail_ssl">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModal_calF" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Modificar calificación final del alumno</h4>
					</div>
					<div class="modal-body" id="employee_detail_calF">
					</div>
				</div>
			</div>
		</div>
		<div id="data_extra" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Agregar calificación de extraordinario al alumno</h4>
					</div>
					<div class="modal-body" id="employee_extra">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalCer" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Datos del certificado de estudios</h4>
					</div>
					<div class="modal-body" id="employee_cer">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalMat" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Modificar información de la materia asignada</h4>
					</div>
					<div class="modal-body" id="employee_mat">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalMod" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Modalidad de término de carrera</h4>
					</div>
					<div class="modal-body" id="employee_mod">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalTray" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-graduation-cap"></i> Trayectoria estudiantil</h4>
					</div>
					<div class="modal-body" id="employee_detailTray">
					</div>
				</div>
			</div>
		</div>
		<div id="dataNewPago" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-smile-o"></i> Agregar nuevos pagos</h4>
					</div>
					<div class="modal-body" id="employee_NewPago">

					</div>
				</div>
			</div>
		</div>
		<div id="data_credencial" class="modal fade">
			<div class="modal-dialog modal-sm">
				<div class="modal-content" style="width: 350px !important; height: 590px !important; margin: 0 auto;">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-barcode"></i> Mi Credencial Digital</h4>
					</div>

					<div class="modal-body" id="employee_credencial">
					</div>
				</div>
			</div>
		</div>


		<?php include("footer.php"); ?>
	</div>
</body>
<!-- jQuery 3 -->
<script>
	$(document).ready(function() {
		var token = document.getElementById("token").value;
		var IdUsua = document.getElementById("idToks").value;
		if (token == '') {
			$.ajax({
				url: "formConsulta/buscarUsuario.php",
				method: "POST",
				data: {},
				success: function(data) {
					$('#employee_detail4').html(data);
					$('#dataModal4').modal('show');
				}
			});
		}

		if (IdUsua) {
			document.getElementById("_disponible").style.display = 'block';
			document.getElementById("_no_disponible").style.display = 'none';
			cargar_permisos();
			cargar_informacion_alumno();
		} else {
			document.getElementById("_no_disponible").style.display = 'block';
			document.getElementById("_disponible").style.display = 'none';
			no_encontrado();
		}

	})

	$(document).ready(function() {
		$(document).on('click', '.view_buscar', function() {
			$.ajax({
				url: "formConsulta/buscarUsuario.php",
				method: "POST",
				data: {},
				success: function(data) {
					$('#employee_detail4').html(data);
					$('#dataModal4').modal('show');
				}
			});
		});
	});

	function addBeca() {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/addBeca.php",
			method: "POST",
			data: {
				Token: Token
			},
			success: function(data) {
				$('#employee_detail3').html(data);
				$('#dataModal3').modal('show');
			}
		});
	}


	function addPago(IdPago) {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/addPago.php",
			method: "POST",
			data: {
				Token: Token,
				IdPago: IdPago
			},
			success: function(data) {
				$('#employee_detail7').html(data);
				$('#dataModal7').modal('show');
			}
		});
	}

	function addPagoTodos() {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/addPagoTodos.php",
			method: "POST",
			data: {
				Token: Token
			},
			success: function(data) {
				$('#employee_detail7T').html(data);
				$('#dataModal7T').modal('show');
			}
		});
	}

	function delPago(IdPago) {
		var Token = document.getElementById("token").value;

		var TipoGuardar = "del_pago";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este pago?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
				cancelButtonText: "Cancelar",
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');

					$.ajax({
						url: "formConsulta/setting.php",
						method: "POST",
						data: {
							TipoGuardar: TipoGuardar,
							IdPago: IdPago,
							Token: Token
						},
						success: function(data) {

							parent.location.href = 'perfil.php?token=' + Token;
						}
					})
				}
			});
	}

	function addPermisos() {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/addPermiso.php",
			method: "POST",
			data: {
				Token: Token
			},
			success: function(data) {
				$('#employee_detail8').html(data);
				$('#dataModal8').modal('show');
			}
		});
	}

	function addNewPago() {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/addNewPago.php",
			method: "POST",
			data: {
				Token: Token
			},
			success: function(data) {
				$('#employee_NewPago').html(data);
				$('#dataNewPago').modal('show');
			}
		});
	}

	function changeGrupo(IdCampus, IdOferta) {
		var IdCiclo = 0;
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/cambiarGrupo.php",
			method: "POST",
			data: {
				Token: Token,
				IdCampus: IdCampus,
				IdOferta: IdOferta,
				IdCiclo: IdCiclo
			},
			success: function(data) {
				$('#employee_Grp').html(data);
				$('#dataGrp').modal('show');
			}
		});
	}

	function changePlantelGrupo(IdCampus) {
		var IdCiclo = 0;
		var IdOferta = 0;
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/cambiarPlantel.php",
			method: "POST",
			data: {
				Token: Token,
				IdCampus: IdCampus,
				IdOferta: IdOferta,
				IdCiclo: IdCiclo
			},
			success: function(data) {
				$('#employee_Grp').html(data);
				$('#dataGrp').modal('show');
			}
		});
	}

	function changePlantelGrupo(IdCampus) {
		var IdCiclo = 0;
		var IdOferta = 0;
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/cambiarPlantel.php",
			method: "POST",
			data: {
				Token: Token,
				IdCampus: IdCampus,
				IdOferta: IdOferta,
				IdCiclo: IdCiclo
			},
			success: function(data) {
				$('#employee_Grp').html(data);
				$('#dataGrp').modal('show');
			}
		});
	}

		function changePlantelGrupoDiplomado(IdCampus) {
		var IdCiclo = 0;
		var IdOferta = 0;
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/cambiarPlantelDiplomado.php",
			method: "POST",
			data: {
				Token: Token,
				IdCampus: IdCampus,
				IdOferta: IdOferta,
				IdCiclo: IdCiclo
			},
			success: function(data) {
				$('#employee_Grp').html(data);
				$('#dataGrp').modal('show');
			}
		});
	}


	function addSaldoIni() {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/addSaldoIni.php",
			method: "POST",
			data: {
				Token: Token
			},
			success: function(data) {
				$('#employee_detailIni').html(data);
				$('#dataModalIni').modal('show');
			}
		});
	}

	function del_alumnoId() {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/eliminarAlumno.php",
			method: "POST",
			data: {
				Token: Token
			},
			success: function(data) {
				$('#employee_detail_del').html(data);
				$('#dataModal_del').modal('show');
			}
		});
	}

	function recursar_materia(IdUsua) {
		var IdGrupo = 0;
		var IdCiclo = 0;
		$.ajax({
			url: "formConsulta/recursar_materia_alumno.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				IdGrupo: IdGrupo,
				IdCiclo: IdCiclo
			},
			success: function(data) {
				$('#employee_detail_rec').html(data);
				$('#dataModal_rec').modal('show');
			}
		});
	}

	function horario_personalizado(IdUsua) {
		var idPeriodo = 0;
		var idCiclo = 0;
		var idGrupo = 0;
		$.ajax({
			url: "vistas/escolar/horario_personalizado.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				idPeriodo: idPeriodo,
				idCiclo: idCiclo,
				idGrupo: idGrupo
			},
			success: function(data) {
				$('#employee_detail_per').html(data);
				$('#dataModal_per').modal('show');
			}
		});
	}

	function horario_personalizado_especial(IdUsua) {
		var idPeriodo = 0;
		var idCiclo = 0;
		var idGrupo = 0;
		var idModulo = 0;
		var idTipo = 'T';
		$.ajax({
			url: "vistas/escolar/horario_personalizado_especial.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				idPeriodo: idPeriodo,
				idCiclo: idCiclo,
				idGrupo: idGrupo,
				idModulo: idModulo,
				idTipo: idTipo
			},
			success: function(data) {
				$('#employee_detail_per').html(data);
				$('#dataModal_per').modal('show');
			}
		});
	}

	function configurar_curso(IdUsua) {
		var idCiclo = 0;
		var idGrupo = 0;
		var idGrado = 7;
		$.ajax({
			url: "vistas/vinculacion/asignar_materia.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				idCiclo: idCiclo,
				idGrupo: idGrupo,
				idGrado: idGrado
			},
			success: function(data) {
				$('#employee_detail_dip').html(data);
				$('#dataModal_dip').modal('show');
			}
		});
	}

	function asignar_materia(IdUsua) {
		var IdGrupo = 0;
		$.ajax({
			url: "vistas/escolar/asignar_materia.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				IdGrupo: IdGrupo
			},
			success: function(data) {
				$('#employee_detail_asig').html(data);
				$('#dataModal_asig').modal('show');
			}
		});
	}

	function datos_acceso_user(IdUsua) {
		$.ajax({
			url: "vistas/escolar/upd_datos_sesion.php",
			method: "POST",
			data: {
				IdUsua: IdUsua
			},
			success: function(data) {
				$('#employee_detail_ssl').html(data);
				$('#dataModal_ssl').modal('show');
			}
		});
	}

	function trayectoria_id(IdUsua) {
		var IdTrayectoria = 0;
		$.ajax({
			url: "vistas/alumno/trayectoria_estudiantil.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				IdTrayectoria: IdTrayectoria
			},
			success: function(data) {
				$('#employee_detailTray').html(data);
				$('#dataModalTray').modal('show');
			}
		});
	}

	$(document).ready(function() {
		$(document).on('click', '.view_delAsignacion', function() {
			var employee_id = $(this).attr("id");
			if (employee_id != '') {
				var TipoGuardar = "del_asignacion";
				swal({
						title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente la materia de este alumno?",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'Aceptar',
						cancelButtonText: "Cancelar",
					},
					function(isConfirm) {
						if (isConfirm) {
							$(".confirm").attr('disabled', 'disabled');

							$.ajax({
								url: "formConsulta/setting.php",
								method: "POST",
								data: {
									TipoGuardar: TipoGuardar,
									employee_id: employee_id
								},
								success: function(data) {
									var porciones = employee_id.split('-');
									IdMod = porciones[3];
									document.getElementById(IdMod).style.display = 'none';
									// parent.location.href='perfil.php?token=9834532145'+Id;
								}
							})
						}
					});
			}
		});
	});

	$(document).ready(function() {
		$(document).on('click', '.view_encuesta', function() {
			var employee_id = $(this).attr("id");
			$.ajax({
				url: "formConsulta/resultado_encuesta_vista_alumno.php",
				method: "POST",
				data: {
					employee_id: employee_id
				},
				success: function(data) {
					$('#employee_detailE').html(data);
					$('#dataModalE').modal('show');
				}
			});
		});
	});

	function mostrarPass() {
		document.getElementById('txtP1').style.display = 'none';
		document.getElementById('txtP2').style.display = 'block';
	}

	function no_encontrado() {
		var IdUsua = document.getElementById("idToks").value;
		document.getElementById("img_cargar_1").style.display = 'block';
		document.getElementById("informacion_gral_alumno").style.display = 'none';
		var Capa = "#informacion_gral_alumno";
		$(Capa).load("vistas/alumno/rep_informacion_gral_alumno.php", {
			IdUsua: IdUsua
		}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
			if (status == "success") {
				document.getElementById("informacion_gral_alumno").style.display = 'block';
				document.getElementById("img_cargar_1").style.display = 'none';
			}
		});
	}

	function cargar_permisos() {
		var IdUsua = document.getElementById("idToks").value;
		document.getElementById("img_cargar_0").style.display = 'block';
		document.getElementById("permisos_alumno_id").style.display = 'none';
		var Capa = "#permisos_alumno_id";
		$(Capa).load("vistas/alumno/rep_permisos_perfil.php", {
			IdUsua: IdUsua
		}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
			if (status == "success") {
				document.getElementById("permisos_alumno_id").style.display = 'block';
				document.getElementById("img_cargar_0").style.display = 'none';
			}
		});
	}

	function cargar_informacion_alumno() {
		var IdUsua = document.getElementById("idToks").value;
		document.getElementById("img_cargar_1").style.display = 'block';
		document.getElementById("informacion_gral_alumno").style.display = 'none';
		var Capa = "#informacion_gral_alumno";
		$(Capa).load("vistas/alumno/rep_informacion_gral_alumno.php", {
			IdUsua: IdUsua
		}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
			if (status == "success") {
				document.getElementById("informacion_gral_alumno").style.display = 'block';
				document.getElementById("img_cargar_1").style.display = 'none';
			}
		});
	}


	function cargar_kardex_alumno() {
		var IdUsua = document.getElementById("idToks").value;
		document.getElementById("img_cargar_2").style.display = 'block';
		document.getElementById("lista_kardex_calificaciones").style.display = 'none';
		var Capa = "#lista_kardex_calificaciones";
		$(Capa).load("vistas/alumno/rep_kardex_alumno.php", {
			IdUsua: IdUsua
		}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
			if (status == "success") {
				document.getElementById("lista_kardex_calificaciones").style.display = 'block';
				document.getElementById("img_cargar_2").style.display = 'none';
			}
		});
	}

	function cargar_materias_asignadas() {
		var IdUsua = document.getElementById("idToks").value;
		document.getElementById("img_cargar_3").style.display = 'block';
		document.getElementById("lista_materias_asig").style.display = 'none';
		var Capa = "#lista_materias_asig";
		$(Capa).load("vistas/alumno/rep_materias_asignadas_alumno.php", {
			IdUsua: IdUsua
		}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
			if (status == "success") {
				document.getElementById("lista_materias_asig").style.display = 'block';
				document.getElementById("img_cargar_3").style.display = 'none';
			}
		});
	}

	function cargar_materias_pendientes(IdEducativa, IdCampus) {
		var IdUsua = document.getElementById("idToks").value;
		document.getElementById("img_cargar_5").style.display = 'block';
		document.getElementById("lista_materias_pend").style.display = 'none';
		var Capa = "#lista_materias_pend";
		$(Capa).load("vistas/alumno/rep_materias_pendientes.php", {
			IdUsua: IdUsua,
			IdEducativa:IdEducativa,
			IdCampus:IdCampus
		}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
			if (status == "success") {
				document.getElementById("lista_materias_pend").style.display = 'block';
				document.getElementById("img_cargar_5").style.display = 'none';
			}
		});
	}


	function cargar_pagos_aprobados() {
		var IdUsua = document.getElementById("idToks").value;
		document.getElementById("img_cargar_4").style.display = 'block';
		document.getElementById("lista_pagos_aprobados").style.display = 'none';
		var Capa = "#lista_pagos_aprobados";
		$(Capa).load("vistas/alumno/rep_pagos_aprobados_alumno.php", {
			IdUsua: IdUsua
		}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
			if (status == "success") {
				document.getElementById("lista_pagos_aprobados").style.display = 'block';
				document.getElementById("img_cargar_4").style.display = 'none';
			}
		});
	}

	function cargar_segui(IdUsua) {
		var IdAlumno = document.getElementById("idToks").value;
		document.getElementById("img_cargar_5").style.display = 'block';
		document.getElementById("list_seguimiento").style.display = 'none';
		var Capa = "#list_seguimiento";
		$(Capa).load("dashboard/rep_seguimiento_usuario.php", {
			IdUsua: IdUsua,
			IdAlumno: IdAlumno
		}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
			if (status == "success") {
				document.getElementById("list_seguimiento").style.display = 'block';
				document.getElementById("img_cargar_5").style.display = 'none';
			}
		});
	}



	function abrir_chat(IdUsua, IdAlumno) {
		var Cic = document.getElementById("_grp").value;
		$.ajax({
			url: "formConsulta/chat_seguimiento.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				IdAlumno: IdAlumno,
				Cic: Cic
			},
			success: function(data) {
				$('#employee_detailC').html(data);
				$('#dataModalC').modal('show');
			}
		});
	}

	function cambiar_calificacion(IdCalificacion) {
		$.ajax({
			url: "vistas/coordinacion/calificacion_final.php",
			method: "POST",
			data: {
				IdCalificacion: IdCalificacion
			},
			success: function(data) {
				$('#employee_detail_calF').html(data);
				$('#dataModal_calF').modal('show');
			}
		});
	}

	function capturar_extra(IdCalificacion) {
		$.ajax({
			url: "vistas/coordinacion/calificacion_extra.php",
			method: "POST",
			data: {
				IdCalificacion: IdCalificacion
			},
			success: function(data) {
				$('#employee_extra').html(data);
				$('#data_extra').modal('show');
			}
		});
	}

	function configurar_certificado(IdUsua) {
		$.ajax({
			url: "vistas/formatos/certificado_estudios.php",
			method: "POST",
			data: {
				IdUsua: IdUsua
			},
			success: function(data) {
				$('#employee_cer').html(data);
				$('#dataModalCer').modal('show');
			}
		});
	}

	function modificar_materia_asig(IdMod) {
		$.ajax({
			url: "vistas/coordinador/modificar_materia_asignada.php",
			method: "POST",
			data: {
				IdMod: IdMod
			},
			success: function(data) {
				$('#employee_mat').html(data);
				$('#dataModalMat').modal('show');
			}
		});

	}

	

	function upd_materia_asig_mod(IdMod) {
		var IdModulo = document.getElementById("txt_modulo_rve").value;

		var TipoGuardar = 'upd_datos_mater_asignada';
		if (IdModulo == '') {
			swal("Error al guardar", "Debe seleccionar a que materia pertenece segun el RVOE.", "error");
			document.getElementById("txt_modulo_rve").focus();
			return 0;
		}

		swal({
				title: "\u00BFEst\u00E1 seguro que desea actualizar la materia del RVOE asignada?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');
					$.ajax({
							type: "POST",
							url: "vistas/escolar/guardar_datos_escolar.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdMod: IdMod,
								IdModulo: IdModulo
							},
							success: function(data) {


							}
						})
						.done(function(data) {
							if (data == 1) {
								cargar_materias_asignadas();
								swal("Actualizado correctamente", "La materia asignada se ha actualizado correctamente.", "success");
								$('#dataModalMat').modal('hide');
							}
							if (data == 0) {
								swal("Ha ocurrido un error", "No se ha podido guardar", "error");
							}
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});
	}

	function upd_modalidad_alumno(IdUsua) {
		var Termino = document.getElementById("txt_termino_alumno").value;

		var TipoGuardar = 'upd_modalidad_alumno';
		if (Termino == '') {
			swal("Error al guardar", "Debe seleccionar el término de la carrera del alumno.", "error");
			document.getElementById("txt_termino_alumno").focus();
			return 0;
		}

		swal({
				title: "\u00BFEst\u00E1 seguro que desea actualizar el término de la carrera de este alumno?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');
					$.ajax({
							type: "POST",
							url: "vistas/escolar/guardar_datos_escolar.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua,
								Termino: Termino
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								cargar_permisos();
								swal("Actualizado correctamente", "El término de la carrera del alumno se ha actualizado correctamente.", "success");
								$('#dataModalMod').modal('hide');
							}
							if (data == 0) {
								swal("Ha ocurrido un error", "No se ha podido guardar", "error");
							}
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});
	}

	function validar_listamaterias(IdUsua, IdCiclo) {
		var TipoGuardar = 'verificar_clases_user';
		
		swal({
				title: "\u00BFEst\u00E1 seguro que desea actualizar la lista de materias de este alumnos?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');
					$.ajax({
							type: "POST",
							url: "vistas/escolar/guardar_datos_escolar.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua,
								IdCiclo: IdCiclo
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								cargar_materias_asignadas();
								swal("Actualizado correctamente", "La lista de materias del alumno se ha actualizado correctamente.", "success");
							}
							if (data == 0) {
								swal("Sin procesar", "No se ha procesado ninguna materia", "info");
							}
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});
	}

	function addNewPago() {
		var Token = document.getElementById("token").value;
		var IdCiclo = 0;
		$.ajax({
			url: "formConsulta/addNewPago_diplomado.php",
			method: "POST",
			data: {
				Token: Token,
				IdCiclo: IdCiclo
			},
			success: function(data) {
				$('#employee_NewPago').html(data);
				$('#dataNewPago').modal('show');
			}
		});
	}

	function mi_credencial_id() {
		var IdUsua = document.getElementById("token").value;
		$.ajax({
			url: "vistas/alumno/mi_credencial.php",
			method: "POST",
			data: {
				IdUsua: IdUsua
			},
			success: function(data) {
				$('#employee_credencial').html(data);
				$('#data_credencial').modal('show');
			}
		});
	}

	function modificar_modalidad(IdUsua) {
		$.ajax({
			url: "vistas/alumno/modalidad_alumno.php",
			method: "POST",
			data: {
				IdUsua: IdUsua
			},
			success: function(data) {
				$('#employee_mod').html(data);
				$('#dataModalMod').modal('show');
			}
		});

	}

	function enviar_correo_id(IdUsua) {
		var TipoGuardar = 'enviar_correo_id';
		swal({
				title: "\u00BFEst\u00E1 seguro que desea enviar este correo?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');
					$.ajax({
							type: "POST",
							url: "formConsulta/procesar_datos.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							swal("Actualizado correctamente", "El término de la carrera del alumno se ha actualizado correctamente.", "success");
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});
	}
	
	function migrar_alumno_id(IdUsua) {
		var TipoGuardar = 'enviar_correo_id';
		swal({
				title: "\u00BFEst\u00E1 seguro que desea migrar a este alumno?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');
					$.ajax({
							type: "POST",
							url: "formConsulta/procesar_datos.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							swal("Actualizado correctamente", "El término de la carrera del alumno se ha actualizado correctamente.", "success");
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});
	}

</script>


<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClic
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>

</html>