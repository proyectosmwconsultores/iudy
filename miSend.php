<?php $valor = 0; $section = "Mi Buzon Enviados"; include("head.php");
if($_SESSION['IdUsua']) {
	if($_SESSION['Permisos'] != 5) {
		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Esta en el módulo de Mi Buzón de Enviados');
	}
	unset($_SESSION['IdAsignacion']);
	unset($_SESSION['IdOferta']);
	unset($_SESSION['EstatusAsig']);
//	$checarEstatus=$t->get_checarEstatus();
	$mailEnviado=$espacio->get_mailEnviado($_SESSION['IdUsua'],$_SESSION['Permisos']);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
	      <h1>
	        Mi buz&oacute;n
	      </h1>
	      <ol class="breadcrumb">
	        <li><a <?php if($_SESSION['Tipo'] == 1 ) { ?> onClick="window.open('welcome.php','_self')" <?php } else { ?> onClick="window.open('clase.php','_self')" <?php } ?>><i class="fa fa-dashboard"></i> Inicio</a></li>
	        <li class="active"> Mi buz&oacute;n</li>
	      </ol>
	    </section>
			<section class="content">
				<form name="frm" id="frm" action="miBuzCrear.php" method="POST" enctype="multipart/form-data">
				<input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
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
		              <h3 class="box-title">Correos enviados</h3>
		            </div>
		            <div class="box-body no-padding">
									<?php if($mailEnviado[0]){ ?>
		              <div class="table-responsive mailbox-messages">
										<table class="table table-hover table-striped">
		                  <tbody>
												<?php for ($i=0;$i< sizeof($mailEnviado);$i++) {
													if($mailEnviado[$i]["DeptoPara"] == 3){
														if($mailEnviado[$i]["IdDepartamento"] == 9){
															$ngrupo=$espacio->get_grupoId($mailEnviado[$i]["IdGrupo"]);
															$nombre = "/ al grupo con Cve: ".$ngrupo[0]["CveGrupo"];
														} else {
															$nAlumno=$espacio->get_nombreAl($mailEnviado[$i]["IdUsua"]);
															$nombre = ' / '.$nAlumno[0]["Nombre"].' '.$nAlumno[0]["APaterno"].' '.$nAlumno[0]["AMaterno"];
														}
													} else {
														$nombre = "";
													}
													$var = uniqid(); $var2 = uniqid(); $var3 = uniqid(); $var4 = uniqid();
										      $vass = $var.$var2.$var3.$var4;
													  ?>
			                  <tr>
			                    <td class="mailbox-name"><a onClick="window.open('miBuzRead.php?token=<?php echo $vass; ?>&Id=<?php echo $mailEnviado[$i]["IdCorreo"]; ?>&id=<?php echo $vass; ?>','_self')" href="javascript:void(0);"><?php if($mailEnviado[$i]["Respuesta"] == 'SI') { echo "<b>Re:</b>"; } ?> <?php echo $mailEnviado[$i]["Para"].' '.$nombre; ?></a></td>
			                    <td class="mailbox-subject"><b><?php echo $mailEnviado[$i]["Asunto"]; ?></b>
			                    </td>
			                    <td class="mailbox-attachment"> <?php if($mailEnviado[$i]["Imagen"]){ ?><i class="fa fa-paperclip"></i> <?php } ?> </td>
			                    <td class="mailbox-date"><?php echo tiempo_transcurrido($mailEnviado[$i]["FecCap"]); ?></td>
			                  </tr>
											<?php } ?>
		                  </tbody>
		                </table>
		                <!-- /.table -->
		              </div>
								<?php } else { ?>
									<div class="box-body">
											<div class="alert alert-info alert-dismissible">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
												<h4><i class="icon fa fa-info"></i> Bandeja de salida</h4>
												Por el momento no ha enviado ningun correo.
											</div>
										</div>
								<?php } ?>
		            </div>
		          </div>
		        </div>
		      </div>
				</form>
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
  			swal("Enviado", "Correo enviado correctamente", "success");
  		}
  	}
  });

</script>

</html>
<?php unset($_SESSION['Alerta']);  ?>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
