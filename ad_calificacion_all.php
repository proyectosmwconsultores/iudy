<?php $valor = 3; $section = "Módulo de calificaciones"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de calificaciones finales de todos los campus.'); }

$_mod51=$t->get_mod_lista_id($_SESSION['IdUsua'],51);
$grp=$t->get_all_grupo($_SESSION['IdUsua']);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Lista de alumnos
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
						<form name="frm" id="frm" action="ad_calificacion_all.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-4">
								<div class="form-group">
									<label>Grupo:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtGrupo" id="txtGrupo" onchange="cargar_materias()">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($grp);$i++) { ?>
											<option value="<?php echo $grp[$i]["IdGrupo"]; ?>"><?php echo $grp[$i]["Grado"].'° '.$grp[$i]["CveGrupo"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label>Lista de materias:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtModulo" id="txtModulo">
											<option value=""> - Seleccione - </option>
										</select>
										<span class="input-group-btn">
                      <button onclick="load_calificaciones()" type="button" class="btn btn-info btn-flat"> <i class="fa fa-fw fa-search"></i> Consultar</button>
                    </span>
									</div>
								</div>
							</div>
							<!-- <p style="text-align: center; position: absolute;">

					    </p> -->

							<div class="col-xs-12">
								<div id="panel_alumnos_lista"></div>
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
		<div id="dataPromx" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
										<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
												 <button type="button" class="close" data-dismiss="modal">&times;</button>
												 <h4 class="modal-title"><i class="fa fa-cog"></i> Configurar promedio final</h4>
										</div>
									 <div class="modal-body" id="employee_promx">
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
	function save_cal_all(IdCal, IdUsua, IdCiclo){
		var Fol = "txtFolio-"+IdUsua;
		var Promedio = document.getElementById(Fol).value;
		var IdModulo = document.getElementById("txtModulo").value;
		var IdGrupo = document.getElementById("txtGrupo").value;

		if (!IdCiclo){
				swal("Error al guardar", "No se puede procesar a guardar la calificación, consulta al administrador general.", "error");

				return 0;
		}

		if (Promedio ==''){
				swal("Error al guardar", "Debe escribir el promedio final del alumno.", "error");
				document.getElementById(Fol).focus();
				document.getElementById(Fol).value='';
				return 0;
		}

		if ((Promedio == 'A') || (Promedio == 'N') || (Promedio == '5') || (Promedio == '6') || (Promedio == '7') || (Promedio == '8') || (Promedio == '9') || (Promedio == '10') || (Promedio == 'NP')){

		} else {
			swal("Error al guardar", "El promedio final deber un número entero, por ejemplo: 5, 6, 7, 8, 9, 10, NP", "error");
			document.getElementById(Fol).focus();
			document.getElementById(Fol).value='';
			return 0;
		}

		// var Valor = 0;
		var TipoGuardar = "sav_prom_zgral_all_cps";
	  $.ajax({
	       url:"formConsulta/setting.php",
	       method:"POST",
	       data:{TipoGuardar:TipoGuardar, IdCal:IdCal, Promedio:Promedio, IdCiclo:IdCiclo, IdUsua:IdUsua, IdModulo:IdModulo, IdGrupo:IdGrupo },
	       success:function(data){
					 if(data == 1){
						 swal("Guardado correctamente", "La calificación final del alumno se ha  guardado correctamente.", "success");
						 return 0;
					 }
					 if(data == 2){
						 swal("Error al guardar", "Este alumno no tiene activo la materia que desea agregar calificación, favor de verificar.", "error");
						 document.getElementById(Fol).focus();
		 				 document.getElementById(Fol).value='';
					 } else {
						 swal("Error al guardar", "Ha ocurrido un error no se puede guardar la calificación final del alumno.", "error");
					 }
	       }
	  })

	}

	function upd_cal_all(IdCal){
		$.ajax({
				 url:"formConsulta/calificaciones_extra_all.php",
				 method:"POST",
				 data:{IdCal:IdCal},
				 success:function(data){
							$('#employee_promx').html(data);
							$('#dataPromx').modal('show');
				 }
		});


	}

	$(function () {
		$('.select2').select2()

	})


	function cargar_materias(){
		var IdGrupo = document.getElementById("txtGrupo").value;
		var Tipo = "get_lst_mat_activas";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, IdGrupo:IdGrupo }, function(data){
			$("#txtModulo").html(data);
		});
	}



	function load_calificaciones(){
		var IdGrupo = document.getElementById("txtGrupo").value;
		var IdModulo = document.getElementById("txtModulo").value;

		if(!IdGrupo){
			swal("Error al buscar", "No seleccionado el Grupo.", "error");
			return 0;
		}
		if(!IdModulo){
			swal("Error al buscar", "No seleccionado la materia.", "error");
			return 0;
		}
		document.getElementById("panel_alumnos_lista").style.display = 'block';
		var Capa = "#panel_alumnos_lista";
		$(Capa).load("dashboard/calificacion_final_alumnos_all.php",{IdGrupo:IdGrupo, IdModulo:IdModulo}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});

	}
</script>
</body>
</html>
