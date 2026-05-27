<?php $valor = 3;
$section = "Asesores";
include("head.php");



if (isset($_GET["token"])) {
	$id = substr($_GET["token"], 10, 10);
	$asesor = $t->get_datAsesor($id);
	$asignaturas = $t->get_datAsignaturas($id);
	$lstCiclo = $t->get_periodo_materias_activas($id);
	$misDocs = $espacio->get_mis_docs_doc($id);
	$misGrad = $espacio->get_mis_gradx_doc($id);
}
if ($_SESSION['IdUsua']) {
	if (isset($id)) {
		$addIngresos = $t->add_registros($_SESSION['IdUsua'], "Está en el buscador de docente", "Buscador docente", "Docente", '', $id, 0);
	}
}


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<script src="assets/grafica/highcharts.js"></script>
<script src="assets/grafica/data.js"></script>
<script src="assets/grafica/exporting.js"></script>

<!-- <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js" integrity="sha512-7U4rRB8aGAHGVad3u2jiC7GA5/1YhQcQjxKeaVms/bT66i3LVBMRcBI9KwABNWnxOSwulkuSXxZLGuyfvo7V1A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Perfil del asesor acad&eacute;mico
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Perfil</a></li>
					<li class="active">Asesore acad&eacute;mico</li>
				</ol>
			</section>

			<section class="content">
				<form name="frm" id="frm" action="asesor.php" method="POST" enctype="multipart/form-data">
					<input id="token" name="token" value="<?php if (isset($_GET['token'])) { echo $_GET['token']; } ?>" type="hidden" />

					<div class="row">

						<div class="col-md-3">
							<div class="box box-primary">
								<a href="javascript:void(0);" class="btn btn-info btn-block view_buscar"><b><i class="fa fa-fw fa-search"></i> B&uacute;squeda de asesor</b></a>
								<div class="box-body box-profile">
									<?php if (isset($_GET['token'])) { ?>
										<img style="width: 100px; height: 100px;" class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $asesor[0]["Foto"]; ?>" alt="User profile picture">
										<h3 class="profile-username text-center"><?php echo $asesor[0]["Nombre"]; ?></h3>
										<p class="text-muted text-center"><?php echo $asesor[0]["APaterno"] . ' ' . $asesor[0]["AMaterno"]; ?></p>
										
									<?php } else { ?>
										<img class="profile-user-img img-responsive img-circle" src="assets/perfil/nuevo.png" alt="User profile picture">
									<?php } ?>

									<?php if (isset($_GET['token'])) {
										$_mod58 = $t->get_mod_lista_id($_SESSION['IdUsua'], 58);
										$_mod74 = $t->get_mod_lista_id($_SESSION['IdUsua'], 74);
										$_mod88 = $t->get_mod_lista_id($_SESSION['IdUsua'], 88);
										$_mod89 = $t->get_mod_lista_id($_SESSION['IdUsua'], 89);
									?>
										<ul class="list-group list-group-unbordered">
											<li class="list-group-item">
												<b>Estatus</b> <a class="pull-right"><b><?php echo $asesor[0]["Estatus"]; ?></b></a>
											</li>
											<li class="list-group-item">
												<b><i class="fa fa-fw fa-envelope"></i></b> <a class="pull-right"><?php echo $asesor[0]["Correo"]; ?></a>
											</li>
											<li class="list-group-item">
												<b><i class="fa fa-fw fa-phone-square"></i></b> <a class="pull-right"><?php echo $asesor[0]["Telefono"]; ?></a>
											</li>
											<li class="list-group-item">
												<b><i class="fa fa-fw fa-user"></i></b> <a class="pull-right"><?php echo $asesor[0]["Usuario"]; ?></a>
											</li>
											<?php if (($_SESSION["Permisos"] == 1) || ($_SESSION["Permisos"] == 10) || ($_SESSION["Permisos"] == 5)) { ?>
											<li class="list-group-item">
												<b onclick="mostrarPass()" style="cursor: pointer;"><i class="fa fa-fw fa-eye"></i></b> <a class="pull-right">
													<div class="form-group" style="margin-top: -7px;">
														<input type="password" class="form-control" id="txtP1" value="               ">
														<input type="text" class="form-control" id="txtP2" value="<?php echo $asesor[0]['Code']; ?>" style="display: none; text-align: right;">
													</div>
												</a>
											</li>
											<li class="list-group-item">
												<a onclick="abrir_chat(<?php echo $_SESSION['IdUsua']; ?>,<?php echo $id; ?>)" class="btn btn-primary btn-block"><i class="fa fa-fw fa-twitch"></i> Seguimiento</a>
												<?php if (isset($_mod88[0])) { ?>
												<a onclick="captura_informacion(<?php echo $id; ?>)" class="btn btn-success btn-block"><i class="fa fa-fw fa-user"></i> Información </a>
												<?php } ?>
											</li>
											<?php } ?>
											<?php if (isset($_mod58[0])) { ?>
												<li class="list-group-item">
													<a title="Configurar baja de usuario" class="btn btn-danger btn-block view_data" name="view" value="view" id="<?php echo $id; ?>"><i class="fa fa-fw fa-warning"></i> Estatus del docente</a>
												</li><?php } ?>
										</ul>
										<div class="box-body">
											<strong><i class="fa fa-book margin-r-5"></i> GRADOS DE ESTUDIOS</strong>
											<p class="text-muted">
												<?php for ($gx = 0; $gx < sizeof($misGrad); $gx++) {
													echo "<i class='fa fa-fw fa-check'></i> " . $misGrad[$gx]['Nombre'] . '<br>';
												} ?>
											</p>
											<hr>
										</div>
									<?php } ?>
								</div>

							</div>

						</div>

						<!-- /.col -->
						<div class="col-md-9">
							<div id="content" class="col-lg-12">
							</div>
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#activity" data-toggle="tab"><i class="fa fa-fw fa-bell"></i> Materias activas</a></li>
									<li><a href="#timeline" data-toggle="tab"><i class="fa fa-fw fa-bell-slash"></i> Materias finalizadas</a></li>
									<!-- <li><a href="#encuesta" data-toggle="tab"><i class="fa fa-fw fa-line-chart"></i> Encuesta</a></li> -->

									<?php if (isset($_GET['token'])) { ?>
										<li><a onclick="cargar_docsxx(<?php echo $id; ?>)" href="#documentos" data-toggle="tab"><i class="fa fa-fw fa-folder-open"></i> Documentos</a></li>
										<li><a onclick="cargar_recono(<?php echo $_SESSION['IdUsua']; ?>,<?php echo $id; ?>)" href="#reconocimient" data-toggle="tab"><i class="fa fa-fw fa-trophy"></i> Reconocimientos</a></li>
									<?php } ?>
								</ul>
								<div class="tab-content">
									<div class="active tab-pane" id="activity">
										<div class="box-body table-responsive no-padding">

											<?php if (isset($_GET['token'])) { ?>
												<table class="table table-striped">
													<tbody>
														<?php $ini = 0;
														$grado = 1;
														$valor = 0;
														$dispo = 0;
														for ($i = 0; $i < sizeof($asignaturas); $i++) {
															if ($asignaturas[$i]["IdEstatus"] <> 26) {
																$dispo = 1;

																if ($grado == $asignaturas[$i]["IdEducativa"]) {
																	$ini = 1;
																} else {
																	$ini = 0;
																} ?>
																<?php if (($ini == 0) || ($valor == 0)) { ?>
																	<tr style="background: #aeaaaa; color: #000; font-size: 12px; ">
																		<th colspan="6"><?php echo $asignaturas[$i]["Oferta"] . ' - ' . $asignaturas[$i]["Nombre"] ?></th>
																	</tr>
																	<tr style="background: #e1dede; color: #000; font-size: 12px;">
																		<!-- <th>Acceso</th> -->
																		<th>Asignatura</th>
																		<th>Fecha</th>
																		<th>Estatus</th>
																		<th>Periodo escolar</th>
																		<th>CveGrupo</th>
																	</tr> <?php } ?>
																<tr style="font-size: 12px;">
																
																	<!-- <td> -->
																	<!-- <button type="button" class="btn btn-block btn-success btn-xs view_foro" id="<?php echo $asignaturas[$i]["IdAsignacion"]; ?>" href="javascript:void(0);" title="Ingresar a los foros"> <i class="fa fa-fw fa-wechat"></i> Foro</button> -->
																	<!-- <button type="button" class="btn btn-primary btn-xs view_enc_doc" id="<?php echo $asignaturas[$i]["IdAsignacion"]; ?>" href="javascript:void(0);" title="Ingresar a la encesta"> <i class="fa fa-fw fa-line-chart"></i></button> -->

																	<!-- </td> -->
																	<td>
																	<?php if (isset($_mod89[0])) { ?>
																<button onclick="configurar_contrato('<?php echo $asignaturas[$i]["IdAsignacion"]; ?>')" type="button" class="btn btn-info btn-xs" href="javascript:void(0);" title="Configurar contrato"> <i class="fa fa-fw fa-check-circle"></i> Contrato</button>
																<?php } ?>	
																	<?php echo $asignaturas[$i]["CodeModulo"] . ' ' . $asignaturas[$i]["NombreMod"]; ?></td>
																	<td><?php echo $asignaturas[$i]["FecIni"] . ' - ' . $asignaturas[$i]["FecFin"]; ?></td>
																	<td><?php echo $asignaturas[$i]["Estatus"]; ?></td>
																	<td><?php echo $asignaturas[$i]["Ciclo"]; ?></td>
																	<td><?php echo $asignaturas[$i]["CveGrupo"]; ?></td>
																</tr>
														<?php $valor = 1;
																$grado = $asignaturas[$i]["IdEducativa"];
															}
														} ?>
														<?php if ($dispo == 0) { ?>
															<tr style="background: #292b33; color: #fff; ">
																<th colspan="6" style=" text-align: center;"><br><br>
																	<img class="profile-user-img img-responsive img-circle" src="assets/perfil/nuevo.png" alt="User profile picture"><br>
																	Este asesor acad&eacute;mico no tienen ninguna asignatura activa.<br><br><br>
																</th>
															</tr>
														<?php } ?>
													</tbody>
												</table><?php } ?>
										</div>


									</div>
									<!-- /.tab-pane -->
									<div class="tab-pane" id="timeline">


										<div class="box-body table-responsive no-padding">


											<table class="table table-striped">
												<tbody>
													<?php $dispoIna = 0;
													$ini = 0;
													$grado = 1;
													$valor = 0;
													if (isset($asignaturas[0])) {
														for ($i = 0; $i < sizeof($asignaturas); $i++) {
															$prmx = 0;
															if ($asignaturas[$i]["IdEstatus"] == 26) {
																$dispoIna = 1;

																if ($grado == $asignaturas[$i]["IdEducativa"]) {
																	$ini = 1;
																} else {
																	$ini = 0;
																} ?>
																<?php if (($ini == 0) || ($valor == 0)) { ?>
																	<tr style="background: #aeaaaa; color: #000; font-size: 12px; ">
																		<th colspan="8"><?php echo $asignaturas[$i]["Oferta"] . ' - ' . $asignaturas[$i]["Nombre"] ?></th>
																	</tr>
																	<tr style="background: #e1dede; color: #000; font-size: 12px;">
																		<th>Acceso</th>
																		<th>Asignatura</th>
																		<th>Fecha</th>
																		<th>Periodo escolar</th>
																		<th style="text-align: center;">Total</th>
																		<th style="text-align: center;">Alumnos</th>
																		<th style="text-align: center;">Promedio</th>
																	</tr> <?php } ?>
																<tr style="font-size: 12px;">
																	<td>
																	<?php if (isset($_mod89[0])) { ?>
																	<button onclick="configurar_contrato('<?php echo $asignaturas[$i]["IdAsignacion"]; ?>')" type="button" class="btn btn-info btn-xs" href="javascript:void(0);" title="Configurar contrato"> <i class="fa fa-fw fa-check-circle"></i> Contrato</button>
																	<?php } ?>
																		<?php if ((isset($_mod74[0])) && (isset($asignaturas[$i]["Fecha_impresion"]))) { ?>
																			<button onclick="reg_materia_edicion('<?php echo $asignaturas[$i]["IdAsignacion"]; ?>',<?php echo $id; ?>,<?php echo $_SESSION['IdUsua']; ?>,1)" type="button" class="btn btn-danger btn-xs" href="javascript:void(0);" title="Regresar acta de calificación"> <i class="fa fa-fw fa-reply-all"></i></button>
																		<?php } ?>

																	</td>
																	<td style="cursor: pointer; color: blue;" onclick="reg_materia_edicion('<?php echo $asignaturas[$i]["IdAsignacion"]; ?>',<?php echo $id; ?>,<?php echo $_SESSION['IdUsua']; ?>,0)"><?php echo $asignaturas[$i]["CodeModulo"] . ' ' . $asignaturas[$i]["NombreMod"]; ?></td>
																	<td><?php echo $asignaturas[$i]["FecIni"] . ' - ' . $asignaturas[$i]["FecFin"]; ?></td>
																	<td><?php echo $asignaturas[$i]["Ciclo"]; ?><br><?php echo $asignaturas[$i]["CveGrupo"]; ?></td>
																	<td <?php if(isset($asignaturas[$i]["_alum"])) { ?> style="text-align: center; cursor: pointer;" onclick="mostrar_alumnos('<?php echo $asignaturas[$i]["IdAsignacion"]; ?>')" <?php } else { echo "style='text-align: center; cursor: wait;'"; }  ?> ><?php if(isset($asignaturas[$i]["_alum"])) { $prmx = (($asignaturas[$i]["pro_alum"] + $asignaturas[$i]["pro_coo"]) / 2); echo $asignaturas[$i]["_alum"]; } else { echo " - "; } ?></td>
																	<td <?php if(isset($asignaturas[$i]["_alum"])) { ?> style="text-align: center; cursor: pointer;" onclick="mostrar_resultado('<?php echo $asignaturas[$i]["IdAsignacion"]; ?>')" <?php } else { echo "style='text-align: center; cursor: wait;'"; }  ?> ><?php if(isset($asignaturas[$i]["_alum"])) { echo $asignaturas[$i]["pro_alum"]; } else { echo " - "; } ?></td>
																	<td <?php if(isset($asignaturas[$i]["_alum"])) { ?>  style="text-align: center; cursor: pointer;" onclick="mostrar_concentrado('<?php echo $asignaturas[$i]["IdAsignacion"]; ?>')" <?php } else { echo "style='text-align: center; cursor: wait;'"; } ?>  ><b><?php if(isset($asignaturas[$i]["_promedio"])) { echo $asignaturas[$i]["_promedio"].'%'; } else { echo " - "; } ?></b></td>
																</tr>
													<?php $valor = 1;
																$grado = $asignaturas[$i]["IdEducativa"];
															}
														}
													} ?>

													<?php if ($dispoIna == 0) { ?>
														<tr style="background: #292b33; color: #fff; ">
															<th colspan="6" style=" text-align: center;"><br><br>
																<img class="profile-user-img img-responsive img-circle" src="assets/images/oferta/us.png" alt="User profile picture"><br>
																Este asesor acad&eacute;mico no tienen ninguna asignatura finalizada.<br><br><br>
															</th>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>

									</div>
									<div class="tab-pane" id="encuesta">


									<table class="table table-striped">
												<tbody>

													<tr style="background: #aeaaaa; color: #000; font-size: 12px; ">
														<th colspan="6">Lista de evaluación docente</th>
													</tr>
													<tr style="background: #e1dede; color: #000; font-size: 12px;">
														<th>Periodo escolar</th>
														<th>Ajuste</th>
													</tr>
													<?php if (isset($lstCiclo)) {
														for ($i = 0; $i < sizeof($lstCiclo); $i++) { ?>
															<tr style="font-size: 12px;">
																<td><?php echo $lstCiclo[$i]["Ciclo"]; ?></td>
																<td>
																	<!-- <a onclick="javascript:window.open('formConsulta/impEvaluacionDocente.php?idD=<?php echo time() . $id; ?>&idC=<?php echo time() . $lstCiclo[$i]["IdCiclo"]; ?>','_blank');" href="javascript:void(0);" title="Descargar mapa de registro">
															<button type="button" class="btn btn-danger btn-xs"> <i class="fa fa-fw fa-print"></i> Imprimir todos</button>
														</a> -->
																	<button type="button" class="btn btn-info btn-xs" onclick="con_encuesta(<?php echo $id; ?>,<?php echo $lstCiclo[$i]["IdCiclo"]; ?>)"><i class="fa fa-fw fa-search"></i> Consultar</button>
																</td>
															</tr>
													<?php }
													} ?>
												</tbody>
											</table>
											<p style="text-align: center; display: none;" id="img_cargar">
												<img src="assets/images/cargando.gif">
											</p>
											<div class="box-body" id="mostrar_encuesta" style="display: none;"></div>
									</div>

									<div class="tab-pane" id="documentos">
										<div id="list_docs_d"></div>
									</div>

									<div class="tab-pane" id="reconocimient">
										<div id="list_reconocimit"></div>
									</div>
								</div>
								<!-- /.tab-content -->
							</div>
							<!-- /.nav-tabs-custom -->
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</form>
			</section>
		</div>
		<div id="dataModal4" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-search"></i> Buscador de asesor acad&eacute;mico</h4>
					</div>
					<div class="modal-body" id="employee_detail4">

					</div>
				</div>
			</div>
		</div>

		<div id="dataDia" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Días disponible para el asesor</h4>
					</div>
					<div class="modal-body" id="employee_Dia">

					</div>
				</div>
			</div>
		</div>
		<div id="dataForo" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-wechat"></i> Foros de la asignatura</h4>
					</div>
					<div class="modal-body" id="employee_Foro">

					</div>
				</div>
			</div>
		</div>

		<div id="dataEnc" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-line-chart"></i> Resultado de la encuesta docente</h4>
					</div>
					<div class="modal-body" id="employee_Enc">
					</div>
				</div>
			</div>
		</div>

		<div id="dataEncRecx" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-trophy"></i> <b id="_prex"></b></h4>
					</div>
					<div class="modal-body" id="employee_EncRecx">
					</div>
				</div>
			</div>
		</div>

		<div id="dataEncRec" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-trophy"></i> Reconocimiento de la materia</h4>
					</div>
					<div class="modal-body" id="employee_EncRec">
					</div>
				</div>
			</div>
		</div>
		<div id="dataEncRecy" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-trophy"></i> Subir reconocimiento al asesor</h4>
					</div>
					<div class="modal-body" id="employee_EncRecy">
					</div>
				</div>
			</div>
		</div>

		<div id="dataDocsx" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-file"></i> <b id="_pre"></b></h4>
					</div>
					<div class="modal-body" id="employee_docsx">
					</div>
				</div>
			</div>
		</div>

		<div id="dataGrp" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-gears"></i> Configuración de baja de usuario</h4>
					</div>
					<div class="modal-body" id="employee_Grp">
						<div class="form-group" name="imgLoadPagos" id="imgLoadPagos" style="display: none; text-align: center; margin: 0 auto;">
							<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="dataInfo" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-gears"></i> Información del docente</h4>
					</div>
					<div class="modal-body" id="employee_info">
					</div>
				</div>
			</div>
		</div>

		<div id="data_acta" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-gears"></i> Regresar acta de calificación</h4>
					</div>
					<div class="modal-body" id="employee_acta">
					</div>
				</div>
			</div>
		</div>
		<div id="data_evaluacion" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-gears"></i> Detalle de la evaluación</h4>
					</div>
					<div class="modal-body" id="employee_eva">
					</div>
				</div>
			</div>
		</div>

		<div id="data_concentrado" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-flag"></i> Resultado de la evaluación docente</h4>
					</div>
					<div class="modal-body" id="employee_con">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalC" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-tags"></i> Seguimiento de alumno</h4>
					</div>
					<div class="modal-body" id="employee_detailC">
					</div>
				</div>
			</div>
		</div>

		<div id="data_contrato" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Configurar contrato de la materia</h4>
					</div>
					<div class="modal-body" id="employee_contrato">
					</div>
				</div>
			</div>
		</div>

		<?php include("footer.php"); ?>
	</div>
</body>
<!-- jQuery 3 -->
<script>
	$(document).ready(function() {
		var token = document.getElementById("token").value;
		if (token == '') {
			$.ajax({
				url: "formConsulta/buscarAsesor.php",
				method: "POST",
				data: {},
				success: function(data) {
					$('#employee_detail4').html(data);
					$('#dataModal4').modal('show');
				}
			});
		}

	})

	$(document).ready(function() {
		$(document).on('click', '.view_buscar', function() {

			$.ajax({
				url: "formConsulta/buscarAsesor.php",
				method: "POST",
				data: {},
				success: function(data) {
					$('#employee_detail4').html(data);
					$('#dataModal4').modal('show');
				}
			});
		});
	});

	function cargarDias() {
		var token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/asesorDias.php",
			method: "POST",
			data: {
				token: token
			},
			success: function(data) {
				$('#employee_Dia').html(data);
				$('#dataDia').modal('show');
			}
		});
	}

	$(document).ready(function() {
		$(document).on('click', '.view_foro', function() {
			var IdAsignacion = $(this).attr("id");
			var IdActividad = 0;
			$.ajax({
				url: "formConsulta/viewForo.php",
				method: "POST",
				data: {
					IdAsignacion: IdAsignacion,
					IdActividad: IdActividad
				},
				success: function(data) {
					$('#employee_Foro').html(data);
					$('#dataForo').modal('show');
				}
			});
		});
	});

	$(document).ready(function() {
		$(document).on('click', '.view_enc_doc', function() {
			var IdAsignacion = $(this).attr("id");
			var IdDocente = document.getElementById("token").value;
			$.ajax({
				url: "formConsulta/resultado_encuesta_docente.php",
				method: "POST",
				data: {
					IdAsignacion: IdAsignacion,
					IdDocente: IdDocente
				},
				success: function(data) {
					$('#employee_Enc').html(data);
					$('#dataEnc').modal('show');
				}
			});
		});
	});

	$(document).ready(function() {
		$(document).on('click', '.view_reconocimiento', function() {
			var IdAsignacion = $(this).attr("id");
			var IdDocente = document.getElementById("token").value;
			$.ajax({
				url: "formConsulta/reconocimiento_asesor.php",
				method: "POST",
				data: {
					IdAsignacion: IdAsignacion,
					IdDocente: IdDocente
				},
				success: function(data) {
					$('#employee_EncRec').html(data);
					$('#dataEncRec').modal('show');
				}
			});
		});
	});

	function vistaPago(IdPago) {
		$.ajax({
			url: "formConsulta/viewPagos.php",
			method: "POST",
			data: {
				IdPago: IdPago
			},
			success: function(data) {
				$('#employee_detail3').html(data);
				$('#dataModal3').modal('show');
			}
		});
	}

	function mostrarPass() {
		document.getElementById('txtP1').style.display = 'none';
		document.getElementById('txtP2').style.display = 'block';
	}

	function con_encuesta(IdUsua, IdCiclo) {

		document.getElementById("img_cargar").style.display = 'block';
		document.getElementById("mostrar_encuesta").style.display = 'none';
		var Capa = "#mostrar_encuesta";
		$(Capa).load("formConsulta/resultado_encuesta.php", {
			IdUsua: IdUsua,
			IdCiclo: IdCiclo
		}, function(response, status, xhr) {

			if (status == "error") {
				var msg = "Error!, algo ha sucedido: ";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
			if (status == "success") {

				document.getElementById("mostrar_encuesta").style.display = 'block';
				document.getElementById("img_cargar").style.display = 'none';
			}
		});
	}

	function cargar_recono(IdUsua, IdDocente) {
		var Capa = "#list_reconocimit";
		$(Capa).load("dashboard/rep_reconocimiento_docente.php", {
			IdUsua: IdUsua,
			IdDocente: IdDocente
		}, function(response, status, xhr) {
			if (status == "error") {
				alert(status);
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
	}

	function cargar_docsxx(IdDocente) {
		var Capa = "#list_docs_d";
		$(Capa).load("dashboard/rep_documentos_docente.php", {
			IdDocente: IdDocente
		}, function(response, status, xhr) {
			if (status == "error") {
				alert(status);
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
	}

	function ver_reconx(IdReconocimiento) {
		$.ajax({
			url: "formConsulta/ver_reconocimiento_asesor.php",
			method: "POST",
			data: {
				IdReconocimiento: IdReconocimiento
			},
			success: function(data) {
				$('#employee_EncRecx').html(data);
				$('#dataEncRecx').modal('show');
			}
		});
	}

	function del_reconx(IdReconocimiento, IdUsua, IdDocente) {
		var TipoGuardar = "del_reconocimiento";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este reconocimiento?",
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
								IdReconocimiento: IdReconocimiento
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								swal("Eliminado correctamente", "El reconocimiento del docente se ha eliminado correctamente.", "success");
								cargar_recono(IdUsua, IdDocente);
							}

							if (data == 0) {
								swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
							}
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
						});

				}

			});
	}

	function subir_reconox_upload(IdUsua, IdDocente) {
		$.ajax({
			url: "formConsulta/subir_reconocimiento_asesor.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				IdDocente: IdDocente
			},
			success: function(data) {
				$('#employee_EncRecy').html(data);
				$('#dataEncRecy').modal('show');
			}
		});
	}

	function mod_estatusx(IdDocs, IdDocente, Valor) {
		var TipoGuardar = "chang_estatus";
		swal({
				title: "\u00BFEst\u00E1 seguro que guardar este estatus?",
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
								IdDocs: IdDocs,
								IdDocente: IdDocente,
								Valor: Valor
							},
							success: function(data) {
								// alert(data);
							}
						})
						.done(function(data) {
							if (data == 1) {
								swal("Ejecutado correctamente", "El proceso de ha ejecutado correctamente.", "success");
								cargar_docsxx(IdDocente);
							}

						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
						});

				}

			});
	}

	function ver_docs_docente(IdDocs) {
		$.ajax({
			url: "dashboard/ver_documento_asesor.php",
			method: "POST",
			data: {
				IdDocs: IdDocs
			},
			success: function(data) {
				$('#employee_docsx').html(data);
				$('#dataDocsx').modal('show');
			}
		});
	}


	function abrir_chat(IdUsua, IdDocente) {
		$.ajax({
			url: "formConsulta/chat_seguimiento_docente.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				IdDocente: IdDocente
			},
			success: function(data) {
				$('#employee_detailC').html(data);
				$('#dataModalC').modal('show');
			}
		});
	}

	$(document).ready(function() {
		$(document).on('click', '.view_data', function() {
			var IdUsua = $(this).attr("id");

			var IdTipo = 2;
			if (IdUsua != '') {
				$.ajax({
					url: "formConsulta/bajasDocente.php",
					method: "POST",
					data: {
						IdUsua: IdUsua,
						IdTipo: IdTipo
					},
					success: function(data) {
						$('#employee_Grp').html(data);
						$('#dataGrp').modal('show');
					}
				});
			}
		});
	});


	function reg_materia_edicion(IdAsignacion, IdUsua, IdAdmin, Tipo){
		$.ajax({
			url: "vistas/admin/regresar_acta_docente.php",
			method: "POST",
			data: {
				IdAsignacion: IdAsignacion,
				IdUsua: IdUsua,
				IdAdmin: IdAdmin,
				Tipo:Tipo
			},
			success: function(data) {
				$('#employee_acta').html(data);
				$('#data_acta').modal('show');
			}
		});
	}

	function mostrar_resultado(IdAsignacion){
		$.ajax({
			url: "vistas/admin/detalle_evaluacion.php",
			method: "POST",
			data: {
				IdAsignacion: IdAsignacion
			},
			success: function(data) {
				$('#employee_eva').html(data);
				$('#data_evaluacion').modal('show');
			}
		});
	}

	function mostrar_concentrado(IdAsignacion){
		$.ajax({
			url: "vistas/admin/evaluacion_concentrado.php",
			method: "POST",
			data: {
				IdAsignacion: IdAsignacion
			},
			success: function(data) {
				$('#employee_con').html(data);
				$('#data_concentrado').modal('show');
			}
		});
	}


	function mostrar_alumnos(IdAsignacion){
		$.ajax({
			url: "vistas/admin/detalle_alumnos.php",
			method: "POST",
			data: {
				IdAsignacion: IdAsignacion
			},
			success: function(data) {
				$('#employee_eva').html(data);
				$('#data_evaluacion').modal('show');
			}
		});
	}

	function reg_materia_edicion_id(IdAsignacion, IdUsua, IdAdmin) {
		var Motivo = document.getElementById("txt_motivo_reg").value;
		
		var TipoGuardar = "regresar_edicion_acta";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea regresar a edición esta acta de calificacion final de esta materia?",
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
							url: "vistas/docente/procesar_datos_docente.php",
							method: "POST",
							data: {
								TipoGuardar: TipoGuardar,
								IdAsignacion: IdAsignacion,
								IdAdmin: IdAdmin,
								Motivo:Motivo
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								swal("Regresado correctamente", "El acta de calificacion se ha regresado a edición correctamente.", "success");
								parent.location.href = 'asesor.php?token=9845723478' + IdUsua;
							}

							if (data == 0) {
								swal("Error al guardar", "No se puede regresar, verifique sus datos.", "error");
							}
						})
						.error(function(data) {
							swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
						});

				}

			});
	}

	function captura_informacion(IdUsua){
		$.ajax({
					url: "formConsulta/informacionDocente.php",
					method: "POST",
					data: {
						IdUsua: IdUsua
					},
					success: function(data) {
						$('#employee_info').html(data);
						$('#dataInfo').modal('show');
					}
				});
	}

	function configurar_contrato(IdAsignacion) {
		$.ajax({
			url: "formConsulta/generar_contrato.php",
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


	function generera_contrato_id(IdAsignacion){
  var Monto = document.getElementById("txt_monto_contrato").value;
  var Texto = document.getElementById("txt_texto_contrato").value;
  var IdEstatus = document.getElementById("txt_estatus_contrato").value;
  var Fecha = document.getElementById("txt_fecha_contrato").value;
	

  if (Monto==""){
		swal("Error al guardar", "Debe poner el monto.", "error");
        document.getElementById("txt_monto_contrato").focus();
        return 0;
  }
  if (Texto==""){
		swal("Error al guardar", "Debe escribir el texto.", "error");
        document.getElementById("txt_paternox").focus();
        return 0;
  }

    var TipoGuardar = "generar_contrato_id";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea generar el contrato con estos datatos?",
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
             data:{TipoGuardar:TipoGuardar, IdAsignacion:IdAsignacion, Monto:Monto, Texto:Texto, IdEstatus:IdEstatus, Fecha:Fecha},
             success:function(data){

               

             }
        })
		.done(function(data) {
			if (data == 1) {
				swal("Generado correctamente", "El contrato se ha generado correctamente.", "success");
				$.ajax({
					url: "formConsulta/generar_contrato.php",
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

			if (data == 0) {
				swal("Error al generar", "No se puede generar el contrato, verifique sus datos.", "error");
			}
		})
		.error(function(data) {
			swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
		});

      }
    });

}

</script>



<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClic
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>

</html>