<?php $section = "Mis cursos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando la lista de cursos.'); }


	$oferta=$t->get_cursosLts();
$moduloId=$t->get_ModuloIdCurT($_POST["txtOferta"]);
?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Lista de cursos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Lista</a></li>
					<li class="active">Mis cursos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="addmiscursos.php" method="POST" enctype="multipart/form-data">
						<input id="IdCampus" name="IdCampus" value="<?php echo $_SESSION["IdCampus"]; ?>" type="hidden"/>
						<div class="col-md-8">
							<div class="form-group">
								<label>Plan de estudio:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
										<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$oferta[$i]["IdEducativa"]){ $scc = $oferta[$i]["IdGrado"]; ?>selected="selected"<?php }?>><?php echo $oferta[$i]["Clave"].' - '.$oferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>


							<div class="col-md-4">
								<div class="form-group">
									<label>Nombre del curso:</label>
									<div class="input-group input-group-sm">
	                  <input class="form-control" type="text" name="txtCurso" id="txtCurso">
	                    <span class="input-group-btn">
	                      <button onclick="saveCurso()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-save"></i> Guardar</button>
	                    </span>
	              </div>
								</div>
							</div>

						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de cursos</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Clave</th>
												<th>Nombre del curso</th>
												<th>Ajuste</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($moduloId);$i++) {
												$id= $moduloId[$i]["IdModulo"];
												?>
											<tr>
												<td><?php echo $moduloId[$i]["CodeModulo"]; ?></td>
												<td><?php echo $moduloId[$i]["NombreMod"]; ?></td>
												<td>

															<button onclick="configCurso(<?php echo $id; ?>)" title="Configurar curso" type="button" class="btn btn-default"><i class="fa fa-qrcode"></i></button>
															<?php if($moduloId[$i]["IdEstatus"] == 12){ ?>
														<a onClick="window.open('adCursoGrupo.php?IdCurso=<?php echo time().$id; ?>','_self')" href="javascript:void(0);">
															<button title="Agregar usuarios" type="button" class="btn btn-default"><i class="fa fa-user-plus"></i></button>
														</a>
													<?php } ?>
														<button title="Configurar curso" type="button" class="btn btn-default view_grupo"  href="javascript:void(0);" name="view" value="view" id="<?php echo $id.'-'.$moduloId[$i]["IdAsignacion"]; ?>"><i class="fa fa-users"></i></button>
														<!-- <?php  if($moduloId[$i]["IdEstatus"] != 12){ ?>
														<a onClick="window.open('planeacionAcademica.php?toks=<?php echo time().$moduloId[$i]["IdPlaneacion"]; ?>','_self')" href="javascript:void(0);">
															<button title="Revisar planeación del curso" type="button" class="btn btn-default"><i class="fa fa-clipboard"></i></button>
														</a><?php } ?> -->


												</td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</form>
				</div>
			</section>
		</div>
	  <?php include("footer.php"); ?>
		<div id="dataModalModAct"  class="modal fade"> <!--MODAL ME GUSTA-->
  				<div class="modal-dialog">
  						 <div class="modal-content">
  									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
  											 <button type="button" class="close" data-dismiss="modal">&times;</button>
  											 <h4 class="modal-title">Configurar curso</h4>
  									</div>
  									<div class="modal-body" id="employee_detailModAct">
  									</div>
  						 </div>
  				</div>
  	 </div>

		 <div id="dataModalModAct2"  class="modal fade"> <!--MODAL ME GUSTA-->
   				<div class="modal-dialog">
   						 <div class="modal-content">
   									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
   											 <button type="button" class="close" data-dismiss="modal">&times;</button>
   											 <h4 class="modal-title">Lista de usuarios que tomarán el curso</h4>
   									</div>
   									<div class="modal-body" id="employee_detailModAct2">
   									</div>
   						 </div>
   				</div>
   	 </div>
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
<script>
function configCurso(IdModulo){
	$.ajax({
			 url:"formConsulta/configCurso.php",
			 method:"POST",
			 data:{IdModulo:IdModulo},
			 success:function(data){
						$('#employee_detailModAct').html(data);
						$('#dataModalModAct').modal('show');
			 }
	});

}

$(document).ready(function(){
		 $(document).on('click', '.view_grupo', function(){
					var employee_id = $(this).attr("id");

					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/viewUsuarios.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detailModAct2').html(data);
												 $('#dataModalModAct2').modal('show');
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
<?php unset($_SESSION['IdCurso']);?>
