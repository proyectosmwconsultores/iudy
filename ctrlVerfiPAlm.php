<?php $section = "Verificar Saldos"; include("head.php");
if($_SESSION['IdUsua'] && $_SESSION['Permisos']==1){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando las verificaciones de pagos'); }
$oferta=$t->get_OfertaETodos();
if(isset($_GET["token"])){
	$_POST["txtOferta"] = $_GET["ed"];
	$_POST["txtIdUsua"] = substr($_GET["token"], 10,4);

}

$lstAlumnosP=$espacio->get_alumnosPag($_POST["txtOferta"]);
$pagoId=$t->get_verificarPagosId($_POST["txtIdUsua"]);
?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Verificaci&oacute;n de saldos por alumno
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Inicio</a></li>
					<li class="active">Verificación de saldos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="ctrlVerfiPAlm.php" method="POST" enctype="multipart/form-data">
						<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'];?>" type="hidden"/>
						<div class="col-md-6">
							<div class="form-group">
								<label>Oferta educativa:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();" <?php if(isset($_GET["token"])){ echo "disabled"; } ?>>
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
										<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST[txtOferta]==$oferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Alumno:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control"  name="txtIdUsua" id="txtIdUsua" onchange="document.frm.submit();" <?php if(isset($_GET["token"])){ echo "disabled"; } ?>>
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstAlumnosP);$i++) { ?>
										<option value="<?php echo $lstAlumnosP[$i]["IdUsua"]; ?>"<?php if($_POST["txtIdUsua"]==$lstAlumnosP[$i]["IdUsua"]){?>selected="selected"<?php }?>><?php echo $lstAlumnosP[$i]["Nombre"].' '.$lstAlumnosP[$i]["APaterno"].' '.$lstAlumnosP[$i]["AMaterno"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>


						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de pagos</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Concepto</th>
												<th>Cuenta</th>
												<th>FecPago</th>
												<th>Estatus</th>
												<th>Monto</th>
												<th>Recargo</th>
												<th>Total pagado</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($pagoId);$i++) {
												if($pagoId[$i]["DetEstatus"] != 7){
														$descuento=$t->get_descuento($pagoId[$i]["IdDescuento"]);
												  ?>
											<tr>
												<td><?php echo $pagoId[$i]["NomConcepto"]; ?></td>
												<td><?php echo $pagoId[$i]["Banco"]; ?></td>
												<td><?php echo $pagoId[$i]["FecPago"]; ?></td>
												<td><b><?php echo $pagoId[$i]["Estatus"]; ?></b></td>
												<td>$ <?php echo number_format($pagoId[$i]["Pagar"], 2, '.', ','); ?></td>
												<td>$ <?php echo number_format($pagoId[$i]["Recargos"], 2, '.', ','); ?>
													<?php if($descuento[0]["IdDescuento"]){ ?>
												<br>(<?php echo $descuento[0]["Porcentaje"]; ?>% en <br> <?php echo $descuento[0]["NomDescuento"]; ?>)
												<br><b>(- $ <?php echo $descuento[0]["Descuento"]; ?>)</b><?php } ?>
												</td>
												<td><b>$ <?php echo number_format($pagoId[$i]["TotalPagado"], 2, '.', ','); ?></b></td>
												</td>
											</tr>
										<?php } } ?>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</form>
				</div>
				<?php if($pagoId[0]){ ?>
				<div class="row no-print">
          <button type="button" onclick="javascript:window.open('formConsulta/expSaldos.php?IdO=<?php echo $_POST["txtOferta"]; ?>&IdUsua=<?php echo $_POST["txtIdUsua"]; ?>');" href="javascript:void(0);" class="btn btn-danger pull-right" style="margin-right: 15px;"><i class="fa fa-download"></i> EXCEL</button>
        </div><?php } ?>
			</section>
		</div>
	  <?php include("footer.php"); ?>
	</div>


</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<!-- date-range-picker -->
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker-->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script>


  $(function () {
    $('#example1').DataTable()
  })


	    //Date picker
	    $('#datepicker').datepicker({
	      autoclose: true
	    })

			$('#datepicker2').datepicker({
	      autoclose: true
	    })

</script>
</body>
</html>
