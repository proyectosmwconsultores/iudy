<?php $valor = 3; $section = "Gastos generados"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de gastos generados.'); }

$campusId=$t->get_campusPermiso($_SESSION['IdUsua']);
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-money"></i> Gastos generados
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Reporte</a></li>
					<li class="active">Gastos</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="gastos_generados.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-8">
	              <div class="box-primary">
	                <div class="box-body">
                  </div>
	              </div>
	            </div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Año:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>

										<select class="form-control" name="txt_anio" id="txt_anio">
											<option value=""> Seleccione </option>
											<option value="2022">2022</option>
										</select>
										<span class="input-group-btn">
											<button onclick="cargar_gastos()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Consultar</button>
										</span>
									</div>
								</div>
							</div>


							<div class="col-xs-12">
								<div id="panel_gastosx"></div>
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
		<!-- Select2 -->
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
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
		$('.select2').select2()

		$('#txtFecIni').datepicker({
	    autoclose: true
	  })

		$('#txtFecFin').datepicker({
	    autoclose: true
	  })

	})




	function cargar_gastos(){
		var Anio = document.getElementById("txt_anio").value;


		if(Anio == ''){
			swal("Error al buscar", "Debe selecciona el año.", "error");
			return 0;
		}
		document.getElementById("panel_gastosx").style.display = 'none';

		document.getElementById("panel_gastosx").style.display = 'block';
		var Capa = "#panel_gastosx";
		$(Capa).load("dashboard/reporte_gastos.php",{Anio:Anio}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});

	}
</script>

</body>
</html>
