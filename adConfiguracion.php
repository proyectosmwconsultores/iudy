<?php  $section = "Configurar generales"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el modulo de configuraciones generales'); }
?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Configuraci&oacute;n generales
				</h1>
				<ol class="breadcrumb">
					<li><a href="welcome.php"><i class="fa fa-user"></i> Inicio</a></li>
					<li class="active">Configuraciones</li>
				</ol>
			</section>
			<section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12" onClick="window.open('adMatricula.php','_self')" href="javascript:void(0);" style="cursor: pointer;">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
            <div class="info-box-content">
							<span class="info-box-text">Configurar matr&iacute;culas</span>
              <span class="info-box-text">por grupo</span>
              <span class="info-box-number"> <small> </small></span>
            </div>
          </div>
        </div>
				<div class="col-md-3 col-sm-6 col-xs-12" onClick="window.open('adConfigMatr.php','_self')" href="javascript:void(0);" style="cursor: pointer;">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
            <div class="info-box-content">
							<span class="info-box-text">Configurar matr&iacute;culas</span>
              <span class="info-box-text">por alumno</span>
              <span class="info-box-number"> <small> </small></span>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12" onClick="window.open('adDocsSolici.php','_self')" href="javascript:void(0);" style="cursor: pointer;">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-folder"></i></span>
            <div class="info-box-content">
							<span class="info-box-text">Configuraci&oacute;n </span>
              <span class="info-box-text">de documentaci&oacute;n</span>
              <span class="info-box-number"></span>
            </div>
          </div>
        </div>
				<div class="col-md-3 col-sm-6 col-xs-12" onClick="window.open('adAlumnosEx.php','_self')" href="javascript:void(0);" style="cursor: pointer;">
          <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
							<span class="info-box-text">Configurar alumnos</span>
              <span class="info-box-text">extempor&aacute;neos</span>
              <span class="info-box-number"></span>
            </div>
          </div>
        </div>
				<div class="col-md-3 col-sm-6 col-xs-12" onClick="window.open('adPlataforma.php','_self')" href="javascript:void(0);" style="cursor: pointer;">
          <div class="info-box">
            <span class="info-box-icon bg-black"><i class="fa fa-database"></i></span>
            <div class="info-box-content">
							<span class="info-box-text">Configuraci&oacute;n general</span>
              <span class="info-box-text">de la Plataforma</span>
              <span class="info-box-number"></span>
            </div>
          </div>
        </div>
				<div class="col-md-3 col-sm-6 col-xs-12" onClick="window.open('adConceptos.php','_self')" href="javascript:void(0);" style="cursor: pointer;">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
							<span class="info-box-text">Configuraci&oacute;n de</span>
              <span class="info-box-text">conceptos de pagos</span>
              <span class="info-box-number"></span>
            </div>
          </div>
        </div>

        <div class="clearfix visible-sm-block"></div>

      </div>
    </section>


		</div>

    <!-- Mainly scripts -->
    <script src="assets/table/js/jquery-3.1.1.min.js"></script>
    <script src="assets/table/js/bootstrap.min.js"></script>
    <script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
    <!-- Custom and plugin javascript -->
		<script src="assets/table/js/scriptAgregado1.js"></script>

	  <?php include("footer.php"); ?>
	</div>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
