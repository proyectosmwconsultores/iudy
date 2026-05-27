<?php $section = "Verificar Documentos";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está verificando los documentos de los docentes');
}
$IdUsua = substr($_GET['IdUsua'], 10, 10);
if (isset($_POST['txtTipo'])) {
	$_POST['txtTipo'] = $_POST['txtTipo'];
} else {
	$_POST['txtTipo'] = '';
}

$datosUser = $t->get_datoDocente($IdUsua);
$misPagos = $espacio->get_misPagos($IdUsua);
if (($datosUser[0]['_tipo'] == 13) || ($datosUser[0]['_tipo'] == 14) || ($datosUser[0]['_tipo'] == 15)) {
	if ($datosUser[0]['_tipo'] == 13) {
		$grad = 7;
	} else {
		$grad = 8;
	}
} else {
	$grad = $datosUser[0]["Grado"];
}
$grad = $datosUser[0]["Grado"];;

$docs = $t->get_docsSubir($grad);
$lstdocs = $t->get_lstdocsSubir($IdUsua);
$documentos = $espacio->get_lstDocTramite($IdUsua);
$docs_tram = $espacio->get_lst_docs_tra($IdUsua);
$servicio = $espacio->get_serivcio_id($IdUsua);
if (isset($_POST["Mov"]) && $_POST["Mov"] == "upl_docsAlumno") {
	$t->upl_docsAlumno();
	exit;
}


