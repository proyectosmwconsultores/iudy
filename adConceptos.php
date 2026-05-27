<?php $section = "Configurar conceptos de pagos";
include("head.php");
if (($_SESSION['IdUsua']) && ($_SESSION['Permisos'])) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está por configurar los conceptos de pago');
}

$conceptos = $t->get_conceptosLst();
if (isset($_POST["txt_camps"])) {
	$lstConceptos = $t->get_concepPlagT($_POST["txt_camps"]);
}
$campus = $t->get_campusPermiso($_SESSION['IdUsua']);
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));

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
					<i class="fa fa-fw fa-gears"></i> Configuraci&oacute;n de conceptos de pago
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Configuraci&oacute;n</a></li>
					<li class="active">Conceptos de pago</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="adConceptos.php" method="POST" enctype="multipart/form-data">
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden" />
					<div class="box box-default">
						<div class="box-body">
							<div class="row">
								<div class="col-md-4">
									<div class="box-primary">
										<div class="box-body">
											<a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
												<i class="fa fa-rotate-left"></i> Regresar
											</a>
											<a class="btn btn-app" href="javascript:void(0);" onclick="nuevo_concepto(<?php echo $_SESSION['IdUsua']; ?>)" title="Crear un nuevo plan de concepto de pago">
												<i class="fa fa-file"></i> Nuevo
											</a>

										</div>
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<label>Nivel de estudios:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-gears"></i>
											</div>
											<select class="form-control" name="txt_camps" id="txt_camps" onchange="document.frm.submit();">
												<option value="">- Seleccione - </option>
												<option value="1" <?php if (isset($_POST["txt_camps"])) { if ($_POST["txt_camps"] == 1) { ?>selected="selected" <?php } } ?>> DOCTORADO </option>
												<option value="2" <?php if (isset($_POST["txt_camps"])) { if ($_POST["txt_camps"] == 2) { ?>selected="selected" <?php } } ?>> MAESTRÍA </option>
												<option value="3" <?php if (isset($_POST["txt_camps"])) { if ($_POST["txt_camps"] == 3) { ?>selected="selected" <?php } } ?>> LICENCIATURA </option>
												<option value="4" <?php if (isset($_POST["txt_camps"])) { if ($_POST["txt_camps"] == 4) { ?>selected="selected" <?php } } ?>> BACHILLERATO </option>
												<option value="7" <?php if (isset($_POST["txt_camps"])) { if ($_POST["txt_camps"] == 7) { ?>selected="selected" <?php } } ?>> DIPLOMADO </option>
												<option value="8" <?php if (isset($_POST["txt_camps"])) { if ($_POST["txt_camps"] == 8) { ?>selected="selected" <?php } } ?>> CURSOS </option>
												<option value="9" <?php if (isset($_POST["txt_camps"])) { if ($_POST["txt_camps"] == 9) { ?>selected="selected" <?php } } ?>> CERTIFICACION </option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="box">
										<div class="box-body">
											<div class="table-responsive">
												<?php if (isset($lstConceptos[0]["IdConceptoPlanes"])) { ?>
													<table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
														<thead>
															<tr>
																<th>AJUSTES</th>
																<th>TIPO CONCEPTO</th>
																<th>NOMBRE DEL PLAN DE PAGO</th>
																<th>COSTO</th>
																<th>RECARGO</th>
															</tr>
														</thead>
														<tbody>
															<?php for ($i = 0; $i < sizeof($lstConceptos); $i++) {
																$IdConc = $lstConceptos[$i]["IdConceptoPlanes"]; ?>
																<tr>
																	<td>
																		<button onclick="verificar_oferta(<?php echo $lstConceptos[$i]["IdConceptoPlanes"] . ',' . $lstConceptos[$i]["IdCampus"]; ?>)" title="Verificaciones de ofertas educativas" type="button" class="btn bg-purple btn-flat btn-sm" href="javascript:void(0);"><i class="fa fa-fw fa-cube"></i></button>
																		<button onclick="editar_concepto(<?php echo $lstConceptos[$i]["IdConceptoPlanes"]; ?>)" title="Editar plan de concepto" type="button" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-fw fa-edit"></i></button>
																		<?php if($lstConceptos[$i]["Code"] == 1) { ?>
																		<button onclick="config_costo(<?php echo $lstConceptos[$i]["IdConceptoPlanes"]; ?>)" title="Editar plan de concepto" type="button" class="btn bg-olive btn-flat btn-sm"><i class="fa fa-fw fa-code-fork"></i></button>
																		<?php } ?>
																	</td>
																	<td><?php echo $lstConceptos[$i]["NomConcepto"]; ?></td>
																	<td><?php echo $lstConceptos[$i]["NomPlan"]; ?></td>
																	<td>$ <?php echo number_format($lstConceptos[$i]["Costo"], 2, '.', ','); ?></td>
																	<td><?php echo $lstConceptos[$i]["Recargo"]; ?> %</td>
																</tr>
															<?php } ?>
															</tfoot>
													</table>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</form>
			</section>
			<div id="dataModal3" class="modal fade">
				<!--MODAL ME GUSTA-->
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Planes de estudios agregados</h4>
						</div>
						<div class="modal-body" id="employee_detail3">

						</div>
					</div>
				</div>
			</div>
			<div id="dataModal_3" class="modal fade">
				<!--MODAL ME GUSTA-->
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Actualización planes de pago</h4>
						</div>
						<div class="modal-body" id="employee_detail_3">

						</div>
					</div>
				</div>
			</div>
			<div id="dataModal_5" class="modal fade">
				<!--MODAL ME GUSTA-->
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar planes de pago</h4>
						</div>
						<div class="modal-body" id="employee_detail_5">

						</div>
					</div>
				</div>
			</div>
			<div id="dataModal_4" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Creación de nuevos planes de pago</h4>
						</div>
						<div class="modal-body" id="employee_detail_4">
						</div>
					</div>
				</div>
			</div>

		</div>
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2 -->
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>


		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>

		<!-- DataTables -->
		<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

		<?php include("footer.php"); ?>
	</div>
	<script>
		function nuevo_concepto(IdUsua) {
			var IdCampus = 0;
			var IdOferta = 0;
			$.ajax({
				url: "formConsulta/nuevo_plan_pago.php",
				method: "POST",
				data: {
					IdUsua: IdUsua,
					IdCampus: IdCampus,
					IdOferta: IdOferta
				},
				success: function(data) {
					$('#employee_detail_4').html(data);
					$('#dataModal_4').modal('show');
				}
			});
		}

		function editar_concepto(IdConceptoPlan) {
			$.ajax({
				url: "formConsulta/upd_conceptos.php",
				method: "POST",
				data: {
					IdConceptoPlan: IdConceptoPlan
				},
				success: function(data) {
					$('#employee_detail_3').html(data);
					$('#dataModal_3').modal('show');
				}
			});
		}

		function config_costo(IdConceptoPlan) {
			var IdCosto = 0;
			$.ajax({
				url: "formConsulta/configurar_costo.php",
				method: "POST",
				data: {
					IdConceptoPlan: IdConceptoPlan,
					IdCosto: IdCosto
				},
				success: function(data) {
					$('#employee_detail_5').html(data);
					$('#dataModal_5').modal('show');
				}
			});
		}

		function editar_costo_id(IdCosto, IdConceptoPlan) {
			$.ajax({
				url: "formConsulta/configurar_costo.php",
				method: "POST",
				data: {
					IdConceptoPlan: IdConceptoPlan,
					IdCosto: IdCosto
				},
				success: function(data) {
					$('#employee_detail_5').html(data);
					$('#dataModal_5').modal('show');
				}
			});
		}

		function verificar_oferta(IdConceptoPlan, IdCampus) {
			$.ajax({
				url: "formConsulta/ofertasConcepto.php",
				method: "POST",
				data: {
					employee_id: IdConceptoPlan,
					IdCampus: IdCampus
				},
				success: function(data) {
					$('#employee_detail3').html(data);
					$('#dataModal3').modal('show');
				}
			});
		}

		$(function() {
			$('#example1').DataTable()
		})
		$(function() {
			$('.select2').select2()

		})

		function activarMod() {
			document.getElementById("newDoc").style.display = 'block';
		}

		function val_TipoSolicitud(valor) {
			var pagar = document.getElementById("txtIdConcep-" + valor).checked;
			if (pagar == true) {
				var numero = 3;
				$.post("formConsulta/updConcepto.php", {
					valor: valor,
					numero: numero
				}, function(data) {});
			} else if (pagar == false) {
				var numero = 1;
				$.post("formConsulta/updConcepto.php", {
					valor: valor,
					numero: numero
				}, function(data) {});
			}
		}
	</script>

</body>

</html>
<?php unset($_SESSION['Alerta']);  ?>