<?php  $section = "Solicitud de baja"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando las solicitudes de baja'); }
if(isset($_POST["txtEstatusBus"])){ $_POST["txtEstatusBus"] = $_POST["txtEstatusBus"]; } else { $_POST["txtEstatusBus"] = ''; }
$estatusLst=$t->get_estatusUser();
$bajas=$t->get_bajasPro($_POST["txtEstatusBus"]);
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));



	if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
			$t->add_bajaUsuario($_POST["IdUsua"]);
			exit;
		}
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
					Solicitudes de baja
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> >Solicitudes</a></li>
					<li class="active">Baja</li>
				</ol>
			</section>
			<section class="content">
      <form name="frm" id="frm" action="adSolBaja.php" method="POST" enctype="multipart/form-data">
				<input id="Mov" name="Mov" value="" type="hidden"/>
				<input id="IdDoc" name="IdDoc" value="" type="hidden"/>
				<input id="Alerta" name="Alerta" value="<?php if(isset($_SESSION['Alerta'])){ echo $_SESSION['Alerta']; } ?>" type="hidden"/>
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="7" type="hidden"/>
				<input id="Nombre" name="Nombre" value="Reporte de solicitudes de baja" type="hidden"/>
				<input id="IdUsua" name="IdUsua" value="" type="hidden"/>
				<input id="IdAdministrador" name="IdAdministrador" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
				<input id="Tipo" name="Tipo" value="Sol" type="hidden"/>
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
	                  <label>Estatus:</label>
	                  <div class="input-group">
	                    <div class="input-group-addon"><i class="fa fa-calendar-check-o"></i></div>
											<select class="form-control" name="txtEstatusBus" id="txtEstatusBus" onchange="document.frm.submit();">
												<option value=""> - Seleccione - </option>
												<option value="2" <?php if($_POST["txtEstatusBus"]=="2"){?>selected="selected"<?php }?>> En Proceso </option>
												<option value="4" <?php if($_POST["txtEstatusBus"]=="4"){?>selected="selected"<?php }?>> Baja realizada </option>
											</select>
	                  </div>
	                </div>
	                </div>
	              </div>
	            </div>

							<?php if(isset($bajas[0])){ ?>
	              <div class="col-md-12">
	                <div class="box">
										<div class="box-body">
										<div class="table-responsive">
											<table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
												<thead>
													<tr>
														<th>Ajustes</th>
														<th>No.Control</th>
														<th>Nombre</th>
														<th>Teléfono</th>
														<th>Correo</th>
														<th>Oferta educativa</th>
														<th>Fecha</th>
														<th>Estatus</th>
														<?php if($_POST["txtEstatusBus"]==4){ ?>
															<th>Comentario</th>
														<?php } ?>
													</tr>
												</thead>
												<tbody>
													<?php for ($i=0;$i< sizeof($bajas);$i++) { $id= $bajas[$i]["IdUsua"];
														$lstDocumentos=$t->get_docsBaja($id);
														$tiempo = time(); $var = uniqid(); $var2 = uniqid();

																$token = $tiempo.$var.$var2.$tiempo.$id;
														 ?>
													<tr>
														<td width="120px">
															<?php for ($x=0;$x< sizeof($lstDocumentos);$x++) {  ?>
															<button type="button" title="Descargar datos de factura" class="btn btn-info btn-sm" onclick="javascript:window.open('assets/docs/Baja/<?php echo $lstDocumentos[$x]["Archivo"]; ?>');"> <i class="fa fa-file-excel-o"></i></button>
															<?php } ?>

															<?php if($bajas[$i]["Estatus"] == "2") {  ?><button type="button" title="Configurar baja de usuario" class="btn btn-success btn-sm view_data" href="javascript:void(0);" name="view" value="view" id="<?php echo $id; ?>"> <i class="fa fa-exclamation-circle"></i></button><?php } ?>
																<?php if($_POST["txtEstatusBus"]==4){ ?>
																	<a onClick="window.open('repositorio/pdf/docBaja.php?tokenId=<?php echo $token ?>','_blank')" href="javascript:void(0);">
																	<button title="Descargar constancia" type="button" class="btn btn-info btn-sm" href="javascript:void(0);" style="float: center;"><i class="fa fa-cloud-download"></i></button>
																</a>
																<?php } ?>
														</td>
														<td><?php echo $bajas[$i]["Matricula"]; ?></td>
														<td><?php echo $bajas[$i]["Nombre"].' '.$bajas[$i]["APaterno"].' '.$bajas[$i]["AMaterno"]; ?></td>
														<td><?php echo $bajas[$i]["Telefono"]; ?></td>
														<td><?php echo $bajas[$i]["Correo"]; ?></td>
														<td><?php echo $bajas[$i]["NomEducativa"]; ?></td>
														<td><?php echo $bajas[$i]["FecCap"]; ?></td>
														<td><?php if($_POST["txtEstatusBus"] == "2") { echo "En Proceso"; } else{ echo $bajas[$i]["Estatus"]; }  ?></td>
														<?php if($_POST["txtEstatusBus"]==4){ ?>
															<td><?php echo $bajas[$i]["Comentario"]; ?></td>
														<?php } ?>
													</tr>
													<?php } ?>
												</tfoot>
											</table>
										</div>
										</div>
	                </div>
	              </div><?php } ?>
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
																	<?php for ($i=0;$i< sizeof($estatusLst);$i++) { ?>
																	<option value="<?php echo $estatusLst[$i]["IdEstatus"]; ?>"<?php if($_POST["txtEstatus"]==$estatusLst[$i]["IdEstatus"]){?>selected="selected"<?php }?>><?php echo $estatusLst[$i]["Estatus"]; ?></option>
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

<!-- jQuery 3 -->

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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
