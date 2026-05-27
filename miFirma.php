<?php
$section = "Mis Documentos";
include("head.php");

$var = 11;

if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en Mis Documentos');
}

$datosUser = $t->get_datosUser($_SESSION['IdUsua']);

/**
 * Validación de firma existente
 */
$firmaUsuario = '';

if (!empty($datosUser[0]['id_paquete'])) {
  $firmaUsuario = 'assets/firma/' . $datosUser[0]['id_paquete'];
}
?>

<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">

  <div class="wrapper">

    <?php include("menuV.php"); ?>

    <div class="content-wrapper">

      <section class="content-header">
        <h1>Mis documentos</h1>

        <ol class="breadcrumb">
          <li>
            <a href="espacioUser.php">
              <i class="fa fa-dashboard"></i> Mi espacio
            </a>
          </li>
          <li class="active">Mi firma</li>
        </ol>
      </section>

      <section class="content">

        <div class="kx-page">
          <div class="kx-layout">

            <!-- SIDEBAR -->
            <?php include("espacioAlumno.php"); ?>

            <section class="pay-page">

              <div class="paytabs-card">

                <input type="hidden" name="idUsua" id="idUsua" value="<?php echo $_SESSION['IdUsua']; ?>">

                <!-- Sección Firma -->
                <div style="padding: 15px 20px; text-align: center;">

                  <div class="paytabs-header" style="margin-bottom: 15px;">
                    <div class="paytabs-title-area">

                      <div class="paytabs-icon">✍️</div>

                      <div>
                        <div class="paytabs-title">Mi firma digital</div>

                        <div class="paytabs-sub">
                          <?php
                          if (!empty($firmaUsuario) && file_exists($firmaUsuario)) {
                            echo "Firma registrada para documentos y autorizaciones";
                          } else {
                            echo "No hay ninguna firma registrada para documentos y autorizaciones";
                          }
                          ?>
                        </div>
                      </div>

                    </div>
                  </div>

                  <?php if (!empty($firmaUsuario) && file_exists($firmaUsuario)) { ?>

                    <div style="display: inline-block; border: 1px solid #ddd; padding: 12px; background: #fff; border-radius: 8px;">
                      <img src="<?php echo $firmaUsuario; ?>"
                        alt="Firma del usuario"
                        style="max-width: 320px; width: 100%; height: auto;">
                    </div>
                    <hr>
                    <div style="margin-top: 15px; text-align: left; background: #f9f9f9; border: 1px solid #ddd; padding: 12px; border-radius: 6px;">

                      <label style="font-weight: normal; cursor: pointer; margin-bottom: 0; display: flex; align-items: flex-start; gap: 8px;">
                        <input type="checkbox" checked disabled style="margin-top: 3px;">

                        <span>
                          Acepto que mi firma digital sea utilizada para firmar documentos, autorizaciones y trámites relacionados con mi expediente académico. (<?php echo $datosUser[0]['fecha_firma'] ?>)
                        </span>

                      </label>

                    </div>

                    <br><br>

                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalFirma">
                      <i class="fa fa-pencil"></i> Actualizar firma
                    </button>

                  <?php } else { ?>

                    <div style="padding: 15px; background: #f9f9f9; border: 1px dashed #ccc; border-radius: 8px;">

                      <p class="text-muted" style="margin-bottom: 10px;">
                        Aún no tienes firma registrada.
                      </p>

                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFirma">
                        <i class="fa fa-pencil"></i> Registrar firma
                      </button>

                    </div>

                  <?php } ?>

                </div>

              </div>

            </section>

          </div>
        </div>

      </section>

    </div>

    <!-- Modal Firma -->
    <div class="modal fade" id="modalFirma" tabindex="-1" role="dialog" aria-labelledby="modalFirmaLabel" aria-hidden="true">

      <div class="modal-dialog" role="document">

        <div class="modal-content">

          <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <h4 class="modal-title">
              <i class="fa fa-fw fa-unlock-alt"></i> Mi firma digital
            </h4>
          </div>

          <div class="modal-body">

            <p class="text-muted">
              Firma dentro del recuadro usando el mouse o tu dedo si estás en celular.
            </p>

            <div style="border: 2px dashed #999; width: 100%; height: 250px; touch-action: none;">
              <canvas id="canvasFirma" style="width: 100%; height: 250px;"></canvas>
            </div>

            <input type="hidden" id="firmaBase64" name="firmaBase64">

            <!-- Checkbox de aceptación -->
            <div style="margin-top: 15px; text-align: left; background: #f9f9f9; border: 1px solid #ddd; padding: 12px; border-radius: 6px;">

              <label style="font-weight: normal; cursor: pointer; margin-bottom: 0; display: flex; align-items: flex-start; gap: 8px;">

                <input type="checkbox"
                  id="chkAceptarFirma"
                  name="chkAceptarFirma"
                  value="1"
                  style="margin-top: 3px;">

                <span>
                  Acepto que mi firma digital sea utilizada para firmar documentos, autorizaciones y trámites relacionados con mi expediente académico.
                </span>

              </label>

            </div>

          </div>

          <div class="modal-footer">

            <button type="button" class="btn btn-secondary" id="btnLimpiarFirma">
              Limpiar
            </button>

            <button type="button" class="btn btn-success" id="btnGuardarFirma">
              Guardar firma
            </button>

          </div>

        </div>

      </div>

    </div>

    <?php include("footer.php"); ?>

  </div>

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>

  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>

  <script>
    let canvas = document.getElementById('canvasFirma');
    let ctx = canvas.getContext('2d');

    let dibujando = false;
    let hayFirma = false;

    function ajustarCanvas() {
      let rect = canvas.getBoundingClientRect();

      canvas.width = rect.width;
      canvas.height = rect.height;

      ctx.lineWidth = 2;
      ctx.lineCap = 'round';
      ctx.strokeStyle = '#000';
    }

    $('#modalFirma').on('shown.bs.modal', function() {
      ajustarCanvas();
    });

    $('#modalFirma').on('hidden.bs.modal', function() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      hayFirma = false;
      dibujando = false;

      document.getElementById('chkAceptarFirma').checked = false;
    });

    window.addEventListener('resize', ajustarCanvas);

    function obtenerPosicion(e) {
      let rect = canvas.getBoundingClientRect();

      if (e.touches && e.touches.length > 0) {
        return {
          x: e.touches[0].clientX - rect.left,
          y: e.touches[0].clientY - rect.top
        };
      } else {
        return {
          x: e.clientX - rect.left,
          y: e.clientY - rect.top
        };
      }
    }

    function iniciarDibujo(e) {
      e.preventDefault();

      dibujando = true;
      hayFirma = true;

      let pos = obtenerPosicion(e);

      ctx.beginPath();
      ctx.moveTo(pos.x, pos.y);
    }

    function dibujar(e) {
      if (!dibujando) return;

      e.preventDefault();

      let pos = obtenerPosicion(e);

      ctx.lineTo(pos.x, pos.y);
      ctx.stroke();
    }

    function terminarDibujo(e) {
      e.preventDefault();
      dibujando = false;
    }

    canvas.addEventListener('mousedown', iniciarDibujo);
    canvas.addEventListener('mousemove', dibujar);
    canvas.addEventListener('mouseup', terminarDibujo);
    canvas.addEventListener('mouseleave', terminarDibujo);

    canvas.addEventListener('touchstart', iniciarDibujo, {
      passive: false
    });

    canvas.addEventListener('touchmove', dibujar, {
      passive: false
    });

    canvas.addEventListener('touchend', terminarDibujo, {
      passive: false
    });

    document.getElementById('btnLimpiarFirma').addEventListener('click', function() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      hayFirma = false;
    });

    let IdUsua = document.getElementById('idUsua').value;

    document.getElementById('btnGuardarFirma').addEventListener('click', function() {

      if (!hayFirma) {
        swal("Firma requerida", "Primero debes realizar la firma.", "warning");
        return;
      }

      if (!document.getElementById('chkAceptarFirma').checked) {
        swal("Aceptación requerida", "Debes aceptar el uso de tu firma digital para continuar.", "warning");
        return;
      }

      let firmaImagen = canvas.toDataURL('image/png');

      $.ajax({
        url: 'ajax/guardar_firma.php',
        type: 'POST',
        dataType: 'json',
        data: {
          firma: firmaImagen,
          IdUsua: IdUsua,
          aceptaFirma: 1
        },
        beforeSend: function() {
          $('#btnGuardarFirma').prop('disabled', true).text('Guardando...');
        },
        success: function(response) {

          if (response.status === 'success') {

            swal({
              title: "Firma guardada",
              text: "La firma se guardó correctamente.",
              icon: "success",
              button: "Aceptar"
            }).then(function() {
              $('#modalFirma').modal('hide');
              location.reload();
            });

          } else {

            swal("Error al guardar", response.message, "error");

          }

        },
        error: function() {
          swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
        },
        complete: function() {
          $('#btnGuardarFirma').prop('disabled', false).text('Guardar firma');
        }
      });

    });
  </script>

</body>

</html>

<?php unset($_SESSION['Alerta']); ?>