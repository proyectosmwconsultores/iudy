<?php $section = "Mi Planeación";
$_v = 89;
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en la planeación académica creada');
}
if ($_SESSION['Permisos']) {
	// $t->get_validar_mat_doc($_GET["idToks"],$_SESSION['IdUsua']);
	$AsignacionId = $t->get_datosModuloD($_GET["idToks"]);
	$_val_s = 0;
	$_val_a = 0;
	$IdActividad = '';
	$porciones = explode("_", $_GET["idLeccion"]);
	$IdParcial =  $porciones[0];
	$IdSemana =  $porciones[1];
	$_val_s = $IdSemana;
	if (isset($porciones[2])) {
		$IdActividad =  $porciones[2];
		$_val_a = $IdActividad;
		$_val_s = 0;
		$lst_actividad = $contenido->get_lst_actividad($IdActividad);

		$id_T = $lst_actividad[0]['IdTipoActividad'];
		if ($id_T == 1) {
			$ico_ = 'fa fa-edit';
		} elseif ($id_T == 2) {
			$ico_ = 'fa fa-comments';
		} elseif ($id_T == 3) {
			$ico_ = 'fa folder';
		} elseif ($id_T == 4) {
			$ico_ = 'fa fa-map-signs';
		}
		if ($lst_actividad[0]['IdEstatus'] == 8) {
			$cols = 'blue';
		} else {
			$cols = 'red';
		}
		$lst_docs = $contenido->get_lst_docs($IdActividad);
	}


	$materia = $t->get_datosModuloD($_GET['idToks']);
	$lst_sem = $t->get_lst_sem_par($IdParcial);

?>
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

	<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
		<div class="wrapper">
			<?php include("menuV.php"); ?>
			<div class="content-wrapper">
				<?php if (($_SESSION['Permisos'] == 2) && ($_SESSION['EstatusAsig'] == "F")) {
					include("formConsulta/alerta.php");
				} ?>
				<section class="content-header">
					<h1> <?php echo $AsignacionId[0]["NombreMod"]; ?></h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-book"></i>Planeación</a></li>
						<li class="active"><a href="#">Vista de la planeación</a></li>
					</ol>
				</section>
				<section class="content">
					<form name="frm" id="frm" action="miLeccion.php" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="idToks" id="idToks" value="<?php echo $_GET["idToks"]; ?>">
						<input type="hidden" name="IdParcial" id="IdParcial" value="<?php echo $IdParcial; ?>">
						<input type="hidden" name="IdSemana" id="IdSemana" value="<?php echo $IdSemana; ?>">
						<input type="hidden" name="IdActividad" id="IdActividad" value="<?php echo $IdActividad; ?>">
						<input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>">

						<div class="row">
							<div class="col-md-4">
								<div class="box box-solid">
									<div class="box-header with-border" style="background: #003A70;">
										<h3 class="box-title" style="font-size: 15px; color: #fff;"><i class="fa fa-fw fa-map-signs"></i> Contenido del <?php echo $lst_sem[0]['Titulo']; ?></h3>

										<div class="box-tools">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="box-body no-padding">
										<div class="box-group" id="accordion">
											<?php $_coll = 0;
											for ($_sem = 0; $_sem < sizeof($lst_sem); $_sem++) {
												$lst_activ = $contenido->get_lst_actividades($IdParcial, $lst_sem[$_sem]['IdSemanaDocente']);
												$lst_tema = $contenido->get_lst_tema($lst_sem[$_sem]['IdSemanaDocente']);

												$_coll = ($_coll + 1);
												if ($IdSemana == $lst_sem[$_sem]['IdSemanaDocente']) {
													$_class = "";
													$_expanded = "true";
													$_sty = "";
													$_collx = " in";
													$_clrs = " background: #c4314d;";
													$_clx = " style='color: black;'";
												} else {
													$_class = "collapsed";
													$_expanded = "false";
													$_sty = "height: 0px;";
													$_collx = "";
													$_clrs = "";
													$_clx = " style='color: #003A70;'";
												}
											?>
												<div class="panel box box-primary" style="border-top: none;">
													<div class="box-header with-border" style="padding: 5px; <?php echo $_clrs; ?>">
														<h4 class="box-title" style="font-size: 13px;">
															<a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $_coll; ?>" aria-expanded="<?php echo $_expanded; ?>" class="<?php echo $_class; ?>" <?php echo $_clx; ?>>
																<i class="fa fa-fw fa-flag-checkered"></i> <?php echo $lst_sem[$_sem]['Etiqueta_semana']; ?>
															</a>
														</h4>
													</div>
													<div id="<?php echo $_coll; ?>" class="panel-collapse collapse<?php echo $_collx; ?>" aria-expanded="<?php echo $_expanded; ?>" style="<?php echo $_sty; ?>">
														<ul class="nav nav-pills nav-stacked" style="font-size: 12px;">
															<li <?php if ($_val_s == $IdSemana) {
																	echo "class='active'";
																} ?>><a onclick="window.open('doPlanContenido.php?idToks=<?php echo $_GET['idToks']; ?>&idLeccion=<?php echo $IdParcial . '_' . $lst_sem[$_sem]['IdSemanaDocente']; ?>','_self')" href="javascript:void(0);"><i class="fa fa-info-circle"></i> <?php echo $lst_tema[0]['Semana']; ?></a></li>
															<?php for ($a = 0; $a < sizeof($lst_activ); $a++) {
																$idT = $lst_activ[$a]['IdTipoActividad'];
																if ($idT == 1) {
																	$ico = 'fa fa-edit';
																} elseif ($idT == 2) {
																	$ico = 'fa fa-comments';
																} elseif ($idT == 3) {
																	$ico = 'fa fa-folder';
																} elseif ($idT == 4) {
																	$ico = 'fa fa-map-signs';
																}
															?>
																<li <?php if ($_val_a == $lst_activ[$a]['IdActividadesDocente']) {
																		echo "class='active'";
																	} ?>><a onclick="window.open('doPlanContenido.php?idToks=<?php echo $_GET['idToks']; ?>&idLeccion=<?php echo $IdParcial . '_' . $lst_sem[$_sem]['IdSemanaDocente'] . '_' . $lst_activ[$a]['IdActividadesDocente']; ?>','_self')" href="javascript:void(0);"><i class="<?php echo $ico; ?>"></i> <?php echo $lst_activ[$a]['NomActividad']; ?> <span class="direct-chat-timestamp pull-right" style="color: #6969ff; font-size: 11px;"><?php echo $lst_activ[$a]['TipoActividad']; ?></span></a></li>
															<?php } ?>
														</ul>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<?php if ($IdActividad) { ?>
									<div class="box box-solid">
										<div class="box-header with-border" style="background: #003A70;">
											<h3 class="box-title" style="font-size: 15px; color:#fff;"><i class="fa fa-fw fa-balance-scale"></i> Información</h3>

											<div class="box-tools">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body no-padding">
											<ul class="nav nav-pills nav-stacked" style="font-size: 12px;">
												<li><a href="javascript:void(0);"><i class="fa fa-calendar-check-o text-red"></i> Inicia: <?php echo obtenerFechaCorta($lst_actividad[0]['FecIni']); ?></a></li>
												<li><a href="javascript:void(0);"><i class="fa fa-calendar-times-o text-yellow"></i> Finaliza: <?php echo obtenerFechaCorta($lst_actividad[0]['FecFin']); ?></a></li>
												<?php if ($id_T <> 4) { ?>
													<li><a href="javascript:void(0);"><i class="fa fa-server text-light-blue"></i> Porcentaje: <?php echo $lst_actividad[0]['Porcentaje']; ?> %</a></li>
												<?php } ?>
											</ul>
										</div>
										<!-- /.box-body -->
									</div>
								<?php } ?>
								<!-- /.box -->
							</div>
							<!-- /.col -->
							<?php if ($IdActividad) { ?>
								<div class="col-md-8">
									<div class="nav-tabs-custom">
										<ul class="nav nav-tabs">
											<li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true"><i class="<?php echo $ico_; ?>"></i> <?php echo $lst_actividad[0]['NomActividad']; ?></a></li>
											<?php if ($lst_actividad[0]['IdTipoActividad'] == 2) { ?><li class=""><a style="cursor: pointer;" onclick="cargarForo()" href="#timeforo" data-toggle="tab" aria-expanded="false">Ingresar al foro</a></li><?php } ?>
											<li class="pull-right"><a href="javascript:void(0);" style="color: <?php echo $cols; ?>" class="text-muted"><i class="fa fa-gear"></i> <?php echo $lst_actividad[0]['Estatus']; ?></a></li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="activity">
											<small class="label label-primary"><i class="fa fa-check-circle"></i> Estrategias, técnicas y herramientas de aprendizaje </small>
												<ol class="breadcrumb" style="color: #72afd2;">
													<li><i class="fa fa-dashboard"></i> <?php echo $lst_actividad[0]['Estrategia']; ?></li>
													<li><i class="fa fa-tags"></i> <?php echo $lst_actividad[0]['Tecnica']; ?></li>
													<li><i class="fa fa-file-text"></i> <?php echo $lst_actividad[0]['Herramienta']; ?></li>
												</ol>
												<div class="post" style="text-align: justify; padding: 10px;">
													<p><?php echo $lst_actividad[0]['DesActividad']; ?></p>
												</div>
												
												<div class="box-footer no-padding">
													<div class="mailbox-controls">
														<?php if (isset($lst_docs[0])) { ?>
															<button style="margin-left: -5px;" href="javascript:void(0);" type="button" class="btn bg-purple btn-flat btn-sm"><i class="fa fa-folder-open"></i> Mis materiales didácticos</button>
														<?php } ?>
														<?php if(isset($lst_actividad[0]['IdRubrica'])){ ?>
															<button onclick="mi_rubrica(<?php echo $IdActividad; ?>)" style="float: right;" type="button" class="btn bg-navy btn-flat btn-sm"><i class="fa fa-fire"></i> Rúbrica de la actividad</button>
														<?php } ?>
													</div>
												</div>
												<?php if (isset($lst_docs[0])) { ?>
													<br>
													<ul class="mailbox-attachments clearfix">
														<?php for ($s = 0; $s < sizeof($lst_docs); $s++) {
															$_tip = $lst_docs[$s]['Tipo'];
															$_tem = $lst_docs[$s]['IdTema'];
															$_icono = "<i class='fa fa-fw fa-file-text'></i>";
															if ($_tem == 7) {
																if ($_tip == 'youtube') {
																	$_icono = "<i class='fa fa-fw fa-toggle-right'></i>";
																} else {
																	$_icono = "<i class='fa fa-fw fa-folder'></i>";
																}
															} else {
																if ($_tip == 'pdf') {
																	$_icono = "<i class='fa fa-fw fa-file-pdf-o'></i>";
																} elseif ($_tip == 'docx') {
																	$_icono = "<i class='fa fa-fw fa-file-word-o'></i>";
																} elseif ($_tip == 'xlsx') {
																	$_icono = "<i class='fa fa-fw fa-file-excel-o'></i>";
																}
															}

														?>
															<li style="background: #f0e7e7; cursor: pointer;" onclick="verBiblioteca(<?php echo $lst_docs[$s]['IdBiblioteca']; ?>)">
																<span class="mailbox-attachment-icon"><?php echo $_icono; ?></span>
																<div class="mailbox-attachment-info">
																	<a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?php echo $lst_docs[$s]['Nombre']; ?></a>
																</div>
															</li><?php } ?>
													</ul><?php } ?>
											</div>
											<div class="tab-pane" id="timeline">
												<ul class="timeline timeline-inverse" id="_panel">
												</ul>
											</div>
											<div class="tab-pane" id="timeforo">
												<div class="post" id="panel_foro">
													<p>ok </p>
												</div>
											</div>
										</div>
									</div>
								</div>

							<?php } else {
								$lst_temax = $contenido->get_lst_tema_id($IdSemana);
							?>
								<div class="col-md-8">
									<div class="box box-primary">
										<div class="box-header with-border">
											<h3 class="box-title" style="font-size: 15px;"><i class="fa fa-fw fa-inbox"></i> <?php echo $lst_temax[0]['Etiqueta_semana']; ?>: <?php echo $lst_temax[0]['Semana']; ?></h3>
										</div>
										<div class="box-body no-padding">
											<div class="mailbox-read-message" style="text-align: justify; justify; padding: 10px;">
												<p>
													<b>Objetivo sobre el contenido temático:</b><br>
													<?php echo $lst_temax[0]['Tematica']; ?>
												</p>
												<p>
													<b>Contenido temático:</b><br>
													<?php echo $lst_temax[0]['Temas']; ?>
												</p>
												<p>
													<?php if ($lst_temax[0]['Code']) {
														echo $lst_temax[0]['Code'];
													} ?>
												</p>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</form>

				</section>

			</div>
			<div id="dataPre" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background: #5a284f; color: #fbeb00; font-size: 16px;">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><i class="fa fa-fw fa-caret-square-o-right"></i> <b id='lbl_Pre'></b></h4>
						</div>
						<div class="modal-body" id="employee_pre">
						</div>
					</div>
				</div>
			</div>

			<div id="dataBli" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background: #5a284f; color: #fbeb00; font-size: 16px;">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><i class="fa fa-fw fa-caret-square-o-right"></i> <b id='lbl_bib'></b></h4>
						</div>
						<div class="modal-body" id="employee_bli">
						</div>
					</div>
				</div>
			</div>

			<div id="dataModal_rub" class="modal fade bs-example-modal-lg">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Rúbrica de la actividad</h4>
					</div>
					<div class="modal-body" id="employee_detail_rub">
					</div>
				</div>
			</div>
		</div>

			<div id="dataEva" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background: #5a284f; color: #fbeb00; font-size: 16px;">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><i class="fa fa-fw fa-wechat"></i> Comentarios realizados</h4>
						</div>
						<div class="modal-body" id="employee_eva">
						</div>
					</div>
				</div>
			</div>

			<?php include("footer.php"); ?>
		</div>
		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
		<script>
			function cargarForo() {
				var IdUsua = document.getElementById("IdUsua").value;
				var IdAsignacion = document.getElementById("idToks").value;
				var IdParcial = document.getElementById("IdParcial").value;
				var IdActividad = document.getElementById("IdActividad").value;
				var Capa = "#panel_foro";
				$(Capa).load("alumnos/miForo.php", {
					idAsignacion: IdAsignacion,
					IdParcial: IdParcial,
					IdActividad: IdActividad,
					IdUsua: IdUsua
				}, function(response, status, xhr) {
					if (status == "error") {
						alert(status);
						var msg = "Error!, algo ha sucedido: ";
						$(Capa).html(msg + xhr.status + " " + xhr.statusText);
					}
				});
			}

			function verPresentacion(IdSemana) {
				$.ajax({
					url: "formConsulta/verPresentacion.php",
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

			function verBiblioteca(IdBiblioteca) {
				$.ajax({
					url: "formConsulta/verDocumento.php",
					method: "POST",
					data: {
						IdBiblioteca: IdBiblioteca
					},
					success: function(data) {
						$('#employee_bli').html(data);
						$('#dataBli').modal('show');
					}
				});
			}

			function newRespuesta(IdForo) {
				$.ajax({
					url: "docente/respuestaForo.php",
					method: "POST",
					data: {
						IdForo: IdForo
					},
					success: function(data) {
						$('#employee_eva').html(data);
						$('#dataEva').modal('show');
					}
				});
			}

			function mi_rubrica(IdActividadDoc) {
			var IdRubrica = 0;
			$.ajax({
				url: "vistas/docente/mi_rubrica_actividad.php",
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
		</script>
	</body>

	</html>
<?php
} else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>