<?php $section = "Agregar biblioteca"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por agregar un nuevo recurso de apoyo en la bilbioteca'); // }
//if($_SESSION['Permisos']=="2") {
	if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
		$t->add_Bliblioteca();
		exit;
	}

$temas=$t->get_temas();


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
			Biblioteca digital
		  </h1>
		  <ol class="breadcrumb">
				<li><a href="miBiblioteca.php"><i class="fa fa-dashboard"></i>Mi biblioteca</a></li>
				<li class="active"><a href="#">Agregar biblioteca</a></li>
		  </ol>
		</section>
		<section class="content">
		<form name="frm" id="frm" action="addBilbioteca.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="box box-default">
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box-primary">
							<div class="box-body">
							</div>
						</div>

						<input id="Mov" name="Mov" value="<?php echo $_GET[Mov];?>" type="hidden"/>
						<input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
						<input id="Variable" name="Variable" value="<?php echo $_SESSION['Variable'];?>" type="hidden"/>
						<input id="Id" name="Id" value="<?php echo $_SESSION['IdAsignacion'] ?>" type="hidden"/>
						<input id="Tipo" name="Tipo" value="0" type="hidden"/>
						<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
						<div class="form-group">
							<label for="inputSkills" class="col-sm-3 control-label">Nombre:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" placeholder="Título" id="txtNombre" name="txtNombre">
							</div>
						</div>
						<div class="form-group">
							<label for="inputSkills" class="col-sm-3 control-label">Autor:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" placeholder="Autor" id="txtAutor" name="txtAutor">
							</div>
						</div>
						<div class="form-group">
							<label for="inputSkills" class="col-sm-3 control-label">Tipo de documento:</label>
							<div class="col-sm-9">
								<select class="form-control" name="txtTipoDoc" id="txtTipoDoc">
								<option value=""> - Seleccione - </option>
								<?php for ($i=0;$i< sizeof($temas);$i++) { ?>
								<option value="<?php echo $temas[$i]["IdTema"]; ?>"<?php if($_POST["txtTipoDoc"]==$temas[$i]["IdTema"]){?>selected="selected"<?php }?>><?php echo $temas[$i]["Descripcion"]; ?></option>
								<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group" name="imgLoadRecurso" id="imgLoadRecurso" style="display: none;">
							<div class="col-sm-12" style="text-align: center;">
									<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
							</div>
						</div>

						<div class="form-group">
							<label for="inputSkills" class="col-sm-3 control-label">Descripción:</label>
							<div class="col-sm-9">
								<div class="box-body pad">
									<textarea name="txtDescripcion" id="txtDescripcion" class="textarea" placeholder="Escriba la descripción del documento" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
								</div>
							</div>
						</div>

							<div class="form-group" name="div3" id="div3">
								<label for="inputSkills" class="col-sm-3 control-label">Buscar:</label>
								<div class="col-sm-9">
									<input type="file" class="form-control" placeholder="Buscar" id="archivo" name="archivo" onchange="ValArchivoPDF(this);">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-6 col-sm-6">
									<button type="button" id="btnRecurso" name="btnRecurso" class="btn btn-primary" onClick="val_doAddBilbio()"><i class="fa fa-save"></i> GUARDAR</button>
								</div>
							</div>



					</div>




				</div>
			</div>
		</div>
	</form>
	</section>

		<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
					<div class="modal-dialog">
							 <div class="modal-content">
										<div class="modal-body" id="employee_detail">
										</div>
							 </div>
					</div>
		 </div>
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
		 $(document).on('click', '.view_data', function(){
			 var Id = document.getElementById("Id").value;
					var employee_id = $(this).attr("id");
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/viewVideo.php",
										method:"POST",
										data:{employee_id:employee_id,Id:Id},
										success:function(data){
												 $('#employee_detail').html(data);
												 $('#dataModal').modal('show');
										}
							 });
					}
		 });
});


$(document).ready(function(){
    $("select").change(function(){
		var tipo = document.getElementById("txtTipoDoc").value;

		if(tipo==7){
			document.getElementById("Tipo").value = '1';
			document.getElementById("div3").style.display = 'none';
			document.getElementById("video").style.display = 'block';
		}else{
			document.getElementById("Tipo").value = '0';
			document.getElementById("div3").style.display = 'block';
			document.getElementById("video").style.display = 'none';
		}

    //document.getElementById("div3").style.display = 'none'

    });
});

function val_recursoApoyo(Id){
	$.ajax({
			 url:"formConsulta/delRecurso.php",
			 method:"POST",
			 data:{Id:Id},
			 success:function(data){
						var valor = 0;
						valor = data;
						if(valor == "1"){
							document.getElementById(Id).style.display = 'none';
										swal("Eliminado", "RECURSO ELIMINADO CON ÉXITO", "success");
						} else{

							swal("Error", "NO SE PUDO ELIMINAR RECURSO", "error");

						}
			 }
	});
}
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
</script>
</body>
</html>
<?php
 unset($_SESSION['Alerta']); unset($_SESSION['Variable']);

 } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>
