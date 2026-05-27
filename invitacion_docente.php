<?php $valor = 3;
$section = "Invitación docente";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de invitacion docente.');
}

$oferta = $t->get_plan_estudios_lic();
$campus = $t->get_campusId();
$lstCiclo = $t->get_cEscolarLst();

$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));
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
					<i class="fa fa-fw fa-file-text-o"></i> Módulo para generar invitación docente
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Docentes</a></li>
					<li class="active">Invitación</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<div class="row">
							<form name="frm" id="frm" action="lista_alumnos.php" method="POST" enctype="multipart/form-data">
								<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden" />
								<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden" />
								<input id="Numero" name="Numero" value="1" type="hidden" />
								<input id="txtClaveGrp" name="txtClaveGrp" value="1" type="hidden" />
								<div class="col-md-5">
									<div class="form-group">
										<label>Campus:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-gears"></i>
											</div>
											<select class="form-control select2" name="txt_campus" id="txt_campus">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($campus); $i++) { ?>
													<option value="<?php echo $campus[$i]["IdCampus"]; ?>"> <?php echo $campus[$i]["Campus"]; ?> </option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="form-group">
										<label>Periodo escolar:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-gears"></i>
											</div>
											<select class="form-control select2" name="txt_ciclo" id="txt_ciclo">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($lstCiclo); $i++) { ?>
													<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"><?php echo $lstCiclo[$i]["Tipo"]; ?> - <?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
												<?php } ?>
											</select>
											<span class="input-group-btn">
												<button onclick="lista_alumnos_activos()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Buscar</button>
											</span>
										</div>
									</div>
								</div>
								<div class="col-xs-12">
									<div class="box" id="mi_lista_materias"></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>

		<div id="data_fact_gene" class="modal fade bs-example-modal-lg">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-gears"></i> Generar invitación de materia</h4>
					</div>

					<div class="modal-body" id="employee_fact_gene">
					</div>
				</div>
			</div>
		</div>

		<!-- jQuery 3 -->
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

	<!-- jQuery 3 -->


	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- Page script -->

	<script>
		$(function() {
			$('.select2').select2()

		})

		function lista_alumnos_activos() {
			var IdCampus = document.getElementById("txt_campus").value;
			var IdCiclo = document.getElementById("txt_ciclo").value;
			document.getElementById("mi_lista_materias").style.display = 'none';

			if (!IdCampus) {
				swal("Error al buscar", "Debe seleccionar el campus.", "error");
				return 0;
			}
			if (!IdCiclo) {
				swal("Error al buscar", "Debe seleccionar el ciclo.", "error");
				return 0;
			}
			document.getElementById("mi_lista_materias").style.display = 'block';
			var Capa = "#mi_lista_materias";
			$(Capa).load("reportes/lista_invitaciones.php", {
				IdCampus: IdCampus,
				IdCiclo: IdCiclo
			}, function(response, status, xhr) {
				if (status == "error") {
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
			});
		}

	function generar_invitacion(IdCampus, IdCiclo, IdGrupo) {
		$.ajax({
			url: "vistas/coordinacion/generar_invitacion_id.php",
			method: "POST",
			data: {
				IdCampus: IdCampus, IdCiclo: IdCiclo, IdGrupo: IdGrupo
			},
			success: function(data) {
				$('#employee_fact_gene').html(data);
				$('#data_fact_gene').modal('show');
			}
		});
	}

	function recargar_ventana(IdCampus, IdCiclo) {
		var IdGrupo = document.getElementById("txt_grupo_sel").value;

		$.ajax({
			url: "vistas/coordinacion/generar_invitacion_id.php",
			method: "POST",
			data: {
				IdCampus: IdCampus, IdCiclo: IdCiclo, IdGrupo: IdGrupo
			},
			success: function(data) {
				$('#employee_fact_gene').html(data);
				$('#data_fact_gene').modal('show');
			}
		});
	}

	function loading() {
		swal({
			title: "Enviando invitación",
			text: "Por favor espere...",
			imageUrl: "https://api.valida-curp.com.mx/panel/images/gears.gif",
		});
	}
	
	function generar_invitacion_id(IdCampus,IdCiclo){
		var IdGrupo = document.getElementById("txt_grupo_sel").value;
		var IdModulo = document.getElementById("txt_materia_sel").value;
		var IdDocente = document.getElementById("txt_docente_sel").value;
		var IdCoordinador = document.getElementById("txt_coordinador_sel").value;
		var Inicio = document.getElementById("txt_fecha_ini").value;
		var Final = document.getElementById("txt_fecha_fin").value;

		var TipoGuardar = 'invitacion_docente_id';
		if (IdGrupo == '') {
			swal("Error al guardar", "Debe seleccionar el grupo.", "error");
			document.getElementById("txt_grupo_sel").focus();
			return 0;
		}
		if (IdModulo == '') {
			swal("Error al guardar", "Debe seleccionar la materia.", "error");
			document.getElementById("txt_materia_sel").focus();
			return 0;
		}
		if (IdDocente == '') {
			swal("Error al guardar", "Debe seleccionar al docente.", "error");
			document.getElementById("txt_docente_sel").focus();
			return 0;
		}
		if (IdCoordinador == '') {
			swal("Error al guardar", "Debe seleccionar el coordinador académico.", "error");
			document.getElementById("txt_coordinador_sel").focus();
			return 0;
		}
		if (Inicio == '') {
			swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
			document.getElementById("txt_fecha_ini").focus();
			return 0;
		}
		if (Final == '') {
			swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
			document.getElementById("txt_fecha_fin").focus();
			return 0;
		}

		swal({
				title: "\u00BFEst\u00E1 seguro que desea generar estar invitación al docente?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
			},
			function(isConfirm) {
				if (isConfirm) {
					loading();
					$(".confirm").attr('disabled', 'disabled');
					$.ajax({
							type: "POST",
							url: "vistas/coordinacion/sav_coordinacion.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdCampus: IdCampus,
								IdCiclo: IdCiclo,
								IdGrupo: IdGrupo,
								IdModulo: IdModulo,
								IdDocente: IdDocente,
								IdCoordinador: IdCoordinador,
								Inicio:Inicio,
								Final: Final 
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								lista_alumnos_activos();
								swal("Enviado correctamente", "La invitación al docente se ha generado correctamente.", "success");
								$('#dataModalMod').modal('hide');
							}
							if (data == 2) {
								swal("Ha ocurrido un error", "La materia ya lo tiene asigando un docente, favor de revisar.", "error");
							}
							if (data == 0) {
								swal("Ha ocurrido un error", "No se ha podido guardar", "error");
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