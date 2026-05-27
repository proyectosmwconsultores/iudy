<?php $valor = 3; $section = "Recursar materia"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el moódulo de recursar materia'); }
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));
if($_SESSION['Permisos']) {
  if(isset($_POST["IdUsuaXX"])){
    $idAlumno = $_POST["IdUsuaXX"];
  } else {
      $idAlumno = substr($_GET["Id"], 10,10);
  }

  if(isset($_GET["G"])){
    $_POST["txtGrupo"] = $_GET["G"];
  }

$datos = $t->get_usuarioId($idAlumno);
$grpDt = $t->get_userGprId($idAlumno);

$grupo = $t->get_gruposTotalCV($datos[0]["IdOferta"]);
$grupoDispo = $t->get_gruposDispods($datos[0]["IdOferta"],$datos[0]["IdCampus"],$datos[0]["IdGrupo"]);

if($datos[0]["IdGrupo"]){
    $lstAsig = $t->get_lstRecursar($datos[0]["IdOferta"],$datos[0]["IdCampus"],$_POST["txtGrupo"]);
}

if(isset($_POST["Mov"]) && $_POST["Mov"]=="AddMRecursar"){
  $espacio->add_asigRecursar();
  exit;
}

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
		<div style="padding: 20px 30px; background: rgb(255, 215, 0) none repeat scroll 0% 0%; z-index: 999999; font-size: 16px; font-weight: 600;"><i class="fa fa-fw fa-warning"></i> Atenci&oacute;n: este módulo es exclusivamente cuando un alumno va para Cursamiento/recursamiento de materia.</a></div>
	<?php } ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Configuraci&oacute;n Cursamiento/Recursamiento de materia
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Recursar</li>
      </ol>
    </section>

    <!-- Main content -->
		<section class="content">
        <form role="form" name="frm" id="frm" action="adRecursar.php" method="POST" enctype="multipart/form-data">
          <input id="IdUsuaXX" name="IdUsuaXX" value="<?php echo $_POST['IdUsuaXX'];?>" type="hidden"/>
          <input id="Id" name="Id" value="<?php echo $idAlumno; ?>" type="hidden"/>
          <input id="Mov" name="Mov" value="" type="hidden"/>
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
              <a href="perfil.php?token=9834532145<?php echo $idAlumno; ?>" class="btn btn-primary btn-block"><b>Regresar</b></a>
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
          				<input id="Nombre" name="Nombre" value="Reporte de materias" type="hidden"/>
                  <div class="col-md-12">
            			  <div class="box-primary">
            				  <div class="box-body">
            					<div class="form-group">
            						<label>Grupo actual en el que se encuentra activo:</label>
            						<div class="input-group">
            						  <div class="input-group-addon">
            							<i class="fa fa-key"></i>
            						  </div>
            						  <input class="form-control" id="txtClave" disabled name="txtClave" placeholder="Clave" type="text" value="<?php echo $grpDt[0]["CveGrupo"]; ?>">
            						</div>
            					</div>
            				  </div>
            			  </div>
            			</div>

                  <div class="col-md-12">
            			  <div class="box-primary">
            				  <div class="box-body">
            					<div class="form-group">
            						<label>Seleccione grupos disponibles:</label>
            						<div class="input-group">
            						  <div class="input-group-addon">
            							<i class="fa fa-key"></i>
            						  </div>
                          <select class="form-control select2" name="txtGrupo" id="txtGrupo" onchange="document.frm.IdUsuaXX.value=<?php echo $idAlumno; ?>;document.frm.submit();">
                            <option value=""> - Seleccione - </option>
                            <?php for ($i=0;$i< sizeof($grupoDispo);$i++) { ?>
                            <option value="<?php echo $grupoDispo[$i]["IdGrupo"]; ?>"<?php if($_POST["txtGrupo"] == $grupoDispo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $grupoDispo[$i]["CveGrupo"].' / Cuatrimestre '.$grupoDispo[$i]["Nivel"]; ?></option>
                            <?php } ?>
                          </select>
            						</div>
            					</div>
            				  </div>
            			  </div>
            			</div>

              <div class="box-body">


                <div class="form-group">

              <h4 style="text-align: center;">

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
              <h3 class="box-title">Lista de asignaturas</h3>
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
                              <th>Ciclo</th>
                              <th>Grupo</th>
                              <th>Fecha</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php for ($i=0;$i< sizeof($lstAsig);$i++) {
                              $checarReg = $t->get_lstCkrRg($idAlumno,$lstAsig[$i]["IdAsignacion"],$lstAsig[$i]["IdModulo"]);
                              $caScarId = $t->get_lstAdfrRg($lstAsig[$i]["IdAsignacion"],$lstAsig[$i]["IdModulo"]);
                              $IdAsig = $caScarId[0]["Id"];
                              $val = 0;
                              $val = $checarReg[0]["IdUsua"];

                               ?>
                            <tr style="font-size: 12px;">

                                <td><?php if($val){ ?>


                                    <button type="button" class="btn btn-default btn-flat"> <i class="fa fa-fw fa-check-circle-o"></i> </button>
                                  <?php } else { ?>
                                    <button type="button" class="btn btn-warning btn-flat" onclick="addNewRecursar(<?php echo $IdAsig; ?>)"> <i class="fa fa-fw fa-crosshairs"></i> Agregar </button>

                                  <?php } ?>


                                </td>
                                <td><?php echo $lstAsig[$i]["CodeModulo"]; ?></td>
                                <td><?php echo $lstAsig[$i]["NombreMod"]; ?></td>
                                <td><?php echo $caScarId[0]["Ciclo"]; ?></td>
                                <td><?php echo $lstAsig[$i]["CveGrupo"]; ?></td>
                                <td><?php echo $caScarId[0]["FecIni"].' / '.$caScarId[0]["FecFin"]; ?></td>
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
                           parent.location.href='adConfigAlumno.php?Id=15485756325'+Id;
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
