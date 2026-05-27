<?php $section = "Estadísticas";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está visualizando el reporte de pagos aprobados');
}

$campus = $t->get_campusPermiso($_SESSION['IdUsua']);
$ciclo = $t->get_all_ciclos();

?>
<script src="assets/grafica/highcharts.js"></script>
<script src="assets/grafica/data.js"></script>
<script src="assets/grafica/exporting.js"></script>
<script src="assets/_dist/html2pdf.bundle.js"></script>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">

	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">

			<section class="content-header">
				<h1>
					Estadísticas alumnos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Dashborad</a></li>
					<li class="active">Estadística</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="dashboard_matricula.php" method="POST" enctype="multipart/form-data">
					<div class="box box-default">
						<div class="box-body">
							<div class="row">
								<div class="col-md-4">
									<div class="box-primary">
									</div>
								</div>
								<div class="col-md-8">
									<div class="box-primary">
										<div class="box-body">
											<div class="form-group">
												<label>Periodo escolar:</label>
												<div class="input-group">
													<div class="input-group-addon"><i class="fa fa-book"></i></div>
													<select class="form-control" name="txt_ciclo" id="txt_ciclo">
														<option value=""> - Seleccione - </option>
														<?php for ($i = 0; $i < sizeof($ciclo); $i++) { ?>
															<option value="<?php echo $ciclo[$i]["IdCiclo"]; ?>"><?php echo $ciclo[$i]["Tipo"]; ?> - <?php echo $ciclo[$i]["Ciclo"]; ?></option>
														<?php } ?>
													</select>
													<span class="input-group-btn">
														<button onclick="cargar_datos()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Consultar</button>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-12">
								</div>
							</div>
						</div>
					</div>

					<p style="text-align: center; display: none;" id="img_cargar">
						<img src="assets/images/cargando.gif">
					</p>
					<div id="mostrar_datos"></div>

				</form>
			</section>

		</div>



		<?php include("footer.php"); ?>
	</div>
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- Sparkline -->

	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<script>
		function cargar_datos() {
			var IdCampus = 1;
			var IdCiclo = document.getElementById("txt_ciclo").value;

			document.getElementById("img_cargar").style.display = 'block';
			document.getElementById("mostrar_datos").style.display = 'none';
			var Capa = "#mostrar_datos";
			$(Capa).load("formConsulta/estadista_universidad.php", {
				IdCampus: IdCampus,
				IdCiclo: IdCiclo
			}, function(response, status, xhr) {

				if (status == "error") {
					var msg = "Error!, algo ha sucedido: ";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
				if (status == "success") {

					document.getElementById("mostrar_datos").style.display = 'block';
					document.getElementById("img_cargar").style.display = 'none';
				}
			});
		}
	</script>
</body>

</html>
<?php unset($_SESSION['Alerta']);  ?>