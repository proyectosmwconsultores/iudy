<?php $valor = 3; $section = "Módulo de certificado"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de certificado.'); }

if(isset($_GET["C"])){ $_POST["txtCampus"] = substr($_GET["C"], 10, 10); }
if(isset($_GET["G"])){ $_POST["txtClaveGrp"] = substr($_GET["G"], 10, 10); }

if(isset($_POST["txtCampus"])){ $_POST["txtCampus"] = $_POST["txtCampus"]; } else { $_POST["txtCampus"]= ''; }
if(isset($_POST["txtClaveGrp"])){ $_POST["txtClaveGrp"] = $_POST["txtClaveGrp"]; } else { $_POST["txtClaveGrp"]= ''; }

$campusId=$t->get_campusPermiso($_SESSION['IdUsua']);
// $campusId=$t->get_campusId();
$clvGrupo=$t->get_clvGrupSTodos($_POST["txtCampus"]);

$alumnos=$t->get_alumnosT($_POST["txtClaveGrp"]);

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
					Lista de alumnos por grupo
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumnos</a></li>
					<li class="active">Muestra todos los alumnos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adCertificado.php" method="POST" enctype="multipart/form-data">
						<div class="col-md-6">
							<div class="form-group">
								<label>Campus / Escuela:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-fw fa-key"></i>
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

						<div class="col-md-6">
							<div class="form-group">
								<label>Grupo:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-fw fa-key"></i>
									</div>
									<select class="form-control select2" name="txtClaveGrp" id="txtClaveGrp" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($clvGrupo);$i++) { $tx = 0;
												$busActivoD=$t->get_busActOfer($clvGrupo[$i]["IdGrupo"],$_SESSION["IdUsua"],$clvGrupo[$i]["IdCampus"]);
												 $tx = $busActivoD[0][0];
												if($tx){
												?>
												<option value="<?php echo $clvGrupo[$i]["IdGrupo"]; ?>"<?php if($_POST['txtClaveGrp']==$clvGrupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $clvGrupo[$i]["Grado"].'° '.$clvGrupo[$i]["CveGrupo"]; ?></option>
												<?php
												} } ?>
									</select>

								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de todos los alumnos</h3>
								</div>
								<div class="box-body">
								<div class="table-responsive">
									<table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
										<thead>
											<tr>
												<th style="width: 70px;">AJUSTES</th>
												<th>NO. CONTROL</th>
												<th>NOMBRE DEL ALUMNO</th>
												<th>CORREO</th>
												<th>PLAN DE ESTUDIOS</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($alumnos);$i++) {
												$_mod20=$t->get_mod_lista_id($_SESSION['IdUsua'],20);
												$_mod21=$t->get_mod_lista_id($_SESSION['IdUsua'],21);
												$_mod22=$t->get_mod_lista_id($_SESSION['IdUsua'],22);
												 ?>
											<tr>
												<td style="text-align: center;">
													<?php if(isset($_mod20[0])){ ?>
													<!-- <a onclick="javascript:window.open('repositorio/pdf/docKardex.php?tokenId=<?php echo time().$alumnos[$i]["Matricula"]; ?>');" href="javascript:void(0);" title="Descargar mapa de registro"><button title="Imprimir kardex" type="button" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-archive"></i></button></a> -->
													<?php } ?>
													<?php if(isset($_mod21[0])){
													 	if($alumnos[$i]["IdGrado"] == 1){ ?>
														<!-- <a onclick="javascript:window.open('repositorio/pdf/cerDoctorado.php?tokenId=<?php echo time().$alumnos[$i]["Matricula"]; ?>');" href="javascript:void(0);" title="Descargar mapa de registro"><button title="Imprimir certificado" type="button" class="btn btn-success btn-xs"><i class="fa fa-fw fa-shield"></i></button></a> -->
													<?php } elseif($alumnos[$i]["IdGrado"] == 2){ ?>
														<!-- <a onclick="javascript:window.open('repositorio/pdf/cerMaestria.php?tokenId=<?php echo time().$alumnos[$i]["Matricula"]; ?>');" href="javascript:void(0);" title="Descargar mapa de registro"><button title="Imprimir certificado" type="button" class="btn btn-success btn-xs"><i class="fa fa-fw fa-shield"></i></button></a> -->
													<?php } elseif($alumnos[$i]["IdGrado"] == 3){
														if($alumnos[$i]["IdOferta"] == 9){ ?>
																<!-- <a onclick="javascript:window.open('repositorio/pdf/cerLicenciaturaCarta.php?tokenId=<?php echo time().$alumnos[$i]["Matricula"]; ?>');" href="javascript:void(0);" title="Descargar mapa de registro"><button title="Imprimir certificado" type="button" class="btn btn-success btn-xs"><i class="fa fa-fw fa-shield"></i></button></a> -->
														<?php } else { ?>
														<!-- <a onclick="javascript:window.open('repositorio/pdf/cerLicenciatura.php?tokenId=<?php echo time().$alumnos[$i]["Matricula"]; ?>');" href="javascript:void(0);" title="Descargar mapa de registro"><button title="Imprimir certificado" type="button" class="btn btn-success btn-xs"><i class="fa fa-fw fa-shield"></i></button></a> -->
													<?php } } } ?>
													<!-- <a onClick="window.open('adCalificacion.php?tokenId=<?php echo time().$alumnos[$i]["IdUsua"]; ?>&Envio=C','_self')" href="javascript:void(0);" ><button title="Calificaciones finales" type="button" class="btn btn-primary btn-xs"><i class="fa fa-fw fa-qrcode"></i></button></a> -->
													<a onclick="upd_acta(<?php echo $alumnos[$i]["IdUsua"]; ?>)" href="javascript:void(0);" ><button title="Configuración del acta profesional" type="button" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-edit"></i></button></a>
													<a onclick="javascript:window.open('reportes/Imprimir/acta_profesional.php?tokenId=<?php echo time().$alumnos[$i]["IdUsua"]; ?>');" href="javascript:void(0);" title="Imprimir acta profesional"><button  type="button" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-shield"></i></button></a>
													<!-- <a onclick="javascript:window.open('repositorio/pdf/actaProfesional.php?tokenId=<?php echo time().$alumnos[$i]["Matricula"]; ?>');" href="javascript:void(0);" title="Imprimir acta profesional"><button  type="button" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-shield"></i></button></a> -->
													<a onclick="javascript:window.open('repositorio/pdf/constancia_terminacion.php?tokenId=<?php echo time().$alumnos[$i]["Matricula"]; ?>');" href="javascript:void(0);" title="Constancia de terminación de grado"><button type="button" class="btn btn-info btn-sm"><i class="fa fa-fw fa-shield"></i></button></a>
													<a onclick="javascript:window.open('repositorio/pdf/certificado_grado.php?tokenId=<?php echo time().$alumnos[$i]["Matricula"]; ?>');" href="javascript:void(0);" title="Certificado grado"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-shield"></i></button></a>
												</td>
												<td>
													<?php echo $alumnos[$i]["Matricula"]; ?></td>
												<td><?php echo $alumnos[$i]["Nombre"].' '.$alumnos[$i]["APaterno"].' '.$alumnos[$i]["AMaterno"]; ?></td>
												<td><?php echo $alumnos[$i]["Correo"]; ?></td>
												<td><?php echo $alumnos[$i]["NomEducativa"]; ?></td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
								<?php if(($_POST["txtCampus"]) && ($_POST["txtClaveGrp"])){ ?>
									<div class="btn-group">

										<button style="margin-right: 5px;" type="button" class="btn btn-warning view_rvoe" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST["txtClaveGrp"]; ?>"><i class="fa fa-fw fa-qrcode"></i> Configurar RVOE</button>
										<button style="margin-right: 5px;" type="button" class="btn btn-success view_grupo" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST["txtClaveGrp"]; ?>"><i class="fa fa-fw fa-qrcode"></i> Configurar Grupo</button>
									</div>

								<!-- <button type="button" class="btn btn-block btn-danger btn-sm view_rvoe"  href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST["txtClaveGrp"]; ?>"> <i class="fa fa-fw fa-qrcode"></i> Configurar RVOE</button> -->
							<?php } ?>
								</div>
							</div>
						</div>
					</form>
				</div>
			</section>
		</div>

		<div id="dataModalRvoe" class="modal fade"> <!--MODAL ME GUSTA-->
  				<div class="modal-dialog">
  						 <div class="modal-content">
  									<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
  											 <button type="button" class="close" data-dismiss="modal">&times;</button>
  											 <h4 class="modal-title">Configuraci&oacute;n de Rvoe</h4>
  									</div>
  									<div class="modal-body" id="employee_detailRvoe">
  									</div>
  						 </div>
  				</div>
  	 </div>

		 <div id="dataModalGrp" class="modal fade"> <!--MODAL ME GUSTA-->
		 		 <div class="modal-dialog">
		 					<div class="modal-content">
		 							 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
		 										<button type="button" class="close" data-dismiss="modal">&times;</button>
		 										<h4 class="modal-title">Configuración de grupo</h4>
		 							 </div>
		 							 <div class="modal-body" id="employee_detailGrp">
		 							 </div>
		 					</div>
		 		 </div>
		 </div>

		 <div id="dataModalA" class="modal fade bs-example-modal-lg"> <!--MODAL ME GUSTA-->
   				<div class="modal-dialog modal-lg">
   						 <div class="modal-content">
   									<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
   											 <button type="button" class="close" data-dismiss="modal">&times;</button>
   											 <h4 class="modal-title"><i class="fa fa-gears"></i> Configuraci&oacute;n del acta profesional</h4>
   									</div>
   									<div class="modal-body" id="employee_detailA">
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

		<!-- InputMask -->
		<!-- <script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
		<script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
		<script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script> -->
		<!-- date-range-picker -->
		<!-- <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> -->
		<!-- bootstrap datepicker -->
		<!-- <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->
		<!-- bootstrap color picker -->
		<!-- <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script> -->
		<!-- bootstrap time picker-->
		<!-- <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script> -->
		<!-- SlimScroll
		<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<!-- iCheck 1.0.1
		<script src="bower_components/plugins/iCheck/icheck.min.js"></script>
		<!-- FastClick
		<script src="bower_components/fastclick/lib/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>

		<!-- DataTables -->
		<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


	  <?php include("footer.php"); ?>
	</div>

<!-- jQuery 3 -->


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

$(document).ready(function(){
     $(document).on('click', '.view_grupo', function(){
          var employee_id = $(this).attr("id");
          if(employee_id != '')
          {
               $.ajax({
                    url:"formConsulta/updGrupo.php",
                    method:"POST",
                    data:{employee_id:employee_id},
                    success:function(data){
                         $('#employee_detailGrp').html(data);
                         $('#dataModalGrp').modal('show');
                    }
               });
          }
     });
});

 $(document).ready(function(){
      $(document).on('click', '.view_rvoe', function(){
           var employee_id = $(this).attr("id");
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/addRvoe.php",
                     method:"POST",
                     data:{employee_id:employee_id},
                     success:function(data){
                          $('#employee_detailRvoe').html(data);
                          $('#dataModalRvoe').modal('show');
                     }
                });
           }
      });
 });



	function saveFolio(IdUsua){
		var Fol = "txtFolio-"+IdUsua;
		var Folio = document.getElementById(Fol).value;

		if (Folio ==''){
				swal("Error al guardar", "Debe escribir el folio del certificado.", "error");
				document.getElementById(Folio).focus();
				return 0;
		}

		var TipoGuardar = "add_FolioCer";
	  $.ajax({
	       url:"formConsulta/setting.php",
	       method:"POST",
	       data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, Folio:Folio},
	       success:function(data){

	       }
	  })

	}

$(function () {
	$('#example1').DataTable()
})
	$(function () {
		$('.select2').select2()

	})

	function upd_acta(IdUsua){
		$.ajax({
				 url:"formConsulta/acta_profesional.php",
				 method:"POST",
				 data:{IdUsua:IdUsua},
				 success:function(data){
							$('#employee_detailA').html(data);
							$('#dataModalA').modal('show');
				 }
		});
	}
</script>
</body>
</html>
