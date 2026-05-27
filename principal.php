<?php $_v = 301; $valor = 0; $section = "Bienvenidos"; include("head.php");
if($_SESSION['IdUsua']) {
		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Esta en la pagina principal');
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">


<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Dashboard Principal
					<small>Analítica de resultados</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
					<li class="active">Dashboard</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<div class="box-body" id="parte_uno"></div>
					<div class="box-body" id="parte_dos"></div>
				</div>

			</section>
		</div>

	  <?php include("footer.php"); ?>
	</div>
<!-- ./wrapper -->

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>

	$(document).ready(function(){
			cargar_div_uno();
			cargar_div_dos();
	});
	function cargar_div_uno(){
		var Capa = "#parte_uno";
		$(Capa).load("dashboard/datos_general_part_1.php",{}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, algo ha sucedido: ";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
	}
	function cargar_div_dos(){
		var Capa = "#parte_dos";
		$(Capa).load("dashboard/datos_general_part_2.php",{}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, algo ha sucedido: ";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
	}
</script>
</body>
</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
