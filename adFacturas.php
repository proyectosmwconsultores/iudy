<?php $valor = 3;
$section = "Facturas solicitadas";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está visualizando las facturas solicitadas');
}

if (isset($_POST["txtEstatus"])) {
	$_POST["txtEstatus"] = $_POST["txtEstatus"];
} elseif (isset($_GET["s"])) {
	$_POST["txtEstatus"] = $_GET["s"];
} else {
	$_POST["txtEstatus"] = '';
}


$facturas = $t->get_facturas($_POST["txtEstatus"]);
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));

if (isset($_POST["Mov"]) && $_POST["Mov"] == "Guardar") {
	$t->add_facturasSol($_POST["IdDoc"]);
	exit;
}
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
					Pagos pendientes sin facturas
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> >Facturas</a></li>
					<li class="active">Solicitadas</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="adFacturas.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
					<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden" />
					<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden" />
					<input id="Numero" name="Numero" value="4" type="hidden" />
					<input id="Nombre" name="Nombre" value="Reporte de facturas" type="hidden" />
					<div class="box box-default">
						<div class="box-body">
							<div class="row">
								<div class="col-md-12">
									<div id="miTablaEvaluacion"></div>
								</div>
							</div>
						</div>
					</div>

				</form>
			</section>

			<div id="data_fact" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><i class="fa fa-fw fa-bell"></i> Datos de facturación</h4>
						</div>

						<div class="modal-body" id="employee_fact">
						</div>
					</div>
				</div>
			</div>
			<div id="data_facx" class="modal fade">
				<!--MODAL ME GUSTA-->
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
		</div>

		<!-- Mainly scripts -->
		<script src="assets/table/js/jquery-3.1.1.min.js"></script>
		<script src="assets/table/js/bootstrap.min.js"></script>

		<?php include("footer.php"); ?>
	</div>

	<!-- jQuery 3 -->

	<script>
		$(document).ready(function() {
			cargar_lista_asistencia();
		});

		function cargar_lista_asistencia() {
			var Capa = "#miTablaEvaluacion";

			$(Capa).load("dashboard/lista_facturas_solicitadas.php", {}, function(response, status, xhr) {
				if (status == "error") {
					var msg = "Error!, algo ha sucedido: ";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
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
			var Ubicacion = 0;
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
	</script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- Page script -->
</body>

</html>
<?php unset($_SESSION['Alerta']);  ?>