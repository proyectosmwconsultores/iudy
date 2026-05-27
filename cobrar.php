<?php $valor = 3;
$section = "Alumnos";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el buscador de alumnos');
}
if (isset($_GET["token"])) {
	$id = substr($_GET["token"], 10, 10);
	$t->get_chk_beca_alumno_id($id);
	$t->get_chkPago($id);
	$chkDeuda = $t->get_chkDeuda($id);
	$alumno = $t->get_datAlumno($id);
	$beca = $t->get_datBeca($id);
	$pagPend = $t->get_pagPendientes($id); 
	$_beca = $t->get_configurar_beca($id);
	$pendIns = $espacio->get_proceso_inscripcion_id($id);
	$pagApro = $t->get_pagAprobados($id);
	$fac_pend = $t->get_factura_pend_id($id);
	$donacion = $t->get_donacion_id($id);
	
	
	$grp = $alumno[0]["TipoCiclo"];
	$mod = $alumno[0]["Turno"];
	$_mod = $t->get_mod_lista($_SESSION['IdUsua'], 9);
	if ($grp == "C") {
		$txtGrp = "CUATRIMESTRE";
	} elseif ($grp == "S") {
		$txtGrp = "SEMESTRE";
	} else {
		$txtGrp = "TRIMESTRE";
	}
	$bv = 1;
} else {
	$id = "";
}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Perfil de alumno para realizar cobros</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumno</a></li>
					<li class="active">Perfil</li>
				</ol>
			</section>

			<section class="content" style="font-size: 13px;">
				<form name="frm" id="frm" action="perfil.php" method="POST" enctype="multipart/form-data">
					<input id="token" name="token" value="<?php if (isset($_GET['token'])) {
																echo $_GET['token'];
															} ?>" type="hidden" />
					<input id="IdUsx" name="IdUsx" value="<?php if (isset($_GET['token'])) {
																echo substr($_GET['token'], 10, 10);
															} ?>" type="hidden" />
					<input id="Mov" name="Mov" value="" type="hidden" />
					<div class="row">
						<div class="col-md-3">
							<div class="box box-primary">
								<a href="javascript:void(0);" class="btn btn-info btn-block view_buscar"><b><i class="fa fa-fw fa-search"></i> B&uacute;squeda de alumno</b></a>
								<div class="box-body box-profile">
									<?php if (isset($_GET['token'])) { ?>
										<img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $alumno[0]["Foto"]; ?>" alt="User profile picture" style="width:100px; height: 100px;">
									<?php } else { ?>
										<img class="profile-user-img img-responsive img-circle" src="assets/perfil/nuevo.png" alt="User profile picture">
									<?php } ?>
									<?php if (isset($_GET['token'])) {  ?>
										<h3 class="profile-username text-center"><?php echo $alumno[0]["Nombre"]; ?></h3>

										<p class="text-muted text-center"><?php echo $alumno[0]["APaterno"] . ' ' . $alumno[0]["AMaterno"]; ?></p>

										<ul class="list-group list-group-unbordeblue">
											<li class="list-group-item">
												<b>Estatus</b> <a class="pull-right"><b><?php echo $alumno[0]["Estatus"]; ?></b></a>
											</li>
											<li class="list-group-item">
												<b>Matr&iacute;cula</b> <a class="pull-right"><?php echo $alumno[0]["Usuario"]; ?></a>
											</li>
										</ul>
										<?php if ($alumno[0]['Estatus'] == 'En proceso') { ?>
											<a style="text-align: left;" onClick="window.open('addAddSeguimiento.php','_self')" href="javascript:void(0);" class="btn btn-danger btn-block"><i class="fa fa-mail-reply-all"></i> Regresar al seguimiento</a>
										<?php } ?>
									<?php } ?>
									<?php if ((isset($_GET['token'])) && ($alumno[0]['_numerica'])) { ?>
										<strong><i class="fa fa-flag margin-r-5"></i> Referencia:</strong>
										<p>
											<span class="label label-primary">Alfanumérica: <?php echo $alumno[0]['_alfanumerica']; ?></span>
											<span class="label label-primary">Numerica: <?php echo $alumno[0]['_numerica']; ?></span>
										</p><?php } ?>
									<?php if ((isset($_GET['token'])) && ($alumno[0]['Estatus'] <> 'En proceso')) {
										for ($m = 0; $m < sizeof($_mod); $m++) {
											if ($_mod[$m]['Tipo'] == 'L') { ?>
												<a style="text-align: left;" onClick="window.open('<?php echo $_mod[$m]['Link']; ?><?php echo time() . $id; ?>','_self')" href="javascript:void(0);" class="btn bg-maroon btn-flat btn-sm btn-block"><i class="fa fa-qrcode"></i> <?php echo $_mod[$m]['Nombre']; ?></a>
											<?php } else { ?>
												<a style="text-align: left;" onclick="<?php echo $_mod[$m]['Link']; ?>" href="javascript:void(0);" class="btn bg-maroon btn-flat btn-sm btn-block"><i class="fa fa-qrcode"></i> <?php echo $_mod[$m]['Nombre']; ?></a>
											<?php } ?>
										<?php } ?>
										<a style="text-align: left;" onclick="datos_factura_id(<?php echo $id; ?>)" href="javascript:void(0);" class="btn bg-maroon btn-flat btn-sm btn-block"><i class="fa fa-question-circle"></i> Datos de factura</a>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="col-md-9">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#activity" data-toggle="tab"><i class="fa fa-fw fa-info-circle"></i> Informaci&oacute;n general</a></li>
									<li><a href="#timeline2" data-toggle="tab"><i class="fa fa-fw fa-file-pdf-o"></i> Pagos aprobados</a></li>
									<li><a href="#mi_beca" data-toggle="tab"><i class="fa fa-fw fa-black-tie"></i> Beca del alumno</a></li>
								</ul>
								<?php if (isset($_GET['token'])) { ?>
									<div class="tab-content">
									<?php if ((isset($pendIns[0]['Valor'])) && ($pendIns[0]['Valor'] == 4)) { ?>
									<div class="bg-red-active color-palette" style="padding: 10px; text-align: center;"><span>EL ALUMNO NO HA SIDO MIGRADO</span></div><br>
									<?php } ?>
									
										<div class="active tab-pane" id="activity">
											<table class="table table-striped" style="font-size: 12px;">
												<tbody>
													<tr style="background: #c1c5ffc4;">
														<th colspan="4"><i class="fa fa-fw fa-book"></i> <?php echo $alumno[0]["NomEducativa"]; ?></th>
													</tr>
													<tr>
														<td style="text-align: right;" class="text-blue">CAMPUS:</td>
														<td><?php echo $alumno[0]["Campus"]; ?></td>
														<td style="text-align: right;" class="text-blue">MODALIDAD:</td>
														<td><?php echo $alumno[0]['_Modalidad'] . ' - ' . $alumno[0]['_Dias']; ?></td>
													</tr>
													<tr>
														<td style="text-align: right;" class="text-blue">GRUPO:</td>
														<td><?php echo $alumno[0]["CveGrupo"]; ?></td>
														<td style="text-align: right;" class="text-blue">GRADO:</td>
														<td><?php echo $alumno[0]["SemCua"] . $alumno[0]["Abreviatura"] . ' ' . $txtGrp; ?></td>
													</tr>
												</tbody>
											</table>
											<?php
											$_mod64 = $t->get_mod_lista_id($_SESSION['IdUsua'], 64);
											if (isset($_mod64[0])) { ?>
												<table class="table table-striped" style="font-size: 12px;">
													<tbody>
														<tr style="background: #c1c5ffc4;">
															<th colspan="5"><i class="fa fa-fw fa-bell"></i> Factura pendiente por realizar del alumno </th>
														</tr>
														<tr>
															<td class="text-blue">Ajuste</td>
															<td class="text-blue">Folio</td>
															<td class="text-blue">Fecha pago</td>
															<td class="text-blue">Fecha cap.</td>
															<td class="text-blue">Monto</td>
														</tr>
														<?php $kx = 0;
														for ($f = 0; $f < sizeof($fac_pend); $f++) { ?>
															<tr>
																<td style="width: 95px;">
																<button onclick="generar_factura_id(<?php echo $fac_pend[$f]["IdUsua"]; ?>,'<?php echo $fac_pend[$f]["NoFolio"]; ?>')" type="button" title="Detalle del concepto" class="btn bg-orange btn-flat btn-sm"><i class="fa fa-object-group"></i></button>
																</td>
																<td><?php echo $fac_pend[$f]["NoFolio"]; ?></td>
																<td><?php echo $fac_pend[$f]["FecPago"]; ?></td>
																<td><?php echo $fac_pend[$f]["FecCap"]; ?></td>
																<td>$ <?php echo number_format($fac_pend[$f]["Monto"], 2, '.', ','); ?></td>
															</tr>
														<?php  }  ?>
													</tbody>
												</table>
											<?php  }
											$_mod11 = $t->get_mod_lista_id($_SESSION['IdUsua'], 11);
											$_mod12 = $t->get_mod_lista_id($_SESSION['IdUsua'], 12);
											$_mod13 = $t->get_mod_lista_id($_SESSION['IdUsua'], 13);
											$_mod14 = $t->get_mod_lista_id($_SESSION['IdUsua'], 14);
											$_mod15 = $t->get_mod_lista_id($_SESSION['IdUsua'], 15);
											$_mod65 = $t->get_mod_lista_id($_SESSION['IdUsua'], 65);
											$_mod91 = $t->get_mod_lista_id($_SESSION['IdUsua'], 91);
											$_mod92 = $t->get_mod_lista_id($_SESSION['IdUsua'], 92);
											?>
											<table class="table table-striped" style="font-size: 12px;">
												<tbody>
													<tr style="background: #c1c5ffc4;">
														<th colspan="7"><i class="fa fa-fw fa-bell"></i> PAGOS PENDIENTES DEL ALUMNO </th>
													</tr>
													<tr>
														<td class="text-blue">Ajuste</td>
														<td class="text-blue">Concepto</td>
														<td class="text-blue">Fecha límite de pago</td>
													</tr>
													<?php $kx = 0;
													for ($p = 0; $p < sizeof($pagPend); $p++) {
														$kx = 1;
														$nomMat = '';
														if (isset($pagPend[$p]["IdModulo"])) {
															$miMatx = $espacio->get_misMat($pagPend[$p]["IdModulo"]);
															$nomMat = ' <b>*' . $miMatx[0]['NombreMod'] . '</b>';
														}
													?>
														<tr>
															<td style="width: 95px;">
															<?php if (isset($_mod65[0])) { ?>
																<button onclick="del_pago_id(<?php echo $pagPend[$p]["IdPago"]; ?>,<?php echo $id; ?>)" type="button" title="Detalle del concepto" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-trash"></i></button>
															<?php } ?>
																<?php if (isset($_mod12[0])) { ?>
																	
																	<button onclick="addPago(<?php echo $pagPend[$p]["IdPago"]; ?>)" type="button" title="Detalle del concepto" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-gears"></i></button> <?php } ?>
																<?php if ($pagPend[$p]["_img"]) { ?>
																	<button onclick="subir_mi_pago(<?php echo $pagPend[$p]["IdPago"]; ?>,1)" type="button" title="Seguimiento del pago" class="btn bg-primary btn-flat btn-sm"><i class="fa fa-fw fa-camera"></i></button>
																<?php } else { ?>
																	<button onclick="subir_mi_pago(<?php echo $pagPend[$p]["IdPago"]; ?>,1)" type="button" title="No hay información disponible" class="btn bg-orange btn-flat btn-sm"><i class="fa fa-fw fa-question-circle"></i></button>
																<?php } ?>
																<button onclick="javascript:window.open('repositorio/pdf/boucherId.php?tokenId=<?php echo time() . $pagPend[$p]["IdPago"]; ?>');" type="button" href="javascript:void(0);" title="Descargar ficha de pago" class="btn bg-navy btn-flat btn-sm"><i class="fa fa-fw fa-file-pdf-o"></i></button>
															</td>
															<td><?php echo $pagPend[$p]["NomPlan"] . $nomMat;
																if ($pagPend[$p]['IdEstatus'] == 58) {
																	$kx = 0;
																	echo "<b style='color: blue;'> - (Congelado)</b>";
																} ?> DE <?php echo fecha_pago($pagPend[$p]["Fecha"]); ?> </td>
															<td><?php echo obtenerFechaCorta($pagPend[$p]["Fecha"]); ?></td>
														</tr>
													<?php  }  ?>
												</tbody>
											</table>
											<div class="btn-group">
												<?php if ((isset($_mod13[0])) && (($kx == 1))) { ?>
													<button onclick="addPagoTodos()" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat"><i class="fa fa-fw fa-diamond"></i> Cobrar conceptos pendientes</button>
												<?php }
												if ((isset($_mod14[0])) && ($kx == 1)) { ?>
													<button onclick="javascript:window.open('repositorio/pdf/saldoTotal.php?tokenId=<?php echo time() . time() . $id; ?>');" href="javascript:void(0);" style="margin-left: 5px;" type="button" class="btn bg-maroon btn-flat"><i class="fa fa-fw fa-cloud-download"></i> Descargar pagos pendientes</button>
												<?php } ?>
											</div>
											
											<?php if(isset($donacion[0])){ ?><hr>
											<button onclick="javascript:window.open('repositorio/formatos/donacion.php?idToks=<?php echo $donacion[0]['Code']; ?>');" href="javascript:void(0);" style="margin-left: 5px;" type="button" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-cloud-download"></i> Descargar oficio de donación </button>
											<?php } else { 
											    $donacion_no_generado = $t->get_donacion_no_generado($id);
											    
											    if(isset($donacion_no_generado[0]['IdPago'])){
											        if (isset($_mod91[0])) {
											    ?>
											
											<button onclick="generar_oficio_donacion(<?php echo $donacion_no_generado[0]["IdFolio"]; ?>)" href="javascript:void(0);" style="margin-left: 5px;" type="button" class="btn bg-navy btn-flat"><i class="fa fa-fw fa-send"></i> Generar oficio de donación</button>
											
											<?php } } } ?>
											
										</div>
										<div class="tab-pane" id="timeline2">
											<div class="box">
												<div class="box-body no-padding">
													<table class="table table-striped">
														<tbody>
															<tr style="background: #c1c5ffc4;">
																<th colspan="7"><i class="fa fa-fw fa-diamond"></i> Lista de pagos aprobados del alumno </th>
															</tr>
															<tr>
																<th class="text-blue">Ajuste</th>
																<th class="text-blue">Folio</th>
																<th class="text-blue">Estatus</th>
																<th class="text-blue">Fecha pago</th>
																<th class="text-blue">Fec. Captura</th>
																<th class="text-blue">Forma pago</th>
																<th class="text-blue" style="text-align: right;">Monto</th>
															</tr>
															<?php for ($a = 0; $a < sizeof($pagApro); $a++) { ?>
																<tr <?php if ($pagApro[$a]["IdEstatus"] == 11) { ?> style="text-decoration: line-through; color: red;" <?php } ?>>
																	<td>
																		<button type="button" class="btn btn-primary btn-xs" onclick="javascript:window.open('repositorio/pdf/comprobante.php?idToks=<?php echo time() . $pagApro[$a]["NoFolio"]; ?>');" href="javascript:void(0);" title="Descargar boucher de pago"><i class="fa fa-fw fa-print"></i></button>
																		<?php if (($pagApro[$a]["Factura"] == 3) && ($pagApro[$a]["_tipo"] <> 'G')) {
																			$_mod70 = $t->get_mod_lista_id($_SESSION['IdUsua'], 70);
																			?>
																			<button type="button" class="btn btn-warning btn-xs" onclick="javascript:window.open('repositorio/pdf/mi_factura.php?idToks=<?php echo $pagApro[$a]["_codigoFactura"]; ?>');" href="javascript:void(0);" title="Descargar factura"><i class="fa fa-fw fa-file-pdf-o"></i></button>
																			<?php if(isset($_mod70[0])){ ?>
																			<button type="button" class="btn btn-danger btn-xs" onClick="window.open('cancelar_factura.php?uuid=<?php echo $pagApro[$a]["uuid"]; ?>&id=<?php echo $id; ?>','_self')" href="javascript:void(0);" title="Cancelar Factura"><i class="fa fa-fw fa-times-circle"></i></button>
																			<?php } ?>
																		<?php } ?>
																		
																	</td>
																	<td><?php echo $pagApro[$a]["NoFolio"]; ?></td>
																	<td><?php echo $pagApro[$a]["Estatus"]; ?></td>
																	<td><?php echo $pagApro[$a]["FecPago"]; ?></td>
																	<td><?php echo $pagApro[$a]["FecCap"]; ?></td>
																	<td><?php echo $pagApro[$a]["Descripcion"]; ?></td>
																	<td style="text-align: right;">$ <?php echo number_format($pagApro[$a]["Monto"], 2, '.', ','); ?></td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
											
											

										</div>
										<div class="tab-pane" id="mi_beca">
											<div class="box">
												<div class="box-body no-padding">
													<?php $_mod10 = $t->get_mod_lista_id($_SESSION['IdUsua'], 10); ?>
													<?php if (isset($beca[0]["IdBeca"])) { ?>
														<table class="table table-striped" style="font-size: 12px;">
															<tbody>
																<tr style="background: #c1c5ffc4;">
																	<th colspan="7"><i class="fa fa-fw fa-black-tie"></i> Becas activas del alumno </th>
																</tr>
																<tr>
																	<td class="text-blue"></td>
																	<td class="text-blue">Concepto</td>
																	<td class="text-blue">Beca (%)</td>
																	<td class="text-blue">Periodo escolar</td>
																	<td class="text-blue">Aplicado por</td>
																	<td class="text-blue">Estatus</td>
																	<td class="text-blue">Fecha captura</td>
																</tr>
																<?php for ($b = 0; $b < sizeof($beca); $b++) { ?>
																	<tr id="bec_<?php echo $beca[$b]["IdBeca"]; ?>">
																		<td>
																		    <?php if (isset($_mod92[0])) { ?>
																			<button onclick="addBeca(<?php echo $beca[$b]["IdBeca"]; ?>)" type="button" title="Detalle del concepto" class="btn bg-orange btn-flat btn-sm"><i class="fa fa-gear"></i></button>
																			<?php } ?>
																		</td>
																		<td><?php echo $beca[$b]["NomConcepto"]; ?></td>
																		<td><?php echo intval($beca[$b]["Porcentaje"]); ?>%</td>
																		<td><?php echo $beca[$b]["Ciclo"]; ?></td>
																		<td><?php if ($beca[$b]["Crm"] == 1) {
																				echo $beca[$b]["Nota"];
																			} else {
																				echo $beca[$b]["Nombre"] . ' ' . $beca[$b]["APaterno"] . ' ' . $beca[$b]["AMaterno"];
																			} ?></td>
																		<td><?php echo $beca[$b]["Estatus"]; ?></td>
																		<td><?php echo $beca[$b]["FecCap"]; ?></td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="col-md-9">

						</div>
					</div>
				</form>
			</section>
		</div>
		<div id="dataModal4" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-search"></i> Buscador de alumnos</h4>
					</div>
					<div class="modal-body" id="employee_detail4">

					</div>
				</div>
			</div>
		</div>
		<div id="dataModal3" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configuración de beca</h4>
					</div>
					<div class="modal-body" id="employee_detail3">

					</div>
				</div>
			</div>
		</div>

		<div id="dataModal7" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-gears"></i> Detalle del concepto</h4>
					</div>
					<div class="modal-body" id="employee_detail7">

					</div>
				</div>
			</div>
		</div>
		<div id="dataModal_del" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-trash"></i> Cancelar pago generado</h4>
					</div>
					<div class="modal-body" id="employee_detail_del">

					</div>
				</div>
			</div>
		</div>
		<div id="dataModal7T" class="modal fade bs-example-modal-lg">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-diamond"></i> Realizar el cobro de conceptos</h4>
					</div>
					<div class="modal-body" id="employee_detail7T">

					</div>
				</div>
			</div>
		</div>

		<div id="dataModal8" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-lock"></i> Configurar permisos del usuario</h4>
					</div>
					<div class="modal-body" id="employee_detail8">

					</div>
				</div>
			</div>
		</div>
		<div id="dataNewPago" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-smile-o"></i> Agregar nuevos pagos</h4>
					</div>
					<div class="modal-body" id="employee_NewPago">

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

		<div id="dataGrp" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Configuraciones generales</h4>
					</div>
					<div class="modal-body" id="employee_Grp">

					</div>
				</div>
			</div>
		</div>
		<div id="dataModalIni" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-dollar"></i> Conciliación de saldos iniciales.</h4>
					</div>
					<div class="modal-body" id="employee_detailIni">

					</div>
				</div>
			</div>
		</div>
		<div id="data_facx" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-child"></i> Datos de facturación</h4>
					</div>
					<div class="modal-body" id="employee_facx">
					</div>
				</div>
			</div>
		</div>
		<div id="data_fact_gene" class="modal fade bs-example-modal-lg">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-gears"></i> Generar factura</h4>
					</div>

					<div class="modal-body" id="employee_fact_gene">
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
				url: "formConsulta/buscar_alumno.php",
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
				url: "formConsulta/buscar_alumno.php",
				method: "POST",
				data: {},
				success: function(data) {
					$('#employee_detail4').html(data);
					$('#dataModal4').modal('show');
				}
			});
		});
	});

	function addBeca(IdBeca) {
		$.ajax({
			url: "formConsulta/configurar_beca_alumno_id_especial.php",
			method: "POST",
			data: {
				IdBeca: IdBeca
			},
			success: function(data) {
				$('#employee_detail3').html(data);
				$('#dataModal3').modal('show');
			}
		});
	}

	function del_pago_gen(Folio) {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/del_pago_folio.php",
			method: "POST",
			data: {
				Folio: Folio,
				Token: Token
			},
			success: function(data) {
				$('#employee_detail_del').html(data);
				$('#dataModal_del').modal('show');
			}
		});
	}

	function addPago(IdPago) {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/addPago.php",
			method: "POST",
			data: {
				Token: Token,
				IdPago: IdPago
			},
			success: function(data) {
				$('#employee_detail7').html(data);
				$('#dataModal7').modal('show');
			}
		});
	}

	function addPagoTodos() {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/addPagoTodos.php",
			method: "POST",
			data: {
				Token: Token
			},
			success: function(data) {
				$('#employee_detail7T').html(data);
				$('#dataModal7T').modal('show');
			}
		});
	}

	function delPago(IdPago) {
		var Token = document.getElementById("token").value;

		var TipoGuardar = "del_pago";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este pago?",
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
							IdPago: IdPago,
							Token: Token
						},
						success: function(data) {

							parent.location.href = 'cobrar.php?token=' + Token;
						}
					})

				}

			});
	}

	function addPermisos() {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/addPermiso.php",
			method: "POST",
			data: {
				Token: Token
			},
			success: function(data) {
				$('#employee_detail8').html(data);
				$('#dataModal8').modal('show');
			}
		});
	}

	function addNewPago() {
		var Token = document.getElementById("token").value;
		var IdCiclo = 0;
		$.ajax({
			//url:"formConsulta/addNewPago.php",
			url: "formConsulta/addNewPago_posgrado.php",
			method: "POST",
			data: {
				Token: Token,
				IdCiclo: IdCiclo
			},
			success: function(data) {
				$('#employee_NewPago').html(data);
				$('#dataNewPago').modal('show');
			}
		});
	}

	function changeGrupo(IdCampus, IdOferta) {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/cambiarGrupo.php",
			method: "POST",
			data: {
				Token: Token,
				IdCampus: IdCampus,
				IdOferta: IdOferta
			},
			success: function(data) {
				$('#employee_Grp').html(data);
				$('#dataGrp').modal('show');
			}
		});
	}


	function addSaldoIni() {
		var Token = document.getElementById("token").value;
		$.ajax({
			url: "formConsulta/addSaldoIni.php",
			method: "POST",
			data: {
				Token: Token
			},
			success: function(data) {
				$('#employee_detailIni').html(data);
				$('#dataModalIni').modal('show');
			}
		});
	}

	$(document).ready(function() {
		$(document).on('click', '.view_delAsignacion', function() {
			var employee_id = $(this).attr("id");
			if (employee_id != '') {
				var TipoGuardar = "del_asignacion";
				swal({
						title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente la materia de este alumno?",
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
									employee_id: employee_id
								},
								success: function(data) {
									var porciones = employee_id.split('-');
									IdMod = porciones[3];
									document.getElementById(IdMod).style.display = 'none';
									// parent.location.href='perfil.php?token=9834532145'+Id;
								}
							})

						}

					});




			}
		});
	});

	function mostrarPass() {
		document.getElementById('txtP1').style.display = 'none';
		document.getElementById('txtP2').style.display = 'block';
	}

	function subir_mi_pago(IdPago, TipoPago) {
		var Tipo = 1;
		$.ajax({
			url: "formConsulta/seguimiento_pago.php",
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

	function datos_factura_id(IdUsua) {
		$.ajax({
			url: "vistas/finanzas/datos_factura_id.php",
			method: "POST",
			data: {
				IdUsua: IdUsua
			},
			success: function(data) {
				$('#employee_facx').html(data);
				$('#data_facx').modal('show');
			}
		});
	}

	function generar_factura_id(IdUsua, NoFolio) {
		var Ubicacion = 1;
		$.ajax({
			url: "vistas/facturar/generar_factura_id.php",
			method: "POST",
			data: {
				IdUsua: IdUsua,
				NoFolio: NoFolio,
				Ubicacion: Ubicacion
			},
			success: function(data) {
				$('#employee_fact_gene').html(data);
				$('#data_fact_gene').modal('show');
			}
		});
	}

	function del_pago_id(IdPago, IdUsua) {
		var TipoGuardar = "del_pago_user";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente este pago del alumno?",
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
							url: "vistas/finanzas/sav_datos_finanzas.php",
							method: "POST",
							data: {
								TipoGuardar: TipoGuardar,
								IdPago: IdPago
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								swal("Eliminado correctamente", "El pago se ha elimninado correctamente.", "success");
								parent.location.href = 'cobrar.php?token=9845723478' + IdUsua;
							}
							
							if (data == 0) {
								swal("Error al guardar", "No se puede eliminar, verifique sus datos.", "error");
							}
						})
						.error(function(data) {
							swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
						});

				}

			});
	}
	
	function generar_oficio_donacion(IdFolio) {
		var TipoGuardar = "generar_ofocio_donacion_id";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea generar el oficio de donación de este alumno?",
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
							url: "vistas/finanzas/sav_datos_finanzas.php",
							method: "POST",
							data: {
								TipoGuardar: TipoGuardar,
								IdFolio: IdFolio
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								swal("Generado correctamente", "El oficio de donación se ha generado correctamente.", "success");
								parent.location.href = 'cobrar.php?token=9845723478' + IdUsua;
							}
							
							if (data == 0) {
								swal("Error al guardar", "No se puede generar, verifique sus datos.", "error");
							}
						})
						.error(function(data) {
							swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
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