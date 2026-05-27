<?php $_v = 91;
$section = "Planeación general";
include("head.php");

if (($_SESSION['IdUsua']) && ($_SESSION['Permisos'])) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de Planeación general.');
}

$t->get_validar_mat_doc($_GET["idToks"], $_SESSION['IdUsua']);
$dat_ = $t->get_datosId($_GET["idToks"]);

$_SESSION['txt'] = $dat_[0]['_texto'];
$_SESSION['noPar'] = $dat_[0]['NoParcial'];

$asignaturaId = $t->get_asignaturaId($_GET["idToks"]);

$t->chk_parcial_mod($_GET["idToks"], $dat_[0]['IdCiclo'], $dat_[0]['IdGrupo'], $asignaturaId[0]['Modalidad']);
$curso = 0;
$IdPAc = 0;

$tixc = $asignaturaId[0]["IdEstatus"];
if (($tixc == 12) || ($tixc == 8)) {
	$rtx = "A";
	$_SESSION['EstatusAsig'] = 'A';
} else {
	$rtx = "F";
	$_SESSION['EstatusAsig'] = 'F';
}

if (isset($_GET["tok"])) {
	$act1 = "";
	$act2 = "";
	$IdPAc = $_GET["tok"];
} else {
	$act1 = "class='active'";
	$act2 = "active";
}

$parciales = $t->get_parcialDocente($asignaturaId[0]["IdEducativa"], $asignaturaId[0]["IdModulo"], $_GET["idToks"]);

