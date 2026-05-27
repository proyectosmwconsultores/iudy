<?php $valor = 3;
$section = "Reincorporación";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de Reincorporación.');
}

$ciclo = $t->get_ciclo_activo();

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Lista de usuarios con seguimiento para su reincorporación
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> >Alumnos</a></li>
					<li class="active">Reincorporación</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="adReincorporacion.php" method="POST" enctype="multipart/form-data">
					<div class="box box-default">
						<div class="box-body">
							<div class="row">
								<div class="col-md-4">
									<div class="box-primary">
										<div class="box-body">
											<a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
												<i class="fa fa-rotate-left"></i> Regresar
											</a>
										</div>
									</div>
								</div>
								<div class="col-md-8">
									<div class="box-primary">
										<div class="box-body">
											<div class="form-group">
												<label>Periodo escolar:</label>
												<div class="input-group">
													<div class="input-group-addon"><i class="fa fa-users"></i></div>
													<select class="form-control select2" name="txt_ciclo" id="txt_ciclo">
														<option value=""> - Seleccione - </option>
														<?php for ($i = 0; $i < sizeof($ciclo); $i++) { ?>
															<option value="<?php echo $ciclo[$i]["IdCiclo"]; ?>"><?php echo $ciclo[$i]["Tipo"]; ?> - <?php echo $ciclo[$i]["Ciclo"]; ?></option>
														<?php } ?>
													</select>
													<span class="input-group-btn">
														<button type="button" class="btn btn-info btn-flat" onclick="consultar_reporte()"><i class="fa fa-fw fa-search"></i> Consultar</button>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<p style="text-align: center; display: none;" id="img_cargar">
										<img src="assets/images/cargando.gif">
									</p>
									<div class="box-body" id="mostrar_ingresos" style="display: none;"></div>
								</div>
							</div>
						</div>
					</div>

				</form>
			</section>

		</div>

		<div id="dataModalIni" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar reincorporación de alumno</h4>
					</div>
					<div class="modal-body" id="employee_detailIni">

					</div>
				</div>
			</div>
		</div>

		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2 -->
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>


		<?php include("footer.php"); ?>
	</div>
	<script>
		function congGrupo(IdUsua, IdReincorporacion) {
			var IdCiclo = 0;
			$.ajax({
				url: "formConsulta/addReincorporacion_seg.php",
				method: "POST",
				data: {
					IdUsua: IdUsua,
					IdCiclo: IdCiclo,
					IdReincorporacion: IdReincorporacion
				},
				success: function(data) {
					$('#employee_detailIni').html(data);
					$('#dataModalIni').modal('show');
				}
			});
		}

		$(function() {
			$('.select2').select2()

		})

		function consultar_reporte() {
			var IdCiclo = document.getElementById("txt_ciclo").value;

			if (IdCiclo == '') {
				swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
				document.getElementById("txt_ciclo").focus();
				return 0;
			}

			document.getElementById("img_cargar").style.display = 'block';
			document.getElementById("mostrar_ingresos").style.display = 'none';
			var Capa = "#mostrar_ingresos";
			$(Capa).load("vistas/coordinador/lista_reincorporacion_seg.php", {
				IdCiclo: IdCiclo
			}, function(response, status, xhr) {

				if (status == "error") {
					var msg = "Error!, algo ha sucedido: ";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
				if (status == "success") {

					document.getElementById("mostrar_ingresos").style.display = 'block';
					document.getElementById("img_cargar").style.display = 'none';
				}
			});
		}

		function sel_ciclo_es(IdUsua) {
			var IdCiclo = document.getElementById("txt_id_ciclo").value;
			$.ajax({
				url: "formConsulta/addReincorporacion_seg.php",
				method: "POST",
				data: {
					IdUsua: IdUsua,
					IdCiclo: IdCiclo
				},
				success: function(data) {
					$('#employee_detailIni').html(data);
					$('#dataModalIni').modal('show');
				}
			});
		}

		function sav_seguimi_reincor(IdUsua, IdReincorporacion, IdAdmin) {
			var Nota = document.getElementById("txt_comen_segx").value;
			var Fecha = document.getElementById("datepicker1").value;
			var IdRvoe = document.getElementById("txt_oferta").value;
			
			var TipoGuardar = "sav_reincorpora_alumno";
			if (Fecha == '') {
				swal("Error al guardar", "Debe seleccionar la fecha de reincorporación", "error");
				document.getElementById("datepicker1").focus();
				return 0;
			}
			if (IdRvoe == '') {
				swal("Error al guardar", "Debe seleccionar el plan de estudios segun el rvoe", "error");
				document.getElementById("datepicker1").focus();
				return 0;
			}
			if (Nota == '') {
				swal("Error al guardar", "Debe escribir las observaciones del seguimiento.", "error");
				document.getElementById("txt_comen_segx").focus();
				return 0;
			} 

			swal({
					title: "\u00BFEst\u00E1 seguro que desea reincorporar a este alumno?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Aceptar',

				},
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
								url: "vistas/coordinador/guardar_datos_coordinador.php",
								method: "POST",
								data: {
									TipoGuardar: TipoGuardar,
									IdReincorporacion: IdReincorporacion,
									IdUsua: IdUsua,
									Nota: Nota,
									IdAdmin: IdAdmin,
									Fecha: Fecha,
									IdRvoe:IdRvoe
								},
								success: function(data) {

								}
							})
							.done(function(data) {
								if (data == 1) {
									$('#dataModalIni').modal('hide');
									swal("Reincorporado correctamente", "El alumno se ha reincorporado correctamente al grupo seleccionado.", "success");
									consultar_reporte();
								}
								if (data == 0) {
									swal("Error al reincorporar", "No se pude realizar el proceso de reincorporación.", "error");
								}
								if (data == 3) {
									swal("Error al reincorporar", "No se pude realizar el proceso, favor de revisar el monto de la reinscripción para poder reincorporar al alumno.", "error");
								}

								if (data == 2) {
									swal("Error al reincorporar", "No se pude realizar el proceso, favor de revisar el monto de la mensualidad para poder reincorporar al alumno.", "error");
								}
							})
							.error(function(data) {
								swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
							});

					}
				});
		}

		function sav_pagos_seguimi_reincor(IdUsua, IdReincorporacion, IdAdmin, IdCiclo) {
			var TipoGuardar = "sav_pagos_reincorpora_alumno";
			swal({
					title: "\u00BFEst\u00E1 seguro que desea aplicar los pagos del alumno para su reincorporación?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Aceptar',

				},
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
								url: "vistas/coordinador/guardar_datos_coordinador.php",
								method: "POST",
								data: {
									TipoGuardar: TipoGuardar,
									IdReincorporacion: IdReincorporacion,
									IdUsua: IdUsua,
									IdAdmin: IdAdmin
								},
								success: function(data) {

								}
							})
							.done(function(data) {
								if (data == 1) {
									swal("Pagos aplicados", "Los pagos iniciales del alumno se han aplicados al alumno para su reincorporado correctamente al grupo seleccionado.", "success");
									$.ajax({
										url: "formConsulta/addReincorporacion_seg.php",
										method: "POST",
										data: {
											IdUsua: IdUsua,
											IdCiclo: IdCiclo,
											IdReincorporacion: IdReincorporacion
										},
										success: function(data) {
											$('#employee_detailIni').html(data);
											$('#dataModalIni').modal('show');
										}
									});
								}
								if (data == 0) {
									swal("Error al reincorporar", "No se pude realizar el proceso de reincorporación.", "error");
								}
								if (data == 3) {
									swal("Error al reincorporar", "No se pude realizar el proceso, favor de revisar el monto de la reinscripción para poder reincorporar al alumno.", "error");
								}

								if (data == 2) {
									swal("Error al reincorporar", "No se pude realizar el proceso, favor de revisar el monto de la mensualidad para poder reincorporar al alumno.", "error");
								}
							})
							.error(function(data) {
								swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
							});

					}
				});
		}
	</script>
</body>

</html>