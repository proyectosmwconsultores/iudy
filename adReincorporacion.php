<?php $valor = 3;
$section = "Reincorporación";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de Reincorporación.');
}

$campusId = $t->get_campusId();

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
					Lista de usuarios de para reincorporación
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
								<div class="col-md-6">
									<div class="box-primary">
										<div class="box-body">
											<a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
												<i class="fa fa-rotate-left"></i> Regresar
											</a>
											<a class="btn btn-app" onclick="crear_nuevo_user()" href="javascript:void(0);">
												<i class="fa fa-user"></i> Nuevo
											</a>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="box-primary">
										<div class="box-body">
											<div class="form-group">
												<label>Campus:</label>
												<div class="input-group">
													<div class="input-group-addon"><i class="fa fa-users"></i></div>
													<select class="form-control select2" name="txtCampus" id="txtCampus">
														<option value=""> - Seleccione - </option>
														<?php for ($i = 0; $i < sizeof($campusId); $i++) { ?>
															<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"><?php echo $campusId[$i]["Campus"]; ?></option>
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
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Reincorporación de alumno a nuevo grupo.</h4>
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
		function crear_nuevo_user() {
			var IdCiclo = 0;
			var Tipo = 'R';
			$.ajax({
				url: "formConsulta/addReincorporacion_new.php",
				method: "POST",
				data: {
					IdCiclo: IdCiclo,
					Tipo:Tipo
				},
				success: function(data) {
					$('#employee_detailIni').html(data);
					$('#dataModalIni').modal('show');
				}
			});

		}

		function sel_ciclo_es_new(Tipo) {
			var IdCiclo = document.getElementById("txt_id_ciclo_new").value;
			$.ajax({
				url: "formConsulta/addReincorporacion_new.php",
				method: "POST",
				data: {
					IdCiclo: IdCiclo,
					Tipo:Tipo
				},
				success: function(data) {
					$('#employee_detailIni').html(data);
					$('#dataModalIni').modal('show');
				}
			});
		}

		function sel_ciclo_es_new_anterior(IdUsua, Tipo) {
			var IdCampus = document.getElementById("txtCampus").value;
			var IdCiclo = document.getElementById("txt_id_ciclo").value;
			$.ajax({
				url: "formConsulta/addReincorporacion.php",
				method: "POST",
				data: {
					IdUsua: IdUsua,
					IdCiclo: IdCiclo,
					Tipo:Tipo, IdCampus:IdCampus
				},
				success: function(data) {
					$('#employee_detailIni').html(data);
					$('#dataModalIni').modal('show');
				}
			});
		}

		function sel_tipo_grupo(IdCiclo) {
			var Tipo = document.getElementById("txt_tipo_grupo").value;
			$.ajax({
				url: "formConsulta/addReincorporacion_new.php",
				method: "POST",
				data: {
					IdCiclo: IdCiclo,
					Tipo:Tipo
				},
				success: function(data) {
					$('#employee_detailIni').html(data);
					$('#dataModalIni').modal('show');
				}
			});
		}

		function sel_tipo_grupo_anterior(IdCiclo, IdUsua) {
			var IdCampus = document.getElementById("txtCampus").value;
			var Tipo = document.getElementById("txt_tipo_grupo").value;
			$.ajax({
				url: "formConsulta/addReincorporacion.php",
				method: "POST",
				data: {
					IdUsua: IdUsua,
					IdCiclo: IdCiclo,
					Tipo:Tipo, IdCampus:IdCampus
				},
				success: function(data) {
					$('#employee_detailIni').html(data);
					$('#dataModalIni').modal('show');
				}
			});
		}

		function congGrupo(IdUsua) {
			var IdCampus = document.getElementById("txtCampus").value;
			var IdCiclo = 0;
			var Tipo = 'R';
			$.ajax({
				url: "formConsulta/addReincorporacion.php",
				method: "POST",
				data: {
					IdUsua: IdUsua,
					IdCiclo: IdCiclo,
					Tipo:Tipo, IdCampus:IdCampus
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
			var IdCampus = document.getElementById("txtCampus").value;

			if (IdCampus == '') {
				swal("Error al guardar", "Debe seleccionar el campus.", "error");
				document.getElementById("txtCampus").focus();
				return 0;
			}

			document.getElementById("img_cargar").style.display = 'block';
			document.getElementById("mostrar_ingresos").style.display = 'none';
			var Capa = "#mostrar_ingresos";
			$(Capa).load("vistas/coordinador/lista_reincorporacion.php", {
				IdCampus: IdCampus
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
				url: "formConsulta/addReincorporacion.php",
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

		function add_seguimi_reincor(IdUsua, IdAdmin, IdCampus) {
			var IdCiclo = document.getElementById("txt_id_ciclo").value;
			var IdGrupo = document.getElementById("txt_id_grupo").value;
			var Nota = document.getElementById("txt_comen_seg").value;
			
			var TipoGuardar = "add_reincorpora";
			if (IdCiclo == '') {
				swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
				document.getElementById("txt_id_ciclo").focus();
				return 0;
			}
			if (IdGrupo == '') {
				swal("Error al guardar", "Debe seleccionar el grupo.", "error");
				document.getElementById("txt_id_grupo").focus();
				return 0;
			}
			if (Nota == '') {
				swal("Error al guardar", "Debe escribir las observaciones del seguimiento.", "error");
				document.getElementById("txt_comen_seg").focus();
				return 0;
			}

			swal({
					title: "\u00BFEst\u00E1 seguro que desea agregar este alumno para seguimiento de reincorporación?",
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
									IdCiclo: IdCiclo,
									IdUsua: IdUsua,
									IdGrupo: IdGrupo,
									Nota: Nota,
									IdAdmin: IdAdmin, IdCampus:IdCampus
								},
								success: function(data) {

								}
							})
							.done(function(data) {
								if (data == 1) {
									var Tipo = 'R';
									swal("Enviado correctamente", "El alumno  se ha enviado correctamente para su reincorporación.", "success");
									var IdCampus = document.getElementById("txtCampus").value;
									$.ajax({
										url: "formConsulta/addReincorporacion.php",
										method: "POST",
										data: {
											IdCampus: IdCampus,
											IdUsua: IdUsua,
											IdCiclo: IdCiclo,
											Tipo:Tipo
										},
										success: function(data) {
											$('#employee_detailIni').html(data);
											$('#dataModalIni').modal('show');
										}
									});

								}
								if (data == 2) {
									swal("Error al reincorporar", "El alumno ya se encuentra en proceso de reincorporación en este periodo escolar seleccionado.", "info");
								}
							})
							.error(function(data) {
								swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
							});

					}
				});
		}

		function new_seguimi_reincor(IdAdmin, Tipo) {
			var IdCiclo = document.getElementById("txt_id_ciclo_new").value;
			var IdGrupo = document.getElementById("txt_id_grupo_new").value;
			var Nota = document.getElementById("txt_comen_seg_new").value;
			var Nombre = document.getElementById("txt_nombre_new").value;
			var Paterno = document.getElementById("txt_paterno_new").value;
			var Materno = document.getElementById("txt_materno_new").value;
			var Celular = document.getElementById("txt_celular_new").value;
			var Correo = document.getElementById("txt_correo_new").value;
			var TipoGuardar = "new_reincorpora_user";
			if (IdCiclo == '') {
				swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
				document.getElementById("txt_id_ciclo").focus();
				return 0;
			}
			if (IdGrupo == '') {
				swal("Error al guardar", "Debe seleccionar el grupo.", "error");
				document.getElementById("txt_id_grupo").focus();
				return 0;
			}
			if (Nombre == '') {
				swal("Error al guardar", "Debe escribir el nombre del alumno.", "error");
				document.getElementById("txt_nombre_new").focus();
				return 0;
			}
			if (Paterno == '') {
				swal("Error al guardar", "Debe escribir el apellido paterno.", "error");
				document.getElementById("txt_paterno_new").focus();
				return 0;
			}
			if (Nota == '') {
				swal("Error al guardar", "Debe escribir las observaciones del seguimiento.", "error");
				document.getElementById("txt_comen_seg_new").focus();
				return 0;
			}

			swal({
					title: "\u00BFEst\u00E1 seguro que desea agregar este alumno para seguimiento de reincorporación?",
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
									Nombre: Nombre,
									Paterno: Paterno,
									Materno: Materno,
									Celular: Celular,
									Correo: Correo,
									IdCiclo: IdCiclo,
									IdGrupo: IdGrupo,
									Nota: Nota,
									IdAdmin: IdAdmin,
									Tipo:Tipo
								},
								success: function(data) {

								}
							})
							.done(function(data) {
								if (data == 1) {
									swal("Enviado correctamente", "El alumno  se ha enviado correctamente para su reincorporación.", "success");
									var IdCiclo = document.getElementById("txt_id_ciclo_new").value;
									$.ajax({
										url: "formConsulta/addReincorporacion_new.php",
										method: "POST",
										data: {
											IdCiclo: IdCiclo,
											Tipo:Tipo
										},
										success: function(data) {
											$('#employee_detailIni').html(data);
											$('#dataModalIni').modal('show');
										}
									});

								}
								if (data == 2) {
									swal("Error al reincorporar", "El alumno ya se encuentra en proceso de reincorporación en este periodo escolar seleccionado.", "info");
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