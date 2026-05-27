<?php $valor = 0; $section = "Mi Buzon Entrada"; include("head.php");
if($_SESSION['IdUsua']) {
	if($_SESSION['Permisos'] != 5) {
		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Esta en el módulo de Mi Buzón de Entrada');
	}
	unset($_SESSION['IdAsignacion']);
	unset($_SESSION['IdOferta']);
	unset($_SESSION['EstatusAsig']);
	//$checarEstatus=$t->get_checarEstatus();
	$departamento=$espacio->get_departamento($_SESSION['Permisos']);
	$grupo=$espacio->get_grupoLSTT();

if(isset($_POST["Mov"]) && $_POST["Mov"]=="envCorreo"){
  $espacio->add_envCorreo();
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
				<form name="frm" id="frm" action="miBuzCrear.php" method="POST" enctype="multipart/form-data">
					<input id="Mov" name="Mov" value="<?php echo $_GET['Mov'];?>" type="hidden"/>
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'] ?>" type="hidden"/>
					<input id="Permisos" name="Permisos" value="<?php echo $_SESSION['Permisos'] ?>" type="hidden"/>
					<input id="Tipo" name="Tipo" value="0" type="hidden"/>
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
			                <li><a onClick="window.open('miSend.php','_self')" href="javascript:void(0);"><i class="fa fa-envelope-o"></i> Enviados</a></li>
			              </ul>
			            </div>
			          </div>
			        </div>
			        <!-- /.col -->
			        <div class="col-md-9">
								<div class="row">
			          <div class="box box-primary">
			            <div class="box-header with-border">
			              <h3 class="box-title">Crear nuevo correo</h3>
			            </div>

			            <div class="box-body">
										<div class="col-md-6">
										  <div class="box-primary">
												<div class="form-group">
													<label>Enviar a:</label>
													<div class="input-group">
													  <div class="input-group-addon"><i class="fa fa-book"></i></div>
														<select class="form-control" name="txtDepartamento" id="txtDepartamento">
															<option value="0"> - Seleccione -</option>
															<?php for ($i=0;$i< sizeof($departamento);$i++) { ?>
															<option value="<?php echo $departamento[$i]["IdDepartamento"]; ?>"<?php if($_POST[txtDepartamento]==$departamento[$i]["IdDepartamento"]){?>selected="selected"<?php }?>><?php echo $departamento[$i]["NomDepartamento"]; ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
										  </div>
										</div>
										<div class="col-md-6" name="divGrupo" id="divGrupo" style=" display: none;">
										  <div class="box-primary">
												<div class="form-group">
													<label>Grupo:</label>
													<div class="input-group">
													  <div class="input-group-addon"><i class="fa fa-book"></i></div>
														<select class="form-control" name="txtGrupo" id="txtGrupo">
															<option value=""> - Seleccione -</option>
															<?php for ($i=0;$i< sizeof($grupo);$i++) { ?>
															<option value="<?php echo $grupo[$i]["IdGrupo"]; ?>"<?php if($_POST[txtGrupo]==$grupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $grupo[$i]["CveGrupo"].'-'.$grupo[$i]["Grupo"]; ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
										  </div>
										</div>

										<div class="col-md-12" name="divAlumno" id="divAlumno" style=" display: none;">
										  <div class="box-primary">
												<div class="form-group">
													<label>Alumno:</label>
													<div class="input-group">
													  <div class="input-group-addon"><i class="fa fa-user"></i></div>
														<select class="form-control" name="txtAlumno" id="txtAlumno"></select>
													</div>
												</div>
										  </div>
										</div>


										<div class="form-group">

			              </div>



										<div class="form-group" name="imgLoadDoc" id="imgLoadDoc" style="display: none;">
		                  <div class="col-sm-12" style="text-align: center;">
		                      <img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
		                  </div>
		                </div>
			              <div class="form-group">
			                <input class="form-control" id="txtAsunto" name="txtAsunto" placeholder="Asunto:">
			              </div>
			              <div class="form-group">
			                  <textarea id="compose-textarea" name="compose-textarea" class="form-control" style="height: 100px"></textarea>
			              </div>
			              <!--<div class="form-group">
			                <div class="btn btn-default btn-file">
			                  <i class="fa fa-paperclip"></i> Imagen
			                  <input type="file" name="foto" id="foto" onchange="valImagenPago(this);">
			                </div>
			                <p class="help-block">Max. 2MB / Tipo imagen: jpg, png.</p>
			              </div>-->
			            </div>
			            <!-- /.box-body -->
			            <div class="box-footer">
			              <div class="pull-right">
			                <button name="btnCorreo" id="btnCorreo" type="button" onClick="val_newCorreo()" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Enviar</button>
			              </div>
			              <button name="btnAtras" id="btnAtras" onClick="window.open('miBuzon.php','_self')" href="javascript:void(0);" type="reset" class="btn btn-default"><i class="fa fa-times"></i> Cancelar</button>
			            </div>
			            <!-- /.box-footer -->
			          </div>
			          <!-- /. box -->
			        </div>
			        <!-- /.col -->
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
	$("#txtDepartamento").change(function () {
		$("#txtDepartamento option:selected").each(function () {
			id_Departamento = $(this).val();
			if((id_Departamento == 9) || (id_Departamento == 10)){
				document.getElementById("divGrupo").style.display = 'block';
				document.getElementById("Tipo").value = '1';
			} else {
				document.getElementById("divGrupo").style.display = 'none';
				document.getElementById("Tipo").value = '0';
			}
		});
	})
});

$(document).ready(function(){
  	$("#txtGrupo").change(function () {
  		$("#txtGrupo option:selected").each(function () {
				var idDepto = document.getElementById("txtDepartamento").value;
				if(idDepto == 10){
					document.getElementById("Tipo").value = '2';
					document.getElementById("divAlumno").style.display = 'block';
					id_grupo = $(this).val();
	  			$.post("formConsulta/getAlumno.php", { id_grupo: id_grupo }, function(data){
	  				$("#txtAlumno").html(data);
	  			});
				} else {
					document.getElementById("divAlumno").style.display = 'none';
					document.getElementById("Tipo").value = '1';
				}
  		});
  	})
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
