<?php $section = "Mis reconocimientos";
include("head.php");
$var = 5;
if (($_SESSION['IdUsua']) && ($_SESSION['Permisos'] == 2)) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de mis documentos');
}
$datosUser = $t->get_docente_id($_SESSION['IdUsua']);
$tipoDocumentos = $espacio->get_tipoDocC($_SESSION['IdUsua'], 2);
$misRecx = $espacio->get_reconox($_SESSION['IdUsua']);


if (isset($_POST["Mov"]) && $_POST["Mov"] == "SubDocumentox") {
  $espacio->add_reconoxc();
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
          <i class="fa fa-fw fa-trophy"></i> Mis reconocimientos
        </h1>
        <ol class="breadcrumb">
          <li><a href="espacioUsuario.php"><i class="fa fa-bell"></i> Mi espacio</a></li>
          <li class="active"> Mis reconocimientos</li>
        </ol>
      </section>
      <section class="content">
        <div class="kx-page">
          <div class="kx-layout">
            <!-- SIDEBAR -->
            <?php include("espacioDocente.php");  ?>
            <section class="pay-page">
              <div class="paytabs-card">

                <!-- Header con Tabs -->
                <div class="paytabs-header">

                  <div class="paytabs-title-area">
                    <div class="paytabs-icon">💼</div>
                    <div>
                      <div class="paytabs-title">Mis reconocimientos</div>
                      <div class="paytabs-sub">Espacio para subir mis reconocimientos </div>
                    </div>
                  </div>

                </div>

                <!-- Contenido -->
                <div class="paytabs-content">

                  <div class="paypanel is-active" data-content="pendientes">
                    <form class="form-horizontal" name="frm" id="frm" action="mi_reconocimiento.php" method="POST" enctype="multipart/form-data">
                      <input id="Mov" name="Mov" value="" type="hidden" />
                      <input id="IdUsua" name="IdUsua" value="<?php echo $datosUser[0]["IdUsua"]; ?>" type="hidden" />
                      <input id="Alerta" name="Alerta" value="<?php if (isset($_SESSION['Alerta'])) { echo $_SESSION['Alerta']; } ?>" type="hidden" />
                      <div class="box-body">
                        <div class="form-group" name="imgLoadDoDoc" id="imgLoadDoDoc" style="display: none;">
                          <div class="col-sm-12" style="text-align: center;">
                            <img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Nombre del reconocimiento:</label>
                          <div class="col-sm-8">
                            <input id="txt_nombre" name="txt_nombre" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-6 control-label">Fecha de emisión del reconocimiento:</label>
                          <div class="col-sm-6">
                            <input id="txt_fecha" name="txt_fecha" type="text" class="form-control">
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
                        <button name="btnDocDocente" id="btnDocDocente" onClick="subir_recnox()" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-check-circle"></i> Guardar</button>
                      </div>

                      <div class="box">
                        <div class="box-header">
                          <h3 class="box-title">Mis reconocimientos subidos</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body no-padding">
                          <div class="box-footer">
                            <ul class="mailbox-attachments clearfix">
                              <?php for ($i = 0; $i < sizeof($misRecx); $i++) {
                                $Formato = $misRecx[$i]['Formato']; ?>
                                <li id="rec_<?php echo $misRecx[$i]['IdReconocimiento']; ?>" style="height: 200px; cursor: pointer;" onclick="ver_reconocimiento(<?php echo $misRecx[$i]['IdReconocimiento']; ?>)" href="javascript:void(0);">
                                  <?php if ($Formato == 'pdf') { ?>
                                    <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                                  <?php } else { ?>
                                    <span class="mailbox-attachment-icon has-img"><img style="height: 130px;" src="assets/docs/files/<?php echo $misRecx[$i]['Anio']; ?>/<?php echo $misRecx[$i]['Mes']; ?>/<?php echo $misRecx[$i]['Archivo']; ?>" alt="Attachment"></span>
                                  <?php } ?>
                                  <div class="mailbox-attachment-info">
                                    <span class="mailbox-attachment-size"> <?php echo $misRecx[$i]['Texto']; ?> </span>
                                    <span class="mailbox-attachment-size"><i class="fa fa-calendar"></i> <?php echo obtenerFechaCorta($misRecx[$i]['Fecha']); ?></span>
                                  </div>
                                </li>
                              <?php } ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </form>


                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>


      <div id="dataEncRec" class="modal fade"> <!--MODAL ME GUSTA-->
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-fw fa-trophy"></i> <b id="_prex"></b></h4>
            </div>
            <div class="modal-body" id="employee_EncRec">
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include("footer.php"); ?>
  </div>
  <!-- ./wrapper -->
  <!-- ./wrapper -->
  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- FastClic

<script src="bower_components/fastclick/lib/fastclick.js"></script>
 AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Bootstrap WYSIHTML5 -->

  <script>
    function ver_reconocimiento(IdReconocimiento) {
      $.ajax({
        url: "formConsulta/ver_reconocimiento_asesor.php",
        method: "POST",
        data: {
          IdReconocimiento: IdReconocimiento
        },
        success: function(data) {
          $('#employee_EncRec').html(data);
          $('#dataEncRec').modal('show');
        }
      });
    }

    $(function() {
      $('#txt_fecha').datepicker({
        autoclose: true
      })
    })

    $(document).ready(function() {
      var alerta = document.frm.Alerta.value;
      if (alerta) {
        if (alerta == "0") {
          swal("Error", "Error no se puede Guardar", "error");
        }
        if (alerta == "1") {
          swal("Subido correctamente", "El reconocimiento se ha guardado correctamente.", "success");
        }
      }
    });
  </script>
</body>

</html>
<?php unset($_SESSION['Alerta']);  ?>