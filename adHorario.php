<?php $section = "Módulo de horario"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de generar horario.'); }
if(isset($_GET["idC"])){ $_POST["txtCiclo"] = $_GET["idC"]; }
if(isset($_GET["idG"])){ $_POST["txtClaveGrp"] = $_GET["idG"]; }


$lstCiclo=$t->get_CicloEscolar();

if(isset($_POST["txtCiclo"])){
  $clvGrupo=$t->get_claveGrupoXA($_POST["txtCiclo"]);
}
if(isset($_POST["txtClaveGrp"])){
  $cveGrado=$t->get_gradoHo($_POST["txtClaveGrp"]);
  $modulosAsigandos=$t->get_gradoHorario($_POST["txtClaveGrp"],$_POST["txtGrado"]);
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
					Materias asignadas
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Asignatura</a></li>
					<li class="active">Asignaturas de los asesores acad&eacute;micos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adHorario.php" method="POST" enctype="multipart/form-data">

						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de las materias asignadas a los asesores acad&eacute;micos</h3>
								</div>
								<div class="box-body">

                  <div class="col-md-5">
      							<div class="form-group">
      								<label>Periodo del ciclo escolar:</label>
      								<div class="input-group">
      									<div class="input-group-addon">
      										<i class="fa fa-gears"></i>
      									</div>
      									<select class="form-control select2" name="txtCiclo" id="txtCiclo" onchange="document.frm.submit();">
      										<option value=""> - Seleccione - </option>
      										<?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
      										<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"<?php if($_POST["txtCiclo"]==$lstCiclo[$i]["IdCiclo"]){  ?>selected="selected"<?php }?>><?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
      										<?php } ?>
      									</select>
      								</div>
      							</div>
      						</div>
                  <div class="col-md-4">
      								<div class="form-group">
      									<label>Clave del grupo:</label>
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
                              <option value="<?php echo $clvGrupo[$i]["IdGrupo"]; ?>"<?php if($_POST['txtClaveGrp']==$clvGrupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $clvGrupo[$i]["CveGrupo"]; ?></option>
                              <?php
                              } } ?>
      									  </select>
      									</div>
      								</div>
      						</div>
                  <div class="col-md-3">
      								<div class="form-group">
      									<label>Grado:</label>
      									<div class="input-group">
      									  <div class="input-group-addon">
      										<i class="fa fa-fw fa-key"></i>
      									  </div>
                          <select class="form-control select2" name="txtGrado" id="txtGrado" onchange="document.frm.submit();">
        										<option value=""> - Seleccione - </option>
        										<?php for ($i=0;$i< sizeof($cveGrado);$i++) { ?>
        										<option value="<?php echo $cveGrado[$i]["Grado"]; ?>"<?php if($_POST["txtGrado"]==$cveGrado[$i]["Grado"]){ ?>selected="selected"<?php }?>>Grado <?php echo $cveGrado[$i]["Grado"]; ?></option>
        										<?php } ?>
        									</select>

      									</div>
      								</div>
      						</div>
                  <div class="col-md-12">
      								<div class="form-group">
                        <div class="btn-group">
                          <button style="margin-right: 5px;" type="button" class="btn btn-danger view_loadMat" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST["txtClaveGrp"]; ?>-<?php echo $_POST["txtCiclo"]; ?>"><i class="fa fa-fw fa-qrcode"></i> Cargar materias</button>
                          <button style="margin-right: 5px;" type="button" class="btn btn-warning view_rvoe" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST["txtClaveGrp"]; ?>"><i class="fa fa-fw fa-qrcode"></i> Días de clases</button>
                          <button style="margin-right: 5px;" type="button" class="btn btn-success view_rvoe" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST["txtClaveGrp"]; ?>"><i class="fa fa-fw fa-qrcode"></i> Docentes disponibles</button>
                          <button style="margin-right: 5px;" type="button" class="btn btn-info view_firma" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST["txtClaveGrp"]; ?>"><i class="fa fa-fw fa-qrcode"></i> Generar horario</button>
                        </div>
      								</div>
      						</div>


                  <div class="col-md-12">
      							<div class="form-group">
                      <table class="table table-striped">
                        <tbody>
                          <tr>
                            <th>Informaci&oacute;n</th>
                            <th>No. Asig.</th>
                            <th>IdAsignatura</th>
                            <th>Asignatura</th>
                          </tr>
                          <?php for ($i=0;$i< sizeof($modulosAsigandos);$i++) {  $IdE = $modulosAsigandos[$i]["IdEstatus"]; ?>
                          <tr>
                            <td>
                              <button type="button" class="btn btn-primary view_horario" href="javascript:void(0);" name="view" value="view" id="<?php echo $modulosAsigandos[$i]["IdAsignacion"]; ?>" style="float: center;"><i class="fa fa-clock-o"></i></button>
                              <button type="button" class="btn btn-primary view_data" href="javascript:void(0);" name="view" value="view" id="<?php echo $modulosAsigandos[$i]["IdAsignacion"]; ?>" style="float: center;"><i class="fa fa-info-circle"></i></button>
                              <a onclick="window.open('adUpdModConfig.php?Id=<?php echo $modulosAsigandos[$i]["IdAsignacion"]; ?>','_self')" href="javascript:void(0);">
                                <button title="Editar asignación" type="button" class="btn btn-default"><i class="fa fa-edit"></i></button>
                              </a>
                              <?php if($_SESSION["Permisos"] == 1){ ?>
                              <button title="Eliminar asignación" type="button" class="btn btn-default view_del" href="javascript:void(0);" name="view" value="view" id="<?php echo $modulosAsigandos[$i]["IdAsignacion"]; ?>" style="float: center;"><i class="fa fa-trash"></i></button>
                              <?php } ?>
                            </td>
                            <td><?php echo $modulosAsigandos[$i]["Grado"].$modulosAsigandos[$i]["Abreviatura"].' '.$modulosAsigandos[$i]["Tipo"]; ?></td>
                            <td><?php echo $modulosAsigandos[$i]["CodeModulo"]; ?></td>
                            <td><?php echo $modulosAsigandos[$i]["NombreMod"]; ?></td>
                          </tr>

                          <?php } ?>
                        </tbody>

                      </table>
                      <?php if(($_POST["txtCiclo"]) && ($_POST["txtClaveGrp"]) && ($_SESSION["Permisos"] == 1)){ ?>
                      <div class="btn-group">
                        <a onclick="javascript:window.open('repositorio/pdf/registroEsc.php?tokenId=<?php echo time().$alumnos[$i]["Matricula"]; ?>&Id=5e0e0a4955c7f&idCiclo=<?php echo time().$_POST["txtCiclo"]; ?>&idGrupo=<?php echo time().$_POST["txtClaveGrp"]; ?>&Grado=<?php echo $modulosAsigandos[0]["Grado"];?>');" href="javascript:void(0);" title="Descargar mapa de registro">
                          <button type="button" class="btn btn-info"> <i class="fa fa-fw fa-download"></i> Registro SEP </button>
                        </a>
                        <button style="margin-right: 5px;" type="button" class="btn btn-warning view_rvoe" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST["txtClaveGrp"]; ?>"><i class="fa fa-fw fa-qrcode"></i> Configurar RVOE</button>
                        <button style="margin-right: 5px;" type="button" class="btn btn-success view_firma" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST["txtClaveGrp"]; ?>"><i class="fa fa-fw fa-qrcode"></i> Configurar firmantes</button>
                      </div>
                    <?php } ?>
      							</div>
      						</div>


								</div>
							</div>
						</div>
					</form>
				</div>
			</section>
		</div>
	  <?php include("footer.php"); ?>
	</div>
	<div id="dataModalHor" class="modal fade"> <!--MODAL ME GUSTA-->
				<div class="modal-dialog">
						 <div class="modal-content">
									<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
											 <button type="button" class="close" data-dismiss="modal">&times;</button>
											 <h4 class="modal-title">Configuraci&oacute;n de horario de la asignatura</h4>
									</div>
									<div class="modal-body" id="employee_detailHor">
									</div>
						 </div>
				</div>
	 </div>

   <div id="dataModalMat" class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Cargar materias</h4>
 									</div>
 									<div class="modal-body" id="employee_detailMat">
 									</div>
 						 </div>
 				</div>
 	 </div>

   <div id="dataModalFir" class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Configuraci&oacute;n de firmantes</h4>
 									</div>
 									<div class="modal-body" id="employee_detailFir">
 									</div>
 						 </div>
 				</div>
 	 </div>
	 <div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Informaci&oacute;n general del grupo</h4>
 									</div>
 									<div class="modal-body" id="employee_detail">
 									</div>
 						 </div>
 				</div>
 	 </div>
	 <div id="dataModal2" class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #449F43; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Tutor asigando</h4>
 									</div>
 									<div class="modal-body" id="employee_detail2">
 									</div>
 						 </div>
 				</div>
 	 </div>
