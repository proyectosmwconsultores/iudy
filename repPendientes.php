<?php $section = "Reporte de pagos pendintes"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando el reporte de pagos pendientes'); }
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));
$campusId=$t->get_campusId();
$lstCiclo=$t->get_CicloEscolar();
$lstConceptos=$t->get_conceptosPlan($_POST["txtOferta"]);
$lstCalendario=$t->get_calen($_POST["txtOferta"],$_POST["txtCicloEscolar"],$_POST["txtConcepto"]);
$pagoPend=$t->get_pagosPend($_POST["txtCampus"],$_POST["txtCicloEscolar"],$_POST["txtConcepto"],$_POST["txtCalen"]);
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
					Reporte de pagos pendientes
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Reportes</a></li>
					<li class="active">Pagos aprobados de pagos</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="repPendientes.php" method="POST" enctype="multipart/form-data">
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="6" type="hidden"/>
				<input id="Nombre" name="Nombre" value="Reporte de verificación de pagos" type="hidden"/>
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Tipo de oferta educativa:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<option value="1"<?php if($_POST["txtOferta"]=="1"){?>selected="selected"<?php }?>>Doctorado</option>
											<option value="2"<?php if($_POST["txtOferta"]=="2"){?>selected="selected"<?php }?>>Maestria</option>
											<option value="3"<?php if($_POST["txtOferta"]=="3"){?>selected="selected"<?php }?>>Licenciatura</option>
											<option value="6"<?php if($_POST["txtOferta"]=="6"){?>selected="selected"<?php }?>>Bachillerato</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Campus:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($campusId);$i++) { ?>
											<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"<?php if($_POST["txtCampus"]==$campusId[$i]["IdCampus"]){ ?>selected="selected"<?php }?>><?php echo $campusId[$i]["Campus"]; ?></option>
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
										<select class="form-control" name="txtCicloEscolar" id="txtCicloEscolar">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
										<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"<?php if($_POST["txtCicloEscolar"]==$lstCiclo[$i]["IdCiclo"]){ $tipoO = $lstCiclo[$i]["Tipo"]; ?>selected="selected"<?php }?>><?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
										<?php } ?>
									  </select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Plan de concepto:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtConcepto" id="txtConcepto" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($lstConceptos);$i++) { ?>
											<option value="<?php echo $lstConceptos[$i]["IdConceptoPlanes"]; ?>"<?php if($_POST["txtConcepto"]==$lstConceptos[$i]["IdConceptoPlanes"]){   $monto = $lstConceptos[$i]["Costo"];  ?>selected="selected"<?php }?>><?php echo $lstConceptos[$i]["NomPlan"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Fecha de pago:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtCalen" id="txtCalen" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($lstCalendario);$i++) { ?>
											<option value="<?php echo $lstCalendario[$i]["IdCalendario"]; ?>"<?php if($_POST["txtCalen"]==$lstCalendario[$i]["IdCalendario"]){   $monto = $lstConceptos[$i]["Costo"];  ?>selected="selected"<?php }?>><?php echo $lstCalendario[$i]["FecDescuento"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<?php if($_POST["txtConcepto"]){ ?>
							<div class="col-md-2">
								<div class="form-group">
									<label>:.</label>
									<div class="input-group">

										<button onClick="window.open('formConsulta/expTodosPagos.php?IdG=<?php echo $_POST["txtOferta"]; ?>&IdC=<?php echo $_POST["txtCampus"]; ?>&IdP=<?php echo $_POST["txtConcepto"]; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-info btn-sm">General <i class="fa fa-fw fa-download"></i></button>
									</div>
								</div>
							</div><?php } ?>

	              <div class="col-md-12">
	                <div class="box">
										<div class="box-body">
											<!-- <table class="table table-bordered">
				                <tbody>
				                <tr>
				                  <!-- <td><i style="color: black;" class="fa fa-fw fa-circle"></i></td>
				                  <td>No existe descuento</td>
													<td><i style="color: blue;" class="fa fa-fw fa-circle"></i></td>
				                  <td>Descuento activo</td>
													<td><i style="color: red;" class="fa fa-fw fa-circle"></i></td>
													<td>Descuento caducado</td>
				                  <td><a onClick="window.open('formConsulta/expPendientes.php','_self')" href="javascript:void(0);" class="btn btn-block btn-social btn-google">
								                <i class="fa fa fa-fw fa-cloud-download"></i> Descargar concentrado
								              </a></td>
				                </tr>
				              </tbody></table> -->
<br>

										<div class="table-responsive">
											<table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
												<thead>
													<tr>
														<th>Nombre</th>
														<th>Oferta educativa</th>
														<th>Concepto</th>
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
													<?php for ($i=0;$i< sizeof($pagoPend);$i++) {
														$xx=$t->get_chkPago($pagoPend[$i]["IdUsua"]);
														$xY=$t->get_beca($pagoPend[$i]["IdUsua"],$pagoPend[$i]["IdPago"]);
														$xZ=$t->get_recargo($pagoPend[$i]["IdUsua"],$pagoPend[$i]["IdPago"]);
														  $sumX = ($pagoPend[$i]["Monto"] - $pagoPend[$i]["Descuento"] + $xZ[0]["Recargo"] - $pagoPend[$i]["TotalPagado"]);
															$sunv = ($sunv + $sumX); ?>
													<tr>
														<td> <?php echo $pagoPend[$i]["Nombre"].' '.$pagoPend[$i]["APaterno"].' '.$pagoPend[$i]["AMaterno"]; ?></td>
														<td><?php echo $pagoPend[$i]["Educativa"]; ?></td>
														<td><?php echo $pagoPend[$i]["NomPlan"]; ?></td>
														<td><?php echo $pagoPend[$i]["Estatus"]; ?></td>
														<td><?php echo $pagoPend[$i]["FecDesc"]; ?></td>
														<td style="width: 80px; text-align: right;">$ <?php echo number_format($pagoPend[$i]["Monto"], 2, '.', ',');  ?></td>
														<td style="width: 80px; text-align: right;">$ <?php echo number_format($pagoPend[$i]["Descuento"], 2, '.', ',');  ?></td>
														<td style="width: 80px; text-align: right;">$ <?php echo number_format($xZ[0]["Recargo"], 2, '.', ',');  ?></td>
														<td style="width: 80px; text-align: right;">$ <?php echo number_format($pagoPend[$i]["TotalPagado"], 2, '.', ',');  ?></td>
														<td style="width: 80px; text-align: right;">$ <?php echo number_format($sumX, 2, '.', ',');  ?></td>
													</tr>
												<?php  } ?>
												</tfoot>
												<tfoot>
                <tr><th rowspan="1" colspan="9" style="text-align: right;">Total:</th><th rowspan="1" colspan="1" style="text-align: right;">$ <?php echo number_format($sunv, 2, '.', ',');  ?></th></tr>
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
    <!-- Mainly scripts -->
    <script src="assets/table/js/jquery-3.1.1.min.js"></script>
    <script src="assets/table/js/bootstrap.min.js"></script>
    <script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
    <!-- Custom and plugin javascript -->
		<script src="assets/table/js/scriptAgregado1.js"></script>

	  <?php include("footer.php"); ?>
	</div>


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
