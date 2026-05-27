<?php $section = "Constancia de estudios profesional";
include("head.php");
$var = 6;
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el modulo de constacias de estudios');
}
$tipoD = 33;

$constancia = $t->get_constancias_estudio_id($_SESSION['IdUsua']);
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
          Constancias de estudios
        </h1>
        <ol class="breadcrumb">
          <li><a href="espacioUser.php"><i class="fa fa-dashboard"></i> Mi espacio</a></li>
          <li class="active"> Constancia de estudios</li>
        </ol>
      </section>
      <section class="content">
        <div class="kx-page">
          <div class="kx-layout">
            <!-- SIDEBAR -->
            <?php include("espacioAlumno.php");  ?>
            <section class="pay-page">
              <div class="paytabs-card">

                <!-- Header con Tabs -->
                <div class="paytabs-header">

                  <div class="paytabs-title-area">
                    <div class="paytabs-icon">📜</div>
                    <div>
                      <div class="paytabs-title">Constancias de estudios </div>
                      <div class="paytabs-sub">Espacio para poder descargar sus constancias de estudios </div>
                    </div>
                  </div>
                </div>

                <!-- Contenido -->
                <div class="paytabs-content">
                  <div class="paypanel is-active" data-content="pendientes">


                    <?php if (isset($constancia[0])) { ?>
                    <div class="box-footer">
                      <ul class="mailbox-attachments clearfix">
                        <?php for ($f = 0; $f < sizeof($constancia); $f++) { ?>
                          <li onclick="javascript:window.open('repositorio/formatos/constancia.php?idToks=<?php echo $constancia[$f]['qrCode']; ?>');" style="cursor: pointer; width: 32%;" href="javascript:void(0);">
                            <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                            <div class="mailbox-attachment-info" style="text-align: center">
                              <a href="#" class="mailbox-attachment-name" style="font-size: 12px;"> <?php echo $constancia[$f]['NomPlan']; ?> </a>
                              <span class="mailbox-attachment-size">
                                <?php echo $constancia[$f]['Ciclo']; ?> </span>
                              <span class="mailbox-attachment-size" style="color: blue; text-align: center">
                                Documento disponible para descargar </span>
                            </div>
                          </li><?php } ?>
                      </ul>
                    </div>
                  <?php } else { ?>
                    <blockquote>
                      <p>No tiene ninguna constancia de estudios disponible.</p>
                      <small>Si ya realizo el pago de alguna constancia, le recomendamos estar atento a los avisos por correo.</small>
                    </blockquote>
                  <?php } ?>
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

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
</body>

</html>