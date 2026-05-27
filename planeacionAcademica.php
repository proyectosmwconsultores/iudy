<?php $valor = 2; $section = "Planeación general"; include("head.php");
	if(($_SESSION['IdUsua']) && ($_SESSION['Permisos'])){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de Planeación general'); }
  $IdPlaneacion = substr($_GET["toks"],10,10);

	$costoPlan=$t->get_costoPlane($IdPlaneacion);

	$asignaturaId=$t->get_asignaturaIdRev($costoPlan[0]["IdAsignacion"]);
 $curso = $asignaturaId[0]["Curso"];
	$parciales=$t->get_parcialDocente($asignaturaId[0]["IdEducativa"],$asignaturaId[0]["IdModulo"],$costoPlan[0]["IdAsignacion"]);

	if($asignaturaId[0]["Modalidad"] == "M"){ $mod = "Mixta"; } elseif($asignaturaId[0]["Modalidad"] == "N"){ $mod = "No Escolarizado"; } elseif($asignaturaId[0]["Modalidad"] == "E"){ $mod = "Escolarizado"; }

$chat=$t->get_chatId($IdPlaneacion);

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
        Informaci&oacute;n de la Planeaci&oacute;n general
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Informaci&oacute;n</a></li>
        <li class="active">Planeaci&oacute;n</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-body">

					  <form name="frm" id="frm" action="planeacionAcademica.php" method="POST" enctype="multipart/form-data">
							<input id="IdAsignacion" name="IdAsignacion" value="<?php echo $costoPlan[0]["IdAsignacion"]; ?>" type="hidden"/>
							<input id="IdPlaneacion" name="IdPlaneacion" value="<?php echo $IdPlaneacion; ?>" type="hidden"/>
							<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>


					<div class="row">
						<div class="col-md-12">

							<?php if($curso == 0){ ?>
							<a style="float: right;" onClick="window.open('adPlaneacionRevision.php','_self')" href="javascript:void(0);" class="btn btn-app" onclick="noticarPlan()"><span class="badge bg-teal"></span><i class="fa fa-rotate-left"></i> Regresar</a>
							<a style="float: right;" class="btn btn-app" onclick="noticarPlan()"><span class="badge bg-teal"><?php echo $chat[0]["sumChat"]?></span><i class="fa fa-wechat"></i> Chat</a>
						  <?php } else { ?>
							<a style="float: right;" onClick="window.open('addmiscursos.php','_self')" href="javascript:void(0);" class="btn btn-app" onclick="noticarPlan()"><span class="badge bg-teal"></span><i class="fa fa-rotate-left"></i> Regresar</a>
						  <?php } ?>
							<?php if(isset($parciales[0]["IdEstatus"])){ if($parciales[0]["IdEstatus"] <> 4) { ?>
							<a style="float: right;" href="javascript:void(0);" class="btn btn-app view_horario" href="javascript:void(0);" name="view" value="view" id="<?php echo $costoPlan[0]["IdAsignacion"]; ?>"><span class="badge bg-red">Agregar</span><i class="fa fa-clock-o"></i> Horario</a>
							<a style="float: right;" onclick="envioPlan(<?php echo $_SESSION['IdUsua']; ?>)" href="javascript:void(0);" class="btn btn-app"><span class="badge bg-aqua">Validar</span><i class="fa fa-check-circle"></i> Planeaci&oacute;n</a>
						  <?php } ?>
							<?php if(($parciales[0]["IdEstatus"] == 4) && ($curso == 110)) { ?>
							<a style="float: right;" onClick="window.open('repositorio/pdf/impPlaneacion.php?toks=<?php echo $_GET["toks"]; ?>','_blank')" href="javascript:void(0);" class="btn btn-app"><span class="badge bg-purple">Descargar</span><i class="fa fa-file-pdf-o"></i> Planeaci&oacute;n</a>
						<?php } } ?>
							<a style="float: right;" onClick="window.open('doPlaneacion.php?idToks=<?php echo $asignaturaId[0]["IdAsignacion"]; ?>','_self')" href="javascript:void(0);" class="btn btn-app" onclick="noticarPlan()"><span class="badge bg-teal"></span><i class="fa fa-object-group"></i> Cambiar vista</a>
		          <div class="nav-tabs-custom">

		            <ul class="nav nav-tabs">
									<li class='active'><a href="#activity98618" data-toggle="tab" aria-expanded="true"> Datos generales de la asignatura</a></li>
									<?php for ($x=0;$x< sizeof($parciales);$x++) { $IdParcial = $parciales[$x]["IdParcialDocente"]; if($IdParcial==1){ $clss = "class='active'"; } else { $clss = "";}
									//$tipoPar = $parciales[$x]["Tipo"]; if($tipoPar=="P"){ $tpar = "Parcial"; } else { $tpar = "Extraordinario";}
									$tipoPar = $parciales[$x]["Tipo"]; if($tipoPar=="P"){ $tpar = "Parcial ".$parciales[$x]["NoParcial"]; } else { $no = $parciales[$x]["NoParcial"]; if($no == 1) { $tpar = "Extraordinario"; } else { $tpar = "Título de suficiencia"; } }
									 ?>
										<li><a href="#activity<?php echo $IdParcial; ?>" data-toggle="tab" aria-expanded="true"> <?php echo $tpar; ?></a></li>
									<?php } ?>
		            </ul>
		            <div class="tab-content">
									<div class="tab-pane active" id="activity98618">
								<div class="row">

					        <div class="col-xs-12 table-responsive">


					          <table class="table table-striped">
					            <thead>
					            <tr>
					              <td colspan="3" style="text-align: center;">
													<?php if($costoPlan[0]["IdEstatus"] == 31){ ?>
														<b>Planeación:</b> en proceso de captura por el asesor acad&eacute;mico.
													<?php  } elseif($costoPlan[0]["IdEstatus"] == 3){ ?>

															<b>Planeación:</b> esta planeación lo debe de revisar.
														<?php  } elseif($costoPlan[0]["IdEstatus"] == 25){ ?>

																<b>Planeación:</b> enviado de regreso a revisión al asesor académico.
															<?php  } elseif($costoPlan[0]["IdEstatus"] == 4){ ?>

																	<b>Planeación:</b> aprobado. <br> <i class="fa fa-fw fa-user"></i> <?php echo $costoPlan[0]["Nombre"].' '.$costoPlan[0]["APaterno"].' '.$costoPlan[0]["AMaterno"]; ?> <i class="fa fa-fw fa-calendar-check-o"></i> <?php echo obtenerFechaEnLetra($costoPlan[0]["FecAprobado"]); ?> <i class="fa fa-fw fa-clock-o"></i> <?php echo substr($costoPlan[0]["FecAprobado"], 11, 10); ?>
																<?php  }  ?>
											</td>
					            </tr>
											<tr style="background: gray;">
					              <th colspan="3" style="text-align: center;"><?php if($asignaturaId[0]["Nombre"]) { echo $asignaturaId[0]["Nombre"]; } else { echo $asignaturaId[0]["Oferta"]; } ?></th>
					            </tr>

					            </thead>
					            <tbody>
					            <tr>
												<td colspan="3" style="text-align: center;"><b>Nombre de la asignatura:</b> <?php echo $asignaturaId[0]["NombreMod"]; ?></td>
					            </tr>
											<?php if($curso == 0){ ?>
											<tr>

												<td><b><?php echo $asignaturaId[0]["Tipo"]; ?>:</b> <?php echo $asignaturaId[0]["Grado"].$asignaturaId[0]["Abreviatura"].' '.$asignaturaId[0]["Tipo"]; ?></td>
												<td><b>Modalidad:</b> <?php  echo $mod; ?></td>
					              <td><b>Per&iacute;odo del <?php echo $asignaturaId[0]["Tipo"]; ?>:</b> <?php echo obtener_mes($asignaturaId[0]["MesIni"]); ?> - <?php echo obtener_mes($asignaturaId[0]["MesFin"]); ?> <?php echo substr($asignaturaId[0]["FFinal"],0,4); ?></td>
					            </tr>
											<tr>
												<td><b>Horas asignadas:</b> <?php echo $asignaturaId[0]["HraDia"]; ?> hrs</td>
												<td><b>Horas semana:</b> <?php echo $asignaturaId[0]["HraSemana"]; ?> hrs</td>
					              <td><b>Horas al mes:</b> <?php echo ($asignaturaId[0]["HraSemana"] * 4);  ?> hrs </td>
					            </tr>
										  <?php } ?>


					            </tbody>
					          </table>
										<table class="table table-striped">
					            <tbody>
					            <tr>
												<td colspan="3" style="text-align: center;"><b>Objetivo general <?php if($curso == 0) { echo " de la asignatura"; } else { echo " del curso"; } ?></b></td>
					            </tr>
											<tr>
												<td colspan="3"><?php echo $asignaturaId[0]["Objetivo"]; ?></td>
					            </tr>
											<tr>
												<td colspan="3" style="text-align: center;"><b>Introducci&oacute;n <?php if($curso == 0) { echo " de la asignatura"; } else { echo " del curso"; } ?></b></td>
					            </tr>
											<tr>
												<td colspan="3"><?php echo $asignaturaId[0]["Introduccion"]; ?></td>
					            </tr>


					            </tbody>
					          </table>
					        </div>
					      </div>

              </div>
									<?php for ($y=0;$y< sizeof($parciales);$y++) { $IdParcial = $parciales[$y]["IdParcialDocente"];
										$semana=$t->get_semanadocente($IdParcial,$asignaturaId[0]["IdModulo"]);
										$avance=$t->get_avanceParcial($costoPlan[0]["IdAsignacion"],$IdParcial);
										if($parciales[$y]["IdEstatus"] == 12) { $nomEs = "En proceso"; } elseif($parciales[$y]["IdEstatus"] == 3) { $nomEs = "En revisión"; } elseif($parciales[$y]["IdEstatus"] == 4) { $nomEs = "Aprobado"; }
										//$tipoParx = $parciales[$y]["Tipo"]; if($tipoParx=="P"){ $tparx = "Parcial"; } else { $tparx = "Extraordinario";}
										$tipoParx = $parciales[$y]["Tipo"]; if($tipoParx=="P"){ $tparx = "Parcial ".$parciales[$y]["NoParcial"]; } else { $no = $parciales[$y]["NoParcial"]; if($no == 1) { $tparx = "Extraordinario"; } else { $tparx = "Título de suficiencia"; } }

										 if($IdParcial==1){ $clssT = "active"; } else { $clssT = "";} ?>
		              <div class="tab-pane" id="activity<?php echo $IdParcial; ?>">
										<div class="col-md-12"><br>
											 <b>Estatus del <?php echo $tparx; ?>:</b> <?php echo $nomEs; ?><br>
											 Total pocentaje en actividades del <?php echo $tparx; ?>: <b><?php echo $avance[0]["Avance"]; ?> %</b><br>
							         <div class="progress progress-sm active">
							           <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avance[0]["Avance"]; ?>%">
							             <span class="sr-only">20% Complete</span>
							           </div>
							         </div>
											 <?php 	if(($parciales[$y]["IdEstatus"] == 12) && ($parciales[$y]["Tipo"] == "E")) { ?>
											 <button name="btnActivar" id="btnActivar" onclick="activarExtra(<?php echo $parciales[$y]["IdParcialDocente"]; ?>)" href="javascript:void(0);"  type="button" class="btn btn-primary">
					 		            <i class="fa fa-check"></i> Activar <?php echo $tparx; ?>
					 		          </button>
											<?php } ?>

											<br><br><br>
											<div class="box box-solid">
						            <div class="box-header with-border">
						              <i class="fa fa-gg-circle"></i>
						              <h3 class="box-title">Datos del <?php echo $tparx; ?></h3>
													<!-- <a onclick="modificarParcial(<?php echo $IdParcial; ?>)" class="btn btn-danger btn-xs" style="float: right;"><i class="fa fa-fw fa-refresh"></i> Actualizar <?php echo $tparx; ?></a> -->
						            </div>
						            <div class="box-body">
						              <dl class="dl-horizontal">
						                <dt>Tema:</dt>
						                <dd><?php echo $parciales[$y]["Tema"]; ?></dd>
						                <dt>Objetivo:</dt>
						                <dd><?php echo $parciales[$y]["Objetivo"]; ?></dd>
														<dt>Fecha:</dt>
						                <dd><?php echo obtenerFechaEnLetra($parciales[$y]["FecIni"]); ?> al <?php echo obtenerFechaEnLetra($parciales[$y]["FecFin"]); ?></dd>
						              </dl>
													<span class="username">
														<span class="text-muted pull-right">
															<i class="fa fa-user"></i> <?php echo $parciales[$y]["Nombre"].' '.$parciales[$y]["APaterno"].' '.$parciales[$y]["AMaterno"].' '; ?>
															<i class="fa fa-clock-o"></i> <?php echo obtenerFechaEnLetra($parciales[$y]["FecCap"]).' / '.substr($parciales[$y]["FecCap"], 11, 8); ?>
														</span>
		                      </span>
						            </div>
						          </div>
									</div>
									<div class="col-md-12">



									<ul class="timeline timeline-inverse">

									<?php for ($s=0;$s< sizeof($semana);$s++) { $IdSemana = $semana[$s]["IdSemanaDocente"];
										$actividades=$t->get_actividadSemDoc($IdParcial,$IdSemana);
										$fuente=$t->get_fuentedocente($IdParcial,$semana[$s]["IdSemanaDocente"]);
										 ?>
                  <li class="time-label">
                        <span class="bg-red">
                          Semana <?php echo $semana[$s]["NoSemana"]; ?>
                        </span>
                  </li>

                  <li>
                    <i class="fa fa-get-pocket bg-blue"></i>

                    <div class="timeline-item">
                      <div class="timeline-body">
                        <?php echo $semana[$s]["Temas"]; ?>
                      </div>
											<span class="username">
												<span class="text-muted pull-right">
													<i class="fa fa-user"></i> <?php echo $semana[$s]["Nombre"].' '.$semana[$s]["APaterno"].' '.$semana[$s]["AMaterno"].' '; ?>
													<i class="fa fa-clock-o"></i> <?php echo obtenerFechaEnLetra($semana[$s]["FecCap"]).' / '.substr($semana[$s]["FecCap"], 11, 8); ?>
												</span>
											</span><br>
                    </div>
                  </li>
									<?php for ($f=0;$f< sizeof($fuente);$f++) {  ?>
									<li>
                    <i class="fa fa-bookmark bg-black"></i>

                    <div class="timeline-item">
                      <div class="timeline-body"><b>Fuente de consulta:</b>
                        <?php echo $fuente[$f]["Fuente"]; ?>
												<p style="text-align: right;">
													<a  onclick="modificarFuente(<?php echo $fuente[$f]["IdFuente"]; ?>,<?php echo $IdPlaneacion; ?>)" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-refresh"></i> Actualizar</a>
												</p>
                      </div>
											<span class="username">
												<span class="text-muted pull-right">
													<i class="fa fa-user"></i> <?php echo $fuente[$f]["Nombre"].' '.$fuente[$f]["APaterno"].' '.$fuente[$f]["AMaterno"].' '; ?>
													<i class="fa fa-clock-o"></i> <?php echo obtenerFechaEnLetra($fuente[$f]["FecCap"]).' / '.substr($fuente[$f]["FecCap"], 11, 8); ?>
												</span>
											</span><br>
                    </div>


                  </li>
									<?php } ?>
									<?php if($actividades[0]){ for ($ac=0;$ac< sizeof($actividades);$ac++) {
										if($actividades[$ac]["IdPlan"]){
												$etapaTemas=$t->get_etapTemas($actividades[$ac]["IdPlan"],$actividades[$ac]["IdTema"],$actividades[$ac]["IdEtapa"]);
										}
										?>

									<li>
                    <i class="fa fa-<?php if($actividades[$ac]["Modalidad"] == 2) { echo "users";} else { echo "user"; } ?> bg-aqua"></i>
										<div class="timeline-item">
                      <span class="time"><i class="fa fa-bell"></i> <?php echo $actividades[$ac]["TipoActividad"]; ?></span>

                      <h3 class="timeline-header"><?php echo $actividades[$ac]["NomActividad"]; ?></h3>

                      <div class="timeline-body">
                        <?php echo $actividades[$ac]["DesActividad"];
												if(isset($etapaTemas[0])){ echo '<b>Plan de proyecto.</b> <br> <b>Tema:</b>'.$etapaTemas[0]["Tema"].' <b>Complejidad: </b>'.$etapaTemas[0]["Complejidad"].' <b>Etapa:</b> '.$etapaTemas[0]["Etapa"]; }
												?>

												<br>
												<?php if($actividades[$ac]["FecIni"]){ ?>
												<dl class="dl-horizontal">
					                <dt>Fecha inicial:</dt>
					                <dd><?php echo obtenerFechaEnLetra($actividades[$ac]["FecIni"]); ?></dd>
					                <dt>Fecha final:</dt>
					                <dd><?php echo obtenerFechaEnLetra($actividades[$ac]["FecFin"]); ?></dd>
					                <dt>Porcentaje:</dt>
					                <dd><?php echo $actividades[$ac]["Porcentaje"]; ?> %</dd>
													<dt>Estatus:</dt>
					                <dd><?php echo $actividades[$ac]["Estatus"]; ?></dd>
					              </dl>
												<?php } else { ?>
													<div class="alert alert-danger alert-dismissible">
						                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						                <h4><i class="icon fa fa-ban"></i> Alerta</h4>
						                El asesor acad&eacute;mico tiene pendiente configurar los datos de esta actividad.
						              </div>
												<?php } ?>
												<?php if($actividades[$ac]["IdTipoActividad"] == 1){ ?>
													<a onclick="vistaExamen(<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>)" href="javascript:void(0);" class="btn btn-info btn-xs"><i class="fa fa-fw fa-eye"></i> Vista examen</a>
												<?php  } ?>
												<span class="username">
													<span class="text-muted pull-right">
														<i class="fa fa-user"></i> <?php echo $actividades[$ac]["Nombre"].' '.$actividades[$ac]["APaterno"].' '.$actividades[$ac]["AMaterno"].' '; ?>
														<i class="fa fa-clock-o"></i> <?php echo obtenerFechaEnLetra($actividades[$ac]["FecCap"]).' / '.substr($actividades[$ac]["FecCap"], 11, 8); ?>
													</span>
												</span><br>
                      </div>

                    </div>
                  </li>


								<?php } } } ?>
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
							</div>


		              </div>
								<?php } ?>


		            </div>
		          </div>
		        </div>

		      </div>
					</form>
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>


	 <div id="dataModalenvioPlan"  class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Seguimiento la de Planeaci&oacute;n</h4>
 									</div>
 									<div class="modal-body" id="employee_detailenvioPlan">
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
  <?php include("footer.php"); ?>
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

	<div id="dataModalHor" class="modal fade"> <!--MODAL ME GUSTA-->
				<div class="modal-dialog">
						 <div class="modal-content">
									<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
											 <button type="button" class="close" data-dismiss="modal">&times;</button>
											 <h4 class="modal-title">Configuraci&oacute;n de horario de la asignatura</h4>
									</div>
									<div class="modal-body" id="employee_detailHor">
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
	var Tipo = "C";
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


	function envioPlan(IdUsua){
		var IdAsignacion = document.getElementById("IdAsignacion").value;
		var IdPlaneacion = document.getElementById("IdPlaneacion").value;
		var Tipo = "C";

		$.ajax({
				 url:"formConsulta/envioPlaneacion.php",
				 method:"POST",
				 data:{IdUsua:IdUsua,IdAsignacion:IdAsignacion,Tipo:Tipo, IdPlaneacion:IdPlaneacion},
				 success:function(data){
							$('#employee_detailenvioPlan').html(data);
							$('#dataModalenvioPlan').modal('show');
				 }
		});

	}

  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })

	function modificarFuente(IdFuente,IdPlaneacion){
		$.ajax({
				 url:"formConsulta/updFuente.php",
				 method:"POST",
				 data:{IdFuente:IdFuente,IdPlaneacion:IdPlaneacion},
				 success:function(data){
							$('#employee_detailModFue').html(data);
							$('#dataModalModFue').modal('show');
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

	$(document).ready(function(){
       $(document).on('click', '.view_horario', function(){
            var employee_id = $(this).attr("id");
 					 //var IdAsignacion = document.getElementById("Id").value;
            if(employee_id != '')
            {
                 $.ajax({
                      url:"formConsulta/addHorario.php",
                      method:"POST",
                      data:{employee_id:employee_id},
                      success:function(data){
                           $('#employee_detailHor').html(data);
                           $('#dataModalHor').modal('show');
                      }
                 });
            }
       });
  });

</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
