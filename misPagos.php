<?php $section = "Mis Pagos";
include("head.php");
$var = 7;
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en Mis Pagos');
}

$chkDeuda = $t->get_chkDeuda($_SESSION['IdUsua']);

$t->get_chk_beca_alumno_id($_SESSION['IdUsua']);
$chkPago = $t->get_chkPago($_SESSION['IdUsua']);
$misPagAprob = $t->get_pagAprobados($_SESSION['IdUsua']);
$misPagos = $espacio->get_misPagos($_SESSION['IdUsua']);

$datFactura = $t->get_datosFactura($_SESSION['IdUsua']);
$datosUser = $t->get_datosUser($_SESSION['IdUsua']);
$hoy = date("Y-m-d");
$donacion = $t->get_donacion_id($_SESSION['IdUsua']);

?>
<style>
  .switch-sm {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    font-size: 13px;
    color: #111827;
  }

  /* ocultar checkbox real */
  .switch-sm input {
    display: none;
  }

  /* track */
  .switch-sm .slider {
    position: relative;
    width: 44px;
    height: 18px;
    background: #6062bc;
    /* azul */
    border-radius: 999px;
    transition: background 0.25s ease;
  }

  /* thumb */
  .switch-sm .slider::before {
    content: "";
    position: absolute;
    top: 2px;
    left: 27px;
    width: 14px;
    height: 14px;
    background: #fff;
    border-radius: 50%;
    transition: transform 0.25s ease;
  }

  /* estado apagado */
  .switch-sm input:not(:checked)+.slider {
    background: #d1d5db;
  }

  .switch-sm input:not(:checked)+.slider::before {
    transform: translateX(-22px);
  }

  /* texto */
  .switch-sm .label-text {
    user-select: none;
  }
