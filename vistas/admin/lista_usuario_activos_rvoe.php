<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();

$IdCampus = $_POST['IdCampus'];

if($IdCampus == '10'){
  $confc = " "; 
} else {
  $confc = " AND tblc_usuario.IdCampus =  '$IdCampus'"; 
}

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

$sql_conc = $db->query("SELECT
Count(tblc_usuario.IdUsua) AS Total,
tblc_rvoe.Rvoe,
tblc_rvoe.Educativa,
tblc_campus.Campus
FROM
tblc_usuario
Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_rvoe.IdCampus
WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.IdEstatus = '8' $confc
GROUP BY
tblc_usuario._idRvoe
");

?>

<form name="frm2xfYj" id="frm2xfYj" action="capturar_gastos.php" method="POST" enctype="multipart/form-data">

  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th colspan="4" style="background: #dedaff;">REPORTE DE CONCENTRADO DE ALUMNOS POR RVOE</th>
      </tr>
      <tr>
        <th style="width: 10px"></th>
        <th>CAMPUS</th>
        <th>PLAN DE ESTUDIOS</th>
        <th>TOTAL</th>
      </tr>
      <?php $v = 0; $s = 0; while($c = $db->recorrer($sql_conc)){ $s = ($s + $c['Total']); ?>
      <tr>
        <td><b><?php  echo $v = ($v + 1); ?>.-</b></td>
        <td><?php if($c['Campus']){ echo $c['Campus']; } else { echo " ------------- ";}  ?></td>
        <td><?php if($c['Educativa']){ echo $c['Rvoe'].' - '.$c['Educativa']; } else { echo " ------------- ";}  ?></td>
        <td><?php echo $c['Total']; ?></td>
      </tr>
      <?php } ?>
      <tr>
        <th colspan="3" style=" text-align: right;">TOTAL: </th>
        <th style="background: yellow;"><?php echo $s; ?></th>
      </tr>

    </tbody>
  </table>

  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th colspan="5" style="background: #dedaff;">REPORTE DE ALUMNOS POR RVOE</th>
      </tr>
      <tr>
        <th style="width: 10px"></th>
        <th style="width: 10px"></th>
        <th>MATRICULA</th>
        <th>NOMBRE DEL ALUMNO</th>
        <th>GRUPO</th>
      </tr>
      <?php $v = 0; $oi = 0; $n = 0; $of = 0; while($x = $db->recorrer($sql_avisos)){ 

        $sql_grad = $db->query("SELECT tblc_ciclogrupo.Grado
        FROM tblc_ciclogrupo
        WHERE tblc_ciclogrupo.IdGrupo = '".$x['IdGrupo']."'
        ORDER BY
        tblc_ciclogrupo.Grado DESC LIMIT 1");
        $db->rows($sql_grad);
        $_grad = $db->recorrer($sql_grad);
        $oi = $x['IdEducativa'];
        if($oi <> $of){ $n = 0; ?>
        <tr style="background: #d8ccff;">
          <td colspan="5"><i class="fa fa-fw fa-check-circle"></i> <?php echo $x['Rvoe']; ?> - <?php echo $x['Educativa']; ?> (<?php echo $x['RCampus']; ?>)</td>
        </tr>
        <?php }
        ?>
      <tr>
        <td><b><?php  echo $v = ($v + 1); ?>.-</b></td>
        <td><b><?php  echo $n = ($n + 1); ?>.-</b></td>
        <td><?php echo $x['Usuario']; ?></td>
        <td><?php echo $x['APaterno'].' '.$x['AMaterno'].' '.$x['Nombre']; ?></td>
        <td><?php echo $_grad['Grado']; ?>° <?php echo $x['CveGrupo']; ?> (<?php echo $x['_Dias']; ?>)</td>
      </tr>
      <?php $of = $x['IdEducativa'];  } ?>

    </tbody>
  </table>

</form>