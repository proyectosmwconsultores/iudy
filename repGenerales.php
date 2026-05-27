<?php $valor = 1; $section = "Lista de reportes"; include("head.php");
if($_SESSION['Permisos']) {
  $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está observando la lista de reportes');

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<script src="assets/grafica/highcharts.js"></script>
<script src="assets/grafica/data.js"></script>
<script src="assets/grafica/exporting.js"></script>
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Lista de reportes generales
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-user"></i> Lista</a></li>
          <li class="active">Reportes generales</li>
        </ol>
      </section>
      <section class="content">


            <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                      <tbody><tr>
                        <th>Ajuste</th>
                        <th>M&oacute;dulo</th>
                        <th>Nombre del reporte</th>
                      </tr>
                      <tr>
                        <td width="40px"><button type="button" class="btn btn-block btn-success btn-xs" onclick="javascript:window.open('formConsulta/expOferta.php');"><i class="fa fa-fw fa-cloud-download"></i></button></td>
                        <td>Ofertas educativas</td>
                        <td>Reporte de ofertas educativas</td>
                      </tr>
                      <tr>
                        <td width="40px"><button type="button" class="btn btn-block btn-success btn-xs" onclick="javascript:window.open('formConsulta/expOfertaModulo.php');"><i class="fa fa-fw fa-cloud-download"></i></button></td>
                        <td>Ofertas educativas</td>
                        <td>Reporte de materias por ofertas educativas</td>
                      </tr>
                    </tbody></table>
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
