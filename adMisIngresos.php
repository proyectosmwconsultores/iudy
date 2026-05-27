<?php $valor = 3; $section = "Lista de docentes"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando los docentes'); }

if(isset($_POST["datepicker"]) && (isset($_POST["datepicker2"]))){
$misIngs=$t->get_misIngresos($_POST["datepicker"],$_POST["datepicker2"]);
}

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
					Lista de ingresos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Inicio</a></li>
					<li class="active">Mis ingresos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adMisIngresos.php" method="POST" enctype="multipart/form-data">
						<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
						<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
						<input id="Numero" name="Numero" value="2" type="hidden"/>
						<input id="Mov" name="Mov" value="" type="hidden"/>
						<div class="col-md-5">
							<div class="box-primary">
								<div class="box-body">
								<div class="form-group">
									<label>Fec. Inicial: </label>
									<div class="input-group">
										<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
										</div>
										<input type="text" class="form-control pull-right" value="<?php if(isset($_POST["datepicker"])){ echo $_POST["datepicker"]; } ?>" id="datepicker" name="datepicker">
									</div>
								</div>
								</div>
							</div>
						</div>
							<div class="col-md-5">
								<div class="box-primary">
									<div class="box-body">
									<div class="form-group">
										<label>Fec. Final: </label>
										<div class="input-group">
											<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
											</div>
											<input type="text" class="form-control pull-right" value="<?php if(isset($_POST["datepicker2"])){ echo $_POST["datepicker2"]; } ?>" id="datepicker2" name="datepicker2">
										</div>
									</div>
									</div>
								</div>
							</div>

							<div class="col-md-2">
								<div class="box-primary">
									<div class="box-body">
									<div class="form-group">
										<label>&nbsp; </label>
										<div class="input-group">
											<button type="button" class="btn btn-primary" onClick="val_datosBusquedaTipo()"> <i class="fa fa-fw fa-search"></i> Buscar</button>
										</div>
									</div>
									</div>
								</div>
							</div>
							<?php if(isset($misIngs[0])){ ?>
						<div class="col-xs-12">

							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de ingresos segun el rango de fecha</h3>
								</div>
								<div class="box-body">
								<div class="table-responsive">
									<table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
										<thead>
											<tr>
												<th>Nombre del docente</th>
												<th>Paquete</th>
												<th>Fec. Compra</th>
												<th>Tipo compra</th>
												<th>Monto</th>
												<th>Ingreso</th>
											</tr>
										</thead>
										<tbody>
											<?php $ing = 0; for ($i=0;$i< sizeof($misIngs);$i++) {
												if($misIngs[$i]["IdTipo"] == 1){ $txt_ = 'Compra'; } else { $txt_ = 'Renovación'; }
												?>
											<tr>
												<td><?php echo $misIngs[$i]["Nombre"].' '.$misIngs[$i]["APaterno"].' '.$misIngs[$i]["AMaterno"]; ?></td>
												<td>Paquete <?php echo $misIngs[$i]["Paquete"]; ?></td>
												<td><?php echo $misIngs[$i]["FecCap"]; ?></td>
												<td><?php echo $txt_; ?></td>
												<td>$ <?php echo number_format($misIngs[$i]["Monto"], 2, '.', ','); ?></td>
												<td>$ <?php echo number_format($misIngs[$i]["ingreso"], 2, '.', ','); ?></td>
											</tr>
											<?php $ing = ($ing + $misIngs[$i]["ingreso"]); } ?>
										</tfoot>
										<tfoot>
		                	<tr>
												<th rowspan="1" colspan="5" style="text-align: right;">Total ingreso</th>
												<th rowspan="1" colspan="1">$ <?php echo number_format($ing, 2, '.', ','); ?></th>
											</tr>
		                </tfoot>
									</table>
								</div>
								</div>
							</div>
						</div><?php } ?>

						<div id="dataModal2" class="modal fade bs-example-modal-lg"> <!--MODAL ME GUSTA-->
								 <div class="modal-dialog">
											<div class="modal-content">
													 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Historial de asignaturas</h4>
													 </div>
													 <div class="modal-body" id="employee_detail2">

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
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	  <?php include("footer.php"); ?>
	</div>
</body>
<!-- jQuery 3 -->
<script>
$(document).ready(function(){
		 $(document).on('click', '.view_detalle', function(){
					var employee_id = $(this).attr("id");
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/lstAsignaturas.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail2').html(data);
												 $('#dataModal2').modal('show');
										}
							 });
					}
		 });
});

$(function () {
	//Date picker
	$('#datepicker').datepicker({
		autoclose: true
	})
//Date picker
	$('#datepicker2').datepicker({
		autoclose: true
	})

})
</script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
