<?php $section = "Agregar Tareas"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de agregar tareas'); }
if($_SESSION['Permisos']) {
	if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
		$t->add_ActividadesDoc();
		exit;
	}
$AsignacionId=$t->get_datosModuloD($_SESSION['IdAsignacion']);
$TareasAsiganadas=$t->get_obtenerActividades($_SESSION['IdAsignacion'],"Todas");
if($AsignacionId[0]["NombreMod"]) {
$idV = $_SESSION['IdAsignacion'];
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
	  <?php include("menuV.php"); ?>
	  <div class="content-wrapper">
			<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo $AsignacionId[0]["NombreMod"];?>
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i><?php echo substr($AsignacionId[0]["NombreMod"], 0 , 40).' [...]';?></a></li>
			<li class="active"><a href="#">Agregar tareas</a></li>
		  </ol>
		</section>
		<section class="content">
		  <div class="row">
			<div class="col-md-12">

			  <div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
				  <li class="active"><a href="#activity" data-toggle="tab">Lista de tareas</a></li>
				  <?php if($_SESSION['EstatusAsig']=="A"){ ?>
						<li><a href="#settings" data-toggle="tab">Agregar tarea</a></li>
					<?php } ?>
				</ul>
				<div class="tab-content">
				  <div class="active tab-pane" id="activity">
					<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Tareas recientes</h3>
				</div>
				<div class="box-body">
				  <table class="table table-bordered">
					<tr>
					  <th style="width: 10px">No</th>
					  <th>Tarea</th>
					  <th>Tipo</th>
					  <th>Inicio</th>
					  <th>Modalidad</th>
						<th>Estatus</th>
						<?php if($_SESSION['EstatusAsig']=="A"){ ?>
					  <th>Opciones</th>
						<?php } ?>
					</tr>
					<?php for ($i=0;$i< sizeof($TareasAsiganadas);$i++) { ?>
					<tr>
					  <td><?php echo $i+1; ?></td>
					  <td><?php echo $TareasAsiganadas[$i]["TituloActividad"];?></td>
					  <td><?php echo $TareasAsiganadas[$i]["TipoActividad"];?></td>
					  <td><?php echo $TareasAsiganadas[$i]["FecIni"]; if(($TareasAsiganadas[$i]["FecFin"]) && ($TareasAsiganadas[$i]["FecFin"] !="0000-00-00") ){ echo ' / '.$TareasAsiganadas[$i]["FecFin"]; } else { echo ''; }?></td>
					  <td><?php echo $TareasAsiganadas[$i]["Modalidad"];?></td>
						<td><?php echo $TareasAsiganadas[$i]["Estatus"];?></td>
						<?php if($_SESSION['EstatusAsig']=="A"){ ?>
						<td>
							<a onClick="window.open('doUpdActividades.php?IdActividad=<?php echo $TareasAsiganadas[$i]["IdActividad"]; ?>','_self')" href="javascript:void(0);">
								<button title="Configurar examen" type="button" class="btn btn-default"><i class="fa fa-edit"></i></button>
							</a>
							<?php if($TareasAsiganadas[$i]["TipoActividad"]=="Examen") { ?>
								<a onClick="window.open('doAddConfigExamen.php?NoActividad=<?php echo $TareasAsiganadas[$i]["NoActividad"]; ?>','_self')" href="javascript:void(0);">
									<button title="Configurar examen" type="button" class="btn btn-default"><i class="fa fa-gears"></i></button>
								</a>
							<?php } ?>
						</td>
						<?php } ?>
					</tr>
					<?php $Total = $TareasAsiganadas[$i]["Porcentaje"] + $Total; } ?>
				  </table>
				</div>
				<?php if($Total) { ?>
				<div class="box-body">
              <p>Total porcentaje: <?php echo $Total; ?> % </p>
              <div class="progress active">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $Total; ?>%">
                  <span class="sr-only"><?php echo $Total; ?> Complete</span>
                </div>
              </div>
            </div>
				<?php } ?>
			  </div>
				  </div>


				  <div class="tab-pane" id="settings">
				  <form name="frm" id="frm" action="doAddActividades.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
				  <input id="Mov" name="Mov" value="<?php echo $_GET[Mov];?>" type="hidden"/>
				  <input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
				  <input id="Variable" name="Variable" value="<?php echo $_SESSION['Variable'];?>" type="hidden"/>
				  <input id="Id" name="Id" value="<?php echo $_SESSION['IdAsignacion']; ?>" type="hidden"/>
				  <input id="IdE" name="IdE" value="<?php echo $_SESSION['IdAsignacion']; ?>" type="hidden"/>
				  <input id="IdDocente" name="IdDocente" value="<?php echo $AsignacionId[0]["IdUsua"] ?>" type="hidden"/>
					<input id="Total" name="Total" value="<?php echo $Total; ?>" type="hidden"/>

				  <div class="form-group">
						<label for="inputName" class="col-sm-3 control-label">Tipo de tarea:</label>
						<div class="col-sm-9">
						  <select class="form-control" name="txtTipoActividad" id="txtTipoActividad">
							<option value=""> - Seleccione - </option>
							<option value="Lectura"> Lectura </option>
							<option value="Tarea"> Tarea </option>
							<option value="Examen"> Examen </option>
							<option value="Foro"> Foro </option>
						  </select>
						</div>
					  </div>
					  <div class="form-group">
						<label for="inputEmail" class="col-sm-3 control-label">Fecha inicial:</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control pull-right" id="datepicker1" name="datepicker1">
						</div>
					  </div>
					  <div class="form-group" name="div1" id="div1">
						<label for="inputName" class="col-sm-3 control-label">Fecha final:</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control pull-right" id="datepicker2" name="datepicker2">
						</div>
					  </div>

						<div class="form-group" name="div2" id="div2">
							<label for="inputExperience" class="col-sm-3 control-label">Modalidad:</label>
							<div class="col-sm-9">
							  <select class="form-control" name="txtModalidad" id="txtModalidad">
								<option value=""> - Seleccione - </option>
								<option value="Individual"> Individual </option>
								<option value="Equipo"> Equipo </option>
								<!--<option value="Grupal"> Grupal </option>-->
							  </select>
							</div>
					  </div>
						<div class="form-group" name="div4" id="div4">
							<label for="inputExperience" class="col-sm-3 control-label">Duración del examen:</label>
							<div class="col-sm-9">
							  <select class="form-control" name="txtDuracion" id="txtDuracion">
								<option value=""> - Seleccione - </option>
								<option value="1"> 1 hra </option>
								<option value="2"> 2 hra </option>
								<option value="3"> 3 hra </option>
								<option value="4"> 4 hra </option>
								<option value="5"> 5 hra </option>
								<option value="10"> 10 hras </option>
							  </select>
							</div>
					  </div>
					  <div class="form-group">
						<label for="inputSkills" class="col-sm-3 control-label">Título:</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" placeholder="Título" id="txtTitulo" name="txtTitulo">
						</div>
					  </div>
					  <div class="form-group">
						<label for="inputSkills" class="col-sm-3 control-label">Descripción:</label>
						<div class="col-sm-9">
						  <div class="box-body pad">
								<textarea name="txtDescripcion" id="txtDescripcion" class="textarea" placeholder="Escriba la descripción de la actividad y/o mensaje" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
							</div>
						</div>
					  </div>
					  <div class="form-group" name="div3" id="div3">
						<label for="inputSkills" class="col-sm-3 control-label">Porcentaje:</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" placeholder="00.00" id="txtPorcentaje" name="txtPorcentaje">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-6 col-sm-6">
						  <button type="button" class="btn btn-primary" onClick="val_doAddActividades()"> AGREGAR </button>
						</div>
					  </div>
					</form>
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
			document.getElementById("div4").style.display = "none";
		}
		if(tipo=="Lectura" || tipo=="Examen" || tipo=="Tarea"){
			document.getElementById("div1").style.display = "block";
			document.getElementById("div2").style.display = "block";
			document.getElementById("div3").style.display = "block";
			document.getElementById("div4").style.display = "none";
		}
		if(tipo=="Examen"){
			document.getElementById("div4").style.display = "block";
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
