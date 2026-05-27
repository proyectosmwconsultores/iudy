<?php $valor = 3; $section = "Envio de correo"; include("head.php");
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
					<i class="fa fa-fw fa-envelope-o"></i> Módulo de envío de correo
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumnos</a></li>
					<li class="active">Envio de correo</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="envio_correo.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-3">
	              <div class="box-primary">
	                <div class="box-body">
	                  <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
	                    <i class="fa fa-rotate-left"></i> Regresar
	                  </a>
										<a class="btn btn-app" href="javascript:void(0);" onclick="cap_correo()" title="Captura de un nuevo gasto">
	                    <i class="fa fa-envelope-o"></i> Nuevo correo
	                  </a>
                  </div>
	              </div>
	            </div>

							<div class="col-md-5">
								<div class="box-primary">
									<div class="form-group">
										<label>Campus:</label>
										<div class="input-group">
											<div class="input-group-addon">
											<i class="fa fa-bank"></i>
											</div>
											<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="cargar_grupo()">
												<option value=""> - Seleccione - </option>
												<?php for ($i=0;$i< sizeof($campusId);$i++) { ?>
												<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"><?php echo $campusId[$i]["Campus"]; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-4">
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

		<div id="dataModal_4" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-folder-open-o"></i> Captura de nuevo correo</h4>
									 </div>
									 <div class="modal-body" id="employee_detail_4">
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

	function cargar_grupo(){
		var IdCampus = document.getElementById("txtCampus").value;
		var Tipo = "get_lst_grupos_id_campus";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, IdCampus:IdCampus }, function(data){
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
		$(Capa).load("dashboard/lista_envios_correos.php",{IdCampus:IdCampus, IdGrupo:IdGrupo }, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
		document.getElementById("panel_alumnos_lista").style.display = 'block';
		document.getElementById("btn_img").style.display = "none";
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

	function cap_correo(){
		var IdCampus = 0;
		var IdGrupo = 0;
		$.ajax({
				 url:"formConsulta/captura_envio_correo.php",
				 method:"POST",
				 data:{IdCampus:IdCampus, IdGrupo:IdGrupo},
				 success:function(data){
							$('#employee_detail_4').html(data);
							$('#dataModal_4').modal('show');
				 }
		});
	}


</script>
</body>
</html>
