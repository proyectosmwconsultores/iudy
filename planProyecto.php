<?php $section = "Plan de proyecto"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de plan de proyecto.'); }
if($_POST["txtEstatus"]){
		$plan=$t->get_planProy($_SESSION["Permisos"],$_SESSION["IdUsua"],$_POST["txtEstatus"],$_SESSION["IdCampus"]);
}

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
					Plan de proyecto
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Inicio</a></li>
					<li class="active">Plan de proyecto</li>
				</ol>
			</section>
			<section class="content">
      <form name="frm" id="frm" action="planProyecto.php" method="POST" enctype="multipart/form-data">
				<input id="IdUsua" name="IdUsua" value="" type="hidden"/>


				<input id="Mov" name="Mov" value="" type="hidden"/>
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="4" type="hidden"/>
				<input id="Nombre" name="Nombre" value="Reporte de facturas solicitadas" type="hidden"/>

	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
	            <div class="col-md-8">
	              <div class="box-primary">
	                <div class="box-body">
	                  <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
	                    <i class="fa fa-rotate-left"></i> Regresar
	                  </a>
										<?php if($_SESSION["Permisos"] == 9){ ?>
                    <a class="btn btn-app" onclick="window.open('adAddPlan.php','_self')" href="javascript:void(0);"> <span class="badge bg-purple">Nuevo</span>
	                    <i class="fa fa-clipboard"></i> Plan de proyecto
	                  </a><?php } ?>
                  </div>
	              </div>
	            </div>

							<div class="col-md-4">
	              <div class="box-primary">
	                <div class="box-body">
	                <div class="form-group">
	                  <label>Estatus del plan de proyecto:</label>
	                  <div class="input-group">
	                    <div class="input-group-addon"><i class="fa fa-users"></i></div>
											<select class="form-control" name="txtEstatus" id="txtEstatus" onchange="document.frm.submit();">
		      							<option value=""> - Seleccione - </option>
												<?php if($_SESSION["Permisos"] == 7){ ?>
			                    <option value="3" <?php if($_POST["txtEstatus"] == 3){?>selected="selected"<?php }?> > Para revisión</option>
												<?php } ?>
												<option value="31" <?php if($_POST["txtEstatus"] == 31){?>selected="selected"<?php }?> > En captura </option>
		                    <option value="4" <?php if($_POST["txtEstatus"] == 4){?>selected="selected"<?php }?> > Aprobado </option>
	      						  </select>
	                  </div>
	                </div>
	                </div>
	              </div>
	            </div>

	              <div class="col-md-12">
	                <div class="box">
										<div class="box-body">
										<div class="table-responsive">
											<table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
												<thead>
													<tr>
														<th>Ajuste</th>
														<th>Licenciatura</th>
														<th>Generaci&oacute;n</th>
														<th>Ciclo</th>
														<th>Modalidad</th>
														<th>Dia</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($i=0;$i< sizeof($plan);$i++) { $sen = 0;
														if($plan[$i]["IdEstatus"] == 3){
															$sen = 1;
														}
														$planTemas=$t->get_planTemas($plan[$i]["IdPlan"]);
														$m = $plan[$i]["Modalidad"]; $d = $plan[$i]["Dia"];
														if($m == "M"){ $mx = "Mixta"; } elseif($m == "E"){ $mx = "Escolarizada"; } elseif($m =="N"){ $mx = "No escolarizada"; }
														if($d == 1){ $dx = "Lunes - Jueves"; }
														elseif($d == 2){ $dx = "Lunes - Viernes"; }
														elseif($d == 3){ $dx = "Viernes"; }
														elseif($d == 4){ $dx = "Interweek"; }
														elseif($d == 5){ $dx = "Sábado"; }
														elseif($d == 6){ $dx = "Domingo"; }
														elseif($d == 7){ $dx = "Viernes - Domingo"; }
														elseif($d == 8){ $dx = "Online"; }



														$permi = 1;
														 $IdEs = $plan[$i]["IdEstatus"];
														 if($IdEs == 4){
															 $anio = substr($plan[$i]["FecAprob"], 0,4);
	 														$mes = substr($plan[$i]["FecAprob"], 5,2);
	 														$dia = substr($plan[$i]["FecAprob"], 8,2);
	 														$dias = ($dia + 8);
	 														if($dias > 30){
	 															$diass = ($dias - 30);
	 															$mes = ($mes + 1);
	 														} else { $diass = $dias; }
	 														if($mes > 12){
	 															$mess = 1;
	 															$anio = ($anio + 1);
	 														} else { $mess = $mes; }

	 													   $nvaFec = $anio.'-'.$mess.'-'.$diass;
	 													   $hoy =date("Y-m-d");

															 if($hoy < $nvaFec){
																 $permi = 1;
															 } else {$permi = 0; }
														 } else {
															 $permi = 1;
														 }

														?>
													<tr>
														<td>
															<!-- <a onClick="window.open('adUpdUsuario.php?IdUser=<?php echo time().$Usuarios[$i]["IdUsua"]; ?>','_self')" href="javascript:void(0);">
																<button title="Editar usuario" type="button" class="btn btn-info"><i class="fa fa-edit"></i></button>
															</a> -->
															<?php  if(($_SESSION["Permisos"] == 9) && ($plan[$i]["IdEstatus"] == 31)){ ?>
																<button title="Alta de temas" type="button" class="btn btn-success view_temas" href="javascript:void(0);" name="view" value="view" id="<?php echo $plan[$i]["IdPlan"]; ?>"><i class="fa fa-bookmark"></i></button>
																<button title="Configurar temas" type="button" class="btn btn-success view_configurar" href="javascript:void(0);" name="view" value="view" id="<?php echo $plan[$i]["IdPlan"]; ?>"><i class="fa fa-share-alt"></i></button>
																<?php if($planTemas[0]["Cuatrimestre"] >= 8){ ?>
																<button onclick="enviarPlan(<?php echo $plan[$i]["IdPlan"]; ?>)" title="Enviar para revisión" type="button" class="btn btn-info" href="javascript:void(0);" ><i class="fa fa-send"></i></button>
															<?php } ?>
															<?php } ?>
															<a href= "planProyect.php?IdPlan=<?php echo $plan[$i]["IdPlan"]; ?>"><button title="Descargar plan de proyecto" type="button" class="btn btn-default" href="javascript:void(0);"><i class="fa fa-file-pdf-o"></i></button></a>
															<?php if(($_SESSION["Permisos"] == 7) && ($permi == 1) && ($IdEs != 31)) { //if($_SESSION["Permisos"] == 7){  ?>
																<button title="Aceptar plan de proyecto" type="button" class="btn btn-success view_confGrupo" href="javascript:void(0);" name="view" value="view" id="<?php echo $plan[$i]["IdPlan"]; ?>"><i class="fa fa-check-circle"></i></button>
															<?php } ?>
														</td>

														<td><?php echo $plan[$i]["Nombre"]; ?></td>
														<td><?php echo $plan[$i]["Generacion"]; ?></td>
														<td><?php echo $plan[$i]["Ciclo"]; ?></td>
														<td><?php echo $mx; ?></td>
														<td><?php echo $dx; ?></td>
													</tr>

												<?php }  ?>
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
		<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
					<div class="modal-dialog">
							 <div class="modal-content">
										<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
												 <button type="button" class="close" data-dismiss="modal">&times;</button>
												 <h4 class="modal-title">Alta de tendencias y temas actuales.</h4>
										</div>
										<div class="modal-body" id="employee_detail">

										</div>
							 </div>
					</div>
		 </div>

		 <div id="dataModal2" class="modal fade"> <!--MODAL ME GUSTA-->
 					<div class="modal-dialog">
 							 <div class="modal-content">
 										<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 												 <button type="button" class="close" data-dismiss="modal">&times;</button>
 												 <h4 class="modal-title">Configurar tendencias y temas actuales.</h4>
 										</div>
 										<div class="modal-body" id="employee_detail2">

 										</div>
 							 </div>
 					</div>
 		 </div>
		 <div id="dataModal3" class="modal fade"> <!--MODAL ME GUSTA-->
 					<div class="modal-dialog">
 							 <div class="modal-content">
 										<div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
 												 <button type="button" class="close" data-dismiss="modal">&times;</button>
 												 <h4 class="modal-title">Validar y configurar plan de proyecto.</h4>
 										</div>
 										<div class="modal-body" id="employee_detail3">

 										</div>
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
$(document).ready(function(){
		 $(document).on('click', '.view_temas', function(){
					var employee_id = $(this).attr("id");


					if(employee_id != '')
					{
						$.ajax({
								 url:"formConsulta/addTemas.php",
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

$(document).ready(function(){
		 $(document).on('click', '.view_configurar', function(){
					var employee_id = $(this).attr("id");


					if(employee_id != '')
					{
						$.ajax({
								 url:"formConsulta/addPlanAsig.php",
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

$(document).ready(function(){
		 $(document).on('click', '.view_confGrupo', function(){
					var employee_id = $(this).attr("id");


					if(employee_id != '')
					{
						$.ajax({
								 url:"formConsulta/addPlanGrupo.php",
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



</script>
<!-- jQuery 3 -->


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
<?php //unset($_SESSION['Alerta']);  ?>
