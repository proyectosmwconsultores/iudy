<?php
$section = "Configurar asignatura";
include("head.php");

if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está por asignar una asignatura a un asesor académico');
}

$meses = $t->get_meses();
$anio = $t->get_anios();

$_POST["txtModulo"] = isset($_POST["txtModulo"]) ? $_POST["txtModulo"] : '';
$_POST["txtClaveGrp"] = isset($_POST["txtClaveGrp"]) ? $_POST["txtClaveGrp"] : '';
$_POST["txtCicloEscolar"] = isset($_POST["txtCicloEscolar"]) ? $_POST["txtCicloEscolar"] : '';

if ($_SESSION['Permisos']) {
	$docentes = $t->get_Docentes();
	$tutores = $t->get_Tutores($_POST["txtModulo"]);
	$rve = $t->get_rvoe_id($_POST["txtClaveGrp"]);
	$moduloId = $t->get_ModuloIdAsig($_POST["txtClaveGrp"]);
	$lstCiclo = $t->get_cEscolarLst();
	$clvGrupo = $t->get_claveGrupoXA($_POST["txtCicloEscolar"]);
}
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1><i class="fa fa-fw fa-cog"></i> Configurar asignación</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-bars"></i> Configurar</a></li>
					<li class="active">Asignatura</li>
				</ol>
			</section>

			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-fw fa-flag"></i> Información para configurar asignatura</h3>
					</div>
					<div class="box-body">
						<form name="frm" id="frm" action="adAddModConfig.php" method="POST" enctype="multipart/form-data">
							<input id="TipoGuardar" name="TipoGuardar" value="val_adAddModConfig" type="hidden" />

							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
										<label>Periodo escolar:</label>
										<div class="input-group date">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<select class="form-control select2" name="txtCicloEscolar" id="txtCicloEscolar" onchange="document.frm.submit();">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($lstCiclo); $i++) { ?>
													<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>" <?php if ($_POST["txtCicloEscolar"] == $lstCiclo[$i]["IdCiclo"]) echo 'selected="selected"'; ?>>
														<?php echo $lstCiclo[$i]["Tipo"] . " - " . $lstCiclo[$i]["Ciclo"]; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-7">
									<div class="form-group">
										<label>Grupo:</label>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-fw fa-key"></i></div>
											<select class="form-control select2" name="txtClaveGrp" id="txtClaveGrp" onchange="document.frm.submit();">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($clvGrupo); $i++) {
													$busActivoD = $t->get_busActOfer($clvGrupo[$i]["IdGrupo"], $_SESSION["IdUsua"], $clvGrupo[$i]["IdCampus"]);
													if (isset($busActivoD[0])) { ?>
														<option value="<?php echo $clvGrupo[$i]["IdGrupo"]; ?>" <?php if ($_POST['txtClaveGrp'] == $clvGrupo[$i]["IdGrupo"]) echo 'selected="selected"'; ?>>
															<?php echo $clvGrupo[$i]["_campus"] . ' * ' . $clvGrupo[$i]["Grado"] . '° ' . $clvGrupo[$i]["CveGrupo"] . ' - (' . $clvGrupo[$i]["_Dias"] . ') / ' . $clvGrupo[$i]["Abreviatura"]; ?>
														</option>
												<?php }
												} ?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="bg-purple disabled color-palette" style="padding: 10px; border-radius: 4px; margin-bottom: 15px;">
										<span><i class="fa fa-info-circle"></i> ROVE: <?php echo isset($rve[0]['Rvoe']) ? $rve[0]['Rvoe'] : '---'; ?> - <?php echo isset($rve[0]['Educativa']) ? $rve[0]['Educativa'] : '---'; ?></span>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Asignatura:</label>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-book"></i></div>
											<select class="form-control select2" name="txtModulo" id="txtModulo" onchange="document.frm.submit();">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($moduloId); $i++) {
													$catBusModAsi = $t->get_catBusModAsig($moduloId[$i]["IdModulo"], $moduloId[$i]["IdEducativa"], $_POST["txtClaveGrp"]);
													if (!isset($catBusModAsi[0]["IdEstatus"])) { ?>
														<option value="<?php echo $moduloId[$i]["IdModulo"]; ?>" <?php if ($_POST['txtModulo'] == $moduloId[$i]["IdModulo"]) echo 'selected="selected"'; ?>>
															<?php echo $moduloId[$i]["Grado"] . '° ' . $moduloId[$i]["CodeModulo"] . ' ' . $moduloId[$i]["NombreMod"]; ?>
														</option>
												<?php }
												} ?>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label>Asesor académico:</label>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-user"></i></div>
											<select class="form-control select2" name="txtDocente" id="txtDocente" onchange="verificar_espacio()">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($docentes); $i++) { ?>
													<option value="<?php echo $docentes[$i]["IdUsua"]; ?>" <?php if (isset($_POST['txtDocente']) && $_POST['txtDocente'] == $docentes[$i]["IdUsua"]) echo 'selected="selected"'; ?>>
														<?php echo $docentes[$i]["Nombre"] . ' ' . $docentes[$i]["APaterno"] . ' ' . $docentes[$i]["AMaterno"]; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label><i class="fa fa-clock-o"></i> Seleccione días y horarios de clase:</label>
										<div class="days-container">
											<?php
											$diasArr = ['LUN' => 'Lunes', 'MAR' => 'Martes', 'MIE' => 'Miércoles', 'JUE' => 'Jueves', 'VIE' => 'Viernes', 'SÁB' => 'Sábado', 'DOM' => 'Domingo'];
											foreach ($diasArr as $key => $nombre) { ?>
												<div class="day-box">
													<input type="checkbox" id="chk_<?php echo $key; ?>" name="dias_clase[]" value="<?php echo $key; ?>" class="check-dia">
													<label for="chk_<?php echo $key; ?>" class="day-label"><?php echo ($key == 'X' ? 'M' : $key); ?></label>
													<div class="time-picker">
														<span>Inicia</span>
														<input type="time" name="h_ini_<?php echo $key; ?>" class="h-inicio">
														<span>Termina</span>
														<input type="time" name="h_fin_<?php echo $key; ?>" class="h-fin">
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Fecha inicial:</label>
										<div class="input-group date">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input onchange="verificar_espacio()" type="text" class="form-control pull-right" id="datepicker" name="datepicker">
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Fecha final:</label>
										<div class="input-group date">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input onchange="verificar_espacio()" type="text" class="form-control pull-right" id="datepicker2" name="datepicker2">
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Coordinador académico / Tutor:</label>
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-user"></i></div>
											<select class="form-control select2" name="txtTutor" id="txtTutor">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($tutores); $i++) { ?>
													<option value="<?php echo $tutores[$i]["IdUsua"]; ?>"><?php echo $tutores[$i]["Nombre"] . ' ' . $tutores[$i]["APaterno"] . ' ' . $tutores[$i]["AMaterno"]; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>&nbsp;</label>
										<button type="button" class="btn bg-maroon btn-flat btn-block" onClick="sav_asignatura_docente_id()"><i class="fa fa-save"></i> Guardar</button>
									</div>
								</div>
							</div>

							<div class="row" id="div_espacio" style="display: none; margin-top: 15px;">
								<div class="col-md-12">
									<div class="callout callout-danger" style="margin-bottom: 0;">
										<h4><i class="icon fa fa-ban"></i> Aviso de disponibilidad</h4>
										<p id="_espacio"></p>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</section>
		</div>
		<?php include("footer.php"); ?>
	</div>

	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
	<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<script src="dist/js/adminlte.min.js"></script>

	<script>
		$(function() {
			$('.select2').select2();
			$('#datepicker, #datepicker2').datepicker({
				autoclose: true,
				format: 'yyyy/mm/dd'
			});
		});

		function sav_asignatura_docente_id() {
			// 1. Validaciones de Días y Horarios (Lado Cliente)
			var diasCheck = document.querySelectorAll('.check-dia:checked');

			if (diasCheck.length === 0) {
				swal("Error de validación", "Debe seleccionar al menos un día de clase.", "error");
				return 0;
			}

			var horariosSeleccionados = {};
			var errorH = false;

			diasCheck.forEach(function(check) {
				var p = check.closest('.day-box');
				var h1 = p.querySelector('.h-inicio');
				var h2 = p.querySelector('.h-fin');
				var diaLetra = check.value;

				h1.classList.remove('input-error');
				h2.classList.remove('input-error');

				if (!h1.value || !h2.value) {
					swal("Horario incompleto", "Por favor indique entrada y salida para el día seleccionado.", "warning");
					if (!h1.value) h1.classList.add('input-error');
					if (!h2.value) h2.classList.add('input-error');
					errorH = true;
				} else if (h1.value >= h2.value) {
					swal("Error de horario", "La hora de fin debe ser mayor a la de inicio.", "error");
					h2.classList.add('input-error');
					errorH = true;
				}

				horariosSeleccionados[diaLetra] = {
					inicio: h1.value,
					fin: h2.value
				};
			});

			if (errorH) return 0;

			// Validar campos obligatorios del formulario
			if ($("#txtCicloEscolar").val() == "" || $("#txtClaveGrp").val() == "" || $("#txtModulo").val() == "" || $("#txtDocente").val() == "" || $("#txtTutor").val() == "" || $("#datepicker").val() == "" || $("#datepicker2").val() == "") {
				swal("Campos incompletos", "Por favor complete los campos obligatorios del formulario.", "error");
				return 0;
			}

			// 2. Preparar Datos
			var formData = {
				TipoGuardar: $("#TipoGuardar").val(),
				txtCicloEscolar: $("#txtCicloEscolar").val(),
				txtClaveGrp: $("#txtClaveGrp").val(),
				txtModulo: $("#txtModulo").val(),
				txtDocente: $("#txtDocente").val(),
				txtTutor: $("#txtTutor").val(),
				datepicker: $("#datepicker").val(),
				datepicker2: $("#datepicker2").val(),
				horariosDetalle: JSON.stringify(horariosSeleccionados)
			};

			// 3. Petición AJAX
			$.ajax({
				url: 'ajax/asignar_materia.php',
				type: 'POST',
				data: formData,
				dataType: 'json', // IMPORTANTE: Indicar que esperamos JSON
				beforeSend: function() {
					$(".bg-maroon").html('<i class="fa fa-refresh fa-spin"></i> Guardando...').prop("disabled", true);
				},
				success: function(response) {
					/* Manejo de alertas según la respuesta del servidor:
					   response.ok  -> true/false
					   response.msg -> El mensaje configurado en el PHP
					*/
					if (response.ok) {
						swal({
							title: "Guardado correctamente",
							text: response.msg,
							type: "success"
						}, function() {
							// Acción después de dar OK a la alerta (ej: recargar o limpiar)
							// window.location.reload();
							document.getElementById("frm").submit();
						});
					} else {
						// Si el servidor dice que no está OK (ej: sesión expirada o duplicado)
						swal("Atención", response.msg, "warning");
					}
				},
				error: function(xhr) {
					// Manejo de errores de conexión o errores 500 del servidor
					console.error(xhr.responseText);
					swal("Error de sistema", "No se pudo procesar la solicitud en el servidor. Intente de nuevo.", "error");
				},
				complete: function() {
					$(".bg-maroon").html('<i class="fa fa-save"></i> Guardar').prop("disabled", false);
				}
			});
		}

		function verificar_espacio() {
			var IdDocente = $("#txtDocente").val();
			var Ini = $("#datepicker").val();
			var Fin = $("#datepicker2").val();
			if (IdDocente && Ini && Fin) {
				$.post("php/clases/getConsulta.php", {
					Tipo: "get_espacio_libre",
					IdDocente: IdDocente,
					Ini: Ini,
					Fin: Fin
				}, function(data) {
					if (data.trim() !== "") {
						$("#div_espacio").show();
						$("#_espacio").html(data);
					} else {
						$("#div_espacio").hide();
					}
				});
			}
		}
	</script>
</body>

</html>