<?php $section = "Vista de la planeación";
$_v = 89;
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en la vista de la planeación académica');
}
if ($_SESSION['Permisos']) {
	// $t->get_validar_mat_doc($_GET["idToks"],$_SESSION['IdUsua']);
	$AsignacionId = $t->get_datosModuloD($_GET["idToks"]);
	$lst_conten = $contenido->get_lst_contenido($_GET['idToks']);

?>
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

	<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
		<div class="wrapper">
			<?php include("menuV.php"); ?>
			<div class="content-wrapper">
				<?php if ($_SESSION['EstatusAsig'] == "F") {
					include("formConsulta/alerta.php");
				} ?>
				<section class="content-header">
					<h1> <?php echo $AsignacionId[0]["NombreMod"]; ?></h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-book"></i>Planeación</a></li>
						<li class="active"><a href="#">Vista de la planeación</a></li>
					</ol>
				</section>
				<section class="content">
					<div class="unidad-grid">
					<?php if (!empty($lst_conten) && sizeof($lst_conten) > 0) { ?>
						<?php for ($c = 0; $c < sizeof($lst_conten); $c++) { ?>
							<div class="unidad-card"
								style="cursor: pointer;" onclick="window.open('vistaContenido.php?idToks=<?php echo $_GET['idToks']; ?>&id=<?php echo $lst_conten[$c]['IdParcialDocente'] . '_' . $lst_conten[$c]['IdSemanaDocente']; ?>','_self')" >
								<div class="unidad-img">
									<img src="assets/fondo/img_1<?php echo $lst_conten[$c]['NoSemana']; ?>.jpg" alt="">
									<span class="badge-parcial">
										<i class="fa fa-fw fa-check-square-o"></i>
										<?php echo $lst_conten[$c]['Titulo']; ?>
									</span>
								</div>
								<div class="unidad-body">
									<div class="unidad-header">
										<span class="unidad-titulo">
											<i class="fa fa-fw fa-toggle-right"></i>
											<?php if(isset($lst_conten[$c]['Etiqueta_semana'])) { echo substr($lst_conten[$c]['Etiqueta_semana'], 0, 60); } else { echo "---"; } ?>
										</span>
									</div>
									<p class="unidad-tema">
										<strong><i class="fa fa-fw fa-chevron-circle-right"></i> Tema:</strong>
										<?php if(isset($lst_conten[$c]['Semana'])) { echo substr($lst_conten[$c]['Semana'], 0, 150); }  else { echo "---"; } ?>
									</p>
									<div class="unidad-footer">
										<span class="lecciones">
											<i class="fa fa-book"></i>
											<?php echo $lst_conten[$c]['NoLeccion']; ?> Lecciones
										</span>
										<div class="progress-bar">
											<div class="progress"></div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

					<?php } else { ?>
						<div class="contenido-empty-state">
							<div class="contenido-empty-icon">
								<i class="fa fa-book"></i>
							</div>
							<h4>Aún no hay contenido disponible</h4>
							<p>
								Por el momento esta materia no tiene unidades o lecciones publicadas.
								Cuando el docente habilite el contenido del curso, aparecerá en esta sección.
							</p>
							<div class="contenido-empty-note">
								<i class="fa fa-info-circle"></i>
								Revisa más tarde para consultar nuevas unidades.
							</div>
						</div>
					<?php } ?>
				</div>


				</section>
			</div>
			<?php include("footer.php"); ?>
		</div>
		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>

	</body>

	</html>
<?php
} else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>