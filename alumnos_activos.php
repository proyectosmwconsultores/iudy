<?php $valor = 3; $section = "Alumnos activos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de alumnos activos.'); }
$campusId = $t->get_campusPermiso($_SESSION["IdUsua"]);
$cicloId = $t->get_all_ciclos();

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
					<i class="fa fa-fw fa-file-text-o"></i> Reporte de alumnos activos en plataforma
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
							
							<div class="col-md-12">
									<div class="form-group">
										<label>Campus:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-gears"></i>
											</div>
											<select class="form-control select2" name="txtCampus" id="txtCampus">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($campusId); $i++) { ?>
													<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"><?php echo $campusId[$i]["Campus"]; ?></option>
												<?php } ?>
												<option value="999"> >> TODOS LOS CAMPUS</option>
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
		var IdCampus = document.getElementById("txtCampus").value;
		document.getElementById("mi_lista_materias").style.display = 'none';

		if(!IdCampus){
			swal("Error al buscar", "Debe seleccionar el Campus.", "error");
			return 0;
		}
		document.getElementById("mi_lista_materias").style.display = 'block';
		var Capa = "#mi_lista_materias";
		$(Capa).load("reportes/rep_alumnos_activos.php",{IdCampus:IdCampus }, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});

	}



</script>
</body>
</html>







