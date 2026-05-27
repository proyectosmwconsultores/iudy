<?php $_v = 2;
$section = "Mi contenido";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'El usuario ha ingresado a la materia.');
}
$contenido->get_validar_mat($_GET['idAsignacion'], $_SESSION['IdUsua']);
$materia = $t->get_datosModuloD($_GET['idAsignacion']);
$lst_conten = $contenido->get_lst_contenido($_GET['idAsignacion']);
$IdGrado = $materia[0]['IdGrado'];
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<div class="topbar-planeacion">
				<div class="topbar-planeacion__left">
					<h1> <i class="fa fa-flag"></i> MI CONTENIDO </h1>
				</div>
				<div class="topbar-planeacion__right">
					<span>MATERIA</span>
					<i class="fa fa-angle-right"></i>
					<span class="active"><?php echo $materia[0]['NombreMod']; ?></span>
				</div>
			</div>
			<section class="content">
				<div class="unidad-grid">
					<?php if (!empty($lst_conten) && sizeof($lst_conten) > 0) { ?>
						<?php for ($c = 0; $c < sizeof($lst_conten); $c++) { ?>
							<div class="unidad-card"
								style="cursor: pointer;" onclick="window.open('miAula.php?idAsignacion=<?php echo $_GET['idAsignacion']; ?>&idToks=<?php echo $lst_conten[$c]['IdParcialDocente'] . '_' . $lst_conten[$c]['IdSemanaDocente']; ?>','_self')">
								<div class="unidad-img">
									<img src="assets/fondo/img_<?php echo $lst_conten[$c]['NoSemana']; ?>.jpg" alt="">
									<span class="badge-parcial">
										<i class="fa fa-fw fa-check-square-o"></i>
										<?php echo $lst_conten[$c]['Titulo']; ?>
									</span>
								</div>
								<div class="unidad-body">
									<div class="unidad-header">
										<span class="unidad-titulo">
											<i class="fa fa-fw fa-toggle-right"></i>
											<?php echo substr($lst_conten[$c]['Etiqueta_semana'], 0, 60); ?>
										</span>
									</div>
									<p class="unidad-tema">
										<strong><i class="fa fa-fw fa-chevron-circle-right"></i> Tema:</strong>
										<?php echo substr($lst_conten[$c]['Semana'], 0, 150); ?>
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

				<div id="dataTar" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header" style="background: #5a284f; color: #fbeb00; font-size: 16px;">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">
									<i class="fa fa-fw fa-quote-left"></i>
									<b id="lbl_par"></b>
								</h4>
							</div>
							<div class="modal-body" id="employee_tar">
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php include("footer.php"); ?>
	</div>
	<!-- ./wrapper -->

	<!-- jQuery 3 -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Select2 -->
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<script>
		function mostrarPresentacion(IdParcial) {
			var IdAsignacion = document.getElementById("idAsignacion").value;

			$.ajax({
				url: "formConsulta/mostrarPresentacion.php",
				method: "POST",
				data: {
					IdAsignacion: IdAsignacion,
					IdParcial: IdParcial
				},
				success: function(data) {
					$('#employee_tar').html(data);
					$('#dataTar').modal('show');
				}
			});
		}
	</script>
</body>

</html>