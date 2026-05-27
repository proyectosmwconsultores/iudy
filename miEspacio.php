<?php $section = "Mi espacio"; include("head.php"); $var = 1;
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está consultado sus datos personsales'); }
$datosUser = $t->get_datosUser($_SESSION['IdUsua']);

$datInformacion = $t->get_datInformacion($_SESSION['IdUsua']);
if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
  $t->upd_datosAlumno();
  exit;
}

if($configuracion[22]["Descripcion"] == "SI"){
  $encuestasPend=$t->get_listaEnsta($_SESSION['IdUsua']);
  if(isset($encuestasPend[0])){
    header('Location: viewFinalizados.php?x=x');
  }
}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Mi espacio</h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Mi espacio</li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="miEspacio.php" method="POST" enctype="multipart/form-data">
     <input id="Alerta" name="Alerta" value="<?php if(isset($_SESSION['Alerta'])){ echo $_SESSION['Alerta']; } ?>" type="hidden"/>
     <input id="Variable" name="Variable" value="<?php if(isset($_SESSION['Variable'])){ echo $_SESSION['Variable']; } ?>" type="hidden"/>
     <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'];?>" type="hidden"/>
     <input id="Permisos" name="Permisos" value="<?php echo $_SESSION['Permisos'];?>" type="hidden"/>
      <div class="row">
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="Imagen de perfil" style="width: 100px; height: 100px;">
              <h3 class="profile-username text-center"><?php echo $datosUser[0]["NombreUser"]; ?></h3>
              <p class="text-muted text-center"><?php echo $datosUser[0]["APaterno"]; ?> <?php echo $datosUser[0]["AMaterno"]; ?></p>
              <ul class="list-group list-group-unbordered">
                <?php //if($_SESSION['Permisos']==3 ) {
                  include("datEspacio.php"); // } ?>
                  <?php //if($_SESSION['Permisos']==2 ) { include("datDocente.php");   ?>
                <?php //}  else { include("datGral.php");   ?>
              <?php //}  ?>

              </ul>

            </div>
          </div>


        </div>
        <!-- /.col -->

        <div class="col-md-9">
          <?php if(!$datInformacion[0]['FecNac']){ ?>
          <div class="bg-red-active color-palette" style="padding: 4px; "><span style="color: yellow; font-size: 12px;"><i class="fa fa-fw fa-warning"></i> Nota: debe de actualizar sus datos personales.</span></div>
          <?php } ?>

          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header" style=" background: #7c366c; color: white;">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="User Avatar" style="width: 60px; height: 60px;">
              </div>
              <h3 class="widget-user-username"><?php echo $datosUser[0]["NombreUser"]; ?> <?php echo $datosUser[0]["APaterno"]; ?> <?php echo $datosUser[0]["AMaterno"]; ?></h3>
              <h5 class="widget-user-desc"><?php echo $datosUser[0]["Cargo"]; ?></h5>
              <span class="input-group-btn" style="float: right; padding-right: 138px; ">
                <?php if($_SESSION["Permisos"] == 3){ ?>
                <button onClick="window.open('misDatos.php','_self')" href="javascript:void(0);" style="border-radius: 25px;" type="button" class="btn btn-warning btn-flat"><i class="fa fa-fw fa-edit"></i> Datos personales</button>
              <?php } else { ?>
                <button onClick="window.open('actualizar_datos.php','_self')" href="javascript:void(0);" style="border-radius: 25px;" type="button" class="btn btn-warning btn-flat"><i class="fa fa-fw fa-edit"></i> Datos personales</button>
              <?php } ?>
              </span>
            </div>
            <table class="table table-striped">
              <tbody>
                <tr>
                  <td style="width: 30px;"><i class="fa fa-fw fa-bank"></i></td>
                  <td><?php echo $datInformacion[0]["Campus"]; ?></td>
                  <td style="width: 30px;"><i class="fa fa-fw fa-mobile-phone"></i></td>
                  <td><?php if(isset($datInformacion[0]["Celular"])){ echo $datInformacion[0]["Celular"]; } else  { echo "- - -"; } ?></td>
                </tr>
                <?php if($_SESSION["Permisos"] == 3){ ?>
                <tr>
                  <td style="width: 30px;"><i class="fa fa-fw fa-book"></i></td>
                  <td><?php echo $datInformacion[0]["NomEducativa"]; ?></td>
                  <td style="width: 30px;"><i class="fa fa-fw fa-flag"></i></td>
                  <td><?php echo $datInformacion[0]["CveGrupo"];  ?></td>
                </tr><?php } ?>
                <tr>
                  <td style="width: 30px;"><i class="fa fa-fw fa-envelope"></i></td>
                  <td><?php echo $datInformacion[0]["Correo"]; ?></td>
                  <td style="width: 30px;"><i class="fa fa-fw fa-envelope"></i></td>
                  <td><?php if(isset($datInformacion[0]["Correo_institucional"])){ echo $datInformacion[0]["Correo_institucional"]; } else  { echo "- - -"; } ?></td>
                </tr>
                <tr>
                  <td style="width: 30px;"><i class="fa fa-fw fa-birthday-cake"></i></td>
                  <td colspan="3"><?php if(isset($datInformacion[0]["FecNac"])){ echo $datInformacion[0]["FecNac"]; } else  { echo "- - -"; } ?></td>
                </tr>
                </tbody>
            </table>
          </div>



          <?php
          if($_SESSION["Permisos"] == 3){ $chkHra=$t->get_chkHorario($_SESSION["IdUsua"]); ?>



          <div class="box box-widget widget-user-2">
            <div class="widget-user-header" style=" background: #7c366c; color: white;">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/images/horario.png" style="width: 60px;"  alt="User Avatar">
              </div>
              <h3 class="widget-user-username">Mi horario de clases</h3>
              <h5 class="widget-user-desc">Mi horario activo</h5>
            </div>
            <div class="box-footer no-padding" id="seleccion">
              <p style="text-align: center;"><b>Mi horario de clases activas en la Plataforma</b></p>
              <table class="table table-striped" style="width: 100%">
                <tbody>
                  <tr style="background: #c0b8ff; font-size: 12px;">
                    <td>Materia</td>
                    <td style="text-align: center;">Lun</td>
                    <td style="text-align: center;">Mar</td>
                    <td style="text-align: center;">Mié</td>
                    <td style="text-align: center;">Jue</td>
                    <td style="text-align: center;">Vie</td>
                    <td style="text-align: center;">Sáb</td>
                    <td style="text-align: center;">Dom</td>
                  </tr>
                  <?php for ($h=0;$h< sizeof($chkHra);$h++) {
                  $chHra=$t->get_chkHor($chkHra[$h]['IdAsignacion']); ?>
                  <tr style="font-size: 12px;">
                    <td><?php echo $chkHra[$h]['NombreMod']; ?></td>
                    <?php for ($v=0;$v< sizeof($chHra);$v++) { ?>
                    <td style="text-align: center;"><?php if($chHra[$v]['Total']){ echo $chHra[$v]['HraIni'].':'.$chHra[$v]['MinIni'].'-'.$chHra[$v]['HraFin'].':'.$chHra[$v]['MinFin']; } else { echo '-';} ?></td>
                  <?php }  ?>
                  </tr>
                  <?php } ?>
              </tbody></table>
            </div>

          </div>

          <?php  } ?>

          <?php if($_SESSION["Permisos"] == 2){
            $gradoEst = $t->get_gradosEst($_SESSION['IdUsua']);
            $chkHra=$t->get_chkHorarioDoc($_SESSION["IdUsua"]);
             ?>
             <div id="panel_docente"></div>




          <div class="box box-widget widget-user-2">
            <div class="widget-user-header" style=" background: #7c366c; color: white;">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/images/horario.png" style="width: 60px;"  alt="User Avatar">
              </div>
              <h3 class="widget-user-username">Mi horario de clases</h3>
              <h5 class="widget-user-desc">Mi horario activo</h5>
            </div>
            <div class="box-footer no-padding" id="seleccion2">
              <table class="table table-striped" style="width: 100%">
                <tbody>
                  <tr style="background: #00c0ef; font-size: 12px; color: #11101e;">
                    <td>Materia</td>
                    <td style="text-align: center;">Lun</td>
                    <td style="text-align: center;">Mar</td>
                    <td style="text-align: center;">Mié</td>
                    <td style="text-align: center;">Jue</td>
                    <td style="text-align: center;">Vie</td>
                    <td style="text-align: center;">Sáb</td>
                    <td style="text-align: center;">Dom</td>
                  </tr>
                  <?php for ($h=0;$h< sizeof($chkHra);$h++) {
                  $chHra=$t->get_chkHor($chkHra[$h]['IdAsignacion']); ?>
                  <tr style="font-size: 12px;">
                    <td><?php echo $chkHra[$h]['NombreMod']; ?></td>
                    <?php for ($v=0;$v< sizeof($chHra);$v++) { ?>
                    <td style="text-align: center;"><?php if($chHra[$v]['Total']){ echo $chHra[$v]['HraIni'].':'.$chHra[$v]['MinIni'].'-'.$chHra[$v]['HraFin'].':'.$chHra[$v]['MinFin']; } else { echo '-';} ?></td>
                  <?php }  ?>
                  </tr>
                  <?php } ?>
              </tbody></table>
            </div>
          </div>

        <?php } ?>

        </div>
      </div>
    </form>
    </section>
  </div>
  <div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
        <div class="modal-dialog">
             <div class="modal-content">
                  <div class="modal-body" id="employee_detail">
                  </div>
             </div>
        </div>
   </div>
  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->
