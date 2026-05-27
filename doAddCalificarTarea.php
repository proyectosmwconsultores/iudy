<?php
$section = "Calificar actividades";
$_v = 92;
include("head.php");

if ($_SESSION['Permisos']) {

	$dispo = $t->get_validar_mat_doc($_GET["idToks"], $_SESSION['IdUsua']);
	$AsignacionId = $t->get_datosModuloD($_GET["idToks"]);

	if ($AsignacionId[0]["NombreMod"]) {

		$nombx = $AsignacionId[0]['NombreMod'];
		$addIngresos = $t->add_registros($_SESSION['IdUsua'], "Está en el módulo de calificar actividades - $nombx", "Modulo calificar", "Modulo", $_GET["idToks"], 0, $AsignacionId[0]["IdModulo"]);

		$IdActividadDoc = substr($_GET["IdToken"], 10, 10);
		$actividad = $t->get_actividadNo($_GET["idToks"], $IdActividadDoc);
		if ($actividad[0]["IdAsignacion"] == $_GET["idToks"]) {
			$ListaResDu = $t->get_listarespuestaDupl($_GET["idToks"], $IdActividadDoc);
		}
		$ListaRespuesta = $t->get_listarespuesta($_GET["idToks"], $IdActividadDoc, $_GET["M"]);

		

		$_SESSION['EstatusAsig'] = 'A';
		$_GET['IdU'] = isset($_GET['IdU']) ? $_GET['IdU'] : 0;

		$parcial = $t->get_parcial_id($actividad[0]["IdParcialDocente"]);

		$tipoActividadTxt = "Actividad";
		if ($actividad[0]["IdTipoActividad"] == 1) $tipoActividadTxt = "Examen";
		if ($actividad[0]["IdTipoActividad"] == 2) $tipoActividadTxt = "Foro";
		if ($actividad[0]["IdTipoActividad"] == 3) $tipoActividadTxt = "Tarea";

		$totalAlumnos = is_array($ListaRespuesta) ? count($ListaRespuesta) : 0;
?>
		<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
		<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

		<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
			<div class="wrapper">
				<?php include("menuV.php"); ?>

				<div class="content-wrapper">
					<section class="content-header">
						<h1><?php echo $AsignacionId[0]["NombreMod"]; ?></h1>
					</section>

					<section class="content">
						<div class="row">
							<form name="frm" id="frm" action="doAddCalificarTarea.php" method="POST" enctype="multipart/form-data">
								<input id="Id" name="Id" value="<?php echo $_GET["idToks"]; ?>" type="hidden" />
								<input id="IdParcial" name="IdParcial" value="<?php echo $actividad[0]["IdParcialDocente"]; ?>" type="hidden" />
								<input id="TipoGuardar" name="TipoGuardar" value="val_adAddCalificar" type="hidden" />
								<input id="MaxCalificacion" name="MaxCalificacion" value="<?php echo $actividad[0]["Porcentaje"]; ?>" type="hidden" />
								<input id="TipoCalificar" name="TipoCalificar" value="<?php echo $_GET["M"]; ?>" type="hidden" />
								<input id="IdActividadDoc" name="IdActividadDoc" value="<?php echo $IdActividadDoc; ?>" type="hidden" />
								<div class="col-md-12">
									<div class="actividad-resumen-v2">
										<!-- FILA 1: ACTIVIDAD COMPLETA -->
										<div class="resumen-card resumen-main full-width">
											<div class="resumen-label">Actividad: </div>
											<div class="resumen-title"><?php echo $actividad[0]["NomActividad"]; ?></div>
											<div class="resumen-desc">
												<?php echo substr(strip_tags($actividad[0]["DesActividad"]), 0, 350); ?>
											</div>
										</div>

										<!-- FILA 2: KPIs -->
										<div class="resumen-card" style="text-align: center;">
											<div class="resumen-label">Porcentaje</div>
											<div class="resumen-value"><?php echo $actividad[0]["Porcentaje"]; ?>%</div>
										</div>

										<div class="resumen-card" style="text-align: center;">
											<div class="resumen-label">Modalidad</div>
											<div class="resumen-value">
												<?php echo $_GET["M"] == 2 ? 'Equipo' : 'Individual'; ?>
											</div>
										</div>

										<div class="resumen-card" style="text-align: center;">
											<div class="resumen-label">Tipo</div>
											<div class="resumen-value"><?php echo $tipoActividadTxt; ?></div>
										</div>

										<div class="resumen-card" style="text-align: center;">
											<div class="resumen-label">Alumnos</div>
											<div class="resumen-value"><?php echo $totalAlumnos; ?></div>
										</div>

									</div>

									<div class="lms-panel">
										<div class="table-responsive tabla-lms-wrap">
											<table class="table table-hover tabla-lms">
												<thead>
													<tr>
														<th style="width: 90px; text-align:center;">Folio</th>
														<th>Alumno</th>

														<?php if ($_GET["M"] == "2") { ?>
															<th style="text-align:center; min-width:130px;">Equipo</th>
														<?php } ?>

														<?php if ($actividad[0]["IdTipoActividad"] == 1) { ?>
															<th style="text-align:center; min-width:170px;">Acciones del examen</th>
														<?php } ?>

														<?php if ($actividad[0]["IdTipoActividad"] == 2) { ?>
															<th style="text-align:center; min-width:150px;">Participación foro</th>
														<?php } ?>

														<?php if ($actividad[0]["IdTipoActividad"] == 3) { ?>
															<th style="text-align:center; min-width:180px;">Archivos</th>
															<th style="text-align:center; min-width:110px;">Comentarios</th>
															<th style="text-align:center; min-width:90px;">Rúbrica</th>
														<?php } ?>

														<th style="text-align:center; width:150px;">Calificación</th>
													</tr>
												</thead>
												<tbody>
													<?php $num = 0; $miequipo = 0; for ($i = 0; $i < sizeof($ListaRespuesta); $i++) {
														$tarea = $ListaRespuesta[$i]["IdTarea"];
														$alumno = $ListaRespuesta[$i]["IdUsua"];
														$valor = 0;
														$nombreCompleto = trim($ListaRespuesta[$i]["APaterno"] . ' ' . $ListaRespuesta[$i]["AMaterno"] . ' ' . $ListaRespuesta[$i]["Nombre"]);
														$rowClass = ($alumno == $_GET['IdU']) ? "row-selected" : "";
													?>
														<tr class="<?php echo $rowClass; ?>">
															<td style="text-align:center;">
																<span class="folio-badge"><?php echo $num = ($num + 1); ?></span>
															</td>

															<td>
																<div class="alumno-nombre"><?php echo $nombreCompleto; ?></div>
																<div class="alumno-sub">
																	ESTATUS: <?php echo $ListaRespuesta[$i]["Estatus"]; ?>
																</div>
															</td>

															<?php if ($_GET["M"] == "2") { ?>
																<td style="text-align: center;">
																	<?php
																	$equipox = $t->get_equipoo($_GET["idToks"], $alumno, $AsignacionId[0]["IdEducativa"], $AsignacionId[0]["IdModulo"]);
																	$equipo = 'EQUIPO: ' . (!empty($equipox[0]["Equipo"]) ? $equipox[0]["Equipo"] : '-');
																	$miequipo = (!empty($equipox[0]["Equipo"]) ? $equipox[0]["Equipo"] : '0');
																	echo $equipo ? $equipo : "ERROR: S/E";
																	?>
																</td>
															<?php } ?>

															<?php if ($actividad[0]["IdTipoActividad"] == 1) { ?>
																<td style="text-align:center;">
																	<div class="acciones-lms">
																		<!-- <button type="button" class="btn btn-danger btn-sm btnVerEventosAlumno" title="Ver bitácora del examen" data-idusua="<?php echo (int)$ListaRespuesta[$i]['IdUsua']; ?>" data-idtarea="<?php echo (int)$ListaRespuesta[$i]['IdTarea']; ?>" data-idasignacion="<?php echo htmlspecialchars($_GET["idToks"]); ?>" data-alumno="<?php echo htmlspecialchars($nombreCompleto); ?>"> <i class="fa fa-shield"></i> </button> -->
																		<button title="Comentarios" type="button" class="btn btn-primary btn-sm view_data" id="<?php echo $ListaRespuesta[$i]["IdTarea"] . '-' . $_SESSION['IdUsua'] . '-D-' . $ListaRespuesta[$i]["IdAlumno"] . '-' . $IdActividadDoc; ?>"> <i class="fa fa-comments"></i></button>
																		<button type="button" class="btn btn-success btn-sm view_resulEx" title="Ver respuestas del examen" id="<?php echo $ListaRespuesta[$i]["IdAlumno"]; ?>"> <i class="fa fa-eye"></i> </button>
																	</div>
																</td>
															<?php } ?>

															<?php if ($actividad[0]["IdTipoActividad"] == 2) { ?>
																<td style="text-align:center;">
																	<button title="Ver detalle del foro" type="button" class="btn btn-danger btn-sm" onclick="verForo(<?php echo $ListaRespuesta[$i]['IdAlumno']; ?>,<?php echo $IdActividadDoc; ?>)"> <i class="fa fa-wechat"></i> Foro </button>
																</td>
															<?php } ?>

															<?php if ($actividad[0]["IdTipoActividad"] == 3) { ?>
																<td style="text-align:center;">
																	<div class="acciones-lms">
																		<?php if (isset($ListaRespuesta[$i]["Link"])) {
																			$valor = 1; ?>
																			<button type="button" onclick="verFile(<?php echo $ListaRespuesta[$i]['IdTarea']; ?>,'Link')" class="btn btn-primary btn-sm" title="Archivo 1">
																				<i class="fa fa-eye"></i> 1
																			</button>
																		<?php } ?>
																		<?php if (isset($ListaRespuesta[$i]["Link2"])) {
																			$valor = 1; ?>
																			<button type="button" onclick="verFile(<?php echo $ListaRespuesta[$i]['IdTarea']; ?>,'Link2')" class="btn btn-primary btn-sm" title="Archivo 2">
																				<i class="fa fa-eye"></i> 2
																			</button>
																		<?php } ?>
																		<?php if (isset($ListaRespuesta[$i]["Link3"])) {
																			$valor = 1; ?>
																			<button type="button" onclick="verFile(<?php echo $ListaRespuesta[$i]['IdTarea']; ?>,'Link3')" class="btn btn-primary btn-sm" title="Archivo 3">
																				<i class="fa fa-eye"></i> 3
																			</button>
																		<?php } ?>
																		<?php if (!$ListaRespuesta[$i]["Link"] && !$ListaRespuesta[$i]["Link2"] && !$ListaRespuesta[$i]["Link3"]) { ?>
																			<span class="text-muted">Sin archivos</span>
																		<?php } ?>
																	</div>
																</td>

																<td style="text-align:center;">
																	<button title="Comentarios" type="button" class="btn btn-primary btn-sm view_data" id="<?php echo $ListaRespuesta[$i]["IdTarea"] . '-' . $_SESSION['IdUsua'] . '-D-' . $ListaRespuesta[$i]["IdAlumno"] . '-' . $IdActividadDoc; ?>">
																		<i class="fa fa-comments"></i>
																	</button>
																</td>

																<td style="text-align:center;">
																	<?php if ((isset($actividad[0]['IdRubrica'])) && ($parcial[0]['IdEstatus'] == 4)) { ?>
																		<button type="button" class="btn btn-warning btn-sm" onclick="cal_rubrica_id(<?php echo $alumno; ?>,<?php echo $IdActividadDoc; ?>,<?php echo $actividad[0]['IdRubrica']; ?>)" title="Calificar con rúbrica"> <i class="fa fa-flag"></i> </button>
																	<?php } else { ?>
																		<span class="text-muted"> --- </span>
																	<?php } ?>
																</td>
															<?php } ?>

															<td style="text-align:center;">
																<?php if($parcial[0]['IdEstatus'] == 10){ echo '<b>'.$ListaRespuesta[$i]["Porcentaje"].'</b>'; } else { ?>
																<input <?php if ($parcial[0]['IdEstatus'] == 10) { echo "disabled"; } ?> value="<?php echo $ListaRespuesta[$i]["Porcentaje"]; ?>" class="form-control input-calificacion" type="text" onchange="sav_cal_tarea_id(<?php echo $tarea; ?>,<?php echo $alumno; ?>,'<?php echo $miequipo; ?>',<?php echo $IdActividadDoc; ?>)" name="txtCalificacion-<?php echo $tarea; ?>" id="txtCalificacion-<?php echo $tarea; ?>">
																<?php } ?>
															</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>

										<div class="footer-actions">
											<?php if($parcial[0]['IdEstatus'] <> 10){ ?>
											<button <?php if ($parcial[0]['IdEstatus'] == 10) { echo "disabled"; } ?> onclick="recarga_falsa()" type="button" class="btn bg-navy btn-flat">
												<i class="fa fa-fw fa-save"></i> Guardar calificaciones
											</button><?php } ?>
										</div>
									</div>

								</div>
							</form>
						</div>
					</section>

					<div id="dataModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><i class="fa fa-fw fa-twitch"></i> Comentarios de la actividad</h4>
								</div>
								<div class="modal-body" id="employee_detail"></div>
							</div>
						</div>
					</div>

					<div id="dataModal3" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body" id="employee_detail3"></div>
							</div>
						</div>
					</div>

					<div id="dataModal8" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><i class="fa fa-fw fa-eye"></i> Vista previa del trabajo</h4>
								</div>
								<div class="modal-body" id="employee_detail8"></div>
							</div>
						</div>
					</div>

					<div id="dataModal_rub" class="modal fade bs-example-modal-lg">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Rúbrica para calificar la actividad</h4>
								</div>
								<div class="modal-body" id="employee_detail_rub"></div>
							</div>
						</div>
					</div>

					<div id="dataModalForo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="foroModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-xl" role="document">
							<div class="modal-content">
								<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Detalle del foro</h4>
								</div>
								<div class="modal-body" id="employee_foro">
									<div class="text-center p-4">Cargando...</div>
								</div>
							</div>
						</div>
					</div>

					<div class="modal fade" id="modalExamEvents" tabindex="-1" role="dialog" aria-labelledby="modalExamEventsLabel">
						<div class="modal-dialog modal-xl" role="document">
							<div class="modal-content">
								<div class="modal-header" style="background:#1f2d3d; color:#fff;">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
										<span aria-hidden="true">&times;</span>
									</button>
									<h4 class="modal-title" id="modalExamEventsLabel">
										<i class="fa fa-user"></i> Eventos del examen del alumno
									</h4>
								</div>
								<div class="modal-body" id="modalExamEventsBody">
									<div style="padding:25px; text-align:center; color:#777;">
										<i class="fa fa-spinner fa-spin"></i> Cargando eventos...
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>

				</div>

				<?php include("footer.php"); ?>
			</div>

			<script src="bower_components/jquery/dist/jquery.min.js"></script>
			<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
			<script src="dist/js/adminlte.min.js"></script>
			<script src="dist/js/demo.js"></script>
			<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

			<script>
				$(function() {

					$(document).on('click', '.view_data', function() {
						var employee_id = $(this).attr("id");

						if (employee_id != '') {
							$.ajax({
								url: "formConsulta/viewComentarios.php",
								method: "POST",
								data: {
									employee_id: employee_id
								},
								success: function(data) {
									$('#employee_detail').html(data);
									$('#dataModal').modal('show');
								}
							});
						}
					});

					$(document).on('click', '.view_resulEx', function() {
						var employee_id = $(this).attr("id");
						var IdAsignacion = document.getElementById("Id").value;
						var IdParcial = document.getElementById("IdParcial").value;
						var IdActividadDoc = document.getElementById("IdActividadDoc").value;

						if (employee_id != '') {
							$.ajax({
								url: "formConsulta/viewRespuestaDoc.php",
								method: "POST",
								data: {
									employee_id: employee_id,
									IdAsignacion: IdAsignacion,
									IdParcial: IdParcial,
									IdActividadDoc: IdActividadDoc
								},
								success: function(data) {
									$('#employee_detail3').html(data);
									$('#dataModal3').modal('show');
								}
							});
						}
					});

					$(document).on('click', '.view_editor', function() {
						var employee_id = $(this).attr("id");
						var TipoCalificar = document.getElementById("TipoCalificar").value;
						var IdParcial = document.getElementById("IdParcial").value;
						var IdActividadDoc = document.getElementById("IdActividadDoc").value;

						if (employee_id != '') {
							$.ajax({
								url: "formConsulta/viewEditor.php",
								method: "POST",
								data: {
									employee_id: employee_id,
									IdParcial: IdParcial,
									IdActividadDoc: IdActividadDoc,
									TipoCalificar: TipoCalificar
								},
								success: function(data) {
									$('#employee_detail').html(data);
									$('#dataModal').modal('show');
								}
							});
						}
					});

					$(document).on('click', '.view_resul', function() {
						var employee_id = $(this).attr("id");
						var Id = document.getElementById("Id").value;
						var NoActividad = document.getElementById("NoActividad").value;

						if (employee_id != '') {
							$.ajax({
								url: "formConsulta/viewRespuestaDoc.php",
								method: "POST",
								data: {
									employee_id: NoActividad,
									Id: Id,
									IdUsua: employee_id
								},
								success: function(data) {
									$('#employee_detail3').html(data);
									$('#dataModal3').modal('show');
								}
							});
						}
					});

					$(document).on('click', '.btnVerEventosAlumno', function() {
						var IdUsua = $(this).data('idusua');
						var IdAsignacion = $(this).data('idasignacion');
						var IdTarea = $(this).data('idtarea');
						var alumno = $(this).data('alumno');

						$('#modalExamEventsLabel').html('<i class="fa fa-user"></i> Eventos del examen - ' + alumno);
						$('#modalExamEventsBody').html(
							'<div style="padding:25px; text-align:center; color:#777;">' +
							'<i class="fa fa-spinner fa-spin"></i> Cargando eventos...' +
							'</div>'
						);

						$('#modalExamEvents').modal('show');

						$.ajax({
							url: 'ajax/get_exam_events.php',
							type: 'POST',
							data: {
								IdUsua: IdUsua,
								IdAsignacion: IdAsignacion,
								IdTarea: IdTarea
							},
							success: function(response) {
								$('#modalExamEventsBody').html(response);
							},
							error: function() {
								$('#modalExamEventsBody').html(
									'<div class="alert alert-danger" style="margin:0;">' +
									'Ocurrió un error al cargar los eventos del examen.' +
									'</div>'
								);
							}
						});
					});

				});

				function verForo(IdUsua, IdActividad) {
					$.ajax({
						url: "formConsulta/viewForoAlumno.php",
						method: "POST",
						data: {
							IdUsua: IdUsua,
							IdActividad: IdActividad
						},
						success: function(data) {
							$('#employee_foro').html(data);
							$('#dataModalForo').modal('show');
						},
						error: function() {
							$('#employee_foro').html('<div class="alert alert-danger">No se pudo cargar el foro.</div>');
							$('#dataModalForo').modal('show');
						}
					});
				}

				function verFile(IdTarea, Ubicacion) {
					$.ajax({
						url: "formConsulta/viewFile.php",
						method: "POST",
						data: {
							IdTarea: IdTarea,
							Ubicacion: Ubicacion
						},
						success: function(data) {
							$('#employee_detail8').html(data);
							$('#dataModal8').modal('show');
						}
					});
				}

				function cal_rubrica_id(IdUsua, IdActividadDoc, IdRubrica) {
					$.ajax({
						url: "vistas/docente/calificar_rubrica_actividad.php",
						method: "POST",
						data: {
							IdActividadDoc: IdActividadDoc,
							IdRubrica: IdRubrica,
							IdUsua: IdUsua
						},
						success: function(data) {
							$('#employee_detail_rub').html(data);
							$('#dataModal_rub').modal('show');
						}
					});
				}

				function sav_cal_rub(IdDesglose, IdUsua, IdActividadDoc, IdRubrica, Calificacion) {
					var TipoGuardar = "sav_calificacion_rub";
					$.ajax({
						url: "vistas/escolar/guardar_datos_escolar.php",
						method: "POST",
						data: {
							TipoGuardar: TipoGuardar,
							IdDesglose: IdDesglose,
							Calificacion: Calificacion
						},
						success: function(data) {
							$.ajax({
								url: "vistas/docente/calificar_rubrica_actividad.php",
								method: "POST",
								data: {
									IdActividadDoc: IdActividadDoc,
									IdRubrica: IdRubrica,
									IdUsua: IdUsua
								},
								success: function(data) {
									$('#employee_detail_rub').html(data);
									$('#dataModal_rub').modal('show');
								}
							});
						}
					})
				}

				function sav_cal_tarea_id(IdTarea, IdUsua, Equipo, IdActividad) {
					var DatoMatricula = "txtCalificacion-" + IdTarea;
					var input = document.getElementById(DatoMatricula);
					var Calificacion = input.value;
					var TipoGuardar = "sav_calificacion_tarea_id";
					var MaxCalificacion = document.getElementById("MaxCalificacion").value;

					input.classList.remove('input-ok');
					input.classList.remove('input-error');

					var calificacionValue = parseFloat(Calificacion);
					var maxCalificacionValue = parseFloat(MaxCalificacion);

					if (isNaN(calificacionValue) || isNaN(maxCalificacionValue)) {
						input.classList.add('input-error');
						swal("Error al guardar", "Debe ingresar un valor numérico válido en la calificación.", "error");
						input.value = '';
						input.focus();
						return 0;
					}

					if (calificacionValue < 0) {
						input.classList.add('input-error');
						swal("Error al guardar", "La calificación no puede ser un valor negativo.", "error");
						input.value = '';
						input.focus();
						return 0;
					}

					if (calificacionValue > maxCalificacionValue) {
						input.classList.add('input-error');
						swal("Error al guardar", "La calificación agregada está fuera del rango permitido.", "error");
						input.value = '';
						input.focus();
						return 0;
					}

					$.ajax({
						url: "formConsulta/setting.php",
						method: "POST",
						data: {
							TipoGuardar: TipoGuardar,
							IdTarea: IdTarea,
							IdUsua: IdUsua,
							Calificacion: Calificacion, Equipo:Equipo, IdActividad:IdActividad
						},
						success: function(data) {
							input.classList.add('input-ok');
							setTimeout(function() {
								input.classList.remove('input-ok');
							}, 1200);
						},
						error: function() {
							input.classList.add('input-error');
							swal("Error", "No se pudo guardar la calificación.", "error");
						}
					});
				}

				function recarga_falsa() {
					swal({
							title: "Favor de validar que todas las calificaciones estén guardadas correctamente",
							type: "success",
							showCancelButton: false,
							confirmButtonColor: '#DD6B55',
							confirmButtonText: 'Aceptar',
							allowEscapeKey: false,
							allowOutsideClick: false
						},
						function(isConfirm) {
							window.location.reload();
						});
				}
			</script>
		</body>

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