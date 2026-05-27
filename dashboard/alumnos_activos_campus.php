<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/class.System.php');
$db = new Conexion();
$IdCampus = $_POST['IdCampus'];
$IdCiclo = $_POST['IdCiclo'];

// $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus' AND tblp_grupo.Dia <> 'P'");
// while($x = $db->recorrer($sql)){
//   $ingles = $x['Ingles'];
//   if($ingles == 'SI'){
//   } else {
//     $sql_rvoe = $db->query("SELECT * FROM tblc_rvoe WHERE tblc_rvoe.IdRvoe = '".$x['id_rvoe']."'");
//     $db->rows($sql_rvoe);
//     $_rvoe = $db->recorrer($sql_rvoe);
//     $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._idRvoe = '".$_rvoe['IdRvoe']."', tblc_usuario._idCampus = '".$_rvoe['IdCampus']."', tblc_usuario._idOferta = '".$_rvoe['IdEducativa']."' WHERE tblc_usuario.IdGrupo = '".$x['IdGrupo']."'  ");
//   }  
// }


  // $sql_grp = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblp_grupo.Dia FROM tblp_grupo WHERE tblp_grupo.IdCicloIni =  '$IdCiclo' AND tblp_grupo.IdCampus =  '$IdCampus' AND tblp_grupo.IdEstatus =  '8' ");
  //   while ($grp = $db->recorrer($sql_grp)) {
  //     if($grp['IdGrupo'] == 'P'){
  //       $dia = 'P';
  //     } else {
  //       $dia = '';
  //     }
      
  //     $lst_us = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdEstatus FROM tblc_usuario WHERE tblc_usuario.IdGrupo =  '".$grp['IdGrupo']."'");
  //     while ($lstuser = $db->recorrer($lst_us)) {
  //         if($lstuser['IdEstatus'] <> 12){
  //             $sql_us = $db->query("SELECT * FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '".$lstuser['IdUsua']."' AND tblc_alumnos.IdCiclo = '$IdCiclo' ");
  //             $db->rows($sql_us);
  //             $user = $db->recorrer($sql_us);
  //             $IdActivo = $user['IdActivo'];
  //             if(!$IdActivo){
  //                $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor, Horario) VALUES('".$grp['IdGrupo']."','$IdCiclo','".$lstuser['IdUsua']."','1','R','".$lstuser['IdEstatus']."',NOW(),1,'$dia')"); 
  //             }    
  //         }
  //     }
  // }

    $sql_pag = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.IdUsua,
tblp_pagos.IdCiclo,
tblc_usuario.IdEstatus,
tblc_usuario._horario,
tblc_usuario.IdGrupo,
tblp_grupo.Dia,
tblc_ciclogrupo.Grado
FROM
tblp_pagos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdCiclo = tblp_pagos.IdCiclo AND tblc_ciclogrupo.IdGrupo = tblp_pagos.IdGrupo
WHERE
tblp_pagos.IdCiclo =  '$IdCiclo' AND 
tblp_pagos.IdCampus =  '$IdCampus'
GROUP BY
tblp_pagos.IdUsua
ORDER BY
tblc_usuario.IdEstatus ASC
");
    while ($x = $db->recorrer($sql_pag)) {
        if($x['IdEstatus'] <> 12){
            $sql_us = $db->query("SELECT * FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '".$x['IdUsua']."' AND tblc_alumnos.IdGrupo = '".$x['IdGrupo']."' AND tblc_alumnos.IdCiclo = '".$x['IdCiclo']."' ");
            $db->rows($sql_us);
            $user = $db->recorrer($sql_us);
            $IdActivo = $user['IdActivo'];
            if(!$IdActivo){
               $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor, Horario) VALUES('".$x['IdGrupo']."','".$x['IdCiclo']."','".$x['IdUsua']."','".$x['Grado']."','R','".$x['IdEstatus']."',NOW(),1,'".$x['_horario']."')"); 
            }    
        }
    }



$sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdUsua, tblp_pagos.IdEstatus FROM tblp_pagos WHERE tblp_pagos.EstatusDescuento IS NULL AND tblp_pagos.IdCampus =  '$IdCampus' AND tblp_pagos.IdCiclo =  '$IdCiclo' AND tblp_pagos.IdEstatus =  '4' GROUP BY tblp_pagos.IdUsua ORDER BY tblp_pagos.IdUsua ASC");
while ($x = $db->recorrer($sql)) {
  $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Pago = 1 WHERE tblc_alumnos.IdCiclo = '$IdCiclo' AND tblc_alumnos.IdUsua = '".$x['IdUsua']."' ");
  if($insertar){
    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.EstatusDescuento = 1 WHERE tblp_pagos.IdPago = '".$x['IdPago']."' ");
  }
}




$lst_plan = $db->query("SELECT tblc_alumnos.IdActivo, tblc_usuario.IdOferta, tblp_educativa.Nombre FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' GROUP BY tblc_usuario.IdOferta ORDER BY tblp_educativa.IdGrado ASC");


