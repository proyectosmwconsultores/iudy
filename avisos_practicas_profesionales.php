<?php $valor = 3;
$section = "Avisos práctica profesional";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de avisos, practicas profesionales.');
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
					<i class="fa fa-fw fa-bell"></i> Pr&aacute;cticas profesionales
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
						<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Captura de nuevo aviso para Prácticas Profesionales</h4>
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
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Actualizar datos del aviso de  la  Práctica Profesional</h4>
					</div>
					<div class="modal-body" id="employee_detailA">

					</div>
				</div>
			</div>
		</div>

		<div id="dataModal_7" class="modal fade bs-example-modal-lg">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-folder-open-o"></i> Detalle de vistas del aviso de Prácticas Profesionales</h4>
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
			$(Capa).load("vistas/practicas/reporte_avisos_capturados.php", {}, function(response, status, xhr) {
				if (status == "error") {
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
			});
		} 

		function crea_aviso(IdUsua) {
			$.ajax({
				url: "vistas/practicas/captura_aviso.php",
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
				url: "vistas/practicas/actualizar_aviso.php",
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

		function ver_avance_reporte(IdAviso) {
			$.ajax({
				url: "vistas/practicas/lista_avisos_visto.php",
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
								url: "vistas/practicas/sav_desarrollo.php",
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
	</script>

</body>

</html>