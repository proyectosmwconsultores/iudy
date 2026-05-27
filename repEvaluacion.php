<?php $section = "Reporte de evaluación"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en le módulo de reporte de evaluación y encuesta'); }
if(isset($_GET["IdC"])){ $_POST["txtCicloEscolar"] = $_GET["IdC"]; }
if(isset($_GET["IdO"])){ $_POST["txtOferta"] = $_GET["IdO"]; }

$lstCiclo=$t->get_periodoTodos();
$campus=$t->get_lstCampusAc();

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<form name="frm" id="frm" action="repEvaluacion.php" method="POST" enctype="multipart/form-data">
		<input id="Mov" name="Mov" value="<?php echo $_GET['Mov'];?>" type="hidden"/>

	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Evaluación docente & encuesta de calidad
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Evaluación & encuesta</a></li>
					<li class="active">Docente</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
						<div class="box-body">
							<div class="col-md-7">
								<div class="form-group">
									<label>Ciclo escolar:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<select class="form-control select2" name="txtCicloEscolar" id="txtCicloEscolar" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
										<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"<?php if($_POST["txtCicloEscolar"]==$lstCiclo[$i]["IdCiclo"]){ $tipoO = $lstCiclo[$i]["Tipo"]; ?>selected="selected"<?php }?>><?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<div class="col-md-5">
								<div class="form-group">
									<label>Tipo:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control select2" name="txtTipo" id="txtTipo" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<!-- <option value="1">Evaluación docente</option> -->
											<option value="2" <?php if($_POST["txtTipo"]==2){ ?>selected="selected"<?php }?>>Encuesta de calidad</option>
											<option value="3" <?php if($_POST["txtTipo"]==3){ ?>selected="selected"<?php }?>>Encuesta de satisfacción académica</option>
											<option value="4" <?php if($_POST["txtTipo"]==4){ ?>selected="selected"<?php }?>>Evaluación docente por campus</option>
										</select>
									</div>
								</div>
							</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Campus:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-gears"></i>
											</div>
											<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
												<option value=""> - Seleccione - </option>
												<?php for ($i=0;$i< sizeof($campus);$i++) { ?>
												<option value="<?php echo $campus[$i]["IdCampus"]; ?>"<?php if($_POST["txtCampus"]==$campus[$i]["IdCampus"]){  ?>selected="selected"<?php }?>><?php echo $campus[$i]["Campus"]; ?></option>
												<?php } ?>
											</select>
											<span class="input-group-btn">
												<?php if($_POST["txtTipo"]==2){ ?>
	                      <button type="button" class="btn btn-info btn-flat" onClick="window.open('formConsulta/impEncuesta.php?idCa=<?php echo time().$_POST["txtCampus"]; ?>&idCi=<?php echo time().$_POST["txtCicloEscolar"]; ?>','_blank')" href="javascript:void(0);"><i class="fa fa-fw fa-gg-circle"></i> Consultar información</button>
												<button onclick="javascript:window.open('formConsulta/expSugerencias.php?idCa=<?php echo time().$_POST["txtCampus"]; ?>&idCi=<?php echo time().$_POST["txtCicloEscolar"]; ?>');"  href="javascript:void(0);" type="button" class="btn btn-success btn-flat" ><i class="fa fa-fw fa-gg-circle"></i> Exportar sugerencias</button>
											<?php } elseif($_POST["txtTipo"]==3){ ?>
												<button type="button" class="btn btn-info btn-flat" onClick="window.open('formConsulta/impSatisfaccion.php?idCa=<?php echo time().$_POST["txtCampus"]; ?>&idCi=<?php echo time().$_POST["txtCicloEscolar"]; ?>','_blank')" href="javascript:void(0);"><i class="fa fa-fw fa-gg-circle"></i> Consultar información</button>
											<?php } elseif($_POST["txtTipo"]==4){ ?>
												<button onclick="javascript:window.open('repositorio/pdf/impEvaluacionDoc.php?idCa=<?php echo time().$_POST["txtCampus"]; ?>&idCi=<?php echo time().$_POST["txtCicloEscolar"]; ?>');"  href="javascript:void(0);" type="button" class="btn btn-info btn-flat" ><i class="fa fa-fw fa-gg-circle"></i> Imprimir PDF</button>
												<button onclick="javascript:window.open('formConsulta/expPromedio.php?idCa=<?php echo time().$_POST["txtCampus"]; ?>&idCi=<?php echo time().$_POST["txtCicloEscolar"]; ?>');"  href="javascript:void(0);" type="button" class="btn btn-success btn-flat" ><i class="fa fa-fw fa-gg-circle"></i> Exportar Excel</button>
											<?php } ?>
                    </span>
										</div>
									</div>
								</div>
								<?php if($_POST["txtTipo"]==4) {
									$lstLista=$t->get_lstListaFinal($_POST["txtCampus"],$_POST["txtCicloEscolar"]);
									?>
								<div class="box-body no-padding">
	              <table class="table table-striped">
	                <tbody><tr>
	                  <th>No.</th>
										<th>Nombre del profesor</th>
	                  <th>Estatus</th>
	                  <th>Cargar</th>
	                </tr>
									<?php for ($i=0;$i< sizeof($lstLista);$i++) { ?>
	                <tr>
	                  <td><?php echo $c = $c + 1; ?></td>
										<td><?php echo $lstLista[$i]["APaterno"].' '.$lstLista[$i]["AMaterno"].' '.$lstLista[$i]["Nombre"]; ?></td>
	                  <td><?php echo $lstLista[$i]["Estatus"]; ?></td>
	                  <td>
											<!-- <button id="<?php echo $lstLista[$i]["IdUsua"]; ?>" onclick="cargarLista(<?php echo $lstLista[$i]["IdUsua"]; ?>)" type="button" class="btn bg-navy btn-flat margin"><i class="fa fa-fw fa-cloud-upload"></i> Calcular promedio</button> -->
											<!-- <button onClick="window.open('formConsulta/impPreguntas.php?idToks=<?php echo time().$lstLista[$i]["IdUsua"]; ?>&idCa=<?php echo time().$_POST["txtCampus"]; ?>&idCi=<?php echo time().$_POST["txtCicloEscolar"]; ?>','_blank')" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat margin"><i class="fa fa-fw fa-cloud-upload"></i> Promedio preguntas</button> -->
	                    <button href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat margin view_grupo" name="view" value="view" id="<?php echo $lstLista[$i]["IdUsua"]; ?>"><i class="fa fa-fw fa-cloud-upload"></i> Promedio preguntas</button>
	                  </td>

	                </tr>
								<?php } ?>
	              </tbody></table>
	            </div> <?php } ?>
						</div>

          </div>
        </div>
      </div>


			</section>
		</div>
	  <?php include("footer.php"); ?>
	</div>


	</form>
	<div id="dataModalGrp" class="modal fade"> <!--MODAL ME GUSTA-->
			 <div class="modal-dialog">
						<div class="modal-content">
								 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">RESULTADO DE LA CALIFICACIÓN OBTENIDA POR PREGUNTA</h4>
								 </div>
								 <div class="modal-body" id="employee_detailGrp">
								 </div>
						</div>
			 </div>
	</div>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->

