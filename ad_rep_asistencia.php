<?php $valor = 3;
$section = "Módulo de asistencia";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de reporte de asistencia.');
}

$campusId = $t->get_campusPermiso($_SESSION['IdUsua']);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<script src="assets/grafica/highcharts.js"></script>
<script src="assets/grafica/data.js"></script>
<script src="assets/grafica/exporting.js"></script>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-bell"></i> Reporte de asistencia de los alumnos por materia
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumnos</a></li>
					<li class="active">Reporte de asistencia</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<div class="row">
							<form name="frm" id="frm" action="ad_rep_asistencia.php" method="POST" enctype="multipart/form-data">
								<div class="col-md-6">
									<div class="box-primary">
										<div class="form-group">
											<label>Campus:</label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-bank"></i>
												</div>
												<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="cargar_grupo(<?php echo $_SESSION['IdUsua']; ?>)">
													<option value=""> - Seleccione - </option>
													<?php for ($i = 0; $i < sizeof($campusId); $i++) { ?>
														<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"><?php echo $campusId[$i]["Campus"]; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label>CveGrupo:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-fw fa-key"></i>
											</div>
											<select class="form-control select2" name="txtClaveGrp" id="txtClaveGrp">
												<option value=""> - Seleccione - </option>
											</select>
											<span class="input-group-btn">
												<button type="button" onclick="cargar_lista_mat()" class="btn btn-info btn-flat">Consultar</button>
											</span>
										</div>
									</div>
								</div>


								<div class="col-xs-12">
									<div class="col-xs-12" style="position: absolute; z-index:0; text-align: center; display: none;" id="btn_img">
										<img src="assets/images/procesando.gif">
									</div>
									<div class="box" id="panel_alumnos_lista"></div>
								</div>

								<div class="col-xs-12">
									<div class="box" id="panel_grafica"></div>
								</div>

							</form>
						</div>
					</div>
				</div>
			</section>
		</div>

		<div id="dataProm" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-cog"></i> Configurar carga de promedio</h4>
					</div>
					<div class="modal-body" id="employee_prom">
					</div>
				</div>
			</div>
		</div>

		<div id="dataFondo" class="modal fade bs-example-modal-lg"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-cog"></i> Pase de lista de asistencia</h4>
					</div>
					<div class="modal-body" id="employee_fondo">
					</div>
				</div>
			</div>
		</div>

		<div id="dataGra" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-line-chart"></i> Gráfica de asistencia</h4>
					</div>
					<div class="modal-body" id="employee_Gra">
					</div>
				</div>
			</div>
		</div>

		<div id="dataxGrax" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-line-chart"></i> Gráfica de asistencia del Periodo Escolar</h4>
					</div>
					<div class="modal-body" id="employee_xGrapx">
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

		function load_materiasx() {
			var IdGrupo = document.getElementById("txtClaveGrp").value;
			var IdCiclo = document.getElementById("txtCiclo").value;
			$.ajax({
				url: "formConsulta/config_mat_promedio.php",
				method: "POST",
				data: {
					IdCiclo: IdCiclo,
					IdGrupo: IdGrupo
				},
				success: function(data) {
					$('#employee_prom').html(data);
					$('#dataProm').modal('show');
				}
			});
		}

		function cargar_grupo(IdUsua) {
			// document.getElementById("btn_img").style.display = 'block';
			var IdCampus = document.getElementById("txtCampus").value;
			var Tipo = "get_lst_grupos_id_campus";
			$.post("php/clases/getConsulta.php", {
				Tipo: Tipo,
				IdCampus: IdCampus,
				IdUsua: IdUsua
			}, function(data) {
				$("#txtClaveGrp").html(data);
			});
			// document.getElementById("btn_img").style.display = 'none';
		}

		function cargar_lista_mat() {
			document.getElementById("panel_grafica").style.display = 'none';
			document.getElementById("panel_alumnos_lista").style.display = 'none';
			document.getElementById("btn_img").style.display = "block";


			var IdCampus = document.getElementById("txtCampus").value;
			var IdGrupo = document.getElementById("txtClaveGrp").value;

			if (!IdCampus) {
				swal("Error al buscar", "No seleccionado el Campus.", "error");
				return 0;
			}
			document.getElementById("panel_alumnos_lista").style.display = 'block';
			var Capa = "#panel_alumnos_lista";
			$(Capa).load("dashboard/asistencia_materia_all.php", {
				IdCampus: IdCampus,
				IdGrupo: IdGrupo
			}, function(response, status, xhr) {
				if (status == "error") {
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
			});

		}

		function mostrar_grafica(IdCampus,IdGrupo,IdAsignacion) {
			document.getElementById("panel_grafica").style.display = 'none';
			if (!IdAsignacion) {
				swal("Error al consultar", "No se ha encontrado la materia seleccionada.", "error");
				return 0;
			}
			document.getElementById("panel_grafica").style.display = 'block';
			var Capa = "#panel_grafica";
			$(Capa).load("dashboard/asistencia_materia_id.php", {
				IdCampus: IdCampus,
				IdGrupo: IdGrupo,
				IdAsignacion: IdAsignacion
			}, function(response, status, xhr) {
				if (status == "error") {
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
			});

		}




		function cargar_lista_asistencia() {
			document.getElementById("miTablaEvaluacion").style.display = 'block';
			document.getElementById("btn_img").style.display = 'block';
			var IdAsignacion = document.getElementById("IdAsignacion").value;

			var Capa = "#miTablaEvaluacion";

			$(Capa).load("formConsulta/lista_asistencia.php", {
				IdAsignacion: IdAsignacion
			}, function(response, status, xhr) {
				if (status == "error") {
					alert(status);
					var msg = "Error!, algo ha sucedido: ";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
			});
			document.getElementById("btn_img").style.display = 'none';
		}


		$(document).ready(function() {
			$(document).on('click', '.view_grafica_id', function() {
				var IdAsignacion = $(this).attr("id");

				$.ajax({
					url: "formConsulta/grafica_asistencia_grupo.php",
					method: "POST",
					data: {
						IdAsignacion: IdAsignacion
					},
					success: function(data) {
						$('#employee_Gra').html(data);
						$('#dataGra').modal('show');
					}
				});
			});
		});

		$(document).ready(function() {
			$(document).on('click', '.view_gra', function() {
				var IdCiclo = $(this).attr("id");

				$.ajax({
					url: "formConsulta/grafica_asistencia_ciclo.php",
					method: "POST",
					data: {
						IdCiclo: IdCiclo
					},
					success: function(data) {
						$('#employee_xGrapx').html(data);
						$('#dataxGrax').modal('show');
					}
				});
			});
		});
	</script>
</body>

</html>