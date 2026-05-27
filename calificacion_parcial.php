<?php $valor = 3; $section = "Calificación parcial"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de calificación por parcial.'); }
$cicloId=$t->get_all_ciclos();
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
					<i class="fa fa-fw fa-bell"></i> Reporte de calificación por parcial
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumnos</a></li>
					<li class="active">Calificación</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="calificacion_parcial.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-6">
								<div class="form-group">
									<label>Periodo escolar:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtCiclo" id="txtCiclo" onchange="cargar_grupo_reg(<?php echo $_SESSION['IdUsua']; ?>)">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($cicloId);$i++) { ?>
											<option value="<?php echo $cicloId[$i]["IdCiclo"]; ?>"><?php echo $cicloId[$i]["Ciclo"]; ?></option>
											<?php } ?>
										</select>
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
										<select class="form-control select2" name="txtClaveGrp" id="txtClaveGrp" onchange="cargar_lst_materia()">
											<option value=""> - Seleccione - </option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Materia:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txt_materia" id="txt_materia">
											<option value=""> - Seleccione - </option>
										</select>
										<span class="input-group-btn">
											<button onclick="cargar_lista_mat()" type="button" class="btn btn-info btn-flat"> <i class="fa fa-fw fa-search"></i> Consultar</button>
										</span>
									</div>
								</div>
							</div>

							<div class="col-xs-12">
								<div class="box" id="panel_alumnos_lista"></div>
							</div>

						</form>
					</div>
				</div>
					</div>
			</section>

		</div>
		<div id="dataModalPa" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Editar calificación del parcial</h4>
									 </div>
									 <div class="modal-body" id="employee_detailPa">

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

	function cal_parcial_add(Parcial, NoParcial, IdAsignacion){
		$.ajax({
				 url:"dashboard/captura_parcial_id.php",
				 method:"POST",
				 data:{Parcial:Parcial, NoParcial:NoParcial, IdAsignacion:IdAsignacion},
				 success:function(data){
							$('#employee_detailPa').html(data);
							$('#dataModalPa').modal('show');
				 }
		});
	}

	function up_cal_parcial(IdModuloAlumno, Parcial, NoParcial, IdAsignacion, IdUsua){
			var Texto = "txt_cal_"+IdModuloAlumno;
		  var Calif = document.getElementById(Texto).value;

		  var TipoGuardar = "sav_cal_parcial_id";

		  if (Calif==''){
		    swal("Error al guardar", "Debe escribir la calificaci\u00F3n final del parcial.", "error");
		      document.getElementById(Texto).focus();
		      return 0;
		  }
		  if ((Calif < 0) || (Calif > 10)){
		    swal("Error al guardar", "Debe escribir la calificaci\u00F3n en un rango de 0 a 10.", "error");
		      document.getElementById(CalAlum).focus();
		      return 0;
		  }

		  $.ajax({
		        url:"formConsulta/setting.php",
		        method:"POST",
		        data:{TipoGuardar:TipoGuardar,IdAsignacion:IdAsignacion, Calif:Calif, IdModuloAlumno:IdModuloAlumno, Parcial:Parcial, NoParcial:NoParcial, IdUsua:IdUsua},
		        success:function(data){
		          if(data == 1){
		            swal("Guardado correctamente", "Calificaci\u00F3n guardada correctamente.", "success");
								$.ajax({
										 url:"dashboard/captura_parcial_id.php",
										 method:"POST",
										 data:{Parcial:Parcial, NoParcial:NoParcial, IdAsignacion:IdAsignacion},
										 success:function(data){
													$('#employee_detailPa').html(data);
													$('#dataModalPa').modal('show');
										 }
								});
		          }
		        }
		   })
	}

	function emitir_acta_parcial(IdAsignacion, Parcial, NoParcial){
		var Fecha = document.getElementById("fecha_emi_par").value;
		if (Fecha==''){
			swal("Error al guardar", "Debe seleccionar la fecha de emisión del parcial.", "error");
				document.getElementById("fecha_emi_par").focus();
				return 0;
		}
      var TipoGuardar = "emit_acra_parc";
      swal({
        title: "\u00BFEst\u00E1 seguro que desea emitir este acta de parcial?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function (isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');

          $.ajax({
               url:"formConsulta/setting.php",
               method:"POST",
               data:{TipoGuardar:TipoGuardar, IdAsignacion:IdAsignacion, Fecha:Fecha, Parcial},
               success:function(data){

               }
          })
          .done(function(data) {
            if(data==1){
							cargar_lista_mat();
							swal("Generado correctamente", "El acta de calificaci\u00F3n se ha generado correctamente.", "success");
							$.ajax({
									 url:"dashboard/captura_parcial_id.php",
									 method:"POST",
									 data:{Parcial:Parcial, NoParcial:NoParcial, IdAsignacion:IdAsignacion},
									 success:function(data){
												$('#employee_detailPa').html(data);
												$('#dataModalPa').modal('show');
									 }
							});

    				}

            if(data==0){
              swal("Error al solicitar", "No se puede solicitar el documento deseado.", "error");
    				}
    			})
    			.error(function(data) {
    				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
    			});

        }

      });
  }

	function modificar_calificacion_id(IdAsignacion, Parcial, NoParcial){
      var TipoGuardar = "edit_acra_parc";
      swal({
        title: "\u00BFEst\u00E1 seguro que desea aperturar el módulo para modificar calificaciones de este parcial?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function (isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');

          $.ajax({
               url:"formConsulta/setting.php",
               method:"POST",
               data:{TipoGuardar:TipoGuardar, IdAsignacion:IdAsignacion, Parcial:Parcial},
               success:function(data){

               }
          })
          .done(function(data) {
            if(data==1){
							cargar_lista_mat();
							swal("Aperturado correctamente", "Ahora el acta de calificaci\u00F3n puede ser mofificado.", "success");
							$.ajax({
									 url:"dashboard/captura_parcial_id.php",
									 method:"POST",
									 data:{Parcial:Parcial, NoParcial:NoParcial, IdAsignacion:IdAsignacion},
									 success:function(data){
												$('#employee_detailPa').html(data);
												$('#dataModalPa').modal('show');
									 }
							});

    				}

            if(data==0){
              swal("Error al solicitar", "No se puede solicitar el documento deseado.", "error");
    				}
    			})
    			.error(function(data) {
    				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
    			});

        }

      });
  }

	function cargar_grupo(IdUsua){
		var IdCampus = document.getElementById("txtCampus").value;
		var Tipo = "get_lst_grupos_id_campus";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, IdCampus:IdCampus, IdUsua:IdUsua }, function(data){
			$("#txtClaveGrp").html(data);
		});
	}

	function cargar_lista_mat(){
		document.getElementById("panel_alumnos_lista").style.display = 'none';

		var IdCiclo = document.getElementById("txtCiclo").value;
		var IdGrupo = document.getElementById("txtClaveGrp").value;
		var IdAsignacion = document.getElementById("txt_materia").value;

		if(!IdCiclo){
			swal("Error al buscar", "No ha seleccionado el Periodo Escolar.", "error");
			return 0;
		}
		if(!IdGrupo){
			swal("Error al buscar", "No ha seleccionado el grupo.", "error");
			return 0;
		}
		if(!IdAsignacion){
			swal("Error al buscar", "No ha seleccionado la materia.", "error");
			return 0;
		}


		var Capa = "#panel_alumnos_lista";
		$(Capa).load("dashboard/calificacion_parcial_alumnos.php",{IdCiclo:IdCiclo, IdGrupo:IdGrupo, IdAsignacion:IdAsignacion }, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
		document.getElementById("panel_alumnos_lista").style.display = 'block';
	}

	function cargar_grupo_reg(IdUsua){
		var IdCiclo = document.getElementById("txtCiclo").value;
		var Tipo = "cargar_grupo_reg";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, IdCiclo:IdCiclo, IdUsua:IdUsua }, function(data){
			$("#txtClaveGrp").html(data);
		});
	}

	function cargar_lst_materia(){
		var IdCiclo = document.getElementById("txtCiclo").value;
		var IdGrupo = document.getElementById("txtClaveGrp").value;
		var Tipo = "cargar_mat_asignadas";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, IdCiclo:IdCiclo, IdGrupo:IdGrupo }, function(data){
			$("#txt_materia").html(data);
		});
	}


</script>
</body>
</html>
