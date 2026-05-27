<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();

$IdAsignacion = $_POST["IdAsignacion"];

$sql8 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);

$sql_user = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '" . $datos81['IdUsua'] . "' ");
$db->rows($sql_user);
$_user = $db->recorrer($sql_user);

?>

<div class="box-body">
  <p style="font-size: 20px; color: blue; text-align: center; "><i class="fa fa-fw fa-check-circle"></i> Autorización para el Uso de Firma en la Generación de Contrato y Declaración de Relación Laboral. </p>
  <blockquote>
    <p style="text-align: justify;">
      Yo, <?php echo $_user['Nombre']; ?> <?php echo $_user['APaterno']; ?> <?php echo $_user['AMaterno']; ?>, con identificación de INE <?php echo $_user['_elector']; ?>,
      por medio de la presente autorizo expresamente el uso de mi firma digitalizada y/o electrónica
      para la generación y formalización de mi contrato y declaración de relación laboral.
      <br><br>
      Entiendo que esta autorización tiene como único propósito la formalización del contrato laboral, académico o de prestación de servicios, en conformidad con la normativa vigente.
    </p>

  </blockquote>

  <form>
    <label>
      <?php if ($datos81['aceptado'] == 0) { ?>
        <?php if ($_user['id_paquete']) { ?>
          <input type="checkbox" id="aceptar_firma" required> <?php } ?>
        Acepto el uso de mi firma.
      <?php } else { ?>
        <input type="checkbox" checked disabled required>
        Acepto el uso de mi firma.
      <?php }  ?>
    </label>
    <?php if ($_user['id_paquete']) { ?>
      <p style="float: right;">
        <img src="assets/firma/<?php echo $_user['id_paquete']; ?>" style="width: 120px">
      </p>
    <?php } else { ?>
      <p style="text-align: right; color: red; font-size: 18px;"><b style="color: blue;">NOTA:</b> Primero debe de subir su firma digital.</p>
      <button type="button" onClick="window.open('actualizar_datos.php','_self')" href="javascript:void(0);" class="btn btn-info pull-right"><i class="fa fa-file"></i> Subir mi firma </button>
    <?php } ?>
  </form>
</div>


<?php if ($_user['id_paquete']) { ?>
  <div class="box-footer">
    <button onclick="javascript:window.open('repositorio/portafolio/contrato.php?tokenId=<?php echo $datos81['aceptado']; ?><?php echo $IdAsignacion; ?>');" href="javascript:void(0);" type="button" class="btn btn-warning pull-left"><i class="fa fa-print"></i> Ver mi contrato</button>
    <?php if ($datos81['aceptado'] == 0) { ?>
      <button id="botongenerar" disabled type="button" onClick="aceptar_contrato_id('<?php echo $IdAsignacion; ?>')" class="btn btn-danger pull-right"><i class="fa fa-check"></i> Firmar mi contrato </button>
    <?php } ?>
  </div>
<?php } ?>

<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
  function aceptar_contrato_id(IdAsignacion) {

    var TipoGuardar = "aceptar_contrato";
    swal({
        title: "\u00BFEst\u00E1 seguro de aceptar este contrato para impartir la materia?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
              url: "formConsulta/setting.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                IdAsignacion: IdAsignacion
              },
              success: function(data) {

              }
            })
            .done(function(data) {

              if (data == 1) {
                swal({
                    title: "El contrato se ha firmado correctamente.",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Aceptar',
                  },
                  function(isConfirm) {
                    if (isConfirm) {
                      $(".confirm").attr('disabled', 'disabled');
                      parent.location.href = 'misClases.php';
                      return true;
                    } else {
                      return false;
                    }
                  });
              }

            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        }
      });
  }

  $(function() {
    $('#txt_fecha_contrato').datepicker({
      autoclose: true
    })
  })

  document.getElementById("aceptar_firma").addEventListener("change", function() {
    if (this.checked) {
      document.getElementById("botongenerar").disabled = false;
    } else {
      document.getElementById("botongenerar").disabled = true;
    }
  });
</script>