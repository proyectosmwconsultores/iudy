<?php
include("php/estructura/session.php");
require('php/clases/registro.php');
$Regis=new Registro();
$configuracion=$Regis->get_configuracionPri();

if($_POST['txtBuscar']){
  $cod = $_POST['txtBuscar'];
}

if($_GET['c']){
  $cod = $_GET['c'];
}
if($_GET['xx']){
  $cod = $_GET['xx'];
}

if($_SESSION["Code"]){
  $cod = $_SESSION["Code"];
}
if($_GET["x"]){
  $cod = $_GET["x"];
}
$datos=$Regis->get_usuarioCode($cod);
echo $datos[0][0];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Informaci&oacute;n | <?php echo $configuracion[0]["Descripcion"]; ?></title>
  <link rel="icon" href="assets/images/campus/icono.png" type="image/x-icon">
  <meta content='assets/images/campus/logo_inicio.png' property='og:image'/>
  <meta name="description" content="Esta plataforma es capaz de crear tareas, foros, evaluaciones y tener los recursos de apoyo.  Con una estructura modular que hace posible su adaptacion a la realidad de los diferentes centros educativos" />
  <meta name="keywords" content="Sistema de educacion en linea, educacion, linea, educacion en linea, sistema" />
  <meta name="author" content="MWConsultores">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->

<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script language="javascript" type="text/javascript" src="php/js/modulo.js"></script>
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <script src="assets/alert/dist/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="assets/alert/dist/sweetalert.css">
  <script src="assets/js/jquery-3.2.1.min.js"></script>

</head>
<!--<body class="hold-transition login-page" style="background: none!important">-->
<body class="hold-transition login-page" style="background: #ffffff !important;">

<div class="login-box" style="width: 600px; margin: 1% auto !important;">
  <div class="login-logo">
    <a style="color: white;" href="registro.php"><img src="assets/images/campus/logo_inicio.png"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="background: #177ebd !important;">
    <?php if($_GET['xx']){ ?>
      <p class="login-box-msg" style="color: #fff;"><b>Su cuenta ya existe, verifique sus datos!!!</b></p>
<?php  }  else { ?>
  <?php if($datos[0]) { ?>
  <p class="login-box-msg" style="color: #fff;"><b>Registro &Eacute;xitoso!</b></p>
<?php  } else { ?>
  <p class="login-box-msg" style="color: #fff;"><b>B&uacute;squeda de informaci&oacute;n:</b></p>
<?php  } ?>
<?php  } ?>

    <form action="success.php" name='frm' method='post' class='form-horizontal' id="frm">
    <input id="Mov" name="Mov" value="<?php echo $_SESSION["Code"];?>" type="hidden"/>
    <div class="form-group">
      <?php if($datos[0]) { ?>
        <?php if($_GET["x"]) { ?>
      <div class="col-sm-12">
        <button type="button" class="btn btn-block btn-primary btn-sm">Re-Enviar informacion a mi Correo.</button>
      </div>
    <?php } else { ?>
      <a href="iindex.php"><button type="button" class="btn btn-block btn-info btn-sm">Re-Enviar informacion a mi Correo.</button></a>
    <?php }  ?>
    <?php } else { ?>
      <label for="inputEmail3" style="color: #fff;" class="col-sm-4 control-label">C&oacute;digo:</label>
      <div class="col-sm-6">
        <input class="form-control" id="txtBuscar" name="txtBuscar" placeholder="Codigo" type="text" >
      </div>

      <div class="col-sm-2">
        <button type="submit" style="color: #fff;" class="btn btn-block btn-info btn-sm">Buscar</button>
      </div>
    <?php } ?>
    </div>
    <?php if($datos[0]) { ?>
      <?php if(!$_GET['xx']){ ?>
    <div class="box-body">
      <div class="form-group">
        <label for="inputEmail3" style="color: #fff;" class="col-sm-4  control-label">C&oacute;digo:</label>
        <div class="col-sm-8">
          <label style="text-align: left; color: #fff;" for="inputEmail3" class="col-sm-4 control-label"><?php echo $datos[0]["Code"]; ?></label>
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail3" style="color: #fff;" class="col-sm-4 control-label">Nombre:</label>
        <div class="col-sm-8">
          <label style="text-align: left; color: #fff;" for="inputEmail3" class="col-sm-4 control-label"><?php echo $datos[0]["Nombre"]; ?></label>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPassword3" style="color: #fff;"  class="col-sm-4 control-label">A. Paterno:</label>
        <div class="col-sm-8">
          <label style="text-align: left; color: #fff;" for="inputEmail3" class="col-sm-4 control-label"><?php echo $datos[0]["APaterno"]; ?></label>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPassword3" style="color: #fff;" class="col-sm-4 control-label">A. Materno:</label>
        <div class="col-sm-8">
          <label style="text-align: left; color: #fff;" for="inputEmail3" class="col-sm-4 control-label"><?php echo $datos[0]["AMaterno"]; ?></label>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPassword3" style="color: #fff;" class="col-sm-4 control-label">Tel&eacute;fono:</label>
        <div class="col-sm-8">
          <label style="text-align: left; color: #fff;" for="inputEmail3" class="col-sm-6 control-label"><?php echo $datos[0]["Telefono"]; ?></label>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPassword3" style="color: #fff;" class="col-sm-4 control-label">Correo:</label>
        <div class="col-sm-8">
          <label style="text-align: left; color: #fff;" for="inputEmail3" class="col-sm-8 control-label"><?php echo $datos[0]["Correo"]; ?></label>
        </div>
      </div>

      <div class="form-group">
        <div class="box-body" style="color: #fff;">
              <dl class="dl-horizontal">
                <dt>Nota:</dt>
                <dd>Favor de verificar su correo, se le envi&oacute; su Usuario y Contrase&ntilde;a para poder ingresar a la Plataforma y para continuar su registro.</dd>
              </dl>
            </div>
      </div>

<?php } ?>




    </div>
    <?php $var = uniqid(); $var2 = uniqid(); $var3 = uniqid(); $var4 = uniqid(); ?>
    <!-- /.box-body -->
    <!--<button onClick="val_registro()" type="button" class="btn btn-danger pull-right"><i class="fa fa-fw fa-cloud-download"></i> Descargar Comprobante </button>-->
    <?php if(!$_GET['xx'] && $datos[0]["Tipo"] == 3){ ?>
    <button onclick="javascript:window.open('repositorio/pdf/tokenId.php?tokenId=<?php echo $var.$var2.$var3.$var4; ?>&token=<?php echo $datos[0]["Code"]; ?>');" href="javascript:void(0);" title="Descargar"  type="button" class="btn btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-fw fa-cloud-download"></i> DESCARGAR COMPROBANTE</button></td>
    <?php } ?>

    <br><br>
    <!-- /.box-footer -->
  <?php } ?>
    <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-fw fa-close"></i></button>

                Cualquier duda y/o aclaraci&oacute;n, favor de llamar al &Aacute;rea de Recursos Escolares.<br>
              </div>
  </form>
  </div>



</div>

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
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Page script -->
    <script>
    $(document).ready(function(){
    	var Mov = document.frm.Mov.value;

    	if(Mov){
    			swal("Guardado", " Registro creado correctamente", "success");
    	}
    });

      $(function () {
        //Date picker
        $('#datepicker').datepicker({
          autoclose: true
        })
    //Money Euro
        $('[data-mask]').inputmask()
        //Timepicker
        $('.timepicker').timepicker({
          showInputs: false
        })
      })
    </script>

</body>
</html>
<?php unset($_SESSION['Code']);    ?>