$horario = $t->get_horario($_GET["idToks"]);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<?php if ($_SESSION['EstatusAsig'] == "F") { include("formConsulta/alerta.php"); } ?>
			<section class="content-header">
				<h1>
					Planeación y guía didáctica del programa
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-bars"></i> Informaci&oacute;n</a></li>
					<li class="active">Planeación académica</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<form name="frm" id="frm" action="doMiPlaneacion.php" method="POST" enctype="multipart/form-data">
							<input id="Mov" name="Mov" value="<?php if (isset($_GET["Mov"])) { echo $_GET["Mov"]; } ?>" type="hidden" />
							<input id="txtOferta" name="txtOferta" value="<?php echo $asignaturaId[0]["IdEducativa"]; ?>" type="hidden" />
							<input id="txtModulo" name="txtModulo" value="<?php echo $asignaturaId[0]["IdModulo"]; ?>" type="hidden" />
							<input id="IdDatosM" name="IdDatosM" value="" type="hidden" />
							<input id="Alerta" name="Alerta" value="<?php echo isset($_SESSION['Alerta']); ?>" type="hidden" />
							<input id="Variable" name="Variable" value="<?php echo isset($_SESSION['Variable']); ?>" type="hidden" />
							<input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_GET["idToks"]; ?>" type="hidden" />
							<!-- <input id="IdPlaneacion" name="IdPlaneacion" value="<?php if (isset($costoPlan[0]["IdPlaneacion"])) { echo $costoPlan[0]["IdPlaneacion"]; } ?>" type="hidden" /> -->
							<input id="Curso" name="Curso" value="<?php echo $curso; ?>" type="hidden" />
							<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden" />
							<div class="row">
								<div class="col-md-12">
									<a style="float: right;" class="btn btn-app view_fondo" id="<?php echo $dat_[0]['IdAsignacion']; ?>"><span class="badge bg-blue">Seleccionar</span><i class="fa fa-black-tie"></i> Fondo</a>
									<a style="float: right;" class="btn btn-app" onclick="portafolio()"><span class="badge bg-red">Nuevo</span><i class="fa fa-black-tie"></i> Portafolio</a>
									<?php if($asignaturaId[0]["contrato"] == 1){ ?>
									<a style="float: right;" class="btn btn-app" onclick="firmar_contrato('<?php echo $dat_[0]['IdAsignacion']; ?>')"><span class="badge bg-black">Ver</span><i class="fa fa-bell"></i> Contrato</a>
									<?php } ?>
									
									<div class="nav-tabs-custom">
										<ul class="nav nav-tabs">
											<li <?php echo $act1; ?>><a href="#activity98618" data-toggle="tab" aria-expanded="true"> Mi planeación</a></li>
											<?php for ($x = 0; $x < sizeof($parciales); $x++) {
												$IdParcial = $parciales[$x]["IdParcialDocente"];
												if ($IdParcial == 1) { $clss = "class='active'"; } else { $clss = ""; } ?>
												<li <?php if ($IdPAc == $IdParcial) { echo "class='active'"; } ?>><a href="#activity<?php echo $IdParcial; ?>" data-toggle="tab" aria-expanded="true"> <?php echo $parciales[$x]["Titulo"] ?></a></li>
											<?php } ?>
										</ul>
										<div class="tab-content">
											<div class="tab-pane <?php echo $act2; ?>" id="activity98618">
												<div class="row">
													<div class="col-xs-12">
														<div class="table-responsive">
															<table class="table">
																<tbody>
																	<tr>
																		<th style="text-align: right;">Campus:</th>
																		<td><?php echo $dat_[0]['Campus']; ?></td>
																		<th style="text-align: right;">Periodo escolar:</th>
																		<td><?php echo $asignaturaId[0]["Periodo"]; ?></td>
																	</tr>
																	<tr>
																		<th style="text-align: right;">Plan de estudios:</th>
																		<td><?php echo $dat_[0]['Nombre']; ?></td>
																		<th style="text-align: right;">Nivel:</th>
																		<td><?php echo $asignaturaId[0]["_Grado"]; ?></td>
																	</tr>
																	<tr>
																		<th style="text-align: right;">Programa de estudios:</th>
																		<td><?php echo $dat_[0]['NombreMod']; ?></td>
																		<th style="text-align: right;">Clave:</th>
																		<td><?php echo $dat_[0]['CodeModulo']; ?></td>
																	</tr>
																	<tr>
																		<th style="text-align: right;">Docente:</th>
																		<td><?php echo $asignaturaId[0]["NomDocente"] . ' ' . $asignaturaId[0]["APaterno"] . ' ' . $asignaturaId[0]["AMaterno"]; ?></td>
																		<th style="text-align: right;">Grupo:</th>
																		<td><?php echo $asignaturaId[0]['CveGrupo']; ?></td>
																	</tr>
																	<tr>
																		<th style="text-align: right;">Fecha inicio:</th>
																		<td><?php echo obtenerFechaEnLetra($asignaturaId[0]['FecIni']); ?></td>
																		<th style="text-align: right;" rowspan="2">Horario de las sesiones:</th>
																		<td rowspan="2">
																			<?php for ($h = 0; $h < sizeof($horario); $h++) {
																				if ($h == 2) {
																					echo '<br>';
																				}
																				echo $horario[$h]["Dia"] . ' ' . $horario[$h]["HraIni"] . ':' . $horario[$h]["MinIni"] . ' a ' . $horario[$h]["HraFin"] . ':' . $horario[$h]["MinFin"] . ' ';
																			} ?>
																		</td>
																	</tr>
																	<tr>
																		<th style="text-align: right;">Fecha final:</th>
																		<td><?php echo obtenerFechaEnLetra($asignaturaId[0]['FecFin']); ?></td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="col-xs-12 table-responsive">
														<table class="table table-striped">
															<thead>
																<tr style="background: #dd4141; color: white;">
																	<th colspan="3" onclick="captura_objetivos(<?php echo $asignaturaId[0]["IdModulo"]; ?>)" style="cursor: pointer;"><b><i class="fa fa-edit"></i> Captura de objetivos</b></th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
											</div>
											<?php for ($y = 0; $y < sizeof($parciales); $y++) {
												$IdParcial = $parciales[$y]["IdParcialDocente"];
												$semana = $t->get_semanadocente($IdParcial, $asignaturaId[0]["IdModulo"]);
												$avance = $t->get_avanceParcial($_GET["idToks"], $IdParcial);
												if ($parciales[$y]["IdEstatus"] == 12) {
													$nomEs = "En proceso";
												} elseif ($parciales[$y]["IdEstatus"] == 3) {
													$nomEs = "En revisión";
												} elseif ($parciales[$y]["IdEstatus"] == 4) {
													$nomEs = "Aprobado";
												}
												if ($IdParcial == 1) {
													$clssT = "active";
												} else {
													$clssT = "";
												} ?>
												<div class="tab-pane <?php if ($IdPAc == $IdParcial) { echo "active"; } ?> " id="activity<?php echo $IdParcial; ?>">
													<div class="col-md-12"><br>
														<a style="float: right;" class="btn btn-app" onclick="crearSemana(<?php echo $IdParcial; ?>)"><span class="badge bg-success">Nuevo</span><i class="fa fa-edit"></i> Crear contenido</a><br>
														Total pocentaje en actividades del <?php echo $parciales[$y]["Titulo"]; ?>: <b><?php echo $avance[0]["Avance"]; ?> %</b><br>
														<div class="progress progress-sm active">
															<div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avance[0]["Avance"]; ?>%">
																<span class="sr-only">20% Complete</span>
															</div>
														</div>
													</div>
													<div class="col-md-12">
														<ul class="timeline timeline-inverse">
															<?php for ($s = 0; $s < sizeof($semana); $s++) {
																$IdSemana = $semana[$s]["IdSemanaDocente"];
																$actividades = $t->get_actividadSemDoc($IdParcial, $IdSemana); ?>
																<li class="time-label">
																	<span class="bg-green">
																		<?php echo $semana[$s]["Etiqueta_semana"]; ?>
																	</span>
																</li>
																<li>
																	<i class="fa fa-get-pocket bg-aqua"></i>
																	<div class="timeline-item">
																		<span class="time"><i class="fa fa-qrcode"></i></span>
																		<h3 class="timeline-header"><a href="#"><?php echo $semana[$s]["Semana"]; ?></a></h3>
																		<div class="timeline-body">
																			<b>Objetivo sobre el contenido temático: </b><br><?php echo $semana[$s]["Tematica"]; ?>
																			<br><br>
																			<b>Contenidos temáticos:</b>
																			<?php echo $semana[$s]["Temas"]; ?>
																			<p style="text-align: right;">
																				<?php if ($avance[0]["Avance"] < 100) { ?>
																					<a onclick="crearActividad(<?php echo $IdParcial; ?>,<?php echo $IdSemana; ?>)" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i> Actividad</a>
																				<?php } ?>
																				<a onclick="modificarSemana(<?php echo $IdSemana; ?>)" class="btn btn-danger"><i class="fa fa-fw fa-refresh"></i> Actualizar</a>
																			</p>
																		</div>
																	</div>
																</li>

																<?php if (isset($actividades[0])) {
																	for ($ac = 0; $ac < sizeof($actividades); $ac++) { ?>
																		<li>
																			<i class="fa fa-<?php if ($actividades[$ac]["Modalidad"] == 2) { echo "users"; } else { echo "user"; } ?> bg-aqua"></i>
																			<div class="timeline-item">
																				<span class="time"><i class="fa fa-bell"></i> <?php echo $actividades[$ac]["TipoActividad"]; ?></span>
																				<h3 class="timeline-header"><?php echo $actividades[$ac]["NomActividad"]; ?></h3>
																				<div class="timeline-body">
																					<ol class="breadcrumb" style="color: #72afd2;">
																						<li><i class="fa fa-dashboard"></i> <?php echo $actividades[$ac]["Estrategia"]; ?></li>
																						<li><i class="fa fa-tags"></i> <?php echo $actividades[$ac]["Tecnica"]; ?></li>
																						<li><i class="fa fa-file-text"></i> <?php echo $actividades[$ac]["Herramienta"]; ?></li>
																					</ol>

																					<?php echo $actividades[$ac]["DesActividad"];
																					?>
																					<br>
																					<?php $_xc = 0;
																					if ($actividades[$ac]["FecIni"]) {
																						$_xc = 1; ?>
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
																					<?php } else {
																						$_xc = 0; ?>
																						<div class="alert alert-danger alert-dismissible">
																							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
																							<h4><i class="icon fa fa-ban"></i> Alerta</h4>
																							Usted tiene pendiente configurar los datos de esta actividad.
																						</div>
																					<?php } ?>

																					<p style="text-align: right;">
																						<?php if (($actividades[$ac]["IdEstatus"] == 12) && ($_xc == 1) && ($actividades[$ac]["IdTipoActividad"] <> 1)) { ?>
																							<a onclick="activarActividad(<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>,<?php echo $IdParcial; ?>)" class="btn btn-primary" name="btnP-<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>" id="btnP-<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>"><i class="fa fa-fw fa-check-circle"></i> Publicar actividad</a>
																						<?php } ?>
																						<?php if ($actividades[$ac]["IdTipoActividad"] == 1) { ?>
																							<a onclick="vistaExamen(<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>)" href="javascript:void(0);" class="btn btn-primary"><i class="fa fa-fw fa-eye"></i> Vista evaluaci&oacute;n</a>
																							<a onclick="actEvaluacion(<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>)" href="javascript:void(0);"><button title="Modificar fecha de entrega" type="button" class="btn btn-warning"><i class="fa fa-users"></i> Seguimiento evaluaci&oacute;n</button></a>
																							<a onClick="window.open('doAddConfigExamen.php?idToks=<?php echo $_GET["idToks"]; ?>&tok=<?php echo time() . $actividades[$ac]["IdActividadesDocente"];  ?>&p=<?php echo $IdParcial;  ?>','_self')" href="javascript:void(0);" class="btn btn-primary"><i class="fa fa-fw fa-cog"></i> Configurar evaluaci&oacute;n</a>
																						<?php } ?>
																						<?php if ($actividades[$ac]["IdTipoActividad"] == 2) { ?>
																							<!-- <a onClick="window.open('viewForoId.php?idToks=<?php echo $_GET["idToks"]; ?>&Id=<?php echo time() . $actividades[$ac]["IdActividadesDocente"];  ?>','_self')" href="javascript:void(0);" class="btn btn-info"><i class="fa fa-fw fa-wechat"></i> Ingresar</a> -->
																						<?php } ?>
																						<?php if (($actividades[$ac]["IdTipoActividad"] == 2) || ($actividades[$ac]["IdTipoActividad"] == 3)) { ?>
																							<a onclick="mi_rubrica(<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>)" class="btn btn-warning"><i class="fa fa-fw fa-briefcase"></i> Rúbrica</a>
																						<?php } ?>
																						<a onclick="modificarActividad(<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>)" class="btn btn-success"><i class="fa fa-fw fa-refresh"></i> Actualizar</a>
																						<?php if ($actividades[$ac]["IdEstatus"] == 12) { ?>
																							<a onclick="del_actividad(<?php echo $actividades[$ac]["IdActividadesDocente"]; ?>,<?php echo $IdParcial; ?>,<?php echo $IdSemana; ?>)" class="btn btn-danger"><i class="fa fa-fw fa-trash"></i></a>
																						<?php } ?>
																					</p>
																				</div>
																			</div>
																		</li>
																	<?php }  ?>
															<?php } } ?>
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

		<div id="dataModal" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Creaci&oacute;n de contenido</h4>
					</div>
					<div class="modal-body" id="employee_detail">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalPor" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-black-tie"></i> Portafolio de evidencias</h4>
					</div>
					<div class="modal-body" id="employee_detailPor">
					</div>
				</div>
			</div>
		</div>

		<div id="data_contrato" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Firmar contrato de la materia </h4>
					</div>
					<div class="modal-body" id="employee_contrato">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalViewPc" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Datos de los parciales creados anteriormente</h4>
					</div>
					<div class="modal-body" id="employee_detailViewPc" style="background: #ecf0f5;">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalViewP" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Datos de la planeación</h4>
					</div>
					<div class="modal-body" id="employee_detailViewP">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalSemana" class="modal fade bs-example-modal-lg">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configuraci&oacute;n del trabajo del contenido</h4>
					</div>
					<div class="modal-body" id="employee_detailSem">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalObjetivo" class="modal fade bs-example-modal-lg">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Captura de objetivos de la materia</h4>
					</div>
					<div class="modal-body" id="employee_detailObj">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalActividad" class="modal fade bs-example-modal-lg">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Creaci&oacute;n de actividad</h4>
					</div>
					<div class="modal-body" id="employee_detailAct">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalenvioPlan" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Envio de planeaci&oacute;n</h4>
					</div>
					<div class="modal-body" id="employee_detailenvioPlan">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalModAct" class="modal fade bs-example-modal-lg">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Modificar actividad</h4>
					</div>
					<div class="modal-body" id="employee_detailModAct">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModal_rub" class="modal fade bs-example-modal-lg">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Mis rúbricas</h4>
					</div>
					<div class="modal-body" id="employee_detail_rub">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalViewEx" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Vista previa del examen</h4>
					</div>
					<div class="modal-body" id="employee_detailViewEx">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalModPar" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Modificar datos</h4>
					</div>
					<div class="modal-body" id="employee_detailModPar">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalModSem" class="modal fade bs-example-modal-lg">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Modificar datos del desglose del contenido</h4>
					</div>
					<div class="modal-body" id="employee_detailModSem">
					</div>
				</div>
			</div>
		</div>
		<div id="dataPre" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Presentación</h4>
					</div>
					<div class="modal-body" id="employee_pre">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalChat" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Notificaciones de la Planeaci&oacute;n</h4>
					</div>
					<div class="modal-body" id="employee_detailChat">

					</div>
				</div>
			</div>
		</div>

		<?php include("footer.php"); ?>

		<div id="dataEva" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar evaluación para los alumnos</h4>
					</div>
					<div class="modal-body" id="employee_eva">
					</div>
				</div>
			</div>
		</div>
		<div id="dataFondo" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-file-image-o"></i> Fondos disponibles</h4>
					</div>
					<div class="modal-body" id="employee_fondo">
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
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script>
		function noticarPlan() {
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			var IdPlaneacion = document.getElementById("IdPlaneacion").value;
			var Tipo = "A";
			$.ajax({
				url: "formConsulta/chatPlaneacion.php",
				method: "POST",
				data: {
					IdAsignacion: IdAsignacion,
					IdPlaneacion: IdPlaneacion,
					Tipo: Tipo
				},
				success: function(data) {
					$('#employee_detailChat').html(data);
					$('#dataModalChat').modal('show');
				}
			});
		}

		function crearParcial() {
			var IdOferta = document.getElementById("txtOferta").value;
			var IdModulo = document.getElementById("txtModulo").value;
			var IdPlaneacion = document.getElementById("IdPlaneacion").value;
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			$.ajax({
				url: "formConsulta/addParcial.php",
				method: "POST",
				data: {
					IdOferta: IdOferta,
					IdModulo: IdModulo,
					IdPlaneacion: IdPlaneacion,
					IdAsignacion: IdAsignacion
				},
				success: function(data) {
					$('#employee_detail').html(data);
					$('#dataModal').modal('show');
				}
			});

		}

		function portafolio() {
			// var IdOferta = document.getElementById("txtOferta").value;
			// var IdModulo = document.getElementById("txtModulo").value;
			// var IdPlaneacion = document.getElementById("IdPlaneacion").value;
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			$.ajax({
				url: "formConsulta/portafolio.php",
				method: "POST",
				data: {
					IdAsignacion: IdAsignacion
				},
				success: function(data) {
					$('#employee_detailPor').html(data);
					$('#dataModalPor').modal('show');
				}
			});

		}

		function viewParcial() {
			var IdOferta = document.getElementById("txtOferta").value;
			var IdModulo = document.getElementById("txtModulo").value;
			$.ajax({
				url: "formConsulta/viewParcial.php",
				method: "POST",
				data: {
					IdOferta: IdOferta,
					IdModulo: IdModulo
				},
				success: function(data) {
					$('#employee_detailViewPc').html(data);
					$('#dataModalViewPc').modal('show');
				}
			});
		}

		function viewPlaneacion(IdParcial) {
			var IdOferta = document.getElementById("txtOferta").value;
			var IdModulo = document.getElementById("txtModulo").value;
			$.ajax({
				url: "formConsulta/viewPlaneacion.php",
				method: "POST",
				data: {
					IdOferta: IdOferta,
					IdModulo: IdModulo,
					IdParcial: IdParcial
				},
				success: function(data) {
					$('#employee_detailViewP').html(data);
					$('#dataModalViewP').modal('show');
				}
			});
		}

		function crearSemana(IdParcial) {
			var IdOferta = document.getElementById("txtOferta").value;
			var IdModulo = document.getElementById("txtModulo").value;
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			$.ajax({
				url: "formConsulta/addSemana.php",
				method: "POST",
				data: {
					IdOferta: IdOferta,
					IdModulo: IdModulo,
					IdParcial: IdParcial,
					IdAsignacion: IdAsignacion
				},
				success: function(data) {
					$('#employee_detailSem').html(data);
					$('#dataModalSemana').modal('show');
				}
			});

		}

		function captura_objetivos(IdModulo) {
			$.ajax({
				url: "vistas/docente/captura_objetivos.php",
				method: "POST",
				data: {
					IdModulo: IdModulo
				},
				success: function(data) {
					$('#employee_detailObj').html(data);
					$('#dataModalObjetivo').modal('show');
				}
			});

		}

		function activarCurso(IdParcial) {
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
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
								url: "formConsulta/setting.php",
								method: "POST",
								data: {
									TipoGuardar: TipoGuardar,
									IdPlaneacion: IdPlaneacion,
									IdAsignacion: IdAsignacion,
									IdUsua: IdUsua
								},
								success: function(data) {
								}
							})
							.done(function(data) {

								if (data == 1) {
									swal("Guardado correctamente", "Curso activado correctamente.", "success");
									parent.location.href = 'doMiPlaneacion.php';
								}
								if (data == 0) {
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

		function del_actividad(IdActividadesDocente, IdParcial, IdSemana) {
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			var TipoGuardar = "del_actividad_id";
			swal({
					title: "\u00BFEst\u00E1 seguro que desea eliminar esta actividad?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Aceptar',
					cancelButtonText: "Cancelar",
				},
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
								url: "formConsulta/setting.php",
								method: "POST",
								data: {
									TipoGuardar: TipoGuardar,
									IdActividadesDocente: IdActividadesDocente,
									IdAsignacion: IdAsignacion,
									IdParcial: IdParcial,
									IdSemana: IdSemana
								},
								success: function(data) {

								}
							})
							.done(function(data) {
								if (data == 1) {
									swal("Eliminado correctamente", "La actividad se ha eliminado correctamente.", "success");
									parent.location.href = 'doMiPlaneacion.php?idToks=' + IdAsignacion + '&tok=' + IdParcial;
								}
								if (data == 0) {
									swal("Error al eliminar", "No se puede guardar, verifique sus datos.", "error");
								}
							})
							.error(function(data) {
								swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
							});
					}
				});
		}

		function crearActividad(IdParcial, IdSemana) {
			var IdOferta = document.getElementById("txtOferta").value;
			var IdModulo = document.getElementById("txtModulo").value;
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			$.ajax({
				url: "formConsulta/addActividad.php",
				method: "POST",
				data: {
					IdOferta: IdOferta,
					IdModulo: IdModulo,
					IdParcial: IdParcial,
					IdSemana: IdSemana,
					IdAsignacion: IdAsignacion
				},
				success: function(data) {
					$('#employee_detailAct').html(data);
					$('#dataModalActividad').modal('show');
				}
			});

		}

		function crearBiblio(IdParcial, IdSemana) {
			var IdOferta = document.getElementById("txtOferta").value;
			var IdModulo = document.getElementById("txtModulo").value;
			$.ajax({
				url: "formConsulta/addBibliografia.php",
				method: "POST",
				data: {
					IdOferta: IdOferta,
					IdModulo: IdModulo,
					IdParcial: IdParcial,
					IdSemana: IdSemana
				},
				success: function(data) {
					$('#employee_detailBiblio').html(data);
					$('#dataModalBiblio').modal('show');
				}
			});

		}


		function envioPlan(IdUsua) {
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			var IdPlaneacion = document.getElementById("IdPlaneacion").value;
			var Tipo = "A";
			$.ajax({
				url: "formConsulta/envioPlaneacion.php",
				method: "POST",
				data: {
					IdUsua: IdUsua,
					IdAsignacion: IdAsignacion,
					Tipo: Tipo,
					IdPlaneacion: IdPlaneacion
				},
				success: function(data) {
					$('#employee_detailenvioPlan').html(data);
					$('#dataModalenvioPlan').modal('show');
				}
			});
		}

		function modificarActividad(IdActividadDoc) {
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			$.ajax({
				url: "formConsulta/updActividad.php",
				method: "POST",
				data: {
					IdActividadDoc: IdActividadDoc,
					IdAsignacion: IdAsignacion
				},
				success: function(data) {
					$('#employee_detailModAct').html(data);
					$('#dataModalModAct').modal('show');
				}
			});

		}

		function mi_rubrica(IdActividadDoc) {
			var IdRubrica = 0;
			$.ajax({
				url: "vistas/docente/mis_rubricas.php",
				method: "POST",
				data: {
					IdActividadDoc: IdActividadDoc,
					IdRubrica: IdRubrica
				},
				success: function(data) {
					$('#employee_detail_rub').html(data);
					$('#dataModal_rub').modal('show');
				}
			});

		}

		function vistaExamen(IdActividadDoc) {
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			$.ajax({
				url: "formConsulta/viewExamen.php",
				method: "POST",
				data: {
					IdActividadDoc: IdActividadDoc,
					IdAsignacion: IdAsignacion
				},
				success: function(data) {
					$('#employee_detailViewEx').html(data);
					$('#dataModalViewEx').modal('show');
				}
			});

		}

		function configurarExamen(IdActividadDoc, IdParcialDoc) {
			$.ajax({
				url: "formConsulta/addExamen.php",
				method: "POST",
				data: {
					IdActividadDoc: IdActividadDoc,
					IdParcialDoc: IdParcialDoc
				},
				success: function(data) {
					$('#employee_detailExam').html(data);
					$('#dataModalExam').modal('show');
				}
			});

		}

		function modificarParcial(IdParcial) {
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			$.ajax({
				url: "formConsulta/updParcial.php",
				method: "POST",
				data: {
					IdParcial: IdParcial,
					IdAsignacion: IdAsignacion
				},
				success: function(data) {
					$('#employee_detailModPar').html(data);
					$('#dataModalModPar').modal('show');
				}
			});

		}

		function modificarSemana(IdSemana) {
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			$.ajax({
				url: "formConsulta/updSemana.php",
				method: "POST",
				data: {
					IdSemana: IdSemana,
					IdAsignacion: IdAsignacion
				},
				success: function(data) {
					$('#employee_detailModSem').html(data);
					$('#dataModalModSem').modal('show');
				}
			});

		}

		function crearPresentacion(IdSemana) {
			$.ajax({
				url: "formConsulta/addPresentacion.php",
				method: "POST",
				data: {
					IdSemana: IdSemana
				},
				success: function(data) {
					$('#employee_pre').html(data);
					$('#dataPre').modal('show');
				}
			});

		}

		function modificarFuente(IdFuente) {
			$.ajax({
				url: "formConsulta/updFuente.php",
				method: "POST",
				data: {
					IdFuente: IdFuente
				},
				success: function(data) {
					$('#employee_detailModFue').html(data);
					$('#dataModalModFue').modal('show');
				}
			});
		}

		$(document).ready(function() {
			var alerta = document.frm.Alerta.value;
			var variable = document.frm.Variable.value;
			if (alerta) {
				if (alerta == "GUARDAR") {
					swal("Guardado", variable + " GUARDADO CON ÉXITO", "success");
				}
				if (alerta == "ACTUALIZAR") {
					swal("Actualizado", variable + " actualizado con exito", "success");
				}
				if (alerta == "ELIMINAR") {
					swal("Eliminado", variable + " ELIMINADO CON ÉXITO", "success");
				}
				if (alerta == "ERROR") {
					swal("Error", variable + " FAVOR DE COMUNICARSE CON EL ADMINISTRADOR", "error");
				}
			}
		});
		$(function() {
			//bootstrap WYSIHTML5 - text editor
			$('.textarea').wysihtml5()
		})

		function actEvaluacion(IdActividadDoc) {
			$.ajax({
				url: "formConsulta/addActivarEva.php",
				method: "POST",
				data: {
					IdActividadDoc: IdActividadDoc
				},
				success: function(data) {
					$('#employee_eva').html(data);
					$('#dataEva').modal('show');
				}
			});

		}

		$(document).ready(function() {
			$(document).on('click', '.view_fondo', function() {
				var employee_id = $(this).attr("id");
				if (employee_id != '') {
					$.ajax({
						url: "formConsulta/viewFondos.php",
						method: "POST",
						data: {
							employee_id: employee_id
						},
						success: function(data) {
							$('#employee_fondo').html(data);
							$('#dataFondo').modal('show');
						}
					});
				}
			});
		});

		function firmar_contrato(IdAsignacion) {
				$.ajax({
					url: "formConsulta/firmar_contrato_id.php",
					method: "POST",
					data: {
						IdAsignacion: IdAsignacion
					},
					success: function(data) {
						$('#employee_contrato').html(data);
						$('#data_contrato').modal('show');
					}
				});
			}

	</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>