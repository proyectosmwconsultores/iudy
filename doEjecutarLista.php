<?php $section = "Pasar lista";
$_v = 94;
include("head.php");
if ($_SESSION["Permisos"] == 3) {
	header('Location: php/estructura/destroy.php');
}
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de pasar lista');
}
if ($_SESSION['Permisos']) {
	$t->get_validar_mat_doc($_GET["idToks"], $_SESSION['IdUsua']);

	// if($_SESSION['EstatusAsig'] == "A"){
	$t->get_ejecPaseLista($_GET["idToks"]);
	// }
	$AsignacionId = $t->get_datosModuloD($_GET["idToks"]);
?>
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

	<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
		<div class="wrapper">
			<?php include("menuV.php"); ?>
			<div class="content-wrapper">
				<?php if ($_SESSION['EstatusAsig'] == "F") {
					include("formConsulta/alerta.php");
				} ?>
				<section class="content-header">
					<h1> <?php echo $AsignacionId[0]["NombreMod"]; ?></h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i><?php echo substr($AsignacionId[0]["NombreMod"], 0, 40) . ' [...]'; ?></a></li>
						<li class="active"><a href="#">Pasar lista</a></li>
					</ol>

				</section>
				<section class="content">
					<div class="row">
						<form name="frm" id="frm" action="doEjecutarLista.php" method="POST" enctype="multipart/form-data">
							<input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_GET["idToks"]; ?>" type="hidden" />
							<div class="col-md-12">
								<div class="box" id="miTablaEvaluacion">
								</div>
							</div>
						</form>
					</div>
			</div>
			</section>
			<div id="dataFondo" class="modal fade"> <!--MODAL ME GUSTA-->
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Pasar lista de asistencia</h4>
						</div>
						<div class="modal-body" id="employee_fondo">
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include("footer.php"); ?>
		</div>
		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>

		<script>
			$(document).ready(function() {
				var IdAsignacion = document.getElementById("IdAsignacion").value;

				cargar_lista_asistencia(IdAsignacion);

			});

			function cargar_lista_asistencia(IdAsignacion) {
				var Capa = "#miTablaEvaluacion";

				$(Capa).load("formConsulta/lista_asistencia.php", {
					IdAsignacion: IdAsignacion
				}, function(response, status, xhr) {
					if (status == "error") {
						alert(status);
						var msg = "Error!, algo ha sucedido: ";
						$(Capa).html(msg + xhr.status + " " + xhr.statusText);
					}
				});
			}
		</script>
	</body>

	</html>
<?php


} else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>