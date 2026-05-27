<?php $section = "Pagos pendientes"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando el reporte de pagos pendientes'); }
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));
$campusId=$t->get_campusPermiso($_SESSION['IdUsua']);

$lstGrps=$t->get_grupoPend($_POST["txtOferta"],$_POST["txtCampus"]);

$pagoPend=$t->get_pagosPenGrupo($_POST["txtGrupo"],$_POST["txtEstatus"]);
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
					Reporte de pagos pendientes por grupo
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Reportes</a></li>
					<li class="active">Pagos pendientes</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="repGrupo.php" method="POST" enctype="multipart/form-data">
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="16" type="hidden"/>

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
							<div class="col-md-8">
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
									<label>Clave de grupo:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control select2" name="txtGrupo" id="txtGrupo" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstGrps);$i++) { ?>
										<option value="<?php echo $lstGrps[$i]["IdGrupo"]; ?>"<?php if($_POST["txtGrupo"]==$lstGrps[$i]["IdGrupo"]){ $txtGrp = $lstGrps[$i]["CveGrupo"];  ?>selected="selected"<?php }?>><?php echo $lstGrps[$i]["CveGrupo"]; ?></option>
										<?php } ?>
									  </select>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Estatus del alumno:</label>
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
									</div>
								</div>
							</div>
							<?php if($pagoPend[0]){ ?>
							<div class="col-md-4">
								<div class="form-group">
									<label>:.</label>
									<div class="input-group">
										<button type="button" onclick="javascript:window.open('repositorio/pdf/saldoGrupo.php?tokenId=<?php echo time().$_POST["txtGrupo"]; ?>&IdEs=<?php echo time().$_POST["txtEstatus"]; ?>');" href="javascript:void(0);" class="btn btn-block btn-primary btn-sm"><i class="fa fa-fw fa-file-pdf-o"></i> Descargar archivo</button>
									</div>
								</div>
							</div><?php } ?>

	              <div class="col-md-12">
	                <div class="box">
										<div class="box-body">
<br>
										<div class="table-responsive">
											<table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;" >
												<thead>
													<tr>
														<th>Nombre</th>
														<th>Concepto</th>
														<th>Ciclo</th>
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
													<?php $sunv = 0; for ($i=0;$i< sizeof($pagoPend);$i++) {
														$xx=$t->get_chkPago($pagoPend[$i]["IdUsua"]);
														$xY=$t->get_beca($pagoPend[$i]["IdUsua"],$pagoPend[$i]["IdPago"]);
														$xZ=$t->get_recargo($pagoPend[$i]["IdUsua"],$pagoPend[$i]["IdPago"]);
														  $sumX = ($pagoPend[$i]["Monto"] - $pagoPend[$i]["Descuento"] + $xZ[0]["Recargo"] - $pagoPend[$i]["TotalPagado"]);
															$sunv = ($sunv + $sumX);
														  ?>
													<tr>

														<td> <?php echo $pagoPend[$i]["Nombre"].' '.$pagoPend[$i]["APaterno"].' '.$pagoPend[$i]["AMaterno"]; ?></td>
														<td><?php echo $pagoPend[$i]["NomPlan"]; ?></td>
														<td><?php echo $pagoPend[$i]["Ciclo"]; ?></td>
														<td><?php echo $txtGrp; ?></td>
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
                <tr><th rowspan="1" colspan="10" style="text-align: right;">Total:</th><th rowspan="1" colspan="1" style="text-align: right;">$ <?php echo number_format($sunv, 2, '.', ',');  ?></th></tr>
                </tfoot>
											</table>

										</div>
										</div>
	                </div>


	              </div>
	          </div>
	        </div>
	      </div>
				<input id="Nombre" name="Nombre" value="Pagos pendientes por grupo - CveGrupo: <?php echo $txtGrp; ?>" type="hidden"/>
				<input id="Oferta" name="Oferta" value="<?php echo $pagoPend[0]["Educativa"]; ?>" type="hidden"/>

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
