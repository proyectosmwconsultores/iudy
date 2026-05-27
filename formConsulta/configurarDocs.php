<?php
session_start();
include('../hace.php');
if (isset($_POST["IdUsua"])) {
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];

  $sql9 = $db->query("SELECT tblc_usuario.Grado FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $_grado = $datos91["Grado"];
  $docs = $db->query("SELECT * FROM tblh_tipodocumento WHERE tblh_tipodocumento.IdEstatus = '8' AND tblh_tipodocumento.Grado = '$_grado'");
  while ($_docs = $db->recorrer($docs)) {
    $_idTipoD = $_docs['IdTipoDoc'];

    $sqlx = $db->query("SELECT tblp_documentos.IdDocumento FROM tblp_documentos WHERE tblp_documentos.IdUsua = '$IdUsua' AND tblp_documentos.IdTipoDocumento = '$_idTipoD'");
    $db->rows($sqlx);
    $dxs = $db->recorrer($sqlx);
    $_idDocx = $dxs["IdDocumento"];
    if (!$_idDocx) {
      $sql = $db->query("INSERT INTO tblp_documentos (IdUsua, IdTipoDocumento) VALUES ('$IdUsua','$_idTipoD') ");
    }
  }

  $sql = $db->query("SELECT
tblp_documentos.IdDocumento,
tblp_documentos.Fecha_original,
tblp_documentos.Fecha_copia,
tblp_documentos.IdUsua,
tblp_documentos.Si,
tblp_documentos.`No`,
tblp_documentos.Co,
tblp_documentos.Co,
tblp_documentos.IdUsua_original,
tblp_documentos.IdUsua_copia,
tblh_tipodocumento.Nombre,
Original.Nombre AS ONombre,
Original.APaterno AS OPaterno,
Original.AMaterno AS OMaterno,
Copia.Nombre AS CNombre,
Copia.APaterno AS CPaterno,
Copia.AMaterno AS CMaterno
FROM
tblp_documentos
Left Join tblh_tipodocumento ON tblh_tipodocumento.IdTipoDoc = tblp_documentos.IdTipoDocumento
Left Join tblc_usuario AS Original ON Original.IdUsua = tblp_documentos.IdUsua_original
Left Join tblc_usuario AS Copia ON Copia.IdUsua = tblp_documentos.IdUsua_copia WHERE tblp_documentos.IdUsua =  '$IdUsua' AND tblh_tipodocumento.IdEstatus = '8'");

  $sql_87 = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '" . $_SESSION['IdUsua'] . "' AND tblc_modulousuario.IdModulo = '87'");
  $db->rows($sql_87);
  $_mod87 = $db->recorrer($sql_87);



?>
  <form name="frm" id="frm" action="configurarDocs.php" method="POST" enctype="multipart/form-data" class="form-horizontal">


    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <table class="table table-striped">
            <tbody>
              <tr>
                <th rowspan="2"><br>NOMBRE DEL DOCUMENTO </th>
                <th colspan="3" style="text-align: center;">ENTREGÓ</th>
              </tr>
              <tr>
                <th style="text-align: center;">ORIGINAL</th>
                <th style="text-align: center;">COPIAS</th>
              </tr>
              <?php while ($x = $db->recorrer($sql)) { ?>
                <tr>
                  <td><?php echo $x["Nombre"]; ?></td>
                  <td style="font-size: 11px;">
                    <?php if ($x["Si"] == 1) { ?>
                      <i style="color: blue;" class="fa fa-fw fa-check-circle"></i> Recibido<br>
                      <?php if (isset($x["Fecha_copia"])) { ?> <i style="color: blue;" class="fa fa-fw fa-calendar"></i> <?php echo $x["Fecha_original"]; ?> <?php } ?><br>
                      <?php if (isset($x["IdUsua_original"])) { ?> <i style="color: blue;" class="fa fa-fw fa-user"></i> <?php echo $x["ONombre"]; ?> <?php echo $x["OPaterno"]; ?> <?php } ?>
                      <!-- <button onclick="saveDoc(<?php echo $x['IdDocumento']; ?>,'Si',0,<?php echo $IdUsua; ?>)" type="button" class="btn btn-info"><i class="fa fa-fw fa-check-circle"></i> SI</button> -->
                    <?php } else { ?>
                      <?php if (isset($_mod87[0])) { ?>
                        <button onclick="saveDoc(<?php echo $x['IdDocumento']; ?>,'Si',1,<?php echo $IdUsua; ?>,<?php echo $_SESSION['IdUsua']; ?>)" type="button" class="btn btn-danger"><i class="fa fa-fw fa-times-circle"></i> NO</button>
                      <?php } else {
                        echo "<p style='text-align: center;'> - - - - - - - - - - - - - - </p>";
                      } ?>
                    <?php } ?>
                  </td>
                  <td style="font-size: 11px;">
                    <?php if ($x["Co"] == 1) { ?>
                      <i style="color: blue;" class="fa fa-fw fa-check-circle"></i> Recibido<br>
                      <?php if (isset($x["Fecha_copia"])) { ?> <i style="color: blue;" class="fa fa-fw fa-calendar"></i> <?php echo $x["Fecha_copia"]; ?> <?php } ?><br>
                      <?php if (isset($x["IdUsua_copia"])) { ?> <i style="color: blue;" class="fa fa-fw fa-user"></i> <?php echo $x["CNombre"]; ?> <?php echo $x["CPaterno"]; ?> <?php } ?>

                      <!-- <button onclick="saveDoc(<?php echo $x['IdDocumento']; ?>,'Co',0,<?php echo $IdUsua; ?>)" type="button" class="btn btn-primary"><i class="fa fa-fw fa-check-circle"></i></button> -->
                    <?php } else { ?>
                      <?php if (isset($_mod87[0])) { ?>
                        <button onclick="saveDoc(<?php echo $x['IdDocumento']; ?>,'Co',1,<?php echo $IdUsua; ?>,<?php echo $_SESSION['IdUsua']; ?>)" type="button" class="btn btn-danger"><i class="fa fa-fw fa-times-circle"></i></button>
                      <?php } else {
                        echo "<p style='text-align: center;'> - - - - - - - - - - - - - - </p>";
                      } ?>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>


            </tbody>
          </table>
        </div>


      </div>
    </div>

    <!-- Incluye SweetAlert v1 -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


  </form>
  <script>
    function saveDoc(IdDocumento, Tipo, Valor, IdUsua, IdAdmin) {
      var TipoGuardar = "sav_documentos_entregados";

      swal({
        title: "Fecha de recepción",
        text: "Seleccione una fecha en la que se recibio el documento:",
        content: {
          element: "div",
          attributes: {
            id: "customInputContainer"
          }
        },
        buttons: {
          cancel: "Cancelar",
          confirm: {
            text: "Guardar",
            closeModal: false
          }
        }
      }).then((isConfirm) => {
        if (isConfirm) {
          let fechaSeleccionada = document.getElementById("fechaInput").value;
          if (!fechaSeleccionada) {
            swal("Error", "Debe ingresar una fecha", "error");
            return;
          }

          $.ajax({
              url: "formConsulta/setting.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                IdDocumento: IdDocumento,
                Tipo: Tipo,
                Valor: Valor,
                Fecha: fechaSeleccionada,
                IdAdmin: IdAdmin
              },
              success: function(data) {}
            })
            .done(function(data) {

              if (data == 1) {
                swal("Aceptado correctamente", "El documento ya fue aprobado correctamente.", "success");
                $.ajax({
                  url: "formConsulta/configurarDocs.php",
                  method: "POST",
                  data: {
                    IdUsua: IdUsua
                  },
                  success: function(data) {
                    $('#employee_detailModFue').html(data);
                    $('#dataModalModFue').modal('show');
                  }
                });
              }

              if (data == 0) {
                swal("Error al guardar", "No se puede eliminar, verifique sus datos.", "error");
              }
            })
            .error(function(data) {
              swal("Error al guardar 0x21", "No se puede guardar, comuniquese con el desarrollador.", "error");
            });
        }
      });

      // Agregar manualmente el input de fecha después de que se abre la alerta
      setTimeout(() => {
        let inputFecha = document.createElement("input");
        inputFecha.setAttribute("type", "date");
        inputFecha.setAttribute("id", "fechaInput");
        inputFecha.setAttribute("class", "swal-content__input");
        document.querySelector(".swal-text").appendChild(inputFecha);
      }, 100);
    }
  </script>

<?php
}
?>