<?php
session_start();
include('../hace.php');
require('../php/clases/class.System.php');
$db = new Conexion();
$IdUsua = $_POST["IdUsua"];

$sql_lts = $db->query("SELECT
tblp_expediente_seguimiento.IdSeguimiento,
tblp_expediente_seguimiento.Tipo,
tblp_expediente_seguimiento.Seguimiento,
tblp_expediente_seguimiento.Fecha,
tblp_expediente_seguimiento.FecCap,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto
FROM
tblp_expediente_seguimiento
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_expediente_seguimiento.IdAdmin
WHERE tblp_expediente_seguimiento.IdUsua = '$IdUsua'
ORDER BY
tblp_expediente_seguimiento.FecCap DESC
");

$sql9 = $db->query("SELECT tblc_usuario.Grado FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);
$_grado = $datos91["Grado"];


?>
<div class="box-footer clearfix">
  <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-right">Captura de expediente</a> -->
  <a onclick="mostrar_captura_seguimiento()" href="javascript:void(0)" class="btn btn-sm btn-primary btn-flat pull-right" style="margin-right: 10px;">Seguimiento de expediente</a>

</div>

<div id="div_seguimiento" style="display: none;">
  <form class="form-horizontal" name="sinx" id="sinx">
    <div class="box-body">
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Tipo:</label>

        <div class="col-sm-10">
          <select class="form-control" name="txt_tipo_seguimiento" id="txt_tipo_seguimiento">
          <option value=""> Seleccione </option>
            <option value="Acuse de recepción de documentos físicos">Acuse de recepción de documentos físicos</option>
            <option value="Préstamos de documentos originales">Préstamos de documentos originales</option>
            <option value="Devolución de documentos originales">Devolución de documentos originales</option>
            <option value="Estatus del expediente">Estatus del expediente</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Comentario:</label>
        <div class="col-sm-10">
          <textarea name="txt_seguimiento_exp" id="txt_seguimiento_exp" class="form-control" rows="3" placeholder="Comentario ..."></textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-8 control-label"><b id="titulo">Selecciona una opción</b></label>
        <div class="col-sm-4">
          <input type="text" name="txt_fecha_exp" id="txt_fecha_exp" class="form-control" placeholder="Fecha">
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button onclick="expediente_fisico(<?php echo $IdUsua; ?>)" type="button" class="btn btn-default">Cancelar</button>
      <button onclick="save_seguimiento_expediente(<?php echo $IdUsua; ?>,<?php echo $_SESSION['IdUsua']; ?>)" type="button" class="btn btn-info pull-right"><i class="fa fa-edit"></i> Guardar</button>
    </div>
  </form>
</div>

<div class="box-body">
  <div class="direct-chat-messages">
    <?php while ($x = $db->recorrer($sql_lts)) { ?>
      <div class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-left"><?php echo $x['Nombre']; ?> <?php echo $x['APaterno']; ?> <?php echo $x['AMaterno']; ?> </span>
          <span class="direct-chat-timestamp pull-right"><?php echo formatearFecha($x['FecCap']); ?> </span>
          <span class="direct-chat-timestamp pull-right" style="color: blue; margin-right: 10px;"><i class="fa fa-fw fa-flag"></i> <?php echo $x['Tipo']; ?></span>
        </div>
        <img class="direct-chat-img" src="assets/perfil/<?php echo $x['Foto']; ?>" alt="Message User Image">
        <div class="direct-chat-text">
          <?php echo $x['Seguimiento']; ?> (<?php echo $x['Fecha']; ?>)
        </div>
      </div><?php } ?>
  </div>

</div>

<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>

document.getElementById("txt_tipo_seguimiento").addEventListener("change", function () {
            let titulo = document.getElementById("titulo");
            let seleccion = this.value; // Obtiene el valor seleccionado
            // Si no hay opción seleccionada, mostrar el mensaje por defecto
            if (seleccion === "Acuse de recepción de documentos físicos") {
                titulo.innerText = "Fecha:";
            } else if (seleccion === "Préstamos de documentos originales") {
                titulo.innerText = "Fecha de devolución:";
            } else if (seleccion === "Devolución de documentos originales") {
                titulo.innerText = "Fecha:";
            } else if (seleccion === "Estatus del expediente") {
                titulo.innerText = "Fecha:";
            } else {
                titulo.innerText = "Fecha: ";
            }
        });


    $(function () {
    //Date picker
    $('#txt_fecha_exp').datepicker({
      autoclose: true
    })
  })

  function mostrar_captura_seguimiento() {
    document.getElementById("div_seguimiento").style.display = "block";
  }
</script>
<?php
function formatearFecha($fecha)
{
  // Convertir la fecha a timestamp
  $timestamp = strtotime($fecha);

  // Formato deseado: "23 Enero 2:00 pm"
  $fechaFormateada = date("d F g:i a", $timestamp);

  // Reemplazar nombres de meses en inglés por español
  $meses = [
    'January' => 'de Enero',
    'February' => 'de Febrero',
    'March' => 'de Marzo',
    'April' => 'de Abril',
    'May' => 'de Mayo',
    'June' => 'de Junio',
    'July' => 'de Julio',
    'August' => 'de Agosto',
    'September' => 'de Septiembre',
    'October' => 'de Octubre',
    'November' => 'de Noviembre',
    'December' => 'de Diciembre'
  ];

  foreach ($meses as $en => $es) {
    $fechaFormateada = str_replace($en, $es, $fechaFormateada);
  }

  return $fechaFormateada;
}


?>