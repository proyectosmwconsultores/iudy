<?php
$section = "Lista de actividades";
$_v = 92;
include("head.php");

if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de la lista de actividades.');
}

if ($_SESSION['Permisos']) {

	$t->get_validar_mat_doc($_GET["idToks"], $_SESSION['IdUsua']);
	$AsignacionId = $t->get_datosModuloD($_GET["idToks"]);
	$tarAsigs = $t->get_obtenerActividades($_GET["idToks"], "Calificar");

	if ($AsignacionId[0]["NombreMod"]) {
		$idV = $_GET["idToks"];
		$totalActividades = is_array($tarAsigs) ? count($tarAsigs) : 0;

		$totalExamenes = 0;
		$totalForos = 0;
		$totalTareas = 0;

		if (!empty($tarAsigs)) {
			foreach ($tarAsigs as $actTmp) {
				if ($actTmp['IdTipoActividad'] == 1) $totalExamenes++;
				if ($actTmp['IdTipoActividad'] == 2) $totalForos++;
				if ($actTmp['IdTipoActividad'] == 3) $totalTareas++;
			}
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
						<h1><?php echo $AsignacionId[0]["NombreMod"]; ?></h1>
					</section>

					<section class="content">
						<div class="row">
							<div class="col-md-12">
								<div class="lms-summary">
									<div class="lms-card">
										<div class="lms-label">Exámenes</div>
										<div class="lms-kpi"><?php echo $totalExamenes; ?></div>
										<div class="lms-kpi-sub">Evaluaciones en línea</div>
									</div>

									<div class="lms-card">
										<div class="lms-label">Foros</div>
										<div class="lms-kpi"><?php echo $totalForos; ?></div>
										<div class="lms-kpi-sub">Foros de discusión</div>
									</div>
									<div class="lms-card">
										<div class="lms-label">Tareas</div>
										<div class="lms-kpi"><?php echo $totalTareas; ?></div>
										<div class="lms-kpi-sub">Actividades de seguimiento</div>
									</div>
									<div class="lms-card lms-card-main">
										<div class="lms-label">Total actividades</div>
										<div class="lms-kpi"><?php echo $totalActividades; ?></div>
										<div class="lms-kpi-sub">Total registradas</div>
									</div>
								</div>
								

								<div class="lms-panel">
									<div class="lms-panel-head">
										<h3>Lista de actividades creadas en la materia</h3>
									</div>

									<div class="lms-table-wrap">
										<table class="table lms-table">
											<thead>
												<tr>
													<th style="min-width: 420px;">Actividad</th>
													<th style="width: 140px; text-align:center;">Estatus</th>
													<th style="width: 120px; text-align:center;">Comienza</th>
													<th style="width: 120px; text-align:center;">Finaliza</th>
													<th style="width: 110px; text-align:center;">Porcentaje</th>
													<th style="width: 150px; text-align:center;">Acciones</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$pi = 0;
												$pf = 0;

												for ($tx = 0; $tx < sizeof($tarAsigs); $tx++) {

													$id = $tarAsigs[$tx]["IdActividadesDocente"];
													$tok = time() . $id;
													$idT = $tarAsigs[$tx]['IdTipoActividad'];
													$pi = $tarAsigs[$tx]['NoParcial'];

													$ico_ = 'fa-folder';
													$tipoBadge = 'badge-tarea';

													if ($idT == 1) {
														$ico_ = 'fa-edit';
														$tipoBadge = 'badge-examen';
													} elseif ($idT == 2) {
														$ico_ = 'fa-comments';
														$tipoBadge = 'badge-foro';
													} elseif ($idT == 3) {
														$ico_ = 'fa-folder';
														$tipoBadge = 'badge-tarea';
													} elseif ($idT == 4) {
														$ico_ = 'fa-map-signs';
														$tipoBadge = 'badge-extra';
													}

													if ($pi <> $pf) {
												?>
														<tr class="lms-unit-row">
															<td colspan="6"><?php echo $tarAsigs[$tx]['Titulo']; ?></td>
														</tr>
													<?php } ?>

													<tr>
														<td>
															<div class="actividad-main">
																<div class="actividad-icon">
																	<i class="fa <?php echo $ico_; ?>"></i>
																</div>

																<div>
																	<div class="actividad-title">
																		<?php if ($idT <> 4) { ?>
																			<a onClick="window.open('doAddCalificarTarea.php?idToks=<?php echo $_GET["idToks"]; ?>&IdToken=<?php echo $tok; ?>&M=<?php echo $tarAsigs[$tx]["Modalidad"]; ?>','_self')" href="javascript:void(0);">
																				<?php echo $tarAsigs[$tx]['NomActividad']; ?>
																			</a>
																		<?php } else { ?>
																			<a class="no-link" href="javascript:void(0);">
																				<?php echo $tarAsigs[$tx]['NomActividad']; ?>
																			</a>
																		<?php } ?>
																	</div>

																	<div class="actividad-meta">
																		<span class="badge-tipo <?php echo $tipoBadge; ?>">
																			<?php echo $tarAsigs[$tx]['TipoActividad']; ?>
																		</span>
																		<span><?php echo $tarAsigs[$tx]['Etiqueta_semana']; ?></span>
																	</div>
																</div>
															</div>
														</td>

														<td style="text-align:center;">
															<span class="badge-status"><?php echo $tarAsigs[$tx]['Estatus']; ?></span>
														</td>

														<td style="text-align:center;">
															<div class="fecha-box"><?php echo fechaMes($tarAsigs[$tx]['FecIni']); ?></div>
														</td>

														<td style="text-align:center;">
															<div class="fecha-box"><?php echo fechaMes($tarAsigs[$tx]['FecFin']); ?></div>
														</td>

														<td style="text-align:center;">
															<div class="porcentaje-box" <?php if ($idT == 4) { ?>style="text-decoration: line-through; color: #b45353;"<?php } ?>>
																<?php echo $tarAsigs[$tx]['Porcentaje']; ?>%
															</div>
														</td>

														<td style="text-align:left; width: 325px;">
															<div class="acciones-box">
																<?php if ($tarAsigs[$tx]["IdTipoActividad"] <> 4) { ?>
																	<a onClick="window.open('doAddCalificarTarea.php?idToks=<?php echo $_GET["idToks"]; ?>&IdToken=<?php echo $tok; ?>&M=<?php echo $tarAsigs[$tx]["Modalidad"]; ?>','_self')" href="javascript:void(0);">
																		<button title="Calificar actividad" type="button" class="btn btn-default">
																			<i class="fa fa-gears"></i>
																		</button>
																	</a>

																	<a onclick="modFecha(<?php echo $tarAsigs[$tx]['IdActividadesDocente']; ?>)" href="javascript:void(0);">
																		<button title="Modificar fecha de entrega" type="button" class="btn btn-default">
																			<i class="fa fa-calendar"></i>
																		</button>
																	</a>

																	<?php if ($tarAsigs[$tx]["IdTipoActividad"] == 1) { ?>
																		<a onclick="actEvaluacion(<?php echo $tarAsigs[$tx]['IdActividadesDocente']; ?>)" href="javascript:void(0);">
																			<button title="Configurar evaluación" type="button" class="btn btn-warning">
																				<i class="fa fa-gg-circle"></i>
																			</button>
																		</a>
																	<?php } ?>
																<?php } ?>
															</div>
														</td>
													</tr>

												<?php
													$pf = $tarAsigs[$tx]['NoParcial'];
												}
												?>
											</tbody>
										</table>
									</div>
								</div>

							</div>
						</div>
					</section>
				</div>

				<?php include("footer.php"); ?>

				<div id="dataModalModFue" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Entrega de actividad personalizada</h4>
							</div>
							<div class="modal-body" id="employee_detailModFue"></div>
						</div>
					</div>
				</div>

				<div id="dataEva" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar evaluación para los alumnos</h4>
							</div>
							<div class="modal-body" id="employee_eva"></div>
						</div>
					</div>
				</div>
			</div>
		</body>

		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="dist/js/adminlte.min.js"></script>
		<script src="dist/js/demo.js"></script>

		<script>
			function modFecha(IdActividadDoc) {
				$.ajax({
					url: "formConsulta/addFechaPer.php",
					method: "POST",
					data: {
						IdActividadDoc: IdActividadDoc
					},
					success: function(data) {
						$('#employee_detailModFue').html(data);
						$('#dataModalModFue').modal('show');
					}
				});
			}

			function actEvaluacion(IdActividadDoc) {
				$.ajax({
					url: "formConsulta/addActivarEva.php",
					method: "POST",
					data: {
						IdActividadDoc: IdActividadDoc
					},
					success: function(data) {
						$('#employee_eva').html(data);
						$('#dataEva').modal('show');
					}
				});
			}
		</script>

		</html>
<?php
		unset($_SESSION['Alerta']);
		unset($_SESSION['Variable']);
	} else {
		echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
	}
} else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
}
?>