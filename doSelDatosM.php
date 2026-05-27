<?php $section = "Datos del Módulos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por actualizar datos del módulo'); }
$datDocents = $t->get_datDocnts($_SESSION['IdAsignacion']);
$datVideos = $t->get_datVideos($_SESSION['IdAsignacion']);
if($_SESSION['Permisos']) {
	if(isset($_POST["Mov"]) && $_POST["Mov"]=="Actualizar"){
		$t->act_ModuloDatosDoc();
		exit;
	}

if(isset($_POST["Mov2"]) && $_POST["Mov2"]=="subVideo"){
  $espacio->add_video();
  exit;
}
$AsignacionId=$t->get_datosModuloD($_SESSION['IdAsignacion']);
if($AsignacionId[0]["NombreMod"]) {
$tipoDatos=$t->get_tioDatosG($_SESSION['IdUsua']);
$moduloDatos=$t->get_datosModulo($AsignacionId[0]["IdEducativa"],$AsignacionId[0]["IdModulo"]);
$idV = $_SESSION['IdAsignacion'];
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">

  <?php include("menuV.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $AsignacionId[0]["NombreMod"];?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php echo substr($AsignacionId[0]["NombreMod"], 0 , 40).' [...]';?></a></li>
				<li  class="active"><a href="#">Informaci&oacute;n general</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-12">

          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
							<?php if($configuracion[28]["Descripcion"] == "SI") { $condA = ""; $cond1A = "active "; $cond1B = "";?>
							<li class="active"><a href="#videos" data-toggle="tab">Videos</a></li>
						<?php } else {
							$condA = "class='active'"; $cond1A=""; $cond1B = "active ";
						}	 ?>

              <li <?php echo $condA; ?> ><a href="#activity" data-toggle="tab">Carta descriptiva</a></li>
							<?php if($_SESSION['EstatusAsig']=="A"){ ?>
							<li><a href="#settings" data-toggle="tab">Modificar</a></li>
							<?php } ?>
							<li><a href="#timeline" data-toggle="tab">Personal</a></li>

            </ul>
			<form name="frm" id="frm" action="doSelDatosM.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
            <div class="tab-content">
							<div class="<?php echo $cond1A; ?>tab-pane" id="videos">
			                <div class="row">
												<div class="col-md-6">
													  <div class="box-primary" style="padding: 10px;">
															<input id="Mov2" name="Mov2" value="<?php echo $_GET['Mov'];?>" type="hidden"/>
									              <div class="box-body" >
												  					<div class="form-group" name="imgLoadDoDoc" id="imgLoadDoDoc" style="display: none;">
									                    <div class="col-sm-12" style="text-align: center;">
									                        <img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
									                    </div>
									                  </div>
									                <div class="form-group">
									                  <label for="exampleInputEmail1">Nombre del video:</label>
									                  <input class="form-control" id="txtTitulo" name="txtTitulo" placeholder="Nombre del video" type="email">
									                </div>

									              </div>


									          </div>
													</div>

													<div class="col-md-6">
														  <div class="box-primary" style="padding: 10px;">
										              <!-- <div class="box-body" >

										                <div class="form-group">
										                  <label for="exampleInputFile">Buscar video</label>
										                  <input id="txtDocumento" name="txtDocumento" type="file" onchange="validarVideo(this,'txtDocumento');">

										                  <p class="help-block">Seleccione el video y/o audio que desea subir (mp4, mp3).</p>
										                </div>

										              </div> -->
										              <div class="box-footer">
																		<br>
										                <button type="button" onClick="val_addVideo()" class="btn btn-primary">Guardar nombre del video</button>
										              </div>

										          </div>
														</div>
														<div class="col-md-12">
															  <div class="box-primary" style="padding: 10px;">
											              <div class="box-body" >
																			<table class="table table-bordered">
												                 <tbody><tr>
												                   <th style="width: 10px">#</th>
																					 <th>Nombre del video:</th>
																					 <th>Publicado por:</th>
																					 <th>Cargo:</th>
																					 <th>Fecha publicaci&oacute;n:</th>
												                   <th>Opciones</th>
												                 </tr>
																				 <?php for ($i=0;$i< sizeof($datVideos);$i++) { $IdR = $datVideos[$i]["IdVideo"]; ?>
																					 <tr id="<?php echo $IdR; ?>">
													                   <td style="width: 10px"><?php echo $i + 1; ?></td>
																						 <td><?php echo $datVideos[$i]["Titulo"]; ?></td>
																						 <td><?php echo $datVideos[$i]["Nombre"].' '.$datVideos[$i]["APaterno"].' '.$datVideos[$i]["AMaterno"]; ?></td>
																						 <td><?php echo $datVideos[$i]["Cargo"]; ?></td>
																						 <td><?php echo $datVideos[$i]["FecCap"]; ?></td>
													                   <td>
																							 <?php if($datVideos[$i]["Link"]) { ?>
																							<a class="btn btn-app view_tutor" href="javascript:void(0);" name="view" value="view" id="<?php echo $datVideos[$i]["IdVideo"]; ?>">
																							 <span class="badge bg-purple"></span>
																							 <i class="fa fa-file-video-o"></i> Video
																						 </a><?php } ?>
																						 <a class="btn btn-app view_subir" href="javascript:void(0);" name="view" value="view" id="<?php echo $datVideos[$i]["IdVideo"]; ?>">
																							<span class="badge bg-purple"></span>
																							<i class="fa fa-refresh"></i> Subir
																						</a>
																							<a class="btn btn-app" onClick="val_delVideo(<?php echo $IdR; ?>)" name="add" id="add">
																							 <span class="badge bg-purple"></span>
																							 <i class="fa fa-trash"></i> Video
																						 </a>
																							 </td>
													                 </tr>
																				<?php } ?>
												               </tbody></table>
											              </div>
											          </div>
															</div>

			                </div>
			              </div>
              <div class="<?php echo $cond1B; ?>tab-pane" id="activity">

								<div class="box box-solid">
									<div class="box-header with-border">
										<i class="fa fa-fw fa-globe"></i>
										<h3 class="box-title">Objetivo:</h3>
									</div>
									<div class="box-body">
										<p><?php echo $moduloDatos[0]["Objetivo"]; ?></p>
									</div>
								</div>

								<div class="box box-solid">
									<div class="box-header with-border">
										<i class="fa fa-fw fa-server"></i>
										<h3 class="box-title">Temas:</h3>
									</div>
									<div class="box-body">
										<p><?php echo $moduloDatos[0]["Tema"]; ?></p>
									</div>
								</div>
								<div class="box box-solid">
									<div class="box-header with-border">
										<i class="fa fa-fw fa-server"></i>
										<h3 class="box-title">Evaluaci&oacute;n:</h3>
									</div>
									<div class="box-body">
										<p><?php echo $moduloDatos[0]["Evaluacion"]; ?></p>
									</div>
								</div>

								<div class="box box-solid">
									<div class="box-header with-border">
										<i class="fa fa-fw fa-info-circle"></i>
										<h3 class="box-title">Metodolog&iacute;a:</h3>
									</div>
									<div class="box-body">
										<p><?php echo $moduloDatos[0]["Metodologia"]; ?></p>
									</div>
								</div>

								<div class="box box-solid">
									<div class="box-header with-border">
										<i class="fa fa-fw fa-bookmark"></i>
										<h3 class="box-title">Bibliograf&iacute;a:</h3>
									</div>
									<div class="box-body">
										<p><?php echo $moduloDatos[0]["Bibliografia"]; ?></p>
									</div>
								</div>

              </div>


              <div class="tab-pane" id="settings">

			  <input id="Mov" name="Mov" value="<?php echo $_GET[Mov];?>" type="hidden"/>
			  <input id="IdDatosM" name="IdDatosM" value="<?php echo $moduloDatos[0]["IdDatosM"];?>" type="hidden"/>
			  <input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
			  <input id="Variable" name="Variable" value="<?php echo $_SESSION['Variable'];?>" type="hidden"/>
			  <input id="Id" name="Id" value="<?php echo $_SESSION['IdAsignacion']; ?>" type="hidden"/>
			  <input id="IdE" name="IdE" value="<?php echo $_SESSION['IdAsignacion']; ?>" type="hidden"/>
			  <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
				<div class="col-md-12">
					<div class="box">
						<div class="box-header">
							<label>Objetivos del módulo</label>
						</div>
						<div class="box-body pad">
							<textarea name="txtObjetivo" id="txtObjetivo" class="textarea" placeholder="Escriba los objetivos del modulo" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $moduloDatos[0]["Objetivo"]; ?></textarea>
						</div>
				  </div>
				</div>
				<div class="col-md-12">
				<div class="box">
					<div class="box-header">
						<label>Temas</label>
					</div>
					<div class="box-body pad">
						<textarea name="txtTema" id="txtTema" class="textarea" placeholder="Escriba los temas" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $moduloDatos[0]["Tema"]; ?></textarea>
					</div>
			  </div>
			</div>
			<div class="col-md-12">
				<div class="box">
					<div class="box-header">
						<label>Metodología</label>
					</div>
					<div class="box-body pad">
						<textarea name="txtMetodologia" id="txtMetodologia" class="textarea" placeholder="Escriba la metodología" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $moduloDatos[0]["Metodologia"]; ?></textarea>
					</div>
			  </div>
			</div>
			<div class="col-md-12">
				<div class="box">
					<div class="box-header">
						<label>Evaluación</label>
					</div>
					<div class="box-body pad">
						<textarea name="txtEvaluacion" id="txtEvaluacion" class="textarea" placeholder="Escriba la forma de evaluación" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $moduloDatos[0]["Evaluacion"]; ?></textarea>
					</div>
			  </div>
			</div>
			<div class="col-md-12">
				<div class="box">
					<div class="box-header">
						<label>Bibliografia</label>
					</div>
					<div class="box-body pad">
						<textarea name="txtBibliografia" id="txtBibliografia" class="textarea" placeholder="Escriba la bibliografia del curso" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $moduloDatos[0]["Bibliografia"]; ?></textarea>
					</div>
			  </div>
			</div>
			<div class="col-md-12">
			    <div class="box-primary">
				    <div class="box-body">
						<div class="box-footer" style=" text-align: center;">
							<button type="button" class="btn btn-primary" onClick="val_doActModDatos()">ACTUALIZAR</button>
						</div>
				    </div>
			    </div>
			  <!-- /.box -->
			</div>.

              </div>
							<div class="tab-pane" id="timeline">
                <div class="row">
									<div class="col-md-6">
					          <div class="box box-widget widget-user-2">
					            <div class="widget-user-header bg-aqua-active">
					              <div class="widget-user-image">
					                <img class="img-circle" src="assets/perfil/<?php echo $datDocents[0]["Foto"] ?>" alt="User Avatar">
					              </div>
					              <h3 class="widget-user-username" style="font-size: 14px;"><?php echo $datDocents[0]["Nombre"].' '.$datDocents[0]["APaterno"]; ?></h3>
					              <h5 class="widget-user-desc"><?php echo $datDocents[0]["Cargo"]; ?></h5>
					            </div>
					            <div class="box-footer no-padding">
					              <ul class="nav nav-stacked">
					                <li><a href="#"><?php echo $datDocents[0]["Correo"]; ?> <span class="pull-right badge bg-blue"></span></a></li>
					                <li><a href="docente.php?U=<?php echo $datDocents[0]["IdUsua"]?>">Ver perfil <span class="pull-right badge bg-aqua"><i class="fa fa-fw fa-tags"></i></span></a></li>
					              </ul>
					            </div>
					          </div>
					        </div>
					        <div class="col-md-6">
					          <div class="box box-widget widget-user-2">
					            <div class="widget-user-header bg-aqua">
					              <div class="widget-user-image">
					                <img class="img-circle" src="assets/perfil/<?php echo $datDocents[1]["Foto"] ?>" alt="User Avatar">
					              </div>
					              <h3 class="widget-user-username" style="font-size: 14px;"><?php echo $datDocents[1]["Nombre"].' '.$datDocents[1]["APaterno"]; ?></h3>
					              <h5 class="widget-user-desc"><?php echo $datDocents[1]["Cargo"]; ?></h5>
					            </div>
					            <div class="box-footer no-padding">
					              <ul class="nav nav-stacked">
					                <li><a href="#"><?php echo $datDocents[1]["Correo"]; ?> <span class="pull-right badge bg-blue"></span></a></li>
					                <li><a href="docente.php?U=<?php echo $datDocents[1]["IdUsua"]?>">Ver perfil <span class="pull-right badge bg-aqua"><i class="fa fa-fw fa-tags"></i></span></a></li>
					              </ul>
					            </div>
					          </div>
					        </div>

                </div>
              </div>

              <!-- /.tab-pane -->
            </div>
			</form>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
	<div id="dataModal2" class="modal fade"> <!--MODAL ME GUSTA-->

			 <div class="modal-dialog">
						<div class="modal-content">

								 <div class="modal-body" id="employee_detail2">

								 </div>
						</div>
			 </div>
	</div>

	<div id="dataModal1" class="modal fade"> <!--MODAL ME GUSTA-->

			 <div class="modal-dialog">
						<div class="modal-content">

								 <div class="modal-body" id="employee_detail1">

								 </div>
						</div>
			 </div>
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>

function val_delVideo(Id){
	$.ajax({
			 url:"formConsulta/delVideo.php",
			 method:"POST",
			 data:{Id:Id},
			 success:function(data){
						var valor = 0;
						valor = data;
						if(valor == 1){
							document.getElementById(Id).style.display = 'none';
										swal("Eliminado", "VIDEO ELIMINADO CON ÉXITO", "success");
						} else{

							swal("Error", "NO SE PUDO ELIMINAR VIDEO", "error");

						}
			 }
	});
}

$(document).ready(function(){
		 $(document).on('click', '.view_tutor', function(){
					var employee_id = $(this).attr("id");

					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/viewSeguimiento.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail2').html(data);
												 $('#dataModal2').modal('show');
										}
							 });
					}
		 });
});

$(document).ready(function(){
		 $(document).on('click', '.view_subir', function(){
					var employee_id = $(this).attr("id");

					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/uploadVideo.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail1').html(data);
												 $('#dataModal1').modal('show');
										}
							 });
					}
		 });
});


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
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })

	$(document).ready(function(){
    var alerta = document.frm.Alerta.value;
    if(alerta){
      if(alerta =="0"){
        swal("Error", "Error no se puede gardar nombre de video", "error");
      }
      if(alerta =="1"){
        swal("Guardado", "Nombre de video guardado correctamente", "success");
      }
    }
  });
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
