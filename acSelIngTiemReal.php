<?php $valor = 1; $section = "Registro de actividades calificadas"; include("head.php");
if($_SESSION['Permisos']) {
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<script src="php/js/reload.js"></script>
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Ingresos
          <small>Ingresos en tiempo real</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-user"></i> Ingresos</a></li>
          <li class="active">Ingresos de usuarios en tiempo real</li>
        </ol>
      </section>
      <section class="content">
        <form name="frm" id="frm" action="acSelIngTiemReal.php" method="POST" enctype="multipart/form-data">
          <input id="IdUsuaBus" name="IdUsuaBus" value="" type="hidden"/>
          <div class="row">
            <div id="contenido1">
              <div name="timediv1" id="timediv1">
              </div>
            </div>
          </div>
        </form>
      </section>
    </div>
    <?php include("footer.php"); ?>
  </div>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php } else {
  echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
