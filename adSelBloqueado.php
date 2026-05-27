<?php $valor = 3; $section = "Alumnos bloqueados temporalmente"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizado la lista de los alumnos bloqueados temporalmente.'); }

$alumnos=$t->get_alumBloqueado();

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
					Lista de alumnos bloqueados temporalmente
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumnos</a></li>
					<li class="active">Alumnos bloqueados temporalmente</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adSelBloqueado.php" method="POST" enctype="multipart/form-data">
						<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
						<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
						<input id="Numero" name="Numero" value="9" type="hidden"/>
						<input id="Nombre" name="Nombre" value="Usuarios bloqueados temporalmente" type="hidden"/>
						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de todos los alumnos bloqueados</h3>
								</div>
								<div class="box-body">
								<div class="table-responsive">
									<table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;" >
										<thead>
											<tr>
												<th>Matricula</th>
												<th>Nombre</th>
												<th>Teléfono</th>
												<th>Correo</th>
												<th>Estatus</th>
												<th>Campus</th>
												<th>Oferta educativa</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($alumnos);$i++) { ?>
											<tr>
												<td><?php echo $alumnos[$i]["Matricula"]; ?></td>
												<td><?php echo $alumnos[$i]["Nombre"].' '.$alumnos[$i]["APaterno"].' '.$alumnos[$i]["AMaterno"]; ?></td>
												<td><?php echo $alumnos[$i]["Telefono"]; ?></td>
												<td><?php echo $alumnos[$i]["Correo"]; ?></td>
												<td><?php echo $alumnos[$i]["Estatus"]; ?></td>
												<td><?php echo $alumnos[$i]["Campus"]; ?></td>
												<td><?php echo $alumnos[$i]["NomEducativa"]; ?></td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</section>
		</div>
		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2 -->
		<!-- <script src="bower_components/select2/dist/js/select2.full.min.js"></script> -->
		<!-- Mainly scripts -->
    <script src="assets/table/js/jquery-3.1.1.min.js"></script>
    <script src="assets/table/js/bootstrap.min.js"></script>
    <script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
    <!-- Custom and plugin javascript -->
		<script src="assets/table/js/scriptAgregado1.js"></script>

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
		<!-- <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> -->


	  <?php include("footer.php"); ?>
	</div>

<!-- jQuery 3 -->


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

	// $(function () {
	// 	$('.select2').select2()
	//
	// })
</script>
</body>
</html>
