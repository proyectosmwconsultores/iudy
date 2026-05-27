<?php $section = "Reporte de bajas";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está visualizando el reporte de bajas');
}

$cicloId = $t->get_all_ciclos();

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
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
					Reporte analítico de bajas
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Reportes</a></li>
					<li class="active">Bajas</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="repBajas.php" method="POST" enctype="multipart/form-data">
					<div class="box box-default">
						<div class="box-body">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">

									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<label>Ciclo escolar:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-gears"></i>
											</div>
											<select class="form-control select2" name="txtCiclo" id="txtCiclo">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($cicloId); $i++) { ?>
													<option value="<?php echo $cicloId[$i]["IdCiclo"]; ?>"><?php echo $cicloId[$i]["Tipo"]; ?> - <?php echo $cicloId[$i]["Ciclo"]; ?></option>
												<?php } ?>
											</select>
											<span class="input-group-btn">
												<button onclick="cargar_lista_bajas()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Buscar</button>
											</span>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="box">
										<div class="box-body">
											<p style="text-align: center; display: none;" id="img_cargar">
												<img src="assets/images/cargando.gif">
											</p>
											<div class="table-responsive" id="panel_baja_alumnos">
											</div>
										</div>
									</div>


								</div>
							</div>
						</div>
					</div>

				</form>
			</section>
		</div>
		<div id="dataModal_del" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar estatus del alumno en la Plataforma</h4>
					</div>
					<div class="modal-body" id="employee_detail_del">
					</div>
				</div>
			</div>
		</div>

		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2 -->
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>

		<!-- Custom and plugin javascript -->
		<!-- <script src="assets/table/js/scriptAgregado1.js"></script> -->
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
		<?php include("footer.php"); ?>
	</div>



	<!-- Page script -->
	<script>
		function cargar_lista_bajas() {
			var IdCiclo = document.getElementById("txtCiclo").value;
			if (!IdCiclo) {
				swal("Error al buscar", "No seleccionado el Ciclo Escolar.", "error");
				return 0;
			}
			document.getElementById("img_cargar").style.display = 'block';
			document.getElementById("panel_baja_alumnos").style.display = 'block';
			var Capa = "#panel_baja_alumnos";
			$(Capa).load("vistas/coordinacion/reporte_reprobados.php", {
				IdCiclo: IdCiclo
			}, function(response, status, xhr) {
				if (status == "error") { 
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
				if (status == "success") {
						document.getElementById("panel_baja_alumnos").style.display = 'block';
						document.getElementById("img_cargar").style.display = 'none';
					}
			});
		}

		function del_alumnoIdx(IdUsua, IdCiclo, IdCampus) {
			$.ajax({
				url: "formConsulta/upd_eliminarAlumno.php",
				method: "POST",
				data: {
					IdUsua: IdUsua,
					IdCiclo: IdCiclo,
					IdCampus: IdCampus
				},
				success: function(data) {
					$('#employee_detail_del').html(data);
					$('#dataModal_del').modal('show');
				}
			});
		}
	</script>
</body>

</html>
<?php unset($_SESSION['Alerta']);  ?>