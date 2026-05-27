<?php $valor = 3; $section = "Encuestas globales"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de encuentas general.'); }

$campusId=$t->get_campusPermiso($_SESSION['IdUsua']);
$ciclo=$t->get_ciclo_activo();
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<script src="assets/grafica/highcharts.js"></script>
<script src="assets/grafica/data.js"></script>
<script src="assets/grafica/exporting.js"></script>
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-bell"></i> Resultados de encuestas por Periodo Escolar
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Resultados</a></li>
					<li class="active">Encuestas</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="rep_encuesta.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-6">
								<div class="box-primary">
									<div class="form-group">
										<label>Campus:</label>
										<div class="input-group">
											<div class="input-group-addon">
											<i class="fa fa-bank"></i>
											</div>
											<select class="form-control select2" name="txtCampus" id="txtCampus">
												<option value=""> - Seleccione - </option>
												<?php for ($i=0;$i< sizeof($campusId);$i++) { ?>
												<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"><?php echo $campusId[$i]["Campus"]; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Periodo escolar:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtCiclo" id="txtCiclo">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($ciclo);$i++) { ?>
											<option value="<?php echo $ciclo[$i]["IdCiclo"]; ?>"><?php echo $ciclo[$i]["Ciclo"]; ?></option>
											<?php } ?>
										</select>
										<span class="input-group-btn">
											<button onclick="encuesta_gral()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Consultar</button>
										</span>
									</div>
								</div>
							</div>


							<div class="col-xs-12">
								<div class="col-xs-12" style="position: absolute; z-index:0; text-align: center; display: none;" id="btn_img">
									<img src="assets/images/procesando.gif">
								</div>
								<div id="panel_lst_usrzx"></div>
							</div>

						</form>
					</div>
				</div>
					</div>
			</section>
		</div>

		<div id="dataProm" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
										<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
												 <button type="button" class="close" data-dismiss="modal">&times;</button>
												 <h4 class="modal-title"><i class="fa fa-cog"></i> Configurar carga de promedio</h4>
										</div>
									 <div class="modal-body" id="employee_prom">
									 </div>
							</div>
				 </div>
		</div>

		<div id="dataFondo" class="modal fade bs-example-modal-lg"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog modal-lg">
							<div class="modal-content">
										<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
												 <button type="button" class="close" data-dismiss="modal">&times;</button>
												 <h4 class="modal-title"><i class="fa fa-cog"></i> Pase de lista de asistencia</h4>
										</div>
									 <div class="modal-body" id="employee_fondo">
									 </div>
							</div>
				 </div>
		</div>

		<div id="dataGra" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-line-chart"></i> Gráfica de asistencia</h4>
									 </div>
									 <div class="modal-body" id="employee_Gra">
									 </div>
							</div>
				 </div>
		</div>

		<div id="dataxGrax" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-line-chart"></i> Gráfica de asistencia del Periodo Escolar</h4>
									 </div>
									 <div class="modal-body" id="employee_xGrapx">
									 </div>
							</div>
				 </div>
		</div>

		<div id="dataModal_4" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar encuenta</h4>
									 </div>
									 <div class="modal-body" id="employee_detail_4">

									 </div>
							</div>
				 </div>
		</div>

		<div id="dataEnc" class="modal fade"> <!--MODAL ME GUSTA-->
		     <div class="modal-dialog">
		          <div class="modal-content">
		               <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
		                    <button type="button" class="close" data-dismiss="modal">&times;</button>
		                    <h4 class="modal-title"><i class="fa fa-fw fa-line-chart"></i> Resultado de la encuesta docente</h4>
		               </div>
		               <div class="modal-body" id="employee_Enc">
		               </div>
		          </div>
		     </div>
		</div>

		<div id="dataxEnc" class="modal fade"> <!--MODAL ME GUSTA-->
		     <div class="modal-dialog">
		          <div class="modal-content">
		               <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
		                    <button type="button" class="close" data-dismiss="modal">&times;</button>
		                    <h4 class="modal-title"><i class="fa fa-fw fa-line-chart"></i> Resultado de la encuesta</h4>
		               </div>
		               <div class="modal-body" id="employee_xEnc">
		               </div>
		          </div>
		     </div>
		</div>



		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2 -->
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>

		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
	  <?php include("footer.php"); ?>
	</div>

<!-- jQuery 3 -->


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

	$(function () {
		$('.select2').select2()

	})

	function encuesta_gral(){
		var IdCampus = document.getElementById("txtCampus").value;
		var IdCiclo = document.getElementById("txtCiclo").value;

		if(IdCampus == ''){
			swal("Error al buscar", "No seleccionado el Campus.", "error");
			return 0;
		}
		if(IdCiclo == ''){
			swal("Error al buscar", "No seleccionado el Periodo Escolar.", "error");
			return 0;
		}
		document.getElementById("panel_lst_usrzx").style.display = 'none';

		document.getElementById("panel_lst_usrzx").style.display = 'block';
		var Capa = "#panel_lst_usrzx";
		$(Capa).load("dashboard/resultado_encuesta_gral.php",{IdCampus:IdCampus, IdCiclo:IdCiclo }, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});

	}




	$(document).ready(function(){
			 $(document).on('click', '.view_grafica_id', function(){
						var IdAsignacion = $(this).attr("id");

						$.ajax({
								 url:"formConsulta/grafica_asistencia_grupo.php",
								 method:"POST",
								 data:{IdAsignacion:IdAsignacion},
								 success:function(data){
											$('#employee_Gra').html(data);
											$('#dataGra').modal('show');
								 }
						});
			 });
	});

	$(document).ready(function(){
			 $(document).on('click', '.view_gra', function(){
						var IdCiclo = $(this).attr("id");

						$.ajax({
								 url:"formConsulta/grafica_asistencia_ciclo.php",
								 method:"POST",
								 data:{IdCiclo:IdCiclo},
								 success:function(data){
											$('#employee_xGrapx').html(data);
											$('#dataxGrax').modal('show');
								 }
						});
			 });
	});


	function set_encuesta_cong(){
		var IdCampus = 0;
		var IdCiclo = 0;
		var IdGrupo = 0;
		$.ajax({
				 url:"formConsulta/configurar_encuesta.php",
				 method:"POST",
				 data:{IdCampus:IdCampus, IdCiclo:IdCiclo, IdGrupo:IdGrupo},
				 success:function(data){
							$('#employee_detail_4').html(data);
							$('#dataModal_4').modal('show');
				 }
		});
	}
</script>
<script>

	$(document).ready(function(){
			 $(document).on('click', '.view_enc_docx', function(){
						var IdAsignacion = $(this).attr("id");
            var vriabx = "_"+IdAsignacion;
            var IdDocentex = document.getElementById(vriabx).value;
						var IdDocente = "9872342342"+IdDocentex;
            $.ajax({
  							 url:"formConsulta/resultado_encuesta_docente.php",
  							 method:"POST",
  							 data:{IdAsignacion:IdAsignacion, IdDocente:IdDocente},
  							 success:function(data){
  										$('#employee_Enc').html(data);
  										$('#dataEnc').modal('show');
  							 }
  					});
			 });
	});

	$(document).ready(function(){
			 $(document).on('click', '.view_enc_all', function(){
						var IdToks = $(this).attr("id");
            $.ajax({
  							 url:"formConsulta/resultado_encuesta_egreso.php",
  							 method:"POST",
  							 data:{IdToks:IdToks},
  							 success:function(data){
  										$('#employee_xEnc').html(data);
  										$('#dataxEnc').modal('show');
  							 }
  					});
			 });
	});
</script>
</body>
</html>
