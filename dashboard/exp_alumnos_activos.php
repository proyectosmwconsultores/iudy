<?php
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=alumnos_activos.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");

  require('../php/clases/class.System.php');
    require('../hace.php');
    $db = new Conexion();
    $IdEstatus = $_GET['IdEstatus'];
   

$baj_plan2 = $db->query("SELECT
	tblc_usuario.IdUsua, 
	tblc_usuario.Nombre, 
	tblc_usuario.Usuario, 
	tblc_usuario.APaterno, 
	tblc_usuario.AMaterno, 
	tblc_usuario.Usuario, 
	tblc_usuario.IdEstatus, 
	tblc_usuario.porcentaje, 
	tblp_educativa.Nombre AS Educativa, 
	tblc_campus.Campus, 
	tblp_grupo.CveGrupo, 
	tblc_dias_clases.Dias_clase, 
	tblc_estatus.Estatus, 
	tblc_usuario.Correo, 
	tblc_usuario.Celular, 
	tblc_usuario.fecha_baja
FROM
	tblc_usuario
	LEFT JOIN
	tblp_educativa
	ON 
		tblp_educativa.IdEducativa = tblc_usuario.IdOferta
	LEFT JOIN
	tblc_campus
	ON 
		tblc_campus.IdCampus = tblc_usuario.IdCampus
	LEFT JOIN
	tblp_grupo
	ON 
		tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
	LEFT JOIN
	tblc_dias_clases
	ON 
		tblc_dias_clases.Dia = tblp_grupo.Dia
	LEFT JOIN
	tblc_estatus
	ON 
		tblc_usuario.IdEstatus = tblc_estatus.IdEstatus
WHERE
tblc_usuario.Permisos =  '3' AND
tblc_usuario.IdEstatus =  '$IdEstatus'
ORDER BY
tblc_usuario.IdCampus ASC,
tblp_educativa.IdGrado ASC
");


?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
  </head>
  <body>
    <table class="table table-striped" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <tbody>
          <tr>
            <th>#</th>
            <th>USUARIO</th>
            <th>NOMBRE</th>
            <th>CAMPUS</th>
            <th>PLAN DE ESTUDIOS</th>
            <th>GRUPO</th>
            <th>DIA</th>
            <th>ULTIMO PAGO GENERADO</th>
            <th>CORREO</th>
            <th>CELULAR</th>
            <th>ESTATUS</th>
            <th>FECHA BAJA</th>
            <th>AVANCE</th>
            
          </tr>
          <?php $c = 0; while ($_baj2 = $db->recorrer($baj_plan2)) { $c = ($c + 1);
            $sql_cic = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.IdUsua,
tblp_pagos.IdEstatus,
tblc_ciclo.Ciclo,
tblc_ciclo.FInicio,
tblp_pagos.IdConcepto
FROM
tblp_pagos
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_pagos.IdCiclo
WHERE
tblp_pagos.IdUsua = '".$_baj2['IdUsua']."' AND ((tblp_pagos.IdConcepto = '1') || (tblp_pagos.IdConcepto = '3')) ORDER BY tblc_ciclo.FInicio DESC LIMIT 1");
            $db->rows($sql_cic);
            $_cic = $db->recorrer($sql_cic);
            ?>
            <tr>
              <td><b><?php echo $c; ?>.- </b></td>
              <td><?php echo $_baj2['Usuario']; ?></td>
              <td><?php echo $_baj2['APaterno']; ?> <?php echo $_baj2['AMaterno']; ?> <?php echo $_baj2['Nombre']; ?></td>
              <td><?php echo $_baj2['Campus']; ?></td>
              <td><?php echo $_baj2['Educativa']; ?></td>
              <td><?php echo $_baj2['CveGrupo']; ?></td>
              <td><?php echo $_baj2['Dias_clase']; ?></td>
              <td><?php echo $_cic['Ciclo']; ?></td>
              <td><?php echo $_baj2['Correo']; ?></td>
              <td><?php echo $_baj2['Celular']; ?></td>
              <td><?php echo $_baj2['Estatus']; ?></td>
              <td><?php if((isset($_baj2['fecha_baja'])) && ($_baj2['IdEstatus'] <> 8)) { echo $_baj2['fecha_baja']; } ?></td>
              <td><?php echo $_baj2['porcentaje']; ?>%</td>
            </tr><?php } ?>
        </tbody>
      </table>
  </body>
</html>
