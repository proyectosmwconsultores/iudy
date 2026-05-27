<?php $valor = 3;
$section = "Seguimiento actividades";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de seguimienyo de actividades.');
}
$cicloId = $t->get_all_ciclos_actual();
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-qrcode"></i> Seguimiento de actividades
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumnos</a></li>
					<li class="active">Materias asignadas</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<div class="row">
							<form name="frm" id="frm" action="materias_asignadas.php" method="POST" enctype="multipart/form-data">
								<div class="col-md-5">
									<div class="form-group">
										<label>Periodo escolar:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-fw fa-key"></i>
											</div>
											<select class="form-control select2" name="txtCiclo" id="txtCiclo" onchange="cargar_grupo_reg(<?php echo $_SESSION['IdUsua']; ?>)">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($cicloId); $i++) { ?>
													<option value="<?php echo $cicloId[$i]["IdCiclo"]; ?>"><?php echo $cicloId[$i]["Tipo"]; ?> - <?php echo $cicloId[$i]["Ciclo"]; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="form-group">
										<label>Grupo:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-fw fa-key"></i>
											</div>
											<select class="form-control select2" name="txtClaveGrp" id="txtClaveGrp">
												<option value=""> - Seleccione - </option>
											</select>
											<span class="input-group-btn">
												<button onclick="load_user_lista()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Consultar</button>
											</span>
										</div>
									</div>
								</div>

								<div class="col-xs-12">
									<p style="text-align: center; display: none;" id="img_cargar">
										<img src="assets/images/cargando.gif">
									</p>
									<div class="box" id="mi_lista_materias"></div>
								</div>

								<div class="col-xs-12">
									<p style="text-align: center; display: none;" id="img_cargar2">
										<img src="assets/images/cargando.gif">
									</p>
									<div class="box" id="panel_actividades"></div>
								</div>

							</form>
						</div>
					</div>
				</div>
			</section>
		</div>

		<div id="dataModalHor" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-clock-o"></i> Seguimiento de actividades</h4>
					</div>
					<div class="modal-body" id="employee_detailHor">
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

	<script>
		$(function() {
			$('.select2').select2()
		})

		function load_user_lista() {
			var IdGrupo = document.getElementById("txtClaveGrp").value;
			var IdCiclo = document.getElementById("txtCiclo").value;

			if (!IdCiclo) {
				swal("Error al buscar", "Debe seleccionar el Periodo Escolar.", "error");
				return 0;
			}
			if (!IdGrupo) {
				swal("Error al buscar", "Debe seleccionar el Grupo.", "error");
				return 0;
			}
			document.getElementById("img_cargar").style.display = 'block';
			document.getElementById("mi_lista_materias").style.display = 'none';
			var Capa = "#mi_lista_materias";
			$(Capa).load("vistas/coordinador/seguimiento_actividades_generadas.php", {
				IdCiclo: IdCiclo,
				IdGrupo: IdGrupo
			}, function(response, status, xhr) {
				if (status == "error") {
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
				if (status == "success") {
					document.getElementById("mi_lista_materias").style.display = 'block';
					document.getElementById("img_cargar").style.display = 'none';
				}
			});

		}

		function cargar_grupo_reg(IdUsua) {
			var IdCiclo = document.getElementById("txtCiclo").value;
			var Tipo = "grpos_materias_asignadas";
			$.post("php/clases/getConsulta.php", {
				Tipo: Tipo,
				IdCiclo: IdCiclo,
				IdUsua: IdUsua
			}, function(data) {
				$("#txtClaveGrp").html(data);
			});
		}

		function mostrar_seguimiento(IdAsignacion) {
			document.getElementById("img_cargar2").style.display = 'block';
			document.getElementById("panel_actividades").style.display = 'none';
			var Capa = "#panel_actividades";
			$(Capa).load("vistas/coordinador/reporte_actividades_generadas.php", {
				IdAsignacion: IdAsignacion
			}, function(response, status, xhr) {
				if (status == "error") {
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
				if (status == "success") {
					document.getElementById("panel_actividades").style.display = 'block';
					document.getElementById("img_cargar2").style.display = 'none';
				}
			});
		}

		function vst_lista_tareas_alumno(IdAsignacion, IdActividad) {
			$.ajax({
				url: "vistas/coordinador/vst_lista_tareas_alumno.php",
				method: "POST",
				data: {
					IdAsignacion: IdAsignacion,
					IdActividad: IdActividad
				},
				success: function(data) {
					$('#employee_detailHor').html(data);
					$('#dataModalHor').modal('show');
				}
			});
		}
	</script>
</body>

</html>