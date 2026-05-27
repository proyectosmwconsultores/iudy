<?php $valor = 3; $section = "Calendario de pagos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de calendario de pagos.'); }
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-calendar"></i> Calendario de pagos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Calendario</a></li>
					<li class="active">Pagos</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="calendario_pagos.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-4">
								<div class="box-primary">
									<div class="form-group">
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="box-primary">
									<div class="form-group">
										<label>Fecha inicial:</label>
										<div class="input-group">
											<div class="input-group-addon">
											<i class="fa fa-bank"></i>
											</div>
											<input type="text" class="form-control pull-right" id="fecha_ini" name="fecha_ini">
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Fecha final:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<input type="text" class="form-control pull-right" id="fecha_fin" name="fecha_fin">
										<span class="input-group-btn">
											<button onclick="calendario_pagos()" type="button" class="btn btn-info btn-flat"> <i class="fa fa-fw fa-search"></i>Buscar</button>
										</span>
									</div>
								</div>
							</div>

							<div class="col-xs-12">
								<div class="col-xs-12" style="position: absolute; z-index:0; text-align: center; display: none;" id="btn_img">
									<img src="assets/images/procesando.gif">
								</div>
								<div class="box" id="panel_lista_calendario"></div>
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


<!-- Page script -->
<script>

	$(function () {
		$('.select2').select2()

		$('#fecha_ini').datepicker({
      autoclose: true
    })
		$('#fecha_fin').datepicker({
      autoclose: true
    })

	})

	function calendario_pagos(){

		var Inicio = document.getElementById("fecha_ini").value;
		var Final = document.getElementById("fecha_fin").value;
		if(!Inicio){
			swal("Error al buscar", "No ha seleccionado la fecha inicial.", "error");
			return 0;
		}
		if(!Final){
			swal("Error al buscar", "No ha seleccionado la fecha final.", "error");
			return 0;
		}

		var Capa = "#panel_lista_calendario";
		$(Capa).load("dashboard/calendario_pagos.php",{Inicio:Inicio, Final:Final }, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
		document.getElementById("panel_lista_calendario").style.display = 'block';
	}




	function cargar_lista_asistencia(){
		document.getElementById("miTablaEvaluacion").style.display = 'block';
		document.getElementById("btn_img").style.display = 'block';
		var IdAsignacion = document.getElementById("IdAsignacion").value;

      var Capa = "#miTablaEvaluacion";

      $(Capa).load("formConsulta/lista_asistencia.php",{IdAsignacion:IdAsignacion}, function(response, status, xhr) {
        if (status == "error") { alert(status);
          var msg = "Error!, algo ha sucedido: ";
          $(Capa).html(msg + xhr.status + " " + xhr.statusText);
        }
      });
			document.getElementById("btn_img").style.display = 'none';
	}


</script>
</body>
</html>
