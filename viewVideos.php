<?php $_v = 919; $section = "Videos de ayuda"; include("head.php");
if($_SESSION['IdUsua']) {

		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Esta en visualizando los videos de ayuda.');

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<form name="frm" id="frm" action="viewFinalizados.php" method="POST" enctype="multipart/form-data">
			<section class="content-header">
				<h1>Lista de videos de ayuda</h1>
				<ol class="breadcrumb">
					<li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
					<li class="active">Video de ayuda</li>
				</ol>
			</section>
			<section class="content">
					<div class="row">
						<div class="col-md-3 col-sm-6 col-xs-12" onclick="ver_video_ayuda(1)" style="cursor: pointer;">
							<div class="info-box">
							<span class="info-box-icon bg-aqua"><i class="fa fa-file-video-o"></i></span>
							<div class="info-box-content">
							<span class="info-box" style="text-align: center;"><b>Conocer mi plataforma, subir tareas</b></span>
							</div>

							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12" onclick="ver_video_ayuda(2)" style="cursor: pointer;">
							<div class="info-box">
							<span class="info-box-icon bg-red"><i class="fa fa-file-video-o"></i></span>
							<div class="info-box-content">
							<span class="info-box" style="text-align: center;"><b>Conocer mi espacio en la plataforma</b></span>
							</div>
							</div>
						</div>
				</div>
			</section>
			<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
								 <div class="modal-content">
											<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
													 <button type="button" class="close" data-dismiss="modal">&times;</button>
													 <h4 class="modal-title">Video de ayuda</h4>
											</div>
											<div class="modal-body" id="employee_detail">
								 			</div>
									</div>
					</div>
			 </div>
		</form>
		</div>
	  <?php include("footer.php"); ?>
	</div>


<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script><!-- Sparkline -->
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
function ver_video_ayuda(Video){
	$.ajax({
		url:"formConsulta/video_ayuda.php",
		method:"POST",
			 data:{Video:Video},
			 success:function(data){
						$('#employee_detail').html(data);
						$('#dataModal').modal('show');
			 }
	});
}

</script>
</body>
</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
