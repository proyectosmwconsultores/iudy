<?php $valor = 3; $section = "Módulo de calificaciones"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de calificaciones finales.'); }

$_mod51=$t->get_mod_lista_id($_SESSION['IdUsua'],51);
$campusId=$t->get_campusPermiso($_SESSION['IdUsua']);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Lista de alumnos por grupo
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumnos</a></li>
					<li class="active">Captura de calificaciones</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="ad_cap_calificacion.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-6">
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
							<div class="col-md-6">
								<div class="form-group">
									<label>Grupo:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtClaveGrp" id="txtClaveGrp" onchange="cargar_periodo()">
											<option value=""> - Seleccione - </option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label>Periodo escolar:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtCiclo" id="txtCiclo" onchange="cargar_materias()">
											<option value=""> - Seleccione - </option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group">
									<label>Lista de materias:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtModulo" id="txtModulo" onchange="cargar_lista_alumnos()">
											<option value=""> - Seleccione - </option>
										</select>
										<?php if(isset($_mod51[0])){ ?>
											<span class="input-group-btn">
	                      <button onclick="load_materiasx()" type="button" class="btn btn-info btn-flat">Cargar</button>
	                    </span>
										<?php } ?>
									</div>
								</div>
							</div>
							<!-- <p style="text-align: center; position: absolute;">

					    </p> -->
							<div class="col-xs-12" style="position: absolute; z-index:0; text-align: center; display: none;" id="btn_img">
								<img src="assets/images/procesando.gif">
							</div>
							<div class="col-xs-12">
								<div class="box" id="panel_alumnos_lista"></div>
							</div>
							<div class="col-xs-12">
								<div class="box" id="miTablaEvaluacion"></div>
							</div>
						</form>
					</div>
				</div>
					</div>
			</section>
		</div>

		<div id="dataProm" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
										<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
												 <button type="button" class="close" data-dismiss="modal">&times;</button>
												 <h4 class="modal-title"><i class="fa fa-cog"></i> Configurar carga de promedio</h4>
										</div>
									 <div class="modal-body" id="employee_prom">
									 </div>
							</div>
				 </div>
		</div>

		<div id="dataFondo" class="modal fade bs-example-modal-lg"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog modal-lg">
							<div class="modal-content">
										<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
												 <button type="button" class="close" data-dismiss="modal">&times;</button>
												 <h4 class="modal-title"><i class="fa fa-cog"></i> Pase de lista de asistencia</h4>
										</div>
									 <div class="modal-body" id="employee_fondo">
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
	function saveFolio(IdCal, Valor){
		var Fol = "txtFolio-"+IdCal;
		var Promedio = document.getElementById(Fol).value;
		var IdGrupo = document.getElementById("txtClaveGrp").value;
		var IdCiclo = document.getElementById("txtCiclo").value;

		if (Promedio ==''){
				swal("Error al guardar", "Debe escribir el promedio final del alumno.", "error");
				document.getElementById(Fol).focus();
				document.getElementById(Fol).value='';
				return 0;
		}

		if ((Promedio == '5') || (Promedio == '6') || (Promedio == '7') || (Promedio == '8') || (Promedio == '9') || (Promedio == '10')){

		} else {
			swal("Error al guardar", "El promedio final deber un número entero, por ejemplo: 5, 6, 7, 8, 9, 10.", "error");
			document.getElementById(Fol).focus();
			document.getElementById(Fol).value='';
			return 0;
		}

		var TipoGuardar = "sav_prom_gral";
	  $.ajax({
	       url:"formConsulta/setting.php",
	       method:"POST",
	       data:{TipoGuardar:TipoGuardar, IdCal:IdCal, Promedio:Promedio, IdCiclo:IdCiclo, IdGrupo:IdGrupo },
	       success:function(data){
					 if(Valor == 2){
						 	document.getElementById(IdCal).style.display = 'none';
					 }

	       }
	  })

	}

	$(function () {
		$('.select2').select2()

	})

	function load_materiasx(){
		var IdGrupo = document.getElementById("txtClaveGrp").value;
		var IdCiclo = document.getElementById("txtCiclo").value;
		$.ajax({
				 url:"formConsulta/config_mat_promedio.php",
				 method:"POST",
				 data:{IdCiclo:IdCiclo,IdGrupo:IdGrupo},
				 success:function(data){
							$('#employee_prom').html(data);
							$('#dataProm').modal('show');
				 }
		});
	}

	function cargar_grupo(){
		document.getElementById("btn_img").style.display = 'block';
		var IdCampus = document.getElementById("txtCampus").value;
		var Tipo = "get_lst_grupos_id_campus";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, IdCampus:IdCampus }, function(data){
			$("#txtClaveGrp").html(data);
		});
		document.getElementById("btn_img").style.display = 'none';
	}

	function cargar_periodo(){
		document.getElementById("btn_img").style.display = 'block';
		document.getElementById("panel_alumnos_lista").style.display = 'none';
		var IdCampus = document.getElementById("txtCampus").value;
		var IdGrupo = document.getElementById("txtClaveGrp").value;
		var Tipo = "get_lst_periodo_grupo";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, IdCampus:IdCampus, IdGrupo:IdGrupo }, function(data){
			$("#txtCiclo").html(data);
		});
		cargar_materias();


		document.getElementById("btn_img").style.display = 'none';

	}
	function cargar_materias(){
		document.getElementById("panel_alumnos_lista").style.display = 'none';
		document.getElementById("miTablaEvaluacion").style.display = 'none';
		document.getElementById("btn_img").style.display = 'block';
		var IdCampus = document.getElementById("txtCampus").value;
		var IdGrupo = document.getElementById("txtClaveGrp").value;
		var IdCiclo = document.getElementById("txtCiclo").value;
		var Tipo = "get_lst_materias_periodo";

		$.post("php/clases/getConsulta.php", { Tipo:Tipo, IdCampus:IdCampus, IdGrupo:IdGrupo, IdCiclo:IdCiclo }, function(data){
			$("#txtModulo").html(data);
		});
		document.getElementById("btn_img").style.display = 'none';
	}

	function cargar_lista_alumnos(){
		document.getElementById("miTablaEvaluacion").style.display = 'none';
		document.getElementById("btn_img").style.display = 'block';
		var IdCampus = document.getElementById("txtCampus").value;
		var IdGrupo = document.getElementById("txtClaveGrp").value;
		var IdCiclo = document.getElementById("txtCiclo").value;
		var IdModulo = document.getElementById("txtModulo").value;

		if(!IdCampus){
			swal("Error al buscar", "No seleccionado el Campus.", "error");
			return 0;
		}
		document.getElementById("panel_alumnos_lista").style.display = 'block';
		var Capa = "#panel_alumnos_lista";
		$(Capa).load("dashboard/calificacion_final_alumnos.php",{IdCampus:IdCampus, IdGrupo:IdGrupo, IdCiclo:IdCiclo, IdModulo:IdModulo }, function(response, status, xhr) {
			if (status == "error") { alert(status);
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
		document.getElementById("btn_img").style.display = 'none';
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