</style>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Mis pagos
        </h1>
        <ol class="breadcrumb">
          <li><a href="espacioUser.php"><i class="fa fa-dashboard"></i> Mi espacio</a></li>
          <li class="active"> Mis pagos </li>
        </ol>
      </section>
      <section class="content">
        <div class="kx-page">
          <div class="kx-layout">
            <?php include("espacioAlumno.php");  ?>
            <section class="pay-page">
              <div class="paytabs-card">

                <!-- Header con Tabs -->
                <div class="paytabs-header">

                  <div class="paytabs-title-area">
                    <div class="paytabs-icon">💳</div>
                    <div>
                      <div class="paytabs-title">Estatus financiero </div>
                      <div class="paytabs-sub">Espacio para poder ver los pagos pendientes, aprobados y solicitud de documentos</div>
                    </div>
                  </div>
                </div>

                <!-- Contenido -->
                <div class="paytabs-content">
                  <?php if ((isset($_GET["x"])) && ($_GET["x"] == "x")) { ?>
                    <blockquote style="color:red;">
                      <p style="color:red;"><i class="fa fa-fw fa-warning"></i> Cuenta suspendida</p>
                      <small style="color:red;">Su cuenta esta temporalmente suspendida, favor de verificar sus pagos pendientes para poder acceder a sus materias.</small>
                    </blockquote>
                  <?php } ?>
                  <div class="paypanel is-active" data-content="pendientes">
                    <form class="form-horizontal" name="frm" id="frm" action="misPagos.php" method="POST" enctype="multipart/form-data">
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Mis pagos pendientes</a></li>
                          <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Mis pagos aprobados</a></li>
                          <li class=""><a style="cursor: pointer;" onclick="solicitarDocs(<?php echo $_SESSION['IdUsua']; ?>)" href="#solicitud" data-toggle="tab" aria-expanded="false">Solicitar documentos</a></li>
                        </ul>

                        <div class="tab-content">
                          <div class="tab-pane active" id="activity">
                              <?php if(isset($donacion[0])){ ?><hr>
                              <button onclick="javascript:window.open('repositorio/formatos/donacion.php?idToks=<?php echo $donacion[0]['Code']; ?>');" href="javascript:void(0);" style="margin-left: 5px;" type="button" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-cloud-download"></i> Descargar oficio de donaci&oacute;n </button>
                              <br>
                              <?php } ?>
                            <blockquote style="color: green;">
                              <p><i class="fa fa-fw fa-check-circle"></i> Evite recargos</p>
                              <small style="color: green;">Realice los pagos oportunos los <b>primeros 5 días de cada mes</b> para evitar recargos.</b></small>
                            </blockquote>

                            <table class="docs-table" aria-label="Tabla de pagos pendientes">
                              <thead>
                                <tr>
                                  <th style="width:120px;">Acción</th>
                                  <th>Facturar</th>
                                  <th>Concepto de pago</th>
                                  <th>Fecha límite</th>
                                  <th style="text-align:right;">Importe</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $v = 0;
                                $importe = 0;
                                $pp = 0;
                                for ($i = 0; $i < sizeof($misPagos); $i++) {
                                  if ($misPagos[$i]["IdConcepto"] <= 3) {
                                    $pp = ($pp + 1);
                                  }
                                  $fecha = '';
                                  $Id = $misPagos[$i]["IdPago"];
                                  $nomMat = '';
                                  if (isset($misPagos[$i]["IdModulo"])) {
                                    $miMatx = $espacio->get_misMat($misPagos[$i]["IdModulo"]);
                                    $nomMat = ' - ' . $miMatx[0]['NombreMod'];
                                  }
                                  $importe = ($misPagos[$i]["Monto"] + $misPagos[$i]["Recargos"] - $misPagos[$i]["TotalPagado"] - $misPagos[$i]["Descuento"] - $misPagos[$i]["Descuento2"]);
                                ?>
                                  <tr>
                                    <td>
                                      <div class="pay-actions" style="cursor: pointer;">
                                        <a class="pay-btn is-ghost" onclick="javascript:window.open('repositorio/pdf/boucherId.php?tokenId=<?php echo time() . $misPagos[$i]['IdPago']; ?>');" href="javascript:void(0);" title="Descargar boucher de pago"><i class="fa fa-fw fa-cloud-download"></i></a>
                                        <a class="pay-btn" onclick="subir_mi_pago(<?php echo $misPagos[$i]['IdPago']; ?>,1)" title="Subir comprobante"><i class="fa fa-fw fa-wechat"></i></a>
                                        <?php if ($pp <= 1) {
                                          $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                          $longitud = 25;
                                          $IdToks =  substr(str_shuffle($caracteres_permitidos), 0, $longitud) . $misPagos[$i]["IdPago"];
                                          $no = strlen($misPagos[$i]["IdPago"]);
                                          $cadena = $no . $IdToks . $misPagos[$i]["IdPago"] . time();
                                        ?>
                                          <a class="pay-btn is-blue" onClick="window.open('procesar_pago.php?idToks=<?php echo $cadena; ?>','_self')" title="Pagar en línea"><i class="fa fa-fw fa-shopping-cart"></i></a>
                                        <?php } ?>
                                      </div>
                                    </td>
                                    <td class="pay-date">
                                      <label class="switch-sm">
                                        <input type="checkbox" class="js-toggle-estatus" data-idpago="<?php echo (int)$misPagos[$i]["IdPago"]; ?>" <?php echo ($misPagos[$i]["Facturar"] === 'SI') ? 'checked' : ''; ?>>
                                        <span class="slider"></span>
                                      </label>
                                    </td>
                                    <td>
                                      <div class="pay-concept">
                                        <div class="pay-concept-title" style="text-transform: uppercase;"><?php if($misPagos[$i]["Fecha"] < $hoy) { ?><i style="color: red;" title="Pago con recargo" class="fa fa-fw fa-warning"></i><?php } ?> <?php echo $misPagos[$i]["NomPlan"] . $nomMat; ?> <?php echo obtenerAnioMes($misPagos[$i]["Fecha"]); ?></div>
                                      </div>
                                    </td>
                                    <td class="pay-date"><?php if($misPagos[$i]["Fecha"] < $hoy) { ?><i style="color: red;" title="Pago con recargo" class="fa fa-fw fa-warning"></i><?php } ?> <?php echo obtenerFechaCorta($misPagos[$i]["Fecha"]); ?></td>
                                    <td class="pay-amount">$ <?php echo number_format($importe, 2, '.', ','); ?></td>
                                  </tr><?php } ?>
                              </tbody>
                            </table>
                            <div class="box-footer">
                              <button type="button" onclick="datos_factura_id(<?php echo $_SESSION['IdUsua']; ?>)" class="btn bg-purple btn-flat pull-right"><i class="fa fa-fw fa-edit"></i> Datos de facturación</button>
                              <button type="button" onclick="javascript:window.open('repositorio/pdf/saldoTotal.php?tokenId=<?php echo time() . time() . $_SESSION['IdUsua']; ?>');" href="javascript:void(0);" style="margin-right: 10px;" class="btn bg-orange btn-flat pull-right"><i class="fa fa-fw fa-file-pdf-o"></i> Adeudo actual </button>
                            </div>
                          </div>
                          <!-- /.tab-pane -->
                          <div class="tab-pane" id="timeline">
                            <table class="docs-table" aria-label="Tabla de pagos aprobados">
                              <thead>
                                <tr>
                                  <th style="text-align: center;">Recibo</th>
                                  <th style="text-align: center;">Factura</th>
                                  <th>Folio</th>
                                  <th>Fecha pago</th>
                                  <th>Fecha captura</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php for ($c = 0; $c < sizeof($misPagAprob); $c++) { ?>
                                  <tr>
                                    <td style="text-align: center;">
                                      <a class="pay-btn" onclick="javascript:window.open('repositorio/pdf/comprobante.php?idToks=<?php echo time() . $misPagAprob[$c]['NoFolio']; ?>');" href="javascript:void(0);" title="Descargar ficha"> <i class="fa fa-fw fa-cloud-download"></i> </a>
                                    </td>
                                    <td style="text-align: center;">
                                      <?php $misPagAprob[$c]["_tipo"];
                                      if (($misPagAprob[$c]["Factura"] == 3) && ($misPagAprob[$c]["_tipo"] <> 'G')) {
                                        $_ani = substr($misPagAprob[$c]["Fecha"], 0, 4);
                                        $_mes = substr($misPagAprob[$c]["Fecha"], 5, 2);
                                      ?>
                                        <a class="pay-btn is-blue" onclick="javascript:window.open('repositorio/pdf/mi_factura.php?idToks=<?php echo $misPagAprob[$c]['_codigoFactura']; ?>');" href="javascript:void(0);" href="javascript:void(0);" title="Descargar PDF"> PDF </a>
                                        <a class="pay-btn is-blue" onclick="javascript:window.open('dashboard/descargar_xml.php?idToks=<?php echo $misPagAprob[$c]['_folio']; ?>&url=<?php echo $_ani . '/' . $_mes; ?>');" href="javascript:void(0);" title="Descargar XML"> XML </a>
                                      <?php } else {
                                        echo "-----";
                                      } ?>
                                    </td>
                                    <td><?php echo $misPagAprob[$c]["NoFolio"]; ?></td>
                                    <td><?php echo obtenerFechaCorta($misPagAprob[$c]["FecPago"]); ?></td>
                                    <td><?php echo $misPagAprob[$c]["FecCap"]; ?></td>

                                  </tr><?php } ?>
                              </tbody>
                            </table>
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


    </div>
    <div id="dataDocs" class="modal fade">
      <!--MODAL ME GUSTA-->
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Solicitud de documentos</h4>
          </div>
          <div class="modal-body" id="employee_docs">
          </div>
        </div>
      </div>
    </div>
    <div id="data_pag" class="modal fade">
      <!--MODAL ME GUSTA-->
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-fw fa-file"></i> Comprobante de pago</h4>
          </div>
          <div class="modal-body" id="employee_pag">
          </div>
        </div>
      </div>
    </div>

    <div id="dataModal" class="modal fade">
      <!--MODAL ME GUSTA-->
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Solicitud de documentos</h4>
          </div>
          <div class="modal-body" id="employee_detail">
          </div>
        </div>
      </div>
    </div>
    <div id="data_facx" class="modal fade">
      <!--MODAL ME GUSTA-->
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-fw fa-child"></i> Datos de facturación</h4>
          </div>
          <div class="modal-body" id="employee_facx">
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
  <!-- FastClic
