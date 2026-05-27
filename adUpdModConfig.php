<?php $section = "Actualizar configurar asignatura"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por actualizar la asignación de un módulo a un docente'); }

if($_SESSION['Permisos']) {
	$datosAsigId=$t->get_datostosAsig($_GET["Id"]);


	$docentes=$t->get_Docentes();
	$tutores=$t->get_Tutores($datosAsigId[0]["IdModulo"]);
	$moduloId=$t->get_ModuloId($datosAsigId[0]["IdEducativa"],$datosAsigId[0]["IdCampus"]);
	$lstCiclo=$t->get_CicloEscolar($datosAsigId[0]["IdEducativa"]);
	//$clvGrupo=$t->get_claveGrupoA();
	$clvGrupo=$t->get_claveGrupoXA($datosAsigId[0]["IdCiclo"],$datosAsigId[0]["IdEducativa"]);

}
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Actualizar y/o cambiar asesor acad&eacute;mico
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Asignatura</a></li>
        <li class="active">Actualizar datos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Información para actualizar configuraci&oacute;n</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
					  <form name="frm" id="frm" action="adUpdModConfig.php" method="POST" enctype="multipart/form-data">
					  <input id="TipoGuardar" name="TipoGuardar" value="val_adUpdModConfig" type="hidden"/>
						<input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_GET["Id"]; ?>" type="hidden"/>
						<input id="IdOferta" name="IdOferta" value="<?php echo $datosAsigId[0]["IdEducativa"]; ?>" type="hidden"/>
						<input id="IdDocente" name="IdDocente" value="<?php echo $datosAsigId[0]["IdUsua"]; ?>" type="hidden"/>
						<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
			            <!-- <div class="col-md-4">
						  <div class="box-primary">
							  <div class="box-body">
								<div class="form-group">
									<label>Oferta educativa:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-gears"></i>
									  </div>
									  <select class="form-control" name="txtOferta" disabled id="txtOferta" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
										<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($datosAsigId[0]["IdEducativa"]==$oferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									  </select>
									</div>
								</div>
							  </div>
						  </div>
						</div> -->


						<div class="col-md-4">
						  <div class="box-primary">
							  <div class="box-body">
								<div class="form-group">
									<label>Ciclo escolar:</label>
									<div class="input-group date">
									  <div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									  </div>
										<select class="form-control" disabled name="txtCicloEscolar" id="txtCicloEscolar" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
										<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"<?php if($datosAsigId[0]["IdCiclo"]==$lstCiclo[$i]["IdCiclo"]){?>selected="selected"<?php }?>><?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
										<?php } ?>
									  </select>
									</div>
								  </div>
							  </div>
						  </div>
						</div>

						<div class="col-md-4">
						  <div class="box-primary">
							  <div class="box-body">
								<div class="form-group">
									<label>Clave del grupo:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-fw fa-key"></i>
									  </div>
									  <select class="form-control" name="txtClaveGrp" id="txtClaveGrp" disabled>
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($clvGrupo);$i++) { ?>
										<option value="<?php echo $clvGrupo[$i]["IdGrupo"]; ?>"<?php if($datosAsigId[0]["IdGrupo"]==$clvGrupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $clvGrupo[$i]["CveGrupo"]; ?></option>
										<?php } ?>
									  </select>
									</div>
								</div>
							  </div>
						  </div>
						</div>
						<div class="col-md-4">
						  <div class="box-primary">
							  <div class="box-body">
								<div class="form-group">
									<label>Asignatura:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-book"></i>
									  </div>
									  <select class="form-control" disabled name="txtModulo" id="txtModulo">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($moduloId);$i++) { ?>
										<option value="<?php echo $moduloId[$i]["IdModulo"]; ?>"<?php if($datosAsigId[0]["IdModulo"]==$moduloId[$i]["IdModulo"]){?>selected="selected"<?php }?>><?php echo $moduloId[$i]["CodeModulo"].' - '.$moduloId[$i]["NombreMod"]; ?></option>
										<?php } ?>
									  </select>
									</div>
								</div>
							  </div>
						  </div>
						</div>
						<div class="col-md-6">
						  <div class="box-primary">
							  <div class="box-body">
								<div class="form-group">
									<label>Asesor acad&eacute;mico:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-user"></i>
									  </div>
									  <select class="form-control select2" name="txtDocente" id="txtDocente" >
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($docentes);$i++) { ?>
										<option value="<?php echo $docentes[$i]["IdUsua"]; ?>"<?php if($datosAsigId[0]["IdUsua"]==$docentes[$i]["IdUsua"]){?>selected="selected"<?php } ?>><?php echo $docentes[$i]["Nombre"].' '.$docentes[$i]["APaterno"].' '.$docentes[$i]["AMaterno"]; ?></option>
										<?php } ?>
									  </select>
									</div>
								</div>
							  </div>
						  </div>
						</div>
						<div class="col-md-6">
						  <div class="box-primary">
							  <div class="box-body">
								<div class="form-group">
									<label>Coordinador académico / Tutor:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-user"></i>
									  </div>
									  <select class="form-control select2" name="txtTutor" id="txtTutor" >
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($tutores);$i++) { ?>
										<option value="<?php echo $tutores[$i]["IdUsua"]; ?>"<?php if(isset($_POST["txtTutor"])){ if($_POST["txtTutor"]==$tutores[$i]["IdUsua"]){?>selected="selected"<?php } } ?>><?php echo $tutores[$i]["Nombre"].' '.$tutores[$i]["APaterno"].' '.$tutores[$i]["AMaterno"]; ?></option>
										<?php } ?>
									  </select>
									</div>
								</div>
							  </div>
						  </div>
						</div>
						<div class="col-md-4">
						  <div class="box-primary">
							  <div class="box-body">
								<div class="form-group">
									<label>No. parcial / módulos:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									  </div>
										<select name="txt_parcial" id="txt_parcial" class="form-control select2">
											<option value="">- Seleccione -</option>
											<option value="1" <?php if($datosAsigId[0]["NoParcial"]== 1){?>selected="selected"<?php } ?>>Parcial / Módulo 1</option>
											<option value="2" <?php if($datosAsigId[0]["NoParcial"]== 2){?>selected="selected"<?php } ?>>Parcial / Módulo 2</option>
											<option value="3" <?php if($datosAsigId[0]["NoParcial"]== 3){?>selected="selected"<?php } ?>>Parcial / Módulo 3</option>
											<option value="4" <?php if($datosAsigId[0]["NoParcial"]== 4){?>selected="selected"<?php } ?>>Parcial / Módulo 4</option>
											<option value="5" <?php if($datosAsigId[0]["NoParcial"]== 5){?>selected="selected"<?php } ?>>Parcial / Módulo 5</option>
											<option value="6" <?php if($datosAsigId[0]["NoParcial"]== 6){?>selected="selected"<?php } ?>>Parcial / Módulo 6</option>
										</select>
									</div>
								</div>
							  </div>
						  </div>
						</div>

						<div class="col-md-4">
						  <div class="box-primary">
							  <div class="box-body">
								<div class="form-group">
									<label>Fecha inicial:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-user"></i>
									  </div>
									  <input type="text" name="datepicker" id="datepicker" class="form-control" value="<?php echo $datosAsigId[0]["FecIni"]; ?>">
									</div>
								</div>
							  </div>
						  </div>
						</div>
						<div class="col-md-4">
						  <div class="box-primary">
							  <div class="box-body">
								<div class="form-group">
									<label>Fecha final:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-user"></i>
									  </div>
									  <input type="text" name="datepicker2" id="datepicker2" class="form-control" value="<?php echo $datosAsigId[0]["FecFin"]; ?>">
									</div>
								</div>
							  </div>
						  </div>
						</div>




						<div class="col-md-12">
						    <div class="box-primary">
							    <div class="box-body">
									<div class="box-footer" style=" text-align: center;">
										<button type="button" class="btn btn-danger" onClick="window.open('adSelAsigMod.php','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-rotate-left"></i> REGRESAR </button>
										<button type="button" class="btn btn-success" onClick="val_adUpdModConfig()"> ACTUALIZAR </button>
									</div>
							    </div>
						    </div>
						  <!-- /.box -->
						</div>
						</form>
			<br><br><br><br>
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->

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
<!-- bootstrap time picker-->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1
<script src="bower_components/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
$(function () {
	$('.select2').select2()

})
  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
	//Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>
