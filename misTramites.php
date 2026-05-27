<?php $section = "Mis trámites escolares"; include("head.php"); $var = 21;
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en mis trámites escolares'); }
$datosUser = $t->get_datoDocente($_SESSION['IdUsua']);
$tipoDocumentos = $espacio->get_docs_tramite($_SESSION['IdUsua']);
$misDocumentos = $espacio->get_mis_tramites($_SESSION['IdUsua']);
$misDocAceptados = $espacio->get_docs_tram_true($_SESSION['IdUsua']);

if(isset($_POST["Mov"]) && $_POST["Mov"]=="sub_doc_tram"){
  $espacio->add_doc_tramite();
  exit;
}

if($datosUser[0]['Grado'] == 3){
  $nombre_file = "ficha_inscripcion";
} else {
  $nombre_file = "ficha_inscripcion";
}

$hora = $datosUser[0]['_horario'];

if($hora == 'P'){
  $cic_act = $espacio->get_cic_activo_personalizado($_SESSION['IdUsua']);
} else {
  $hora = 'R';
  $cic_act = $espacio->get_cic_activo($datosUser[0]['IdGrupo']);
}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Mis tramites escolares</h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="miEspacio.php"> Mi espacio</a></li>
        <li class="active"> Trámites escolares</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="Imagen de perfil">
              <h3 class="profile-username text-center"><?php echo $datosUser[0]["Nombre"]; ?></h3>
              <p class="text-muted text-center"><?php echo $datosUser[0]["APaterno"]; ?> <?php echo $datosUser[0]["AMaterno"]; ?></p>
              <ul class="list-group list-group-unbordered">
                <?php include("datEspacio.php"); ?>
              </ul>
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">

            <form class="form-horizontal" name="frm" id="frm" action="misTramites.php" method="POST" enctype="multipart/form-data">
              <input id="Mov" name="Mov" value="" type="hidden"/>
              <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
              <input id="Alerta" name="Alerta" value="<?php if(isset($_SESSION['Alerta'])){ echo $_SESSION['Alerta']; } ?>" type="hidden"/>
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Mis trámites escolares</a></li>
                <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Documentos de trámites aprobados</a></li>
              </ul>

              <div class="tab-content">
                <div class="tab-pane active" id="activity">
                <?php if(($datosUser[0]['Grado'] == 1) || ($datosUser[0]['Grado'] == 2) || ($datosUser[0]['Grado'] == 3)){ ?>
                  <?php if(isset($cic_act[0]['Ciclo'])) { ?>
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <td colspan="4" style="text-align: center; color: blue;"><b>Documentos oficiales del Periodo escolar: <?php echo $cic_act[0]['Ciclo']; ?></b><br><b style="color: black;">Nota:</b> deberá descargar el archivo y firmar el documento, una vez firmado deberá de subirlo en la Plataforma.</td>
                      </tr>
                      <tr>
                        <td><button onclick="window.open('repositorio/portafolio/convenio_beca.php?id=<?php echo time().$_SESSION['IdUsua']; ?>&idToks=<?php echo time().$cic_act[0]['IdCiclo']; ?>&h=<?php echo $hora; ?>','_blank')" href="javascript:void(0);" title="Descargar convenio de beca" type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i></button></td>
                        <td colspan="3"><p style="margin-top: 5px;">DESCARGAR CONVENIO DE BECA</p></td>
                      </tr>
                      <tr>
                        <td><button onclick="window.open('repositorio/portafolio/<?php echo $nombre_file; ?>.php?id=<?php echo time().$_SESSION['IdUsua']; ?>&idToks=<?php echo time().$cic_act[0]['IdCiclo']; ?>','_blank')" href="javascript:void(0);" title="Descargar ficha de inscripción" type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i></button></td>
                        <td colspan="3"><p style="margin-top: 5px;">DESCARGAR FICHA DE INSCRIPCIÓN</p></td>
                      </tr>
                      <tr>
                        <td><button onclick="window.open('misDatos.php','_self')" href="javascript:void(0);" title="Mis datos" type="button" class="btn btn-warning pull-right" style="margin-right: 5px;"><i class="fa fa-edit"></i></button></td>
                        <td colspan="3"><p style="margin-top: 5px;">ACTUALIZAR MIS DATOS PERSONALES</p></td>
                      </tr>
                      
                    </tbody>
                  </table>
                  <div class="box-body">
                    <h4 class="page-header"><label style="color: red;"><i class="fa fa-fw fa-paperclip"></i> Documentos que debe de subir</label></h4>
                    <div class="form-group" name="imgLoadDoAlum" id="imgLoadDoAlum" style="display: none;">
                      <div class="col-sm-12" style="text-align: center;">
                          <img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-4 control-label">Tipo de documento:</label>
                      <div class="col-sm-8">
                        <select class="form-control" name="txtTipoDoc" id="txtTipoDoc">
                          <option value=""> - Seleccione - </option>
                          <?php for ($i=0;$i< sizeof($tipoDocumentos);$i++) { ?>
                          <option value="<?php echo $tipoDocumentos[$i]["IdDocAlumno"]; ?>"><?php echo $tipoDocumentos[$i]["NomDocumento"].' / '.$tipoDocumentos[$i]["Ciclo"]; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Buscar:</label>
                      <div class="col-sm-8">
                        <input id="txtDocumento" name="txtDocumento" type="file" onchange="validarPDF(this,'txtDocumento');">
                        <p style="color: blue;">El archivo puede ser en formato .pdf/.png/.jpg</p>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                          <label style="color: red;">
                            <i class="fa fa-fw fa-warning"></i> Nota: Su archivo debe pesar menos de 10 MB.
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
              <div class="box-footer">
                <button name="btnDocAlumno" id="btnDocAlumno" onClick="val_docs_tramite()" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-cloud-upload"></i> Guardar archivo</button>
              </div><?php } ?>


                    <div class="box">
                      <div class="box-header">
                        <h3 class="box-title">Documentos en revisi&oacute;n</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body no-padding">
                        <table class="table table-striped" style="font-size: 12px;">
                          <tbody><tr>
                            <th>TIPO DOCUMENTO</th>
                            <th>FEC.CAP</th>
                            <th>ESTATUS</th>
                            <th></th>
                          </tr>
                          <?php for ($i=0;$i< sizeof($misDocumentos);$i++) { $id = $misDocumentos[$i]["IdDocAlumno"];

                             ?>
                          <tr>
                            <td><?php echo $misDocumentos[$i]["NomDocumento"]; ?></td>
                            <td><?php echo $misDocumentos[$i]["FecCap"]; ?></td>
                            <td><?php echo $misDocumentos[$i]["Estatus"]; ?></td>
                            <td>
                                <button onClick="val_del_doc_trami(<?php echo $id; ?>)"  type="button" class="btn btn-danger pull-right"> <i class="fa fa-times-circle"></i></button>
                              <a onClick="window.open('assets/docs/files/<?php echo $misDocumentos[$i]["Anio"]; ?>/<?php echo $misDocumentos[$i]["Mes"]; ?>/<?php echo $misDocumentos[$i]["Archivo"]; ?>','_blank')" href="javascript:void(0);">
                                <button type="button" class="btn btn-primary pull-left"> <i class="fa fa-fw fa-cloud-download"></i></button>
                              </a>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody></table>
                      </div>
                      <!-- /.box-body -->
                    </div>

                    <?php } ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="timeline">
                  <!-- The timeline -->
                  <ul class="timeline timeline-inverse">
                    <!-- timeline time label -->
                    <li class="time-label">
                          <span class="bg-red">
                            Mis documentos aceptados
                          </span>
                    </li>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <?php for ($x=0;$x< sizeof($misDocAceptados);$x++) { ?>
                    <li>
                      <i class="fa fa-file-pdf-o bg-green"></i>
                      <div class="timeline-item">
                        <span class="time">
                          <a onClick="window.open('assets/docs/files/<?php echo $misDocAceptados[$x]["Anio"]; ?>/<?php echo $misDocAceptados[$x]["Mes"]; ?>/<?php echo $misDocAceptados[$x]["Archivo"]; ?>','_blank')" href="javascript:void(0);">
                            <button type="button" class="btn btn-danger btn-xs pull-left"> <i class="fa fa-fw fa-cloud-download"></i> <?php echo $misDocAceptados[$x]["Ciclo"]; ?></button>
                          </a>
                        </span>
                        <h3 class="timeline-header"><a href="#"></a><?php echo $misDocAceptados[$x]["NomDocumento"]; ?></h3>
                      </div>
                    </li>
                    <?php } ?>
                    <li>
                      <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                  </ul>
                </div>
              </div>
              <!-- /.tab-content -->
            </div>
            </form>

        </div>
      </div>
    </section>
  </div>
  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

  $(document).ready(function(){
  	var alerta = document.frm.Alerta.value;
  	if(alerta){
  		if(alerta =="0"){
  			swal("Error", "Error no se puede Guardar", "error");
  		}
  		if(alerta =="1"){
  			swal("Guardado correctamente", "El archivo se ha guardado correctamente.", "success");
  		}
      if(alerta =="5"){
  			swal("Eliminado correctamente", "El archivo se ha eliminado correctamente.", "success");
  		}
      if(alerta =="6"){
  			swal("Error al eliminar", "No se puede eliminar el archivo.", "error");
  		}
  	}
  });
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