</body>

<script>
 $(document).ready(function(){
      $(document).on('click', '.view_horario', function(){
           var employee_id = $(this).attr("id");
					 //var IdAsignacion = document.getElementById("Id").value;
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/addHorario.php",
                     method:"POST",
                     data:{employee_id:employee_id},
                     success:function(data){
                          $('#employee_detailHor').html(data);
                          $('#dataModalHor').modal('show');
                     }
                });
           }
      });
 });

 $(document).ready(function(){
      $(document).on('click', '.view_loadMat', function(){
           var employee_id = $(this).attr("id");
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/loadMaterias.php",
                     method:"POST",
                     data:{employee_id:employee_id},
                     success:function(data){
                          $('#employee_detailMat').html(data);
                          $('#dataModalMat').modal('show');
                     }
                });
           }
      });
 });


 $(document).ready(function(){
      $(document).on('click', '.view_firma', function(){
           var employee_id = $(this).attr("id");
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/addFirmas.php",
                     method:"POST",
                     data:{employee_id:employee_id},
                     success:function(data){
                          $('#employee_detailFir').html(data);
                          $('#dataModalFir').modal('show');
                     }
                });
           }
      });
 });


 $(document).ready(function(){
      $(document).on('click', '.view_data', function(){
           var employee_id = $(this).attr("id");
					 //var IdAsignacion = document.getElementById("Id").value;
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/viewGrupo.php",
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
      $(document).on('click', '.view_del', function(){
           var employee_id = $(this).attr("id");
           var TipoGuardar = "delAsignacion";

           swal({
         		title: "\u00BFEst\u00E1 seguro que desea eliminar esta asignaci\u00F3n de materia a este asesor?",
         		type: "warning",
         		showCancelButton: true,
         		confirmButtonColor: '#DD6B55',
         		confirmButtonText: 'Aceptar',
         		cancelButtonText: "Cancelar",
         	},
         	function (isConfirm) {
         		if (isConfirm) {
         			$(".confirm").attr('disabled', 'disabled');
         			var datos = 'TipoGuardar=' + TipoGuardar + '&employee_id=' + employee_id;
         			$.ajax({
         				type:"POST",
         				url:"insertar.php",
         				data:datos,
         				success:function(data){

         				}
         			})
         			.done(function(data) {

                 if(data==1){
         					swal("Eliminado correctamente", "La asignación ha sido eliminado correctamente.", "success");
                   parent.location.href='adSelAsigMod.php'; //direcciona la pagina madre
         				}

                 if(data==0){
         					swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
         				}
         			})
         			.error(function(data) {
         				swal("Error al agregar 0x138", "No se puede eliminar, comuniquese con el desarrollador.", "error");
         			});
         		}

         	});






          // alert('hola');
          //  if(employee_id != '')
          //  {
          //       $.ajax({
          //            url:"formConsulta/viewGrupo.php",
          //            method:"POST",
          //            data:{employee_id:employee_id},
          //            success:function(data){
          //                 $('#employee_detail').html(data);
          //                 $('#dataModal').modal('show');
          //            }
          //       });
          //  }
      });
 });

 $(document).ready(function(){
			$(document).on('click', '.view_tutor', function(){
					 var employee_id = $(this).attr("id");
					//var IdAsignacion = document.getElementById("Id").value;
					 if(employee_id != '')
					 {
								$.ajax({
										 url:"formConsulta/viewTutor.php",
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
 <script src="bower_components/jquery/dist/jquery.min.js"></script>
 <!-- Bootstrap 3.3.7 -->
 <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
 <!-- Select2 -->
 <script src="bower_components/select2/dist/js/select2.full.min.js"></script>

 <!-- AdminLTE App -->
 <script src="dist/js/adminlte.min.js"></script>
 <!-- AdminLTE for demo purposes -->
 <script src="dist/js/demo.js"></script>


<!-- Page script -->
<script>


    $(function () {
  		$('.select2').select2()

    })
</script>
</body>
</html>
