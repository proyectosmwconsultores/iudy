<?php $section = "Reporte de pagos aprobados pagos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando el reporte de pagos aprobados'); }

$campus=$t->get_campusPermiso($_SESSION['IdUsua']);


if(isset($_POST['txtCampus'])){
	$_POST["txtCampus"] = $_POST['txtCampus'];
}
if(isset($_POST['txtEstatus'])){
	$_POST["txtEstatus"] = $_POST['txtEstatus'];
}

$pagoPend=$t->get_pagosPenOferta($_POST["txtCampus"],$_POST["txtEstatus"]);

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
					Reporte de pagos pendientes por oferta
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Reportes</a></li>
					<li class="active">Pagos pendientes</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="repOferta.php" method="POST" enctype="multipart/form-data">
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'];?>" type="hidden"/>
				<input id="Mov" name="Mov" value="" type="hidden"/>
				<input id="IdDoc" name="IdDoc" value="" type="hidden"/>
				<input id="Alerta" name="Alerta" value="<?php echo isset($_SESSION['Alerta']);?>" type="hidden"/>
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="6" type="hidden"/>
				<input id="Nombre" name="Nombre" value="Reporte de verificación de pagos" type="hidden"/>
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
							<div class="col-md-7">
								<div class="form-group">
									<label>Campus:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($campus);$i++) { ?>
											<option value="<?php echo $campus[$i]["IdCampus"]; ?>"<?php if($_POST['txtCampus']==$campus[$i]["IdCampus"]){?>selected="selected"<?php }?>><?php echo $campus[$i]["Campus"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>



							<div class="col-md-5">
								<div class="form-group">
									<label>Estatus:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtEstatus" id="txtEstatus" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<option value="8"<?php if($_POST["txtEstatus"]==8){  ?>selected="selected"<?php }?>>Activo</option>
											<option value="20"<?php if($_POST["txtEstatus"]==20){  ?>selected="selected"<?php }?>>Baja por deserción</option>
											<option value="50"<?php if($_POST["txtEstatus"]==50){  ?>selected="selected"<?php }?>>Bloqueado temporalmente</option>
											<option value="55"<?php if($_POST["txtEstatus"]==55){  ?>selected="selected"<?php }?>>Graduado</option>
									  </select>
									  <?php if(isset($pagoPend[0])){ ?>
									  <span class="input-group-btn">
                                          <button type="button" class="btn btn-info btn-flat" onClick="window.open('formConsulta/impReporte.php?idCa=<?php echo time().$_POST["txtCampus"]; ?>&idEs=<?php echo time().$_POST["txtEstatus"]; ?>','_blank')" href="javascript:void(0);"><i class="fa fa-fw fa-gg-circle"></i> Descargar</button>
                                        </span>

									  <?php } ?>
									</div>
								</div>
							</div>








	              <div class="col-md-12">
	                <div class="box">
										<div class="box-body">
										<div class="table-responsive">
											<table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;" >
												<thead>
													<tr>
														<th>Nombre</th>
														<th>Concepto / Ciclo</th>
														<th>Oferta</th>
														<th>Grupo</th>
														<th>Estatus</th>
														<th>Fec. Desc</th>
														<th>Monto</th>
														<th>Descuento</th>
														<th>Recargo</th>
														<th>Abono</th>
														<th>Total</th>
													</tr>
												</thead>
												<tbody>
													<?php $sunv = 0; $s_monto = 0; $s_descuento = 0; $s_recargo = 0; $s_recargo = 0; $s_abono = 0;
													 for ($i=0;$i< sizeof($pagoPend);$i++) {
														$xx=$t->get_chkPago($pagoPend[$i]["IdUsua"]);
														$xY=$t->get_beca($pagoPend[$i]["IdUsua"],$pagoPend[$i]["IdPago"]);
														$xZ=$t->get_recargo($pagoPend[$i]["IdUsua"],$pagoPend[$i]["IdPago"]);
														  $sumX = ($pagoPend[$i]["Monto"] - $pagoPend[$i]["Descuento"] + $xZ[0]["Recargo"] - $pagoPend[$i]["TotalPagado"]);
															$sunv = ($sunv + $sumX);
														  ?>
													<tr>

														<td> <?php echo $pagoPend[$i]["Nombre"].' '.$pagoPend[$i]["APaterno"].' '.$pagoPend[$i]["AMaterno"]; ?></td>
														<td><?php echo $pagoPend[$i]["NomPlan"]; ?> <br> <?php echo $pagoPend[$i]["Ciclo"]; ?></td>
														<td><?php echo $pagoPend[$i]["Educativa"]; ?></td>
														<td><?php echo $pagoPend[$i]["CveGrupo"]; ?></td>
														<td><?php echo $pagoPend[$i]["Estatus"]; ?></td>
														<td><?php echo $pagoPend[$i]["FecDesc"]; ?></td>
														<td style="width: 80px; text-align: right;">$ <?php echo number_format($pagoPend[$i]["Monto"], 2, '.', ',');  ?></td>
														<td style="width: 80px; text-align: right;">$ <?php echo number_format($pagoPend[$i]["Descuento"], 2, '.', ',');  ?></td>
														<td style="width: 80px; text-align: right;">$ <?php echo number_format($xZ[0]["Recargo"], 2, '.', ',');  ?></td>
														<td style="width: 80px; text-align: right;">$ <?php echo number_format($pagoPend[$i]["TotalPagado"], 2, '.', ',');  ?></td>
														<td style="width: 80px; text-align: right;">$ <?php echo number_format($sumX, 2, '.', ',');  ?></td>
													</tr>
												<?php $s_monto = ($s_monto + $pagoPend[$i]["Monto"]); $s_descuento = ($s_descuento + $pagoPend[$i]["Descuento"]); $s_recargo = ($s_recargo + $xZ[0]["Recargo"]); $s_abono = ($s_abono + $pagoPend[$i]["TotalPagado"]); } ?>
												</tfoot>
												<tfoot>
                <tr><th rowspan="1" colspan="6" style="text-align: right;">Total:</th>
									<th rowspan="1" colspan="1" style="text-align: right;">$ <?php echo number_format($s_monto, 2, '.', ',');  ?></th>
									<th rowspan="1" colspan="1" style="text-align: right;">$ <?php echo number_format($s_descuento, 2, '.', ',');  ?></th>
									<th rowspan="1" colspan="1" style="text-align: right;">$ <?php echo number_format($s_recargo, 2, '.', ',');  ?></th>
									<th rowspan="1" colspan="1" style="text-align: right;">$ <?php echo number_format($s_abono, 2, '.', ',');  ?></th>
									<th rowspan="1" colspan="1" style="text-align: right;">$ <?php echo number_format($sunv, 2, '.', ',');  ?></th>
								</tr>
                </tfoot>
											</table>

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
