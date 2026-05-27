<?php $section = "Recursos";
$_v = 95;
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de recursos');
}
if ($_SESSION['Permisos']) {


	if (isset($_POST["Mov"]) && $_POST["Mov"] == "Guardar") {
		$t->add_RecusosA();
		exit;
	}


	$AsignacionId = $t->get_datosModuloD($_GET["idToks"]);
	$recursosA = $t->get_recursosApoyo($_GET["idToks"]);


	$t->get_validar_mat_doc($_GET["idToks"], $_SESSION['IdUsua']);
	if ($AsignacionId[0]["NombreMod"]) {
?>
		<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
		<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
		<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

		<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
			<div class="wrapper">
				<?php include("menuV.php"); ?>
				<div class="content-wrapper">
					<?php if ($_SESSION['EstatusAsig'] == "F") {
						include("formConsulta/alerta.php");
					} ?>
					<!-- Content Header (Page header) -->
					<section class="content-header">
						<h1>
							<?php echo $AsignacionId[0]["NombreMod"]; ?>
						</h1>
						<ol class="breadcrumb">
							<li><a href="#"><i class="fa fa-dashboard"></i><?php echo substr($AsignacionId[0]["NombreMod"], 0, 40) . ' [...]'; ?></a></li>
							<li class="active"><a href="#">Material didáctico</a></li>
						</ol>
					</section>
					<section class="content">
						<input type="hidden" name="asig" id="asig" value="<?php echo $_GET["idToks"]; ?>">
						<div class="row">
							<div class="col-md-12">
								<p style="text-align: center; display: none;" id="img_cargar_0">
									<img src="assets/images/cargando.gif">
								</p>
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li class="active"><a style="cursor: pointer;" onclick="ver_material_didactico()" href="#activity" data-toggle="tab"><i class="fa fa-fw fa-folder-open-o"></i> Material didáctico</a></li>
										<?php if ($_SESSION['EstatusAsig'] == "A") { ?>
											<li><a style="cursor: pointer;" onclick="subir_material_didactico()" href="#settings" data-toggle="tab"><i class="fa fa-fw fa-edit"></i> Agregar</a></li>
											<li><a style="cursor: pointer;" onclick="mi_repositorio()" href="#repositorio" data-toggle="tab"><i class="fa fa-fw fa-files-o"></i> Mi repositorio de archivos</a></li>
										<?php } ?>

									</ul>
									<div class="tab-content">
										<div class="active tab-pane" id="activity">
											<p style="text-align: center; display: none;" id="img_cargar_1">
												<img src="assets/images/cargando.gif">
											</p>
											<div id="lista_material_didactico"> </div>
										</div>


										<div class="tab-pane" id="settings">
											<p style="text-align: center; display: none;" id="img_cargar_2">
												<img src="assets/images/cargando.gif">
											</p>
											<div id="subir_material_didactico"> </div>


										</div>

										<div class="tab-pane" id="repositorio">
											<p style="text-align: center; display: none;" id="img_cargar_3">
												<img src="assets/images/cargando.gif">
											</p>
											<div id="mi_repositorio"> </div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body" id="employee_detail">
								</div>
							</div>
						</div>
					</div>
					<div id="dataBli" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background: #5a284f; color: #fbeb00; font-size: 16px;">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><i class="fa fa-fw fa-caret-square-o-right"></i> <b id='lbl_bib'></b></h4>
								</div>
								<div class="modal-body" id="employee_bli">
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php include("footer.php"); ?>
			</div>
		</body>
		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2 -->
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
		<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
		<!-- date-range-picker -->
		<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
		<!-- bootstrap datepicker -->
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<!-- bootstrap color picker -->
		<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
		<!-- bootstrap time picker -->
		<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
		<script>
			$(document).ready(function() {
				ver_material_didactico();
			})

			function ver_material_didactico() {
				var idToks = document.getElementById("asig").value;
				document.getElementById("img_cargar_0").style.display = 'block';
				document.getElementById("lista_material_didactico").style.display = 'none';
				var Capa = "#lista_material_didactico";
				$(Capa).load("docente/lista_materia_didactico.php", {
					idToks: idToks
				}, function(response, status, xhr) {
					if (status == "error") {
						var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
						$(Capa).html(msg + xhr.status + " " + xhr.statusText);
					}
					if (status == "success") {
						document.getElementById("lista_material_didactico").style.display = 'block';
						document.getElementById("img_cargar_0").style.display = 'none';
					}
				});
			}

			function subir_material_didactico() {
				var idToks = document.getElementById("asig").value;
				document.getElementById("img_cargar_2").style.display = 'block';
				document.getElementById("subir_material_didactico").style.display = 'none';
				var Capa = "#subir_material_didactico";
				$(Capa).load("docente/subir_materia_didactico.php", {
					idToks: idToks
				}, function(response, status, xhr) {
					if (status == "error") {
						var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
						$(Capa).html(msg + xhr.status + " " + xhr.statusText);
					}
					if (status == "success") {
						document.getElementById("subir_material_didactico").style.display = 'block';
						document.getElementById("img_cargar_2").style.display = 'none';
					}
				});
			}

			function mi_repositorio() {
				var idToks = document.getElementById("asig").value;
				document.getElementById("img_cargar_3").style.display = 'block';
				document.getElementById("mi_repositorio").style.display = 'none';
				var Capa = "#mi_repositorio";
				$(Capa).load("docente/mi_repositorio.php", {
					idToks: idToks
				}, function(response, status, xhr) {
					if (status == "error") {
						var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
						$(Capa).html(msg + xhr.status + " " + xhr.statusText);
					}
					if (status == "success") {
						document.getElementById("mi_repositorio").style.display = 'block';
						document.getElementById("img_cargar_3").style.display = 'none';
					}
				});
			}


			function verBiblioteca(IdBiblioteca) {
				$.ajax({
					url: "formConsulta/verDocumento.php",
					method: "POST",
					data: {
						IdBiblioteca: IdBiblioteca
					},
					success: function(data) {
						$('#employee_bli').html(data);
						$('#dataBli').modal('show');
					}
				});
			}

			$(document).ready(function() {
				$(document).on('click', '.view_data', function() {
					var Id = document.getElementById("Id").value;
					var employee_id = $(this).attr("id");
					if (employee_id != '') {
						$.ajax({
							url: "formConsulta/viewVideo.php",
							method: "POST",
							data: {
								employee_id: employee_id,
								Id: Id
							},
							success: function(data) {
								$('#employee_detail').html(data);
								$('#dataModal').modal('show');
							}
						});
					}
				});
			});


			function val_recursoApoyo(Id) {
				swal({
						title: "\u00BFEst\u00E1 seguro que desea eliminar este material didáctico?",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'Aceptar',
						cancelButtonText: "Cancelar",
					},
					function(isConfirm) {
						if (isConfirm) {
							eliminando();
							$(".confirm").attr('disabled', 'disabled');
							$.ajax({
									url: "formConsulta/delRecurso.php",
									method: "POST",
									data: {
										Id: Id
									},
									success: function(data) {

									}
								})
								.done(function(data) {
									if (data == 1) {
										ver_material_didactico();
										swal("Eliminado correctamente", "El material didáctico se ha eliminado correctamente.", "success");
									}
									if (data == 0) {
										swal("Error al eliminar", "No se ha podido eliminar, favor de intentarlo más tarde.", "error");
									}
								})

								.error(function(e) {
									swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
								});

						}

					});
			}

			function copiar_recurso(Id, IdAsignacion) {
				var Tabla = "L-" + Id;
				$.ajax({
					url: "formConsulta/copiarRecurso.php",
					method: "POST",
					data: {
						Id: Id,
						IdAsignacion: IdAsignacion
					},
					success: function(data) {
						if (data == 1) {
							document.getElementById(Tabla).style.display = 'none';
							swal("Copiado correctamente", "El recurso de apoyo se ha copiado correctamente.", "success");
						} else {
							swal("Error al copiar", "No se pudo copiar el recurso de apoyo.", "error");
						}
					}
				});
			}

			function loading() {
				swal({
					title: "Subiendo archivo...",
					text: "Por favor espere.",
					imageUrl: "https://api.valida-curp.com.mx/panel/images/gears.gif",
					allowEscapeKey: false,    // Evita cerrar la alerta con la tecla Esc
					allowOutsideClick: false, // Evita cerrar la alerta haciendo clic fuera de ella
					showConfirmButton: false  // Oculta el botón de confirmación
				});
			}

			function eliminando() {
				swal({
					title: "Eliminando archivo...",
					text: "Se esta procesando la eliminación del archivo",
					imageUrl: "https://api.valida-curp.com.mx/panel/images/gears.gif",
					allowEscapeKey: false,    // Evita cerrar la alerta con la tecla Esc
					allowOutsideClick: false, // Evita cerrar la alerta haciendo clic fuera de ella
					showConfirmButton: false  // Oculta el botón de confirmación
				});
			}

			function upload_recurso_id() {
				var Tipo = document.getElementById("Tipo").value;
				var Nombre = document.getElementById("txtNombre").value;
				var TipoDoc = document.getElementById("txtTipoDoc").value;
				var Archivo = document.getElementById("archivo").value;
				var Video = document.getElementById("txtVideo").value;
				var IdToks = document.getElementById("asig").value;
				var IdActividad = document.getElementById("txtIdActividad").value;
				var Imagen = '#archivo';
				if (Nombre == "") {
					swal("Error al guardar", "Debe escribir el nombre.", "error");
					document.getElementById("txtNombre").focus();
					return 0;
				}
				if (TipoDoc == "") {
					swal("Error al guardar", "Debe seleccionar el tipo de documento.", "error");
					document.getElementById("txtTipoDoc").focus();
					return 0;
				}
				if (Tipo == 0) {
					if (archivo == "") {
						swal("Error al guardar", "Debe seleccionar el archivo.", "error");
						document.getElementById("archivo").focus();
						return 0;
					}
				} else {
					if (Video == "") {
						swal("Error al guardar", "Debe pegar el iframe del video de YouTube.", "error");
						document.getElementById("txtVideo").focus();
						return 0;
					}
				}

				swal({
						title: "\u00BFEst\u00E1 seguro que desea guardar esta evidencia de esta actividad?",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'Aceptar',
						cancelButtonText: "Cancelar",
					},
					function(isConfirm) {
						loading();

						if (isConfirm) {
							$(".confirm").attr('disabled', 'disabled');

							var formData = new FormData();
							var files = $(Imagen)[0].files[0];
							formData.append('Tipo', Tipo);
							formData.append('Nombre', Nombre);
							formData.append('TipoDoc', TipoDoc);
							formData.append('Video', Video);
							formData.append('IdToks', IdToks);
							formData.append('IdActividad', IdActividad);
							formData.append('file', files);

							$.ajax({
									url: 'upload_biblioteca.php',
									type: 'post',
									data: formData,
									contentType: false,
									processData: false,
									success: function(response) {
										// alert(response);
										if (response == 1) {
											// hideUploadingIndicator();
										}
									}

								})
								.done(function(response) {
									if (response == 1) {
										swal("Guardado correctamente", "El material didáctico se ha guardado correctamente.", "success");
										subir_material_didactico();
									}
									if (response == 2) {
										swal("Error al subir", "El archivo excede el tamaño máximo permitido de 50 MB.", "error");
									}
									if (response == 4) {
										swal("Error al guardar", "El porcentaje no puede ser mayor al 100%, revise que porcentaje de avance lleva actualmente.", "error");
									}
									if (response == 0) {
										swal("Error al guardar", "Ha ocurrido un error no se ha podido subir el archivo.", "error");
									}
								})
								.error(function(data) {
									swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
								});


						} else {
							document.getElementById("frm").reset();
						}
					});
				// hideUploadingIndicator();

			}

			function showUploadingIndicator() {

				const carga = document.getElementById('uploading-indicator');
				carga.style.display = 'flex';
				console.log(carga);
			}

			function hideUploadingIndicator() {
				console.log('se ejecuto hideUploadingIndicator');
				document.getElementById('uploading-indicator').style.display = 'none';
			}
		</script>
		</body>

		</html>
<?php
	} else {
		echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
	}
} else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>