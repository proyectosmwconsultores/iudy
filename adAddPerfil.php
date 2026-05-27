<?php $section = "Perfil"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por agregar un nuevo perfil'); }
$datosUser = $t->get_datosUser($_SESSION['IdUsua']);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Perfil
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Perfil</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="Imagen de perfil">
              <h3 class="profile-username text-center"><?php echo $datosUser[0]["NombreUser"]; ?></h3>
              <p class="text-muted text-center"><?php echo $datosUser[0]["APaterno"]; ?> <?php echo $datosUser[0]["AMaterno"]; ?></p>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  Tipo: <?php echo $datosUser[0]["Cargo"]; ?>
                </li>
                <li class="list-group-item">
                  Email: <?php echo $datosUser[0]["Correo"]; ?>
                </li>
                <li class="list-group-item">
                  Teléfono: <?php echo $datosUser[0]["Telefono"]; ?>
                </li>
              </ul>
              <a href="#" class="btn btn-primary btn-block"><b>Actualizar</b></a>
            </div>
          </div>
          <?php if($_SESSION['Permisos']=="3") { ?>
		  <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Datos</h3>
            </div>
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> <?php echo $datosUser[0]["Tipo"]; ?></strong>
              <p class="text-muted">
                <?php echo $datosUser[0]["NombreOfe"]; ?>
              </p>
              <hr>
              <strong><i class="fa fa-group"></i> Grupo: </strong> <?php echo $datosUser[0]["Grupo"]; ?>
            </div>
          </div>
		  <?php } ?>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-text-width"></i>

              <h3 class="box-title">SEMBLANZA</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <blockquote>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
              </blockquote>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
  </div>
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
$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	var variable = document.frm.Variable.value;
	if(alerta){
		if(alerta =="GUARDAR"){
			swal("Guardado", variable + " GUARDADO CON ÉXITO", "success");
		}
		if(alerta =="ACTUALIZAR"){
			swal("Actualizado", variable + " ACTUALIZADO CON ÉXITO", "success");
		}
		if(alerta =="ELIMINAR"){
			swal("Eliminado", variable + " ELIMINADO CON ÉXITO", "success");
		}
		if(alerta =="ERROR"){
			swal("Error", variable + " FAVOR DE COMUNICARSE CON EL ADMINISTRADOR", "error");
		}
	}
});

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
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
