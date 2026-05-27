<?php
include('../hace.php');

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdDocente = $_POST["IdUsua"];
  $IdCiclo = $_POST["IdCiclo"];

$sql_mod1 = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdCiclo,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_asignacion.pro_alum,
tblp_asignacion.pro_coo,
tblp_grupo.CveGrupo,
tblp_educativa.Nombre,
tblc_campus.Campus
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus
WHERE
tblp_asignacion.IdUsua =  '93' AND
tblp_asignacion.Tipo =  '2' AND
tblp_asignacion._alum IS NOT NULL 
ORDER BY
tblp_asignacion.FecCap ASC
");

$sql_mod2 = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdCiclo,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_asignacion.pro_alum,
tblp_asignacion.pro_coo,
tblp_grupo.CveGrupo,
tblp_educativa.Nombre,
tblc_campus.Campus
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus
WHERE
tblp_asignacion.IdUsua =  '93' AND
tblp_asignacion.Tipo =  '2' AND
tblp_asignacion._alum IS NOT NULL 
ORDER BY
tblp_asignacion.FecCap ASC
");

$sqlV = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdDocente'");
$db->rows($sqlV);
$datos91 = $db->recorrer($sqlV);

?>


<input type="hidden" name="docente" id="docente" value="DOCENTE: <?php echo $datos91["Nombre"].' '.$datos91["APaterno"].' '.$datos91["AMaterno"]; ?> " >
  
<div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"> <i class="fa fa-fw fa-check-circle"></i> GRÁFICA DE PROMEDIO ALCANZADO</span></div>

<div id="container_mod" style="width: 100%;"></div>
<table id="datatable_mod" class="table table-striped" style="font-size: 12px; display: none;">
  <thead>
    <tr style="background: #d2d6de; color: black;">
      <th>NOMBRE DE LA MATERIA</th>
      
      <th style="text-align: center; font-size: 10px;">PROMEDIO</th>
      
    </tr>
  </thead>
  <tbody>
  <?php $prom1 = 0; $snx = 0; while($x = $db->recorrer($sql_mod1)){ $prom1 = (($x['pro_alum'] + $x['pro_coo']) / 2); ?>
    <tr>
      <td><?php echo $x['NombreMod']; ?></td>
      <td><?php echo $prom1; ?></td>
    </tr>
    <?php $prom1 = 0; } ?>
  </tbody>
</table>

<table class="table table-striped" style="font-size: 12px;">
  <thead>
    <tr style="background: #d2d6de; color: black;">
      <th>CAMPUS</th>
      <th>CARRERA</th>
      <th>GRUPO</th>
      <th>NOMBRE DE LA MATERIA</th>
      <th style="text-align: center;">PROMEDIO</th>
    </tr>
  </thead>
  <tbody>
  <?php  $prom2 = 0; $snx = 0; while($x = $db->recorrer($sql_mod2)){ $prom2 = (($x['pro_alum'] + $x['pro_coo']) / 2);  ?>
    <tr>
      <td><?php echo $x['Campus']; ?></td>
      <td><?php echo $x['Nombre']; ?></td>
      <td><?php echo $x['CveGrupo']; ?></td>
      <td><?php echo $x['NombreMod']; ?></td>
      <td style="text-align: center;"><?php echo $prom2; ?></td>
    </tr>
    <?php $prom2 = 0; } ?>
  </tbody>
</table>

<script>
var Docente = document.getElementById("docente").value;
Highcharts.chart('container_mod', {
data: {
  table: 'datatable_mod'
},
chart: {
  type: 'column',
  options3d: {
    enabled: true,
    alpha: 10,
    beta: 25,
    depth: 70
  }
},
title: {
  text: 'RESULTADO DE LA EVALUACIÓN POR MATERIA<br>' + Docente
},
yAxis: {
  allowDecimals: false,
  title: {
    text: 'Promedio alcanzado'
  }
},
tooltip: {
  formatter: function () {
    return '<b>Promedio: </b> ' + this.point.y;
  }
}
});

</script>
