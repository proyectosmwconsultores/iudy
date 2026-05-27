<?php $section = "Asignaturas asignadas"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizado a los docentes asignados a una Asignatura'); }

$lstCiclo=$t->get_periodoTodos();
if(isset($_POST["txtCiclo"])){
  $clvGrupo=$t->get_claveGrupoXA($_POST["txtCiclo"]);
}

if(isset($_POST["txtCiclo"])){ $_POST["txtCiclo"] = $_POST["txtCiclo"]; } else { $_POST["txtCiclo"] = ''; }
if(isset($_POST["txtClaveGrp"])){ $_POST["txtClaveGrp"] = $_POST["txtClaveGrp"]; } else { $_POST["txtClaveGrp"] = ''; }

$modulosAsigandos=$t->get_modulosAsigandos($_POST["txtCiclo"],$_POST["txtClaveGrp"]);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Materias asignadas</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Asignatura</a></li>
					<li class="active">Asignaturas de los asesores acad&eacute;micos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adSelAsigMod.php" method="POST" enctype="multipart/form-data">

						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title"><i class="fa fa-fw fa-edit"></i> Lista de las materias asignadas a los asesores acad&eacute;micos</h3>
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
      										<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"<?php if($_POST["txtCiclo"]==$lstCiclo[$i]["IdCiclo"]){ $tipoO = $lstCiclo[$i]["Tipo"]; ?>selected="selected"<?php }?>><?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
      										<?php } ?>
      									</select>
      								</div>
      							</div>
      						</div>
                  <div class="col-md-7">
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
                              <option value="<?php echo $clvGrupo[$i]["IdGrupo"]; ?>"<?php if($_POST['txtClaveGrp']==$clvGrupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $clvGrupo[$i]["Grado"].'° '.$clvGrupo[$i]["CveGrupo"].' - '.$clvGrupo[$i]["_Dias"]; ?></option>
                              <?php
                              } } ?>
      									  </select>
      									</div>
      								</div>
      						</div>
                  <?php if(isset($modulosAsigandos[0])){ ?>
                  <div class="col-md-12">
      							<div class="form-group">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Ajustes</th>
                            <th>Grado</th>
                            <th>Asignatura</th>
                            <th>Fecha</th>
                            <th>Estatus</th>
                            <th>Asesor</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i=0;$i< sizeof($modulosAsigandos);$i++) {  $IdE = $modulosAsigandos[$i]["IdEstatus"]; ?>
                          <tr>
                            <td>
                              <!-- <button type="button" title="Formato de lista de asistencia" class="btn btn-primary" href="javascript:void(0);" onclick="javascript:window.open('repositorio/portafolio/listaAsistencia.php?tokenId=<?php echo $modulosAsigandos[$i]["IdAsignacion"]; ?>');" href="javascript:void(0);" style="float: center;"><i class="fa fa-calendar"></i></button> -->
                              <!-- <button type="button" title="Acta de calificaciones" class="btn btn-info" onclick="javascript:window.open('repositorio/pdf/acta.php?tokenId=<?php echo $modulosAsigandos[$i]["IdAsignacion"]; ?>');" href="javascript:void(0);" style="float: center;"><i class="fa fa-sort-numeric-asc"></i></button> -->
                              <button title="Actulizar datos de la asignación de la materia" onclick="window.open('adUpdModConfig.php?Id=<?php echo $modulosAsigandos[$i]["IdAsignacion"]; ?>','_self')" href="javascript:void(0);" title="Editar asignación" type="button" class="btn btn-default"><i class="fa fa-edit"></i></button>
                              <button type="button" title="Captura de horario de clases" class="btn btn-success view_horario" href="javascript:void(0);" name="view" value="view" id="<?php echo $modulosAsigandos[$i]["IdAsignacion"]; ?>" style="float: center;"><i class="fa fa-clock-o"></i></button>
                              <button title="Eliminar asignación" type="button" class="btn btn-danger view_del" href="javascript:void(0);" name="view" value="view" id="<?php echo $modulosAsigandos[$i]["IdAsignacion"]; ?>" style="float: center;"><i class="fa fa-trash"></i></button>
                              <!-- <button title="Fecha de entrega" type="button" class="btn btn-success view_fecha" href="javascript:void(0);" name="view" value="view" id="<?php echo $modulosAsigandos[$i]["IdAsignacion"]; ?>" style="float: center;"><i class="fa fa-bell"></i></button> -->

                              <button type="button" class="btn btn-warning view_evaluacion" href="javascript:void(0);" name="view" value="view" id="<?php echo $modulosAsigandos[$i]["IdAsignacion"]; ?>" style="float: center;"><i class="fa fa-file-o"></i></button>
                              <button type="button" title="Copiar planeación académica" class="btn btn-primary view_copiar" href="javascript:void(0);" name="view" value="view" id="<?php echo $modulosAsigandos[$i]["IdAsignacion"].'_'.$modulosAsigandos[$i]["IdModulo"].'_'.$modulosAsigandos[$i]["IdCiclo"]; ?>" style="float: center;"><i class="fa fa-copy"></i></button>
                            </td>
                            <td><?php echo $modulosAsigandos[$i]["Grado"].$modulosAsigandos[$i]["Abreviatura"].' '.$modulosAsigandos[$i]["Tipo"]; ?></td>
                            <td><?php echo $modulosAsigandos[$i]["CodeModulo"].'-'.$modulosAsigandos[$i]["NombreMod"]; ?></td>
                            <td><?php echo $modulosAsigandos[$i]["FecIni"].' / '.$modulosAsigandos[$i]["FecFin"]; ?></td>
                            <td><?php echo $modulosAsigandos[$i]["Estatus"]; ?></td>
                            <td><?php echo $modulosAsigandos[$i]["Nombre"].' '.$modulosAsigandos[$i]["APaterno"].' '.$modulosAsigandos[$i]["AMaterno"]; ?></td>
                          </tr>
                          <?php } ?>
                        </tfoot>
                      </table>
                      <?php if(($_POST["txtCiclo"]) && ($_POST["txtClaveGrp"])){ ?>
                      <div class="btn-group">
                        <a onclick="javascript:window.open('repositorio/pdf/registroEsc1.php?tokenId=<?php echo time(); ?>&Id=5e0e0a4955c7f&idCiclo=<?php echo time().$_POST["txtCiclo"]; ?>&idGrupo=<?php echo time().$_POST["txtClaveGrp"]; ?>&Grado=<?php echo $modulosAsigandos[0]["Grado"];?>','_blank');" href="javascript:void(0);" title="Descargar mapa de registro">
                          <button type="button" class="btn btn-info"> <i class="fa fa-fw fa-download"></i> Registro SEP Pág1 </button>
                        </a>
                        <a onclick="javascript:window.open('repositorio/pdf/registroEsc2.php?tokenId=<?php echo time(); ?>&Id=5e0e0a4955c7f&idCiclo=<?php echo time().$_POST["txtCiclo"]; ?>&idGrupo=<?php echo time().$_POST["txtClaveGrp"]; ?>&Grado=<?php echo $modulosAsigandos[0]["Grado"];?>','_blank');" href="javascript:void(0);" title="Descargar mapa de registro">
                          <button type="button" class="btn btn-info"> <i class="fa fa-fw fa-download"></i> Registro SEP Pág2 </button>
                        </a>
                        <a onclick="javascript:window.open('repositorio/pdf/registroRev.php?tokenId=<?php echo time(); ?>&Id=5e0e0a4955c7f&idCiclo=<?php echo time().$_POST["txtCiclo"]; ?>&idGrupo=<?php echo time().$_POST["txtClaveGrp"]; ?>&Grado=<?php echo $modulosAsigandos[0]["Grado"];?>','_blank');" href="javascript:void(0);" title="Descargar mapa de registro">
                          <button type="button" class="btn btn-info"> <i class="fa fa-fw fa-download"></i> Registro SEP Reverso </button>
                        </a>
                        <!-- <button style="margin-right: 5px;" type="button" class="btn btn-warning view_rvoe" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST["txtClaveGrp"]; ?>"><i class="fa fa-fw fa-qrcode"></i> Configurar RVOE</button> -->
                        <button style="margin-right: 5px;" type="button" class="btn btn-success view_firma" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST["txtClaveGrp"]; ?>"><i class="fa fa-fw fa-qrcode"></i> Configurar firmantes</button>
                      </div>
                    <?php } ?>
      							</div>
      						</div>
                <?php } ?>
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
									<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
											 <button type="button" class="close" data-dismiss="modal">&times;</button>
											 <h4 class="modal-title"><i class="fa fa-clock-o"></i> Configuraci&oacute;n de horario de la asignatura</h4>
									</div>
									<div class="modal-body" id="employee_detailHor">
									</div>
						 </div>
				</div>
	 </div>
   <div id="dataModalCP" class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title"><i class="fa fa-gears"></i> Copiar planeación existente en la plataforma</h4>
 									</div>
 									<div class="modal-body" id="employee_detailCP">
 									</div>
 						 </div>
 				</div>
 	 </div>
   <div id="dataModalEv" class="modal fade bs-example-modal-lg"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog modal-lg">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title"><i class="fa fa-edit"></i> Configuración de encuesta</h4>
 									</div>
 									<div class="modal-body" id="employee_detailEv">
 									</div>
 						 </div>
 				</div>
 	 </div>

   <div id="dataModalRvoe" class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title"><i class="fa fa-qrcode"></i> Configuraci&oacute;n de Rvoe</h4>
 									</div>
 									<div class="modal-body" id="employee_detailRvoe">
 									</div>
 						 </div>
 				</div>
 	 </div>

   <div id="dataModalFir" class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title"><i class="fa fa-users"></i> Configuraci&oacute;n de firmantes</h4>
 									</div>
 									<div class="modal-body" id="employee_detailFir">
 									</div>
 						 </div>
 				</div>
 	 </div>
	 <div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title"><i class="fa fa-info"></i> Informaci&oacute;n general del grupo</h4>
 									</div>
 									<div class="modal-body" id="employee_detail">
 									</div>
 						 </div>
 				</div>
 	 </div>
	 <div id="dataModal2" class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
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
      $(document).on('click', '.view_fecha', function(){
           var employee_id = $(this).attr("id");
					 //var IdAsignacion = document.getElementById("Id").value;
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/addFecha.php",
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
      $(document).on('click', '.view_copiar', function(){
           var employee_id = $(this).attr("id");
					 //var IdAsignacion = document.getElementById("Id").value;
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/copiar_planeacion.php",
                     method:"POST",
                     data:{employee_id:employee_id},
                     success:function(data){
                          $('#employee_detailCP').html(data);
                          $('#dataModalCP').modal('show');
                     }
                });
           }
      });
 });

 $(document).ready(function(){
      $(document).on('click', '.view_evaluacion', function(){
           var employee_id = $(this).attr("id");

           $.ajax({
                url:"formConsulta/vista_evualuacion.php",
                method:"POST",
                data:{employee_id:employee_id},
                success:function(data){
                     $('#employee_detailEv').html(data);
                     $('#dataModalEv').modal('show');
                }
           });
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
