<?php $mnAl = 4; $section = "Bibliografia"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de bibliografia'); }
if($_SESSION['Permisos']) {
$AsignacionId=$t->get_datosModuloD($_SESSION['IdAsignacion']);
$recursosA=$t->get_recursosApoyo($_SESSION['IdAsignacion']);
$archivos=$t->get_archivos($AsignacionId[0]["IdEducativa"],$AsignacionId[0]["NombreMod"],$_SESSION['IdAsignacion']);
if($AsignacionId[0]["NombreMod"]) {
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
	  <?php include("menuV.php"); ?>
	  <div class="content-wrapper">
			<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo $AsignacionId[0]["NombreMod"];?>
		  </h1>
		  <ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i><?php echo substr($AsignacionId[0]["NombreMod"], 0 , 40).' [...]';?></a></li>
				<li class="active"><a href="#">Bibliograf&iacute;a</a></li>
		  </ol>
		</section>
		<section class="content">
		  <div class="row">
			<div class="col-md-12">

			  <div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
				  <li class="active"><a href="#activity" data-toggle="tab">Bibliograf&iacute;a</a></li>
				</ul>
				<div class="tab-content">
				  <div class="active tab-pane" id="activity">
					<div class="box">
				<div class="box-body">
				  <table class="table table-bordered">
					<tr>
					  <th>No.</th>
					  <th>Nombre</th>
						<th>Tipo documento</th>
					  <th>Descripción</th>
					  <th>Descargar</th>
					</tr>
					<?php for ($i=0;$i< sizeof($recursosA);$i++) { ?>
					<tr>
					  <td><?php echo $i+1; ?></td>
					  <td><?php echo $recursosA[$i]["Nombre"];?></td>
						<td><?php echo $recursosA[$i]["Tema"];?></td>
					  <td><?php echo $recursosA[$i]["Descripcion"];?></td>
					  <td>
							<?php if($recursosA[$i]["IdTema"]=="7") { ?>
								<button type="button" class="btn btn-primary view_data" href="javascript:void(0);" name="view" value="view" href="javascript:;" id="<?php echo $recursosA[$i]["IdBiblioteca"]; ?>"><i class="fa fa-eye"></i></button>
							<?php } else { ?>
							<a onClick="window.open('assets/biblioteca/<?php echo $recursosA[$i]["Link"] ?>','_blank')" href="javascript:void(0);"><button type="button" class="btn btn-default"><i class="fa fa-cloud-download"></i></button></a>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
					<?php for ($x=0;$x< sizeof($archivos);$x++) { ?>
					<tr>

						<td></td>
					  <td><?php echo $archivos[$x]["Nombre"];?></td>
						<td>Información general</td>
					  <td>Publicado por la Institución</td>
					  <td>
							<a onClick="window.open('assets/docs/files/asignatura/<?php echo $archivos[$x]["Link"] ?>','_blank')" href="javascript:void(0);"><button type="button" class="btn btn-default"><i class="fa fa-cloud-download"></i></button></a>
						</td>
						<?php if($_SESSION['EstatusAsig']=="A"){ ?>
						<td></td>
						<?php } ?>
					</tr>
					<?php } ?>
				  </table>
				</div>
			  </div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</section>
		<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
					<div class="modal-dialog">
							 <div class="modal-content">
										<div class="modal-body" id="employee_detail">
										</div>
							 </div>
					</div>
		 </div>
	  </div>
	  <?php include("footer.php"); ?>
	</div>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
$(document).ready(function(){
		 $(document).on('click', '.view_data', function(){
			 //alert('holla ');
			 //var Id = document.getElementById("Id").value;

					var employee_id = $(this).attr("id");

					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/viewVideo.php",
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
</body>
</html>
<?php
 unset($_SESSION['Alerta']); unset($_SESSION['Variable']);
 } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
}
 } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>
