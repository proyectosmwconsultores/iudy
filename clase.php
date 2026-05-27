<?php $_v = 31;
$section = "Bienvenidos";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Esta en la pagina principal');

	unset($_SESSION['IdAsignacion']);
	unset($_SESSION['IdOferta']);
	unset($_SESSION['IdModulo']);
	unset($_SESSION['EstatusAsig']);
	// $checarEstatus=$t->get_checarEstatus();

	if ($_SESSION["Permisos"] == 3) {
		$pendIns = $espacio->get_proceso_inscripcion_id($_SESSION['IdUsua']);
		$avisosPublico = $espacio->get_avisos_publico();

		$_evx = 0;
		$avis = $espacio->get_chkAvisos($_SESSION['IdGrupo']);
		$pagP = $espacio->get_chkEncuenta($_SESSION['IdUsua']);
		$docs_pend = $espacio->get_chk_docs_pen($_SESSION['IdUsua'], $infoPerfil[0]['IdOferta']);
		$avis_war = $espacio->get_mis_avisos_id($_SESSION['IdUsua']);
		$adeudo = $espacio->get_chk_pagos_pendientes($_SESSION['IdUsua']);
		$pract_pro = $espacio->get_mis_avisos_practica_id($_SESSION['IdUsua']);

		$servicio = $espacio->get_mis_avisos_servicio_id($_SESSION['IdUsua']);
		$trayectoria = $espacio->get_trayectoria_id($_SESSION['IdUsua']);
		$fac_pend = $t->get_factura_pend_id($_SESSION['IdUsua']);

		$servicio_pendiente = $espacio->get_servicio_social_pendiente($_SESSION['IdUsua']);

		if ($pagP) {
			$_evx = 1;
			$_hoy = date("Y-m-d");
			if ($_hoy > $pagP[0]['FecFin']) {
				header('Location: viewEvaluacion.php');
				exit();
			}
		}
	}

