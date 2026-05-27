<?php $_v = 381;
$valor = 0;
$section = "Lista de evaluación";
include("head.php");
if ($_SESSION['IdUsua']) {
	$pagP = $espacio->get_chkEncuenta($_SESSION['IdUsua']);
	$eva = $espacio->get_chkEval($_SESSION['IdUsua']);
	$eval = $espacio->get_chkEvalU($_SESSION['IdUsua']);
	$hoy = date("Y-m-d");
?>
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

	<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
		<div class="wrapper">
			<?php include("menuV.php"); ?>
			<div class="content-wrapper">
				<form name="frm" id="frm" action="viewEvaluacion.php" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>">
					<section class="content-header">
						<h1> <i class="fa fa-edit"></i> Evaluación docente </h1>
						<ol class="breadcrumb">
							<li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
							<li class="active">Evaluación</li>
						</ol>
					</section>
					<section class="content">
						<div class="row">
							<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title">Lista de evaluaciones</h3>
									</div>
									<p style="text-align: center; display: none;" id="img_cargar">
										<img src="assets/images/cargando.gif">
									</p>

									<div class="box-body" id="mostrar_ingresos" style="display: none;"></div>

								</div>
							</div>
						</div>
					</section>
					<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><i class="fa fa-fw fa-exclamation-circle"></i> Realizar evaluación docente</h4>
								</div>
								<div class="modal-body" id="employee_detail">
								</div>
							</div>
						</div>
					</div>
					<div id="dataModal2" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><i class="fa fa-fw fa-exclamation-circle"></i> Realizar encuesta de calidad</h4>
								</div>
								<div class="modal-body" id="employee_detail2">
								</div>
							</div>
						</div>
					</div>
					<div id="dataModal3" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><i class="fa fa-fw fa-exclamation-circle"></i> Realizar encuesta de satisfacción académica</h4>
								</div>
								<div class="modal-body" id="employee_detail3">
								</div>
							</div>
						</div>
					</div>

					<div id="dataModalE" class="modal fade bs-example-modal-lg"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><i class="fa fa-fw fa-exclamation-circle"></i> Realizar evaluación docente</h4>
								</div>
								<div class="modal-body" id="employee_detailE">
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<?php include("footer.php"); ?>
		</div>
		<!-- ./wrapper -->

		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script><!-- Sparkline -->

		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<script src="dist/js/pages/dashboard.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
		<script>
			$(document).ready(function() {
				cargar_lista_evaluacion();
			});

			function cargar_lista_evaluacion() {
				document.getElementById("img_cargar").style.display = 'block';
				document.getElementById("mostrar_ingresos").style.display = 'none';
				var Capa = "#mostrar_ingresos";
				$(Capa).load("vistas/evaluacion/evaluacion_docente_coordinador.php", {}, function(response, status, xhr) {

					if (status == "error") {
						var msg = "Error!, algo ha sucedido: ";
						$(Capa).html(msg + xhr.status + " " + xhr.statusText);
					}
					if (status == "success") {
						document.getElementById("mostrar_ingresos").style.display = 'block';
						document.getElementById("img_cargar").style.display = 'none';
					}
				});
			}


			function realizar_evaluacion_id(IdEvaluacion) {
				$.ajax({
					url: "vistas/evaluacion/realizar_encuesta_coordinador.php",
					method: "POST",
					data: {
						IdEvaluacion: IdEvaluacion
					},
					success: function(data) {
						$('#employee_detailE').html(data);
						$('#dataModalE').modal('show');
					}
				});
			}
		</script>
	</body>

	</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>