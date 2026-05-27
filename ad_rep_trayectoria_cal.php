<?php $valor = 3; $section = "Trayectoria calificación"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de trayectoria de calificación.'); }

$campusId=$t->get_campusPermiso($_SESSION['IdUsua']);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<script src="assets/grafica/highcharts.js"></script>
<script src="assets/grafica/data.js"></script>
<script src="assets/grafica/exporting.js"></script>
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-bell"></i> Reporte de trayectoria de calificación de los alumnos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumnos</a></li>
					<li class="active">Reporte de trayectoria</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="ad_rep_trayectoria_cal.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-6">
								<div class="box-primary">
									<div class="form-group">
										<label>Campus:</label>
										<div class="input-group">
											<div class="input-group-addon">
											<i class="fa fa-bank"></i>
											</div>
											<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="cargar_grupo(<?php echo $_SESSION['IdUsua']; ?>)">
												<option value=""> - Seleccione - </option>
												<?php for ($i=0;$i< sizeof($campusId);$i++) { ?>
												<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"><?php echo $campusId[$i]["Campus"]; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Grupo:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtClaveGrp" id="txtClaveGrp">
											<option value=""> - Seleccione - </option>
										</select>
										<span class="input-group-btn">
											<button onclick="cargar_lista_mat()" type="button" class="btn btn-info btn-flat"> <i class="fa fa-fw fa-search"></i>Buscar</button>
										</span>
									</div>
								</div>
							</div>

							<div class="col-xs-12">
								<div class="col-xs-12" style="position: absolute; z-index:0; text-align: center; display: none;" id="btn_img">
									<img src="assets/images/procesando.gif">
								</div>
								<div class="box" id="panel_alumnos_lista"></div>
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

	function cargar_grupo(IdUsua){
		var IdCampus = document.getElementById("txtCampus").value;
		var Tipo = "get_lst_grupos_id_campus";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, IdCampus:IdCampus, IdUsua:IdUsua }, function(data){
			$("#txtClaveGrp").html(data);
		});
	}

	function cargar_lista_mat(){

		document.getElementById("panel_alumnos_lista").style.display = 'none';
		document.getElementById("btn_img").style.display = "block";


		var IdCampus = document.getElementById("txtCampus").value;
		var IdGrupo = document.getElementById("txtClaveGrp").value;


		if(!IdCampus){
			swal("Error al buscar", "No ha seleccionado el Campus.", "error");
			document.getElementById("btn_img").style.display = "none";
			return 0;
		}
		if(!IdGrupo){
			swal("Error al buscar", "No ha seleccionado el grupo.", "error");
			document.getElementById("btn_img").style.display = "none";
			return 0;
		}


		var Capa = "#panel_alumnos_lista";
		$(Capa).load("dashboard/trayectoria_calificacion_alumnos.php",{IdCampus:IdCampus, IdGrupo:IdGrupo }, function(response, status, xhr) {
			if (status == "error") { alert(status);
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
		document.getElementById("panel_alumnos_lista").style.display = 'block';
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
