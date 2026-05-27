<?php
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=Alumnos_periodo.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");

  require('../php/clases/class.System.php');
    require('../hace.php');
    $db = new Conexion();
    $IdCiclo = $_GET['IdCiclo'];
   

$baj_plan2 = $db->query("SELECT
tblc_alumnos.IdUsua,
tblc_alumnos.Grado,
tblc_alumnos.Tipo,
tblc_alumnos.Horario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblp_grupo.CveGrupo,
tblc_rvoe.Educativa,
tblc_rvoe.Rvoe,
tblp_beca.Importe,
tblp_beca.Descuento,
tblp_beca.Total,
tblc_campus.Campus
FROM
tblc_alumnos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_alumnos.IdGrupo
Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe
Left Join tblp_beca ON tblp_beca.IdUsua = tblc_alumnos.IdUsua AND tblp_beca.IdCiclo = tblc_alumnos.IdCiclo
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
WHERE
tblc_alumnos.IdCiclo =  '51' AND
tblp_beca.IdConcepto =  '2'
GROUP BY
tblc_alumnos.IdUsua

");


?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
  </head>
  <body>
    <table class="table table-striped">
        <tbody>
          <tr>
            <th>USUARIO</th>
            <th>NOMBRE</th>
            <th>GRADO</th>
            <th>TIPO</th>
            <th>HORARIO</th>
            <th>RVOE</th>
            <th>PLAN DE ESTUDIOS</th>
            <th>CAMPUS</th>
            <th>IMPORTE MENSUALIDAD</th>
            <th>DESCUENTO MENSUALIDAD</th>
            <th>TOTAL MENSUALIDAD</th>
            <th>IMPORTE INSCRIPCION</th>
            <th>DESCUENTO INSCRIPCION</th>
            <th>TOTAL INSCRIPCION</th>
            
            
          </tr>
          <?php $c = 0; while ($_baj2 = $db->recorrer($baj_plan2)) { if($_baj2['Usuario']){ $c = ($c + 1);
          
          $sql_cic = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '".$_baj2['IdUsua']."' AND tblp_beca.IdCiclo = '$IdCiclo' AND ((tblp_beca.IdConcepto = 1) || ((tblp_beca.IdConcepto = 3))) ");
        $db->rows($sql_cic);
        $_cic = $db->recorrer($sql_cic);
        //$_cic['IdModUsua'];

          ?>
            <tr>
              <td><?php echo $_baj2['Usuario']; ?></td>
              <td><?php echo $_baj2['APaterno'].' '.$_baj2['AMaterno'].' '.$_baj2['Nombre']; ?></td>
              <td><?php echo $_baj2['Grado']; ?></td>
              <td><?php if($_baj2['Tipo'] == 'R'){ echo "REGULAR"; } else { echo "REINCORPORACION"; } ?></td>
              <td><?php if($_baj2['Horario'] == 'P'){ echo "PERSONALIZADO"; } else { echo "REGULAR"; } ?></td>
              <td><?php echo $_baj2['Rvoe']; ?></td>
              <td><?php echo $_baj2['Educativa']; ?></td>
              <td><?php echo $_baj2['Campus']; ?></td>
              <td><?php echo $_baj2['Importe']; ?></td>
              <td><?php echo $_baj2['Descuento']; ?></td>
              <td><?php echo $_baj2['Total']; ?></td>
              <td><?php echo $_cic['Importe']; ?></td>
              <td><?php echo $_cic['Descuento']; ?></td>
              <td><?php echo $_cic['Total']; ?></td>
            </tr><?php } } ?>
        </tbody>
      </table>
  </body>
</html>
