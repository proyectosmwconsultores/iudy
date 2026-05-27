<?php $mnA = 5;
$valor = 3;
$section = "Video tutoriales";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está la lista de ayuda');
}

$id = $_SESSION["Permisos"];
if (($id == 1) || ($id == 6) || ($id == 7)) {
	$idX = 1;
} else {
	$idX = $_SESSION["Permisos"];
}


?>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<?php if ($_SESSION['IdEstatus'] == 50) {
				include("formConsulta/msjEstatus.php");
			} ?>
			<section class="content-header">
				<h1>
					Centro de ayuda con videos para la Plataforma SCIUDY
				</h1>
			</section>
			<section class="content">
			<?php if ($_SESSION['Permisos'] == 2) { ?>
					<div class="col-md-6 col-sm-6 col-xs-12 view_data" href="javascript:void(0);" name="view" value="view" href="javascript:;" id="101" style="cursor: pointer;">
						<div class="info-box">
							<span class="info-box-icon bg-green"><i class="fa fa-youtube-play"></i></span>
							<div class="info-box-content">
								<p>Docente</p>
								<span class="info-box-number">Crear planeación academica</span>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-xs-12 view_data" href="javascript:void(0);" name="view" value="view" href="javascript:;" id="102" style="cursor: pointer;">
						<div class="info-box">
							<span class="info-box-icon bg-purple"><i class="fa fa-youtube-play"></i></span>
							<div class="info-box-content">
							<p>Docente</p>
								<span class="info-box-number">Crear actividad y rúbrica</span>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 view_data" href="javascript:void(0);" name="view" value="view" href="javascript:;" id="103" style="cursor: pointer;">
						<div class="info-box">
							<span class="info-box-icon bg-purple"><i class="fa fa-youtube-play"></i></span>
							<div class="info-box-content">
							<p>Docente</p>
								<span class="info-box-number">Configuración de examen</span>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 view_data" href="javascript:void(0);" name="view" value="view" href="javascript:;" id="104" style="cursor: pointer;">
						<div class="info-box">
							<span class="info-box-icon bg-purple"><i class="fa fa-youtube-play"></i></span>
							<div class="info-box-content">
							<p>Docente</p>
								<span class="info-box-number">Generar acta de calificaciones</span>
							</div>
						</div>
					</div>

					
						
					<?php } ?>

				</div>
			</section>

		</div>
		<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body" id="employee_detail">
					</div>
				</div>
			</div>
		</div>

		<?php include("footer.php"); ?>
	</div>

	<!-- jQuery 3 -->

	<script>
		$(document).ready(function() {
			$(document).on('click', '.view_data', function() {
				//alert('holla ');
				//var Id = document.getElementById("Id").value;

				var employee_id = $(this).attr("id");

				if (employee_id != '') {
					$.ajax({
						url: "formConsulta/viewTutorial.php",
						method: "POST",
						data: {
							employee_id: employee_id
						},
						success: function(data) {
							$('#employee_detail').html(data);
							$('#dataModal').modal('show');
						}
					});
				}
			});
		});
	</script>
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Select2 -->
	<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
	
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<!-- Page script -->
</body>

</html>