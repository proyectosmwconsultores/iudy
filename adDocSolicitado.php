<?php $valor = 3; $section = "Lista de alumnos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizado los documentos solicitados'); }
// $oferta=$t->get_OfertaE();
if($_SESSION['Permisos'] == 9){
	$oferta=$t->get_OfertaCoordinador($_SESSION['IdUsua']);
} else {
	$oferta=$t->get_OfertaETodos($_SESSION['Permisos'],$_SESSION['IdOferta'],$_SESSION['IdCampus']);
}

$conceptos=$t->get_conceptosSol($_POST["txtOferta"]);
$alumnos=$t->get_docSolicitadosLst($_POST["txtOferta"],$_POST["txtClaveGrp"], $_POST["txtConcepto"]);
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));
if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
		$t->add_docSolicitado($_POST["IdDoc"]);
		exit;
	}
?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Documentos solicitados
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-file"></i> Documentos</a></li>
					<li class="active">Proceso</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adDocSolicitado.php" method="POST" enctype="multipart/form-data">
						<input id="Mov" name="Mov" value="" type="hidden"/>
						<input id="IdDoc" name="IdDoc" value="" type="hidden"/>
						<input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
						<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
						<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
						<input id="Numero" name="Numero" value="4" type="hidden"/>
						<input id="Nombre" name="Nombre" value="Documentos solicitados" type="hidden"/>
						<div class="col-md-4">
							<div class="form-group">
								<label>Selecione oferta educativa:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-fw fa-key"></i>
									</div>
									<select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
									<option value=""> - Seleccione - </option>
									<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
									<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST['txtOferta']==$oferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
									<?php } ?>
								  </select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Selecione estatus:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-fw fa-key"></i>
									</div>
									<select class="form-control" name="txtClaveGrp" id="txtClaveGrp" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<option value="12"<?php if($_POST["txtClaveGrp"]==12){?>selected="selected"<?php }?>> En proceso</option>
										<option value="13"<?php if($_POST["txtClaveGrp"]==13){?>selected="selected"<?php }?>> Enviado al solicitante</option>
										<option value="14"<?php if($_POST["txtClaveGrp"]==14){?>selected="selected"<?php }?>> Todos</option>
								  </select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Selecione concepto:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-fw fa-key"></i>
									</div>
									<select class="form-control" name="txtConcepto" id="txtConcepto" onchange="document.frm.submit();">
									<option value=""> - Seleccione - </option>
									<?php for ($i=0;$i< sizeof($conceptos);$i++) { ?>
									<option value="<?php echo $conceptos[$i]["IdConcepto"]; ?>"<?php if($_POST['txtConcepto']==$conceptos[$i]["IdConcepto"]){?>selected="selected"<?php }?>><?php echo $conceptos[$i]["NomConcepto"]; ?></option>
									<?php } ?>
								  </select>
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de todos los alumnos</h3>
								</div>
								<div class="box-body">
								<div class="table-responsive">
									<table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
										<thead>
											<tr>
												<th>Ajuste</th>
												<th>No.Control</th>
												<th>Nombre</th>
												<th>Oferta educativa</th>
												<th>Concepto</th>
												<th>Estatus</th>
												<th>Fecha solicitado</th>
												<th>Fecha entrega</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($alumnos);$i++) { $tiempo = time(); $var = uniqid(); $var2 = uniqid();
												 $IdDoc = $alumnos[$i]["IdDocSolicitado"];
												  $token = $tiempo.$var.$var2.$tiempo.$IdDoc;
												 ?>
											<tr>
												<td>
													<?php if($alumnos[$i]["IdConcepto"] == 5){ ?>
													<a onClick="window.open('repositorio/pdf/constanciaSin.php?tokenId=<?php echo $token ?>','_blank')" href="javascript:void(0);">
													<button title="Descargar constancia" type="button" class="btn btn-info btn-sm" href="javascript:void(0);" style="float: center;"><i class="fa fa-cloud-download"></i></button>
												</a> <?php } elseif($alumnos[$i]["IdConcepto"] == 6){ ?>
													<a onClick="window.open('repositorio/pdf/constanciaCon.php?tokenId=<?php echo $token ?>','_blank')" href="javascript:void(0);">
													<button title="Descargar constancia" type="button" class="btn btn-info btn-sm" href="javascript:void(0);" style="float: center;"><i class="fa fa-cloud-download"></i></button>
												</a> <?php }  ?>
													<button title="Subir constancia firmada y sellada " type="button" class="btn btn-primary btn-sm view_data" href="javascript:void(0);" name="view" value="view" id="<?php echo $IdDoc; ?>" style="float: center;"><i class="fa fa-cloud-upload"></i></button>

												<?php if(($_POST["txtClaveGrp"] != 12) && ($alumnos[$i]["Archivo"])){ ?>
													<a onClick="window.open('assets/docs/Solicitudes/<?php echo $alumnos[$i]["Archivo"]; ?>','_blank')" href="javascript:void(0);">
													<button type="button" class="btn btn-danger btn-sm" href="javascript:void(0);" style="float: center;"><i class="fa fa-file-pdf-o"></i></button>
												</a>

												<?php  } ?>
												</td>
												<td><?php echo $alumnos[$i]["Matricula"]; ?></td>
												<td><?php echo $alumnos[$i]["Nombre"].' '.$alumnos[$i]["APaterno"].' '.$alumnos[$i]["AMaterno"]; ?></td>
												<td><?php echo $alumnos[$i]["NomOferta"]; ?></td>
												<td><?php echo $alumnos[$i]["NomConcepto"]; ?></td>
												<td><?php echo $alumnos[$i]["Estatus"]; ?></td>
												<td><?php echo $alumnos[$i]["Fecha"]; ?></td>
												<td>
													<?php if(($_POST["txtClaveGrp"] != 12) && ($alumnos[$i]["FechaEntrega"])){ ?>
														<?php echo $alumnos[$i]["FechaEntrega"]; ?>
													<?php  } ?>
												</td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
								</div>
							</div>
						</div>
						<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
									<div class="modal-dialog">
											 <div class="modal-content">
														<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
																 <button type="button" class="close" data-dismiss="modal">&times;</button>
																 <h4 class="modal-title">Enviar documento solicitado</h4>
														</div>
														<div class="modal-body">
															<div class="form-group" name="imgLoadPagos" id="imgLoadPagos" style="display: none; text-align: center; margin: 0 auto;">
						                        <img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
						                  </div>
														  <table class="table table-condensed">
									                <tr>
									                  <td style="width: 160px; text-align: right;"><b>Seleccione documento:</b></td>
									                  <td><input id="txtDocumento" name="txtDocumento" type="file" onchange="validarPDF(this);"></td>
									                </tr>
									                <tr>
									                  <td style="width: 160px; text-align: right;"><b>Guardar:</b></td>
									                  <td>
									                      <button type="button" class="btn btn-block btn-info btn" onClick="val_DocSolicitado()" > <i class="fa fa-fw fa-cloud-upload"></i> Subir documento solicitado </button></td>
									                </tr>
									              </tbody></table>
														</div>
											 </div>
									</div>
						 </div>
					</form>
				</div>
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


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
$(document).ready(function(){
		 $(document).on('click', '.view_data', function(){
					var employee_id = $(this).attr("id");

					document.getElementById("IdDoc").value = employee_id;
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
			swal("Guardado correctamente", "El archivo ha sido guardado correctamente", "success");
		}
		if(alerta =="3"){
			swal("Error al guardar", "No se ha podido actualizar el registro", "success");
		}
	}
});
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
