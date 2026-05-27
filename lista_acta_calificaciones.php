<?php $valor = 3; $section = "Acta de calificaciones"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de las acta de calificaciones recientes.'); }

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-calendar"></i> Actas de calificaciones publicadas más recientes
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Reporte</a></li>
					<li class="active">Acta de calificaciones</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="lista_acta_calificaciones.php" method="POST" enctype="multipart/form-data">
							<div class="col-xs-12">
								<div id="panel_lista_calendario"></div>
							</div>

						</form>
					</div>
				</div>
					</div>
			</section>
		</div>

		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
	  <?php include("footer.php"); ?>
	</div>

<!-- jQuery 3 -->


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

	$(function () {
		cargar_calendario();
	})

	function cargar_calendario(){
		document.getElementById("panel_lista_calendario").style.display = 'none';

		var Capa = "#panel_lista_calendario";
		$(Capa).load("dashboard/reporte_acta_calificaciones.php",{ }, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
		document.getElementById("panel_lista_calendario").style.display = 'block';
	}


</script>
</body>
</html>
