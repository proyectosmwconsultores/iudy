<?php $section = "Mi informacion"; include("head.php"); $var = 25;
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en Mi Informacion'); }
$datosUser = $t->get_datoDocente($_SESSION['IdUsua']);
if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
  $t->upd_datosAlumno();
  exit;
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
        <i class="fa fa-fw fa-edit"></i>  Mi informaci&oacute;n
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Mi espacio</a></li>
        <li class="active"> Mi informaci&oacute;n</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="Imagen de perfil">
              <h3 class="profile-username text-center"><?php echo $datosUser[0]["Nombre"]; ?></h3>
              <p class="text-muted text-center"><?php echo $datosUser[0]["APaterno"]; ?> <?php echo $datosUser[0]["AMaterno"]; ?></p>
              <ul class="list-group list-group-unbordered">
                <?php include("datEspacio.php"); ?>
              </ul>
            </div>
          </div>
          <div class="box box-primary" id="viewForo" style="display: none;">
            <div class="box-body box-profile">
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <i class="fa fa-file-image-o"></i> Nueva foto
                </li>
              </ul>
              <div id="imagePreview"></div>
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-fw fa-edit"></i> Actualizar mis datos personales</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" name="frm" id="frm" action="updateMiEspacioA.php" method="POST" enctype="multipart/form-data">
              <input id="Mov" name="Mov" value="<?php if(isset($_GET['Mov'])){ echo $_GET['Mov']; } ?>" type="hidden"/>
              <input id="IdDocente" name="IdDocente" value="<?php echo $datosUser[0]["IdUsua"] ?>" type="hidden"/>
              <input id="Id" name="Id" value="<?php if(isset($_GET["Id"])){ echo $_GET["Id"]; } ?>" type="hidden"/>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nombre:</label>
                  <div class="col-sm-8">
                    <input class="form-control" disabled id="txtNombre" name="txtNombre" placeholder="Nombre" type="text" value="<?php echo $datosUser[0]["Nombre"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Apellido Paterno:</label>
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
                    <input class="form-control" id="txtCorreo" name="txtCorreo" type="email" value="<?php echo $datosUser[0]["Correo"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Correo institucional:</label>
                  <div class="col-sm-8">
                    <input class="form-control" id="txtCorreoIns" name="txtCorreoIns" type="email" value="<?php echo $datosUser[0]["Correo_institucional"]; ?>">
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label class="col-sm-4 control-label">Imagen:</label>
                  <div class="col-sm-8">
                    <input id="foto" name="foto" type="file" onchange="ValidarImagen(this);">
                    <p class="help-block" style="color: red;"><b style="color: blue;">Nota:</b> Recuerde que su foto de perfil se someterá a revisión para ser publicada.</p>
                  </div>
                </div> -->
                <div class="form-group">
                  <label class="col-sm-6 control-label">Celular:</label>
                  <div class="col-sm-6">
                    <input class="form-control" id="txtCelular" name="txtCelular" type="text" value="<?php echo $datosUser[0]["Celular"]; ?>">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button onClick="window.open('miEspacio.php','_self')" href="javascript:void(0);" type="button" class="btn btn-default"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
                <button onClick="val_updateAlumno()" type="button" class="btn btn-info pull-right"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
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
<!-- FastClic
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    $('.textarea').wysihtml5()
  })
</script>
</body>
</html>
