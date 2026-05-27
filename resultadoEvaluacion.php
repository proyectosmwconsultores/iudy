<?php $_v = 186;
$section = "Resultado de evaluación";
include("head.php");
if ($_SESSION['IdUsua']) {
	$moduloA = $t->get_materias_finalizas_eva($_SESSION['IdUsua']);

	$moduloAlumFin = $t->get_modFinaAlum($_SESSION['IdUsua']);
	if ($_SESSION['Permisos'] != 5) {
		$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Esta en visualizando las el modulo de resultado de evaluación');
	}
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
				<form name="frm" id="frm" action="viewFinalizados.php" method="POST" enctype="multipart/form-data">
					<?php if (isset($_GET["x"]) && ($_GET["x"] == "x")) { ?>
						<div style="padding: 20px 30px; background: rgb(243, 58, 18) none repeat scroll 0% 0%; z-index: 999999; font-size: 16px; font-weight: 600;">Favor de realizar la encuesta que tenga pendiente.</a></div><?php } ?>
					<section class="content-header">
						<h1>Lista de asignaturas finalizadas</h1>
						<ol class="breadcrumb">
							<li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
							<li class="active">Asignaturas finalizadas</li>
						</ol>
					</section>
					<section class="content">
						<?php if (($_SESSION['Permisos'] == "2") || ($_SESSION['Permisos'] == "4")) { ?>
							<div class="row">
								<div class="col-xs-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Lista de asignaturas finalizadas</h3>
										</div>
										<div class="box-body">
											<table id="example1" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>Oferta</th>
														<th>Nombre de la asignatura</th>
														<th>CveGrupo</th>
														<th>Fecha</th>
														<th>Resultado</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($x = 0; $x < sizeof($moduloA); $x++) {  ?>
														<tr>
															<td><?php echo $moduloA[$x]["Nombre"]; ?></td>
															<td><?php echo $moduloA[$x]["NombreMod"]; ?></td>
															<td><?php echo $moduloA[$x]["CveGrupo"]; ?></td>
															<td><?php echo $moduloA[$x]["FecIni"] . ' al ' . $moduloA[$x]["FecFin"]; ?></td>
															<td <?php if (isset($moduloA[$x]["_alum"])) { ?> style="text-align: center; cursor: pointer;" onclick="mostrar_concentrado('<?php echo $moduloA[$x]["IdAsignacion"]; ?>')" <?php } else { echo "style='text-align: center; cursor: wait;'"; } ?>><?php if (isset($moduloA[$x]["_promedio"])) { echo '<b>' . $moduloA[$x]["_promedio"] . '% </b>'; } else { echo "<b style='color: blue;'> <i class='fa fa-fw fa-bell'></i> DESCUBRE TU RESULTADO </b> "; } ?></td>
															</td>
														</tr>
													<?php }  ?>
													</tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</section>
				</form>
			</div>
			<?php include("footer.php"); ?>
		</div>


		<div id="data_concentrado" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-flag"></i> Resultado de la evaluación docente</h4>
					</div>
					<div class="modal-body" id="employee_con">
					</div>
				</div>
			</div>
		</div>
		<!-- ./wrapper -->

		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
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
			})

			function mostrar_concentrado(IdAsignacion) {
				$.ajax({
			url: "vistas/admin/evaluacion_concentrado.php",
			method: "POST",
			data: {
				IdAsignacion: IdAsignacion
			},
			success: function(data) {
				$('#employee_con').html(data);
				$('#data_concentrado').modal('show');
			}
		});
			}
		</script>
	</body>

	</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>