<script>
$(document).ready(function(){
     $(document).on('click', '.view_grupo', function(){
          var employee_id = $(this).attr("id");
					var IdCampus = document.getElementById("txtCampus").value;
					var IdCiclo = document.getElementById("txtCicloEscolar").value;
          if(employee_id != '')
          {
               $.ajax({
                    url:"formConsulta/verPreguntas.php",
                    method:"POST",
                    data:{employee_id:employee_id, IdCampus:IdCampus, IdCiclo:IdCiclo },
                    success:function(data){
                         $('#employee_detailGrp').html(data);
                         $('#dataModalGrp').modal('show');
                    }
               });
          }
     });
});

function cargarLista(IdUsua){
	var IdCiclo = document.getElementById("txtCicloEscolar").value;
	document.getElementById(IdUsua).style.display = "none";
	$.ajax({
			 url:"formConsulta/impEvaluacionDocenteY.php",
			 method:"POST",
			 data:{IdCiclo:IdCiclo, IdUsua:IdUsua},
			 success:function(data){
				 if(data == 1){
					 	swal("Cargado correctamente", "La evaluación docente ha sido cargado correctamente.", "success");
				 } else {
					 swal("Ya se actualizo", "La evaluación docente ha sido cargado correctamente.", "info");
				 }
			 }
	});

}

  $(function () {
    $('.select2').select2()


  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
