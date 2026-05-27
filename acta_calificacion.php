<?php $section = "Acta de calificación lista";
$_v = 93;
include("head.php");
if (($_SESSION["Permisos"] == 3) || ($_SESSION["Permisos"] == 4)) {
	header('Location: php/estructura/destroy.php');
}

if ($_SESSION['Permisos']) {
	$t->get_validar_mat_doc($_GET["idToks"], $_SESSION['IdUsua']);
	$AsignacionId = $t->get_datosModuloD($_GET["idToks"]);
	$parcial = $t->get_parcialActivo($_GET["idToks"]);
	$nombx = $AsignacionId[0]['NombreMod'];		
	$addIngresos = $t->add_registros($_SESSION['IdUsua'],"Está en el módulo de acta de calificación - $nombx","Lista alumnos","Acta",$_GET["idToks"],0,$AsignacionId[0]["IdModulo"]);

	$Px1 = 0;
	$Px2 = 0;
	$Px3 = 0;
	if ($AsignacionId[0]['Fec_emi_bim1']) {
		$Px1 = 1;
	}
	if ($AsignacionId[0]['Fec_emi_bim2']) {
		$Px2 = 1;
	}
	if ($AsignacionId[0]['Fec_emi_bim3']) {
		$Px3 = 1;
	}
	
?>
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

	<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
		<div class="wrapper">
			<?php include("menuV.php"); ?>
			<div class="content-wrapper">
				<?php if ($_SESSION['EstatusAsig'] == "F") {
					include("formConsulta/alerta.php");
				} ?>
				<section class="content-header">
					<h1> <?php echo $AsignacionId[0]["NombreMod"]; ?></h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Acta</a></li>
						<li class="active"><a href="#">Acta de calificación</a></li>
					</ol>
				</section>
				<section class="content">
					<?php if (!isset($AsignacionId[0]['Fecha_impresion'])) { ?>
						<div class="row">
							<input id="IdAsignacionx" name="IdAsignacionx" value="<?php echo $_GET["idToks"]; ?>" type="hidden" />
							<?php
							$par = 0;
							for ($i = 0; $i < sizeof($parcial); $i++) {
								$par = $par + 1; ?>
								<div class="col-md-3">
									<div style="cursor: <?php if ($parcial[$i]['IdEstatus'] == 4) {
															echo 'pointer';
														} else {
															echo 'not-allowed';
														} ?>" title="Cargar calificaciones" class="info-box bg-<?php if ($parcial[$i]["IdEstatus"] == 4) {
																																																			echo "purple";
																																																		} else {
																																																			echo "red";
																																																		} ?>" <?php if ($parcial[$i]["IdEstatus"] == 4) { ?>onclick="cargarCal(<?php echo $parcial[$i]["IdParcialDocente"]; ?>,<?php echo $par; ?>)" <?php } ?>>
										<span class="info-box-icon"><i class="fa fa-calendar-check-o"></i></span>
										<div class="info-box-content">
											<span class="info-box-text"><?php echo $parcial[$i]["Titulo"]; ?></span>
											<span class="info-box-number"><?php if ($parcial[$i]["IdEstatus"] == 4) {
																				echo "Activo";
																			} else {
																				echo "Completado";
																			} ?></span>
											<div class="progress">
												<div class="progress-bar" style="width: <?php if ($parcial[$i]['IdEstatus'] == 4) {
																							echo '25';
																						} else {
																							echo '100';
																						} ?>%"></div>
											</div>
											<span class="progress-description">
												Cargar calificaciones
											</span>
										</div>
									</div>
								</div>
							<?php } ?>
						</div><?php } ?>
					<div class="row">
						<form name="frm" id="frm" action="acta_calificacion.php" method="POST" enctype="multipart/form-data">
							<input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_GET["idToks"]; ?>" type="hidden" />
							<div class="col-md-12">
								<div class="box" id="miTablaEvaluacion"> </div>
							</div>
						</form>
					</div>
			</div>
			</section>
		</div>
		<div id="dataFondo" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-file-image-o"></i> Subir acta de calificación escaneado</h4>
					</div>
					<div class="modal-body" id="employee_fondo">
					</div>
				</div>
			</div>
		</div>
		<?php include("footer.php"); ?>
		</div>
		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>

		<script>
			$(document).ready(function() {
				var IdAsignacion = document.getElementById("IdAsignacion").value;

				cargar_calificacionx(IdAsignacion);

			});

			function cargar_calificacionx(IdAsignacion) {
				var Capa = "#miTablaEvaluacion";

				$(Capa).load("formConsulta/captura_calificacion_final.php", {
					IdAsignacion: IdAsignacion
				}, function(response, status, xhr) {
					if (status == "error") {
						var msg = "Error!, algo ha sucedido: ";
						$(Capa).html(msg + xhr.status + " " + xhr.statusText);
					}
				});
			}

			function cargar_mi_acta() {
				var IdAsignacion = document.getElementById("IdAsignacion").value;
				$.ajax({
					url: "formConsulta/addActa.php",
					method: "POST",
					data: {
						IdAsignacion: IdAsignacion
					},
					success: function(data) {
						$('#employee_fondo').html(data);
						$('#dataFondo').modal('show');
					}
				});
			}

			function cargarCal(IdParcialDoc, NoParcial) {
				var IdAsignacion = document.getElementById("IdAsignacion").value;
				var TipoGuardar = "cargarCali";
				swal({
						title: "\u00BFEst\u00E1 seguro que desea cargar calificaciones?",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'Aceptar',
						cancelButtonText: "Cancelar",
						//closeOnConfirm: false,
						//closeOnCancel: false
					},
					function(isConfirm) {
						if (isConfirm) {
							$(".confirm").attr('disabled', 'disabled');

							$.ajax({
								url: "formConsulta/setting.php",
								method: "POST",
								data: {
									TipoGuardar: TipoGuardar,
									IdAsignacion: IdAsignacion,
									IdParcialDoc: IdParcialDoc,
									NoParcial: NoParcial
								},
								success: function(data) {
									// alert(data);
									
									// valirdar_calificacion(IdAsignacion, NoParcial);
									if (data == 1) {
										swal("Cargado correctamente", "Calificaciones cargadas correctamente.", "success");
										parent.location.href = 'acta_calificacion.php?idToks=' + IdAsignacion;
									}
								}
							})

							return true;
						} else {
							return false;
						}
					});
			}


			function valirdar_calificacion(IdAsignacion, NoParcial) {
				var TipoGuardar = "validar_calificacion_final";

				$.ajax({
					url: "formConsulta/setting.php",
					method: "POST",
					data: {
						TipoGuardar: TipoGuardar,
						IdAsignacion: IdAsignacion,
						NoParcial: NoParcial
					},
					success: function(data) { alert(data);
						if (data == 1) {
							//swal("Guardado correctamentfffe", "Calificaci\u00F3n guardada correctamente.", "success");
							//cargar_calificacionx(IdAsignacion);
							// parent.location.href='doSelActa.php';
						}
					}
				})
			}
		</script>
	</body>

	</html>
<?php


} else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>