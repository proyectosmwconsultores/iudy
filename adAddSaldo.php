<?php $valor = 2;
$section = "Alta de saldos";
include("head.php");
if (($_SESSION['IdUsua']) && ($_SESSION['Permisos'])) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de alta de saldos');
}

if (isset($_POST["Mov"]) && $_POST["Mov"] == "Guardar") {
	$t->add_Modulo();
	exit;
}

$catSaldo = $t->get_catSaldo($_SESSION['IdUsua']);

if (isset($_POST["Mov"]) && $_POST["Mov"] == "subExcel") {
	$t->add_excelSaldo();
	exit;
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
					Carga de saldos iniciales
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-bars"></i> Saldos</a></li>
					<li class="active">Saldos iniciales</li>
				</ol>
			</section>

			<section class="content">
				<form name="frm" id="frm" action="adAddSaldo.php" method="POST" enctype="multipart/form-data">
					<input id="TipoGuardar" name="TipoGuardar" value="val_adAddModulo" type="hidden" />
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden" />
					<input id="IdPermiso" name="IdPermiso" value="<?php echo $_SESSION['Permisos']; ?>" type="hidden" />
					<!-- <input id="IdOferta" name="IdOferta" value="<?php echo $_POST['txtOferta']; ?>" type="hidden"/> -->
					<input id="Mov" name="Mov" value="" type="hidden" />

					<div class="box box-default color-palette-box">
						<div class="box-header with-border">
							<h3 class="box-title"><i class="fa fa-tag"></i> Carga de saldos iniciales</h3>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label>Buscar archivo <b>excel(.xls)</b>:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-file-excel-o"></i>
											</div>
											<input type="file" class="form-control" name="txtArchivo" id="txtArchivo" onchange="validarExcel(this,'txtArchivo');">
											<span class="input-group-btn">
												<button type="button" class="btn btn-info btn-flat" onClick="val_addSaldo()"><i class="fa fa-cloud-upload"></i> Subir saldo</button>
												<button type="button" class="btn bg-olive btn-flat" onclick="window.open('assets/carga_saldo.xls','_blank')" href="javascript:void(0);" style="margin-right: 5px;"><i class="fa fa-clipboard"></i> Layout</button>
											</span>
										</div>

									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group" name="imgLoadPagos" id="imgLoadPagos" style="display: none;">
										<div class="col-sm-12" style="text-align: center;">
											<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
										</div>
									</div>
								</div>
								<div class="col-xs-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Lista de usuarios con saldos en proceso de alta</h3>
										</div>
										<div class="box-body">
											<table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
												<thead>
													<tr>
														<th>MATRÍCULA</th>
														<th>NOMBRE</th>
														<th>FECHA</th>
														<th>OFERTA EDUCATIVA</th>
														<th>DESCRIPCIÓN</th>
														<th>MONTO</th>
													</tr>
												</thead>
												<tbody id="trLine60">
													<?php $aluSIn = 0;
													$aluAct = 0;
													for ($i = 0; $i < sizeof($catSaldo); $i++) {
														$sty = "";
														if ($catSaldo[$i]["IdEstatus"] == 29) {
															$aluSIn = ($aluSIn + 1);
															$sty = "style = 'background: red;'";
														} else {
															$aluAct = ($aluAct + 1);
														} ?>
														<tr <?php echo $sty; ?>>
															<td><?php echo $catSaldo[$i]["Matricula"]; ?></td>
															<td <?php if (!$catSaldo[$i]["Nombre"]) {
																	echo "style='background: red'; ";
																} ?>><?php echo $catSaldo[$i]["Nombre"] . ' ' . $catSaldo[$i]["APaterno"] . ' ' . $catSaldo[$i]["AMaterno"]; ?></td>
															<td <?php if (!$catSaldo[$i]["Nombre"]) {
																	echo "style='background: red'; ";
																} ?>><?php echo $catSaldo[$i]["Fecha"]; ?></td>
															<td <?php if (!$catSaldo[$i]["Nombre"]) {
																	echo "style='background: red'; ";
																} ?>><?php echo $catSaldo[$i]["NomEducativa"]; ?></td>
															<td <?php if (!$catSaldo[$i]["Nombre"]) {
																	echo "style='background: red'; ";
																} ?>><?php echo $catSaldo[$i]["Descripcion"]; ?></td>
															<td <?php if (!$catSaldo[$i]["Nombre"]) {
																	echo "style='background: red'; ";
																} ?>>$ <?php echo number_format($catSaldo[$i]["Deuda"], 2, '.', ','); ?></td>
														</tr>
													<?php } ?>
													</tfoot>
											</table>
											<br>
											<br>
											<table class="table table-striped">
												<tbody>
													<tr>
														<td style="text-align: right;"><b>Alumnos identificados:</b></td>
														<td><?php echo $aluAct; ?></td>
														<td></td>
													</tr>
													<tr>
														<td style="text-align: right;"><b>Alumnos SIN identificados:</b></td>
														<td><?php echo $aluSIn; ?></td>
														<td></td>
													</tr>
													<tr>
														<td colspan="3">
															<div class="col-md-4">
																<div class="form-group">
																	<label>Movimiento:</label>
																	<div class="input-group">
																		<button type="button" class="btn bg-red btn-flat" onClick="val_delSaldo()" style="float: right; margin-right: 5px;"><i class="fa fa-trash"></i> Eliminar registros</button>
																		<button type="button" class="btn bg-green btn-flat" onClick="val_insertSaldo()" style="float: right; margin-right: 5px;"><i class="fa fa-lock"></i> Guardar saldos</button>
																	</div>
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
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
	<script>
		$(function() {
			//Initialize Select2 Elements
			$('.select2').select2()

			//Datemask dd/mm/yyyy
			$('#datemask').inputmask('dd/mm/yyyy', {
				'placeholder': 'dd/mm/yyyy'
			})
			//Datemask2 mm/dd/yyyy
			$('#datemask2').inputmask('mm/dd/yyyy', {
				'placeholder': 'mm/dd/yyyy'
			})
			//Money Euro
			$('[data-mask]').inputmask()



			//Date picker
			$('#datepicker').datepicker({
				autoclose: true
			})

			//Timepicker
			$('.timepicker').timepicker({
				showInputs: false
			})
		})

		$(function() {
			$('#example1').DataTable()
		})
	</script>
</body>

</html>
<?php unset($_SESSION['Alerta']);
unset($_SESSION['Variable']); ?>