<script src="bower_components/fastclick/lib/fastclick.js"></script> -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Bootstrap WYSIHTML5 -->

  <script>
    function val_delComprobante(Id) {
      swal({
          title: "Est\u00E1 seguro que desea eliminar este comprobante de pago?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Aceptar',
          cancelButtonText: "Cancelar",
        },
        function(isConfirm) {
          if (isConfirm) {
            var Idxrf = document.getElementById("IdUsua").value;
            $.ajax({
              url: "formConsulta/delComprobante.php",
              method: "POST",
              data: {
                Id: Id,
                Idxrf: Idxrf
              },
              success: function(data) {
                var valor = 0;
                valor = data;
                if (valor == 1) {
                  document.getElementById(Id).style.display = 'none';
                  swal("Eliminado", "Comprobante eliminado correctamente.", "success");
                } else {
                  swal("Error", "No se puede eliminar el comprobante.", "error");
                }
              }
            });
            //  return true;
          } else {
            return false;
          }
        });
    }

    $(document).ready(function() {
      $(document).on('click', '.view_data', function() {
        var employee_id = $(this).attr("id");
        //var IdAsignacion = document.getElementById("Id").value;
        if (employee_id != '') {
          $.ajax({
            url: "formConsulta/viewDocumento.php",
            method: "POST",
            data: {
              employee_id: employee_id
            },
            success: function(data) {
              $('#employee_detail').html(data);
              $('#dataModal').modal('show');
            }
          });
        }
      });
    });

    function solicitarDocs(IdUsua) {
      $.ajax({
        url: "formConsulta/solicitarDocs.php",
        method: "POST",
        data: {
          IdUsua: IdUsua
        },
        success: function(data) {
          $('#employee_docs').html(data);
          $('#dataDocs').modal('show');
        }
      });
    }

    function subir_mi_pago(IdPago, TipoPago) {
      var Tipo = 2;
      $.ajax({
        url: "formConsulta/seguimiento_pago.php",
        method: "POST",
        data: {
          IdPago: IdPago,
          Tipo: Tipo,
          TipoPago: TipoPago
        },
        success: function(data) {
          $('#employee_pag').html(data);
          $('#data_pag').modal('show');
        }
      });
    }

    function validar_file(obj, nombre) {
      var uploadFile = obj.files[0];
      if (!window.FileReader) {
        swal("Error", "El navegador no soporta la lectura de archivos.", "error");
        return;
      }

      if (!(/\.(pdf|docx|doc|jpg|jpeg|png)$/i).test(uploadFile.name)) {
        swal("Error de archivo", "Porfavor, cargue solamente archivo .pdf | .jpg | .png", "error");
        document.getElementById(nombre).value = '';
        document.getElementById(nombre).focus();
      } else {
        var img = new Image();
        if (uploadFile.size > 10000000) {
          swal("Error", "El peso del archivo debe ser menos a 10 MB.", "error");
          document.getElementById(nombre).value = '';
          document.getElementById(nombre).focus();
        }
      }
    }

    function datos_factura_id(IdUsua) {
      $.ajax({
        url: "vistas/finanzas/datos_factura_id.php",
        method: "POST",
        data: {
          IdUsua: IdUsua
        },
        success: function(data) {
          $('#employee_facx').html(data);
          $('#data_facx').modal('show');
        }
      });
    }
  </script>


  <script>
    // Si usas DataTables, usa delegation porque la tabla se re-renderiza.
    $(document).on('change', '.js-toggle-estatus', function() {
      const $chk = $(this);
      const idpago = $chk.data('idpago');
      const nuevo = $chk.is(':checked') ? 'SI' : 'NO';

      // Evitar doble click mientras guarda
      $chk.prop('disabled', true);

      $.ajax({
        url: 'ajax/facturar_toggle_estatus.php', // AJUSTA LA RUTA
        type: 'POST',
        dataType: 'json',
        data: {
          idpago: idpago,
          Estatus: nuevo
        },
        success: function(res) {
          if (!res || res.ok !== true) {
            // Revertir visualmente
            $chk.prop('checked', !$chk.is(':checked'));
            swal("Error", res.msg || "No se pudo actualizar el estatus.", "error");
          }
        },
        error: function() {
          // Revertir visualmente
          $chk.prop('checked', !$chk.is(':checked'));
          swal("Error de conexión", "Intenta de nuevo.", "error");
        },
        complete: function() {
          $chk.prop('disabled', false);
        }
      });
    });
  </script>

</body>

</html>
