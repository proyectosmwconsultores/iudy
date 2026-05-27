<?php $section = "Verificar pagos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando las verificaciones de pagos'); }
$oferta=$t->get_OfertaETodos();
if($_GET['IdO']){
	$_POST[txtOferta] = $_GET['IdO'];
}
if($_GET['IdC']){
	$_POST[txtConcepto] = $_GET['IdC'];
}
if($_GET['IdG']){
	$_POST[txtGrupo] = $_GET['IdG'];
}

$conceptos=$espacio->get_conceptosOf($_POST["txtOferta"]);

$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));

//$lstgrupo=$espacio->get_grupoActiv($_POST["txtOferta"]);
$lstCiclo=$t->get_CicloEscolar();
$clvGrupo=$t->get_claveGrupoXA($_POST["txtCicloEscolar"],$_POST["txtOferta"]);

$pagoId=$t->get_verificarPagos($_POST["txtOferta"],$_POST["txtConcepto"],$_POST["txtCicloEscolar"],$_POST["txtGrupo"]);
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
					Verificaci&oacute;n de pagos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Pagos</a></li>
					<li class="active">Verificación de pagos</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="ctrlVerficarPagos.php" method="POST" enctype="multipart/form-data">
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'];?>" type="hidden"/>
				<input id="Mov" name="Mov" value="" type="hidden"/>
				<input id="IdDoc" name="IdDoc" value="" type="hidden"/>
				<input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="6" type="hidden"/>
				<input id="Nombre" name="Nombre" value="Reporte de verificación de pagos" type="hidden"/>
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Oferta educativa:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
											<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST[txtOferta]==$oferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Ciclo escolar:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtCicloEscolar" id="txtCicloEscolar" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
										<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"<?php if($_POST["txtCicloEscolar"]==$lstCiclo[$i]["IdCiclo"]){?>selected="selected"<?php }?>><?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Grupo:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtGrupo" id="txtGrupo" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($clvGrupo);$i++) { ?>
											<option value="<?php echo $clvGrupo[$i]["IdGrupo"]; ?>"<?php if($_POST["txtGrupo"]==$clvGrupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $clvGrupo[$i]["CveGrupo"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label>Conceptos de pago:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtConcepto" id="txtConcepto" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($conceptos);$i++) { ?>
											<option class="form-control"  value="<?php echo $conceptos[$i]["IdConcepto"]; ?>"<?php if($_POST[txtConcepto]==$conceptos[$i]["IdConcepto"]){?>selected="selected"<?php }?>><?php echo $conceptos[$i]["NomConcepto"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<?php if(($pagoId[0]) && ($_POST["txtConcepto"])){ ?>
							<div class="col-md-4">
								<div class="form-group">
									<label></label>
									<div class="input-group">
										<button type="button" class="btn btn-danger view_fecha" href="javascript:void(0);" name="view" value="view" id="1" style="float: right;"><i class="fa fa-calendar"></i> NUEVA FECHA LIM. PAGO</button>
									</div>
								</div>
							</div>
							<?php } ?>





	              <div class="col-md-12">
	                <div class="box">
										<div class="box-body">
										<div class="table-responsive">
											<table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
												<thead>
													<tr>
														<th>Nombre</th>
														<th>Referencia</th>
														<th>FecCaptura</th>
														<th>FecLimPago</th>
														<th>Estatus</th>
														<th>Monto</th>
														<th>Ver</th>
														<th>Desc</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($i=0;$i< sizeof($pagoId);$i++) {
														if($pagoId[$i]["DetEstatus"] != 7){
															$descuento=$t->get_descuentoXa($pagoId[$i]["IdDescuento"]);



														 $recargos = $pagoId[$i]["Recargos"];
														 $totalPagar = $recargos + $pagoId[$i]["Pagar"];
														  ?>
													<tr>

														<td><?php echo $pagoId[$i]["Nombre"].' '.$pagoId[$i]["APaterno"].' '.$pagoId[$i]["AMaterno"]; ?></td>
														<td><?php echo $pagoId[$i]["Referencia"]; ?></td>
														<td><?php echo substr($pagoId[$i]["FecCapP"], 0 ,10); ?></td>
														<td>
															<?php $hoy = date("Y-m-d");
															if($descuento[0]){
																if($descuento[0]["FecDescuento"] >= $hoy ){ echo "<b style='color: blue;'>*DA </b>"; echo $descuento[0]["FecDescuento"]; } else { echo "<b style='color: red;'>*DE </b>"; echo $pagoId[$i]["FecLimPago"]; }
															} else {
																echo $pagoId[$i]["FecLimPago"];
															}
		 ?>
														</td>
														<td><b><?php echo $pagoId[$i]["Estatus"]; ?></b></td>
														<td style="text-align: right;">
															<button type="button" class="btn btn-danger view_total" href="javascript:void(0);" name="view" value="view" id="<?php echo $pagoId[$i]["IdPago"]; ?>" style="float: right;"><i class="fa fa-server"></i></button>
														</td>
														<td>
															<?php if($pagoId[$i]["Archivo"]) { ?>
				                        <a class="btn btn-primary" onClick="window.open('assets/docs/Pagos/<?php echo $pagoId[$i]["Archivo"]; ?>','_blank')" href="javascript:void(0);"> <i class="fa fa-eye"></i> </a>
																<?php if($pagoId[$i]["Visto"] == 1) { ?>
																<span class="badge bg-black">Nuevo</span>
					                    <?php } } ?>
														</td>

														<td>
															<?php if($pagoId[$i]["IdEstatus"] == 4) { ?>
																<button title="Editar modulo" type="button" class="btn btn-danger"><i class="fa fa-lock"></i></button>
															<?php } else { ?>

															<button type="button" class="btn btn-warning view_descuento" href="javascript:void(0);" name="view" value="view" id="<?php echo $pagoId[$i]["IdPago"]; ?>"><i class="fa fa-balance-scale"></i></button>

					                    <?php }  ?>
														</td>
													</tr>
												<?php } } ?>
												</tfoot>
											</table>
											<p>
												<b style="color: blue;">*DA</b> = Descuento activo<br>
												<b style="color: red;">*DE</b> = Descuento expirado
											</p>
										</div>
										</div>
	                </div>


	              </div>
	          </div>
	        </div>
	      </div>

	    </form>
    </section>

		</div>
		<div id="dataModal2" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Opci&oacute;n para cerrar comprobante</h4>
									 </div>
									 <div class="modal-body" id="employee_detail2">

									 </div>
							</div>
				 </div>
		</div>

		<div id="dataModal3" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Generar descuentos sobre recargos</h4>
									 </div>
									 <div class="modal-body" id="employee_detail3">

									 </div>
							</div>
				 </div>
		</div>

		<div id="dataModal4" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Detalle del total a pagar</h4>
									 </div>
									 <div class="modal-body" id="employee_detail4">

									 </div>
							</div>
				 </div>
		</div>

		<div id="dataModal5" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: #605ca8; color: white; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Cambiar fecha l&iacute;mite de pago</h4>
									 </div>
									 <div class="modal-body" id="employee_detail5">

									 </div>
							</div>
				 </div>
		</div>
		<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
					<div class="modal-dialog">
							 <div class="modal-content">
										<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
												 <button type="button" class="close" data-dismiss="modal">&times;</button>
												 <h4 class="modal-title">Informaci&oacute;n del alumno</h4>
										</div>
										<div class="modal-body" id="employee_detail">
										</div>
							 </div>
					</div>
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
		 $(document).on('click', '.view_tutor', function(){
					var employee_id = $(this).attr("id");
				//	document.getElementById("IdAlumno").value = employee_id;
				var Oferta = document.getElementById("txtOferta").value;

					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/closeComprobacion.php",
										method:"POST",
										data:{employee_id:employee_id, Oferta:Oferta},
										success:function(data){
												 $('#employee_detail2').html(data);
												 $('#dataModal2').modal('show');
										}
							 });
					}
		 });
});

