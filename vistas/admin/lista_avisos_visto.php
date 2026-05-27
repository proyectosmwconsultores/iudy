<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();

$IdAviso = $_POST['IdAviso'];

$sql_avisos = $db->query("SELECT
tbla_aviso_detalle.IdDetalle,
tbla_aviso_detalle.IdAviso,
tbla_aviso_detalle.IdUsua,
tbla_aviso_detalle.Fec_visto,
tbla_aviso_detalle.Fec_aceptado,
tbla_aviso_detalle.IdEstatus,
tblc_usuario.IdOferta,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_educativa.Nombre AS Educativa
FROM
tbla_aviso_detalle
Left Join tblc_usuario ON tblc_usuario.IdUsua = tbla_aviso_detalle.IdUsua
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE
tbla_aviso_detalle.IdAviso =  '$IdAviso'
ORDER BY
tblc_usuario.IdOferta
");


?>

<form name="frm2xfYj" id="frm2xfYj" action="capturar_gastos.php" method="POST" enctype="multipart/form-data">

  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th style="width: 10px"></th>
        <th>Nombre</th>
        <th>Fecha visto</th>
        <th>Fecha aceptado</th>
      </tr>
      <?php $sv = 0; $sa = 0; $v = 0; $oi = 0; $of = 0; while($x = $db->recorrer($sql_avisos)){ $oi = $x['IdOferta'];
          if($x['Fec_visto']){ $sv = ($sv + 1); }
          if($x['Fec_aceptado']){ $sa = ($sa + 1); }

        if($oi <> $of){ ?>
        <tr style="background: #d8ccff;">
          <td colspan="4"><i class="fa fa-fw fa-book"></i> <?php echo $x['Educativa']; ?></td>
        </tr>
        <?php }
        ?>
      <tr>
        <td><b><?php  echo $v = ($v + 1); ?>.-</b></td>
        <td><?php echo $x['Nombre'].' '.$x['APaterno'].' '.$x['AMaterno']; ?></td>
        <td><?php echo $x['Fec_visto']; ?></td>
        <td><?php echo $x['Fec_aceptado']; ?></td>
      </tr>
      <?php $of = $x['IdOferta'];  } ?>

      <tr>
        <td colspan="3" style="text-align: right;"><b>Total alumnos que ya vieron el aviso:</b></td>
        <td><?php echo $sv; ?></td>
      </tr>
      <tr>
        <td colspan="3" style="text-align: right;"><b>Total alumnos que ya aceptaron el aviso:</b></td>
        <td><?php echo $sa; ?></td>
      </tr>
    </tbody>
  </table>

</form>