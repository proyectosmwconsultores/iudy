<?php $valor = 3; $section = "Confirmación especial"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en configurar grupo y asignatura de un alumno'); }
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));
if($_SESSION['Permisos']) {
  $id = substr($_GET["Id"], 52,10);
  $idAlumno = substr($_GET["Id"], 52,10);
$datos = $t->get_usuarioId($idAlumno);
$grupo = $t->get_gruposTotalC($datos[0]["IdOferta"],$datos[0]["IdCampus"]);
$Grado = $datos[0]["Grado"];

if($datos[0]["IdGrupo"]){
    $lstAsig = $t->get_lstAsigados($datos[0]["IdGrupo"]);
}




if(isset($_POST["Mov"]) && $_POST["Mov"]=="AddGropoAl"){
  $espacio->add_alumGrupo();
  exit;
}

if(isset($_POST["Mov"]) && $_POST["Mov"]=="AddModuloCFST"){
  $espacio->add_asigModulo();
  exit;
}

if(isset($_POST["Mov"]) && $_POST["Mov"]=="AddModuloDip"){
  $espacio->add_asigDiplomado();
  exit;
}



if($grupo[0]["IdGrado"] == 3){ $txtMs = "Cuatrimestre"; } else { $txtMs = "Módulo"; }


?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">

  <?php include("menuV.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<?php if($datos[0]["IdGrupo"]){ ?>
		<div style="padding: 20px 30px; background: rgb(243, 58, 18) none repeat scroll 0% 0%; z-index: 999999; font-size: 16px; font-weight: 600;"><i class="fa fa-fw fa-warning"></i> Atenci&oacute;n: este usuario ya esta asignado a un grupo, tenga cuidado con los movimientos que va a realizar.</a></div>
	<?php } ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Configuraci&oacute;n especial de grupo y asignaturas
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Configuraci&oacute;n</li>
      </ol>
    </section>

    <!-- Main content -->
		<section class="content">
        <form role="form" name="frm" id="frm" action="adConfigAlumno.php" method="POST" enctype="multipart/form-data">
          <input id="Mov" name="Mov" value="<?php echo $_GET['Mov'];?>" type="hidden"/>
          <input id="Id" name="Id" value="<?php echo $idAlumno; ?>" type="hidden"/>
          <input id="Grado" name="Grado" value="<?php echo $Grado; ?>" type="hidden"/>
          <input id="IdAsignacion" name="IdAsignacion" value="" type="hidden"/>
          <input id="IdAsig" name="IdAsig" value="" type="hidden"/>
          <input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $datos[0]["Foto"]; ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $datos[0]["Nombre"]; ?></h3>

              <p class="text-muted text-center"><?php echo $datos[0]["APaterno"].' '.$datos[0]["AMaterno"]; ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b><i class="fa fa-fw fa-envelope"></i></b> <a class="pull-right"><?php echo $datos[0]["Correo"]; ?></a>
                </li>
                <li class="list-group-item">
                  <b><i class="fa fa-fw fa-phone"></i></b> <a class="pull-right"><?php echo $datos[0]["Telefono"]; ?></a>
                </li>
              </ul>
              <?php if($_GET["T"] == "x"){ ?>
              <a href="perfil.php?token=9834532145<?php echo $idAlumno; ?>" class="btn btn-primary btn-block"><b>Regresar</b></a>
            <?php } elseif($_GET["T"] == "r") { ?>
              <a href="perfil.php?token=9834532145<?php echo $idAlumno; ?>" class="btn btn-primary btn-block"><b>Regresar</b></a>
            <?php } else { ?>
              <a href="perfil.php?token=9834532145<?php echo $idAlumno; ?>" class="btn btn-primary btn-block"><b>Regresar</b></a>
            <?php }  ?>
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <div class="tab-content">
              <div class="active tab-pane" id="activity">

                  <input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
          				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
          				<input id="Numero" name="Numero" value="4" type="hidden"/>
          				<input id="Nombre" name="Nombre" value="Reporte de facturas solicitadas" type="hidden"/>
              <div class="box-body">

                <div class="form-group">
                  <label><?php if($datos[0]["IdGrupo"]){ $valor = "disabled"; ?>Grupo actual en el que se encuentra activo: <?php } else { echo "Seleccione al grupo que desea asignar:"; $valor = ""; } ?></label>
									<div class="input-group input-group-sm">
										<select class="form-control select2" name="txtGrupo" id="txtGrupo" <?php echo $valor; ?>>
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($grupo);$i++) {
                        if($Grado == 4){
                          $dispo = (20 - $total = $grupo[$i]["Total"]);
                          $disp = " / Cupo disponible: ".$dispo;
                        } else {
                          $disp = "1";
                        }
                         ?>
                         <?php //if($dispo == 0){ echo "disabled"; } ?>
											<option  value="<?php echo $grupo[$i]["IdGrupo"]; ?>"<?php if($grupo[$i]["IdGrupo"] == $datos[0]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $grupo[$i]["CveGrupo"].' /  '.$txtMs.' '.$grupo[$i]["Nivel"].$disp; ?></option>
											<?php } ?>
										</select>
                    <span class="input-group-btn">
                      <?php if($datos[0]["IdGrupo"]){ ?>
                      <button type="button" class="btn btn-info btn-flat"> Grupo activo </button>
                    <?php } else { ?>
                      <button onclick="addNewGrupo()" type="button" class="btn btn-info btn-flat"> Asignarlo a este grupo </button>
                    <?php } ?>
                    </span>
              </div>
              <hr>
              <h4 style="text-align: center;">
                <?php echo $lstAsig[0]["NomEducativa"]; ?>
              </h4>
                </div>

              </div>




              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-body">
              <div class="box-header">
              <h3 class="box-title">Lista de asignaturas del grupo</h3>
            </div>
              <div class="row">
                  <div class="col-md-12">
                    <div class="box">
                      <div class="box-body">
                      <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th>Ajuste</th>
                              <th>IdAsignatura</th>
                              <th>Asignatura</th>
                              <th>Estatus</th>
                              <th>Ciclo</th>
                              <th>Grupo</th>
                              <th>Fecha activo</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php for ($i=0;$i< sizeof($lstAsig);$i++) {
                              $checarReg = $t->get_lstCkrRg($idAlumno,$lstAsig[$i]["IdAsignacion"],$lstAsig[$i]["IdModulo"]);
                              $IdAsig = $lstAsig[$i]["Id"];
                              // $extra1 = $lstAsig[$i]["Recursar"];
                              // $extra2 = $lstAsig[$i]["Recursar"];
                              $reprob = $checarReg[0]["Recursar"];
                              $activo = $checarReg[0]["Activo"];

                               ?>
                            <tr style="font-size: 12px;">

                                <td><?php if($checarReg[0]["IdUsua"]){ ?>

                                  <?php if($reprob){ if($activo){ ?>
                                      <button type="button" class="btn btn-default btn-flat"> R </button>
                                    <?php } else { ?>
                                      <button title="Recursar materia" type="button" class="btn btn-danger btn-flat view_materias" href="javascript:void(0);" name="view" value="view" id="<?php echo $idAlumno.'-'.$lstAsig[$i]["IdAsignacion"].'-'.$lstAsig[$i]["IdModulo"].'-'.$lstAsig[$i]["IdCampus"]; ?>"> R </button>
                                    <?php } ?>
                                  <?php } else { ?>
                                    <!-- <button type="button" class="btn btn-primary btn-flat view_delAsignacion" href="javascript:void(0);" name="view" value="view" id="<?php echo $idAlumno.'-'.$lstAsig[$i]["IdAsignacion"].'-'.$lstAsig[$i]["IdModulo"].'-'.$lstAsig[$i]["IdModuloAlumno"]; ?>" href="javascript:void(0);" title="Eliminar asignación"> <i class="fa fa-fw fa-trash"></i> </button> -->
                                    <!-- <button type="button" class="btn btn-default btn-flat"> A </button> -->
                                  <?php } ?>
                                    <button type="button" class="btn btn-default btn-flat"> <i class="fa fa-fw fa-check-circle-o"></i> </button>
                                  <?php } else { ?>
                                    <?php if($lstAsig[0]["IdGrado"] == 4){
                                      if(($lstAsig[$i]["IdEstatus"] == 8) && ($lstAsig[$i]["Estatus"] == "Activo")){ ?>
                                        <button type="button" class="btn btn-primary btn-flat" onclick="addDiplomado(<?php echo $IdAsig; ?>)"> <i class="fa fa-fw fa-crosshairs"></i> Disponible </button>
                                      <?php } else { ?>
                                        <button type="button" class="btn btn-warning btn-flat"> <i class="fa fa-fw fa-crosshairs"></i> No disponible </button>
                                      <?php }
                                       ?>


                                  <?php }else { ?>
                                    <button type="button" class="btn btn-info btn-flat" onclick="addNewAsignatura(<?php echo $IdAsig; ?>)"> <i class="fa fa-fw fa-crosshairs"></i> Pendiente </button>

                                  <?php } } ?>


                                </td>
                                <td><?php echo $lstAsig[$i]["CodeModulo"]; ?></td>
                                <td><?php echo $lstAsig[$i]["NombreMod"]; ?></td>
                                <td><?php echo $lstAsig[$i]["Estatus"]; ?></td>
                                <td><?php echo $lstAsig[$i]["Ciclo"]; ?></td>
                                <td><?php echo $lstAsig[$i]["CveGrupo"]; ?></td>
                                <td><?php echo $lstAsig[$i]["FecIni"].' / '.$lstAsig[$i]["FecFin"]; ?></td>
                            </tr>
                            <?php } ?>
                          </tfoot>
                        </table>
                      </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    </section>
  </div>
  <!-- /.content-wrapper -->
  <?php include("footer.php"); ?>
  <div id="dataModal4" class="modal fade"> <!--MODAL ME GUSTA-->
       <div class="modal-dialog">
            <div class="modal-content">
                 <div class="modal-header" style="background: #7c366c; color: white; font-size: 16px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Buscar asignatura ingresar alumno</h4>
                 </div>
                 <div class="modal-body" id="employee_detail4">

                 </div>
            </div>
       </div>
  </div>
</div>
<!-- ./wrapper -->
<script src="assets/table/js/jquery-3.1.1.min.js"></script>
<script src="assets/table/js/bootstrap.min.js"></script>
<script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- Custom and plugin javascript -->
<script src="assets/table/js/scriptAgregado1.js"></script>


<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>

$(document).ready(function(){
		 $(document).on('click', '.view_materias', function(){
					var employee_id = $(this).attr("id");
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/buscarAsignatura.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail4').html(data);
												 $('#dataModal4').modal('show');
										}
							 });
					}
		 });
});

$(document).ready(function(){
  var Id = document.frm.Id.value;
		 $(document).on('click', '.view_delAsignacion', function(){
					var employee_id = $(this).attr("id");
					if(employee_id != '')
					{
            var TipoGuardar = "del_asignacion";
                swal({
                 title: "\u00BFEst\u00E1 seguro que desea eliminar permanentemente la materia de este alumno?",
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
                         data:{TipoGuardar:TipoGuardar, employee_id:employee_id},
                         success:function(data){


                           parent.location.href='adConfigAlumno.php?Id=555553873b4d25e4f63873b4d65e4f63873b4d95e4f63873b4db'+Id+'&T=x';
                         }
                    })

                 }

               });




					}
		 });
});


$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	if(alerta){
		if(alerta =="0"){
			swal("Error al guardar", "No se ha podido realizar realizar este proceso", "error");
		}
		if(alerta =="1"){
			swal("Guardado correctamente", "Alumno asignado correctamente al grupo.", "success");
		}
		if(alerta =="2"){
			swal("Error al guardar", "No se ha podido actualizar el registro", "success");
		}
	}
});
$(function () {
  $('.select2').select2()

})
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
<?php } else {
 echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>
