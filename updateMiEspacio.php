<?php $section = "Mi espacio"; include("head.php"); $var = 2;
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por actualizar sus datos personales'); }
$datosUser = $t->get_datoDocente($_SESSION['IdUsua']);
if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
  $t->upd_datosDocente();
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
        Docente
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Actualizar mi espacio</li>
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
                <?php include("datDocente.php"); ?>
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
              <h3 class="box-title">Actualizar información</h3>
            </div>
            <form class="form-horizontal" name="frm" id="frm" action="updateMiEspacio.php" method="POST" enctype="multipart/form-data">
              <input id="Mov" name="Mov" value="<?php echo $_GET[Mov];?>" type="hidden"/>
              <input id="IdDocente" name="IdDocente" value="<?php echo $datosUser[0]["IdUsua"] ?>" type="hidden"/>
              <input id="Id" name="Id" value="<?php echo $_GET["Id"] ?>" type="hidden"/>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nombre:</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre" type="text" value="<?php echo $datosUser[0]["Nombre"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">A. Paterno:</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="txtAPaterno" name="txtAPaterno" placeholder="Apellido paterno" type="text" value="<?php echo $datosUser[0]["APaterno"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">A. Materno:</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="txtAMaterno" name="txtAMaterno" placeholder="Apellido materno" type="text" value="<?php echo $datosUser[0]["AMaterno"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Correo:</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="txtCorreo" name="txtCorreo" placeholder="Correo" type="email" value="<?php echo $datosUser[0]["Correo"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Teléfono:</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="txtTelefono" name="txtTelefono" placeholder="Telefono" type="text" value="<?php echo $datosUser[0]["Telefono"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imagen:</label>
                  <div class="col-sm-10">
                    <input id="foto" name="foto" type="file" onchange="ValidarImagen(this);">
                    <p class="help-block">La imagen debe ser de 128px * 128px</p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Semblanza:</label>
                  <div class="col-sm-10">
                    <div class="box-body pad">
                      <textarea class="textarea" name="txtSemblanza" id="txtSemblanza" placeholder="Información general" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $datosUser[0]["Semblanza"]; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <button onClick="window.open('miEspacio.php','_self')" href="javascript:void(0);" type="button" class="btn btn-default">Cancelar</button>
                <button onClick="val_updateDocente()" type="button" class="btn btn-info pull-right">Actualizar</button>
              </div>
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
