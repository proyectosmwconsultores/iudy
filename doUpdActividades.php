<?php $section = "Agregar Actividades"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por actualizar alguna actividad'); }
if($_SESSION['Permisos']) {
	if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
		$t->upd_ActividadesDoc();
		exit;
	}
$AsignacionId=$t->get_datosModuloD($_SESSION['IdAsignacion']);
$obtenerActividadId=$t->get_obtenerActividadId($_SESSION['IdAsignacion'],$_GET["IdActividad"]);
if($AsignacionId[0]["NombreMod"]) {
//$tipoDatos=$t->get_tioDatosG($_SESSION['IdAsignacion']);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
	  <?php include("menuV.php"); ?>
	  <div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo $AsignacionId[0]["NombreMod"];?>
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i><?php echo substr($AsignacionId[0]["NombreMod"], 0 , 40).' [...]';?></a></li>
			<li class="active"><a href="#">Actualizar actividad</a></li>
		  </ol>
		</section>
		<section class="content">
		  <div class="row">
				<div class="col-md-12">
			  <div class="nav-tabs-custom">
				<div class="tab-content">
				  <div class="active tab-pane" id="activity">
					<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Actualizar datos de la actividad</h3>
				</div>
				<div class="box-body">
					<form name="frm" id="frm" action="doUpdActividades.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
				  <input id="Mov" name="Mov" value="<?php echo $_GET[Mov];?>" type="hidden"/>
				  <input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
				  <input id="Variable" name="Variable" value="<?php echo $_SESSION['Variable'];?>" type="hidden"/>
				  <input id="Id" name="Id" value="<?php echo $_SESSION['IdAsignacion']; ?>" type="hidden"/>
				  <input id="IdE" name="IdE" value="<?php echo $_SESSION['IdAsignacion']; ?>" type="hidden"/>
				  <input id="IdDocente" name="IdDocente" value="<?php echo $AsignacionId[0]["IdUsua"] ?>" type="hidden"/>
					<input id="Total" name="Total" value="<?php echo $Total; ?>" type="hidden"/>
					<input id="IdActividad" name="IdActividad" value="<?php echo $_GET["IdActividad"]; ?>" type="hidden"/>
					<input id="txtTipoActividad" name="txtTipoActividad" value="<?php echo $obtenerActividadId[0]["TipoActividad"]; ?>" type="hidden"/>

				  <div class="form-group">
						<label for="inputName" class="col-sm-3 control-label">Tipo de Actividad:</label>
						<div class="col-sm-9">
						  <select class="form-control" name="txtTipoActividad2" id="txtTipoActividad2" disabled>
								<option value=""> - Seleccione - </option>
								<option value="Lectura" <?php if($obtenerActividadId[0]["TipoActividad"] == "Lectura"){?>selected="selected"<?php }?>> Lectura </option>
								<option value="Tarea" <?php if($obtenerActividadId[0]["TipoActividad"] == "Tarea"){?>selected="selected"<?php }?>> Tarea </option>
								<option value="Examen" <?php if($obtenerActividadId[0]["TipoActividad"] == "Examen"){?>selected="selected"<?php }?>> Examen </option>
								<option value="Foro" <?php if($obtenerActividadId[0]["TipoActividad"] == "Foro"){?>selected="selected"<?php }?>> Foro </option>
						  </select>
						</div>
					  </div>
					  <div class="form-group">
						<label for="inputEmail" class="col-sm-3 control-label">Fecha inicial:</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control pull-right" id="datepicker1" name="datepicker1" value="<?php echo $obtenerActividadId[0]["FecIni"]; ?>">
						</div>
					  </div>
						<?php if($obtenerActividadId[0]["TipoActividad"]!="Foro") { ?>
						<div class="form-group" name="div1" id="div1">
							<label for="inputName" class="col-sm-3 control-label">Fecha final:</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control pull-right" id="datepicker2" name="datepicker2" value="<?php echo $obtenerActividadId[0]["FecFin"]; ?>">
							</div>
					  </div>
					  <div class="form-group" name="div2" id="div2">
							<label for="inputExperience" class="col-sm-3 control-label">Modalidad:</label>
							<div class="col-sm-9">
							  <select class="form-control" name="txtModalidad" id="txtModalidad">
								<option value=""> - Seleccione - </option>
								<option value="Individual" <?php if($obtenerActividadId[0]["Modalidad"] == "Individual"){?>selected="selected"<?php }?>> Individual </option>
								<option value="Equipo" <?php if($obtenerActividadId[0]["Modalidad"] == "Equipo"){?>selected="selected"<?php }?>> Equipo </option>
							  </select>
							</div>
					  </div>
						<?php } ?>
					  <div class="form-group">
						<label for="inputSkills" class="col-sm-3 control-label">Título:</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" placeholder="Título" id="txtTitulo" name="txtTitulo" value="<?php echo $obtenerActividadId[0]["TituloActividad"]; ?>">
						</div>
					  </div>
					  <div class="form-group">
						<label for="inputSkills" class="col-sm-3 control-label">Descripción:</label>
						<div class="col-sm-9">
						  <div class="box-body pad">
								<textarea name="txtDescripcion" id="txtDescripcion" class="textarea" placeholder="Escriba la descripción de la actividad y/o mensaje" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $obtenerActividadId[0]["Descripcion"]; ?></textarea>
							</div>
						</div>
					  </div>
						<?php if($obtenerActividadId[0]["TipoActividad"]!="Foro") { ?>
					  <div class="form-group" name="div3" id="div3">
							<label for="inputSkills" class="col-sm-3 control-label">Porcentaje:</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" placeholder="00.00" id="txtPorcentaje" name="txtPorcentaje" value="<?php echo $obtenerActividadId[0]["Porcentaje"]; ?>">
							</div>
					  </div>
						<?php } ?>
					  <div class="form-group">
						<div class="col-sm-offset-6 col-sm-6">
						  <button type="button" class="btn btn-primary" onClick="val_updAddActividades()">ACTUALIZAR ACTIVIDAD</button>
						</div>
					  </div>
					</form>
				</div>
			  </div>
				  </div>
				</div>
			  </div>
			</div>
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
<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>
$(document).ready(function(){

    $("select").change(function(){
		var tipo = document.getElementById("txtTipoActividad").value;
		if(tipo=="Foro"){
			document.getElementById("div1").style.display = 'none'
			document.getElementById("div2").style.display = "none";
			document.getElementById("div3").style.display = "none";
		}
		if(tipo=="Lectura" || tipo=="Examen" || tipo=="Tarea"){
			document.getElementById("div1").style.display = "block";
			document.getElementById("div2").style.display = "block";
			document.getElementById("div3").style.display = "block";
		}
    });
});
</script>


<script>
$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	var variable = document.frm.Variable.value;
	if(alerta){
		if(alerta =="GUARDAR"){
			swal("Guardado", variable + " GUARDADO CON ÉXITO", "success");
		}
		if(alerta =="ACTUALIZAR"){
			swal("Actualizado", variable + " ACTUALIZADO CON ÉXITO", "success");
		}
		if(alerta =="ELIMINAR"){
			swal("Eliminado", variable + " ELIMINADO CON ÉXITO", "success");
		}
		if(alerta =="ERROR"){
			swal("Error", variable + " FAVOR DE COMUNICARSE CON EL ADMINISTRADOR", "error");
		}
	}
});
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()



    //Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    })
	//Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    })

  })
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
</body>
</html>
<?php
 unset($_SESSION['Alerta']); unset($_SESSION['Variable']);
 } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
}
 } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>
