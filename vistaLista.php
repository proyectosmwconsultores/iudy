<?php $section = "Pasar lista"; $_v = 94; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de pasar lista'); }
if($_SESSION['Permisos']) {
	$aniomes = date("Y-m");
  $dia = date("d");
		$AsignacionId=$t->get_datosModuloD($_GET['idToks']);
		$listaAsistencia=$t->get_listaAsistenciaMes($_GET['idToks'],$_GET['tipo']);
		$listaMeses=$t->get_listaMeses($_GET['idToks']);
	//	$grupo=$t->get_grupoActivo($tipoDatos[0]["IdEducativa"],$tipoDatos[0]["IdModulo"],$AsignacionId[0]["Grupo"],$_SESSION['IdAsignacion']);


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
		<div class="wrapper">
		<?php include("menuV.php"); ?>
			<div class="content-wrapper">
				<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
				<section class="content-header">
					<h1> <?php echo $AsignacionId[0]["NombreMod"];?></h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i><?php echo substr($AsignacionId[0]["NombreMod"], 0 , 40).' [...]';?></a></li>
						<li class="active"><a href="#">Pasar lista</a></li>
					</ol>

				</section>
				<section class="content">
					<div class="row">
						<form name="frm" id="frm" action="doEjecutarLista.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-12">

								<div class="nav-tabs-custom">
									<div class="tab-content">
										<div class="active tab-pane" id="activity">
											<div class="box">
												<div class="col-md-10">
													<div class="box-header with-border">
														<blockquote>
							                <p>Lista de asistencia</p>
							                <small><?php echo obtenerAnioMes($listaMeses[0]["AnioMes"]); ?></small>
							              </blockquote>
													</div>
												</div>
												<div class="col-md-2">
													<div class="box-header with-border">
															<a class="btn btn-app" onclick="window.open('doEjecutarLista.php?idToks=<?php echo $_GET['idToks']; ?>','_self')" href="javascript:void(0);">
							                <i class="fa fa-reply-all"></i> Regresar </a>
													</div>
												</div>


												<div class="box-body">
													<table id="example1" class="table table-bordered table-striped">
														<thead>
															<tr style="background: #9c9c9c;">
																<td style="font-size: 12px; width: 10px; text-align: center;">#</td>
																<td style="font-size: 12px;" width="50px">Foto</td>
																<td style="font-size: 12px;">Nombre del alumno <?php echo $listaAsistencia[0]["1"] ?></td>
																<?php if($listaAsistencia[0][1]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-01'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][2]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-02'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][3]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-03'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][4]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-04'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][5]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-05'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][6]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-06'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][7]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-07'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][8]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-08'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][9]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-09'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][10]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-10'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][11]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-11'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][12]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-12'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][13]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-13'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][14]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-14'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][15]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-15'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][16]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-16'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][17]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-17'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][18]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-18'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][19]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-19'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][20]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-20'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][21]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-21'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][22]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-22'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][23]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-23'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][24]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-24'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][25]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-25'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][26]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-26'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][27]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-27'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][28]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-28'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][29]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-29'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][30]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-30'); ?></td> <?php } ?>
																<?php if($listaAsistencia[0][31]) { ?> <td style="font-size: 10px; text-align: center;"><?php echo obtenerFecLista($aniomes.'-31'); ?></td> <?php } ?>
															</tr>
														</thead>
														<tbody>
															<?php
															$tT30 = '';
															$c = 0; for ($i=0;$i< sizeof($listaAsistencia);$i++) { ?>
															<tr>
																<td style="text-align: center;"><?php echo $c = $c + 1; ?></td>
																<td>
              												<img width="35px;" src="assets/perfil/<?php echo $listaAsistencia[$i]["Foto"]; ?>" class="user-image" alt="User Image">
																</td>
																<td style="font-size: 12px;"><?php echo $listaAsistencia[$i]["APaterno"].' '.$listaAsistencia[$i]["AMaterno"].' '.$listaAsistencia[$i]["Nombre"]; ?></td>
																<?php if($listaAsistencia[$i][1]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][1]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][2]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][2]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][3]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][3]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][4]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][4]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][5]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][5]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][6]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][6]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][7]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][7]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][8]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][8]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][9]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][9]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][10]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][10]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][11]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][11]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][12]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][12]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][13]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][13]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][14]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][14]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][15]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][15]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][16]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][16]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][17]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][17]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][18]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][18]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][19]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][19]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][20]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][20]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][21]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][21]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][22]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][22]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][23]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][23]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][24]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][24]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][25]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][25]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][26]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][26]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][27]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][27]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][28]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][28]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][29]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][29]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][30]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][30]; ?></td><?php } ?>
																<?php if($listaAsistencia[$i][31]) { ?><td style="font-size: 10px; text-align: center;"><?php echo $listaAsistencia[$i][31]; ?></td><?php } ?>
															</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</section>
		</div>
	<?php include("footer.php"); ?>
	</div>
	<!-- jQuery 3 -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Select2 -->
	<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
	<!-- InputMask -->
	<script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
	<script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<!-- date-range-picker -->
	<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap datepicker -->
	<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<!-- bootstrap color picker -->
	<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
	<!-- bootstrap time picker -->
	<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>


	</body>
</html>
<?php


} else {
echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
