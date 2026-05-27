<?php $valor = 3;
$section = "Calendario de materias";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de calendario de materias asignadas.');
}

$campusId = $t->get_campusPermiso($_SESSION['IdUsua']);
$cicloId = $t->get_all_ciclos_actual();
$dias = $t->get_get_dias();

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-calendar"></i> Calendario de materias asignadas en un periodo escolar
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Calendario</a></li>
					<li class="active">Materias asignadas</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<div class="row">
							<form name="frm" id="frm" action="ad_rep_trayectoria_cal.php" method="POST" enctype="multipart/form-data">
								<div class="col-md-4">
									<div class="box-primary">
										<div class="form-group">
											<label>Campus:</label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-bank"></i>
												</div>
												<select class="form-control select2" name="txtCampus" id="txtCampus">
													<option value=""> - Seleccione - </option>
													<?php for ($i = 0; $i < sizeof($campusId); $i++) { ?>
														<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"><?php echo $campusId[$i]["Campus"]; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
								</div>


								<div class="col-md-4">
									<div class="form-group">
										<label>Periodo escolar:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-fw fa-key"></i>
											</div>
											<select class="form-control select2" name="txtCiclo" id="txtCiclo">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($cicloId); $i++) { ?>
													<option value="<?php echo $cicloId[$i]["IdCiclo"]; ?>"><?php echo $cicloId[$i]["Tipo"]; ?> - <?php echo $cicloId[$i]["Ciclo"]; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Dia:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-fw fa-key"></i>
											</div>
											<select class="form-control select2" name="txtDias" id="txtDias">
												<option value=""> - Seleccione - </option>
												<option value="T">TODOS</option>
												<?php for ($i = 0; $i < sizeof($dias); $i++) { ?>
													<option value="<?php echo $dias[$i]["Dia"]; ?>"><?php echo $dias[$i]["_Dias"]; ?></option>
												<?php } ?>
											</select>
											<span class="input-group-btn">
												<button onclick="cargar_calendario()" type="button" class="btn btn-info btn-flat"> <i class="fa fa-fw fa-search"></i>Buscar</button>
											</span>
										</div>
									</div>
								</div>

								<div class="col-xs-12">
								<p style="text-align: center; display: none;" id="img_cargar">
									<img src="assets/images/cargando.gif">
								</p>
									<div class="box" id="panel_lista_calendario"></div>
								</div>

							</form>
						</div>
					</div>
				</div>
			</section>
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

		function cargar_calendario() {
			

			var IdCampus = document.getElementById("txtCampus").value;
			var IdCiclo = document.getElementById("txtCiclo").value;
			var Dias = document.getElementById("txtDias").value;
			if (!IdCampus) {
				swal("Error al buscar", "No ha seleccionado el Campus.", "error");
				document.getElementById("btn_img").style.display = "none";
				return 0;
			}
			if (!IdCiclo) {
				swal("Error al buscar", "No ha seleccionado el periodo escolar.", "error");
				document.getElementById("btn_img").style.display = "none";
				return 0;
			}

			if (!Dias) {
				swal("Error al buscar", "No ha seleccionado el el dia de clasesr.", "error");
				document.getElementById("btn_img").style.display = "none";
				return 0;
			}

			document.getElementById("img_cargar").style.display = 'block';
			document.getElementById("panel_lista_calendario").style.display = 'none';
			var Capa = "#panel_lista_calendario";
			$(Capa).load("dashboard/calendario_materias_asignadas.php", {
				IdCampus: IdCampus,
				IdCiclo: IdCiclo,
				Dias: Dias
			}, function(response, status, xhr) {
				if (status == "error") {
					alert(status);
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
				if (status == "success") {
					document.getElementById("panel_lista_calendario").style.display = 'block';
					document.getElementById("img_cargar").style.display = 'none';
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
	</script>
</body>

</html>