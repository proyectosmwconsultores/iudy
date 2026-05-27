<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/class.System.php');
$db = new Conexion();
 $IdOferta = $_POST['IdOferta'];
$Tipo = $_POST['Tipo'];


if ($Tipo == "SS") {
  $pocen = 70;
  $texto = "SERVICIO";
  $sql_lst = $db->query("SELECT tblc_estatus.Estatus, tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblc_usuario.porcentaje, estatus.Estatus AS EstatusTipo FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus Left Join tblc_estatus AS estatus ON estatus.IdEstatus = tblc_usuario.idss WHERE tblc_usuario.IdOferta =  '$IdOferta' AND tblc_usuario.porcentaje >=  '$pocen' ");
  $sql_tot = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.idss WHERE tblc_usuario.IdOferta =  '$IdOferta' AND tblc_usuario.porcentaje >=  '$pocen' GROUP BY tblc_usuario.idss ");
  $sql_all = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.idss WHERE tblc_usuario.IdOferta =  '$IdOferta' AND tblc_usuario.porcentaje >=  '$pocen' GROUP BY tblc_usuario.idss ");
} else {
  $pocen = 40;
  $texto = "PRÁCTICA";
  $sql_lst = $db->query("SELECT tblc_estatus.Estatus, tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblc_usuario.porcentaje, estatus.Estatus AS EstatusTipo FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus Left Join tblc_estatus AS estatus ON estatus.IdEstatus = tblc_usuario.idpp WHERE tblc_usuario.IdOferta =  '$IdOferta' AND tblc_usuario.porcentaje >=  '$pocen' ");
  $sql_tot = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.idpp WHERE tblc_usuario.IdOferta =  '$IdOferta' AND tblc_usuario.porcentaje >=  '$pocen' GROUP BY tblc_usuario.idpp ");
  $sql_all = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.idpp WHERE tblc_usuario.IdOferta =  '$IdOferta' AND tblc_usuario.porcentaje >=  '$pocen' GROUP BY tblc_usuario.idpp ");
}

$sum = 0;
while ($tot = $db->recorrer($sql_tot)) {
  $sum = $sum  + $tot['Total'];
}
if($sum > 0){
  $porcentaje = 100 / $sum;
} else {
  $porcentaje = 0;
}


?>
<div class="box-header">
  <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Resultado de la búsqueda</h3>
</div>
<table class="table">
  <tbody>
    <tr style="background: yellow;">
      <th>ESTATUS</th>
      <th style="text-align: center;">TOTAL</th>
      <th>PROGRESO</th>
      <th style="width: 40px; text-align: center;">PORCENTAJE</th>
    </tr>
    <?php while ($all = $db->recorrer($sql_all)) {
      $avance = ($all['Total'] * $porcentaje);
    ?>
      <tr>
        <td><?php echo $all['Estatus']; ?></td>
        <td style="text-align: center;"><?php echo $all['Total']; ?></td>
        <td>
          <div class="progress progress-xs progress-striped active">
            <div class="progress-bar progress-bar-danger" style="width: <?php echo round($avance, 2); ?>%"></div>
          </div>
        </td>
        <td style="text-align: center;"><span class="badge bg-light-blue"><?php echo round($avance, 2); ?>%</span></td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<div class="box-body">

  <table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;">
    <thead>
      <tr>
        <th>MATRICULA</th>
        <th>NOMBRE</th>
        <th>ESTATUS DEL ALUMNO</th>
        <th>PORCENTAJE</th>
        <th>ESTATUS <?php echo $texto;  ?></th>
      </tr>
    </thead>
    <tbody>
      <?php while ($matx = $db->recorrer($sql_lst)) { ?>
        <tr>
          <td><?php echo $matx["Usuario"]; ?></td>
          <td><?php echo $matx["APaterno"] . ' ' . $matx["AMaterno"] . ' ' . $matx["Nombre"]; ?></td>
          <td><?php echo $matx["Estatus"]; ?></td>
          <td style="text-align: center;"><?php echo $matx["porcentaje"]; ?>%</td>
          <td><?php echo $matx["EstatusTipo"]; ?></td>
        </tr>
      <?php } ?>
      </tfoot>
  </table>
</div>
<script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
<!-- Custom and plugin javascript -->
<script src="assets/table/js/scriptAgregado1.js"></script>