<?php $_v = 39;
$valor = 0;
$section = "Asignaturas activas";
include("head.php");
if ($_SESSION['IdUsua']) {
	$ciclo = $t->get_ciclo_activo();

	unset($_SESSION['IdAsignacion']);
	unset($_SESSION['IdOferta']);
	unset($_SESSION['EstatusAsig']);
	//$checarEstatus=$t->get_checarEstatus();

?>
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

	<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
		<div class="wrapper">
			<?php include("menuV.php"); ?>
			<div class="content-wrapper">
				<form name="frm" id="frm" action="viewSupervisor.php" method="POST" enctype="multipart/form-data">

					<section class="content-header">
						<h1>
							Asignaturas modo supervisor
						</h1>
						<ol class="breadcrumb">
							<li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
							<li class="active">Asignaturas</li>
						</ol>
					</section>
					<section class="content">
						<div class="row">
							<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title">Lista de asignaturas</h3>
									</div>
									
									<div class="col-md-12">
										<p style="text-align: center; display: none;" id="img_cargar">
											<img src="assets/images/cargando.gif">
										</p>
										<div class="box" id="panel_lista_calendario"></div>
									</div>
									<div class="box-body">
									</div>
								</div>
							</div>
						</div>
					</section>
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

		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script><!-- Sparkline -->
		<!-- AdminLTE App -->
		<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<script src="dist/js/pages/dashboard.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
		<script>
			$(function() {
				$('#example1').DataTable()
				cargar_calendario();
			})

			function cargar_calendario() {
				document.getElementById("img_cargar").style.display = 'block';
				document.getElementById("panel_lista_calendario").style.display = 'none';
				var Capa = "#panel_lista_calendario";
				$(Capa).load("vistas/coordinador/lista_materias_activas.php", {
				}, function(response, status, xhr) {
					if (status == "error") {
						var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
						$(Capa).html(msg + xhr.status + " " + xhr.statusText);
					}
					if (status == "success") {
						document.getElementById("panel_lista_calendario").style.display = 'block';
						document.getElementById("img_cargar").style.display = 'none';
					}
				});
			}
		</script>
	</body>

	</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>