<?php session_start();
require('../php/clases/class.System.php');
include('../hace.php');
$db = new Conexion();
$Autorizacion = $_POST["Autorizacion"];
$Rerefencia = $_POST["Rerefencia"];

$folios = $db->query("SELECT * FROM tblh_temporal_conciliar WHERE tblh_temporal_conciliar.autorizacion = '$Autorizacion' AND tblh_temporal_conciliar.referencia = '$Rerefencia' ");

?>
<form class="form-horizontal">
  <div class="box-body">
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-6 control-label">Referencia Númerica:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="txt_referencia_bus" name="txt_referencia_bus" placeholder="00000" value="<?php echo $Rerefencia; ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword3" class="col-sm-6 control-label">Autorización:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="txt_autorizacion_bus" name="txt_autorizacion_bus" placeholder="000000" value="<?php echo $Autorizacion; ?>">
      </div>
    </div>
  </div>
  <div class="box-footer">
    <button onclick="buscar_folio_pago_id()" type="button" class="btn btn-info pull-right"><i class="fa fa-fw fa-search"></i> Realizar búsqueda</button>
  </div>
</form>

<?php while ($x = $db->recorrer($folios)) {
  $pago = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_foliospago.NoFolio, tblp_foliospago.FecCap FROM tblp_foliospago LEFT JOIN tblc_usuario ON tblp_foliospago.IdAdmin = tblc_usuario.IdUsua WHERE tblp_foliospago._idtemporal = '" . $x['IdTemporal'] . "' ");
  $db->rows($pago);
  $_pago = $db->recorrer($pago);
?>

  <div class="box-body">
    <blockquote>
      <p><b>Ordenante:</b> <?php echo $x['ordenante']; ?> 
      <?php if($x['idestatus'] == 10){ echo "<b style='color: green;'>(COMPLETADO)</b>";} ?> 
      <?php if($x['idestatus'] == 7){ echo "<b style='color: red;'>(CANCELADO)</b>";} ?> 
      <?php if($x['idestatus'] == 2){ echo "<b style='color: blue;'>(EN REVISIÓN)</b>";} ?> 
       <?php // echo $x['IdTemporal']; ?></p> 
      <small><b>Fecha: </b><?php echo $x['Fecha']; ?></small>
      <small><b>Importe: </b>$ <?php echo $x['Importe']; ?></small>
      <small><b>Referencia: </b> <?php echo $x['referencia']; ?></small>
      <small><b>Alfanumérica: </b> <?php echo $x['alfanumerica']; ?></small>
      <small><b>Ordenante: </b> <?php echo $x['ordenante']; ?></small>
      <small><b>Banco: </b> <?php echo $x['banco']; ?></small>
      <small><b>Descripción:</b> <?php echo $x['Descripcion']; ?></small>
    </blockquote>
  </div>
  <?php if (isset($_pago['Nombre'])) { ?>
    <div class="box-body">
      <blockquote>
        <p><b>Aprobado por:</b> <?php echo $_pago['Nombre']; ?> <?php echo $_pago['APaterno']; ?> <?php echo $_pago['AMaterno']; ?></p>
        <small><b>Fecha creación: </b><?php echo $_pago['FecCap']; ?></small>
        <small><b>Folio: </b> <?php echo $_pago['NoFolio']; ?></small>
        <small><b onclick="javascript:window.open('repositorio/pdf/comprobante.php?idToks=<?php echo time() . $_pago['NoFolio']; ?>');" href="javascript:void(0);" style="color: blue; cursor: pointer;">Imprimir comprobante </b></small>
      </blockquote>
    </div>
  <?php } ?>
<?php } ?>