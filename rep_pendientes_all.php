<?php $valor = 3; $section = "Reporte de pagos pendientes"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el reporte de pagos pendientes por grupo.'); }
$campus=$t->get_campusPermiso($_SESSION['IdUsua']);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-dollar"></i> Pagos pendientes
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Reporte</a></li>
					<li class="active">Pagos pendientes</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="rep_pendientes_all.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-12">
								<div class="form-group">
									<label>Campus:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtCampus" id="txtCampus">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($campus);$i++) { ?>
											<option value="<?php echo $campus[$i]["IdCampus"]; ?>"><?php echo $campus[$i]["Campus"]; ?></option>
											<?php } ?>
										</select>
										<span class="input-group-btn">
											<button onclick="load_pagos_all()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Consultar</button>
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




		<div id="dataModalFir" class="modal fade"> <!--MODAL ME GUSTA-->
  				<div class="modal-dialog">
  						 <div class="modal-content">
  									<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
  											 <button type="button" class="close" data-dismiss="modal">&times;</button>
  											 <h4 class="modal-title"><i class="fa fa-users"></i> Configuraci&oacute;n de firmantes</h4>
  									</div>
  									<div class="modal-body" id="employee_detailFir">
  									</div>
  						 </div>
  				</div>
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

	function load_pagos_all(){
		var IdCampus = document.getElementById("txtCampus").value;
		document.getElementById("mi_lista_materias").style.display = 'none';

		if(!IdCampus){
			swal("Error al buscar", "Debe seleccionar el Campus.", "error");
			return 0;
		}

		document.getElementById("mi_lista_materias").style.display = 'block';
		var Capa = "#mi_lista_materias";
		$(Capa).load("dashboard/rep_pagos_pendientes_all.php",{IdCampus:IdCampus }, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});

	}


</script>
</body>
</html>
