<?php $section = "Actividades"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por subir alguna tarea'); }
$actividad=$t->get_actividad($_GET["NoActividad"]);
$link=$t->get_link($_SESSION['IdAsignacion'],$_GET["NoActividad"]);
if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
		$t->add_Tareas();
		exit;
	}
  ?>
<link rel='stylesheet prefetch' href='assets/fancy/css/ybgpzy.css'>
<link rel="stylesheet" href="assets/fancy/css/style.css">
<script language="javascript" type="text/javascript" src="php/js/funciones.js"></script>

  <div class="container-container">
	  <form name="frm" id="frm" action="alSelResponder.php" method="POST" enctype="multipart/form-data">
	  <input id="Mov" name="Mov" value="<?php echo $_GET[Mov];?>" type="hidden"/>
	  <input id="NoActividad" name="NoActividad" value="<?php echo $_GET["NoActividad"]; ?>" type="hidden"/>
	  <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_SESSION['IdAsignacion']; ?>" type="hidden"/>
	  <input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
	<input id="Variable" name="Variable" value="<?php echo $_SESSION['Variable'];?>" type="hidden"/>
	<input id="Id" name="Id" value="<?php echo $_GET[Id];?>" type="hidden"/>

	  <div class="modal-title" style="background: #449F43; color: white; font-size: 16px; "><?php echo $actividad[0]["TituloActividad"]; ?></div>
	  <div class="modal-body">
			<div class="col-md-12">
			  <div class="box-primary">
				  <div class="box-body">
						<div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label" style="text-align: right;">Buscar archivo: </label>
              <div class="col-sm-10">
                <input type="file" name="archivo" id="archivo" onchange="ValArchivoPDF(this);">
								<span class="help-block">El formato de archivo puede ser: WORD, EXCEL, PDF, menor a 10MB</span>
              </div>
            </div>
						<div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label" style="text-align: right;">No. Archivo: </label>
              <div class="col-sm-10">
								<select class="form-control" name="NoArchivo" id="NoArchivo">
    							<option value=""> - Seleccione - </option>
                  <option value="Link"<?php if($_POST["NoArchivo"]=="Link"){?>selected="selected"<?php }?>> No. 1 <?php if($link[0]["Link"]) { echo " - (Archivo existente.) "; } ?></option>
                  <option value="Link2"<?php if($_POST["NoArchivo"]=="Link2"){?>selected="selected"<?php }?>> No. 2 <?php if($link[0]["Link2"]) { echo " - (Archivo existente.) "; } ?> </option>
                  <option value="Link3"<?php if($_POST["NoArchivo"]=="Lin3"){?>selected="selected"<?php }?>> No. 3 <?php if($link[0]["Link3"]) { echo " - (Archivo existente.) "; } ?> </option>
  						  </select>
              </div>
            </div>
						<div name="imgCargando" id="imgCargando" style="margin: 0px 300px auto; position: absolute; display: none;">
							<img src="assets/images/cargando.gif" style="position: absolute;">
						</div>

						<div class="form-group">
							<label for="exampleInputEmail1">Comentario (opcional):</label>
							<input name="txtComentario" id="txtComentario" class="form-control" placeholder="Escriba si tiene algun comentario">
						</div>
						<div class="form-group">
							<div class="box-footer" style=" text-align: center;">
								<button type="button" name="btnResponder" id="btnResponder" class="btn btn-primary" onclick="val_alSelResponder()">Responder</button><br><br><br><br>
							</div>
						</div>


				  </div>
			  </div>
			</div>
	  </div>
  </form>
</div>
<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	var variable = document.frm.Variable.value;
	var IDA = document.frm.Id.value;
	//alert('hola= '+ IDA);
	if(alerta){
		if(alerta =="GUARDAR"){
			//swal("Guardado", variable + " GUARDADO CON ÉXITO", "success");

			parent.location.href='alSelActividades.php'; //direcciona la pagina madre
			parent.jQuery.fancybox.close();  //cierra el box
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
</script>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']);  ?>
