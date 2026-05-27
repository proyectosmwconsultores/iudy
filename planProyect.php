<?php $mnD = 1; $valor = 2; $section = "Plan de proyecto"; include("head.php");
	if(($_SESSION['IdUsua']) && ($_SESSION['Permisos'])){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de Planeación general.'); }

	$plan=$t->get_panGral($_GET["IdPlan"]);
	$temas=$t->get_temasPlan($_GET["IdPlan"]);

	$mod = $plan[0]["Modalidad"];
	if($mod == "E"){
		$mds = "Escolar";
	}elseif($mod == "N"){
		$mds = "No escolarizada";
	}elseif($mod == "M"){
		$mds = "Mixta";
	}
// $costoPlan=$t->get_costoPlaneDoc($_SESSION['IdAsignacion'],$_SESSION['IdUsua']);
// $chat=$t->get_chatId($costoPlan[0]["IdPlaneacion"]);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
				<?php if($curso == 0){ ?>
        Informaci&oacute;n de la Planeaci&oacute;n general
			<?php } else { echo "Información general del curso"; } ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Informaci&oacute;n</a></li>
        <li class="active">Planeaci&oacute;n</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-body">

					  <form name="frm" id="frm" action="doMiPlaneacion.php" method="POST" enctype="multipart/form-data">
					  <input id="Mov" name="Mov" value="<?php echo $_GET["Mov"];?>" type="hidden"/>
						<input id="txtOferta" name="txtOferta" value="<?php echo $_SESSION['IdOferta']; ?>" type="hidden"/>
						<input id="txtModulo" name="txtModulo" value="<?php echo $_SESSION['IdModulo']; ?>" type="hidden"/>
					  <input id="IdDatosM" name="IdDatosM" value="<?php echo $asignaturaId[0]["IdDatosM"];?>" type="hidden"/>
					  <input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
						<input id="Variable" name="Variable" value="<?php echo $_SESSION['Variable'];?>" type="hidden"/>
						<input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_SESSION['IdAsignacion'];?>" type="hidden"/>
						<input id="IdPlaneacion" name="IdPlaneacion" value="<?php echo $costoPlan[0]["IdPlaneacion"];?>" type="hidden"/>
						<input id="Curso" name="Curso" value="<?php echo $curso;?>" type="hidden"/>
					  <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"];?>" type="hidden"/>
					<div class="row">
						<div class="col-md-12">

							<table class="table table-striped">
							<tbody><tr>
								<td><b>Ciclo:</b><br><b>Generación:</b><br><b>Modalidad:</b></td>
								<td><?php echo $plan[0]["Ciclo"]; ?><br><?php echo $plan[0]["Generacion"]; ?><br>
								<?php echo $mds; ?></td>
								<td><b>Objetivo:</b></td>
								<td colspan="3"><?php echo $plan[0]["Objetivo"]; ?></td>

							</tr>
							<tr>
								<th>Tendencias y temas actuales</th>
								<th>Asignatura</th>
								<th>Complejidad</th>
								<th><?php echo $plan[0]["Tipo"]; ?></th>
								<th>Etapa de la metodología</th>
								<th>Departamento que apoya</th>
							</tr>

							<?php for ($i=0;$i< sizeof($temas);$i++) {
								$temasT=$t->get_asignaPlan($temas[$i]["IdTema"]);
								$etapaT=$t->get_etapaPlan($temas[$i]["IdTema"]);
								 ?>
							<tr>
								<td><?php echo $temas[$i]["Tema"]; ?></td>
								<td>
									<?php for ($x=0;$x< sizeof($temasT);$x++) {
										if($temasT[$x]["NombreMod"]){
										echo "&#8226; ".$temasT[$x]["NombreMod"];
										echo "<br>";
									}
									}
										?>
								</td>
								<td><?php echo $temas[$i]["Complejidad"]; ?></td>
								<td style="text-align: center;"><?php echo $temas[$i]["Cuatrimestre"]; ?></td>
								<td><?php for ($z=0;$z< sizeof($etapaT);$z++) {
									if($etapaT[$z]["Etapa"]){
									echo $etapaT[$z]["Etapa"];
									echo ", ";
								}
								}
									?></td>
								<td><?php echo $temas[$i]["Departamento"]; ?></td>

							</tr>
						<?php } ?>

						</tbody></table>
		        </div>

		      </div>
					</form>
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>

	<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
				<div class="modal-dialog">
						 <div class="modal-content">
									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
											 <button type="button" class="close" data-dismiss="modal">&times;</button>
											 <h4 class="modal-title"><?php if($curso == 0){ ?>Creaci&oacute;n de parcial<?php } else { echo "Datos del curso"; } ?></h4>
									</div>
									<div class="modal-body" id="employee_detail">
									</div>
						 </div>
				</div>
	 </div>

	 <div id="dataModalViewPc" class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Datos de los parciales creados anteriormente</h4>
 									</div>
 									<div class="modal-body" id="employee_detailViewPc" style="background: #ecf0f5;">
 									</div>
 						 </div>
 				</div>
 	 </div>

	 <div id="dataModalViewP" class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Datos de la planeación acad&eacute;mica</h4>
 									</div>
 									<div class="modal-body" id="employee_detailViewP">
 									</div>
 						 </div>
 				</div>
 	 </div>

	 <div id="dataModalSemana"  class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Informaci&oacute;n del trabajo de la semana</h4>
 									</div>
 									<div class="modal-body" id="employee_detailSem">
 									</div>
 						 </div>
 				</div>
 	 </div>

	 <div id="dataModalActividad"  class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Creaci&oacute;n de actividad</h4>
 									</div>
 									<div class="modal-body" id="employee_detailAct">
 									</div>
 						 </div>
 				</div>
 	 </div>

	 <div id="dataModalBiblio"  class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Agregar fuentes de consulta</h4>
 									</div>
 									<div class="modal-body" id="employee_detailBiblio">
 									</div>
 						 </div>
 				</div>
 	 </div>

	 <div id="dataModalenvioPlan"  class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Envio de planeci&oacute;n para revisi&oacute;n</h4>
 									</div>
 									<div class="modal-body" id="employee_detailenvioPlan">
 									</div>
 						 </div>
 				</div>
 	 </div>

	 <div id="dataModalModAct"  class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Modificar actividad</h4>
 									</div>
 									<div class="modal-body" id="employee_detailModAct">
 									</div>
 						 </div>
 				</div>
 	 </div>

	 <div id="dataModalViewEx"  class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Vista previa del examen</h4>
 									</div>
 									<div class="modal-body" id="employee_detailViewEx">
 									</div>
 						 </div>
 				</div>
 	 </div>

	 <!-- <div id="dataModalExam"  class="modal fade">
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Configurar examen</h4>
 									</div>
 									<div class="modal-body" id="employee_detailExam">
 									</div>
 						 </div>
 				</div>
 	 </div> -->

	 <div id="dataModalModPar"  class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Modificar datos</h4>
 									</div>
 									<div class="modal-body" id="employee_detailModPar">
 									</div>
 						 </div>
 				</div>
 	 </div>

	 <div id="dataModalModSem"  class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Modificar datos de la semana</h4>
 									</div>
 									<div class="modal-body" id="employee_detailModSem">
 									</div>
 						 </div>
 				</div>
 	 </div>
	 <div id="dataModalModFue"  class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Actualizar fuente de consulta</h4>
 									</div>
 									<div class="modal-body" id="employee_detailModFue">
 									</div>
 						 </div>
 				</div>
 	 </div>
	 <div id="dataModalChat" class="modal fade"> <!--MODAL ME GUSTA-->
				<div class="modal-dialog">
						 <div class="modal-content">
									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
											 <button type="button" class="close" data-dismiss="modal">&times;</button>
											 <h4 class="modal-title">Notificaciones de la Planeaci&oacute;n</h4>
									</div>
									<div class="modal-body" id="employee_detailChat">

									</div>
						 </div>
				</div>
	 </div>

  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClic
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>

function noticarPlan(){
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var IdPlaneacion = document.getElementById("IdPlaneacion").value;
	var Tipo = "A";
	$.ajax({
			 url:"formConsulta/chatPlaneacion.php",
			 method:"POST",
			 data:{IdAsignacion:IdAsignacion, IdPlaneacion:IdPlaneacion, Tipo:Tipo},
			 success:function(data){
						$('#employee_detailChat').html(data);
						$('#dataModalChat').modal('show');
			 }
	});
}

	function crearParcial(){
		var IdOferta = document.getElementById("txtOferta").value;
		var IdModulo = document.getElementById("txtModulo").value;
		var IdPlaneacion = document.getElementById("IdPlaneacion").value;
		$.ajax({
				 url:"formConsulta/addParcial.php",
				 method:"POST",
				 data:{IdOferta:IdOferta,IdModulo:IdModulo,IdPlaneacion:IdPlaneacion},
				 success:function(data){
							$('#employee_detail').html(data);
							$('#dataModal').modal('show');
				 }
		});

	}

	function viewParcial(){
		var IdOferta = document.getElementById("txtOferta").value;
		var IdModulo = document.getElementById("txtModulo").value;
		$.ajax({
				 url:"formConsulta/viewParcial.php",
				 method:"POST",
				 data:{IdOferta:IdOferta,IdModulo:IdModulo},
				 success:function(data){
							$('#employee_detailViewPc').html(data);
							$('#dataModalViewPc').modal('show');
				 }
		});
	}

	function viewPlaneacion(IdParcial){
		var IdOferta = document.getElementById("txtOferta").value;
		var IdModulo = document.getElementById("txtModulo").value;
		$.ajax({
				 url:"formConsulta/viewPlaneacion.php",
				 method:"POST",
				 data:{IdOferta:IdOferta,IdModulo:IdModulo,IdParcial:IdParcial},
				 success:function(data){
							$('#employee_detailViewP').html(data);
							$('#dataModalViewP').modal('show');
				 }
		});
	}

	function crearSemana(IdParcial){
		var IdOferta = document.getElementById("txtOferta").value;
		var IdModulo = document.getElementById("txtModulo").value;
		$.ajax({
				 url:"formConsulta/addSemana.php",
				 method:"POST",
				 data:{IdOferta:IdOferta,IdModulo:IdModulo,IdParcial:IdParcial},
				 success:function(data){
							$('#employee_detailSem').html(data);
							$('#dataModalSemana').modal('show');
				 }
		});

	}

	function activarCurso(IdParcial){
		var IdUsua = document.getElementById("IdUsua").value;
		var IdModulo = document.getElementById("txtModulo").value;
		var IdAsignacion = document.getElementById("IdAsignacion").value;
		var IdPlaneacion = document.getElementById("IdPlaneacion").value;

		  //var IdUsua = document.getElementById("IdUsua").value;

		  var TipoGuardar = "actCurso";
		  swal({
		    title: "\u00BFEst\u00E1 seguro que desea activar este curso para todos sus usuarios activos?",
		    type: "warning",
		    showCancelButton: true,
		    confirmButtonColor: '#DD6B55',
		    confirmButtonText: 'Aceptar',
		    cancelButtonText: "Cancelar",
		  },
		  function (isConfirm) {
		    if(isConfirm) {
		      $(".confirm").attr('disabled', 'disabled');
		      $.ajax({
		           url:"formConsulta/setting.php",
		           method:"POST",
		           data:{TipoGuardar:TipoGuardar, IdPlaneacion:IdPlaneacion, IdAsignacion:IdAsignacion, IdUsua:IdUsua},
		           success:function(data){


		           }
		      })
		      .done(function(data) {

		        if(data==1){
		          swal("Guardado correctamente", "Curso activado correctamente.", "success");
							 parent.location.href='doMiPlaneacion.php';
		        }
		        if(data==0){
		          swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
		        }
		      })
		      .error(function(data) {
		        swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
		      });
		    }
		  });



		// $.ajax({
		// 		 url:"formConsulta/addSemana.php",
		// 		 method:"POST",
		// 		 data:{IdOferta:IdOferta,IdModulo:IdModulo,IdParcial:IdParcial},
		// 		 success:function(data){
		// 					$('#employee_detailSem').html(data);
		// 					$('#dataModalSemana').modal('show');
		// 		 }
		// });

	}

	function crearActividad(IdParcial,IdSemana){
		var IdOferta = document.getElementById("txtOferta").value;
		var IdModulo = document.getElementById("txtModulo").value;
		$.ajax({
				 url:"formConsulta/addActividad.php",
				 method:"POST",
				 data:{IdOferta:IdOferta,IdModulo:IdModulo,IdParcial:IdParcial,IdSemana:IdSemana},
				 success:function(data){
							$('#employee_detailAct').html(data);
							$('#dataModalActividad').modal('show');
				 }
		});

	}

	function crearBiblio(IdParcial,IdSemana){
		var IdOferta = document.getElementById("txtOferta").value;
		var IdModulo = document.getElementById("txtModulo").value;
		$.ajax({
				 url:"formConsulta/addBibliografia.php",
				 method:"POST",
				 data:{IdOferta:IdOferta,IdModulo:IdModulo,IdParcial:IdParcial,IdSemana:IdSemana},
				 success:function(data){
							$('#employee_detailBiblio').html(data);
							$('#dataModalBiblio').modal('show');
				 }
		});

	}


	function envioPlan(IdUsua){
		var IdAsignacion = document.getElementById("IdAsignacion").value;
		var IdPlaneacion = document.getElementById("IdPlaneacion").value;
		var Tipo = "A";
		$.ajax({
				 url:"formConsulta/envioPlaneacion.php",
				 method:"POST",
				 data:{IdUsua:IdUsua,IdAsignacion:IdAsignacion,Tipo:Tipo,IdPlaneacion:IdPlaneacion},
				 success:function(data){
							$('#employee_detailenvioPlan').html(data);
							$('#dataModalenvioPlan').modal('show');
				 }
		});

	}

	function modificarActividad(IdActividadDoc){
		$.ajax({
				 url:"formConsulta/updActividad.php",
				 method:"POST",
				 data:{IdActividadDoc:IdActividadDoc},
				 success:function(data){
							$('#employee_detailModAct').html(data);
							$('#dataModalModAct').modal('show');
				 }
		});

	}

	function vistaExamen(IdActividadDoc){
		var IdAsignacion = document.getElementById("IdAsignacion").value;
		$.ajax({
				 url:"formConsulta/viewExamen.php",
				 method:"POST",
				 data:{IdActividadDoc:IdActividadDoc,IdAsignacion:IdAsignacion},
				 success:function(data){
							$('#employee_detailViewEx').html(data);
							$('#dataModalViewEx').modal('show');
				 }
		});

	}

	function configurarExamen(IdActividadDoc, IdParcialDoc){
		$.ajax({
				 url:"formConsulta/addExamen.php",
				 method:"POST",
				 data:{IdActividadDoc:IdActividadDoc,IdParcialDoc:IdParcialDoc},
				 success:function(data){
							$('#employee_detailExam').html(data);
							$('#dataModalExam').modal('show');
				 }
		});

	}

	function modificarParcial(IdParcial){
		$.ajax({
				 url:"formConsulta/updParcial.php",
				 method:"POST",
				 data:{IdParcial:IdParcial},
				 success:function(data){
							$('#employee_detailModPar').html(data);
							$('#dataModalModPar').modal('show');
				 }
		});

	}

	function modificarSemana(IdSemana){
		$.ajax({
				 url:"formConsulta/updSemana.php",
				 method:"POST",
				 data:{IdSemana:IdSemana},
				 success:function(data){
							$('#employee_detailModSem').html(data);
							$('#dataModalModSem').modal('show');
				 }
		});

	}

	function modificarFuente(IdFuente){
		$.ajax({
				 url:"formConsulta/updFuente.php",
				 method:"POST",
				 data:{IdFuente:IdFuente},
				 success:function(data){
							$('#employee_detailModFue').html(data);
							$('#dataModalModFue').modal('show');
				 }
		});

	}



$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	var variable = document.frm.Variable.value;
	if(alerta){
		if(alerta =="GUARDAR"){
			swal("Guardado", variable + " GUARDADO CON ÉXITO", "success");
		}
		if(alerta =="ACTUALIZAR"){
			swal("Actualizado", variable + " actualizado con exito", "success");
		}
		if(alerta =="ELIMINAR"){
			swal("Eliminado", variable + " ELIMINADO CON ÉXITO", "success");
		}
		if(alerta =="ERROR"){
			swal("Error", variable + " FAVOR DE COMUNICARSE CON EL ADMINISTRADOR", "error");
		}
	}
});
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
