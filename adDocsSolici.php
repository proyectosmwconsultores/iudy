<?php $section = "Configurar documentos solicitados";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está por configurar los documentos solicitados');
}

if (isset($_GET["Grado"])) {
	$_POST["txtGrado"] = $_GET["Grado"];
}
if (isset($_POST["txtGrado"])) {
	$_POST["txtGrado"] = $_POST["txtGrado"];
} else {
	$_POST["txtGrado"] = '';
}

$grado = $t->get_gradoEs();
$lstDosSolicitados = $t->get_docsGrado($_POST["txtGrado"]);
$lstDos = $t->get_misdocsGrado($_POST["txtGrado"]);

$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));


?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-cog"></i> Configuraci&oacute;n de documentos solicitados
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Configuraci&oacute;n</a></li>
					<li class="active">Documentos solicitados</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="adDocsSolici.php" method="POST" enctype="multipart/form-data">
					<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden" />
					<input id="TipoGuardar" name="TipoGuardar" value="addMatricula" type="hidden" />
					<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden" />
					<input id="Numero" name="Numero" value="9" type="hidden" />
					<input id="Nombre" name="Nombre" value="Reporte de matrículas por grupo" type="hidden" />
					<div class="box box-default">
						<div class="box-body">
							<div class="row">
								<div class="col-md-2">
									<div class="box-primary">
										<div class="box-body">
											<a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
												<i class="fa fa-rotate-left"></i> Regresar
											</a>
											<!-- <a class="btn btn-app" href="javascript:void(0);" onclick="activarMod()">
	                    <i class="fa fa-file"></i> Nuevo
	                  </a> -->
										</div>
									</div>
								</div>




								<div class="col-md-4">
									<div class="box-primary">
										<div class="box-body">
											<div class="form-group">
												<label>Grado de estudio:</label>
												<div class="input-group">
													<div class="input-group-addon"><i class="fa fa-book"></i></div>
													<select class="form-control" name="txtGrado" id="txtGrado" onchange="document.frm.submit();">
														<option value=""> - Seleccione - </option>
														<?php for ($i = 0; $i < sizeof($grado); $i++) { ?>
															<option value="<?php echo $grado[$i]["IdGrado"]; ?>" <?php if ($_POST["txtGrado"] == $grado[$i]["IdGrado"]) {  ?>selected="selected" <?php } ?>><?php echo $grado[$i]["Descripcion"]; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php if (isset($_POST["txtGrado"])) { ?>
									<div class="col-md-6">
										<div class="box-primary">
											<div class="box-body">
												<div class="form-group">
													<label>Nombre del documento:</label>
													<div class="input-group">
														<input class="form-control" id="txtNombre" name="txtNombre" type="text" />
														<span class="input-group-btn">
															<button type="button" class="btn btn-success btn-flat" onclick="saveNewDocs(this,txtNombre)"><i class="fa fa-save"></i> Guardar</button>
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
								<div class="col-md-12">
									<div class="box">
										<div class="box-body">
											<div class="table-responsive">
												<table id="example" class="table table-striped table-bordered table-hover dataTables-example">
													<thead>
														<tr>
															<th style="text-align: center">Estatus del documento</th>
															<th style="text-align: center">Documento que debe de subir </th>
															<th>Nombre</th>
														</tr>
													</thead>
													<tbody>
														<?php if (isset($lstDos[0])) {
															for ($i = 0; $i < sizeof($lstDos); $i++) {
																$Id = $lstDos[$i]["IdTipoDoc"]; ?>
																<tr>
																	<td style="text-align: center; width: 150px;">
																		<input style="cursor: pointer;" <?php if ($lstDos[$i]['IdEstatus'] == 8) { ?>checked="true" <?php } ?> class="minimal" type="checkbox" name="txtIdDocs-<?php echo $Id; ?>" id="txtIdDocs-<?php echo $Id; ?>" onClick="val_TipoFolio(<?php echo $Id; ?>)">
																	</td>
																	<td style="text-align: center; width: 150px;">
																		<input style="cursor: pointer;" <?php if ($lstDos[$i]['Solicitado'] == 1) { ?>checked="true" <?php } ?> class="minimal" type="checkbox" name="txtIdDocs-<?php echo $Id; ?>" id="txtIdDocs-<?php echo $Id; ?>" onClick="val_solicitadoFolio(<?php echo $Id; ?>)">
																	</td>
																	<td><?php echo $lstDos[$i]["Nombre"]; ?></td>
																</tr>
														<?php }
														} ?>
														</tfoot>
												</table>
											</div>
										</div>
									</div>


								</div>
							</div>
						</div>
					</div>

				</form>
			</section>

		</div>

		<!-- Mainly scripts -->
		<script src="assets/table/js/jquery-3.1.1.min.js"></script>
		<script src="assets/table/js/bootstrap.min.js"></script>
		<script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
		<!-- Custom and plugin javascript -->
		<script src="assets/table/js/scriptAgregado1.js"></script>

		<?php include("footer.php"); ?>
	</div>
	<script>
		function activarMod() {
			document.getElementById("newDoc").style.display = 'block';
		}

		function val_solicitadoFolio(valor) {

			var pagar = document.getElementById("txtIdDocs-" + valor).checked;
			var Grado = document.getElementById("txtGrado").value;
			if (pagar == true) {
				var numero = 1;
				$.post("formConsulta/updDocsSolicitado.php", {
					valor: valor,
					numero: numero,
					Grado: Grado
				}, function(data) {});
			} else if (pagar == false) {
				var numero = 0;
				$.post("formConsulta/updDocsSolicitado.php", {
					valor: valor,
					numero: numero,
					Grado: Grado
				}, function(data) {});
			}



		}

		function val_TipoFolio(valor) {

			var pagar = document.getElementById("txtIdDocs-" + valor).checked;
			var Grado = document.getElementById("txtGrado").value;
			if (pagar == true) {
				var numero = 8;
				$.post("formConsulta/updDocs.php", {
					valor: valor,
					numero: numero,
					Grado: Grado
				}, function(data) {});
			} else if (pagar == false) {
				var numero = 9;
				$.post("formConsulta/updDocs.php", {
					valor: valor,
					numero: numero,
					Grado: Grado
				}, function(data) {});
			}



		}
	</script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- Page script -->
</body>

</html>
<?php unset($_SESSION['Alerta']);  ?>