<?php $valor = 2;
$section = "Alta de asignatura"; include("head.php");
if(($_SESSION['IdUsua']) && ($_SESSION['Permisos'])){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de alta de asignatura'); }

$campusId=$t->get_lstCampusAc($_SESSION['IdUsua']);

	if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
		$t->add_Modulo();
		exit;
	}

	$catModulo=$t->get_catModulos($_SESSION['IdUsua']);

	 if(isset($catModulo[0]["IdOferta"])) { $_POST["txtOferta"] = $catModulo[0]["IdOferta"]; }
	 if(isset($catModulo[0]["IdCampus"])) { $_POST["txtCampus"] = $catModulo[0]["IdCampus"]; }

	if(isset($_POST["txtOferta"])) { $_POST["txtOferta"] = $_POST["txtOferta"]; } else { $_POST["txtOferta"] = ''; }
	if(isset($_POST["txtCampus"])) { $_POST["txtCampus"] = $_POST["txtCampus"]; } else { $_POST["txtCampus"] = ''; }

	if(isset($_POST["Mov"]) && $_POST["Mov"]=="subExcel"){
	  $t->add_excelModulo();
	  exit;
	}

$oferta=$t->get_misOfertas($_POST["txtCampus"],$_SESSION['IdUsua']);

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">

  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-fw fa-upload"></i> Captura de las materias
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Asignatura</a></li>
        <li class="active">Alta de asignatura</li>
      </ol>
    </section>
<?php
// $as = 1303;
// echo $gradn = substr($as,1,1);
 ?>
    <section class="content">
			<form name="frm" id="frm" action="adAddModulo.php" method="POST" enctype="multipart/form-data">
			<input id="TipoGuardar" name="TipoGuardar" value="val_adAddModulo" type="hidden"/>
			<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
			<input id="IdPermiso" name="IdPermiso" value="<?php echo $_SESSION['Permisos']; ?>" type="hidden"/>
			<input id="IdOferta" name="IdOferta" value="<?php echo $_POST['txtOferta']; ?>" type="hidden"/>
			<input id="Mov" name="Mov" value="" type="hidden"/>
			<div class="box box-default">
				<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Campus:</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-gears"></i>
								</div>
								<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
									<option value=""> - Seleccione - </option>
									<?php for ($i=0;$i< sizeof($campusId);$i++) { ?>
									<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"<?php if($_POST["txtCampus"]==$campusId[$i]["IdCampus"]){ ?>selected="selected"<?php }?>><?php echo $campusId[$i]["Campus"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Plan de estudio:</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-gears"></i>
								</div>
								<select class="form-control select2" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
									<option value=""> - Seleccione - </option>
									<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
									<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$oferta[$i]["IdEducativa"]){ ?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>

					<?php if($_POST["txtCampus"]){ ?>
					<div class="col-md-6">
						<div class="form-group">
							<label>Buscar archivo <b>excel(.xls)</b>:</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-file-excel-o"></i>
								</div>
								<input type="file" class="form-control" name="txtArchivo" id="txtArchivo" onchange="validarExcel(this,'txtArchivo');">
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Movimiento:</label>
							<div class="input-group">

									<?php if(isset($catModulo[0])){ ?>
										<button type="button" class="btn btn-danger" onClick="val_delCatMod()" style="float: right; margin-right: 5px;"><i class="fa fa-trash"></i> Eliminar</button>
										<button type="button" class="btn btn-success" onClick="val_subAsignaturas()" style="float: right; margin-right: 5px;"><i class="fa fa-save"></i> Guardar asignaturas</button>
									<?php } else { ?>
										<button type="button" class="btn bg-navy btn-flat" onClick="val_addCatAsig()" style="float: right; margin-right: 5px;"><i class="fa fa-cloud-upload"></i> Subir</button>
										<button type="button" class="btn bg-olive btn-flat" onClick="window.open('assets/carga_materias.xls','_blank')" href="javascript:void(0);" style="float: right; margin-right: 5px;"><i class="fa fa-clipboard"></i> Layout materias</button>
									<?php } ?>
							</div>
						</div>
					</div><?php } ?>

					<div class="col-xs-12">
						<div class="form-group" name="imgLoadPagos" id="imgLoadPagos" style="display: none;">
							<div class="col-sm-12" style="text-align: center;">
									<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
							</div>
						</div>
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">Lista de usuarios en proceso de alta</h3>
							</div>
							<div class="box-body">
								<table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
									<thead>
										<tr>
											<th>#</th>
											<th>CLAVE</th>
											<th>MATERIA</th>
											<th>ESTATUS</th>
											<th>CAMPUS</th>
											<th>PLAN DE ESTUDIOS</th>
											<th>CRÉDITOS</th>
											<th>HI</th>
											<th>HD</th>
										</tr>
									</thead>
									<tbody id="trLine60">
										<?php for ($i=0;$i< sizeof($catModulo);$i++) { $sty = "";
											$catBusMod=$t->get_catBusMod($catModulo[$i]["IdAsignatura"]);
											// if(isset($catBusMod[0])){
											// if($catBusMod[0]["CodeModulo"] == $catModulo[$i]["IdAsignatura"]){ $sty = "style = 'background: gray;'";
											// 	$catBusMod=$t->get_updcatBusModId($catModulo[$i]["IdTemporal"], 27);
											// } }

											if(!$catModulo[$i]["Campus"]){ $sty = "style = 'background: red;'";
												$catBusMod=$t->get_updcatBusModId($catModulo[$i]["IdTemporal"], 29);
											}
											if($catModulo[$i]["IdEstatus"] == 29){ $sty = "style = 'background: red;'";}
											if($catModulo[$i]["IdEstatus"] == 28){ $sty = "style = 'background: green;'";}

											?>
										<tr <?php echo $sty; ?> >
											<td><?php echo $i+1; ?>.- </td>
											<td><?php echo $catModulo[$i]["IdAsignatura"]; ?></td>
											<td><?php echo $catModulo[$i]["Asignatura"]; ?></td>
											<td><?php echo $catModulo[$i]["Estatus"]; ?></td>
											<td><?php echo $catModulo[$i]["Campus"]; ?></td>
											<td><?php echo $catModulo[$i]["Nombre"]; ?></td>
											<td><?php echo $catModulo[$i]["Grupo"]; ?></td>
											<td><?php echo $catModulo[$i]["HraDoc"]; ?></td>
											<td><?php echo $catModulo[$i]["HraInd"]; ?></td>
										</tr>
									<?php } ?>
									</tfoot>
								</table>
							</div>
						</div>
					</div>

				</div>
			</div>
			</div>

			</form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()



    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })

	$(function () {
		$('#example1').DataTable()
	})
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
