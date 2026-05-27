<?php $section = "Asignaturas"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando la lista de asigantura.'); }
if(isset($_GET["IdO"])){ $_POST["txtOferta"] = $_GET["IdO"]; }
if(isset($_GET["IdC"])){ $_POST["txtCampus"] = $_GET["IdC"]; }
if(isset($_POST["txtOferta"])){ $_POST["txtOferta"] = $_POST["txtOferta"]; } else { $_POST["txtOferta"] = ''; }
if(isset($_POST["txtCampus"])){ $_POST["txtCampus"] = $_POST["txtCampus"]; } else { $_POST["txtCampus"] = ''; }

//$oferta=$t->get_OfertaCoordinador($_SESSION['IdUsua']);
$oferta=$t->get_OfertaETodos($_SESSION['IdUsua'],$_SESSION['IdUsua'],$_SESSION['IdUsua']);
$campusId=$t->get_campusId();

 if(isset($_POST["txtOferta"])){
	$moduloId=$t->get_ModuloIdCur($_POST["txtOferta"],$_POST["txtCampus"]);
}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Lista de asignaturas
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Plan de estudio</a></li>
					<li class="active">Asignaturas</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adSelModulos.php" method="POST" enctype="multipart/form-data">
						<input id="IdCampus" name="IdCampus" value="<?php echo $_SESSION["IdCampus"]; ?>" type="hidden"/>
						<div class="col-md-5">
							<div class="form-group">
								<label>Campus:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($campusId);$i++) { ?>
										<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"<?php if($_POST["txtCampus"]==$campusId[$i]["IdCampus"]){ ?>selected="selected"<?php }?>><?php echo $campusId[$i]["Campus"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-md-7">
							<div class="form-group">
								<label>Plan de estudio:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control select2" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
										<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$oferta[$i]["IdEducativa"]){ ?>selected="selected"<?php }?>><?php echo $oferta[$i]["Clave"].' - '.$oferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>



						<?php if(isset($_POST["txtOferta"])){ ?>
						<div class="col-md-8">
							<div class="form-group">
								<label>Copiar plan de estudios a campus:</label>
								<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control select2" name="txtNewOferta" id="txtNewOferta">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($campusId);$i++) { if($campusId[$i]["IdCampus"] <> $_POST["txtCampus"]){ ?>
											<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"<?php if(isset($_POST["txtNewOferta"])){ if($_POST["txtNewOferta"]==$campusId[$i]["IdCampus"]){ ?>selected="selected"<?php } } ?>><?php echo $campusId[$i]["Campus"]; ?></option>
                    <?php } } ?>
										</select>
                    <span class="input-group-btn">
                      <button onclick="copiarPlan()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-copy"></i> Copiar oferta educativa</button>
                    </span>
              </div>
							</div>
						</div><?php } ?>
						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de las asignaturas</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>No. </th>
												<th>Clave</th>
												<th>Nombre de la asignatura</th>
												<th>Créditos</th>
												<th>HraDoc</th>
												<th>HraInd</th>
												<th>Ajuste</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($moduloId);$i++) {
												$id= $moduloId[$i]["IdModulo"];
												?>
											<tr>
												<td><?php echo $moduloId[$i]["Code"]; ?></td>
												<td><?php echo $moduloId[$i]["CodeModulo"]; ?></td>
												<td><?php echo $moduloId[$i]["NombreMod"]; ?></td>
												<td><?php echo $moduloId[$i]["Creditos"]; ?></td>
												<td><?php echo $moduloId[$i]["HraDoc"]; ?></td>
												<td><?php echo $moduloId[$i]["HraInd"]; ?></td>
												<td>
													<!-- <a onClick="window.open('adUpdModulo.php?IdModulo=<?php echo time().$id; ?>','_self')" href="javascript:void(0);">
														<button title="Editar datos" type="button" class="btn btn-default"><i class="fa fa-edit"></i></button>
													</a> -->
													<!-- <a onClick="window.open('adSubirFile.php?IdModulo=<?php echo time().$id; ?>','_self')" href="javascript:void(0);">
														<button title="Subir archivos" type="button" class="btn btn-primary"><i class="fa fa-upload"></i></button>
													</a> -->
													<a onClick="mostrarMat(<?php echo $id; ?>)" href="javascript:void(0);">
														<button title="Materias de avance" type="button" class="btn btn-danger"><i class="fa fa-edit"></i></button>
													</a>
													<!-- <a onClick="horaSemana(<?php echo $id; ?>)" href="javascript:void(0);">
														<button title="Horas a la semana" type="button" class="btn btn-success"><i class="fa fa-fw fa-clock-o"></i></button>
													</a> -->
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
                 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><span class="glyphicon glyphicon-check"></span> Actualizar datos de la materias</h4>
                 </div>
  									<div class="modal-body" id="employee_detailModAct">
  									</div>
  						 </div>
  				</div>
  	 </div>
		 <div id="dataHra"  class="modal fade"> <!--MODAL ME GUSTA-->
   				<div class="modal-dialog">
   						 <div class="modal-content">
   									<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
   											 <button type="button" class="close" data-dismiss="modal">&times;</button>
   											 <h4 class="modal-title">Configurar horas de la semana</h4>
   									</div>
   									<div class="modal-body" id="employee_hra">
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
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
function copiarPlan(IdUsua){
	var IdCampus = document.getElementById("txtCampus").value;
	var IdOferta = document.getElementById("txtOferta").value;
	var IdNewCampus = document.getElementById("txtNewOferta").value;

  if (IdNewCampus==""){
	   swal("Error al copiar", "Debe seleccionar el nuevo campus.", "error");
      document.getElementById("txtNewOferta").focus();
      return 0;
  }

	var TipoGuardar = "copiarPlanStudio";


      swal({
    		title: "\u00BFEst\u00E1 seguro que desea copiar esta oferta educativa al otro campus?",
    		type: "warning",
    		showCancelButton: true,
    		confirmButtonColor: '#DD6B55',
    		confirmButtonText: 'Aceptar',
    		cancelButtonText: "Cancelar",
    	},
    	function (isConfirm) {
    		if (isConfirm) {
    			$(".confirm").attr('disabled', 'disabled');
          $.ajax({
               url:"formConsulta/setting.php",
               method:"POST",
               data:{TipoGuardar:TipoGuardar, IdCampus:IdCampus, IdOferta:IdOferta, IdNewCampus:IdNewCampus},
               success:function(data){
                 if(data == 1){
									 swal("Copiado correctamente", "La  oferta educativa se ha copiado correctamente.", "success");
								 } else {
									 swal("Error al copiar", "No se pudo copiar la oferta educativa.", "error");
								 }
               }
          })

    		}

    	});
}



function mostrarMat(IdModulo){
	$.ajax({
			 url:"vistas/admin/actualiza_materia_id.php",
			 method:"POST",
			 data:{IdModulo:IdModulo},
			 success:function(data){
						$('#employee_detailModAct').html(data);
						$('#dataModalModAct').modal('show');
			 }
	});

}

function horaSemana(IdModulo){
	var IdCampus = document.getElementById("txtCampus").value;
	$.ajax({
			 url:"formConsulta/horasMateria.php",
			 method:"POST",
			 data:{IdModulo:IdModulo,IdCampus:IdCampus},
			 success:function(data){
						$('#employee_hra').html(data);
						$('#dataHra').modal('show');
			 }
	});

}

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

  $(function () {
    $('#example1').DataTable()
  })
	$(function () {
		$('.select2').select2()

	})
</script>
</body>
</html>
<?php unset($_SESSION['IdCurso']);?>
