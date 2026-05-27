<?php $section = "Solicitar baja"; include("head.php"); $var = 11;
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en solicitar baja'); }
$tipoD = 45;
$datosUser = $t->get_datoDocente($_SESSION['IdUsua']);
$tipoDocumentos = $espacio->get_tipoDoc($_SESSION['IdUsua'],$tipoD,$datosUser[0]["IdOferta"]);
$misDocumentos = $espacio->get_misDocTramite($_SESSION['IdUsua'],$tipoD);
$misDocAceptados = $espacio->get_misDocTraAcep($_SESSION['IdUsua'],$tipoD);






if(isset($_POST["Mov"]) && $_POST["Mov"]=="SubDocAlum"){
  $espacio->add_docBaja();
  exit;
}

//
// if(isset($_POST["Mov"]) && $_POST["Mov"]=="datSocial"){
//   $espacio->add_datSocial();
//   exit;
// }

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
        Solitar baja
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="miEspacio.php"> Mi espacio</a></li>
        <li class="active">Solicitar baja</li>
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
            <form class="form-horizontal" name="frm" id="frm" action="miBaja.php" method="POST" enctype="multipart/form-data">
              <input id="Mov" name="Mov" value="<?php echo $_GET['Mov'];?>" type="hidden"/>
              <input id="IdPago" name="IdPago" value="<?php echo $_GET['IdPago'];?>" type="hidden"/>
              <input id="IdUsua" name="IdUsua" value="<?php echo $datosUser[0]["IdUsua"]; ?>" type="hidden"/>
              <input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
              <input id="Tipo" name="Tipo" value="45" type="hidden"/>
              <input id="Tramite" name="Tramite" value="SS" type="hidden"/>
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Subir documento</a></li>
                <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Mis documentos</a></li>

              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="activity">
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <td><button onClick="window.open('assets/docs/Baja/SolicitudBajaX.docx','_blank')" href="javascript:void(0);" type="button" class="btn btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i></button></td>
                        <td>Solicitud de baja</td>
                        <td><button onClick="window.open('assets/docs/Baja/CuestionarioBaja.docx','_blank')" href="javascript:void(0);" type="button" class="btn btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i></button></td>
                        <td>Cuestionario de baja</td>
                      </tr>
                    </tbody></table>


                    <h4 class="page-header"><label style="color: red;"><i class="fa fa-fw fa-cubes"></i> Documentos ha subir</label></h4>
                    <div class="form-group" name="imgLoadDoAlum" id="imgLoadDoAlum" style="display: none;">
                      <div class="col-sm-12" style="text-align: center;">
                          <img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-4 control-label" style="text-align: left;">Tipo  de documento: <br>
                        <select class="form-control" name="txtTipoDoc" id="txtTipoDoc">
            							<option value=""> - Seleccione - </option>
            							<?php for ($i=0;$i< sizeof($tipoDocumentos);$i++) { ?>
            							<option value="<?php echo $tipoDocumentos[$i]["IdTipoDocumento"]; ?>"<?php if($_POST[txtTipoDoc]==$tipoDocumentos[$i]["IdTipoDocumento"]){?>selected="selected"<?php }?>><?php echo $tipoDocumentos[$i]["NomDocumento"]; ?></option>
            							<?php } ?>
          						  </select>
                     </label>

                      <div class="col-sm-5">
                        <label for="inputPassword3" style="text-align: left;">Buscar: <br>
                        <input id="txtDocumento" name="txtDocumento" type="file" onchange="validarPDF(this,'txtDocumento');">
                        <p class="help-block">El archivo puede ser en formato .pdf/.docx/.png/.jpg</p>
                      </div>
                      <div class="col-sm-3">
                        <button name="btnDocAlumno" id="btnDocAlumno" onClick="val_addDocAlumno()" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-check-circle"></i> Guardar</button>
                      </div>
                      <label for="inputPassword3" class="col-sm-12 control-label" style="text-align: left; color: red; margin-top: -26px;">* Nota: Su archivo debe pesar menos de 10 MB.</label>
                    </label>
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
                              <a onClick="window.open('assets/docs/Baja/<?php echo $misDocumentos[$i]["Archivo"]; ?>','_blank')" href="javascript:void(0);">
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
                            Documentos de baja
                          </span>
                    </li>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <?php for ($x=0;$x< sizeof($misDocAceptados);$x++) { ?>
                    <li>
                      <i class="fa fa-file-pdf-o bg-green"></i>
                      <div class="timeline-item">
                        <span class="time">
                          <a onClick="window.open('assets/docs/Baja/<?php echo $misDocAceptados[$x]["Archivo"]; ?>','_blank')" href="javascript:void(0);">
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
  			swal("Error", "Error no se puede Guardar", "error");
  		}
  		if(alerta =="1"){
  			swal("Guardado", "Archivo guardado con exito", "success");
  		}
  	}
  });

</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
