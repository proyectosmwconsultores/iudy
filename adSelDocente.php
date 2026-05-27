<?php $valor = 3; $section = "Lista de docentes"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando los docentes'); }

$lstCampus=$t->get_campusPermiso($_SESSION['IdUsua']);

if(isset($_POST['txtCampus'])){ $_POST['txtCampus'] = $_POST['txtCampus']; } else { $_POST['txtCampus'] = ''; }
$docentes=$t->get_docentesTId($_POST['txtCampus']);
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
					Asesores acad&eacute;micos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Directorio</a></li>
					<li class="active">Asesores acad&eacute;micos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adSelDocente.php" method="POST" enctype="multipart/form-data">
						<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
						<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
						<input id="Numero" name="Numero" value="2" type="hidden"/>
						<div class="col-md-12">
							<div class="form-group">
								<label>Campus:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-fw fa-key"></i>
									</div>
									<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstCampus);$i++) { ?>
												<option value="<?php echo $lstCampus[$i]["IdCampus"]; ?>"<?php if($_POST['txtCampus']==$lstCampus[$i]["IdCampus"]){?>selected="selected"<?php }?>><?php echo $lstCampus[$i]["Campus"]; ?></option>
												<?php } ?>
									</select>


								</div>
							</div>
						</div>

						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Directorio de todos los asesores acad&eacute;micos</h3>
								</div>
								<div class="box-body">
								<div class="table-responsive">
									<table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
										<thead>
											<tr>
												<th></th>
												<th>Nombre</th>
												<th>Usuario</th>
												<th>Campus</th>
												<th>Teléfono</th>
												<th>Correo</th>
												<th>Sexo</th>
												<th>Estatus</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($docentes);$i++) { ?>
											<tr>
												<td><button type="button" class="btn btn-block btn-info btn-xs view_detalle" href="javascript:void(0);" name="view" value="view" id="<?php echo $docentes[$i]["IdUsua"]; ?>">Consulta</button></td>
												<td><?php echo $docentes[$i]["Usuario"]; ?></td>
												<td><?php echo $docentes[$i]["Nombre"].' '.$docentes[$i]["APaterno"].' '.$docentes[$i]["AMaterno"]; ?></td>
												<td><?php echo $docentes[$i]["Campus"]; ?></td>
												<td><?php echo $docentes[$i]["Telefono"]; ?></td>
												<td><?php echo $docentes[$i]["Correo"]; ?></td>
												<td><?php echo $docentes[$i]["Sexo"]; ?></td>
												<td><?php echo $docentes[$i]["Estatus"]; ?></td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
								</div>
							</div>
						</div>

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
</script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