?>

	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

	<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
		<div class="wrapper">
			<?php include("menuV.php"); ?>
			<div class="content-wrapper">
				<?php if ($_SESSION['IdEstatus'] == 50) {
					include("formConsulta/msjEstatus.php");
				} ?>
				<section class="content-header">
					<h1><?php echo $configuracion[1]['Descripcion']; ?></h1><br>
					<div class="row">
						<div class="col-md-12">
							<?php if (isset($docs_pend[0])) { ?>
								<div class="alert alert-info alert-dismissible">
									<h4 style="color: black;"><i class="icon fa fa-warning"></i> Documentación pendiente</h4>
									<p style="text-align: justify; font-size: 16px; color: black;">
										Hola <b><?php echo $infoPerfil[0]['Alumno']; ?>,</b> te informamos que tienes la siguiente documentación pendiente en la plataforma:
									</p>
									<blockquote>
										<?php for ($v = 0; $v < sizeof($docs_pend); $v++) { ?>
										<small style="color: black;"><?php echo $docs_pend[$v]['Nombre']; ?></small>
										<?php } ?>
									</blockquote>
									<div class="btn-group" style="float: right; margin-right: -35px;">
										<button onClick="window.open('misDocumentos.php','_self')" href="javascript:void(0);" type="button" class="btn bg-orange btn-flat pull-right"><i class="fa fa-fw fa-send"></i> Subir documentos </button>
									</div><br>
								</div>
							<?php } ?>



							<?php if (isset($servicio_pendiente[0])) { ?>
								<div class="alert alert-danger alert-dismissible">
									<h4><i class="icon fa fa-warning"></i> ¡Último día!</h4>
									<p style="text-align: center; font-size: 16px">
										Hola <b><?php echo $infoPerfil[0]['Alumno']; ?>,</b> <b>No haz terminado tu registro para el Servicio Social.</b> Hoy <b>28 de julio de 2025 </b> es el último día para completar tu registro a la <b>2da. Convocatoria 2025 (septiembre 2025 - febrero 2026)</b>.
									</p>
									<div class="btn-group" style="float: right; margin-right: -35px;">
										<button onClick="window.open('miServicio.php','_self')" href="javascript:void(0);" type="button" class="btn bg-orange btn-flat pull-right"><i class="fa fa-fw fa-send"></i> Ir al módulo </button>
									</div><br>
									<p style="text-align: center;"><img src="assets/images/gif/atrasado.gif" style="width: 150px;"></p>
								</div>
							<?php } ?>
						</div>

						<?php if (isset($fac_pend[0])) { ?>
							<div class="col-md-12">
								<div class="box-body">
									<input type="hidden" name="txt_fechax" id="txt_fechax" value="<?php echo date("Y-m-d"); ?>">
									<table class="table table-striped" style="font-size: 12px;">
										<tbody>
											<tr style="background: #c1c5ffc4;">
												<th colspan="5"><i class="fa fa-fw fa-bell"></i> Factura disponible para generar </th>
											</tr>
											<tr>
												<td class="text-blue"></td>
												<td class="text-blue">Folio</td>
												<td class="text-blue">Fecha pago</td>
												<td class="text-blue">Fecha cap.</td>
												<td class="text-blue">Monto</td>
											</tr>
											<?php $kx = 0;
											for ($f = 0; $f < sizeof($fac_pend); $f++) { ?>
												<tr>
													<td style="width: 95px;">
														<button onclick="procesar_factura_id(<?php echo $fac_pend[$f]['IdUsua']; ?>,'<?php echo $fac_pend[$f]['NoFolio'] ?>',<?php echo $fac_pend[$f]['Monto']; ?>,<?php echo $fac_pend[$f]['c_FormaPago']; ?>,<?php echo 1; ?>)" type="button" title="Generar factura" class="btn bg-orange btn-flat btn-sm"><i class="fa fa-check-circle"></i> GENERAR MI FACTURA</button>
													</td>
													<td><?php echo $fac_pend[$f]["NoFolio"]; ?></td>
													<td><?php echo $fac_pend[$f]["FecPago"]; ?></td>
													<td><?php echo $fac_pend[$f]["FecCap"]; ?></td>
													<td>$ <?php echo number_format($fac_pend[$f]["Monto"], 2, '.', ','); ?></td>
												</tr>
											<?php  }  ?>
										</tbody>
									</table>
								</div>
							</div><?php } ?>



						<div class="col-md-8">




							<?php if (isset($_GET['toks']) && ($_GET['toks'] == 9)) { ?>
								<div class="bg-red-active color-palette" style="padding: 10px; "><span style="color: yellow;"><i class="fa fa-fw fa-warning"></i> Nota: ha ingresado a una página no disponible.</span></div>
								<br><?php } ?>

							<?php if ((isset($pendIns[0]['Valor'])) && ($pendIns[0]['Valor'] == 4)) { ?>
								<div class="alert alert-danger alert-dismissible">
									<h4><i class="icon fa fa-warning"></i> ¡Aviso importante!</h4>
									<p style="text-align: center; font-size: 16px">
										Hola <b><?php echo $infoPerfil[0]['Alumno']; ?>,</b> para poder inscribirse al nuevo periodo escolar, favor de comunicarte con tu <b>Coordinador Académico.</b>
									</p>
								</div> <?php } ?>
							<?php if ($_evx == 1) { ?>
								<div class="alert alert-info alert-dismissible">
									<h4><i class="icon fa fa-warning"></i> ¡Aviso importante!</h4>
									<p style="text-align: center;">
										Debe de ir al módulo de <b onClick="window.open('viewEvaluacion.php','_self')" href="javascript:void(0);">Evaluación docente</b> para evaluar la materia que acaba de finalizar. <button onClick="window.open('viewEvaluacion.php','_self')" href="javascript:void(0);" type="button" class="btn bg-orange btn-flat margin"><i class="fa fa-fw fa-pencil-square"></i> Ir al módulo</button>
									</p>
								</div> <?php } ?>

							<?php if (isset($pract_pro[0])) { ?>
								<div class="alert alert-warning alert-dismissible">
									<h4><i class="icon fa fa-flag"></i> <?php echo $pract_pro[0]['Titulo']; ?> <button onClick="window.open('miPractica.php','_self')" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat pull-right"><i class="fa fa-fw fa-check-circle-o"></i> Ir al módulo </button></h4>
									<p>Convocatoria disponible: <?php echo obtenerFechaCorta($pract_pro[0]['Inicio']); ?> al <?php echo obtenerFechaCorta($pract_pro[0]['Final']); ?></p>
								</div>
							<?php } ?>

							<?php if (isset($servicio[0])) { ?>
								<div class="alert alert-info alert-dismissible">
									<h4><i class="icon fa fa-flag"></i> <?php echo $servicio[0]['Titulo']; ?>

									</h4>
									<p>Convocatoria disponible: <?php echo obtenerFechaCorta($servicio[0]['Inicio']); ?> al <?php echo obtenerFechaCorta($servicio[0]['Final']); ?></p>
									<div class="btn-group" style="float: right; margin-right: -35px;">
										<button onClick="window.open('miServicio.php','_self')" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat pull-right"><i class="fa fa-fw fa-check-circle-o"></i> Ir al módulo </button>
										<button onclick="ver_detalle_ss(<?php echo $servicio[0]['IdAviso']; ?>)" href="javascript:void(0);" type="button" class="btn bg-orange btn-flat pull-right"><i class="fa fa-fw fa-eye"></i> Detalle </button>
									</div><br>

								</div>
							<?php } ?>
							<?php if ($infoPerfil[0]['SemCua'] == 1) { ?>
								<div class="alert alert-success alert-dismissible">
									<h4><i class="icon fa fa-check-circle"></i> Facturación <button onclick="datos_factura_id(<?php echo $_SESSION['IdUsua']; ?>)" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat pull-right"><i class="fa fa-fw fa-pencil-square"></i> Datos factura </button></h4>
									<p style="font-size: justify;">
										Si usted desea factura, debera llenar todos los datos según su <b>Constancia de Situación Fiscal</b> y solo se le podrá facturar lo del mes vigente.
									</p>
								</div>
							<?php } ?>

							<?php if ($adeudo[0]['Total'] >= 1) { ?>
								<div class="alert alert-warning alert-dismissible">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<h4><i class="icon fa fa-warning"></i> ¡Pago pendiente!</h4>
									<p style="font-size: justify; color:black">
										Estimado usuario, usted tiene pagos pendientes por realizar, si ya realizo el pago favor de comunicarse al área de finanzas. <button onClick="window.open('misPagos.php','_self')" href="javascript:void(0);" type="button" class="btn bg-primary btn-flat margin"><i class="fa fa-fw fa-pencil-square"></i> Pagos pendientes </button>
									</p>
								</div> <?php } ?>
							<div class="class=" pad"">
								<!-- <img src="assets/images/avisos/slider1.jpg" alt="First slide"> -->
								<!-- <img src="assets/images/campus/iudy_23.png" width="100%"><br><br> -->
							</div>
							<!--
							<div class="box-body">
									<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
										<ol class="carousel-indicators">
											<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
											<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
											<li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
										</ol>
										<div class="carousel-inner">
											<div class="item active">
													<img src="assets/docs/avisos/<?php //echo $avisosPublico[0]['Archivo']; ?>" alt="First slide">
													<div onclick="ver_aviso_id(<?php //echo $avisosPublico[0]['IdAviso']; ?>)" class="carousel-caption" style="font-size: 18px; background: #af00ffa1; cursor: pointer;">
														CLIC PARA VER MÁS INFORMACIÓN
													</div>
												</div>
											<div class="item active">
												<img src="assets/docs/avisos/derechos_humanos.jpg" alt="First slide">
											</div>
										</div>
										<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
											<span class="fa fa-angle-left"></span>
										</a>
										<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
											<span class="fa fa-angle-right"></span>
										</a>
									</div>
								</div>-->



							<?php if (isset($trayectoria[0])) { ?>

								<div class="nav-tabs-custom">
									<div class="box-header with-border">
										<h3 class="box-title">Espacio para poder visualizar mi proceso de titulación.</h3>
									</div>
									<div class="tab-content">
										<div class="tab-pane active" id="timeline">
											<ul class="timeline timeline-inverse">
												<li class="time-label">
													<span class="bg-red">
														Trayectoria estudiantil
													</span>
												</li>
												<?php for ($i = 0; $i < sizeof($trayectoria); $i++) { ?>
													<li>
														<i class="fa fa-envelope bg-blue"></i>
														<div class="timeline-item">
															<span class="time"><i class="fa fa-clock-o"></i> <?php echo tiempo_transcurrido($trayectoria[$i]['FecCap']); ?></span>
															<h3 class="timeline-header"><a href="#"><?php echo $trayectoria[$i]['Trayectoria']; ?></a></h3>
															<div class="timeline-body">
																<?php echo $trayectoria[$i]['Nota']; ?>
															</div>
															<div class="timeline-footer">
																<?php if ($trayectoria[$i]['IdEstatus'] == 12) { ?>
																	<a class="btn btn-danger btn-xs"><i class="fa fa-fw fa-warning"></i> En proceso</a>
																<?php } else { ?>
																	<a class="btn btn-primary btn-xs"><i class="fa fa-fw fa-check-circle"></i> Concluido</a>
																	<?php if (isset($trayectoria[$i]['Archivo'])) { ?>
																		<a onclick="window.open('assets/docs/files/<?php echo $trayectoria[$i]['Anio']; ?>/<?php echo $trayectoria[$i]['Mes']; ?>/<?php echo $trayectoria[$i]['Archivo']; ?>','_blank')" class="btn btn-warning btn-xs"><i class="fa fa-fw fa-share-alt"></i> Evidencia</a>
																	<?php } ?>
																<?php } ?>
															</div>
														</div>
													</li>
												<?php } ?>

												<li>
													<i class="fa fa-clock-o bg-gray"></i>
												</li>
											</ul>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="col-md-4">
						</div>
					</div>
				</section>
			</div>

		</div>
		<?php include("footer.php"); ?>
		</div>
		<!-- ./wrapper -->
		<div id="dataEva" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-info-circle"></i> Datos del aviso</h4>
					</div>
					<div class="modal-body" id="employee_eva">
					</div>
				</div>
			</div>
		</div>
		<div id="dataEvaA" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-info-circle"></i> Datos del aviso generado</h4>
					</div>
					<div class="modal-body" id="employee_evaA">
					</div>
				</div>
			</div>
		</div>
		<div class="welcome-modal">
			<button class="welcome-modal-close">
				<i class="bi bi-x-lg"></i>
			</button>
			<div id="miTablaEvaluacion">

			</div>
		</div>
		<div id="data_facx" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-child"></i> Datos de facturación</h4>
					</div>
					<div class="modal-body" id="employee_facx">
					</div>
				</div>
			</div>
		</div>
		<div id="data_aviso" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-check-circle"></i> Información del aviso</h4>
					</div>
					<div class="modal-body" id="employee_aviso">
					</div>
				</div>
			</div>
		</div>
		<div id="data_ss" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-child"></i> Aviso de servicio social</h4>
					</div>
					<div class="modal-body" id="employee_ss">
					</div>
				</div>
			</div>
		</div>



		<button class="welcome-modal-btn">
			<i class="fa fa-bell"></i> Mis avisos
		</button>

		<!-- js -->
		<script src="vendors/scripts/core.js"></script>
		<script src="vendors/scripts/layout-settings.js"></script>
		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script><!-- Sparkline -->


		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<script src="dist/js/pages/dashboard.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
		<script>
			function mostrarAviso(IdAviso) {
				$.ajax({
					url: "formConsulta/viewAviso.php",
					method: "POST",
					data: {
						IdAviso: IdAviso
					},
					success: function(data) {
						$('#employee_eva').html(data);
						$('#dataEva').modal('show');
					}
				});
			}

			function _mostrar_aviso_id(IdAviso, IdDetalle) {
				$.ajax({
					url: "vistas/admin/viewAviso.php",
					method: "POST",
					data: {
						IdAviso: IdAviso,
						IdDetalle: IdDetalle
					},
					success: function(data) {
						$('#employee_evaA').html(data);
						$('#dataEvaA').modal('show');
					}
				});
			}

			function ver_archivo_aviso(IdAviso, IdDetalle, Archivo) {
				var TipoGuardar = "aviso_visto";

				$.ajax({
					url: "formConsulta/setting.php",
					method: "POST",
					data: {
						TipoGuardar: TipoGuardar,
						IdDetalle: IdDetalle
					},
					success: function(data) {}
				})

				window.open("assets/docs/avisos/" + Archivo, "_blank");

			}

			function check_archivo_aviso(IdAviso, IdDetalle) {
				var TipoGuardar = "aviso_visto_check";

				$.ajax({
					url: "formConsulta/setting.php",
					method: "POST",
					data: {
						TipoGuardar: TipoGuardar,
						IdDetalle: IdDetalle
					},
					success: function(data) {}
				})
				swal("Aviso ocultado", "El aviso ha sido ocultado del panel principal.", "success");
				document.getElementById(IdDetalle).style.display = 'none';
			}

			$(document).ready(function() {
				var IdUsua = document.getElementById("_idUs").value;

				cargar_avisos_id(IdUsua);
			})

			function cargar_avisos_id(IdUsua) {
				var Capa = "#miTablaEvaluacion";

				$(Capa).load("vistas/admin/mostrar_avisos.php", {
					IdUsua: IdUsua
				}, function(response, status, xhr) {
					if (status == "error") {
						var msg = "Error!, algo ha sucedido: ";
						$(Capa).html(msg + xhr.status + " " + xhr.statusText);
					}
				});
			}

			function datos_factura_id(IdUsua) {
				$.ajax({
					url: "vistas/finanzas/datos_factura_id.php",
					method: "POST",
					data: {
						IdUsua: IdUsua
					},
					success: function(data) {
						$('#employee_facx').html(data);
						$('#data_facx').modal('show');
					}
				});
			}

			function ver_detalle_ss(IdAviso) {
				$.ajax({
					url: "formConsulta/ver_detalle_ss.php",
					method: "POST",
					data: {
						IdAviso: IdAviso
					},
					success: function(data) {
						$('#employee_ss').html(data);
						$('#data_ss').modal('show');
					}
				});
			}

			function ver_aviso_id(Id) {
				$.ajax({
					url: "vistas/alumno/ver_aviso_id.php",
					method: "POST",
					data: {
						Id: Id
					},
					success: function(data) {
						$('#employee_aviso').html(data);
						$('#data_aviso').modal('show');
					}
				});
			}

			function procesar_factura_id(IdUsua, NoFolio, Total, Forma, Ubicacion) {
				var Fecha = document.getElementById("txt_fechax").value;

				var TipoGuardar = "process_fact_id";

				swal({
						title: "\u00BFEst\u00E1 seguro que desea generar esta factura?",
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
									url: "vistas/facturar/setting_facturar.php",
									method: "POST",
									data: {
										TipoGuardar: TipoGuardar,
										IdUsua: IdUsua,
										NoFolio: NoFolio,
										Total: Total,
										Forma: Forma,
										Ubicacion: Ubicacion,
										Fecha: Fecha
									},
									success: function(data) { //alert(data);

									}
								})
								.done(function(data) {
									var Valor1 = '';
									var Valor2 = '';
									var porciones = data.split('_');
									Valor1 = porciones[0];
									Valor2 = porciones[1];

									if (Valor1 == 1) {

										swal({
												title: "La factura se ha generado correctamente",
												type: "success",
												showCancelButton: false,
												confirmButtonColor: '#DD6B55',
												confirmButtonText: 'Aceptar',
												//cancelButtonText: "Cancelar",
												//closeOnConfirm: false,
												//closeOnCancel: false
											},
											function(isConfirm) {
												if (isConfirm) {
													$(".confirm").attr('disabled', 'disabled');
													parent.location.href = 'clase.php';

													return true;
												} else {
													return false;
												}
											});
									}
									if (Valor1 == 0) {
										swal("Ha ocurrido un error", Valor2, "error");
									}
								})
								.error(function(data) {
									swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
								});
						}

					});
			}
		</script>
	</body>

	</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>