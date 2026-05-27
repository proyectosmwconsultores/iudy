<?php $mnAl = 6; $section = "Foro"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está observando los avisos'); }
if(!$_SESSION['IdAsignacion']){
	$_SESSION['IdAsignacion'] = $_GET["Id"];
}

if(!$_SESSION['EstatusAsig']){
	$_SESSION['EstatusAsig'] = $_GET["T"];
}
//unset($_SESSION['IdAsignacion']);

if($_SESSION['Permisos']) {
	$AsignacionId=$t->get_datosModuloD($_SESSION['IdAsignacion']);
	$_SESSION['IdOferta'] = $AsignacionId[0]["IdEducativa"];
	if($AsignacionId[0]["NombreMod"]) {
	$viewAvisos=$t->get_viewAvisos($_SESSION['IdAsignacion']);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini">
	<div class="wrapper">
	<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
			<section class="content-header">
				<h1>Avisos</h1>
				<ol class="breadcrumb">
					<li><a <?php if($_SESSION['Tipo'] == 1 ) { ?> onClick="window.open('welcome.php','_self')" <?php } else { ?> onClick="window.open('clase.php','_self')" <?php } ?>><i class="fa fa-dashboard"></i>Inicio</a></li>
					<li class="active">Avisos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<?php if($viewAvisos[0]){ ?>
						<?php for ($i=0;$i< sizeof($viewAvisos);$i++) { ?>
						<div class="col-md-12">
							<div class="box box-widget">
								<div class="box-header with-border">
									<div class="user-block">
										<img class="img-circle" src="assets/perfil/<?php echo $viewAvisos[$i]["Foto"];?>" alt="User Image">
										<span class="username"><a href="#"><?php echo $viewAvisos[$i]["Nombre"].' '.$viewAvisos[$i]["APaterno"].' '.$viewAvisos[$i]["AMaterno"];?></a></span>
										<span class="description">Publicado hace <?php echo tiempo_transcurrido($viewAvisos[$i]["FecCap"]); ?></span>
									</div>
									<div class="box-tools">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
										<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
									</div>
								</div>
								<div class="box-body" style="">
									<h4 class="attachment-heading"><i class="fa fa-fw fa-gg-circle"></i> <?php echo $viewAvisos[$i]["Titulo"]; ?></h4>
									<p><?php echo $viewAvisos[$i]["Mensaje"];?></p>
								</div>
							</div>
						</div>
						<?php } ?>


				<?php } else { ?>
					<div class="col-md-12">
						<div class="box box-widget">
							<div class="box-header with-border">
								<div class="user-block">
									<img class="img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="User Image">
									<span class="username"><a href="#">No hay avisos</a></span>
									<span class="description"></span>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				</div>
			</section>
		</div>
	<?php include("footer.php"); ?>
	</div>
</body>





<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

</body>
</html>
<?php } else {
echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
}
} else {
echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>
