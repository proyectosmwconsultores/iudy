<?php $section = "Configurar asignaturas"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de configurar materias a profesor.'); }
if(isset($_POST["token"])){ $_GET["token"] = $_POST["token"]; }
$IdUsua = substr($_GET["token"], 10,10);
$asesor=$t->get_datAsesor($IdUsua);

$campusId=$t->get_campusId();
$oferta=$t->get_ofertasxCampus($asesor[0]["IdCampus"]);

 if(isset($_POST["txtOferta"])){
	$moduloId=$t->get_ModuloIdCur($_POST["txtOferta"],$asesor[0]["IdCampus"]);
}

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Lista de asignaturas
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Plan de estudio</a></li>
					<li class="active">Asignaturas</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adMaterias.php" method="POST" enctype="multipart/form-data">
						<input id="IdCampus" name="IdCampus" value="<?php echo $asesor[0]["IdCampus"]; ?>" type="hidden"/>
						<input id="token" name="token" value="<?php echo $_GET["token"];?>" type="hidden"/>

						<div class="col-md-4">
							<div class="form-group">
								<label>Campus:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control" name="txtCampus" id="txtCampus" onchange="document.frm.submit();" disabled>
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($campusId);$i++) { ?>
										<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"<?php if($asesor[0]["IdCampus"]==$campusId[$i]["IdCampus"]){ ?>selected="selected"<?php }?>><?php echo $campusId[$i]["Campus"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label>Plan de estudio:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.token.value='<?php echo $_GET["token"]; ?>';document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
										<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$oferta[$i]["IdEducativa"]){ $scc = $oferta[$i]["IdGrado"]; ?>selected="selected"<?php }?>><?php echo $oferta[$i]["Clave"].' - '.$oferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de las asignaturas</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Ajuste</th>
												<th>Clave</th>
												<th>Nombre de la asignatura</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($moduloId);$i++) {
												$IdMod= $moduloId[$i]["IdModulo"];
												$dispo=$t->get_oferDispo($asesor[0]["IdCampus"],$_POST["txtOferta"],$IdMod,$IdUsua);

												?>
											<tr>
												<td>
													<?php if($dispo[0]){ ?>
														<button id="actEx-<?php echo $IdMod; ?>" onclick="activarMatEx(<?php echo $IdMod; ?>,<?php echo $moduloId[$i]["Grado"]; ?>,<?php echo $IdUsua; ?>,<?php echo $asesor[0]["IdCampus"]; ?>,0)" title="Desactivar materia" type="button" class="btn btn-primary"><i class="fa fa-check-circle"></i></button>
														<button id="desEx-<?php echo $IdMod; ?>" style="display: none; " onclick="activarMatEx(<?php echo $IdMod; ?>,<?php echo $moduloId[$i]["Grado"]; ?>,<?php echo $IdUsua; ?>,<?php echo $asesor[0]["IdCampus"]; ?>,1)" title="Activar materia" type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i></button>
													<?php } else { ?>
														<button id="actIn-<?php echo $IdMod; ?>" onclick="activarMatIn(<?php echo $IdMod; ?>,<?php echo $moduloId[$i]["Grado"]; ?>,<?php echo $IdUsua; ?>,<?php echo $asesor[0]["IdCampus"]; ?>,1)" title="Activar materia" type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i></button>
														<button style="display: none; " id="desIn-<?php echo $IdMod; ?>" onclick="activarMatIn(<?php echo $IdMod; ?>,<?php echo $moduloId[$i]["Grado"]; ?>,<?php echo $IdUsua; ?>,<?php echo $asesor[0]["IdCampus"]; ?>,0)" title="Desactivar materia" type="button" class="btn btn-primary"><i class="fa fa-check-circle"></i></button>
													<?php } ?>

												</td>
												<td><?php echo $moduloId[$i]["CodeModulo"]; ?></td>
												<td><?php echo $moduloId[$i]["NombreMod"]; ?></td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</form>
				</div>
			</section>
		</div>
	  <?php include("footer.php"); ?>

	</div>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

function activarMatIn(IdModulo, Grado, IdUsua, IdCampus, Valor){
	var IdOferta = document.frm.txtOferta.value;
	var TipoGuardar = "addMatDispo";

		var Activ = "actIn-"+IdModulo;
		var Desac = "desIn-"+IdModulo;

	$.ajax({
			 url:"formConsulta/setting.php",
			 method:"POST",
			 data:{TipoGuardar:TipoGuardar, IdModulo:IdModulo, Grado:Grado, IdOferta:IdOferta, IdCampus:IdCampus, IdUsua:IdUsua, Valor:Valor},
			 success:function(data){
				 if(Valor == 1){
					 document.getElementById(Activ).style.display = 'none';
					 document.getElementById(Desac).style.display = 'block';
				 }
				 if(Valor == 0){
					 document.getElementById(Activ).style.display = 'block';
					 document.getElementById(Desac).style.display = 'none';
				 }
			 }
	})
}

function activarMatEx(IdModulo, Grado, IdUsua, IdCampus, Valor){
	var IdOferta = document.frm.txtOferta.value;
	var TipoGuardar = "addMatDispo";

		var Activ = "actEx-"+IdModulo;
		var Desac = "desEx-"+IdModulo;

	$.ajax({
			 url:"formConsulta/setting.php",
			 method:"POST",
			 data:{TipoGuardar:TipoGuardar, IdModulo:IdModulo, Grado:Grado, IdOferta:IdOferta, IdCampus:IdCampus, IdUsua:IdUsua, Valor:Valor},
			 success:function(data){
				 if(Valor == 1){
					 document.getElementById(Activ).style.display = 'block';
					 document.getElementById(Desac).style.display = 'none';
				 }
				 if(Valor == 0){
					 document.getElementById(Activ).style.display = 'none';
					 document.getElementById(Desac).style.display = 'block';
				 }
			 }
	})
}

  $(function () {
    $('#example1').DataTable()
  })
</script>
</body>
</html>