<div id="dataModalViewPc" class="modal fade"> <!--MODAL ME GUSTA-->
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-fw fa-user"></i> Mi semblanza</h4>
               </div>
               <div class="modal-body" id="employee_detailViewPc">
               </div>
          </div>
     </div>
</div>

<div id="data_grad"  class="modal fade">
     <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-fw fa-briefcase"></i> Grado de estudio</h4>
               </div>

               <div class="modal-body" id="employee_grad">
               </div>
          </div>
     </div>
</div>

<div id="data_grad_u"  class="modal fade">
     <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-fw fa-briefcase"></i> Actualizar documento del grado de estudio</h4>
               </div>

               <div class="modal-body" id="employee_grad_u">
               </div>
          </div>
     </div>
</div>

<div id="dataDocsx" class="modal fade"> <!--MODAL ME GUSTA-->
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-fw fa-file"></i> <b id="_pre"></b></h4>
               </div>
               <div class="modal-body" id="employee_docsx">
               </div>
          </div>
     </div>
</div>


<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
 $(document).ready(function(){
      $(document).on('click', '.view_data', function(){
           var employee_id = $(this).attr("id");
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/viewActividad.php",
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
</script>
<script>
$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	var variable = document.frm.Variable.value;

	if(alerta){
		if(alerta =="GUARDAR"){
			swal("Guardado correctamente", "Sus datos han sido guardados correctamente.", "success");
		}
		if(alerta =="ACTUALIZAR"){
			swal("Actualizado correctamente", "Sus datos han sido actualizado correctamente.", "success");
		}
		if(alerta =="ELIMINAR"){
			swal("Eliminado correctamente", "La informacion se ha eliminado correctamente.", "success");
		}
		if(alerta =="ERROR"){
			swal("Error", "Ha ocurrido un error, favor de comunicarse con el administrador.", "error");
		}
    if(alerta =="DEL_FIRMA"){
			swal("Eliminado correctamente", "La forma digital se ha eliminado correctamente.", "success");
		}
	}

  var IdPermiso = document.getElementById("Permisos").value;
  if(IdPermiso == 2){
    var IdUsua = document.getElementById("IdUsua").value;
    datos_docente(IdUsua);
  }
});

function datos_docente(IdUsua){
    var Capa = "#panel_docente";
    $(Capa).load("dashboard/datos_docente.php",{IdUsua:IdUsua}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
}

function viewSemblanza(){
  var IdUsua = document.getElementById("IdUsua").value;

  $.ajax({
       url:"formConsulta/addSemblanza.php",
       method:"POST",
       data:{IdUsua:IdUsua},
       success:function(data){
            $('#employee_detailViewPc').html(data);
            $('#dataModalViewPc').modal('show');
       }
  });
}

function viewGrados(IdUsua){
  var IdGrado = 0;
  $.ajax({
       url:"formConsulta/addGrado.php",
       method:"POST",
       data:{IdUsua:IdUsua, IdGrado:IdGrado},
       success:function(data){
            $('#employee_grad').html(data);
            $('#data_grad').modal('show');
       }
  });
}

function aplicar_n(IdUsua,IdNivel, Valor){
  var TipoGuardar = "sav_nivel_class";
  $.ajax({
       url:"formConsulta/setting.php",
       method:"POST",
       data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdNivel:IdNivel, Valor:Valor},
       success:function(data){
         datos_docente(IdUsua);
       }
  })
}

function ver_docs_docente(IdDocs){
	$.ajax({
			 url:"dashboard/ver_documento_asesor.php",
			 method:"POST",
			 data:{IdDocs:IdDocs},
			 success:function(data){
						$('#employee_docsx').html(data);
						$('#dataDocsx').modal('show');
			 }
	});
}

function del_docsx(Code,IdUsua){

    var TipoGuardar = "del_docs_doce";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea eliminar estos datos del nivel académico?",
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
             data:{TipoGuardar:TipoGuardar, Code:Code, IdUsua:IdUsua},
             success:function(data){


             }
        })
        .done(function(data) {
          if(data==1){
            swal("Elimado correctamente", "Los datos del nivel se han eliminado correctamente.", "success");
            datos_docente(IdUsua);
          }

          if(data==0){
            swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
          }
        })
        .error(function(data) {
          swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
        });
      }

    });
}

  function subir_docs_dox(IdDocDocente,Tipo){
    $.ajax({
         url:"formConsulta/upd_grado.php",
         method:"POST",
         data:{IdDocDocente:IdDocDocente,Tipo:Tipo},
         success:function(data){
              $('#employee_grad_u').html(data);
              $('#data_grad_u').modal('show');
         }
    });
  }

</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
