<?php
session_start();
$IdEstatus = $_POST['IdEstatus'];
require('../php/clases/class.System.php');
$db = new Conexion();


$user_estatus = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.IdEstatus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario.IdCampus,
tblc_campus.Campus,
tblp_educativa.Nombre AS Educativa
FROM
tblc_usuario
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE
tblc_usuario.Permisos =  '3' AND
tblc_usuario.IdEstatus =  '$IdEstatus'
ORDER BY
tblc_usuario.IdCampus ASC,
tblp_educativa.IdGrado ASC,
Educativa ASC
 ");


?>

<div class="row">
  <div class="col-lg-c12 col-xs-12">
    <div class="bg-maroon-active color-palette" style="padding: 8px;"><span><i class="fa fa-fw fa-folder"></i> Lista de alumnos en IUDY por Estatus</span></div>
  </div>
  
  <div class="col-lg-12 col-xs-12">
  <button onclick="window.open('dashboard/exp_alumnos_activos.php?IdEstatus=<?php echo $IdEstatus; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-cloud-download"></i> Descargar excel</button>
  <br>
    <div class="box-body no-padding">
      <table class="table table-striped">
        <tbody>
          
          <?php $ci = 0; $cf = 0; while ($_estatus = $db->recorrer($user_estatus)) { $ci = $_estatus['IdCampus'];
            if($ci <> $cf){ ?>
            <tr style="background: #b6b1f9;">
              <th colspan="3"><?php echo $_estatus['Campus']; ?></th>
            </tr>
            <?php }
            ?>
            <tr>
              <td><?php echo $_estatus['Usuario']; ?></td>
              <td><?php echo $_estatus['Nombre']; ?> <?php echo $_estatus['APaterno']; ?> <?php echo $_estatus['AMaterno']; ?></td>
              <td><?php echo $_estatus['Educativa']; ?></td>
            </tr><?php $cf = $_estatus['IdCampus']; } ?>
        </tbody>
      </table>
    </div>
  </div>

  


</div>
