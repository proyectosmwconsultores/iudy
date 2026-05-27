<?php $section = "Universo de alumnos";
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
					Universo de alumnos IUDY
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Reportes</a></li>
					<li class="active">Alumnos</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="repBajas.php" method="POST" enctype="multipart/form-data">
					<div class="box box-default">
						<div class="box-body" id="panel_baja_alumnos">
							
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
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Alumnos por estatus </h4>
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

	$(document).ready(function() {
		cargar_lista_bajas();

	});


		function cargar_lista_bajas() {

			document.getElementById("panel_baja_alumnos").style.display = 'block';
			var Capa = "#panel_baja_alumnos";
			$(Capa).load("dashboard/alumnos_universo_total.php", {
			}, function(response, status, xhr) {
				if (status == "error") { 
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
			});
		}

		function mostrar_alumno_id(IdEstatus) {
    $.ajax({
      url: "dashboard/alumnos_universo_estatus.php",
      method: "POST",
      data: {
        IdEstatus: IdEstatus
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