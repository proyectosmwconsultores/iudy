<?php $section = "Estadísticas docente";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está visualizando el reporte de pagos aprobados');
}

$lst = $t->get_doc_list();

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
					Estadísticas docentes
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

								<div class="col-md-12">
									<div class="box-primary">
										<div class="box-body">
											<table class="table table-striped" style="font-size: 12px;">
												<tbody>
													<?php $m = 0;
													$f = 0;
													$n = 0;
													$ci = 0;
													$cf = 0;
													for ($i = 0; $i < sizeof($lst); $i++) {
														$ci = $lst[$i]['IdCampus'];
														if ($ci <> $cf) { ?>
															<tr>
																<th colspan="5"><i class="fa fa-fw fa-fire"></i> <?php echo $lst[$i]['Campus']; ?></th>
															</tr>
															<tr>
																<th colspan="2">NOMBRE DEL DOCENTE</th>
																<th style="text-align: center;">SEXO</th>
																<th style="text-align: center;">FECHA NACIMIENTO</th>
																<th style="text-align: center;">EDAD</th>
															</tr>
														<?php }
														?>
														<tr>
															<td style="width: 10px;"><b><?php echo $n = ($n + 1); ?>.- </b></td>
															<td><?php echo $lst[$i]['APaterno'] . ' ' . $lst[$i]['AMaterno'] . ' ' . $lst[$i]['Nombre']; ?></td>
															<td style="text-align: center;"><?php echo $lst[$i]['Sexo']; ?></td>
															<td style="text-align: center;"><?php echo $lst[$i]['FecNac']; ?></td>
															<td style="text-align: center;"><?php echo calculaedad($lst[$i]['FecNac']); ?></td>
														</tr>
													<?php if ($lst[$i]['Sexo'] == 'H') {
															$h = ($h + 1);
														}
														if ($lst[$i]['Sexo'] == 'M') {
															$m = ($m + 1);
														}
														$cf = $lst[$i]['IdCampus'];
													} ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="col-xs-6">
								</div>
								<div class="col-xs-6">
									<p class="lead">&nbsp;</p>
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<th style="width:50%">DOCENTES HOMBRE:</th>
													<td><?php echo $h; ?></td>
												</tr>
												<tr>
													<th> DOCENTES MUJERES:</th>
													<td><?php echo $m; ?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
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

</body>

</html>