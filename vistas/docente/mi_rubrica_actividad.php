<?php session_start();
include('../../hace.php');
require('../../php/clases/class.System.php');
$anio = date("Y-m-d");
$db = new Conexion();
$IdUsua = $_SESSION['IdUsua'];
$IdActividadDoc = $_POST["IdActividadDoc"];
$IdRubrica = $_POST["IdRubrica"];

$act = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
$db->rows($act);
$x_act = $db->recorrer($act);
$_IdRubrica = $x_act['IdRubrica'];
$IdRubrica = $_IdRubrica;

$sql_rub = $db->query("SELECT tblc_rubrica.IdRubrica, tblc_rubrica.IdUsua, tblc_rubrica.Nombre, tblc_estatus.Estatus FROM tblc_rubrica Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_rubrica.IdEstatus WHERE tblc_rubrica.IdUsua = '$IdUsua' ORDER BY tblc_rubrica.IdEstatus DESC");
$sql_rub_det = $db->query("SELECT tblc_rubrica_detalle.IdDetalle, tblc_rubrica_detalle.IdRubrica, tblc_rubrica_detalle.Texto, tblc_rubrica_detalle.Cal1, tblc_rubrica_detalle.Cal2, tblc_rubrica_detalle.Cal3, tblc_rubrica_detalle.Cal4, tblc_rubrica_detalle.Cal5, tblc_rubrica.IdEstatus FROM tblc_rubrica_detalle Left Join tblc_rubrica ON tblc_rubrica.IdRubrica = tblc_rubrica_detalle.IdRubrica WHERE tblc_rubrica_detalle.IdRubrica = '$IdRubrica' ");
$rub = $db->query("SELECT * FROM tblc_rubrica WHERE tblc_rubrica.IdRubrica = '$IdRubrica'");
$db->rows($rub);
$x_rub = $db->recorrer($rub);
$IdEstatus = $x_rub['IdEstatus'];




?>
<form method="POST" enctype="multipart/form-data" class="form-horizontal">
  <div class="box-body">
    <div id="div_lista">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr>
              <th style="width: 10px"></th>
              <th>Criterios de evaluación</th>
              <th style="text-align: center;">Excelente</th>
              <th style="text-align: center;">Muy bien</th>
              <th style="text-align: center;">Satisfactorio</th>
              <th style="text-align: center;">Requiere mejora</th>
              <th style="text-align: center;">Inadecuado</th>
            </tr>
            <?php $v = 0;
            while ($_det = $db->recorrer($sql_rub_det)) { ?>
              <tr>
                <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
                <td><?php echo $_det['Texto']; ?></td>
                <td style="text-align: center;"><?php echo $_det['Cal1']; ?></td>
                <td style="text-align: center;"><?php echo $_det['Cal2']; ?></td>
                <td style="text-align: center;"><?php echo $_det['Cal3']; ?></td>
                <td style="text-align: center;"><?php echo $_det['Cal4']; ?></td>
                <td style="text-align: center;"><?php echo $_det['Cal5']; ?></td>
              </tr><?php } ?>
          </tbody>
        </table>
    </div>
  </div>
</form>