$(document).ready(function(){
		 $(document).on('click', '.view_descuento', function(){
					var employee_id = $(this).attr("id");
				//	document.getElementById("IdAlumno").value = employee_id;
				  var Oferta = document.getElementById("txtOferta").value;
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/descuento.php",
										method:"POST",
										data:{employee_id:employee_id, Oferta:Oferta},
										success:function(data){
												 $('#employee_detail3').html(data);
												 $('#dataModal3').modal('show');
										}
							 });
					}
		 });
});


$(document).ready(function(){
		 $(document).on('click', '.view_fecha', function(){
					var employee_id = $(this).attr("id");
				//	document.getElementById("IdAlumno").value = employee_id;
				var Oferta = document.getElementById("txtOferta").value;
				var Grupo = document.getElementById("txtGrupo").value;
				var Concepto = document.getElementById("txtConcepto").value;
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/modFecha.php",
										method:"POST",
										data:{employee_id:employee_id, Oferta:Oferta, Grupo:Grupo, Concepto:Concepto},
										success:function(data){
												 $('#employee_detail5').html(data);
												 $('#dataModal5').modal('show');
										}
							 });
					}
		 });
});

$(document).ready(function(){
		 $(document).on('click', '.view_total', function(){
					var employee_id = $(this).attr("id");
				//	document.getElementById("IdAlumno").value = employee_id;
				  var Oferta = document.getElementById("txtOferta").value;
					var IdGrupo = document.getElementById("txtGrupo").value;
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/totalPagar.php",
										method:"POST",
										data:{employee_id:employee_id, Oferta:Oferta, IdGrupo:IdGrupo},
										success:function(data){
												 $('#employee_detail4').html(data);
												 $('#dataModal4').modal('show');
										}
							 });
					}
		 });
});

$(document).ready(function(){
		 $(document).on('click', '.view_data', function(){
					var employee_id = $(this).attr("id");
					//var IdAsignacion = document.getElementById("Id").value;
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/viewAlumno.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail').html(data);
												 $('#dataModal').modal('show');
										}
							 });
					}
		 });
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
