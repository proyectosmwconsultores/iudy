<?php $valor = 3; $section = "Lista de docentes"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando los asesores academicos'); }
$docentes=$t->get_docentesT();
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
					Asesor acad&eacute;mico
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Asesor acad&eacute;mico</a></li>
					<li class="active">Informaci&oacute;n</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adDocDocente.php" method="POST" enctype="multipart/form-data">
						<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
						<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
						<input id="Numero" name="Numero" value="2" type="hidden"/>
						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de todos los asesores acad&eacute;micos</h3>
								</div>
								<div class="box-body">
								<div class="table-responsive">
									<table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
										<thead>
											<tr>
												<th>#</th>
												<th>Nombre</th>
												<th>Teléfono</th>
												<th>Correo</th>
												<th>Documentos</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($docentes);$i++) { ?>
											<tr>
												<td><?php echo $i + 1; ?></td>
												<td><?php echo $docentes[$i]["Nombre"].' '.$docentes[$i]["APaterno"].' '.$docentes[$i]["AMaterno"]; ?></td>
												<td><?php echo $docentes[$i]["Telefono"]; ?></td>
												<td><?php echo $docentes[$i]["Correo"]; ?></td>
												<td>
													<a onClick="window.open('docVerificar.php?Id=<?php echo time().$docentes[$i]["IdUsua"]; ?>','_self')" href="javascript:void(0);">
														<button type="button" class="btn btn-default"> <i class="fa fa-file"></i> Documentos</button>
													</a>
												</td>
												<!-- <td>
													<a onClick="window.open('docContrato.php?Id=<?php echo $docentes[$i]["IdUsua"]; ?>','_self')" href="javascript:void(0);">
														<button type="button" class="btn btn-success"> <i class="fa fa-edit"></i> CONTRATO</button>
													</a>
												</td> -->
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

    <!-- Mainly scripts -->
    <script src="assets/table/js/jquery-3.1.1.min.js"></script>
    <script src="assets/table/js/bootstrap.min.js"></script>
    <script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
    <!-- Custom and plugin javascript -->
		<script src="assets/table/js/scriptAgregado1.js"></script>

	  <?php include("footer.php"); ?>
	</div>
</body>
<!-- jQuery 3 -->


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
