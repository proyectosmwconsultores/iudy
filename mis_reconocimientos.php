<?php $_v = 68; $section = "Mis reconocimientos"; include("head.php");
if($_SESSION['IdUsua']) {
	$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en visualizando sus reconocimientos.');
	$rec=$espacio->get_mis_reco($_SESSION['IdUsua']);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">

		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Mis reconocimientos
					<!-- <small>reconocimientos</small> -->
				</h1>

			</section>
			<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
							<div class="box-footer">
								<div class="post">
									<div class="user-block">
										<img class="img-circle img-bordered-sm" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="User Image">
										<span class="username">
										<a href="#"><?php echo $_SESSION['NombreUser']; ?></a>
										</span>
										<span class="description">Mis reconocimientos mas recientes</span>
									</div>
									<hr>
									<ul class="mailbox-attachments clearfix">
										<?php for ($i=0;$i< sizeof($rec);$i++) { ?>
										<li id="rec_<?php echo $rec[$i]['IdReconocimiento']; ?>" onclick="ver_reconocimiento(<?php echo $rec[$i]['IdReconocimiento']; ?>)" href="javascript:void(0);" style="height: 200px; cursor: pointer;">
											<?php if($rec[$i]['Formato'] == 'pdf'){ ?>
											<span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
											<?php } else { ?>
												<span class="mailbox-attachment-icon has-img"><img style="height: 133px;" src="assets/docs/files/<?php echo $rec[$i]['Anio'].'/'.$rec[$i]['Mes'].'/'.$rec[$i]['Archivo']; ?>" alt="Attachment"></span>
											<?php } ?>
												<div class="mailbox-attachment-info">
													<span class="mailbox-attachment-size"> <?php echo obtenerFechaCorta($rec[$i]['Fecha']); ?> </span>
												</div>
										</li><?php } ?>
									</ul>


									</div>


								</div>
							</div>

							</div>
					</div>
			</section>
		</div>
	  <?php include("footer.php"); ?>
	</div>
	<div id="dataEncRec" class="modal fade"> <!--MODAL ME GUSTA-->
			 <div class="modal-dialog">
						<div class="modal-content">
								 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title"><i class="fa fa-fw fa-trophy"></i> <b id="_prex"></b></h4>
								 </div>
								 <div class="modal-body" id="employee_EncRec">
								 </div>
						</div>
			 </div>
	</div>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script><!-- Sparkline -->
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<script>
	function ver_reconocimiento(IdReconocimiento){
		$.ajax({
				 url:"formConsulta/ver_reconocimiento_asesor.php",
				 method:"POST",
				 data:{IdReconocimiento:IdReconocimiento},
				 success:function(data){
							$('#employee_EncRec').html(data);
							$('#dataEncRec').modal('show');
				 }
		});
	}
</script>
</body>
</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
