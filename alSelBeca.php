<?php $valor = 3; $section = "Lista de alumnos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizado la lista de los alumnos'); }

if(isset($_GET["C"])){ $_POST["txtCampus"] = $_GET["C"]; }
if(isset($_GET["G"])){ $_POST["txtClaveGrp"] = $_GET["G"]; }
if(isset($_GET["P"])){ $_POST["txtPlan"] = $_GET["P"]; }


$campus=$t->get_lstCampusAc();
$clvGrupo=$t->get_gruposCampus($_POST["txtCampus"]);
$plan=$t->get_concepPlag($_POST["txtClaveGrp"]);
$alumnos=$t->get_alumnosBeca($_POST["txtClaveGrp"],$_POST["txtCampus"],$_POST["txtPlan"]);

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
					Lista de alumnos por grupo para generar beca
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumnos</a></li>
					<li class="active">Muestra todos los alumnos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="alSelBeca.php" method="POST" enctype="multipart/form-data">
						<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
						<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
						<input id="Numero" name="Numero" value="1" type="hidden"/>
						<div class="col-md-3">
							<div class="form-group">
								<label>Campus:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-fw fa-key"></i>
									</div>
									<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($campus);$i++) { ?>
												<option value="<?php echo $campus[$i]["IdCampus"]; ?>"<?php if($_POST['txtCampus']==$campus[$i]["IdCampus"]){?>selected="selected"<?php }?>><?php echo $campus[$i]["Campus"]; ?></option>
											<?php } ?>
									</select>

								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>IdGrupo:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-fw fa-key"></i>
									</div>
									<select class="form-control select2" name="txtClaveGrp" id="txtClaveGrp" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($clvGrupo);$i++) { $tx = 0;
												$busActivoD=$t->get_busActOfer($clvGrupo[$i]["IdGrupo"],$_SESSION["IdUsua"],$clvGrupo[$i]["IdCampus"]);
												 $tx = $busActivoD[0][0];
												if($tx){
												?>
												<option value="<?php echo $clvGrupo[$i]["IdGrupo"]; ?>"<?php if($_POST['txtClaveGrp']==$clvGrupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $clvGrupo[$i]["CveGrupo"].' / Cuatrimestre '.$clvGrupo[$i]["Nivel"]; ?></option>
												<?php
												} } ?>
									</select>

								</div>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<label>Plan de concepto:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-fw fa-key"></i>
									</div>
									<!-- <select class="form-control select2" name="txtPlan" id="txtPlan" onchange="document.frm.submit();"> -->
									<select class="form-control" name="txtPlan" id="txtPlan" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($plan);$i++) { ?>
												<option value="<?php echo $plan[$i]["IdConceptoPlan"]; ?>"<?php if($_POST['txtPlan']==$plan[$i]["IdConceptoPlan"]){?>selected="selected"<?php }?>><?php echo $plan[$i]["NomPlan"]; ?></option>
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
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Matricula</th>
												<th>Nombre</th>
												<th>Oferta educativa</th>
												<th>Beca</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($alumnos);$i++) { ?>
											<tr>
												<td><?php echo $alumnos[$i]["Usuario"]; ?></td>
												<td><?php echo $alumnos[$i]["Nombre"].' '.$alumnos[$i]["APaterno"].' '.$alumnos[$i]["AMaterno"]; ?></td>
												<td><?php echo $alumnos[$i]["NomEducativa"]; ?></td>
												<td><?php echo $alumnos[$i]["Porcentaje"]; ?>%</td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
								<hr>
								<?php if(($_POST["txtClaveGrp"]) && ($_POST["txtCampus"]) && ($_POST["txtPlan"])){ ?>

								<h3>Configurar beca del grupo</h3><br><br>
								<div class="col-md-5">
									<div class="form-group">
										<label>Porcentaje de beca del grupo:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-fw fa-balance-scale"></i>
											</div>

											<input type="text" name="txtBeca" id="txtBeca" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label>:.</label>
										<div class="input-group">
											<div class="input-group-addon">

											</div>

											<button type="button" onclick="saveBecaGpal()" class="btn btn-block btn-success btn-sm">Guardar beca</button>
										</div>
									</div>
								</div>
							<?php } ?>

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
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>

		<!-- InputMask -->
		<!-- <script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
		<script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
		<script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script> -->
		<!-- date-range-picker -->
		<!-- <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> -->
		<!-- bootstrap datepicker -->
		<!-- <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->
		<!-- bootstrap color picker -->
		<!-- <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script> -->
		<!-- bootstrap time picker-->
		<!-- <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script> -->
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
		<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


	  <?php include("footer.php"); ?>
	</div>

<!-- jQuery 3 -->


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
$(function () {
	$('#example1').DataTable()
})
	$(function () {
		$('.select2').select2()

	})
</script>
</body>
</html>
