<?php $section = "Generar Pagos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en le módulo de generar pagos'); }

if($_GET['Id']){
	$_POST["txtOferta"] = $_GET['Id'];
}
//
$lstCiclo=$t->get_cEscolarLst();
// $clvGrupo=$t->get_claveGrupoXA($_POST["txtCicloEscolar"],$_POST["txtOferta"]);

if(isset($_POST["Mov"]) && $_POST["Mov"]=="genPago"){
  $t->add_generarPagos();
  exit;
}


$lstConceptos=$t->get_conceptosPlan($_POST["txtOferta"]);
$calen=$t->get_lstCanlendario($_POST["txtOferta"]);




?>




<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<form name="frm" id="frm" action="ctrlGenerarPagos.php" method="POST" enctype="multipart/form-data">
		<input id="TipoGuardar" name="TipoGuardar" value="val_addGenerarPag" type="hidden"/>
		<input id="Mov" name="Mov" value="<?php echo $_GET['Mov'];?>" type="hidden"/>
		<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"] ?>" type="hidden"/>
		<input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Configuración de pagos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Pagos</a></li>
					<li class="active">Generar pagos</li>
				</ol>
			</section>
			<section class="content">

				<div class="row">

						<div class="col-md-3">
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
						<div class="col-md-6">
							<div class="form-group">
								<label>Concepto de pago:</label>
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
						<div class="col-md-3">
							<div class="form-group">
								<label>Monto:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-dollar"></i>
									</div>
									<input type="text" disabled class="form-control pull-right" value="<?php echo $monto; ?>">
									<input type="hidden" name="txtMonto" id="txtMonto" value="<?php echo $monto; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Fecha de pago con descuento:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right" id="datepicker" name="datepicker">
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Fecha de pago base:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right" id="datepicker2" name="datepicker2">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Fecha limite de pago:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right" id="datepicker3" name="datepicker3">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Ciclo escolar:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<select class="form-control select2" name="txtCicloEscolar" id="txtCicloEscolar">
									<option value=""> - Seleccione - </option>
									<?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
									<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"<?php if($_POST["txtCicloEscolar"]==$lstCiclo[$i]["IdCiclo"]){ $tipoO = $lstCiclo[$i]["Tipo"]; ?>selected="selected"<?php }?>><?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
									<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Movimiento:</label>
								<div class="input-group">
									<button id="bntGenerarP" name="bntGenerarP" type="button" class="btn btn-danger" onClick="val_addGenerarPag()"><i class="fa fa-dollar"></i> Generar pago</button>
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="form-group" name="imgLoadPag" id="imgLoadPag" style="display: none;">
								<div class="col-sm-12" style="text-align: center;">
										<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
								</div>
							</div>
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de pagos configurados</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<!-- <th>Ajuste</th> -->
												<th>Estatus</th>
												<th>Concepto</th>
												<th>Monto</th>
												<th>Fechas</th>
												<th>Fec. Captura</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($calen);$i++) {
												   ?>
											<tr><!--
												<td>
													<button onClick="window.open('formConsulta/expPagos.php?IdC=<?php echo time().$calen[$i]["IdCalendario"]; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-info btn-sm"><i class="fa fa-fw fa-download"></i></button>
													 <button onClick="window.open('formConsulta/expPagos.php?IdC=<?php echo time().$calen[$i]["IdCalendario"]; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-edit"></i></button>
												</td>-->
												<td><?php echo $calen[$i]["Estatus"]; ?></td>
												<td><?php echo $calen[$i]["NomPlan"]; ?></td>
												<td><?php echo number_format($calen[$i]["Monto"], 2, '.', ','); ?></td>
												<td>
													Fec. Desc: <?php echo obtenerFechaEnLetra($calen[$i]["FecDescuento"]).'<br>Fec. Base: '.obtenerFechaEnLetra($calen[$i]["FecBase"]).'<br>Fec. Lim: '.obtenerFechaEnLetra($calen[$i]["FecLimite"]); ?></td>
												<td><?php echo $calen[$i]["FecCap"]; ?></td>
											</tr>
										<?php }  ?>
										</tfoot>
									</table>
								</div>
							</div>
						</div>

				</div>
			</section>
		</div>
	  <?php include("footer.php"); ?>
	</div>


	</form>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker-->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

function val_TipoFolio(valor){
    var pagar = document.getElementById("txtIdCurso-"+valor).checked;
    if(pagar == true){
      var numero = 1;
      $.post("formConsulta/updPago.php", { valor:valor, numero:numero }, function(data){
      });
    }else if(pagar == false){
      var numero = 0;
      $.post("formConsulta/updPago.php", { valor:valor, numero:numero }, function(data){
      });
    }

  }

$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	if(alerta){
		if(alerta =="0"){
			swal("Error", "Error no se puede Generar", "error");
		}
		if(alerta =="1"){
			swal("Guardado", "Fechas del pago generado con exito", "success");
		}
	}
});

  $(function () {
    $('#example1').DataTable()
  })
</script>
<script>
  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
	//Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    })
		$('#datepicker3').datepicker({
      autoclose: true
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
