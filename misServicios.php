<?php $section = "Tramite de servicio social"; include("head.php"); $var = 8;
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en Mis Tramites del servicio social'); }
$tipoD = 33;
$datosUser = $t->get_datoDocente($_SESSION['IdUsua']);

// $tipoDocumentos = $espacio->get_tipoDoc($_SESSION['IdUsua'],$tipoD,$datosUser[0]["IdOferta"]);
$misDocumentos = $espacio->get_misDocTramite($_SESSION['IdUsua'],$tipoD);
$misDocAceptados = $espacio->get_misDocTraAcep($_SESSION['IdUsua'],$tipoD);
$serSocial = $espacio->get_Social($_SESSION['IdUsua']);


$datosUser = $t->get_datoDocente($_SESSION['IdUsua']);


if(isset($_POST["Mov"]) && $_POST["Mov"]=="SubDocAlum"){
  $espacio->add_docAlumno();
  exit;
}


if(isset($_POST["Mov"]) && $_POST["Mov"]=="datSocial"){
  $espacio->add_datSocial();
  exit;
}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Tr&aacute;mite de servicio social
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="miEspacio.php"> Mi espacio</a></li>
        <li class="active"> Mis tr&aacute;mites</li>
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
        <div class="col-md-9">
            <form class="form-horizontal" name="frm" id="frm" action="misServicios.php" method="POST" enctype="multipart/form-data">

              <input id="Mov" name="Mov" type="hidden"/>
              <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
              <input id="Alerta" name="Alerta" value="<?php if(isset($_SESSION['Alerta'])){ echo $_SESSION['Alerta']; } ?>" type="hidden"/>
              <input id="Tipo" name="Tipo" value="33" type="hidden"/>
              <input id="Tramite" name="Tramite" value="SS" type="hidden"/>
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Subir mis documentos</a></li>
                <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Mis documentos aprobados</a></li>
                <li class=""><a href="#settings" data-toggle="tab" aria-expanded="true">Dependencia</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="activity">
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <td colspan="4" style="text-align: center; color: blue;"><b>En este espacio podrá descargar documentos oficiales</b></td>
                      </tr>
                      <?php if($serSocial[0]['FecCarta']){ ?>
                      <tr>
                        <td><button onclick="window.open('repositorio/portafolio/carta_presentacion_ss.php?tokenId=<?php echo time().$serSocial[0]['IdServicio']; ?>','_blank')" href="javascript:void(0);" title="Descargar constancia de servicio social" type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i></button></td>
                        <td colspan="3"><p style="margin-top: 5px;">Descargar carta de presentación para el servicio social</p></td>
                      </tr><?php } ?>
                      <?php if($serSocial[0]['Documento']){ ?>
                      <tr>
                        <td><button onclick="window.open('assets/docs/ServicioSocial/<?php echo $serSocial[0]['Documento']; ?>','_blank')" href="javascript:void(0);" title="Descargar constancia de servicio social" type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i></button></td>
                        <td colspan="3"><p style="margin-top: 5px;">Descargar constancia de servicio social legalizada</p></td>
                      </tr><?php } ?>
                    </tbody></table>


                    <h4 class="page-header"><label style="color: red;"><i class="fa fa-fw fa-cubes"></i> Documentos por subir</label></h4>

                    <div class="box-body">
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
                            <option value="101">CARTA DE ACEPTACIÓN - (Firmada y sellada por la Dependencia)</option>
              							<option value="102">CARTA DE LIBERACIÓN - (Firmada y sellada por la Dependencia)</option>
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
                            <label style="color: blue;">
                              <i class="fa fa-fw fa-info-circle"></i> Recuerde que los documentos originales deberán ser entregados en el area de Control Escolar.
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="box-footer">
                      <button name="btnDocAlumno" id="btnDocAlumno" onClick="val_addDocAlumno()" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-check-circle"></i> Guardar</button>
                    </div>


                    <div class="box">
                      <div class="box-header">
                        <h3 class="box-title">Documentos en revisi&oacute;n</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body no-padding">
                        <table class="table table-striped">
                          <tbody><tr>
                            <th>Tipo documento</th>
                            <th>FecCap</th>
                            <th>Estatus</th>
                            <th></th>
                          </tr>
                          <?php for ($i=0;$i< sizeof($misDocumentos);$i++) { $id = $misDocumentos[$i]["IdDocTramite"];
                            if($misDocumentos[$i]["Estatus"] == "No Aprobado"){ $color = "red"; } else { $color = "blue"; }
                             ?>
                          <tr>
                            <td><?php echo $misDocumentos[$i]["NomDocumento"]; ?></td>
                            <td><?php echo $misDocumentos[$i]["FecCap"]; ?></td>
                            <td><b style=" color: <?php echo $color; ?>;"><?php echo $misDocumentos[$i]["Estatus"]; ?></b></td>
                            <td>
                                <button onClick="val_delDocAlumno(this,<?php echo $id; ?>)"  type="button" class="btn btn-danger pull-right"> <i class="fa fa-times-circle"></i></button>
                              <a onClick="window.open('assets/docs/ServicioSocial/<?php echo $misDocumentos[$i]["Archivo"]; ?>','_blank')" href="javascript:void(0);">
                                <button type="button" class="btn btn-primary pull-left"> <i class="fa fa-fw fa-cloud-download"></i></button>
                              </a>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody></table>
                      </div>
                      <!-- /.box-body -->
                    </div>


                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="timeline">
                  <!-- The timeline -->
                  <ul class="timeline timeline-inverse">
                    <!-- timeline time label -->
                    <li class="time-label">
                          <span class="bg-purple">
                            Servicio Social
                          </span>
                    </li>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <?php for ($x=0;$x< sizeof($misDocAceptados);$x++) { ?>
                    <li>
                      <i class="fa fa-file-pdf-o bg-green"></i>
                      <div class="timeline-item">
                        <span class="time">
                          <a onClick="window.open('assets/docs/ServicioSocial/<?php echo $misDocAceptados[$x]["Archivo"]; ?>','_blank')" href="javascript:void(0);">
                            <button type="button" class="btn btn-danger btn-xs pull-left"> <i class="fa fa-fw fa-cloud-download"></i> Descargar</button>
                          </a>
                        </span>
                        <h3 class="timeline-header"><a href="#"></a><?php echo $misDocAceptados[$x]["NomDocumento"]; ?></h3>
                        <h3 class="timeline-header" style="color: black; font-size: 12px;"><span class="time"><i class="fa fa-clock-o"></i> <?php echo $misDocAceptados[$x]["FecCap"]; ?></span></h3>
                      </div>
                    </li>
                    <?php } ?>
                    <li>
                      <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                  </ul>
                </div>
                <div class="tab-pane" id="settings">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-4 control-label">Nombre de la Dependencia / Instituci&oacute;n / Organismo:</label>

                    <div class="col-sm-8">
                      <input class="form-control" id="txtDependencia" name="txtDependencia" type="text" placeholder="Nombre de la Dependencia / Instituci&oacute;n / Organismo" value="<?php echo $serSocial[0]["NomDependencia"]; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-4 control-label">Progama del Servicio Social:</label>

                    <div class="col-sm-8">
                      <input class="form-control" id="txtPrograma" name="txtPrograma" type="text" placeholder="Progama del Servicio Social" value="<?php echo $serSocial[0]["NomPrograma"]; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-4 control-label">Periodo:</label>

                    <div class="col-sm-8">
                      <input class="form-control" placeholder="ejemplo: 05 de Abril de 2018 al 05 de Octubre de 2018" id="txtPeriodo" name="txtPeriodo" type="text" value="<?php echo $serSocial[0]["Periodo"]; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-4 control-label">Actividades a realizar o realizadas:</label>

                    <div class="col-sm-8">
                      <textarea class="textarea" id="txtActividades" name="txtActividades" placeholder="Actividades a realizar o realizadas" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $serSocial[0]["Actividades"]; ?></textarea>
                    </div>
                  </div>
                  <?php if($serSocial[0]["IdEstatus"] == 8){ ?>
                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                      <button type="button" onClick="val_addDatSocial()" class="btn btn-success"><i class="fa fa-save"></i> Guardar datos</button>
                    </div>
                  </div><?php } ?>
                </form>
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
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClic
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Bootstrap WYSIHTML5 -->

<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>

  $(function () {
    $('.textarea').wysihtml5()
  })

  $(document).ready(function(){
  	var alerta = document.frm.Alerta.value;
  	if(alerta){
  		if(alerta =="0"){
  			swal("Error al guardar", "Error no se puede Guardar", "error");
  		}
  		if(alerta =="1"){
  			swal("Guardado correctamente", "El archivo  se ha guardado correctamente.", "success");
  		}
      if(alerta =="2"){
  			swal("Guardado correctamente", "Los datos del servicio social se han guardado correctamente.", "success");
  		}
  	}
  });

</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
