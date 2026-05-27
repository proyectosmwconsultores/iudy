<?php
  require('php/clases/consulta_class.php');
  $t=new Consultas();
  $datos=$t->get_dos_sol_all_id($_GET['tokenId']);
  if(isset($datos[0]['IdDocumento'])){
    $IdDocs = $datos[0]['IdDocumento'];
  } else {
      $IdDocs = NULL;
  }


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Validar documento generado</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

	<link rel="icon" href="assets/images/campus/icono.png" type="image/x-icon">
	<meta name="description" content="Esta plataforma es capaz de crear tareas, foros, evaluaciones y tener los recursos de apoyo.  Con una estructura modular que hace posible su adaptacion a la realidad de los diferentes centros educativos" />
  <meta name="keywords" content="IUDY" />
  <meta name="author" content="MWConsultores">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top" style="background: white;">
      <div class="container">
        <div class="navbar-header">
          <a href="./" style="color: #060d35;" class="navbar-brand"><b>IUDY - INSTITUTO UNIVERSITARIO DE YUCATAN</b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
      </div>
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <?php

      if(isset($IdDocs)) { ?>
      <section class="content-header">
        <h1 style="text-align: center;">
          MÓDULO PARA VERIFICAR LA AUTENTICIDAD DEL DOCUMENTO POR MEDIO DEL QR<br>
          <b style="color: #060d35;">CONSTANCIA DE ESTUDIOS</b><br><br>
          <i class="fa fa-calendar margin-r-5"></i> Fecha de expedición del documento: </strong><?php echo obtener_fexc($datos[0]['FecAprobado']); ?>
        </h1>
      </section>

      <section class="content">

        <ul class="timeline timeline-inverse">

                  <li class="time-label">
                        <span class="bg-red">
                          Información académica
                        </span>
                  </li>
                  <li>
                    <i class="fa fa-bank bg-blue"></i>
                    <div class="timeline-item">
                      <div class="timeline-body">

                        <ul class="nav nav-stacked">
                          <li><a href="#"><b><?php echo $datos[0]['Educativa']; ?></b></a></li>
                          <li><a href="#"><b>CICLO ESCOLAR:</b> <?php echo $datos[0]['Ciclo']; ?></a></li>
                        </ul>
                      </div>
                    </div>
                  </li>
                  <li class="time-label">
                        <span class="bg-green">
                          Información del alumno
                        </span>
                  </li>
                  <li>
                    <i class="fa fa-user   bg-purple"></i>
                    <div class="timeline-item">
                      <h3 class="timeline-header"><a href="#"><?php echo $datos[0]['Nombre'].' '.$datos[0]['APaterno'].' '.$datos[0]['AMaterno']; ?></a> </h3>
                      <div class="timeline-body">
                        <ul class="nav nav-stacked">
                          <li><a href="#">MATRÍCULA <?php echo $datos[0]['Usuario']; ?></a></li>
                        </ul>
                      </div>
                    </div>
                  </li>
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
      </section>
    <?php } else { ?>
      <section class="content-header">
        <h1 style="text-align: center;">
          MÓDULO PARA VERIFICAR LA AUTENTICIDAD DEL DOCUMENTO POR MEDIO DEL QR<br><br>
          <b style="color: #060d35;">CONSTANCIA DE ESTUDIOS</b><br><br><br><br><br>
          <b style="color: #060d35; font-size: 20px;">LA CONSTANCIA DE ESTUDIOS NO EXISTE, FAVOR DE VERIFICAR LA AUTENTICIDAD CON LA INSTITUCIÓN.</b><br><br>
        </h1>
      </section>
    <?php } ?>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 6.20.05
      </div>
      <strong>Copyright &copy; 2022.</strong> Todos los derechos reservados
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
