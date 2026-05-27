<?php $section = "Crear Grupo"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando como crear grupo'); }
if(isset($_GET["C"])){ $_POST["txtCampus"] = $_GET["C"]; }
if(isset($_GET["O"])){ $_POST["txtOferta"] = $_GET["O"]; }
//
// $oferta=$t->get_OfertaETodos();
//
// if($_GET['Id']){
// 	$_POST["txtOferta"] = $_GET['Id'];
// }

// $grupo=$t->get_grupoCreado($_POST["txtOferta"],$_POST["txtGrupo"]);

$lstCampus=$t->get_campusPermiso($_SESSION["IdUsua"]);
$lstOferta=$t->get_lstoFERTACampus($_POST["txtCampus"]);

$grupo=$t->get_lstalumnosPro($_POST["txtCampus"],$_POST["txtOferta"],$_POST["txtGrupo"]);
$lstGrupo=$t->get_grupoAbierto($_POST["txtCampus"],$_POST["txtOferta"]);

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<form name="frm" id="frm" action="ctrlCrearGrupo.php" method="POST" enctype="multipart/form-data">
		<input id="TipoGuardar" name="TipoGuardar" value="asigGrupo" type="hidden"/>
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Configuración de alumnos en el grupo
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Módulos</a></li>
					<li class="active">Crear grupo</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Campus:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstCampus);$i++) { ?>
										<option value="<?php echo $lstCampus[$i]["IdCampus"]; ?>"<?php if($_POST['txtCampus']==$lstCampus[$i]["IdCampus"]){?>selected="selected"<?php } ?>><?php echo $lstCampus[$i]["Campus"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Plan de estudios:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-book"></i>
									</div>
									<select class="form-control select2" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstOferta);$i++) { ?>
										<option value="<?php echo $lstOferta[$i]["IdEducativa"]; ?>" <?php if($_POST['txtOferta']==$lstOferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php  echo $lstOferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Clave grupo:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control select2" name="txtGrupo" id="txtGrupo" onchange="document.frm.submit();">
										<option value=""> - Todos los grupos - </option>
										<?php for ($i=0;$i< sizeof($lstGrupo);$i++) { ?>
										<option value="<?php echo $lstGrupo[$i]["IdGrupo"]; ?>"<?php if($_POST["txtGrupo"]==$lstGrupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $lstGrupo[$i]["CveGrupo"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<?php if(($grupo[0]) && ($_POST["txtGrupo"])){ ?>
						<div class="col-md-2">
							<div class="form-group">
								<label>Movimiento:</label>
								<div class="input-group">
									<button type="button" class="btn btn-danger view_grupo" href="javascript:void(0);" name="view" value="view" id="0" style="float: right;"><i class="fa fa-unlock"></i> CERRAR GRUPO</button>
								</div>
							</div>
						</div><?php } ?>
						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de los módulos</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Grupo</th>
												<th>Nombre</th>
												<th>Tel&eacute;fono</th>
												<th>Correo</th>
												<th>FecCap</th>
												<th>Cve. Grupo</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($grupo);$i++) { if($grupo[$i]["Tipo"] != 'Cerrado') {?>
											<tr>
												<td style="text-align: center;">

													<button type="button" class="btn btn-primary view_tutor" href="javascript:void(0);" name="view" value="view" id="<?php echo $grupo[$i]["IdUsua"]; ?>" style="float: right;"><i class="fa fa-users"></i></button>
												</td>
												<td><?php echo $grupo[$i]["Nombre"].' '.$grupo[$i]["APaterno"].' '.$grupo[$i]["AMaterno"]; ?></td>
												<td><?php echo $grupo[$i]["Telefono"]; ?></td>
												<td><?php echo $grupo[$i]["Correo"]; ?></td>
												<td><?php echo $grupo[$i]["FecCap"]; ?></td>
												<td><?php echo $grupo[$i]["CveGrupo"]; ?></td>
											</tr>
										<?php } } ?>
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
	<div id="dataModal2" class="modal fade"> <!--MODAL ME GUSTA-->
		<input id="IdAlumno" name="IdAlumno" value="0" type="hidden"/>
			 <div class="modal-dialog">
						<div class="modal-content">
								 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Asignar alumno a un grupo</h4>
								 </div>
								 <div class="modal-body" id="employee_detail2">

								 </div>
						</div>
			 </div>
	</div>
	<div id="dataModal3" class="modal fade"> <!--MODAL ME GUSTA-->
			 <div class="modal-dialog">
						<div class="modal-content">
								 <div class="modal-header" style="background: #008d4c; color: white; font-size: 16px;">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Cerrar grupo</h4>
								 </div>
								 <div class="modal-body" id="employee_detail3">

								 </div>
						</div>
			 </div>
	</div>
	<div id="dataModal5" class="modal fade"> <!--MODAL ME GUSTA-->
			 <div class="modal-dialog">
						<div class="modal-content">
								 <div class="modal-header" style="background: #056fb1; color: white; font-size: 16px;">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Configuración de prospecto</h4>
								 </div>
								 <div class="modal-body" id="employee_detail5">

								 </div>
						</div>
			 </div>
	</div>
	</form>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

$(document).ready(function(){
		 $(document).on('click', '.view_config', function(){
					var employee_id = $(this).attr("id");
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/viewConfiguracion.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail5').html(data);
												 $('#dataModal5').modal('show');
										}
							 });
					}
		 });
});


$(document).ready(function(){
		 $(document).on('click', '.view_tutor', function(){
					var employee_id = $(this).attr("id");
				  document.getElementById("IdAlumno").value = employee_id;
					var IdOferta = document.getElementById("txtOferta").value;
					var IdCampus = document.getElementById("txtCampus").value;
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/addGrupo.php",
										method:"POST",
										data:{employee_id:employee_id, IdOferta:IdOferta, IdCampus:IdCampus},
										success:function(data){
												 $('#employee_detail2').html(data);
												 $('#dataModal2').modal('show');
										}
							 });
					}
		 });
});

$(document).ready(function(){
		 $(document).on('click', '.view_grupo', function(){
					var employee_id = $(this).attr("id");
					var IdOferta = document.getElementById("txtOferta").value;
					var IdCampus = document.getElementById("txtCampus").value;
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/cerrarGrupo.php",
										method:"POST",
										data:{IdOferta:IdOferta,IdCampus:IdCampus},
										success:function(data){
												 $('#employee_detail3').html(data);
												 $('#dataModal3').modal('show');
										}
							 });
					}
		 });
});

  $(function () {
    $('#example1').DataTable()
  })
	$(function () {
    $('.select2').select2()

  })
</script>
</body>
</html>
