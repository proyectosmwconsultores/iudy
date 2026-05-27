<?php $mnAl = 3; $section = "Mis actividades"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de las tareas'); }
if(!$_SESSION['IdAsignacion']){
	$_SESSION['IdAsignacion'] = $_GET["Id"];
}
if($_SESSION['Permisos']) {

	if(isset($_GET["tok"])){
		$IdParcial = substr($_GET["tok"], 10, 10);
	}

 $lstParcial=$t->get_parcialDatos($_SESSION['IdAsignacion'],$IdParcial);
 if(!$lstParcial[0]){
 	header("Location:miAsignatura.php");
 }

 $lstActividades=$t->get_actividadesPar($_SESSION['IdAsignacion']);

	$AsignacionId=$t->get_datosModuloD($_SESSION['IdAsignacion']);
	if($AsignacionId[0]["NombreMod"]) {
	$ForoAlumno=$t->get_datosActividadesAlumno($_SESSION['IdAsignacion']);
if($AsignacionId[0]["Curso"] == 0){
	$tipoPar = $lstParcial[0]["Tipo"]; if($tipoPar=="P"){ $tpar = "Parcial"; } else { $tpar = "Extraordinario";}
} else {
	$tpar = "Módulo";
}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel='stylesheet prefetch' href='assets/fancy/css/ybgpzy.css'>
<!--<link rel="stylesheet" href="assets/fancy/css/style.css">-->
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
	<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
			<section class="content-header">
				<h1><?php echo $AsignacionId[0]["NombreMod"];?></h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i><?php echo substr($AsignacionId[0]["NombreMod"], 0 , 40).' [...]';?></a></li>
					<li class="active"><a href="#">Tareas</a></li>
				</ol>
			</section>
			<form name="frm" id="frm" action="doSelActividades.php" method="POST" enctype="multipart/form-data">
				<input id="Id" name="Id" value="<?php echo $_SESSION['IdAsignacion']; ?>" type="hidden"/>
				<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
				<input id="saveF" name="saveF" value="<?php echo $_SESSION['SaveFile']; ?>" type="hidden"/>

				<input id="IdParcial" name="IdParcial" value="<?php echo $IdParcial; ?>" type="hidden"/>
				<input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_SESSION['IdAsignacion']; ?>" type="hidden"/>

			<section class="content">
				<div class="row">
					<div class="col-md-12">

						<div class="box box-widget">
							<div class="box-body">
              <strong><?php echo $tpar.' '.$lstParcial[0]["NoParcial"]; ?></strong>
            <br>
              <strong>Tema: </strong> <?php echo $lstParcial[0]["Tema"]; ?>
              <br>
              <strong>Objetivo: </strong> <?php echo $lstParcial[0]["Objetivo"]; ?>
              <hr>
            </div>


							<div class="tab-pane active" id="timeline">
								<ul class="timeline timeline-inverse">

								<?php

								$semana=$t->get_semanadocente($IdParcial,$lstParcial[0]["IdModulo"]);
								 for ($s=0;$s< sizeof($semana);$s++) { $IdSemana = $semana[$s]["IdSemanaDocente"];
									$actividades=$t->get_actividadSemAlum($IdParcial,$IdSemana);
									$fuente=$t->get_fuenteSemana($IdSemana);
									 ?>
								<li class="time-label">
											<span class="bg-red">
												Unidad <?php echo $semana[$s]["NoSemana"]; ?>
											</span>
								</li>

								<li>
									<i class="fa fa-bookmark bg-blue"></i>

									<div class="timeline-item">
										<div class="timeline-body"><b>Informacion de la unidad:</b> <br>
                        <?php echo $semana[$s]["Temas"]; ?>
                      </div>




									</div>
								</li>
								<?php if($actividades[0]){ for ($ac=0;$ac< sizeof($actividades);$ac++) {
									$respAlumnos=$t->get_respuestaAlumnos($actividades[$ac]["IdActividadesDocente"],$_SESSION['IdAsignacion']);
									$IdEstatus = $actividades[$ac]["IdEstatus"];
									?>

								<li>
									<i class="fa fa-<?php if($actividades[$ac]["Modalidad"] == 2) { echo "users";} else { echo "user"; } ?> bg-aqua"></i>
									<!-- <i class="fa fa-map-signs bg-green"></i> -->

									<div class="timeline-item">

          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1-<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>" data-toggle="tab" aria-expanded="true"><span class="time"><i class="fa fa-bell"></i> <?php echo $actividades[$ac]["TipoActividad"]; ?></span></a></li>
              <!-- <li class=""><a href="#tab_2-<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>" data-toggle="tab" aria-expanded="false"> <i class="fa fa-fw fa-info"></i> Datos generales</a></li> -->
							<?php // if($actividades[$ac]["IdTipoActividad"] <> 2){ ?>
							<!-- <li class=""><a  class="coment_data" href="javascript:void(0);" name="coment" value="coment" id="<?php echo $respAlumnos[0]["IdTarea"].'-'.$_SESSION['IdUsua'].'-A'; ?>"><i class="fa fa-fw fa-comments"></i> Chat</a></li> -->
						  <?php //} ?>
							<?php // if(($actividades[$ac]["IdTipoActividad"] == 3) || ($actividades[$ac]["IdTipoActividad"] == 4)){ ?>
							<!-- <li class=""><a href="#tab_3-<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>" data-toggle="tab" aria-expanded="false"><i class="fa fa-fw fa-folder-open"></i> Mi trabajo</a></li> -->

						  <?php// } ?>

							 <?php //if($actividades[$ac]["IdEstatus"] == 8){

							//	if($actividades[$ac]["IdTipoActividad"] == 1){ ?>
					<!--				<li class=""><a onclick="iniciarExamen(<?php //echo $actividades[$ac]["IdActividadesDocente"]; ?>,<?php echo $respAlumnos[0]["IdTarea"] ?>)" href="javascript:void(0);" data-toggle="tab" aria-expanded="false"><i class="fa fa-fw fa-crosshairs"></i> Comenzar evaluaci&oacute;n</a></li>
								<?php // } elseif($actividades[$ac]["IdTipoActividad"] == 2) { ?>
									<li class=""><a onClick="window.open('viewForoId.php?Id=<?php // echo $actividades[$ac]["IdActividadesDocente"]; ?>','_self')" href="javascript:void(0);" data-toggle="tab" aria-expanded="false"><i class="fa fa-fw fa-wechat"></i> Ingresar al foro</a></li>

								<?php //} else {
								?>
	              <li class="dropdown">
	                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
	                  <i class="fa fa-send"></i> Responder <span class="caret"></span>
	                </a>
	                <ul class="dropdown-menu">
										<li><a onClick="window.open('miEditor.php?toks=<?php// echo time().$actividades[$ac]["IdActividadesDocente"]; ?>&tok=<?php echo time().$IdParcial; ?>','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-edit"></i> Editor</a></li>
										<li><a href="javascript:void(0);"  class="view_subir" name="view" value="view" id="<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>"><i class="fa fa-fw fa-file"></i> Archivo</a></li>
										<!-- <li><a href="javascript:void(0);"  class="view_subirImg" name="view" value="view" id="<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>"><i class="fa fa-fw fa-file-image-o"></i> Imagen</a></li>
										<li><a href=""><i class="fa fa-fw fa-youtube-play"></i> Video YouTube</a></li> -->
	                <!-- </ul>
	              </li> -->
							<?php //} } ?>
							<?php

							if($respAlumnos[0]["FecFinal"]){
									$hoy = date("Y-m-d");
									if($respAlumnos[0]["FecFinal"] >= $hoy){
										$IdEstatus = 8; $txz = " (especial)";
									} else {
										$IdEstatus = $IdEstatus; $txz = "";
									}
							}
							  ?>




              <li class="pull-right"><a href="javascript:void(0);" >
								<?php if($IdEstatus == 6){ ?>
								<b style="color: green;">	<i class="fa fa-flag-checkered"></i> En proceso</b>
								<?php } elseif($IdEstatus == 8) { ?>
									<b><i class="fa fa-unlock"></i> En tiempo <?php echo $txz; ?></b>
								<?php } elseif($IdEstatus == 26) { ?>
									<b style="color: red;"><i class="fa fa-expeditedssl"></i> Finalizado</b>
								<?php } elseif($IdEstatus == 12) { ?>
									<b><i class="fa fa-lock"></i> Inactivo</b>
								<?php } ?>
							</a>

							</li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1-<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>">
								<table class="table table-striped">
	                <tbody>
	                <tr>
	                  <td style="width: 10px"><i class="fa fa-fw fa-calendar-check-o"></i></td>
	                  <td>Fecha de inicio: <?php echo obtenerFechaEnLetra($actividades[$ac]["FecIni"]); ?></td>
	                  <td>Fecha de cierre: <?php echo obtenerFechaEnLetra($actividades[$ac]["FecFin"]); ?></td>
	                </tr>
									<?php if(($actividades[$ac]["IdTipoActividad"] == 1) && ($actividades[$ac]["Fin"])){ ?>
									<tr style="background: red; color: white; font-weight: bold;">
	                  <td style="width: 10px"><i class="fa fa-fw fa-clock-o"></i></td>
	                  <td colspan="2">Fecha de la evaluación: <?php echo obtenerFechaEnLetra($actividades[$ac]["Ini"]); ?> a partir de las <?php echo substr($actividades[$ac]["Ini"], 11, 10); ?> hasta el día <?php echo obtenerFechaEnLetra($actividades[$ac]["Fin"]); ?> hasta las <?php echo substr($actividades[$ac]["Fin"], 11, 10); ?></td>
	                </tr><?php } ?>
									<tr>
	                  <td style="width: 10px"><i class="fa fa-fw fa-gg-circle"></i></td>
	                  <td>Porcentaje: <?php echo $actividades[$ac]["Porcentaje"]; ?> %</td>
	                  <td>Trabajo: <?php if($actividades[$ac]["Modalidad"] == 2){ echo "En equipo"; } else { echo "Individual"; } ?></td>
	                </tr>
									<?php if($respAlumnos[0]["Calificacion"]){ ?>
										<tr>
		                  <td style="width: 10px"><i class="fa fa-fw fa-gg"></i></td>
		                  <td>Porcentaje logrado:</td>
		                  <td><?php echo $respAlumnos[0]["Porcentaje"]; ?> %</td>
		                </tr>
									<?php } ?>
									<tr>
	                  <th colspan="3">Nombre: <?php echo $actividades[$ac]["NomActividad"]; ?></th>
	                </tr>
									<tr>
	                  <td colspan="3"><b>Desarrollo de la actividad:</b><br> <?php echo $actividades[$ac]["DesActividad"]; ?></td>
	                </tr>

									<tr>
	                  <td colspan="2">

											<?php if($IdEstatus == 8){

												if($actividades[$ac]["IdTipoActividad"] == 1){ ?>
													<button type="button" onclick="iniciarExamen(<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>,<?php echo $respAlumnos[0]["IdTarea"]; ?>,<?php echo $IdParcial; ?>)" href="javascript:void(0);" class="btn btn-primary btn-block"><i class="fa fa-fw fa-crosshairs"></i> Comenzar evaluaci&oacute;n</button>

												<?php } elseif($actividades[$ac]["IdTipoActividad"] == 2) { ?>
													<button type="button" onClick="window.open('viewForoId.php?idToks=<?php echo $_SESSION['IdAsignacion']; ?>&Id=<?php echo time().$actividades[$ac]["IdActividadesDocente"]; ?>','_self')" href="javascript:void(0);" class="btn btn-primary btn-block"><i class="fa fa-fw fa-wechat"></i> Ingresar al foro</button>
													<!-- <li class=""><a onClick="window.open('viewForoId.php?Id=<?php //echo $actividades[$ac]["IdActividadesDocente"]; ?>','_self')" href="javascript:void(0);" data-toggle="tab" aria-expanded="false"><i class="fa fa-fw fa-wechat"></i> Ingresar al foro</a></li> -->

												<?php } else {
												?>
												<button type="button" href="javascript:void(0);"  name="view" value="view" id="<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>" class="btn btn-primary btn-block view_subir"><i class="fa fa-fw fa-upload"></i> Subir mi tarea</button>
														<!-- <li><a onClick="window.open('miEditor.php?toks=<?php echo time().$actividades[$ac]["IdActividadesDocente"]; ?>&tok=<?php echo time().$IdParcial; ?>','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-edit"></i> Editor</a></li> -->
														<!-- <li><a href="javascript:void(0);"  class="view_subir" name="view" value="view" id="<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>"><i class="fa fa-fw fa-file"></i> Archivo</a></li> -->
														<!-- <li><a href="javascript:void(0);"  class="view_subirImg" name="view" value="view" id="<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>"><i class="fa fa-fw fa-file-image-o"></i> Imagen</a></li>
														<li><a href=""><i class="fa fa-fw fa-youtube-play"></i> Video YouTube</a></li> -->

											<?php } } ?>
										</td>
										<td>
											<?php if($actividades[$ac]["IdTipoActividad"] <> 2){ ?>
												<button type="button" href="javascript:void(0);"  name="view" value="view" id="<?php echo $respAlumnos[0]["IdTarea"].'-'.$_SESSION['IdUsua'].'-A'; ?>" class="btn btn-info btn-block coment_data"><i class="fa fa-fw fa-commenting"></i> Chat de la actividad</button>
											<!-- <li class=""><a  class="coment_data" href="javascript:void(0);" name="coment" value="coment" id="<?php echo $respAlumnos[0]["IdTarea"].'-'.$_SESSION['IdUsua'].'-A'; ?>"><i class="fa fa-fw fa-comments"></i> Chat</a></li> -->
										  <?php } ?>

										</td>

	                </tr>
									<?php if(($actividades[$ac]["IdTipoActividad"] == 3) || ($actividades[$ac]["IdTipoActividad"] == 4)){ ?>
									<tr>
	                  <th colspan="3">Mi lista de trabajos subidos:</th>
	                </tr>
									<?php if($respAlumnos[0]["Link"]) {

										 ?>
										<tr>
											<td style="width: 10px"><i class="fa fa-fw fa-file"></i></td>
											<td>Archivo 1</td>
		                  <td>
												<button type="button" onclick="verFile(<?php echo $respAlumnos[0]["IdTarea"]; ?>,'Link')" class="btn btn-block btn-success btn-xs"> <i class="fa fa-fw fa-file-o"></i> Ver archivo</button>

											</td>
		                </tr>
									<?php } ?>
									<?php if($respAlumnos[0]["Link2"]) { ?>
										<tr>
											<td style="width: 10px"><i class="fa fa-fw fa-file"></i></td>
											<td>Archivo 2</td>
		                  <td>
												<button type="button" onclick="verFile(<?php echo $respAlumnos[0]["IdTarea"]; ?>,'Link2')" class="btn btn-block btn-success btn-xs"><i class="fa fa-fw fa-file-o"></i> Ver archivo</button>

											</td>
		                </tr>
									<?php } ?>
									<?php if($respAlumnos[0]["Link3"]) { ?>
										<tr>
											<td style="width: 10px"><i class="fa fa-fw fa-file"></i></td>
											<td>Archivo 3</td>
		                  <td>
												<button type="button" onclick="verFile(<?php echo $respAlumnos[0]["IdTarea"]; ?>,'Link3')" class="btn btn-block btn-success btn-xs"> <i class="fa fa-fw fa-file-o"></i> Ver archivo</button>

											</td>
		                </tr>
									<?php } } ?>


	              </tbody></table>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2-<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>">
								<table class="table table-striped">
                <tbody><tr>
                  <th>Instrucción de la actividad:</th>
                </tr>
                <tr>
                  <td><?php echo $actividades[$ac]["DesActividad"]; ?></td>
                </tr>
              </tbody></table>
              </div>
              <div class="tab-pane" id="tab_3-<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>">
								<table class="table table-striped">
                <tbody>
									<tr>
	                  <th colspan="3">Mi lista de trabajos subidos:</th>
	                </tr>
									<?php if($respAlumnos[0]["Link"]) {

										 ?>
										<tr>
											<td style="width: 10px"><i class="fa fa-fw fa-file"></i></td>
											<td>Archivo 1</td>
		                  <td>
												<button type="button" onclick="verFile(<?php echo $respAlumnos[0]["IdTarea"]; ?>,'Link')" class="btn btn-block btn-primary btn-xs">Ver archivo</button>
												<!-- <a onClick="window.open('assets/trabajos/<?php echo $respAlumnos[0]["IdAsignacion"]; ?>/tareas/<?php echo $respAlumnos[0]["Link"]; ?>','_blank')" href="javascript:void(0);" class="btn"><button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-cloud-download"></i></button></a> -->
											</td>
		                </tr>
									<?php } ?>
									<?php if($respAlumnos[0]["Link2"]) { ?>
										<tr>
											<td style="width: 10px"><i class="fa fa-fw fa-file"></i></td>
											<td>Archivo 2</td>
		                  <td>
												<button type="button" onclick="verFile(<?php echo $respAlumnos[0]["IdTarea"]; ?>,'Link2')" class="btn btn-block btn-primary btn-xs">Ver archivo</button>
												<!-- <a onClick="window.open('assets/trabajos/<?php echo $respAlumnos[0]["IdAsignacion"]; ?>/tareas/<?php echo $respAlumnos[0]["Link2"]; ?>','_blank')" href="javascript:void(0);" class="btn"><button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-cloud-download"></i></button></a> -->
											</td>
		                </tr>
									<?php } ?>
									<?php if($respAlumnos[0]["Link3"]) { ?>
										<tr>
											<td style="width: 10px"><i class="fa fa-fw fa-file"></i></td>
											<td>Archivo 3</td>
		                  <td>
												<button type="button" onclick="verFile(<?php echo $respAlumnos[0]["IdTarea"]; ?>,'Link3')" class="btn btn-block btn-primary btn-xs">Ver archivo</button>
												<!-- <a onClick="window.open('assets/trabajos/<?php echo $respAlumnos[0]["IdAsignacion"]; ?>/tareas/<?php echo $respAlumnos[0]["Link3"]; ?>','_blank')" href="javascript:void(0);" class="btn"><button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-cloud-download"></i></button></a> -->
											</td>
		                </tr>
									<?php } ?>
									<?php if($respAlumnos[0]["Editor"] == 1) { ?>
										<tr>
											<td style="width: 10px"><i class="fa fa-fw fa-edit"></i></td>
											<td>Editor</td>
		                  <td>
												<button type="button" onClick="window.open('miEditor.php?toks=<?php echo time().$actividades[$ac]["IdActividadesDocente"]; ?>&tok=<?php echo time().$IdParcial; ?>','_self')" href="javascript:void(0);" class="btn btn-block btn-primary btn-xs">Editor</button>
												<!-- <a  class="btn"><button type="button" class="btn btn-primary btn-sm pull-right"><i class="fa fa-edit"></i></button></a> -->
											</td>
		                </tr>
									<?php } ?>
              </tbody></table>
              </div>
            </div>
          </div>
									</div>
								</li>
							<?php } } } ?>
								<li>
									<i class="fa fa-clock-o bg-gray"></i>
								</li><br>
							</ul>
              </div>
						</div>
					</div>
				</div>
			</section>
			<form>
			<div id="dataModal2" class="modal fade"> <!--MODAL ME COMENNTARIOS-->
						<div class="modal-dialog">
								 <div class="modal-content">
											<div class="modal-body" id="employee_detail2">
											</div>
								 </div>
						</div>
			 </div>
			 <div id="dataModal1" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
								 <div class="modal-content">
									 <div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">M&oacute;dulo para responder actividad</h4>
 									</div>
											<div class="modal-body" id="employee_detail1">
											</div>
								 </div>
						</div>
			 </div>

			 <div id="dataModal2Img" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
								 <div class="modal-content">
									 <div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">M&oacute;dulo para responder actividad (Imagen)</h4>
 									</div>
											<div class="modal-body" id="employee_detail2Img">
											</div>
								 </div>
						</div>
			 </div>
			<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
								 <div class="modal-content">
									 <div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Chat de la actividad</h4>
									 </div>
											<div class="modal-body" id="employee_detail">
											</div>
								 </div>
						</div>
			 </div>

			 <div id="dataModal3" class="modal fade"> <!--MODAL ME GUSTA-->
 						<div class="modal-dialog">
 								 <div class="modal-content">
 											<div class="modal-body" id="employee_detail3">
 											</div>
 								 </div>
 						</div>
 			 </div>
			 <div id="dataModal8" class="modal fade"> <!--MODAL ME GUSTA-->
 						<div class="modal-dialog">
 								 <div class="modal-content">
									 <div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Vista previa del trabajo</h4>
									 </div>
 											<div class="modal-body" id="employee_detail8">
 											</div>
 								 </div>
 						</div>
 			 </div>
			 <div id="dataModalExam" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
								 <div class="modal-content">
											<div class="modal-body" id="employee_detailExam">
											</div>
								 </div>
						</div>
			 </div>

		</div>
	<?php include("footer.php"); ?>
	</div>
</body>
<script>
	// function iniciarExamen(IdActividadDoc,IdTarea){
	// 	var IdAsignacion = document.getElementById("IdAsignacion").value;
	// 	var IdUsua = document.getElementById("IdUsua").value;
	//   var IdParcial = document.getElementById("IdParcial").value;
	//
	// 	swal({
	// 		title: "\u00BFEst\u00E1 seguro que desea iniciar esta evaluaci\u00F3n? \n Recuerde que una vez iniciado comenzar\u00E1 a correr su tiempo?",
	// 		type: "warning",
	// 		showCancelButton: true,
	// 		confirmButtonColor: '#DD6B55',
	// 		confirmButtonText: 'Aceptar',
	// 		cancelButtonText: "Cancelar",
	// 	},
	// 	function (isConfirm) {
	// 		if (isConfirm) {
	// 			$.ajax({
	// 					 url:"formConsulta/viewRealizarExamen.php",
	// 					 method:"POST",
	// 					 data:{IdAsignacion:IdAsignacion,IdUsua:IdUsua,IdParcial:IdParcial,IdActividadDoc:IdActividadDoc,IdTarea:IdTarea},
	// 					 success:function(data){
	// 								$('#employee_detailExam').html(data);
	// 								$('#dataModalExam').modal('show');
	// 					 }
	// 			});
	// 		}
	// 	});
	//
	// }

	function iniciarExamen(IdActividadDoc,IdTarea, IdParcial){
		// var IdAsignacion = document.getElementById("IdAsignacion").value;
		// var IdUsua = document.getElementById("IdUsua").value;
	  // var IdParcial = document.getElementById("IdParcial").value;

		swal({
			title: "\u00BFEst\u00E1 seguro que desea iniciar esta evaluaci\u00F3n? \n Recuerde que una vez iniciado comenzar\u00E1 a correr su tiempo?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Aceptar',
			cancelButtonText: "Cancelar",
		},
		function (isConfirm) {
			if (isConfirm) {

				parent.location.href='viewEvaYseC.php?Id=8643543276'+IdActividadDoc+'&IdP=9807506430'+IdParcial+'&IdT=7090980989'+IdTarea; //direcciona la pagina madre
			}
		});

	}

 $(document).ready(function(){
      $(document).on('click', '.view_data', function(){
           var employee_id = $(this).attr("id");
					 var Id = document.getElementById("Id").value;
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/viewForoDetalle.php",
                     method:"POST",
                     data:{employee_id:employee_id,Id:Id},
                     success:function(data){
                          $('#employee_detail').html(data);
                          $('#dataModal').modal('show');
                     }
                });
           }
      });
 });

 $(document).ready(function(){
      $(document).on('click', '.view_fuente', function(){
           var employee_id = $(this).attr("id");
					 var Id = document.getElementById("Id").value;
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/viewFuente.php",
                     method:"POST",
                     data:{employee_id:employee_id,Id:Id},
                     success:function(data){
                          $('#employee_detail').html(data);
                          $('#dataModal').modal('show');
                     }
                });
           }
      });
 });

 $(document).ready(function(){
      $(document).on('click', '.view_editor', function(){
           var employee_id = $(this).attr("id");
					 var Id = document.getElementById("Id").value;
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/viewEditor.php",
                     method:"POST",
                     data:{employee_id:employee_id,Id:Id},
                     success:function(data){
                          $('#employee_detail').html(data);
                          $('#dataModal').modal('show');
                     }
                });
           }
      });
 });

 $(document).ready(function(){
 		 $(document).on('click', '.view_subir', function(){
 					var employee_id = $(this).attr("id");
					var IdAsignacion = document.getElementById("Id").value;
					var IdUsua = document.getElementById("IdUsua").value;

 					if(employee_id != '')
 					{
 							 $.ajax({
 										url:"formConsulta/uploadTarea.php",
 										method:"POST",
 										data:{employee_id:employee_id, IdAsignacion:IdAsignacion, IdUsua:IdUsua},
 										success:function(data){
 												 $('#employee_detail1').html(data);
 												 $('#dataModal1').modal('show');
 										}
 							 });
 					}
 		 });
 });

 $(document).ready(function(){
 		$(document).on('click', '.view_subirImg', function(){
 				 var employee_id = $(this).attr("id");
 				 var IdAsignacion = document.getElementById("Id").value;
 				 var IdUsua = document.getElementById("IdUsua").value;

 				 if(employee_id != '')
 				 {
 							$.ajax({
 									 url:"formConsulta/uploadTareaImg.php",
 									 method:"POST",
 									 data:{employee_id:employee_id, IdAsignacion:IdAsignacion, IdUsua:IdUsua},
 									 success:function(data){
 												$('#employee_detail2Img').html(data);
 												$('#dataModal2Img').modal('show');
 									 }
 							});
 				 }
 		});
 });


 $(document).ready(function(){
      $(document).on('click', '.coment_data', function(){
           var employee_id = $(this).attr("id");
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/viewComentarios.php",
                     method:"POST",
                     data:{employee_id:employee_id},
                     success:function(data){
                          $('#employee_detail').html(data);
                          $('#dataModal').modal('show');
                     }
                });
           }
      });
 });

 $(document).ready(function(){
      $(document).on('click', '.view_resul', function(){

           var employee_id = $(this).attr("id");
					 var Id = document.getElementById("Id").value;
					 var IdUsua = document.getElementById("IdUsua").value;

           if(employee_id != '')
           {

                $.ajax({
                     url:"formConsulta/viewRespuestaAlu.php",
                     method:"POST",
                     data:{employee_id:employee_id,Id:Id,IdUsua:IdUsua},
                     success:function(data){

                          $('#employee_detail3').html(data);
                          $('#dataModal3').modal('show');
                     }
                });
           }
      });
 });

function verFile(IdTarea,Ubicacion){
	$.ajax({
			 url:"formConsulta/viewFile.php",
			 method:"POST",
			 data:{IdTarea:IdTarea,Ubicacion:Ubicacion},
			 success:function(data){

						$('#employee_detail8').html(data);
						$('#dataModal8').modal('show');
			 }
	});

}


 $(document).ready(function(){
	 var alerta = document.frm.saveF.value;
	 if(alerta){
		 if(alerta =="0"){
			 swal("Error", "Error no se puede Guardar", "error");
		 }
		 if(alerta =="1"){
			 swal("Guardado", "Archivo guardado con exito", "success");
		 }
	 }
 });


 //$(document).on('click', '.edit_data', function(){
	//		var employee_id = $(this).attr("id");
	//		$('#add_data_Modal').modal('show');
	//		$('#NoActividad').val(employee_id);
// });
 </script>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src='assets/fancy/js/ybgpzy.js'></script>
<!-- jQuery 3 -->
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php unset($_SESSION['SaveFile']);  ?>
<?php } else {
echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
}
} else {
echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>
