<?php $_v = 69;
$section = "Cancelar factura";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el modulo de cancelacion de facturas');
}

$fact = $t->get_factura_id($_GET['uuid']);
$id = $_GET['id'];

 $fechax = substr($fact[0]['Fecha'], 0, 7);

 $hoy = date("Y-m");

?>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Cancelar factura emitida
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> >Facturas</a></li>
					<li class="active">Reporte</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">

					<div class="box-body">
						<div class="row">

							<div class="col-xs-7">
								<p class="lead"><?php echo $fact[0]['R_Nombre']; ?></p>
								<p><b>RFC:</b> <?php echo $fact[0]['R_Rfc']; ?><br>
									<b>Regimen Fiscal:</b> <?php echo $fact[0]['R_RegimenFiscalReceptor']; ?> - <?php echo $fact[0]['Regimen']; ?><br>
									<b>Uso CFDI:</b> <?php echo $fact[0]['R_UsoCFDI']; ?>- <?php echo $fact[0]['Uso']; ?><br>
									<b>Fecha de timbrado:</b> <?php echo $fact[0]['Fecha']; ?><br>
									<b>No. Factura:</b> <?php //echo $fact[0]['Serie']; ?><?php echo $fact[0]['Folio']; ?>
								</p>
								<p>Conceptos facturados:</p>
								<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
								<?php for ($i=0;$i< sizeof($fact);$i++) { ?>
									<i class="fa fa-fw fa-check-circle"></i> <?php echo $fact[$i]['Descripcion']; ?> <br>
								<?php } ?>
								</p>
						        <?php if($fact[0]['IdEstatus'] == 7){  ?>
									<button type="button" class="btn btn-block btn-danger btn-sm"><i class="fa fa-fw fa-times-circle"></i> FACTURA CANCELADA</button>
								<?php } else { ?>
									<button type="button" class="btn btn-block btn-success btn-sm"><i class="fa fa-fw fa-check-circle"></i> FACTURA ACTIVA</button>
								<?php } ?>
								
							</div>

							<div class="col-xs-5">
								<p class="lead">Importe facturado</p>
								<div class="table-responsive">
									<table class="table">
										<tbody>
											<tr>
												<th style="width:50%">Subtotal: </th>
												<td>$ <?php echo $fact[0]['SubTotal']; ?></td>
											</tr>
											<tr>
												<th>Descuento: </th>
												<td>$ <?php echo $fact[0]['Descuento']; ?></td>
											</tr>
											<tr>
												<th>Total: </th>
												<td>$ <?php echo $fact[0]['Total']; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
								<?php if($fact[0]['IdEstatus'] == 6){ ?>
								<br><br><br><br>
								<p>
								<button onclick="cancelar_factura('<?php echo $_GET['uuid']; ?>',<?php echo $id; ?>)" style="float: right;" type="button" class="btn bg-maroon btn-success btn-sm"><i class="fa fa-fw fa-trash"></i> CANCELAR FACTURA</button>
								</p><?php } ?>
								
							</div>
									
						</div>
					</div>
					
				</div>
			</section>
		</div>

		<div id="data_fact_cancel" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-times-circle"></i> Cancelar factura</h4>
					</div>

					<div class="modal-body" id="employee_fact_cancel">
					</div>
				</div>
			</div>
		</div>

		<!-- Mainly scripts -->
		<script src="assets/table/js/jquery-3.1.1.min.js"></script>
		<script src="assets/table/js/bootstrap.min.js"></script>
		<?php include("footer.php"); ?>
	</div>

	<!-- jQuery 3 -->

	<script>
		function cancelar_factura(uuid, id) {
			$.ajax({
				url: "vistas/facturar/cancelar_factura.php",
				method: "POST",
				data: {
					uuid: uuid,
					id:id
				},
				success: function(data) {
					$('#employee_fact_cancel').html(data);
					$('#data_fact_cancel').modal('show');
				}
			});
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