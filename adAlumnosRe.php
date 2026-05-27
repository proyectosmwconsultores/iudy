<?php $valor = 3; $section = "Alumnos reprobados"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de alumnos reprobados'); }
if(isset($_POST["txtTipo"])){
		$alumnos=$t->get_alumnosRep($_POST["txtTipo"]);
}

$estatus=$t->get_estatusUser();
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Configuraci&oacute;n de alumnos reprobados
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> >Alumnos</a></li>
					<li class="active">Reprobados</li>
				</ol>
			</section>
			<section class="content">
      <form name="frm" id="frm" action="adAlumnosRe.php" method="POST" enctype="multipart/form-data">
				<input id="IdUsua" name="IdUsua" value="" type="hidden"/>
				<input id="IdAdministrador" name="IdAdministrador" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
				<input id="Mov" name="Mov" value="" type="hidden"/>
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="4" type="hidden"/>
				<input id="Nombre" name="Nombre" value="Reporte alumnos" type="hidden"/>
				<input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
				<input id="Tipo" name="Tipo" value="Man" type="hidden"/>
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
	            <div class="col-md-8">
	              <div class="box-primary">
	                <div class="box-body">
	                  <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
	                    <i class="fa fa-rotate-left"></i> Regresar
	                  </a>
                  </div>
	              </div>
	            </div>
							<div class="col-md-4">
	              <div class="box-primary">
	                <div class="box-body">
										<div class="form-group">
											<label>Seguimiento:</label>
											<div class="input-group">
											  <div class="input-group-addon">
												<i class="fa fa-gears"></i>
											  </div>
											  <select class="form-control" name="txtTipo" id="txtTipo" onchange="document.frm.submit();">
												<option value=""> - Seleccione - </option>
												<option value="1"<?php if($_POST['txtTipo'] == 1){?>selected="selected"<?php }?>>Alumnos reprobados sin asignar</option>
												<option value="2"<?php if($_POST['txtTipo'] == 2){?>selected="selected"<?php }?>>Alumnos reprobados asignados</option>
											  </select>
											</div>
										</div>
                  </div>
	              </div>
	            </div>







	              <div class="col-md-12">
	                <div class="box">
										<div class="box-body">
										<div class="table-responsive">
											<table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
												<thead>
													<tr>
														<th>Ajuste</th>
														<th>Matr&iacute;cula</th>
														<th>Nombre</th>
														<th>Teléfono</th>
														<th>Correo</th>
														<th>Oferta educativa</th>
														<th>Asignatura</th>
														<th>Campus</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($i=0;$i< sizeof($alumnos);$i++) { $Id = $alumnos[$i]["IdUsua"];
														$pagos=$t->get_pagosPendientes($Id);

														 ?>
													<tr>
														<td>
															<?php
																$var = uniqid(); $var2 = uniqid(); $var3 = uniqid(); $var4 = uniqid();
					                        $tok = $var.$var2.$var3.$var4.$alumnos[$i]["IdUsua"];
																	if($pagos[0]){ ?>
																		<button title="Este prospecto tiene pagos pendientes" type="button" class="btn btn-danger"><i class="fa fa-hand-stop-o"></i></button>
																	<?php } else {
																 ?>
																<a onClick="window.open('adConfigAlumno.php?Id=<?php echo $tok; ?>&T=r','_self')" href="javascript:void(0);">
																	<button title="Configurar grupo y asignaturas" type="button" class="btn btn-success"><i class="fa fa-key "></i></button>
																</a><?php  } ?>
														</td>
														<td><?php echo $alumnos[$i]["Matricula"]; ?></td>
														<td><?php echo $alumnos[$i]["Nombre"].' '.$alumnos[$i]["APaterno"].' '.$alumnos[$i]["AMaterno"]; ?></td>
														<td><?php echo $alumnos[$i]["Telefono"]; ?></td>
														<td><?php echo $alumnos[$i]["Correo"]; ?></td>
														<td><?php echo $alumnos[$i]["NombreOfe"]; ?></td>
														<td><?php echo $alumnos[$i]["NombreMod"]; ?></td>
														<td><?php echo $alumnos[$i]["Campus"]; ?></td>
													</tr>
													<?php } ?>
												</tfoot>
											</table>
										</div>
										</div>
	                </div>


	              </div>
	          </div>
	        </div>
	      </div>
				<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
							<div class="modal-dialog">
									 <div class="modal-content">
												<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
														 <button type="button" class="close" data-dismiss="modal">&times;</button>
														 <h4 class="modal-title">Configuración de baja de usuario</h4>
												</div>
												<div class="modal-body">
													<div class="form-group" name="imgLoadPagos" id="imgLoadPagos" style="display: none; text-align: center; margin: 0 auto;">
																<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
													</div>


							              <div class="box-body">
							                <div class="form-group">
							                  <label for="exampleInputEmail1">Seleccione tipo de baja</label>
																<select class="form-control" name="txtEstatus" id="txtEstatus">
																	<option value=""> - Seleccione - </option>
																	<?php for ($i=0;$i< sizeof($estatus);$i++) { ?>
																	<option value="<?php echo $estatus[$i]["IdEstatus"]; ?>"<?php if($_POST["txtEstatus"]==$estatus[$i]["IdEstatus"]){?>selected="selected"<?php }?>><?php echo $estatus[$i]["Estatus"]; ?></option>
																	<?php } ?>
																</select>
							                </div>
							                <div class="form-group">
							                  <label for="exampleInputPassword1">Comentario:</label>
							                  <textarea class="form-control" rows="3" name="txtComentario" id="txtComentario" placeholder="Escriba un mensaje al usuario ..."></textarea>
							                </div>

							                <div class="checkbox">
							                  <label>
							                    <input type="checkbox" checked disabled> <b>Nota:</b> al dar clic guardar configuraci&oacute;n, autom&aacute;ticamente se le notificar&aacute; al usuario via correo electr&oacute;nico sobre su respectiva baja.
							                  </label>
							                </div>
							              </div>
							              <div class="box-footer">
							                <button type="button" class="btn btn-block btn-info btn" onClick="val_bajaUsuario()" > <i class="fa fa-save"></i> Guardar configuraci&oacute;n</button></td>
							              </div>

												</div>
									 </div>
							</div>
				 </div>
	    </form>
    </section>

		</div>

    <!-- Mainly scripts -->
    <script src="assets/table/js/jquery-3.1.1.min.js"></script>
    <script src="assets/table/js/bootstrap.min.js"></script>
    <script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
    <!-- Custom and plugin javascript -->
		<script src="assets/table/js/scriptAgregado1.js"></script>

	  <?php include("footer.php"); ?>
	</div>
<script>
$(document).ready(function(){
		 $(document).on('click', '.view_data', function(){
					var employee_id = $(this).attr("id");

					document.getElementById("IdUsua").value = employee_id;
					if(employee_id != '')
					{
							 $.ajax({
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail').html(data);
												 $('#dataModal').modal('show');
										}
							 });
					}
		 });
});

$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	if(alerta){
		if(alerta =="0"){
			swal("Error al subir", "No se ha podido subir el archivo al servidor", "error");
		}
		if(alerta =="1"){
			swal("Guardado correctamente", "Datos guardado correctamente y notificado al usuario.", "success");
		}
		if(alerta =="2"){
			swal("Error al guardar", "No se ha podido actualizar el registro", "success");
		}
	}
});
</script>
<!-- jQuery 3 -->


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
