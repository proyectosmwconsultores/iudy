<?php $valor = 3; $section = "Alumnos inscritos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de alumnos inscritos.'); }

$cicloId = $t->get_all_ciclos_activos_2023();
$oferta = $t->get_plan_estudios_all();

$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-file-text-o"></i> Reporte de alumnos inscritos por periodo escolar
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Reporte</a></li>
					<li class="active">Alumnos</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="lista_alumnos.php" method="POST" enctype="multipart/form-data">
							<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
							<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
							<input id="Numero" name="Numero" value="1" type="hidden"/>
							<input id="txtClaveGrp" name="txtClaveGrp" value="1" type="hidden"/>
							
							<div class="col-md-5">
									<div class="form-group">
										<label>Periodo escolar:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-gears"></i>
											</div>
											<select class="form-control select2" name="txt_ciclo" id="txt_ciclo">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($cicloId); $i++) { ?>
													<option value="<?php echo $cicloId[$i]["IdCiclo"]; ?>"><?php echo $cicloId[$i]["Tipo"]; ?> - <?php echo $cicloId[$i]["Ciclo"]; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="form-group">
										<label>Plan de estudios:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-gears"></i>
											</div>
											<select class="form-control select2" name="txt_oferta" id="txt_oferta">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($oferta); $i++) { ?>
													<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"><?php echo $oferta[$i]["Nombre"]; ?></option>
												<?php } ?>
											</select>
											<span class="input-group-btn">
												<button onclick="lista_alumnos_activos()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Buscar</button>
											</span>
										</div>
									</div>
								</div>
							

							<div class="col-xs-12">
								<div class="box" id="mi_lista_materias"></div>
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

	})

	function lista_alumnos_activos(){
		var IdCiclo = document.getElementById("txt_ciclo").value;
		var IdOferta = document.getElementById("txt_oferta").value;
		document.getElementById("mi_lista_materias").style.display = 'none';

		if(!IdCiclo){
			swal("Error al buscar", "Debe seleccionar el Periodo Escolar.", "error");
			return 0;
		}
		if(!IdOferta){
			swal("Error al buscar", "Debe seleccionar el plan de estudios.", "error");
			return 0;
		}
		document.getElementById("mi_lista_materias").style.display = 'block';
		var Capa = "#mi_lista_materias";
		$(Capa).load("reportes/rep_alumnos_inscritos.php",{IdCiclo:IdCiclo, IdOferta:IdOferta }, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});

	}



</script>
</body>
</html>







