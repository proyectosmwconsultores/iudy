<?php $mnI = 9; $valor = 0; $section = "Mis cursos"; include("head.php");
if($_SESSION['IdUsua']) {
		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en visualizando sus cursos.');
		$moduloAlum=$t->get_ModuloAsigAlumC($_SESSION['IdUsua']);
		$moduloA=$t->get_ModuloAsigC($_SESSION['IdUsua']);
unset($_SESSION['IdAsignacion']);
unset($_SESSION['IdOferta']);
unset($_SESSION['EstatusAsig']);

$checarEstatus=$t->get_checarEstatus();

if($configuracion[22]["Descripcion"] == "SI"){
	$encuestasPend=$t->get_listaEnsta($_SESSION['IdUsua']);
	if($encuestasPend[0]){
		header('Location: viewFinalizados.php?x=x');
	}
}


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">

		<?php include("menuV.php"); ?>
		<div class="content-wrapper">


			<section class="content-header">
				<h1>

					MIS CURSOS DISPONIBLES


				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Mis cursos</a></li>
					<li class="active">Panel de control</li>
				</ol>
			</section>
			<section class="content">



				<div class="row">

					<?php if(($recargosmx) && ($configuracion[13]["Descripcion"] == "SI")) { ?>
					<div class="col-md-12">
          <!-- Widget: user widget style 1 -->
	          <div class="box box-widget widget-user">
	            <!-- Add the bg color to the header using any of the bg-* classes -->
	            <div class="widget-user-header bg-red-active">
	              <h3 class="widget-user-username"><?php echo $_SESSION['NombreUser']; ?></h3>
	              <h5 class="widget-user-desc">Debe realizar los pagos pendientes.</h5>
	            </div>
	            <div class="widget-user-image">
	              <img class="img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="User Avatar">
	            </div>
	            <div class="box-footer">
								<div class="box-footer no-padding">
		              <ul class="nav nav-stacked">
		                <li><a href="#"><b style="color: red;">Favor de realizar sus pagos pendientes </b><span class="pull-right badge bg-red"><i class="fa fa-fw fa-map-signs"></i></span></a></li>
		                <li><a onClick="window.open('misPagos.php','_self')" href="javascript:void(0);"> <b>Clic para visualizar sus pagos pendientes</b> <span class="pull-right badge bg-aqua"><i class="fa fa-fw fa-sign-out"></i></span></a></li>
		              </ul>
		            </div>
	            </div>
	          </div>
	          <!-- /.widget-user -->
	        </div> <?php } else { ?>


					<?php $est= 0;  for ($i=0;$i< sizeof($moduloAlum);$i++) {  $x = $x + 1; if($moduloAlum[$i]["Estatus"] == "Finalizado") { $est = 1; }
					$tipoDatos=$t->get_tioDatosG($_SESSION['IdUsua']);

					$oft = "assets/images/oferta/".$moduloAlum[$i]["IdEducativa"].".png";
					if(file_exists($oft)) {
						$mstImg = "1.png";
					} else {
						$mstImg = "default.png";
					}


					$totalAlumnos=$t->get_totalAlumnos($moduloAlum[$i]["IdModulo"],$tipoDatos[$i]["Grupo"]);
					if($x == 0) { $color = "bg-blue"; }
					if($x == 1) { $color = "bg-green"; }
					if($x == 2) { $color = "bg-aqua"; }
					if($x == 3) { $color = "bg-yellow"; }
					if($x == 4) { $color = "bg-red"; $x = 0; } ?>
					<?php if($moduloAlum[$i]["Estatus"] == "Activo") { ?>
					<div class="col-md-4">
	          <div class="box box-widget widget-user-2">
							<img style="position: absolute; margin-left:-10px; margin-top:-4px;"  src="assets/images/oferta/<?php echo $mstImg; ?>" alt="User Avatar">
	            <div class="widget-user-header <?php echo $color; ?>">

	              <h3 class="widget-user-username"><?php echo $moduloAlum[$i]["Nombre"]; ?></h3>
								<h5 class="widget-user-desc">
									<?php
									$total = strlen($moduloAlum[$i]["NombreMod"]);
									if($total < 25 ){
										echo $moduloAlum[$i]["NombreMod"]; echo "&nbsp;";
									}else {
										echo substr($moduloAlum[$i]["NombreMod"], 0 , 22); if($total > 22){ echo " [...]";}
									} ?> </h5>
	            </div>
	            <div class="box-footer no-padding">
	              <ul class="nav nav-stacked">

									<?php if($moduloAlum[$i]["IdEstatus"] == 12){ ?><br><br>
									<li><a href="#"><b>En proceso de activaci&oacute;n <span class="pull-right badge bg-red">&nbsp;</span></b></a></li>
									<br><br>
									<?php } else { ?>
										<li><a href="#"><?php echo obtenerFechaEnLetra($moduloAlum[$i]["FecIni"]); ?> <span class="pull-right badge bg-blue">I</span></a></li>
		                <li><a href="#"><?php echo obtenerFechaEnLetra($moduloAlum[$i]["FecFin"]); ?><span class="pull-right badge bg-green">F</span></a></li>
									  <li><a href="#"><b>En tiempo <span class="pull-right badge bg-yellow">&nbsp;</span></b></a></li>
									<?php } ?>
	              </ul>
								<?php if($moduloAlum[$i]["IdEstatus"] == 12){ ?>
									<a href="javascript:void(0);" class="btn btn-danger btn-block"><b>No disponible</b></a>
								<?php } else { ?>
									<a title="Ingresar a mi asignatura" onClick="window.open('miAsignatura.php?Id=<?php echo $moduloAlum[$i]["IdAsignacion"]; ?>&T=A','_self')" href="javascript:void(0);" class="btn btn-primary btn-block"><b>Acceder</b></a>
								<?php }  ?>
	            </div>
	          </div>
	        </div>
				<?php } ?>
			<?php } ?>
				<?php } ?>


				</div>

			</section>
		</div>

	  <?php include("footer.php"); ?>
	</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script><!-- Sparkline -->
<!-- jvectormap -->
<script src="bower_components/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="bower_components/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
