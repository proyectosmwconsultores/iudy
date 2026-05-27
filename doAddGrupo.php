<?php
$section = "Formar equipo de trabajo";
$_v = 96;
include("head.php");

if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de formar equipo de trabajo');
}

if ($_SESSION['Permisos']) {

	$t->get_validar_mat_doc($_GET["idToks"], $_SESSION['IdUsua']);

	$AsignacionId = $t->get_datosModuloD($_GET["idToks"]);
	$tipoDatos    = $t->get_tioDatosGrupo($_SESSION['IdUsua'], $_GET["idToks"]);
	$grupo        = $t->get_grupoActivo($tipoDatos[0]["IdEducativa"], $tipoDatos[0]["IdModulo"], $AsignacionId[0]["Grupo"], $_GET["idToks"]);

	$totalAlumnos = is_array($grupo) ? count($grupo) : 0;
?>
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

	<style>
		
	</style>

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
						<form name="frm" id="frm" action="doAddGrupo.php" method="POST" enctype="multipart/form-data">
							<input id="Mov" name="Mov" value="<?php if (isset($_GET['Mov'])) echo $_GET['Mov']; ?>" type="hidden" />
							<input id="IdAlumno" name="IdAlumno" value="<?php if (isset($_GET['IdAlumno'])) echo $_GET['IdAlumno']; ?>" type="hidden" />
							<input id="Id" name="Id" value="<?php echo $_GET["idToks"]; ?>" type="hidden" />

							<div class="col-md-12">

								<div class="lms-panel">
									<div class="lms-panel-head">
										<h3>Formación de grupos</h3>
									</div>

									<?php if ($_SESSION['EstatusAsig'] == "A") { ?>
										<div class="auto-groups-wrap">
											<div class="auto-field">
												<label>Modo de generación</label>
												<select id="modoAutoGrupo">
													<option value="secuencial">Secuencial balanceado</option>
													<option value="aleatorio">Aleatorio balanceado</option>
												</select>
											</div>

											<div class="auto-field">
												<label>Número de grupos</label>
												<input type="number" min="1" step="1" id="numGruposAuto" placeholder="Ej. 5">
											</div>

											<div>
												<button type="button" class="btn btn-lms btn-lms-primary" onclick="generarGruposAutomaticos()">
													<i class="fa fa-random"></i> Generar automático
												</button>
											</div>

											<div>
												<button type="button" class="btn btn-lms btn-lms-success" onclick="limpiarGruposAutomaticos()">
													<i class="fa fa-eraser"></i> Limpiar equipo
												</button>
											</div>
										</div>

										<div class="lms-helper">
											La opción automática distribuye a los alumnos de manera equilibrada entre la cantidad de grupos indicada. Después puedes ajustar manualmente cualquier integrante.
										</div>
									<?php } ?>

									<div class="lms-table-wrap">
										<table id="example1" class="table lms-table">
											<thead>
												<tr>
													<th style="width: 10px;">#</th>
													<th style="width: 180px;">Matrícula</th>
													<th>Alumno</th>
													<th style="width: 180px; text-align:center;">No. Equipo</th>
												</tr>
											</thead>
											<tbody>
												<?php $num = 0; for ($i = 0; $i < sizeof($grupo); $i++) {
													$valor = $grupo[$i]["IdUsua"];
													$nombreCompleto = $grupo[$i]["APaterno"] . ' ' . $grupo[$i]["AMaterno"] . ' ' . $grupo[$i]["Nombre"];
												?>
													<tr>
														<td>
															<b><?php echo  $num = ($num + 1); ?>.- </b>
														</td>
														<td>
															<span class="badge-equipo"><?php echo $grupo[$i]["Matricula"]; ?></span>
														</td>

														<td>
															<div class="alumno-main">
																<div class="alumno-icon">
																	<i class="fa fa-user"></i>
																</div>
																<div>
																	<div class="alumno-title"><?php echo $nombreCompleto; ?></div>
																	<div class="alumno-meta">ESTATUS: <?php echo $grupo[$i]["Estatus"]; ?></div>
																</div>
															</div>
														</td>

														<?php if ($_SESSION['EstatusAsig'] == "A") { ?>
															<td style="text-align:center;">
																<input
																	onchange="guardarEquipoManual(this.value, <?php echo $valor; ?>)"
																	class="form-control input-equipo js-equipo-input"
																	type="text"
																	name="NoEquipo<?php echo $grupo[$i]["IdUsua"]; ?>"
																	id="NoEquipo<?php echo $grupo[$i]["IdUsua"]; ?>"
																	data-idusua="<?php echo $grupo[$i]["IdUsua"]; ?>"
																	value="<?php echo $grupo[$i]["Equipo"]; ?>">
															</td>
														<?php } elseif ($_SESSION['EstatusAsig'] == "F") { ?>
															<td style="text-align:center;">
																<input
																	class="form-control input-equipo"
																	type="text"
																	name="NoEquipo<?php echo $grupo[$i]["IdUsua"]; ?>"
																	id="NoEquipo<?php echo $grupo[$i]["IdUsua"]; ?>"
																	value="<?php echo $grupo[$i]["Equipo"]; ?>"
																	readonly>
															</td>
														<?php } ?>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>

							</div>
						</form>
					</div>
				</section>
			</div>

			<?php include("footer.php"); ?>
		</div>

		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
		<script src="dist/js/adminlte.min.js"></script>
		<script src="dist/js/demo.js"></script>

		<script>
			function marcarInputOk(inputId) {
				var input = document.getElementById(inputId);
				if (!input) return;
				input.classList.remove('input-equipo-error');
				input.classList.add('input-equipo-ok');
				setTimeout(function() {
					input.classList.remove('input-equipo-ok');
				}, 1200);
			}

			function marcarInputError(inputId) {
				var input = document.getElementById(inputId);
				if (!input) return;
				input.classList.remove('input-equipo-ok');
				input.classList.add('input-equipo-error');
			}

			function guardarEquipoManual(valor, IdUsua) {
				var inputId = 'NoEquipo' + IdUsua;
				var valorLimpio = String(valor).trim();

				if (valorLimpio === '') {
					marcarInputError(inputId);
					swal("Dato requerido", "Debe indicar un número de equipo.", "warning");
					return;
				}

				if (!/^[0-9]+$/.test(valorLimpio)) {
					marcarInputError(inputId);
					swal("Dato inválido", "El número de equipo debe ser numérico.", "error");
					return;
				}

				if (typeof val_adAddGrupo === 'function') {
					val_adAddGrupo(valorLimpio, IdUsua);
					marcarInputOk(inputId);
				} else {
					console.warn('No existe la función val_adAddGrupo(valor, IdUsua)');
					marcarInputError(inputId);
				}
			}

			function shuffleArray(array) {
				for (let i = array.length - 1; i > 0; i--) {
					const j = Math.floor(Math.random() * (i + 1));
					[array[i], array[j]] = [array[j], array[i]];
				}
				return array;
			}

			function generarGruposAutomaticos() {
				var numGrupos = parseInt(document.getElementById('numGruposAuto').value, 10);
				var modo = document.getElementById('modoAutoGrupo').value;
				var inputs = Array.from(document.querySelectorAll('.js-equipo-input'));

				if (!numGrupos || numGrupos <= 0) {
					swal("Dato requerido", "Indica cuántos grupos deseas generar.", "warning");
					return;
				}

				if (!inputs.length) {
					swal("Sin datos", "No se encontraron alumnos para asignar.", "warning");
					return;
				}

				if (numGrupos > inputs.length) {
					swal("Cantidad inválida", "El número de grupos no puede ser mayor al total de alumnos.", "warning");
					return;
				}

				let lista = inputs.slice();

				if (modo === 'aleatorio') {
					lista = shuffleArray(lista);
				}

				for (let i = 0; i < lista.length; i++) {
					let equipo = (i % numGrupos) + 1;
					let input = lista[i];
					let idUsua = input.getAttribute('data-idusua');

					input.value = equipo;

					if (typeof val_adAddGrupo === 'function') {
						val_adAddGrupo(equipo, idUsua);
						input.classList.remove('input-equipo-error');
						input.classList.add('input-equipo-ok');
					}
				}

				setTimeout(function() {
					document.querySelectorAll('.js-equipo-input').forEach(function(el) {
						el.classList.remove('input-equipo-ok');
					});
				}, 1500);

				swal("Grupos generados", "La distribución automática fue aplicada correctamente.", "success");
			}

			function limpiarGruposAutomaticos() {
				var IdAsignacion = document.getElementById('Id').value;

				swal({
					title: "¿Limpiar asignación?",
					text: "Se eliminarán TODOS los equipos asignados.",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Sí, limpiar',
					cancelButtonText: 'Cancelar'
				}, function(isConfirm) {

					if (!isConfirm) return;

					$.ajax({
						url: 'ajax/limpiar_grupos.php',
						method: 'POST',
						dataType: 'json',
						data: {
							IdAsignacion: IdAsignacion
						},
						success: function(resp) {
							if (resp.ok) {

								$('.js-equipo-input').each(function() {
									$(this).val('');
									$(this).removeClass('input-equipo-ok input-equipo-error');
								});

								// 🔥 FIX SCROLL DATATABLE
								var table = $('#example1').DataTable();
								table.columns.adjust().draw(false);

								swal("Listo", "Los equipos fueron eliminados.", "success");

							} else {
								swal("Error", resp.msg || "No se pudo limpiar.", "error");
							}
						},
						error: function() {
							swal("Error", "Error de conexión.", "error");
						}
					});

				});
			}

			function val_adAddGrupo(Equipo, IdUsua) {
				var IdAsignacion = document.getElementById('Id').value;
				var inputId = 'NoEquipo' + IdUsua;

				$.ajax({
					url: 'ajax/guardar_equipo_grupo.php',
					method: 'POST',
					dataType: 'json',
					data: {
						IdAsignacion: IdAsignacion,
						IdUsua: IdUsua,
						Equipo: Equipo
					},
					success: function(resp) {
						if (resp.ok) {
							$('#' + inputId).addClass('input-equipo-ok');
							setTimeout(function() {
								$('#' + inputId).removeClass('input-equipo-ok');
							}, 1200);
						} else {
							$('#' + inputId).addClass('input-equipo-error');
							swal("Error", resp.msg || "No se pudo guardar el equipo.", "error");
						}
					},
					error: function() {
						$('#' + inputId).addClass('input-equipo-error');
						swal("Error", "Ocurrió un error al guardar el equipo.", "error");
					}
				});
			}
		</script>


	</body>

	</html>
<?php
} else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
}
?>