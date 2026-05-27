<?php $valor = 3; $section = "Lista de alumnos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizado la lista de los alumnos para ver los documentos'); }
$alumnos=$t->get_alumnosT($_POST[txtClaveGrp]);
$clvGrupo=$t->get_claveGrupoA();
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
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumnos</a></li>
					<li class="active">Lista de alumnos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adDocAlumnos.php" method="POST" enctype="multipart/form-data">
						<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
						<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
						<input id="Numero" name="Numero" value="1" type="hidden"/>
						<div class="col-md-4">
							<div class="form-group">
								<label>Clave de grupo:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-fw fa-key"></i>
									</div>
									<select class="form-control" name="txtClaveGrp" id="txtClaveGrp" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($clvGrupo);$i++) { ?>
										<option value="<?php echo $clvGrupo[$i]["IdGrupo"]; ?>"<?php if($_POST["txtClaveGrp"]==$clvGrupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $clvGrupo[$i]["CveGrupo"]; ?></option>
										<?php } ?>
								  </select>
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de todos los alumnos</h3>
								</div>
								<div class="box-body">
								<div class="table-responsive">
									<table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
										<thead>
											<tr>
												<th>Matricula</th>
												<th>Nombre</th>

												<th>Correo</th>
												<th>Oferta educativa</th>
												<th>Documentos</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($alumnos);$i++) { ?>
											<tr>
												<td><?php echo $alumnos[$i]["Matricula"]; ?></td>
												<td><?php echo $alumnos[$i]["Nombre"].' '.$alumnos[$i]["APaterno"].' '.$alumnos[$i]["AMaterno"]; ?></td>

												<td><?php echo $alumnos[$i]["Correo"]; ?></td>
												<td><?php echo $alumnos[$i]["NomEducativa"]; ?></td>
												<td>
													<a onclick="window.open('docVerificar.php?IdUsua=<?php echo time().$alumnos[$i]["IdUsua"] ?>','_self')" href="javascript:void(0);">
														<button type="button" class="btn btn-success"> <i class="fa fa-edit"></i> Docs.</button>
													</a>
													<!--
													<a onclick="window.open('docVerificar.php?Id=<?php echo time().$alumnos[$i]["IdUsua"] ?>&Tramite=SS','_self')" href="javascript:void(0);">
														<button type="button" class="btn btn-danger"> <i class="fa fa-edit"></i> S.Social</button>
													</a>
													<a onclick="window.open('repositorio/pdf/listaAlumnos.php?Id=5c3cb1a1558dd','_blank')" href="javascript:void(0);">
														<button type="button" class="btn btn-primary"> <i class="fa fa-edit"></i> Imp. Serv</button>
													</a>-->
												</td>
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
