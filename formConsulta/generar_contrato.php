<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();

$IdAsignacion = $_POST["IdAsignacion"];

$sql8 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);

$sql_contrato = $db->query("SELECT * FROM tblp_contrato WHERE tblp_contrato.IdAsignacion = '$IdAsignacion'");
$db->rows($sql_contrato);
$contrato = $db->recorrer($sql_contrato);
if (!isset($contrato['IdContrato'])) {
  $sql_ins = $db->query("INSERT INTO tblp_contrato (IdAsignacion, IdUsua, Monto, Texto, IdEstatus) VALUES ('$IdAsignacion','" . $datos81['IdUsua'] . "',350,'por hora efectiva de docencia',1) ");
  $sql_contrato = $db->query("SELECT * FROM tblp_contrato WHERE tblp_contrato.IdAsignacion = '$IdAsignacion'");
  $db->rows($sql_contrato);
  $contrato = $db->recorrer($sql_contrato);
}
?>
<form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-6 control-label">Cantidad:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="txt_monto_contrato" name="txt_monto_contrato" value="<?php echo $contrato['Monto']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label">Texto:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="txt_texto_contrato" name="txt_texto_contrato" value="<?php echo $contrato['Texto']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label">Estatus del contrato:</label>
      <div class="col-sm-6">
        <select class="form-control" name="txt_estatus_contrato" id="txt_estatus_contrato">
          <option value="1" <?php if (1 == $contrato['IdEstatus']) { ?>selected="selected" <?php } ?>> PENDIENTE </option>
          <option value="8" <?php if (8 == $contrato['IdEstatus']) { ?>selected="selected" <?php } ?>> ACTIVO </option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">Fecha del contrato:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="txt_fecha_contrato" name="txt_fecha_contrato" value="<?php echo $datos81['_fec_contrato']; ?>">
      </div>
    </div>
  </div>
  <div class="box-footer">
    <button onclick="javascript:window.open('repositorio/portafolio/contrato.php?tokenId=<?php echo $datos81['aceptado']; ?><?php echo $IdAsignacion; ?>');" href="javascript:void(0);" type="button" class="btn btn-warning"><i class="fa fa-print"></i> Imprimir contrato</button>
    <?php if ($contrato['IdEstatus'] == 1) { ?>
      <button type="button" onClick="generera_contrato_id('<?php echo $IdAsignacion; ?>')" class="btn btn-success pull-right"><i class="fa fa-save"></i> Activar contrato</button>
    <?php } else { ?>
      <button type="button" onClick="generera_contrato_id('<?php echo $IdAsignacion; ?>')" class="btn btn-info pull-right"><i class="fa fa-refresh"></i> Actualizar contrato</button></button>
    <?php } ?>
  </div>
</form>

<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
  $(function () {
    $('#txt_fecha_contrato').datepicker({
      autoclose: true
    })
  })
</script>
