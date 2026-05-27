<?php  $section = "Configurar datos del rvoe"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de rvoe'); }
$lstRvoe=$t->get_rvoe_list();
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
				<h1><i class="fa fa-fw fa-gears"></i> Configuración de rvoe</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Configuraci&oacute;n</a></li>
					<li class="active">Rvoe</li>
				</ol>
			</section>
			<section class="content">
      <form name="frm" id="frm" action="adDocsSolici.php" method="POST" enctype="multipart/form-data">
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="TipoGuardar" name="TipoGuardar" value="addMatricula" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="9" type="hidden"/>
				<input id="Nombre" name="Nombre" value="Reporte de matrículas por grupo" type="hidden"/>
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
	            <div class="col-md-12">
	              <div class="box-primary">
	                <div class="box-body">
	                  <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
	                    <i class="fa fa-rotate-left"></i> Regresar
	                  </a>
										<!-- <a class="btn btn-app" href="javascript:void(0);" onclick="activarMod()">
	                    <i class="fa fa-file"></i> Nuevo
	                  </a> -->
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
														<th></th>
														<th>CAMPUS</th>
														<th>PLAN DE ESTUDIOS</th>
														<th>RVOE</th>
														<th>VIGENCIA</th>
														<th>ESCUELA</th>
														<th>LOCALIDAD</th>
													</tr>
												</thead>
												<tbody>
													<?php if(isset($lstRvoe[0])){ for ($i=0;$i< sizeof($lstRvoe);$i++) { $Id = $lstRvoe[$i]["IdRvoe"]; ?>
													<tr>
														<td>
															<button onclick="add_rvoe(<?php echo $Id; ?>)" type="button" class="btn bg-maroon btn-flat btn-sm" href="javascript:void(0);"><i class="fa fa-fw fa-edit"></i></button>
															<button onclick="rvoe_campus(<?php echo $Id; ?>)" type="button" class="btn bg-navy btn-flat btn-sm" href="javascript:void(0);"><i class="fa fa-fw fa-gear"></i></button>
														</td>
														<td><?php echo $lstRvoe[$i]["Campus"]; ?></td>
														<td><?php echo $lstRvoe[$i]["Educativa"]; ?></td>
														<td><?php echo $lstRvoe[$i]["Rvoe"]; ?></td>
														<td><?php echo $lstRvoe[$i]["Vigencia"]; ?></td>
														<td><?php echo $lstRvoe[$i]["Escuela"]; ?></td>
														<td><?php echo $lstRvoe[$i]["Localidad"]; ?></td>
													</tr>
												<?php } } ?>
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

		<div id="dataModalRvoe" class="modal fade"> <!--MODAL ME GUSTA-->
  				<div class="modal-dialog">
  						 <div class="modal-content">
  									<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
  											 <button type="button" class="close" data-dismiss="modal">&times;</button>
  											 <h4 class="modal-title"><i class="fa fa-qrcode"></i> Datos del Rvoe</h4>
  									</div>
  									<div class="modal-body" id="employee_detailRvoe">
  									</div>
  						 </div>
  				</div>
  	 </div>
		 <div id="dataModal_Rvoe" class="modal fade"> <!--MODAL ME GUSTA-->
   				<div class="modal-dialog">
   						 <div class="modal-content">
   									<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
   											 <button type="button" class="close" data-dismiss="modal">&times;</button>
   											 <h4 class="modal-title"><i class="fa fa-qrcode"></i> Configurar Rvoe en los campus</h4>
   									</div>
   									<div class="modal-body" id="employee_detail_Rvoe">
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
<script>

function add_rvoe(employee_id){
	$.ajax({
			 url:"vistas/admin/actualizar_rvoe_id.php",
			 method:"POST",
			 data:{employee_id:employee_id},
			 success:function(data){
						$('#employee_detailRvoe').html(data);
						$('#dataModalRvoe').modal('show');
			 }
	});
}

function rvoe_campus(IdRvoe){
	$.ajax({
			 url:"vistas/admin/configurar_rvoe_campus.php",
			 method:"POST",
			 data:{IdRvoe:IdRvoe},
			 success:function(data){
						$('#employee_detail_Rvoe').html(data);
						$('#dataModal_Rvoe').modal('show');
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
