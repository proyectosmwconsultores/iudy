<?php $valor = 3;
$section = "Factura global";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el modulo de factura global');
}

if (isset($_POST["txtEstatus"])) {
	$_POST["txtEstatus"] = $_POST["txtEstatus"];
} elseif (isset($_GET["s"])) {
	$_POST["txtEstatus"] = $_GET["s"];
} else {
	$_POST["txtEstatus"] = '';
}

?>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Generar factura global
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> >Facturas</a></li>
					<li class="active">Global</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Generar reporte global del mes</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<form name="frm" id="frm" action="factura_global.php" method="POST" enctype="multipart/form-data">
								<div class="col-md-5">
									<div class="box-primary">
										<div class="box-body">
											<div class="form-group">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="box-primary">
										<div class="box-body">
											<div class="form-group">
												<label>Fecha inicial: </label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" class="form-control pull-right" id="datepicker1" name="datepicker1">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box-primary">
										<div class="box-body">
											<div class="form-group">
												<label>Fecha final: </label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" class="form-control pull-right" id="datepicker2" name="datepicker2">
													<span class="input-group-btn">
														<button type="button" class="btn btn-info btn-flat" onclick="consultar_facturas()"><i class="fa fa-fw fa-search"></i> Consultar</button>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div id="miTablaEvaluacion">
									</div>
								</div>


							</form>
						</div>
					</div>
					<p style="text-align: center; display: none;" id="img_cargar">
						<img src="assets/images/cargando.gif">
					</p>

					<div class="box-body" id="mostrar_ingresos" style="display: none;"></div>

				</div>
			</section>


		</div>

		<div id="data_fact_gene" class="modal fade">
			<div class="modal-dialog">
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

		<script>
			$(function() {
				//Date picker
				$('#datepicker1').datepicker({
					autoclose: true
				})
				//Date picker
				$('#datepicker2').datepicker({
					autoclose: true
				})


			})

			function consultar_facturas() {
				var Inicio = document.getElementById("datepicker1").value;
				var Final = document.getElementById("datepicker2").value;

				if (Inicio == '') {
					swal("Error al buscar", "Debe seleccionar la fecha inicial.", "error");
					document.getElementById("datepicker1").focus();
					return 0;
				}
				if (Final == '') {
					swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
					document.getElementById("datepicker2").focus();
					return 0;
				}

				var Capa = "#miTablaEvaluacion";
				$(Capa).load("dashboard/lista_pagos_mes.php", {
					Inicio: Inicio,
					Final: Final
				}, function(response, status, xhr) {

					if (status == "error") {
						var msg = "Error!, algo ha sucedido: ";
						$(Capa).html(msg + xhr.status + " " + xhr.statusText);
					}
				});
			}


			function gener_factura_global(IdForma) {
				var Inicio = document.getElementById("datepicker1").value;
				var Final = document.getElementById("datepicker2").value;

				$.ajax({
					url: "vistas/facturar/generar_factura_global.php",
					method: "POST",
					data: {
						Inicio: Inicio,
						Final: Final,
						IdForma:IdForma
					},
					success: function(data) {
						$('#employee_fact_gene').html(data);
						$('#data_fact_gene').modal('show');
					}
				});
			}

			function quitar_pago(IdFolio) {
				var TipoGuardar = 'quitar_pago_id';
				swal({
						title: "\u00BFEst\u00E1 seguro que desea quitar de la lista de la factura global este pago?",
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
									type: "POST",
									url: "vistas/finanzas/sav_datos_finanzas.php",
									data: {
										TipoGuardar: TipoGuardar,
										IdFolio:IdFolio
									},
									success: function(data) {

									}
								})
								.done(function(data) {
									if (data == 1) {
										swal("Quitado correctamente", "El pago se ha quitado de la lista de la factura global.", "success");
										consultar_facturas();
									} else {
										swal("Ha ocurrido un error", "No se puede procesar la lista de pagos.", "error");
										consultar_facturas();
									}
								})
								.error(function(data) {
									swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
								});
						} else {
							document.getElementById("frm").reset();
						}
					});
			}
		</script>


		<!-- Mainly scripts -->
		<script src="assets/table/js/jquery-3.1.1.min.js"></script>
		<script src="assets/table/js/bootstrap.min.js"></script>
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<?php include("footer.php"); ?>
	</div>

	<!-- jQuery 3 -->


	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- Page script -->
</body>

</html>
<?php unset($_SESSION['Alerta']);  ?>