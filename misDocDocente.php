<?php $section = "Mis documentos";
include("head.php");
$var = 4;
if (($_SESSION['IdUsua']) && ($_SESSION['Permisos'] == 2)) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de mis documentos');
}
$datosUser = $t->get_docente_id($_SESSION['IdUsua']);
$tipoDocumentos = $espacio->get_tipoDocC($_SESSION['IdUsua'], 2);
$misDocumentos = $espacio->get_misDocumentos($_SESSION['IdUsua']);
$misDocAceptados = $espacio->get_misDocAcept($_SESSION['IdUsua']);


if (isset($_POST["Mov"]) && $_POST["Mov"] == "SubDocumento") {
  $espacio->add_documentoDoc();
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
          <i class="fa fa-fw fa-black-tie"></i> Mis documentos
        </h1>
        <ol class="breadcrumb">
          <li><a href="espacioUsuario.php"><i class="fa fa-bell"></i> Mi espacio</a></li>
          <li class="active"> Mis documentos</li>
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
                    <div class="paytabs-icon">📄</div>
                    <div>
                      <div class="paytabs-title">Mis documentos</div>
                      <div class="paytabs-sub">Consulta los documentos solicitados y aprobados </div>
                    </div>
                  </div>

                  <div class="paytabs-nav" role="tablist">
                    <button class="paytab is-active" data-tab="pendientes">
                      Pendientes
                    </button>

                    <button class="paytab" data-tab="aprobados">
                      Aprobados
                    </button>
                  </div>

                </div>

                <!-- Contenido -->
                <div class="paytabs-content">

                  <div class="paypanel is-active" data-content="pendientes">
                    <!-- AQUÍ TU TABLA DE PENDIENTES -->
                    <form class="form-horizontal" name="frm" id="frm" action="misDocDocente.php" method="POST" enctype="multipart/form-data">
                      <input id="Mov" name="Mov" value="" type="hidden" />
                      <input id="IdUsua" name="IdUsua" value="<?php echo $datosUser[0]["IdUsua"]; ?>" type="hidden" />
                      <input id="Alerta" name="Alerta" value="<?php if (isset($_SESSION['Alerta'])) {
                                                                echo $_SESSION['Alerta'];
                                                              } ?>" type="hidden" />
                      <div class="docs-grid">
                        <div class="docs-field">
                          <label class="docs-label" for="docType">Tipo de documento:</label>
                          <div class="docs-control">
                            <select class="form-control" name="txtTipoDoc" id="txtTipoDoc">
                              <option value=""> - Seleccione - </option>
                              <?php for ($i = 0; $i < sizeof($tipoDocumentos); $i++) { ?>
                                <option value="<?php echo $tipoDocumentos[$i]["IdTipoDocumento"]; ?>"><?php echo $tipoDocumentos[$i]["NomDocumento"]; ?></option>
                              <?php } ?>
                            </select>


                          </div>
                        </div>

                        <div class="docs-field">
                          <label class="docs-label" for="docFile">Buscar:</label>
                          <div class="docs-control">
                            <div class="docs-file">
                              <input id="txtDocumento" name="txtDocumento" class="docs-file-input" type="file" onchange="validarPDF(this,'txtDocumento');">
                              <label class="docs-file-ui" for="docFile">
                                <span class="docs-file-btn">Browse…</span>
                                <span class="docs-file-name" id="docFileName">No file selected</span>
                              </label>
                            </div>

                            <div class="docs-help">
                              <div class="docs-help-line is-info">El archivo puede ser en formato .pdf/.png/.jpg</div>
                              <div class="docs-help-line is-danger">Para la fotografía solo se acepta imagen: .png/.jpg</div>
                            </div>

                          </div>
                        </div>

                      </div>
                      <div class="box-footer">
                        <button name="btnDocDocente" id="btnDocDocente" onClick="add_documento_docente()" type="button" class="btn btn-success pull-right"><i class="fa fa-fw fa-cloud-upload"></i> Guardar archivo</button>
                      </div>

                    </form>
                    <div class="paytabs-header">

                      <div class="paytabs-title-area">
                        <div class="paytabs-icon">💳</div>
                        <div>
                          <div class="paytabs-title">Lista de documentos</div>
                          <div class="paytabs-sub">Estos documentos estan en proceso de revisión </div>
                        </div>
                      </div>
                    </div>
                    <table class="docs-table" aria-label="Documentos en revisión">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Tipo documento</th>
                          <th style="width:180px;">FecCap</th>
                          <th style="width:160px;">Estatus</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i = 0; $i < sizeof($misDocumentos); $i++) {
                          $id = $misDocumentos[$i]["IdDocDocente"];
                          if ($misDocumentos[$i]["Estatus"] == "No Aprobado") {
                            $color = "red";
                          } else {
                            $color = "blue";
                          }
                        ?>
                          <tr>
                            <td class="docs-td-strong">


                              <div class="pay-actions" style="cursor: pointer;">
                                <a class="pay-btn is-ghost" onClick="val_delDocumento(this,<?php echo $id; ?>)" href="javascript:void(0);" title="Descargar ficha"><i class="fa fa-fw fa-trash"></i></a>
                                <a class="pay-btn is-ghost" onClick="window.open('assets/docs/Docentes/<?php echo $misDocumentos[$i]["Anio"]; ?>/<?php echo $misDocumentos[$i]["Mes"]; ?>/<?php echo $misDocumentos[$i]["Archivo"]; ?>','_blank')" href="javascript:void(0);" title="Subir comprobante"><i class="fa fa-fw fa-cloud-download"></i></a>
                              </div>
                            </td>
                            <td class="docs-td-strong"><?php echo $misDocumentos[$i]["NomDocumento"]; ?></td>
                            <td class="docs-td-muted"><?php echo $misDocumentos[$i]["FecCap"]; ?></td>
                            <td><span class="docs-pill is-pending"><?php echo $misDocumentos[$i]["Estatus"]; ?></span></td>
                          </tr><?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="paypanel" data-content="aprobados">
                    <table class="docs-table" aria-label="Documentos en revisión">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Tipo documento</th>
                          <th style="width:180px;">Fecha Captura</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($x = 0; $x < sizeof($misDocAceptados); $x++) { ?>
                          <tr>
                            <td class="docs-td-strong">
                              <div class="pay-actions" style="cursor: pointer;">
                                <a class="pay-btn is-blue" onClick="window.open('assets/docs/Docentes/<?php echo $misDocAceptados[$x]["Anio"]; ?>/<?php echo $misDocAceptados[$x]["Mes"]; ?>/<?php echo $misDocAceptados[$x]["Archivo"]; ?>','_blank')" href="javascript:void(0);" title="Subir comprobante"><i class="fa fa-fw fa-cloud-download"></i></a>
                              </div>
                            </td>
                            <td class="docs-td-strong"><?php echo $misDocAceptados[$x]["NomDocumento"]; ?></td>
                            <td class="docs-td-muted"><?php echo $misDocAceptados[$x]["FecCap"]; ?></td>
                          </tr><?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </section>
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
<script src="bower_components/fastclick/lib/fastclick.js"></script> -->

  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Bootstrap WYSIHTML5 -->

  <script>
    function add_documento_docente() {
      var Tipo = document.getElementById("txtTipoDoc").value;
      var Documento = document.getElementById("txtDocumento").value;
      if (Tipo == "") {
        swal("Error al guardar", "Debe seleccionar el tipo de documento.", "error");
        document.getElementById("txtDocumento").focus();
        return 0;
      }
      if (Documento == "") {
        swal("Error al guardar", "Debe seleccionar el documento.", "error");
        document.getElementById("txtDocumento").focus();
        return 0;
      }

      swal({
          title: "\u00BFEst\u00E1 seguro que desea subir este documento?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Aceptar',
          cancelButtonText: "Cancelar",
        },
        function(isConfirm) {
          if (isConfirm) {
            document.getElementById("btnDocDocente").disabled = true;
            document.frm.Mov.value = 'SubDocumento';
            document.frm.submit();
            return true;
          } else {
            return false;
          }
        });
    }



    $(document).ready(function() {
      var alerta = document.frm.Alerta.value;
      if (alerta) {
        if (alerta == "0") {
          swal("Error", "Error no se puede Guardar", "error");
        }
        if (alerta == "1") {
          swal("Guardado", "Documento guardado con exito", "success");
        }
      }
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const tabs = document.querySelectorAll('.paytab');
      const panels = document.querySelectorAll('.paypanel');

      tabs.forEach(tab => {
        tab.addEventListener('click', function() {

          const target = this.getAttribute('data-tab');

          // reset tabs
          tabs.forEach(t => t.classList.remove('is-active'));
          this.classList.add('is-active');

          // reset panels
          panels.forEach(p => p.classList.remove('is-active'));

          // activate selected panel
          document.querySelector(`.paypanel[data-content="${target}"]`)
            .classList.add('is-active');

        });
      });

    });
  </script>

</body>

</html>
<?php unset($_SESSION['Alerta']);  ?>