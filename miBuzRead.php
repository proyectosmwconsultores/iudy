<?php $valor = 0; $section = "Mi Buzon"; include("head.php");
if($_SESSION['IdUsua']) {
	if($_SESSION['Permisos'] != 5) {
		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Esta en Mi Buzon, leyendo un correo');
	}

$emailLeer=$espacio->get_emailLeer($_GET['Id'],$_SESSION['IdUsua'],$_SESSION['Permisos']);
if(!$emailLeer[0]){
	echo "<script type='text/javascript'>window.location='miSend.php';</script>";
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
	        Mi Buz&oacute;n
	      </h1>
	      <ol class="breadcrumb">
	        <li><a href="welcome.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
	        <li class="active"> Mi buz&oacute;n</li>
	      </ol>
	    </section>
			<section class="content">
				<form name="frm" id="frm" action="miBuzCrear.php" method="POST" enctype="multipart/form-data">
					<input id="Mov" name="Mov" value="<?php echo $_GET['Mov'];?>" type="hidden"/>
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'] ?>" type="hidden"/>
			      <div class="row">
			        <div class="col-md-3">
			          <a onClick="window.open('miBuzon.php','_self')" href="javascript:void(0);" class="btn btn-success btn-block margin-bottom"> <i class="fa fa-fw fa-arrow-circle-left"></i> Regresar</a>
			          <div class="box box-solid">
			            <div class="box-header with-border">
			              <h3 class="box-title">Carpeta</h3>
			              <div class="box-tools">
			                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			                </button>
			              </div>
			            </div>
			            <div class="box-body no-padding">
			              <ul class="nav nav-pills nav-stacked">
			                <li><a onClick="window.open('miBuzon.php','_self')" href="javascript:void(0);"><i class="fa fa-inbox"></i> Entrada <span class="label label-primary pull-right">0</span></a></li>
			                <li class="active"><a onClick="window.open('miSend.php','_self')" href="javascript:void(0);"><i class="fa fa-envelope-o"></i> Enviados</a></li>
			              </ul>
			            </div>
			          </div>
			        </div>
			        <!-- /.col -->
			        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Leer correo enviado</h3>
              <div class="box-tools pull-right">
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
              </div>
            </div>
						<?php if($emailLeer[0]["Respuesta"] == 'SI') {
							$emailRes=$espacio->get_emailResId($emailLeer[0]["IdCorreoAnterior"]);
							?>
							<div class="box-body no-padding">
	              <div class="mailbox-read-info">
	                <h5><b>Mensaje de respuesta:</b>

	                  <span class="mailbox-read-time pull-right"><?php echo $emailLeer[0]["FecCap"]; ?></span></h5>
	              </div>

	              <div class="mailbox-read-message">
	                <?php echo $emailLeer[0]["Mensaje"]; ?>
	              </div>
	            </div>
							<hr>


							<div class="box-body no-padding" style="margin-left: 50px;">
								<h5><b>Asunto:</b> <?php echo $emailRes[0]["Asunto"]; ?></h5>
								<h5><b>De: </b> <?php echo $emailRes[0]["De"]; ?>
									<span class="mailbox-read-time pull-right"><?php echo $emailRes[0]["FecCap"]; ?></span></h5>

								<div class="box-body">
	              <blockquote>
	                <small><?php echo $emailRes[0]["Mensaje"]; ?></small>
	              </blockquote>
	            </div>




	            </div>

							<?php if($emailRes[0]["Imagen"]){ ?>
	            <div class="box-footer">
	              <ul class="mailbox-attachments clearfix">
	                <li>
	                  <div class="mailbox-attachment-info">
	                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Archivo Adjunto</a>
	                        <span class="mailbox-attachment-size">
	                          1,245 KB
	                          <a onClick="window.open('assets/docs/Email/<?php echo $emailRes[0]["Imagen"]; ?>','_blank')" href="javascript:void(0);" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
	                        </span>
	                  </div>
	                </li>
	              </ul>
	            </div> <?php } ?>



						<?php } else { ?>
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h5><b>Asunto:</b> <?php echo $emailLeer[0]["Asunto"]; ?></h5>
                <h5><b>Para: </b> <?php echo $emailLeer[0]["Para"]; ?>
                  <span class="mailbox-read-time pull-right"><?php echo $emailLeer[0]["FecCap"]; ?></span></h5>
              </div>

              <div class="mailbox-read-message">
                <?php echo $emailLeer[0]["Mensaje"]; ?>
              </div>
            </div>
						<?php if($emailLeer[0]["Imagen"]){ ?>
            <div class="box-footer">
              <ul class="mailbox-attachments clearfix">
                <li>
                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Archivo Adjunto</a>
                        <span class="mailbox-attachment-size">
                          1,245 KB
                          <a onClick="window.open('assets/docs/Email/<?php echo $emailLeer[0]["Imagen"]; ?>','_blank')" href="javascript:void(0);" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                  </div>
                </li>
              </ul>
            </div> <?php } ?>

						<?php } ?>

          </div>
        </div>
			      </div>
					</form>
      <!-- /.row -->
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
<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
</body>
<script>
  $(function () {
    $('.textarea').wysihtml5()
  })

  $(document).ready(function(){
  	var alerta = document.frm.Alerta.value;
  	if(alerta){
  		if(alerta =="0"){
  			swal("Error", "Error no se puede Enviar", "error");
  		}
  		if(alerta =="1"){
  			swal("Guardado", "Archivo guardado con exito", "success");
  		}
  	}
  });

</script>
<script>
  $(function () {
    //Add text editor
    $("#compose-textarea").wysihtml5();
  });
</script>
</html>
<?php // unset($_SESSION['Alerta']);  ?>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
