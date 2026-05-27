<?php $valor = 0; $section = "Mi Buzon"; include("head.php");
if($_SESSION['IdUsua']) {
	if($_SESSION['Permisos'] != 5) {
		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Esta en Mi Buzon, leyendo un correo');
	}

	$emailLeer=$espacio->get_emailLeerEntrda($_GET['Id'],$_SESSION['IdUsua']);
  $emailVisto=$espacio->get_emailVisto($_GET['Id'],$_SESSION['IdUsua']);


if(isset($_POST["Mov"]) && $_POST["Mov"]=="saveRespuesta"){
  $espacio->add_respuesta();
  exit;
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
				<form name="frm" id="frm" action="miBuzEntrada.php" method="POST" enctype="multipart/form-data">
					<input id="Mov" name="Mov" value="<?php echo $_GET['Mov'];?>" type="hidden"/>
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'] ?>" type="hidden"/>
					<input id="IdCorreo" name="IdCorreo" value="<?php echo $_GET['Id']; ?>" type="hidden"/>
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
			                <li class="active"><a onClick="window.open('miBuzon.php','_self')" href="javascript:void(0);"><i class="fa fa-inbox"></i> Entrada <span class="label label-primary pull-right">0</span></a></li>
			                <li><a onClick="window.open('miSend.php','_self')" href="javascript:void(0);"><i class="fa fa-envelope-o"></i> Enviados</a></li>
			              </ul>
			            </div>
			          </div>
			        </div>
			        <!-- /.col -->
			        <div class="col-md-9">
		          <div class="box box-primary">
		            <div class="box-header with-border">
		              <h3 class="box-title">Leer correo de entrada</h3>
		              <div class="box-tools pull-right">
		                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
		                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
		              </div>
		            </div>
								<?php

								$mailPrincipal=$espacio->get_emailResId($emailLeer[0]["IdCorreoPrincipal"]);
								$mailDeptoDe=$espacio->get_mailDe($mailPrincipal[0]["DeptoDe"]);
								$mailDeptoPara=$espacio->get_mailDe($mailPrincipal[0]["DeptoPara"]);

								if(($mailPrincipal[0]["DeptoDe"] == 3) || ($mailPrincipal[0]["DeptoDe"] == 2)){
									$nAlumno=$espacio->get_nombreAl($mailPrincipal[0]["IdUsua"]);
									$nombre = ' / '.$nAlumno[0]["Nombre"].' '.$nAlumno[0]["APaterno"].' '.$nAlumno[0]["AMaterno"];
								} else {
									$nombre = "";
								}

								if($mailDeptoPara[0]["NomDepartamento"] == "Alumno"){
									$nAlumnox=$espacio->get_nombreAl($mailPrincipal[0]["IdUsua"]);
									$nombrex = ' / '.$nAlumnox[0]["Nombre"].' '.$nAlumnox[0]["APaterno"].' '.$nAlumnox[0]["AMaterno"];
								} else { $nombrex = ""; }

								?>
								<div class="form-group" name="imgLoadDoc" id="imgLoadDoc" style="display: none;">
									<div class="col-sm-12" style="text-align: center;">
											<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
									</div>
								</div>
		            <div class="box-body no-padding">
		              <div class="mailbox-read-info">
										<h5><b>Asunto:</b> <?php echo $emailLeer[0]["Asunto"]; ?></h5>
										<h5><b>De: </b> <?php echo $mailDeptoDe[0]["NomDepartamento"].' '.$nombre; ?>
										<h5><b>Para: </b> <?php echo $mailDeptoPara[0]["NomDepartamento"].' '.$nombrex; ?>
		                  <span class="mailbox-read-time pull-right"><?php echo $emailLeer[0]["FecCap"]; ?></span></h5>
		              </div>
		              <div class="mailbox-read-message">
		                <?php echo $emailLeer[0]["Mensaje"]; ?>
		              </div>
		            </div>
								<?php if($emailLeer[0]["IdCorreoAnterior"]) {
									$emailRespuesta=$espacio->get_emailResId($emailLeer[0]["IdCorreoAnterior"]);
									?>
								<hr>
								<!-- RESPUESTA DEL CORREO SI EXISTE-->
								<div class="box-body">
								              <blockquote>
								                <p>Respuesta: <span class="mailbox-read-time pull-right"><?php echo $emailRespuesta[0]["FecCap"]; ?></span></p>
								                <small><?php echo $emailRespuesta[0]["Mensaje"]; ?></small>
																<br>
																<?php if($emailRespuesta[0]["Imagen"]){ ?>
										            <div class="box-footer" style="padding-left: 50px!important;">
										              <ul class="mailbox-attachments clearfix">
										                <li>
										                  <div class="mailbox-attachment-info">
										                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Archivo Adjunto</a>
										                        <span class="mailbox-attachment-size">
										                          1,245 KB
										                          <a onClick="window.open('assets/docs/Email/<?php echo $emailRespuesta[0]["Imagen"]; ?>','_blank')" href="javascript:void(0);" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
										                        </span>
										                  </div>
										                </li>
										              </ul>
										            </div> <?php } ?>
								              </blockquote>
								            </div>




							<?php } else { ?>
								<div class="box-footer">
              <div class="pull-right">
                <button name="btnResponder" id="btnResponder" type="button" class="btn btn-danger view_responder" href="javascript:void(0);" name="view" value="view" id="1"><i class="fa fa-share"></i> Responder</button>
              </div>
							<div class="col-md-12" id="div12" name="div12" style="display: none;">
			          <div class="form-group">
			            <label>Respuesta:</label>
			            <div class="input-group">
			              <div class="input-group-addon">
			                <i class="fa fa-commenting"></i>
			              </div>
			              <textarea class="form-control" id="inputExperience" name="inputExperience" placeholder="Respuesta del correo"></textarea>
			            </div>
			          </div>
			        </div>
							<div class="col-md-4" name="div4" id="div4" style="display: none;">
			          <div class="form-group">
			            <label>&nbsp;</label>
			            <div class="input-group">
			              <button type="button" class="btn btn-block btn-primary" onClick="val_responderEmail()"> RESPONDER</button>
			            </div>
			          </div>
			        </div>

            </div>
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

$(document).ready(function(){
		 $(document).on('click', '.view_responder', function(){

			 document.getElementById("btnResponder").style.display = 'none';
			 document.getElementById("div12").style.display = 'block';
			 document.getElementById("div4").style.display = 'block';

		 });
});

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
