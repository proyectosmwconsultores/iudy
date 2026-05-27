<?php $section = "Crear plan de estudio"; include("head.php");
if($_SESSION['IdUsua']){  $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por agregar un nuevo plan de proyecto.'); }


$oferta=$t->get_OfertaCoordinador($_SESSION["IdUsua"]);
$periodo=$t->get_periodoEsc();
if(isset($_POST["Mov"]) && $_POST["Mov"]=="addPlan"){
  $t->add_comPago();
  exit;
}

//$cheRec=$t->get_chkRecargo();


 ?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Creación de plan de proyecto
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> Agregar</a></li>
        <li class="active">Plan de proyecto</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Datos del plan de proyecto</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
      		  <form name="frm" id="frm" action="adAddPlan.php" method="POST" enctype="multipart/form-data">
      		  <input id="TipoGuardar" name="TipoGuardar" value="val_adAddPlan" type="hidden"/>
            <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'] ?>" type="hidden"/>
            <input id="IdCampus" name="IdCampus" value="<?php echo $_SESSION['IdCampus'] ?>" type="hidden"/>
                <div class="col-md-6">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Licenciatura:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-key"></i>
          						  </div>
                        <select class="form-control" name="txtOferta" id="txtOferta">
      									<option value=""> - Seleccione - </option>
      									<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
      									<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST['txtOferta']==$oferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Clave"].' - '.$oferta[$i]["Nombre"]; ?></option>
                        <?php }  ?>
      								  </select>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
                <div class="col-md-3">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Modalidad:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-list-alt"></i>
          						  </div>
          						  <select class="form-control" name="txtModalidad" id="txtModalidad">
            							<option value=""> - Seleccione - </option>
            							<option value="E"> Escolarizada </option>
            							<option value="N"> No escolarizada </option>
            							<option value="M"> Mixta </option>
          						  </select>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
          			<div class="col-md-3">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>D&iacute;a(s):</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-qrcode"></i>
          						  </div>
          						  <select class="form-control" name="txtDias" id="txtDias">
          							<option value=""> - Seleccione - </option>
          							<option value="1"> Lunes - Jueves </option>
          							<option value="2"> Lunes - Viernes </option>
          							<option value="3"> Viernes </option>
                        <option value="4"> Interweek </option>
                        <option value="5"> Sábado </option>
                        <option value="6"> Domingo </option>
                        <option value="7"> Viernes - Domingo </option>
          							<option value="8"> Online </option>
          						  </select>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
                <div class="col-md-6">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Generación:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-qrcode"></i>
          						  </div>
          						  <input type="text" name="txtGeneracion" id="txtGeneracion" class="form-control">
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
                <div class="col-md-6">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Periodo escolar:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-key"></i>
          						  </div>
                        <select class="form-control" name="txtCiclo" id="txtCiclo">
      									<option value=""> - Seleccione - </option>
      									<?php for ($i=0;$i< sizeof($periodo);$i++) { ?>
      									<option value="<?php echo $periodo[$i]["IdCiclo"]; ?>"<?php if($_POST['txtCiclo']==$periodo[$i]["IdCiclo"]){?>selected="selected"<?php }?>><?php echo $periodo[$i]["Tipo"].' / '.$periodo[$i]["Ciclo"]; ?></option>
                        <?php }  ?>
      								  </select>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
                <div class="col-md-12">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Objetivo del plan de proyecto:</label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-qrcode"></i>
          						  </div>
          						  <textarea name="txtObjetivo" id="txtObjetivo" class="form-control" rows="3" placeholder="Objetivo ..."></textarea>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
          			<div class="col-md-12">
          			    <div class="box-primary">
          				    <div class="box-body">
          						<div class="box-footer" style=" text-align: center;">
                        <button type="button" class="btn btn-info" onClick="window.open('planProyecto.php','_self')" href="javascript:void(0);"> <i class="fa fa-fw fa-rotate-left"></i> Regresar</button>
          							<button type="button" class="btn btn-primary" onClick="val_adAddPlan()"> <i class="fa fa-fw fa-save"></i> Guardar</button>
          						</div>
          				    </div>
          			    </div>
          			  <!-- /.box -->
          			</div>
      			</form>

          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
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
<!-- bootstrap time picker-->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
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

<script>


  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy/mm/dd', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('yyyy/mm/dd', { 'placeholder': 'mm/dd/yyyy' })
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
</script>
</body>
</html>
