<?php $valor = 3;
$section = "Avisos servicio social";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de avisos, servicio social.');
}
?>

<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-bell"></i> Servicio social
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Configurar</a></li>
					<li class="active">Avisos</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<div class="row">
							<form name="frm" id="frm" action="captura_gastos.php" method="POST" enctype="multipart/form-data">
								<!-- <div class="col-md-5">
									<div class="box-primary">
										<div class="box-body">
											<a class="btn btn-app" href="javascript:void(0);" onclick="captura_aviso(<?php echo $_SESSION['IdUsua']; ?>)" title="Captura de un nuevo aviso">
												<i class="fa fa-tags"></i> Captura de aviso
											</a>
										</div>
									</div>
								</div> -->
								<div class="col-xs-12">
									<div class="box" id="panel_ultimos_gastos"></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>


		<div id="dataModalC" class="modal fade bs-example-modal-lg">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Captura de nuevo aviso para servicio social</h4>
					</div>
					<div class="modal-body" id="employee_detailC">

					</div>
				</div>
			</div>
		</div>

		<div id="dataModalA" class="modal fade bs-example-modal-lg">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Actualizar datos del aviso del servicio social</h4>
					</div>
					<div class="modal-body" id="employee_detailA">

					</div>
				</div>
			</div>
		</div>

		<div id="dataModalD" class="modal fade bs-example-modal-lg">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Documentos del servicio social</h4>
					</div>
					<div class="modal-body" id="employee_detailD">

					</div>
				</div>
			</div>
		</div>

		<div id="dataModal_7" class="modal fade bs-example-modal-lg">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-folder-open-o"></i> Detalle de vistas del aviso del servicio social</h4>
					</div>
					<div class="modal-body" id="employee_detail_7">

					</div>
				</div>
			</div>
		</div>


		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>-->
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
		<?php include("footer.php"); ?>
	</div>

	<!-- jQuery 3 -->

	<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- Page script -->
	<script>
		$(function() {
			cargar_ultimo_gasto();
			//$('.select2').select2()

			$('#txtFecIni').datepicker({
				autoclose: true
			})

			$('#txtFecFin').datepicker({
				autoclose: true
			})

		})


		function cargar_ultimo_gasto() {
			document.getElementById("panel_ultimos_gastos").style.display = 'none';
			document.getElementById("panel_ultimos_gastos").style.display = 'block';
			var Capa = "#panel_ultimos_gastos";
			$(Capa).load("vistas/servicio/reporte_avisos_capturados.php", {}, function(response, status, xhr) {
				if (status == "error") {
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
			});
		}

		function crea_aviso(IdUsua) {
			$.ajax({
				url: "vistas/servicio/captura_aviso.php",
				method: "POST",
				data: {
					IdUsua: IdUsua
				},
				success: function(data) {
					$('#employee_detailC').html(data);
					$('#dataModalC').modal('show');
				}
			});
		}

		function configurar_aviso(IdAviso) {
			$.ajax({
				url: "vistas/servicio/actualizar_aviso.php",
				method: "POST",
				data: {
					IdAviso: IdAviso
				},
				success: function(data) {
					$('#employee_detailA').html(data);
					$('#dataModalA').modal('show');
				}
			});
		}

		function configurar_documentos(IdAviso) {
			$.ajax({
				url: "vistas/servicio/documentos_servicio_social.php",
				method: "POST",
				data: {
					IdAviso: IdAviso
				},
				success: function(data) {
					$('#employee_detailD').html(data);
					$('#dataModalD').modal('show');
				}
			});
		}

		function ver_avance_reporte(IdAviso) {
			$.ajax({
				url: "vistas/servicio/lista_avisos_visto.php",
				method: "POST",
				data: {
					IdAviso: IdAviso
				},
				success: function(data) {
					$('#employee_detail_7').html(data);
					$('#dataModal_7').modal('show');
				}
			});
		}

		function del_aviso_id(IdAviso) {
			var TipoGuardar = 'del_aviso_idok';
			swal({
					title: "\u00BFEst\u00E1 seguro que desea eliminar este aviso?",
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
								type: "POST",
								url: "vistas/servicio/sav_desarrollo.php",
								data: {
									TipoGuardar: TipoGuardar,
									IdAviso: IdAviso
								},
								success: function(data) {

								}
							})
							.done(function(data) {
								if (data == 1) {
									swal("Eliminado correctamente", "El aviso se ha eliminado correctamente.", "success");
									cargar_ultimo_gasto();
								} else {
									swal("Error al eliminar", "El aviso no se ha podido eliminar.", "error");
								}
							})
							.error(function(data) {
								swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
							});
					} else {
						document.getElementById("frm").reset();
					}
				});
		}

		function del_documento_ss(IdAviso, IdDocs) {
			var TipoGuardar = 'del_documento_ss_id';
			swal({
					title: "\u00BFEst\u00E1 seguro que desea eliminar este documento?",
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
								type: "POST",
								url: "vistas/servicio/sav_desarrollo.php",
								data: {
									TipoGuardar: TipoGuardar,
									IdAviso: IdAviso, IdDocs:IdDocs
								},
								success: function(data) {

								}
							})
							.done(function(data) {
								if (data == 1) {
									swal("Eliminado correctamente", "El documento se ha eliminado correctamente.", "success");
									$.ajax({
										url: "vistas/servicio/documentos_servicio_social.php",
										method: "POST",
										data: {
											IdAviso: IdAviso
										},
										success: function(data) {
											$('#employee_detailD').html(data);
											$('#dataModalD').modal('show');
										}
									});
								} else {
									swal("Error al eliminar", "El documento no se ha podido eliminar.", "error");
								}
							})
							.error(function(data) {
								swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
							});
					} else {
						document.getElementById("frm").reset();
					}
				});
		}

		function subir_archivo_ss(IdAviso, Tipo) {
			var Archivo = "";
			if(Tipo == 1){
				var Archivo = document.getElementById("txt_archivo1").value;
				var Imagen = '#txt_archivo1';
			}
			if(Tipo == 2){
				var Archivo = document.getElementById("txt_archivo2").value;
				var Imagen = '#txt_archivo2';
			}
			if(Tipo == 3){
				var Archivo = document.getElementById("txt_archivo3").value;
				var Imagen = '#txt_archivo3';
			}
			if(Tipo == 4){
				var Archivo = document.getElementById("txt_archivo4").value;
				var Imagen = '#txt_archivo4';
			}
			

			if (Archivo == "") {
			swal("Error al guardar", "Debe seleccionar el archivo que sea subir.", "error");
			return 0;
			}

			swal({
				title: "\u00BFEst\u00E1 seguro que desea guardar este archivo?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
				cancelButtonText: "Cancelar",
			},
			function(isConfirm) {
				if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');

				var formData = new FormData();
				var files = $(Imagen)[0].files[0];
				formData.append('IdAviso', IdAviso);
				formData.append('Tipo', Tipo);
				formData.append('file', files);

				$.ajax({
					url: 'upload_servicio_social_docs.php',
					type: 'post',
					data: formData,
					contentType: false,
					processData: false,
					success: function(response) {

					}
					})
					.done(function(response) {
					if (response == 1) {
						swal("Guardado correctamente", "El documento se ha guardado correctamente.", "success");
						$.ajax({
						url: "vistas/servicio/documentos_servicio_social.php",
						method: "POST",
						data: {
							IdAviso: IdAviso
						},
						success: function(data) {
							$('#employee_detailD').html(data);
							$('#dataModalD').modal('show');
						}
						});
					}
					if (response == 0) {
						swal("Error al guardar", "Favor de verificar el archivo que esta subiendo.", "error");
					}
					})
					.error(function(data) {
					swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
					});


				}
			});
		}
	</script>

</body>

</html>