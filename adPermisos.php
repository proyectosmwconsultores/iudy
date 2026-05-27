<?php $section = "Configurar permisos";
include("head.php");
if (($_SESSION['IdUsua']) && ($_SESSION['Permisos'] == 1)) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de configuración de permisos');
}

if (isset($_POST["txtTipo"])) {
	$_POST["txtTipo"] = $_POST["txtTipo"];
} else {
	$_POST["txtTipo"] = '';
}

$lstUsers = $t->get_lstUsers($_POST["txtTipo"]);

if (isset($_POST["txtIdUsua"])) {
	$lstUserId = $t->get_usuarioId($_POST["txtIdUsua"]);
	// $lstMenu=$t->get_menu($lstUserId[{0]["Permisos"]);
	// $lstModulo=$t->get_modulo_espe();}
}

if (isset($_POST["txtIdUsua"][0])) {

	$lstMenu = $t->get_menu($lstUserId[0]["Permisos"]);
	$lstModulo = $t->get_modulo_espe();
}
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Configuración de permisos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Configuraci&oacute;n</a></li>
					<li class="active">Permisos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adPermisos.php" method="POST" enctype="multipart/form-data">
						<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden" />
						<div class="col-md-4">
							<div class="form-group">
								<label>Tipo de usuario:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-creative-commons"></i>
									</div>
									<select class="form-control select2" name="txtTipo" id="txtTipo" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<option value="1" <?php if ($_POST["txtTipo"] == 1) { ?>selected="selected" <?php } ?>> Administrador general</option>
										<option value="10" <?php if ($_POST["txtTipo"] == 10) { ?>selected="selected" <?php } ?>> Rectoría</option>
										<option value="5" <?php if ($_POST["txtTipo"] == 5) { ?>selected="selected" <?php } ?>> Director de campus </option>
										<option value="6" <?php if ($_POST["txtTipo"] == 6) { ?>selected="selected" <?php } ?>> Administraci&oacute;n </option>
										<option value="7" <?php if ($_POST["txtTipo"] == 7) { ?>selected="selected" <?php } ?>> Gesti&oacute;n escolar </option>
										<option value="8" <?php if ($_POST["txtTipo"] == 8) { ?>selected="selected" <?php } ?>> Admisiones </option>
										<option value="9" <?php if ($_POST["txtTipo"] == 9) { ?>selected="selected" <?php } ?>> Coordinador acad&eacute;mico </option>
										<option value="11" <?php if ($_POST["txtTipo"] == 11) { ?>selected="selected" <?php } ?>> Aux. Coordinador acad&eacute;mico </option>
										<option value="13" <?php if ($_POST["txtTipo"] == 13) { ?>selected="selected" <?php } ?>> Extensión y Vinculación </option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label>Nombre del usuario:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-users"></i>
									</div>
									<select class="form-control select2" name="txtIdUsua" id="txtIdUsua" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i = 0; $i < sizeof($lstUsers); $i++) { ?>
											<option value="<?php echo $lstUsers[$i]["IdUsua"]; ?>" <?php if ($_POST["txtIdUsua"] == $lstUsers[$i]["IdUsua"]) { ?>selected="selected" <?php } ?>><?php echo $lstUsers[$i]["Nombre"] . ' ' . $lstUsers[$i]["APaterno"] . ' ' . $lstUsers[$i]["AMaterno"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</form>
					<?php if ((isset($_POST["txtTipo"])) && (isset($lstUserId[0]))) { ?>
						<div class="col-md-12">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#activity" data-toggle="tab">Informaci&oacute;n general</a></li>
									<li><a href="#timeline" data-toggle="tab">Configurar acceso a m&oacute;dulos</a></li>
									<li><a href="#settings" data-toggle="tab">Configurar permisos</a></li>
									<li><a href="#permisos_especiales" data-toggle="tab">Permisos especiales</a></li>
								</ul>
								<div class="tab-content">
									<div class="active tab-pane" id="activity">
										<!-- Post -->
										<div class="post">
											<div class="user-block">
												<img class="img-circle img-bordered-sm" src="assets/perfil/<?php echo $lstUserId[0]["Foto"]; ?>" alt="user image">
												<span class="username">
													<a href="#"><?php echo $lstUserId[0]["Nombre"] . ' ' . $lstUserId[0]["APaterno"] . ' ' . $lstUserId[0]["AMaterno"]; ?></a>
													<a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
												</span>
												<span class="description">Fecha de registro: <?php echo $lstUserId[0]["FecCap"]; ?></span>
											</div>
											<form class="form-horizontal">
												<div class="form-group">
													<label for="inputName" class="col-sm-2 control-label">Nombre:</label>

													<div class="col-sm-10">
														<input class="form-control" id="inputName" placeholder="Name" type="text" value="<?php echo $lstUserId[0]["Nombre"] . ' ' . $lstUserId[0]["APaterno"] . ' ' . $lstUserId[0]["AMaterno"]; ?>" disabled>
													</div>
												</div>
												<div class="form-group">
													<label for="inputEmail" class="col-sm-2 control-label">Correo:</label>

													<div class="col-sm-10">
														<input class="form-control" id="inputEmail" placeholder="Email" type="email" value="<?php echo $lstUserId[0]["Correo"]; ?>" disabled>
													</div>
												</div>
												<div class="form-group">
													<label for="inputName" class="col-sm-2 control-label">Tel&eacute;fono</label>

													<div class="col-sm-10">
														<input class="form-control" id="inputName" placeholder="Name" type="text" value="<?php echo $lstUserId[0]["Telefono"]; ?>" disabled>
													</div>
												</div>



											</form>

										</div>
									</div>
									<!-- /.tab-pane -->
									<div class="tab-pane" id="timeline">
										<div class="box-body no-padding">

											<table id="example1" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>Folio</th>
														<th>Tipo</th>
														<th>Descripci&oacute;n</th>
														<th style="width: 50px;">Permiso</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($i = 0; $i < sizeof($lstMenu); $i++) {
														$menuId = $t->get_menuId($lstMenu[$i]["IdMenu"], $_POST["txtIdUsua"]);
														$tipo = $lstMenu[$i]["Tipo"];
														if ($tipo == "M") {
															$txtTip = "Módulo";
														} elseif ($tipo == "R") {
															$txtTip = "Reporte";
														} else {
															$txtTip = "Actualizar";
														}
													?>
														<tr>
															<td><?php echo $lstMenu[$i]["Code"]; ?></td>
															<td><?php echo $txtTip; ?></td>
															<td><?php echo $lstMenu[$i]["Nombre"]; ?></td>
															<td style="width: 50px;">
																<?php

																if (isset($menuId[0]["IdMenuUsua"])) {
																?>
																	<button id="btnActivo-<?php echo $lstMenu[$i]["IdMenu"]; ?>" onclick="accesoModulo(<?php echo $lstMenu[$i]["IdMenu"]; ?>,<?php echo $_POST["txtIdUsua"]; ?>, 0)" type="button" class="btn btn-block btn-success btn-xs"><i class="fa fa-fw fa-check-circle"></i> Activo</button>
																	<button style="display: none;" id="btnInactivo-<?php echo $lstMenu[$i]["IdMenu"]; ?>" style="width: 50%;" onclick="accesoModulo(<?php echo $lstMenu[$i]["IdMenu"]; ?>,<?php echo $_POST["txtIdUsua"]; ?>, 1)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-times-circle"></i> Inactivo</button>

																<?php } else { ?>
																	<button style="display: none;" id="btnActivo-<?php echo $lstMenu[$i]["IdMenu"]; ?>" style="width: 50%;" onclick="accesoModulo(<?php echo $lstMenu[$i]["IdMenu"]; ?>,<?php echo $_POST["txtIdUsua"]; ?>, 0)" type="button" class="btn btn-block btn-success btn-xs"><i class="fa fa-fw fa-check-circle"></i> Activo</button>
																	<button id="btnInactivo-<?php echo $lstMenu[$i]["IdMenu"]; ?>" onclick="accesoModulo(<?php echo $lstMenu[$i]["IdMenu"]; ?>,<?php echo $_POST["txtIdUsua"]; ?>, 1)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-times-circle"></i> Inactivo</button>
																<?php }

																?>
															</td>

														</tr>
													<?php } ?>
													</tfoot>
											</table>
										</div>
									</div>
									<!-- /.tab-pane -->

									<div class="tab-pane" id="settings">
										<?php $lstCampus = $t->get_lstCampusAc(); ?>
										<form class="form-horizontal">
											<table class="table table-hover">
												<tbody>
													<tr>
														<th>Campus</th>
														<th>Planeaci&oacute;n</th>
														<th>Carrera</th>

													</tr>
													<?php for ($i = 0; $i < sizeof($lstCampus); $i++) { ?>
														<tr style="background: #aad3ff;">
															<td colspan="3"><i class="fa fa-flag"></i> <?php echo $lstCampus[$i]["Campus"]; ?></td>
														</tr>
														<?php $lstOfert = $t->get_lstOfertCam($lstCampus[$i]["IdCampus"]);
														if (isset($lstOfert[0])) { ?>
															<?php for ($v = 0; $v < sizeof($lstOfert); $v++) {
																$permiAct = $t->get_permiActiId($lstOfert[$v]["IdEducativa"], $_POST["txtIdUsua"], $lstCampus[$i]["IdCampus"]);
																if (isset($permiAct[0]["IdCoordinador"])) {
																	$IdCoo = $permiAct[0]["IdCoordinador"];
																	$xolA = "block";
																	$xolI = "none";
																} else {
																	$IdCoo = 0;
																	$xolA = "none;";
																	$xolI = "block;";
																}
															?>
																<tr>
																	<td></td>
																	<td><?php echo $lstOfert[$v]["Nombre"]; ?></td>
																	<td>
																		<button id="btnA-<?php echo $lstOfert[$v]["IdGrupo"]; ?>" onclick="activarCampus(<?php echo $lstOfert[$v]['IdEducativa']; ?>,0,<?php echo $IdCoo; ?>,<?php echo $lstOfert[$v]['IdGrupo']; ?>,<?php echo $_POST['txtIdUsua']; ?>,<?php echo $lstCampus[$i]['IdCampus']; ?>)" style="display: <?php echo $xolA; ?>;" type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>
																		<button id="btnI-<?php echo $lstOfert[$v]["IdGrupo"]; ?>" onclick="activarCampus(<?php echo $lstOfert[$v]['IdEducativa']; ?>,1,<?php echo $IdCoo; ?>,<?php echo $lstOfert[$v]['IdGrupo']; ?>,<?php echo $_POST['txtIdUsua']; ?>,<?php echo $lstCampus[$i]['IdCampus']; ?>)" style="display: <?php echo $xolI; ?>;" type="button" class="btn btn-default"><i class="fa fa-times-circle"></i></button>
																	</td>
																</tr>
															<?php }
															?>
														<?php } ?>
													<?php } ?>

												</tbody>
											</table>
										</form>
									</div>

									<div class="tab-pane" id="permisos_especiales">
										<div class="box-body no-padding">
											<table id="example2" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>Módulo</th>
														<th>Descripci&oacute;n</th>
														<th style="width: 50px;">Permiso</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($m = 0; $m < sizeof($lstModulo); $m++) {
														$menuId = $t->get_modulo_id($lstModulo[$m]["IdModulo"], $_POST["txtIdUsua"]); ?>
														<tr>
															<td><?php echo $lstModulo[$m]["Modulo"]; ?></td>
															<td><?php echo $lstModulo[$m]["Nombre"]; ?></td>
															<td style="width: 50px;">
																<?php
																if (isset($menuId[0]["IdModUsua"])) { ?>
																	<button id="btnActivo2-<?php echo $lstModulo[$m]["IdModulo"]; ?>" onclick="accesoModEsp(<?php echo $lstModulo[$m]["IdModulo"]; ?>,<?php echo $_POST["txtIdUsua"]; ?>, 0)" type="button" class="btn btn-block btn-success btn-xs"><i class="fa fa-fw fa-check-circle"></i> Activo</button>
																	<button style="display: none;" id="btnInactivo2-<?php echo $lstModulo[$m]["IdModulo"]; ?>" style="width: 50%;" onclick="accesoModEsp(<?php echo $lstModulo[$m]["IdModulo"]; ?>,<?php echo $_POST["txtIdUsua"]; ?>, 1)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-times-circle"></i> Inactivo</button>
																<?php } else { ?>
																	<button style="display: none;" id="btnActivo2-<?php echo $lstModulo[$m]["IdModulo"]; ?>" style="width: 50%;" onclick="accesoModEsp(<?php echo $lstModulo[$m]["IdModulo"]; ?>,<?php echo $_POST["txtIdUsua"]; ?>, 0)" type="button" class="btn btn-block btn-success btn-xs"><i class="fa fa-fw fa-check-circle"></i> Activo</button>
																	<button id="btnInactivo2-<?php echo $lstModulo[$m]["IdModulo"]; ?>" onclick="accesoModEsp(<?php echo $lstModulo[$m]["IdModulo"]; ?>,<?php echo $_POST["txtIdUsua"]; ?>, 1)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-times-circle"></i> Inactivo</button>
																<?php } ?>
															</td>
														</tr>
													<?php } ?>
													</tfoot>
											</table>
										</div>
									</div>
									<!-- /.tab-pane -->
								</div>
								<!-- /.tab-content -->
							</div>
							<!-- /.nav-tabs-custom -->
						</div>
					<?php } ?>

				</div>
			</section>
		</div>
		<?php include("footer.php"); ?>
	</div>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>

<!-- InputMask -->
<!-- <script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script> -->
<!-- date-range-picker -->
<!-- <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> -->
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<!-- <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script> -->
<!-- bootstrap time picker-->
<!-- <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script> -->
<!-- SlimScroll
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1
<script src="bower_components/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
	function accesoModulo(IdMenu, IdUsua, Movimiento) {
		var Texto1 = "";
		var BtnAct = "";
		var BtnIna = "";
		var BtnDisplayAct = "";
		var BtnDisplayInac = "";

		if (Movimiento == 1) {
			BtnAct = "btnActivo-" + IdMenu;
			BtnIna = "btnInactivo-" + IdMenu;
			Texto1 = "activar esta opci\u00F3n";
			BtnDisplayAct = "block";
			BtnDisplayInac = "none";

		} else {
			BtnAct = "btnActivo-" + IdMenu;
			BtnIna = "btnInactivo-" + IdMenu;
			Texto1 = "desactivar esta opci\u00F3n";
			BtnDisplayAct = "none";
			BtnDisplayInac = "block";
		}


		var TipoGuardar = "configMenu";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea " + Texto1,
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
							IdUsua: IdUsua,
							IdMenu: IdMenu,
							Movimiento: Movimiento
						},
						success: function(data) {
							if (data == 1) {
								document.getElementById(BtnAct).style.display = BtnDisplayAct;

								document.getElementById(BtnIna).style.display = BtnDisplayInac;
							}
						}
					})
				}
			});
	}

	function accesoModEsp(IdMenu, IdUsua, Movimiento) {
		var Texto1 = "";
		var BtnAct = "";
		var BtnIna = "";
		var BtnDisplayAct = "";
		var BtnDisplayInac = "";

		if (Movimiento == 1) {
			BtnAct = "btnActivo2-" + IdMenu;
			BtnIna = "btnInactivo2-" + IdMenu;
			Texto1 = "activar esta opci\u00F3n";
			BtnDisplayAct = "block";
			BtnDisplayInac = "none";

		} else {
			BtnAct = "btnActivo2-" + IdMenu;
			BtnIna = "btnInactivo2-" + IdMenu;
			Texto1 = "desactivar esta opci\u00F3n";
			BtnDisplayAct = "none";
			BtnDisplayInac = "block";
		}


		var TipoGuardar = "configModEsp";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea " + Texto1,
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
							IdUsua: IdUsua,
							IdMenu: IdMenu,
							Movimiento: Movimiento
						},
						success: function(data) {
							if (data == 1) {
								document.getElementById(BtnAct).style.display = BtnDisplayAct;

								document.getElementById(BtnIna).style.display = BtnDisplayInac;
							}
						}
					})
				}
			});
	}


	function activarCampus(IdOferta, Movimiento, IdCoo, IdModulo, IdUsua, IdCampus) {

		var Texto1 = "";
		var BtnAct = "";
		var BtnIna = "";
		var BtnDisplayAct = "";
		var BtnDisplayInac = "";

		if (Movimiento == 1) {
			BtnAct = "btnA-" + IdModulo;
			BtnIna = "btnI-" + IdModulo;
			Texto1 = "activar esta planeaci\u00F3n a este usuario?";
			BtnDisplayAct = "block";
			BtnDisplayInac = "none";

		} else {
			BtnAct = "btnA-" + IdModulo;
			BtnIna = "btnI-" + IdModulo;
			Texto1 = "desactivar esta planeaci\u00F3n a este usuario?";
			BtnDisplayAct = "none";
			BtnDisplayInac = "block";
		}


		var TipoGuardar = "actCampusMov";
		$.ajax({
			url: "formConsulta/setting.php",
			method: "POST",
			data: {
				TipoGuardar: TipoGuardar,
				IdUsua: IdUsua,
				IdOferta: IdOferta,
				Movimiento: Movimiento,
				IdCoo: IdCoo,
				IdCampus: IdCampus
			},
			success: function(data) {
				if (data == 1) {
					document.getElementById(BtnAct).style.display = BtnDisplayAct;

					document.getElementById(BtnIna).style.display = BtnDisplayInac;
				}
			}
		})

		// swal({
		// 	title: "\u00BFEst\u00E1 seguro que desea " + Texto1,
		// 	type: "warning",
		// 	showCancelButton: true,
		// 	confirmButtonColor: '#DD6B55',
		// 	confirmButtonText: 'Aceptar',
		// 	cancelButtonText: "Cancelar",
		// },
		// function (isConfirm) {
		// 	if(isConfirm) {
		// 		$(".confirm").attr('disabled', 'disabled');
		//
		// 	}
		// });
	}




	$(function() {
		$('.select2').select2()

	})

	$(function() {
		$('#example1').DataTable()
	})
	$(function() {
		$('#example2').DataTable()
	})
</script>
</body>

</html>