<?php $_v = 90; $section = "Asignaturas finalizadas"; include("head.php");
if($_SESSION['IdUsua']) {
	$moduloA=$t->get_matFinDoc($_SESSION['IdUsua']);

	$moduloAlumFin=$t->get_modFinaAlum($_SESSION['IdUsua']);
	if($_SESSION['Permisos'] != 5) {
		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Esta en visualizando las asignaturas finalizadas');
	}
unset($_SESSION['IdAsignacion']);
unset($_SESSION['IdOferta']);
unset($_SESSION['EstatusAsig']);
//$checarEstatus=$t->get_checarEstatus();

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<?php if($_SESSION['IdEstatus'] == 50){ include("formConsulta/msjEstatus.php"); } ?>
			<form name="frm" id="frm" action="viewFinalizados.php" method="POST" enctype="multipart/form-data">
				<?php if(isset($_GET["x"]) && ($_GET["x"] == "x")){ ?>
				<div style="padding: 20px 30px; background: rgb(243, 58, 18) none repeat scroll 0% 0%; z-index: 999999; font-size: 16px; font-weight: 600;">Favor de realizar la encuesta que tenga pendiente.</a></div><?php } ?>
			<section class="content-header">
				<h1>Lista de asignaturas finalizadas</h1>
				<ol class="breadcrumb">
					<li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
					<li class="active">Asignaturas finalizadas</li>
				</ol>
			</section>
			<section class="content">
				<?php if(($_SESSION['Permisos'] =="2") || ($_SESSION['Permisos'] =="4")) { ?>
					<div class="row">
						<div class="col-xs-12">
		          <div class="box">
		            <div class="box-header">
		              <h3 class="box-title">Lista de asignaturas finalizadas</h3>
		            </div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Campus</th>
												<th>Oferta</th>
												<th>Nombre de la asignatura</th>
												<th>CveGrupo</th>
												<th>Fecha</th>
												<th>Ajuste</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($x=0;$x< sizeof($moduloA);$x++) {  ?>
												<tr>
													<td><?php echo $moduloA[$x]["Campus"]; ?></td>
													<td><?php echo $moduloA[$x]["NomEducativa"]; ?></td>
													<td><?php echo $moduloA[$x]["NombreMod"]; ?></td>
				                  <td><?php echo $moduloA[$x]["CveGrupo"]; ?></td>
													<td><?php echo $moduloA[$x]["FecIni"].' al '.$moduloA[$x]["FecFin"]; ?></td>
				                  <td>
														<?php if($_SESSION['IdEstatus'] == 8){ ?><button onClick="window.open('doMiPlaneacion.php?idToks=<?php echo $moduloA[$x]["IdAsignacion"]; ?>&T=F','_self')" href="javascript:void(0);" style="cursor: pointer;" type="button" class="btn btn-default btn-sm"> <i class="fa fa-fw fa-arrow-circle-o-right"></i> Ingresar </button><?php } ?>
				                </tr>
											<?php }  ?>
										</tfoot>
									</table>
								</div>
		          </div>
		        </div>
				</div>
				<?php } ?>
				<?php if($_SESSION['Permisos'] =="3") { ?>
				<div class="row">

					<div class="col-xs-12">
	          <div class="box">
	            <div class="box-header">
	              <h3 class="box-title">Lista de asignaturas finalizadas</h3>
	            </div>
							<div class="box-body">
							<table class="table table-striped">
								<tbody>
									<?php $ini = 0; $grado = 1; $valor = 0; for ($y=0;$y< sizeof($moduloAlumFin);$y++) { $id = $moduloAlumFin[$y]["IdAsignacion"];

										if($moduloAlumFin[$y]["Estatus"] == "Finalizado") {
											$encuesta=$t->get_encuestaDR($id,$_SESSION["IdUsua"]);
										if($grado == $moduloAlumFin[$y]["Grado"]){ $ini = 1; } else { $ini = 0; } ?>
										<?php if(($ini == 0) || ($valor == 0)){ ?>
										<tr style="background: #aeaaaa; color: #000; ">
											<th colspan="5"><?php echo $moduloAlumFin[$y]["Grado"].$moduloAlumFin[$y]["Abreviatura"]; ?> <?php echo $moduloAlumFin[$y]["Tipo"]; ?></th>
										</tr>
										<tr style="background: #e1dede; color: #000; ">
											<th>IdAsignacion</th>
											<th>Asignatura</th>
											<th>Vigencia</th>
											<!-- <th></th> -->
											<th></th>
										</tr> <?php } ?>
										<tr>
											<td><?php echo $moduloAlumFin[$y]["IdAsignacion"]; ?></td>
											<td><?php echo $moduloAlumFin[$y]["CodeModulo"].' '.$moduloAlumFin[$y]["NombreMod"]; ?></td>
											<td><?php echo $moduloAlumFin[$y]["FecIni"].' al '.$moduloAlumFin[$y]["FecFin"]; ?></td>
											<!-- <td>
												<?php if($encuesta[0]["Estatus"]){ if($encuesta[0]["Estatus"] == 8) { ?>
													<button style="cursor: pointer;"  type="button" class="btn btn-block btn-info btn-sm view_data" href="javascript:void(0);" name="view" value="view" id="<?php echo $id; ?>"> <i class="fa fa-unlock"></i> Realizar encuesta </button>
												<?php } else { ?>
													<button style="cursor: pointer;"  type="button" class="btn btn-block btn-de btn-sm"> <i class="fa fa-lock"></i> Encuesta realizada </button>
												<?php } } ?>

											</td> -->
											<td>
												<button onClick="window.open('miMateria.php?idAsignacion=<?php echo $moduloAlumFin[$y]["IdAsignacion"]; ?>&T=F','_self')" href="javascript:void(0);" style="cursor: pointer;"  type="button" class="btn btn-block btn-default btn-sm"> <i class="fa fa-fw fa-arrow-circle-o-right"></i> Ingresar </button>
											</td>
										</tr>
								<?php $valor = 1; $grado = $moduloAlumFin[$y]["Grado"]; } } ?>
							</tbody></table>
						</div>
	          </div>
	        </div>

				</div>
			  <?php } ?>
			</section>
			<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
								 <div class="modal-content">
											<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
													 <button type="button" class="close" data-dismiss="modal">&times;</button>
													 <h4 class="modal-title">Realizar encuesta del m&oacute;dulo finalizado</h4>
											</div>
											<div class="modal-body" id="employee_detail">
								 			</div>
									</div>
					</div>
			 </div>
		</form>
		</div>
	  <?php include("footer.php"); ?>
	</div>
	<div id="dataModal3" class="modal fade"> <!--MODAL ME GUSTA-->
			 <div class="modal-dialog">
						<div class="modal-content">
									<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
											 <button type="button" class="close" data-dismiss="modal">&times;</button>
											 <h4 class="modal-title"><i class="fa fa-qrcode"></i> Activar clase nuevamemente</h4>
									</div>
								 <div class="modal-body" id="employee_detail3">
								 </div>
						</div>
			 </div>
	</div>

<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script><!-- Sparkline -->
<!-- AdminLTE App -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
$(document).ready(function(){
		 $(document).on('click', '.view_code', function(){
					var employee_id = $(this).attr("id");
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/activarClase.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail3').html(data);
												 $('#dataModal3').modal('show');
										}
							 });
					}
		 });
});

	$(document).ready(function(){
			 $(document).on('click', '.view_data', function(){
						var employee_id = $(this).attr("id");

						var IdUsua = document.getElementById("IdUsua").value;
						if(employee_id != '')
						{
								 $.ajax({
									 url:"formConsulta/createEncuesta.php",
									 method:"POST",
											data:{employee_id:employee_id, IdUsua:IdUsua},
											success:function(data){
													 $('#employee_detail').html(data);
													 $('#dataModal').modal('show');
											}
								 });
						}
			 });
	});
	$(function () {
		$('#example1').DataTable()
	})
</script>
</body>
</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