$baj_plan2 = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.IdUsua,
tblc_usuario.Sexo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario._horario,
tblc_usuario.Usuario,
tblc_usuario.IdOferta,
tblc_rvoe.Educativa,
tblc_rvoe.Rvoe,
tblc_rvoe.Vigencia,
tblc_rvoe.Turno,
tblc_rvoe.Modalidad,
tblc_rvoe.Escuela,
tblc_rvoe.Localidad,
tblc_rvoe.Clave,
tblc_rvoe.Clave_dgp,
tblc_rvoe.Clave_rpe,
tblc_campus.Campus,
tblc_estatus.Estatus,
tblp_grupo.Modalidad AS ModalidadGrupo,
tblp_grupo.Dia,
tblp_grupo.TipoCiclo,
tblp_grupo.Periodo,
tblc_ciclogrupo.Grado,
tblc_ciclo.FInicio,
tblc_ciclo.FFinal,
tblp_informacion.P_curp,
tblp_informacion.E_escuela_procedencia
FROM
tblp_pagos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdCiclo = tblp_pagos.IdCiclo AND tblc_ciclogrupo.IdGrupo = tblp_pagos.IdGrupo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_pagos.IdCiclo
Left Join tblp_informacion ON tblp_informacion.IdUsua = tblc_usuario.IdUsua
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE
tblp_pagos.IdCiclo =  '$IdCiclo' AND tblp_educativa.IdGrado <=  '3'
GROUP BY
tblp_pagos.IdUsua
ORDER BY
tblc_usuario.IdCampus ASC,
tblc_usuario.IdOferta ASC
 ");

?>


<table class="table table-striped" style="font-size: 12px;">
  <tbody>
    <tr>
      <th rowspan="2"></th>
      <th rowspan="2">PLAN DE ESTUDIOS</th>
      <th colspan="2" style="text-align: center;">ESCOLARIZADO</th>
      <th colspan="2" style="text-align: center;">SÁBADO</th>
      <th colspan="2" style="text-align: center;">DOMINGO</th>
      <th colspan="2" style="text-align: center;">TOTAL</th>
    </tr>
    <tr>
      <th style="text-align: center;">META</th>
      <th style="text-align: center;">REAL</th>
      <th style="text-align: center;">META</th>
      <th style="text-align: center;">REAL</th>
      <th style="text-align: center;">META</th>
      <th style="text-align: center;">REAL</th>
      <th style="text-align: center;">META</th>
      <th style="text-align: center;">REAL</th>
    </tr>
    <?php $c = 0; $sum_total = 0;
    while ($_baj2 = $db->recorrer($lst_plan)) {

      $sql_total_escolar = $db->query("SELECT Count(tblc_alumnos.IdActivo) AS Total FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario.IdOferta =  '".$_baj2['IdOferta']."' AND tblc_usuario.tipo_modalidad =  'E' ");
      $db->rows($sql_total_escolar);
      $_totalEscolar = $db->recorrer($sql_total_escolar);
      $totalEsc = $_totalEscolar['Total'];

      $sql_total_sabado = $db->query("SELECT Count(tblc_alumnos.IdActivo) AS Total FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario.IdOferta =  '".$_baj2['IdOferta']."' AND tblc_usuario.tipo_modalidad =  'S' ");
      $db->rows($sql_total_sabado);
      $_totalSabado = $db->recorrer($sql_total_sabado);
      $totalSab = $_totalSabado['Total'];

      $sql_total_domingo = $db->query("SELECT Count(tblc_alumnos.IdActivo) AS Total FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario.IdOferta =  '".$_baj2['IdOferta']."' AND tblc_usuario.tipo_modalidad =  'D' ");
      $db->rows($sql_total_domingo);
      $_totalDomingo = $db->recorrer($sql_total_domingo);
      $totalDom = $_totalDomingo['Total'];

      $sql_total = $db->query("SELECT Count(tblc_alumnos.IdActivo) AS Total FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario.IdOferta =  '".$_baj2['IdOferta']."' ");
      $db->rows($sql_total);
      $_total = $db->recorrer($sql_total);
      $total = $_total['Total'];


      $c = ($c + 1); ?>
      <tr>
        <td><b><?php echo $c; ?>.- </b></td>
        <td><?php echo $_baj2['Nombre']; ?></td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"><?php echo $totalEsc; ?></td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"><?php echo $totalSab; ?></td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"><?php echo $totalDom; ?></td>
        <td style="text-align: center;"></td>
        <td style="cursor: pointer;" onclick="lista_alumnos(<?php echo $IdCiclo; ?>,<?php echo $IdCampus; ?>,<?php echo $_baj2['IdOferta']; ?>)" style="text-align: center;"><?php echo $total; ?></td>
      </tr><?php $sum_total = ($sum_total + $total); } ?>
      <tr>
        <td colspan="2" style="text-align: right;"><b>TOTAL:</b></td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"><b><?php echo $sum_total; ?></b></td>
      </tr>

  </tbody>
</table>