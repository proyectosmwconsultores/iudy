<?php $section = "Reporte de pagos aprobados pagos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando el reporte de pagos aprobados'); }
$oferta=$t->get_lstOTodos();
$campus=$t->get_campusPermiso($_SESSION['IdUsua']);


//$conceptos=$espacio->get_conceptosOf($_POST["txtOferta"]);
$conceptos=$t->get_conceptospAG($_POST["txtOferta"],$_POST["txtCampus"]);
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));

//$lstgrupo=$espacio->get_grupoActiv($_POST["txtOferta"]);
$lstCiclo=$t->get_CicloEscolar();
// $clvGrupo=$t->get_claveGrupoXA($_POST["txtCicloEscolar"],$_POST["txtOferta"],$_POST["txtCampus"]);

$pagoId=$t->get_reportPagos($_POST["txtCampus"],$_POST["txtOferta"],$_POST["txtCicloEscolar"],$_POST["txtConcepto"]);
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
					Reporte de pagos aprobados
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Reportes</a></li>
					<li class="active">Pagos aprobados de pagos</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="repPagosA.php" method="POST" enctype="multipart/form-data">
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
											<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$oferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
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
							<!-- <div class="col-md-4">
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
							</div> -->
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
											<option class="form-control"  value="<?php echo $conceptos[$i]["IdConceptoPlanes"]; ?>"<?php if($_POST["txtConcepto"]==$conceptos[$i]["IdConceptoPlanes"]){?>selected="selected"<?php }?>><?php echo $conceptos[$i]["NomPlan"]; ?></option>
											<?php } ?>
										</select>
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
														<th></th>
														<th>Folio</th>
														<th>Nombre</th>
														<th>FecPago</th>
														<th>Cuenta</th>
														<th>Monto</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($i=0;$i< sizeof($pagoId);$i++) {

														  ?>
													<tr>
														<td>
															<?php if($pagoId[$i]["_img"]){ ?>
															<button onclick="subir_mi_pago(<?php echo $pagoId[$i]["IdPago"]; ?>,1)" type="button" title="Seguimiento del pago" class="btn bg-primary btn-flat btn-sm"><i class="fa fa-fw fa-camera"></i></button>
														<?php } ?>
														</td>
														<td><?php echo $pagoId[$i]["Folio"]; ?></td>
														<td><?php echo $pagoId[$i]["Nombre"].' '.$pagoId[$i]["APaterno"].' '.$pagoId[$i]["AMaterno"]; ?></td>
														<td><?php echo $pagoId[$i]["FecPago"]; ?></td>
														<td><?php echo $pagoId[$i]["Descripcion"]; ?></td>
														<td style="text-align: right;">$
															<?php echo number_format($pagoId[$i]["Monto"], 2, '.', ',');  ?>
														</td>
													</tr>
												<?php $suma = $suma + $pagoId[$i]["Monto"]; } ?>
												</tfoot>
												<tfoot>
                <tr><th rowspan="1" colspan="4" style="text-align: right;">Total:</th><th rowspan="1" colspan="1" style="text-align: right;">$ <?php echo number_format($suma, 2, '.', ',');  ?></th></tr>
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
		<div id="data_pag" class="modal fade"> <!--MODAL ME GUSTA-->
	       <div class="modal-dialog">
	            <div class="modal-content">
	                 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
	                      <button type="button" class="close" data-dismiss="modal">&times;</button>
	                      <h4 class="modal-title"><i class="fa fa-fw fa-file"></i> Comprobante de pago</h4>
	                 </div>
	                 <div class="modal-body" id="employee_pag">

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

function subir_mi_pago(IdPago,TipoPago){
	var Tipo = 2;
	$.ajax({
			 url:"formConsulta/seguimiento_pago_sel.php",
			 method:"POST",
			 data:{IdPago:IdPago, Tipo:Tipo, TipoPago:TipoPago},
			 success:function(data){
						$('#employee_pag').html(data);
						$('#data_pag').modal('show');
			 }
	});
}

</script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