if ($datosUser[0]['Grado'] == 3) {
	$nombre_file = "ficha_inscripcion";
} else {
	$nombre_file = "ficha_inscripcion";
}
$_mod86 = $t->get_mod_lista_id($_SESSION['IdUsua'], 86);

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Documentos del alumno</h1>
				<ol class="breadcrumb">
					<li><a href=""><i class="fa fa-book"></i> Documentos</a></li>
					<li class="active">Verificación de documentos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="docVerificar.php" method="POST" enctype="multipart/form-data">
						<input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden" />
						<input id="IdGrupo" name="IdGrupo" value="<?php echo $datosUser[0]["IdGrupo"]; ?>" type="hidden" />
						<input id="Mov" name="Mov" value="" type="hidden" />
						<input id="IdDocente" name="IdDocente" value="<?php echo $IdUsua; ?>" type="hidden" />
						<input id="Tipo" name="Tipo" value="3" type="hidden" />
						<input id="Tramite" name="Tramite" value="SS" type="hidden" />
						<div class="col-md-3">
							<div class="box box-primary">
								<div class="box-body box-profile">
									<?php if (isset($datosUser[0]["Foto"])) { ?>
										<img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $datosUser[0]["Foto"]; ?>" alt="User profile picture" style="width:100px; height: 100px;">
									<?php } else { ?>
										<img class="profile-user-img img-responsive img-circle" src="assets/perfil/nuevo.png" alt="User profile picture" style="width:100px; height: 100px;">
									<?php } ?>
									<h3 class="profile-username text-center"><?php echo $datosUser[0]["Nombre"]; ?></h3>
									<p class="text-muted text-center"><?php echo $datosUser[0]["APaterno"] . ' ' . $datosUser[0]["AMaterno"]; ?></p>
									<ul class="list-group list-group-unbordered">
										<li class="list-group-item">
											<b> <?php echo $datosUser[0]["Correo"]; ?> </b>
										</li>
										<li class="list-group-item">
											<b> <?php echo $datosUser[0]["Telefono"]; ?></b>
										</li>
										<?php if (isset($datosUser[0]["IdGrupo"])) { ?>
											<a style='text-align: left;' onclick="javascript:window.open('perfil.php?token=<?php echo time() . $IdUsua; ?>', '_self');" href="javascript:void(0);" title="Regresar" class="btn btn-default btn-block"><i class="fa fa-fw fa-mail-reply-all"></i> Regresar</a>
										<?php } else { ?>
											<a style='text-align: left;' onclick="javascript:window.open('addAddSeguimiento.php?idO=<?php echo $datosUser[0]['IdOferta']; ?>', '_self');" href="javascript:void(0);" title="Regresar" class="btn btn-default btn-block"><i class="fa fa-fw fa-mail-reply-all"></i> Regresar</a>
										<?php } ?><br>
										<a style='text-align: left;' onclick="notificar_user(<?php echo $IdUsua; ?>,<?php echo $_SESSION['IdUsua']; ?>)" href="javascript:void(0);" title="Notificar al usuario" class="btn btn-primary btn-block"><i class="fa fa-fw fa-send"></i> Notificar</a>
										<a style='text-align: left;' onclick="configurarDocs(<?php echo $IdUsua; ?>)" href="javascript:void(0);" title="Configurar documentación" class="btn btn-danger btn-block"><i class="fa fa-fw fa-cog"></i> Configurar documentación</a>
										<a style='text-align: left;' onclick="expediente_fisico(<?php echo $IdUsua; ?>)" href="javascript:void(0);" title="Configurar documentación" class="btn btn-info btn-block"><i class="fa fa-fw fa-building"></i> Expediente </a>
										<a style='text-align: left;' onclick="window.open('adCaptura.php?idToks=<?php echo time() . $IdUsua; ?>&Ub=Py','_self')" href="javascript:void(0);" title="Editar perfil" class="btn btn-warning btn-block"><i class="fa fa-fw fa-edit"></i> Editar perfil</a>
										<a style='text-align: left;' onclick="subir_foto_perfil(<?php echo $IdUsua; ?>)" href="javascript:void(0);" title="Foto tamaño infantil" class="btn btn-success btn-block"><i class="fa fa-fw fa-user"></i> Foto tamaño infantil</a>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xs-9">
							<div class="box">
								<div class="bg-maroon-active color-palette" style="padding: 10px;"><span>Documentos de alumnos</span></div>
								<div class="box-body">
									<div class="col-md-4">
										<div class="form-group">
											<label>Tipo documento:</label>
											<div class="input-group">
												<div class="input-group-addon"><i class="fa fa-book"></i></div>
												<select class="form-control" name="txtTipo" id="txtTipo">
													<option value=""> - Seleccione - </option>
													<?php for ($i = 0; $i < sizeof($docs); $i++) { ?>
														<option value="<?php echo $docs[$i]["IdTipoDoc"]; ?>" <?php if ($_POST["txtTipo"] == $docs[$i]["IdTipoDoc"]) {  ?>selected="selected" <?php } ?>><?php echo $docs[$i]["Nombre"]; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-8">
										<div class="form-group">
											<label>Buscar archivo:</label>
											<div class="input-group">
												<div class="input-group-addon"><i class="fa fa-book"></i></div>
												<input type="file" name="txtArchivo" id="txtArchivo" class="form-control">
												<span class="input-group-btn">
													<button onclick="val_sbisDocs()" type="button" class="btn btn-info btn-flat">Guardar</button>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12" name="imgLoadDoAlum" id="imgLoadDoAlum" style="display: none;">
									<div class="box-primary">
										<div class="box-body">
											<div class="box-footer" style=" text-align: center;">
												<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
											</div>
										</div>
									</div>
								</div>

								<div class="box-header">
									<h3 class="box-title">Lista de documentos en subidos</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
										<thead>
											<tr>
												<th style="width: 40px;">OPCIONES</th>
												<th>TIPO DOCUMENTO</th>
												<th>FEC.CAP</th>
												<th>ESTATUS</th>
												<th>AJUSTE</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i = 0; $i < sizeof($lstdocs); $i++) {
												$IdE = $lstdocs[$i]["Estatus"];
												if ($IdE == 4) {
													$_est = 'APROBADO';
												}
												if ($IdE == 2) {
													$_est = 'ENVIADO';
												}
												if ($IdE == 5) {
													$_est = 'NO APROBADO';
												}
											?>
												<tr id="<?php echo $lstdocs[$i]["IdDocAlumno"]; ?>">
													<td>
														<?php if (isset($_mod86[0])) { ?>
															<a class="btn btn-primary pull-right btn-sm" onclick="delDocs(<?php echo $lstdocs[$i]["IdDocAlumno"]; ?>)" href="javascript:void(0);"> <i class="fa fa-trash"></i> </a>
														<?php } ?>
														<a class="btn btn-warning pull-right btn-sm" onClick="window.open('assets/docs/files/<?php echo $lstdocs[$i]["Anio"]; ?>/<?php echo $lstdocs[$i]["Mes"]; ?>/<?php echo $lstdocs[$i]["Archivo"]; ?>','_blank')" href="javascript:void(0);" style="margin-right: 5px;"> <i class="fa fa-eye"></i> </a>
													</td>
													<td><?php echo $lstdocs[$i]["Nombre"]; ?></td>
													<td><?php echo $lstdocs[$i]["FecCap"]; ?></td>
													<td><?php echo $_est; ?></td>
													<td>
														<?php if ($lstdocs[$i]["Estatus"] == 4) { ?>
															<a title="Documento no aprobado" class="btn btn-success pull-right btn-sm"> <i class="fa fa-check-circle"></i> </a>
														<?php } else { ?>
															<a title="Aprobar documento" class="btn btn-success pull-right btn-sm" onclick="apro_docs(<?php echo $lstdocs[$i]["IdDocAlumno"]; ?>,4)" href="javascript:void(0);"> <i class="fa fa-check-circle"></i> </a>
															<a title="Documento no aprobado" class="btn btn-danger pull-right btn-sm" onclick="apro_docs(<?php echo $lstdocs[$i]["IdDocAlumno"]; ?>,5)" href="javascript:void(0);" style="margin-right: 5px;"> <i class="fa fa-times-circle"></i> </a>
														<?php } ?>
													</td>

												</tr>
											<?php } ?>
											</tfoot>
									</table>

								</div>
								<hr>
								<div class="box-header" style="background: #555299; color: white;">
									<h3 class="box-title">Documentos de trámites escolares</h3>
								</div>
								<div class="box-body">
									<table class="table table-striped" style="font-size: 12px;">
										<!-- <thead>
											<tr>
												<th>TIPO DE TRÁMITE</th>
												<th>FEC.CAP</th>
												<th>ESTATUS</th>
												<th>OPCIONES</th>
											</tr>
										</thead> -->
										<tbody>
											<?php $d_i = 0;
											$d_f = 0;
											for ($d = 0; $d < sizeof($docs_tram); $d++) {
												$d_i = $docs_tram[$d]["IdCiclo"];
												$regl = $espacio->get_docs_regl($datosUser[0]['IdGrupo'], $d_i);
												if ($d_i <> $d_f) { ?>
													<tr style="background: #d2d6de; color: black;">
														<th colspan="4"><?php echo $docs_tram[$d]["Ciclo"]; ?></th>
													</tr>
												<?php }
												?>
												<tr>
													<td>
														<?php if ($docs_tram[$d]["NomDocumento"] == 'CONVENIO BECA') { ?>
															<button onclick="window.open('repositorio/portafolio/convenio_beca.php?id=<?php echo time() . $IdUsua; ?>&idToks=<?php echo time() . $docs_tram[$d]["IdCiclo"]; ?>','_blank')" href="javascript:void(0);" title="Descargar convenio de beca" type="button" class="btn bg-maroon btn-flat btn-xs" style="margin-right: 5px;"><i class="fa fa-download"></i></button>
														<?php } ?>
														<?php if ($docs_tram[$d]["NomDocumento"] == 'FICHA DE INSCRIPCIÓN') { ?>
															<button onclick="window.open('repositorio/portafolio/<?php echo $nombre_file; ?>.php?id=<?php echo time() . $IdUsua; ?>&idToks=<?php echo time() . $docs_tram[$d]["IdCiclo"]; ?>','_blank')" href="javascript:void(0);" title="Descargar convenio de beca" type="button" class="btn bg-maroon btn-flat btn-xs" style="margin-right: 5px;"><i class="fa fa-download"></i></button>
														<?php } ?>
														<?php if ($docs_tram[$d]["NomDocumento"] == 'REGLAMENTO') { ?>
															<?php if (isset($regl[0])) { ?>
																<button onclick="window.open('assets/docs/files/<?php echo $regl[0]["Anio"]; ?>/<?php echo $regl[0]["Mes"]; ?>/<?php echo $regl[0]["Archivo"]; ?>','_blank')" href="javascript:void(0);" title="Descargar convenio de beca" type="button" class="btn bg-maroon btn-flat btn-xs" style="margin-right: 5px;"><i class="fa fa-download"></i></button>
														<?php }
														} ?>
														<?php echo $docs_tram[$d]["NomDocumento"]; ?>

													</td>
													<td><?php echo $docs_tram[$d]["FecCap"]; ?></td>
													<td><?php echo $docs_tram[$d]["Estatus"]; ?></td>
													<td>

														<?php if ($docs_tram[$d]["Archivo"]) { ?>
															<?php if ($docs_tram[$d]["IdEstatus"] <> 4) { ?>
																<a title="Aprobar documento" class="btn btn-success pull-right btn-sm" onclick="apro_docs(<?php echo $docs_tram[$d]["IdDocAlumno"]; ?>,4)" href="javascript:void(0);"> <i class="fa fa-check-circle"></i> </a>
																<a title="Documento no aprobado" class="btn btn-danger pull-right btn-sm" onclick="apro_docs(<?php echo $docs_tram[$d]["IdDocAlumno"]; ?>,5)" href="javascript:void(0);" style="margin-right: 5px;"> <i class="fa fa-times-circle"></i> </a>
															<?php } ?>
															<a style="margin-right: 5px;" class="btn btn-warning pull-right btn-sm" onClick="window.open('assets/docs/files/<?php echo $docs_tram[$d]["Anio"]; ?>/<?php echo $docs_tram[$d]["Mes"]; ?>/<?php echo $docs_tram[$d]["Archivo"]; ?>','_blank')" href="javascript:void(0);"> <i class="fa fa-eye"></i> </a>
														<?php } ?>
													</td>
												</tr>
											<?php $d_f = $docs_tram[$d]["IdCiclo"];
											} ?>
											</tfoot>
									</table>

								</div>
								<hr>
								<div class="box-header" style="background: #555299; color: white;">
									<h3 class="box-title">Pagos pendientes del alumno</h3>
								</div>
								<div class="box-body">
									<table class="table table-striped" style="font-size: 12px;">
										<thead>
											<tr>
												<th style="width: 10px">#</th>
												<th>CONCEPTO DE PAGO</th>
												<th>FECHA LÍMITE</th>
												<th>FICHA</th>
												<th style="text-align: center;">MI COMPROBANTE</th>
											</tr>
										</thead>
										<tbody>
											<?php $v = 0;
											for ($i = 0; $i 	< sizeof($misPagos); $i++) {
												$fecha = '';
												$Id = $misPagos[$i]["IdPago"];
												$nomMat = '';
												if (isset($misPagos[$i]["IdModulo"])) {
													$miMatx = $espacio->get_misMat($misPagos[$i]["IdModulo"]);
													$nomMat = ' - ' . $miMatx[0]['NombreMod'];
												} elseif ($datosUser[0]['Grado'] == 3) {
													$fecha = ' / ' . obtenerAnioMes($misPagos[$i]["Fecha"]);
												} ?>
												<tr>
													<td><b><?php echo $v = ($v + 1); ?>.- </b></td>
													<td style='text-transform: uppercase;'><?php echo $misPagos[$i]["NomPlan"] . $nomMat; ?> <?php echo $fecha; ?></td>
													<td><?php echo $misPagos[$i]["Fecha"]; ?></td>
													<td>
														<button type="button" class="btn bg-primary btn-flat" onclick="javascript:window.open('repositorio/pdf/boucherId.php?tokenId=<?php echo time() . $misPagos[$i]["IdPago"]; ?>');" href="javascript:void(0);" title="Descargar boucher de pago"><i class="fa fa-fw fa-cloud-download"></i></button>
													</td>
													<td style="text-align: center;">
														<?php if ($misPagos[$i]["IdEstatus"] == 1) { ?>
															<button onclick="subir_mi_pago(<?php echo $misPagos[$i]["IdPago"]; ?>,1)" type="button" class="btn bg-navy btn-flat"><i class="fa fa-fw fa-cloud-upload"></i></button>
														<?php } ?>
														<?php if ($misPagos[$i]["IdEstatus"] == 3) {
															echo "<b>EN REVISIÓN</b>";
														} ?>
													</td>
												<?php } ?>
												</tr>
												</tfoot>
									</table>

								</div>
								<hr>
								<?php if ($datosUser[0]['Grado'] == 13) { ?>
									<div class="box-header" style="background: #606060; color: white;">
										<h3 class="box-title">Servicio Social</h3>
									</div>
									<div class="box-body">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>Tipo de documento</th>
													<th>FecCap</th>
													<th>Estatus</th>
													<th>Opciones</th>
												</tr>
											</thead>
											<tbody>
												<?php for ($i = 0; $i < sizeof($documentos); $i++) {
												?>
													<tr>
														<td><?php echo $documentos[$i]["NomDocumento"]; ?></td>
														<td><?php echo $documentos[$i]["FecCap"]; ?></td>
														<td><?php echo $documentos[$i]["Estatus"]; ?></td>
														<td>
															<?php if ($documentos[$i]["Estatus"] != 'Aprobado') { ?>
																<!-- <button type="button" class="btn btn-danger pull-right" href="javascript:void(0);"  style="float: right;"><i class="fa fa-lock"></i> CERRADO</button> -->
																<button type="button" class="btn btn-default view_tutor pull-right" href="javascript:void(0);" name="view" value="view" id="<?php echo $documentos[$i]["IdDocumento"]; ?>" style="float: right;"><i class="fa fa-unlock"></i></button>
															<?php }   ?>
															<a style="margin-right: 10px;" class="btn btn-default pull-right" onClick="window.open('assets/docs/ServicioSocial/<?php echo $documentos[$i]["Archivo"]; ?>','_blank')" href="javascript:void(0);"> <i class="fa fa-eye"></i> </a>
														</td>


													</tr>
												<?php } ?>
												</tfoot>
										</table>

										<br>
										<div class="box box-widget">
											<div class="box-header with-border">
												<div class="user-block">
													<img class="img-circle" src="assets/perfil/<?php echo $datosUser[0]["Foto"]; ?>" alt="User Image">
													<span class="username"><a href="#"><?php echo $datosUser[0]["Nombre"] . ' ' . $datosUser[0]["APaterno"] . ' ' . $datosUser[0]["AMaterno"]; ?></a></span>
													<span class="description"><?php echo $datosUser[0]["Correo"]; ?></span>
												</div>
											</div>
											<div class="box-body">
												<div class="box-body">
													<strong><i class="fa fa-home margin-r-5"></i> Nombre de la Dependencia / Institución / Organismo:</strong>
													<p class="text-muted"><?php echo $servicio[0]['NomDependencia']; ?></p>
													<strong><i class="fa fa-book margin-r-5"></i> Programa del Servicio Social</strong>
													<p class="text-muted"><?php echo $servicio[0]['NomPrograma']; ?></p>
													<strong><i class="fa fa-calendar margin-r-5"></i> Periodo</strong>
													<p class="text-muted"><?php echo $servicio[0]['Periodo']; ?></p>
													<strong><i class="fa fa-edit margin-r-5"></i> Actividades a realizar o realizadas</strong>
													<p class="text-muted"><?php echo $servicio[0]['Actividades']; ?></p>
												</div>
												<br>
												<button onclick="configurar_carta(<?php echo $servicio[0]['IdServicio']; ?>)" type="button" class="btn btn-primary btn-xs"><i class="fa fa-gear"></i> Carta de presentación</button>
												<button onclick="configurar_servicio(<?php echo $servicio[0]['IdServicio']; ?>)" type="button" class="btn btn-primary btn-xs"><i class="fa fa-gear"></i> Configurar constancia</button>

											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</form>
				</div>
			</section>
		</div>
		<?php include("footer.php"); ?>
	</div>
	<div id="dataModal2" class="modal fade"> <!--MODAL ME GUSTA-->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-commenting"></i> Notificaciones realizadas al prospecto</h4>
				</div>
				<div class="modal-body" id="employee_detail2">

				</div>
			</div>
		</div>
	</div>

	<div id="dataModalc" class="modal fade"> <!--MODAL ME GUSTA-->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-gear"></i> Carta de presentación para el servicio social</h4>
				</div>
				<div class="modal-body" id="employee_detailc">

				</div>
			</div>
		</div>
	</div>
	<div id="dataModal3" class="modal fade"> <!--MODAL ME GUSTA-->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-gear"></i> Configurar constancia de servicio social</h4>
				</div>
				<div class="modal-body" id="employee_detail3">

				</div>
			</div>
		</div>
	</div>
	<div id="dataModalPerfil" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Foto de perfil del alumno</h4>
				</div>
				<div class="modal-body" id="employee_detailPerfil">
				</div>
			</div>
		</div>
	</div>
	<div id="dataModalModFue" class="modal fade bs-example-modal-lg">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar documentos</h4>
				</div>
				<div class="modal-body" id="employee_detailModFue">
				</div>
			</div>
		</div>
	</div>
	<div id="dataModalExpediente" class="modal fade bs-example-modal-lg">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Expediente físico </h4>
				</div>
				<div class="modal-body" id="employee_expediente">
				</div>
			</div>
		</div>
	</div>
	<div id="data_pag" class="modal fade">
		<!--MODAL ME GUSTA-->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-fw fa-file"></i> Comprobante de pago</h4>
				</div>
				<div class="modal-body" id="employee_pag">
				</div>
			</div>
		</div>
	</div>

</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
	function apro_docs(IdDocs, IdEstatus) {
		if (IdEstatus == 4) {
			var Texto = "seguro que desea aprobar este documento";
		} else {
			var Texto = "seguro que desea NO aprobar este documento";
		}
		var IdUsua = document.getElementById("IdUsua").value;
		var TipoGuardar = "aprob_docs_alum";
		swal({
				title: '\u00BFEst\u00E1 ' + Texto + '?',
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
							IdEstatus: IdEstatus
						},
						success: function(data) {
							parent.location.href = 'docVerificar.php?IdUsua=1548575632' + IdUsua;
						}
					})

				}

			});
	}

	function delDocs(IdDocs) {
		var IdUsua = document.getElementById("IdUsua").value;
		var TipoGuardar = "del_docsAlumno";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea eliminar este documento?",
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
							IdDocs: IdDocs
						},
						success: function(data) {
							parent.location.href = 'docVerificar.php?IdUsua=1548575632' + IdUsua;
						}
					})

				}

			});
	}

	$(function() {
		$('#example1').DataTable()
	})

	function notificar_user(IdUsua, IdAdmin) {
		$.ajax({
			url: "formConsulta/chat_notificacion.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				IdAdmin: IdAdmin
			},
			success: function(data) {
				$('#employee_detail2').html(data);
				$('#dataModal2').modal('show');
			}
		});
	}

	$(document).ready(function() {
		$(document).on('click', '.view_tutor', function() {
			var employee_id = $(this).attr("id");
			//	document.getElementById("IdAlumno").value = employee_id;
			var Tipo = 2; //document.getElementById("Tipo").value;
			if (employee_id != '') {
				$.ajax({
					url: "formConsulta/closeDocumento.php",
					method: "POST",
					data: {
						employee_id: employee_id,
						Tipo: Tipo
					},
					success: function(data) {
						$('#employee_detail2').html(data);
						$('#dataModal2').modal('show');
					}
				});
			}
		});
	});

	function configurar_servicio(IdServicio) {
		$.ajax({
			url: "formConsulta/configurar_servicio_social.php",
			method: "POST",
			data: {
				IdServicio: IdServicio
			},
			success: function(data) {
				$('#employee_detail3').html(data);
				$('#dataModal3').modal('show');
			}
		});
	}

	function configurar_carta(IdServicio) {
		$.ajax({
			url: "formConsulta/configurar_carta_servicio_social.php",
			method: "POST",
			data: {
				IdServicio: IdServicio
			},
			success: function(data) {
				$('#employee_detailc').html(data);
				$('#dataModalc').modal('show');
			}
		});
	}

	function configurarDocs(IdUsua) {
		$.ajax({
			url: "formConsulta/configurarDocs.php",
			method: "POST",
			data: {
				IdUsua: IdUsua
			},
			success: function(data) {
				$('#employee_detailModFue').html(data);
				$('#dataModalModFue').modal('show');
			}
		});
	}

	function expediente_fisico(IdUsua) {
		$.ajax({
			url: "formConsulta/expediente_fisico.php",
			method: "POST",
			data: {
				IdUsua: IdUsua
			},
			success: function(data) {
				$('#employee_expediente').html(data);
				$('#dataModalExpediente').modal('show');
			}
		});
	}

	function subir_foto_perfil(IdUsua) {
		$.ajax({
			url: "formConsulta/foto_perfil.php",
			method: "POST",
			data: {
				IdUsua: IdUsua
			},
			success: function(data) {
				$('#employee_detailPerfil').html(data);
				$('#dataModalPerfil').modal('show');
			}
		});
	}

	function copiar_imagen(IdDocs, IdUsua) {
		var TipoGuardar = "copiar_img_user";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea copiar esta imagen?",
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
							IdUsua: IdUsua
						},
						success: function(data) {
							alert(data);
						}
					})

				}

			});
	}

	function subir_mi_pago(IdPago, TipoPago) {
		var Tipo = 2;
		$.ajax({
			url: "formConsulta/seguimiento_pago_especial.php",
			method: "POST",
			data: {
				IdPago: IdPago,
				Tipo: Tipo,
				TipoPago: TipoPago
			},
			success: function(data) {
				$('#employee_pag').html(data);
				$('#data_pag').modal('show');
			}
		});
	}

	function val_sbisDocs() {
		var Tipo = document.getElementById("txtTipo").value;
		var Archivo = document.getElementById("txtArchivo").value;

		if (Tipo == '') {
			swal("Error al guardar", "Debe seleccionar el tipo de documento.", "error");
			document.getElementById("txtTipo").focus();
			return 0;
		}
		if (Archivo == '') {
			swal("Error al guardar", "Debe seleccionar el archivo.", "error");
			document.getElementById("txtArchivo").focus();
			return 0;
		}

		document.getElementById("imgLoadDoAlum").style.display = 'block';
		document.frm.Mov.value = 'upl_docsAlumno';
		document.frm.submit();

	}

	function save_seguimiento_expediente(IdUsua,IdAdmin) {
		var Tipo = document.getElementById("txt_tipo_seguimiento").value;
		var Seguimiento = document.getElementById("txt_seguimiento_exp").value;
		var Fecha = document.getElementById("txt_fecha_exp").value;
		
		if (Tipo == '') {
			swal("Error al guardar", "Debe seleccionar el tipo de seguimiento.", "error");
			document.getElementById("txt_tipo_seguimiento").focus();
			return 0;
		}
		if (Seguimiento == '') {
			swal("Error al guardar", "Debe escribir el seguimiento.", "error");
			document.getElementById("txt_fecha_exp").focus();
			return 0;
		}
		if (Fecha == '') {
			swal("Error al guardar", "Debe escribir el seguimiento.", "error");
			document.getElementById("txt_seguimiento_exp").focus();
			return 0;
		}
		

		var TipoGuardar = "ad_seguimiento_exp";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea agregar este seguimiento del expediente?",
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
								IdUsua: IdUsua, IdAdmin:IdAdmin, Tipo:Tipo, Seguimiento:Seguimiento, Fecha:Fecha
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								swal("Guardado correctamente", "El seguimiento se ha  guardado correctamente.", "success");
								$.ajax({
									url: "formConsulta/expediente_fisico.php",
									method: "POST",
									data: {
										IdUsua: IdUsua
									},
									success: function(data) {
										$('#employee_expediente').html(data);
										$('#dataModalExpediente').modal('show');
									}
								});
							}
							
							if (data == 0) {
								swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
							}
						})
						.error(function(data) {
							swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
						});

				}

			});
	}

</script>
</body>

</html>