<?php $section = "Reporte de pagos aprobados pagos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando el reporte de pagos aprobados'); }
if(isset($_POST['txtCampus'])){ $_POST['txtCampus'] = $_POST['txtCampus']; } else { $_POST['txtCampus'] = ''; }
$campus=$t->get_lstCampusAc();
$saldo=$t->get_saldoIni($_POST['txtCampus']);

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
					Reporte de saldos iniciales
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Reportes</a></li>
					<li class="active">Saldos iniciales</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="repSaldo.php" method="POST" enctype="multipart/form-data">
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'];?>" type="hidden"/>
				<input id="Mov" name="Mov" value="" type="hidden"/>
				<input id="IdDoc" name="IdDoc" value="" type="hidden"/>
				<input id="Alerta" name="Alerta" value="<?php if(isset($_SESSION['Alerta'])){ echo $_SESSION['Alerta']; } ?>" type="hidden"/>
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php if(isset($bytesCodificados)){ echo $bytesCodificados;} ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="6" type="hidden"/>
				<input id="Nombre" name="Nombre" value="Reporte de verificación de pagos" type="hidden"/>
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
							<div class="col-md-12">
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


	              <div class="col-md-12">
	                <div class="box">
										<div class="box-body">
										<div class="table-responsive">
											<table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;" >
												<thead>
													<tr>
														<th>CAMPUS</th>
														<th>OFERTA</th>
														<th>NOMBRE</th>
														<th>DESCRIPCIÓN</th>
														<th>TIPO</th>
														<th style="width: 100px;">MONTO</th>
													</tr>
												</thead>
												<tbody>
													<?php $salEg = 0; $salIng = 0; for ($i=0;$i< sizeof($saldo);$i++) {
														if($saldo[$i]["Tipo"] == "Egreso"){
															$txtS = "Saldo inicial";
															$salEg =($salEg + $saldo[$i]["Monto"]);
														} else {
															$txtS = "Abono";
															$salIng =($salIng + $saldo[$i]["Monto"]);
														}
														  ?>
													<tr>
														<td><?php echo $saldo[$i]["Campus"]; ?></td>
														<td><?php echo $saldo[$i]["Educativa"]; ?></td>
														<td><?php echo $saldo[$i]["Nombre"].' '.$saldo[$i]["APaterno"].' '.$saldo[$i]["AMaterno"]; ?></td>
														<td><?php echo $saldo[$i]["Descripcion"]; ?></td>
														<td><?php echo $txtS; ?></td>
														<td style="text-align: right;">$
															<?php echo number_format($saldo[$i]["Monto"], 2, '.', ',');  ?>
														</td>
													</tr>
												<?php

											 } ?>
												</tfoot>
												<tfoot>
													<tr><th rowspan="1" colspan="5" style="text-align: right;">Saldo Egreso:</th><th rowspan="1" colspan="1" style="text-align: right;">$ <?php echo number_format($salEg, 2, '.', ',');  ?></th></tr>
                				<tr><th rowspan="1" colspan="5" style="text-align: right;">Saldo Ingreso (abono):</th><th rowspan="1" colspan="1" style="text-align: right;">$ <?php echo number_format($salIng, 2, '.', ',');  ?></th></tr>
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
