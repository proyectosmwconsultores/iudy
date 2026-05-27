<?php $mnB = 4; $valor = 0; $section = "Mi Buzon Entrada"; include("head.php");
if($_SESSION['IdUsua']) {
	if($_SESSION['Permisos'] != 5) {
		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Esta en el módulo de Mi Buzón de Entrada');
	}
	unset($_SESSION['IdAsignacion']);
	unset($_SESSION['IdOferta']);
	unset($_SESSION['EstatusAsig']);
	//$checarEstatus=$t->get_checarEstatus();
	$mailEntrada=$espacio->get_mailEntrada($_SESSION['IdUsua'],$_SESSION['Permisos']);

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
	        <li><a <?php if($_SESSION['Tipo'] == 1 ) { ?> onClick="window.open('welcome.php','_self')" <?php } else { ?> onClick="window.open('clase.php','_self')" <?php } ?>><i class="fa fa-dashboard"></i> Inicio</a></li>
	        <li class="active"> Mi buz&oacute;n</li>
	      </ol>
	    </section>
			<section class="content">
      <div class="row">
				<form name="frm" id="frm" action="miBuzon.php" method="POST" enctype="multipart/form-data">
        <div class="col-md-3">
					<a onClick="window.open('miBuzCrear.php','_self')" href="javascript:void(0);" class="btn btn-primary btn-block margin-bottom">Nuevo correo</a>
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
              <h3 class="box-title">Correos de entrada</h3>
            </div>
            <div class="box-body no-padding">

							<?php if($mailEntrada[0]){ ?>
							<div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
									<tbody>
										<?php for ($i=0;$i< sizeof($mailEntrada);$i++) {
											if($mailEntrada[$i]["DeptoDe"] == 3){
												$nAlumno=$espacio->get_nombreAl($mailEntrada[$i]["IdUsua"]);
												$nombre = ' / '.$nAlumno[0]["Nombre"].' '.$nAlumno[0]["APaterno"].' '.$nAlumno[0]["AMaterno"];
											} else {
												$nombre = "";
											}
											$nAlumno=$espacio->get_nombreAl($mailEntrada[$i]["IdUsua"]);
											$nombre = ' / '.$nAlumno[0]["Nombre"].' '.$nAlumno[0]["APaterno"].' '.$nAlumno[0]["AMaterno"];

											$var = uniqid(); $var2 = uniqid(); $var3 = uniqid(); $var4 = uniqid();
											$vass = $var.$var2.$var3.$var4;
											?>
										<tr>
											<td class="mailbox-name">
												<a onClick="window.open('miBuzEntrada.php?token=<?php echo $vass; ?>&Id=<?php echo $mailEntrada[$i]["IdCorreo"]; ?>&id=<?php echo $vass; ?>','_self')" href="javascript:void(0);"><?php if($mailEntrada[$i]["Visto"] == 1) { echo "<i style='color: #3c8dbc;' class='fa fa-fw fa-circle'></i>"; } else { echo "<i style='color: #dce9f0;' class='fa fa-fw fa-circle'></i>"; } ?>
												</a>
											</td>
											<td class="mailbox-name"><a onClick="window.open('miBuzEntrada.php?token=<?php echo $vass; ?>&Id=<?php echo $mailEntrada[$i]["IdCorreo"]; ?>&id=<?php echo $vass; ?>','_self')" href="javascript:void(0);"><?php if($mailEntrada[$i]["Respuesta"] == "SI"){ echo "<i class='fa fa-reply'></i>"; } ?> <?php echo $mailEntrada[$i]["De"].' '.$nombre; ?></a></td>
											<td class="mailbox-subject"><b><?php echo $mailEntrada[$i]["Asunto"]; ?></b>
											</td>
											<td class="mailbox-attachment"> <?php if($mailEntrada[$i]["Imagen"]){ ?><i class="fa fa-paperclip"></i> <?php } ?> </td>
											<td class="mailbox-date"><?php echo tiempo_transcurrido($mailEntrada[$i]["FecCap"]); ?></td>
										</tr>
									<?php } ?>
									</tbody>
                </table>
                <!-- /.table -->
              </div>
						<?php } else { ?>
							<div class="box-body">

							              <div class="alert alert-success alert-dismissible">
							                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							                <h4><i class="icon fa fa-info"></i> Bandeja de entrada</h4>
							                Por el momento no tiene ningun correo de entrada.
							              </div>

							            </div>
						<?php } ?>

              <!-- /.mail-box-messages -->
            </div>
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
				</form>
      </div>
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
</body>
</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
