<?php $section = "Balanza General"; include("head.php");
if($_SESSION['IdUsua'] && $_SESSION['Permisos']==1){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando la balanza general'); }
$oferta=$t->get_OfertaETodos();
$balanza=$t->get_balanzaGral($_POST["txtOferta"],$_POST["datepicker"],$_POST["datepicker2"]);
?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Balanza general
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Inicio</a></li>
					<li class="active">Balanza</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="balGeneral.php" method="POST" enctype="multipart/form-data">
						<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'];?>" type="hidden"/>
						<div class="col-md-4">
							<div class="form-group">
								<label>Oferta educativa:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control" name="txtOferta" id="txtOferta">
										<option value=""> - Seleccione - </option>
										<option value="TODAS"<?php if($_POST["txtOferta"]=="TODAS"){?>selected="selected"<?php }?>>Todas las Ofertas Educativas</option>
										<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
										<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$oferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Fecha inicial:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right" id="datepicker" name="datepicker" value="<?php echo $_POST["datepicker"] ?>">
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Fecha final:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right" id="datepicker2" name="datepicker2" value="<?php echo $_POST["datepicker2"] ?>">
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>&nbsp;</label>
								<button type="button" class="btn btn-block btn-info btn-sm" onclick="document.frm.submit();"><i class="fa fa-fw fa-search"></i> Buscar </button>
							</div>
						</div>

						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Balanza general con rango de fecha</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Oferta educativa</th>
												<th>Tipo de concepto</th>
												<th>Ingreso</th>
												<th>Cve. Grupo</th>
												<th>Alumno</th>
												<th>Fecha ingreso</th>
												<th>Importe</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($balanza);$i++) { $total = $balanza[$i]["TotalPagado"] + $total; ?>
											<tr>
												<td style="font-size: 12px;"><?php echo $balanza[$i]["nomEducativa"]; ?></td>
												<td style="font-size: 12px;"><?php echo $balanza[$i]["NomConcepto"]; ?></td>
												<td style="font-size: 12px;"><?php echo $balanza[$i]["Banco"]; ?></td>
												<td style="font-size: 12px;"><?php echo $balanza[$i]["CveGrupo"].' '.$balanza[$i]["Grupo"]; ?></td>
												<td style="font-size: 12px;"><?php echo $balanza[$i]["Nombre"].' '.$balanza[$i]["APaterno"].' '.$balanza[$i]["AMaterno"]; ?></td>
												<td style="font-size: 12px;"><?php echo $balanza[$i]["FecPago"]; ?></td>

												<td style="font-size: 12px;">$ <?php echo number_format($balanza[$i]["TotalPagado"], 2, '.', ','); ?></td>
											</tr>
										<?php } ?>
										</tfoot>
										<tfoot>
			                <tr><th style="text-align: right;" rowspan="1" colspan="6">Totales</th><th rowspan="1" colspan="1">$ <?php echo number_format($total, 2, '.', ','); ?></th></tr>
		                </tfoot>
									</table>
								</div>
							</div>
						</div>
					</form>
				</div>
				<?php if($balanza[0]){ ?>
				<div class="row no-print">
          <button type="button" onclick="javascript:window.open('formConsulta/expBalanzaGral.php?IdO=<?php echo $_POST["txtOferta"]; ?>&F1=<?php echo $_POST["datepicker"]; ?>&F2=<?php echo $_POST["datepicker2"]; ?>');" href="javascript:void(0);" class="btn btn-danger pull-right" style="margin-right: 15px;"><i class="fa fa-download"></i> EXCEL</button>
        </div><?php } ?>
      </div>
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
