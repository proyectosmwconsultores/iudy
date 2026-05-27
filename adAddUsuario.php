<?php $valor = 3;
$section = "Agregar usuarios";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está por agregar un nuevo usuario');
}
if (isset($_POST["Mov"]) && $_POST["Mov"] == "subExcel") {
	$t->add_excelUsuario();
	exit;
}
$lstUsers = $t->get_usersProcess($_SESSION["IdUsua"]);

$lstCampus = $t->get_campusPermiso($_SESSION['IdUsua']);
$lstOferta = $t->get_lstOTodos();
if (isset($_GET["tok"])) {
	$act1 = "class='active'";
	$act2 = "";
	$acrf1 = "active";
	$acrf2 = "";
} else {
	$act2 = "class='active'";
	$act1 = "";
	$acrf2 = "active";
	$acrf1 = "";
}

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Alta de usuarios
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
					<li class="active">Usuarios</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="adAddUsuario.php" method="POST" enctype="multipart/form-data">
					<input id="TipoGuardar" name="TipoGuardar" value="val_adAddUsuario" type="hidden" />
					<input id="Mov" name="Mov" value="<?php if (isset($_GET['Mov'])) {
															echo $_GET['Mov'];
														} ?>" type="hidden" />
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden" />
					<div class="box box-default">

						<div class="box-body">
							<div class="row">

								<div class="col-md-12">
									<div class="nav-tabs-custom">
										<ul class="nav nav-tabs">
											<li <?php echo $act2; ?>><a href="#activity" data-toggle="tab">Agregar usuario</a></li>
											<li <?php echo $act1; ?>><a href="#timeline" data-toggle="tab">Subir lista de usuarios</a></li>
										</ul>
										<div class="tab-content">
											<div class="<?php echo $acrf2; ?> tab-pane" id="activity">
												<div class="col-md-4">
													<div class="form-group">
														<label>Tipo usuario:</label>
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-user-circle"></i>
															</div>
															<select class="form-control" name="txtTipo" id="txtTipo" onchange="document.frm.submit();">
																<option value=""> - Seleccione - </option>
																<option value="1" <?php if ($_POST["txtTipo"] == 1) { ?>selected="selected" <?php } ?>> Administrador general</option>
																<option value="10" <?php if ($_POST["txtTipo"] == 10) { ?>selected="selected" <?php } ?>> Rectoría </option>
																<option value="5" <?php if ($_POST["txtTipo"] == 5) { ?>selected="selected" <?php } ?>> Director de campus </option>
																<option value="9" <?php if ($_POST["txtTipo"] == 9) { ?>selected="selected" <?php } ?>> Coordinador acad&eacute;mico </option>
																<option value="11" <?php if ($_POST["txtTipo"] == 11) { ?>selected="selected" <?php } ?>> Aux. Coordinador acad&eacute;mico </option>
																<option value="6" <?php if ($_POST["txtTipo"] == 6) { ?>selected="selected" <?php } ?>> Administración </option>
																<option value="7" <?php if ($_POST["txtTipo"] == 7) { ?>selected="selected" <?php } ?>> Gestión Escolar </option>
																<option value="13" <?php if ($_POST["txtTipo"] == 13) { ?>selected="selected" <?php } ?>> Extensión y Vinculación </option>
																<option value="8" <?php if ($_POST["txtTipo"] == 8) { ?>selected="selected" <?php } ?>> Admisiones </option>
																<option value="2" <?php if ($_POST["txtTipo"] == 2) { ?>selected="selected" <?php } ?>> Docente </option>
																<option value="4" <?php if ($_POST["txtTipo"] == 4) { ?>selected="selected" <?php } ?>> Tutor </option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Campus:</label>
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-compass"></i>
															</div>
															<select class="form-control" name="txtCampus" id="txtCampus" onchange="sel_campus()">
																<option value=""> - Seleccione - </option>
																<?php for ($i = 0; $i < sizeof($lstCampus); $i++) { ?>
																	<option value="<?php echo $lstCampus[$i]["IdCampus"]; ?>"><?php echo $lstCampus[$i]["Campus"]; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
												<?php if (isset($_POST["txtTipo"]) && ($_POST["txtTipo"] == "3")) { ?>
													<div class="col-md-4">
														<div class="form-group">
															<label>Oferta educativa:</label>
															<div class="input-group">
																<div class="input-group-addon">
																	<i class="fa fa-compass"></i>
																</div>
																<select class="form-control" name="txtOferta" id="txtOferta">
																	<option value=""> - Seleccione - </option>
																	<?php for ($i = 0; $i < sizeof($lstOferta); $i++) { ?>
																		<option value="<?php echo $lstOferta[$i]["IdEducativa"]; ?>"><?php if ($lstOferta[$i]["Nombre"]) {
																																			echo $lstOferta[$i]["Nombre"];
																																		} else {
																																			echo $lstOferta[$i]["Clave"];
																																		} ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
													</div>
												<?php } ?>

												<div class="col-md-4">
													<div class="form-group">
														<label>Nombre:</label>
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-user"></i>
															</div>
															<input class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre" type="text">
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>A. Paterno:</label>
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-user"></i>
															</div>
															<input class="form-control" id="txtAPaterno" name="txtAPaterno" placeholder="Paterno" type="text">
														</div>
													</div>
													<!-- /.box -->
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>A. Materno:</label>
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-user"></i>
															</div>
															<input class="form-control" id="txtAMaterno" name="txtAMaterno" placeholder="Materno" type="text">
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Sexo:</label>
														<div class="input-group">
															<div class="input-group-addon"><i class="fa fa-user"></i></div>
															<select class="form-control" name="txtSexo" id="txtSexo">
																<option value=""> - Seleccione - </option>
																<option value="F"> MUJER </option>
																<option value="M"> HOMBRE </option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Teléfono:</label>
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-phone"></i>
															</div>
															<input class="form-control" id="txtTelefono" name="txtTelefono" data-inputmask='"mask": "(999) 999-9999"' data-mask type="text">
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Correo:</label>
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-envelope"></i>
															</div>
															<input class="form-control" id="txtCorreo" name="txtCorreo" placeholder="Enter email" type="email">
														</div>
													</div>
												</div>

												<div class="col-md-4">
													<div class="form-group">
														<label>Usuario:</label>
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-user"></i>
															</div>
															<input class="form-control" id="txtUser" name="txtUser" placeholder="Usuario" type="text">
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Contraseña:</label>
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-key"></i>
															</div>
															<input class="form-control" id="txtPass" name="txtPass" placeholder="Password" type="text">
														</div>
													</div>
												</div>

												<div class="col-md-12">
													<div class="box-primary">
														<div class="box-body">
															<div class="box-footer" style=" text-align: center;">
																<button type="button" class="btn btn-success" onClick="val_adAddUsuario()"><i class="fa fa-fw fa-save"></i> Guardar</button>
															</div>
														</div>
													</div>
													<!-- /.box -->
												</div>

											</div>
											<div class="<?php echo $acrf1; ?> tab-pane" id="timeline">
												<div class="col-md-4">
													<div class="form-group">
														<label>Campus:</label>
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-compass"></i>
															</div>
															<select class="form-control" name="txtCampusx" id="txtCampusx">
																<option value=""> - Seleccione - </option>
																<?php for ($i = 0; $i < sizeof($lstCampus); $i++) { ?>
																	<option value="<?php echo $lstCampus[$i]["IdCampus"]; ?>"><?php echo $lstCampus[$i]["Campus"]; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>

												<div class="col-md-4">
													<div class="form-group">
														<label>Buscar archivo <b>excel(.xls)</b>:</label>
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-file-excel-o"></i>
															</div>
															<input type="file" class="form-control" name="txtArchivo" id="txtArchivo" onchange="validarExcel(this,'txtArchivo');">
														</div>
													</div>
												</div>

												<div class="col-md-4">
													<div class="form-group">
														<label>Movimiento:</label>
														<div class="input-group">
															<?php if (isset($lstUsers[0])) { ?>
																<button type="button" class="btn bg-maroon btn-flat" onClick="val_delUsuariosExc()" style="float: right; margin-right: 5px;"><i class="fa fa-trash"></i> Eliminar</button>
																<button type="button" class="btn bg-olive btn-flat" onClick="val_savUsers()" style="float: right; margin-right: 5px;"><i class="fa fa-lock"></i> Guardar usuarios</button>
															<?php } else { ?>
																<button type="button" class="btn bg-navy btn-flat" onClick="val_addExcel()" style="float: right; margin-right: 5px;"><i class="fa fa-cloud-upload"></i> Subir</button>
																<button type="button" class="btn bg-olive btn-flat" onclick="window.open('assets/carga_masiva_usuarios.xls','_blank')" href="javascript:void(0);" style="float: right; margin-right: 5px;"><i class="fa fa-file"></i> Layout excel</button>
															<?php } ?>
														</div>
													</div>
												</div>

												<div class="col-xs-12">
													<div class="form-group" name="imgLoadPagos" id="imgLoadPagos" style="display: none;">
														<div class="col-sm-12" style="text-align: center;">
															<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
														</div>
													</div>

													<div class="box">
														<div class="box-header">

															<h3 class="box-title">Lista de usuarios en proceso de alta</h3>
														</div>
														<div class="box-body">
															<table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
																<thead>
																	<tr>
																		<!-- <th>Grupo</th> -->
																		<th>#</th>
																		<th>Nombre</th>
																		<th>Permiso</th>
																		<th>Campus</th>
																		<th>Usuario</th>
																		<th>Password</th>
																		<th>Sexo</th>
																		<th>Correo</th>
																		<th>Celular</th>
																		<th>FecNac</th>
																	</tr>
																</thead>
																<tbody id="tbtabl59">
																	<?php $v = 0;
																	for ($i = 0; $i < sizeof($lstUsers); $i++) {
																	?>
																		<tr>
																			<td><?php echo $v = ($v + 1); ?>.- </td>
																			<td><?php echo $lstUsers[$i]["APaterno"] . ' ' . $lstUsers[$i]["AMaterno"] . ' ' . $lstUsers[$i]["Nombre"]; ?></td>
																			<td><?php echo $lstUsers[$i]["Permiso"]; ?></td>
																			<td><?php echo $lstUsers[$i]["Campus"]; ?></td>
																			<td><?php echo $lstUsers[$i]["Usuario"]; ?></td>
																			<td><?php echo $lstUsers[$i]["Pass"]; ?></td>
																			<td><?php echo $lstUsers[$i]["Sexo"]; ?></td>
																			<td><?php echo $lstUsers[$i]["Correo"]; ?></td>
																			<td><?php echo $lstUsers[$i]["Celular"]; ?></td>
																			<td><?php echo $lstUsers[$i]["FecNac"]; ?></td>
																		</tr>
																	<?php } ?>
																	</tfoot>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /.row -->
						</div>
					</div>
					<!-- /.box -->
				</form>
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<?php include("footer.php"); ?>
	</div>
	<!-- ./wrapper -->

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
	<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- Page script -->
	<script>
		$(function() {
			//Date picker
			$('#datepicker').datepicker({
				autoclose: true
			})
			//Money Euro
			$('[data-mask]').inputmask()
			//Timepicker
			$('.timepicker').timepicker({
				showInputs: false
			})
		})
		$(function() {
			$('#example1').DataTable()
		})

		function sel_campus() {
			var IdCampus = document.getElementById("txtCampus").value;
			var Tipo = document.getElementById("txtTipo").value;
			if (Tipo == 2) {
				document.getElementById("txtUser").disabled = true;
				var TipoGuardar = "usuario_docente";
				$.ajax({
					url: "formConsulta/setting.php",
					method: "POST",
					data: {
						TipoGuardar: TipoGuardar,
						IdCampus: IdCampus
					},
					success: function(data) {

						var IdCampus = document.getElementById("txtUser").value = data;
					}
				})
			} else {
				document.getElementById("txtUser").disabled = false;
			}


		}
	</script>
</body>

</html>