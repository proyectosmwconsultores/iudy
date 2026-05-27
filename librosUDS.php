<?php $mnA = 42; $section = "Libro UDS"; include("head.php"); $var = 15;
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el modulo de libros UDS'); }
$datosUser = $t->get_datosUser($_SESSION['IdUsua']);
$datOfe = $t->get_lstOfertauds();


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Libros de consulta - Universidad del Sureste</h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Libros UDS</li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="librosUDS.php" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header" style=" background: #04152b; color: white;">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/images/oferta/default.png" alt="User Avatar" style="width: 60px; height: 60px;">
              </div>
              <h3 class="widget-user-username">LIBROS DE CONSULTA UDS</h3>
              <h5 class="widget-user-desc"><?php echo $datosUser[0]["Cargo"]; ?></h5>
            </div>
            <div class="box-footer">
              <ul class="mailbox-attachments clearfix">
                <?php for ($i=0;$i< sizeof($datOfe);$i++) {
                  $imgh = 'assets/images/oferta/'.$datOfe[$i]["Clave"].'.png';
                  if (file_exists($imgh)) { $img = $datOfe[$i]["Clave"].'.png'; } else {  $img = 'MODULO.png'; }
                   ?>
                <li onClick="window.open('libro.php?idLibro=<?php echo time().$datOfe[$i]["IdEducativa"]; ?>','_self')" href="javascript:void(0);" style="cursor: pointer;">
                  <span class="mailbox-attachment-icon has-img"><img src="assets/images/oferta/<?php echo $img; ?>" alt="Attachment"></span>
                  <!-- <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-book"></i> <?php echo $datOfe[$i]["Clave"]; ?></a>
                  </div> -->
                </li>
                <?php } ?>
              </ul>
            </div>

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

<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
