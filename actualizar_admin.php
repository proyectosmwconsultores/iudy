<?php $section = "Mi informacion";
include("head.php");
$var = 3;
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en Mi Informacion');
}
$datosUser = $t->get_docente_id($_SESSION['IdUsua']);
if (isset($_POST["Mov"]) && $_POST["Mov"] == "Guardar") {
  $t->upd_datos_gral_admin();
  exit;
}

$_p = 0;
if ($datosUser[0]['Estado']) {
  $paqz = $datosUser[0]['Estado'];
  $pathz = "./assets/perfil/" . $paqz;
  if (file_exists($pathz)) {
    $_p = 1;
  } else {
    $_p = 0;
  }
}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <i class="fa fa-fw fa-edit"></i> Mis datos
        </h1>
        <ol class="breadcrumb">
          <li><a href="espacioAdministrativo.php"><i class="fa fa-bell"></i> Mi espacio</a></li>
          <li class="active"> Actualizar datos</li>
        </ol>
      </section>
      <section class="content">
        <div class="kx-page">
          <div class="kx-layout">
            <!-- SIDEBAR -->
            <?php include("espacioAdmin.php");  ?>

            <section class="pay-page">
              <div class="paytabs-card">

                <!-- Header con Tabs -->
                <div class="paytabs-header">

                  <div class="paytabs-title-area">
                    <div class="paytabs-icon">👤</div>
                    <div>
                      <div class="paytabs-title">Actualizar mis datos </div>
                      <div class="paytabs-sub">Espacio para poder actualizar mis datos personales </div>
                    </div>
                  </div>
                </div>

                <!-- Contenido -->
                <div class="paytabs-content">
                  <div class="paypanel is-active" data-content="pendientes">
                    <form class="form-horizontal" name="frm" id="frm" action="actualizar_admin.php" method="POST" enctype="multipart/form-data">
                      <input id="Mov" name="Mov" value="<?php if (isset($_GET['Mov'])) { echo $_GET['Mov']; } ?>" type="hidden" />
                      <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden" />
                      <div class="box-body">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-4 control-label">Nombre:</label>
                          <div class="col-sm-8">
                            <input class="form-control" disabled id="txtNombre" name="txtNombre" placeholder="Nombre" type="text" value="<?php echo $datosUser[0]["Nombre"]; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Apellido Paterno:</label>
                          <div class="col-sm-8">
                            <input class="form-control" disabled id="txtAPaterno" name="txtAPaterno" placeholder="Apellido paterno" type="text" value="<?php echo $datosUser[0]["APaterno"]; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Apellido Materno:</label>
                          <div class="col-sm-8">
                            <input class="form-control" disabled id="txtAMaterno" name="txtAMaterno" placeholder="Apellido materno" type="text" value="<?php echo $datosUser[0]["AMaterno"]; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Correo personal:</label>
                          <div class="col-sm-8">
                            <input class="form-control" id="txtCorreo" name="txtCorreo" placeholder="Correo" type="email" value="<?php echo $datosUser[0]["Correo"]; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Correo institucional:</label>
                          <div class="col-sm-8">
                            <input class="form-control" id="txtCorreoIns" name="txtCorreoIns" placeholder="Correo" type="email" value="<?php echo $datosUser[0]["Correo_institucional"]; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Celular:</label>
                          <div class="col-sm-8">
                            <input class="form-control" id="txtCelular" name="txtCelular" type="text" value="<?php echo $datosUser[0]["Celular"]; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Foto de perfil:</label>
                          <div class="col-sm-8">
                            <input id="foto" name="foto" type="file" onchange="ValidarImagen(this);">
                            <p class="help-block" style="color: red;"><b style="color: blue;">Nota:</b> Recuerde que su foto de perfil se someter&aacute; a revisi&oacute;n para ser publicada.</p>
                          </div>
                        </div>
                       
                        <div class="form-group">
                          <label class="col-sm-8 control-label">Fecha de nacimiento:</label>
                          <div class="col-sm-4">
                            <input class="form-control" id="txtFecNac" name="txtFecNac" type="text" value="<?php echo $datosUser[0]["FecNac"]; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-8 control-label">Fecha de ingreso en la IUDY:</label>
                          <div class="col-sm-4">
                            <input class="form-control" id="txtIngreso" name="txtIngreso" type="text" value="<?php echo $datosUser[0]["FecAlta"]; ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-8 control-label">Sexo:</label>
                          <div class="col-sm-4">
                            <select class="form-control" name="txtSexo" id="txtSexo">
                              <option value=""> - Seleccione - </option>
                              <option value="M" <?php if ($datosUser[0]["Sexo"] == "M") { ?>selected="selected" <?php } ?>> MUJER </option>
                              <option value="H" <?php if ($datosUser[0]["Sexo"] == "H") { ?>selected="selected" <?php } ?>> HOMBRE </option>
                            </select>
                          </div>
                        </div>

                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <button onClick="val_update_datos()" type="button" class="btn btn-info pull-right"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
                      </div>
                      <!-- /.box-footer -->
                    </form>


                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>

      
    </div>
    <?php include("footer.php"); ?>
  </div>
  <!-- ./wrapper -->
  <!-- ./wrapper -->
  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- FastClic
<script src="bower_components/fastclick/lib/fastclick.js"></script>-->

  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  
  <script>
   

    $(function() {
      //Date picker
      $('#txtFecNac').datepicker({
        autoclose: true
      })
      $('#txtIngreso').datepicker({
        autoclose: true
      })

    })

  </script>
</body>

</html>