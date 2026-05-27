<?php $valor = 2;
$section = "Alta de asignatura"; include("head.php");
if(($_SESSION['IdUsua']) && ($_SESSION['Permisos'])){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de alta de asignatura'); }

if(isset($_GET["idC"])){ $_POST["txtCampus"] = $_GET["idC"]; }
if(isset($_GET["idO"])){ $_POST["txtOferta"] = $_GET["idO"]; }
if(isset($_POST["txtCampus"])){ $_POST["txtCampus"] = $_POST["txtCampus"]; } else { $_POST["txtCampus"] = ''; }
if(isset($_POST["txtOferta"])){ $_POST["txtOferta"] = $_POST["txtOferta"]; } else { $_POST["txtOferta"] = ''; }


$lstCampus=$t->get_lstCampusAc2($_SESSION['Permisos'],$_SESSION['IdUsua']);
$oferta=$t->get_ofertNb($_SESSION['Permisos'],$_SESSION['IdUsua']);
 
$lstAsig=$t->get_lstAsign($_POST["txtCampus"],$_POST["txtOferta"]);

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
        Captura de asignatura
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Asignatura</a></li>
        <li class="active">Alta de asignatura</li>
      </ol>
    </section>

    <section class="content">
			<form name="frm" id="frm" action="adAddAsignatura.php" method="POST" enctype="multipart/form-data">
			<input id="TipoGuardar" name="TipoGuardar" value="val_adAddModulo" type="hidden"/>
			<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
			<input id="IdPermiso" name="IdPermiso" value="<?php echo $_SESSION['Permisos']; ?>" type="hidden"/>
			<input id="IdOferta" name="IdOferta" value="<?php echo $_POST['txtOferta']; ?>" type="hidden"/>
			<input id="Mov" name="Mov" value="" type="hidden"/>
				<div class="row">
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
					<div class="col-md-6">
						<div class="form-group">
							<label>Campus/Escuela:</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-gears"></i>
								</div>
								<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
									<option value=""> - Seleccione - </option>
									<?php for ($i=0;$i< sizeof($lstCampus);$i++) { ?>
									<option value="<?php echo $lstCampus[$i]["IdCampus"]; ?>"<?php if($_POST["txtCampus"]==$lstCampus[$i]["IdCampus"]){ ?>selected="selected"<?php }?>><?php echo $lstCampus[$i]["Campus"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<?php if(isset($_POST["txtCampus"])){ ?>
					<div class="col-md-12">
						<div class="form-group">
							<label>Nombre de la asignatura:</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-pencil"></i>
								</div>
								<div class="input-group input-group">
                <input type="text" name="txtAsignatura" id="txtAsignatura" class="form-control">
                    <span class="input-group-btn">
                      <button onclick="saveAsignatura()" type="button" class="btn btn-info btn-flat"> <i class="fa fa-fw fa-save"></i> Guardar</button>
                    </span>
              </div>
							</div>
						</div>
					</div>

					<?php } ?>

					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">Lista de asignaturas dadas de alta</h3>
							</div>
							<div class="box-body">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Asignatura</th>
											<th>Ajuste</th>
										</tr>
									</thead>
									<tbody id="trLine60">
										<?php for ($i=0;$i< sizeof($lstAsig);$i++) {
											?>
										<tr>
											<td><?php echo $i+1; ?></td>
											<td><?php echo $lstAsig[$i]["NombreMod"]; ?></td>
											<td>ca</td>
										</tr>
									<?php } ?>
									</tfoot>
								</table>
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
