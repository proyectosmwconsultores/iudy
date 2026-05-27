<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/class.System.php');
$db = new Conexion();

$IdCampus = $_POST['IdCampus'];


 $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus' AND tblp_grupo.Dia <> 'P'");
 while($x = $db->recorrer($sql)){
   $ingles = $x['Ingles'];
   if($ingles == 'SI'){
   } else {
     $sql_rvoe = $db->query("SELECT * FROM tblc_rvoe WHERE tblc_rvoe.IdRvoe = '".$x['id_rvoe']."'");
     $db->rows($sql_rvoe);
     $_rvoe = $db->recorrer($sql_rvoe);
     //$insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._idRvoe = '".$_rvoe['IdRvoe']."', tblc_usuario._idCampus = '".$_rvoe['IdCampus']."', tblc_usuario._idOferta = '".$_rvoe['IdEducativa']."' WHERE tblc_usuario.IdGrupo = '".$x['IdGrupo']."'  ");
   }  
 }


$sql = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.IdOferta IS NULL  ");
while ($x = $db->recorrer($sql)) {
  $IdUs = $x['IdUsua'];
  $sql_par3 = $db->query("SELECT tblp_educativa.IdGrado, tblp_pagos.IdPago, tblp_pagos.IdOferta FROM tblp_pagos Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta WHERE tblp_pagos.IdUsua = '$IdUs' LIMIT 1");
  $db->rows($sql_par3);
  $_par3 = $db->recorrer($sql_par3);
  if(isset($_par3['IdOferta'])){
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdOferta = '".$_par3['IdOferta']."', tblc_usuario.Grado = '".$_par3['IdGrado']."' WHERE tblc_usuario.IdUsua = '$IdUs' ");
  }
}

if($IdCampus == 999){
  $condCampus = '';
} else {
  $condCampus = " AND tblc_usuario.IdCampus =  '$IdCampus' ";
}



$sql_lst = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Sexo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.IdOferta,
tblc_usuario.Usuario,
tblp_educativa.Nombre AS Educativa,
tblc_estatus.Estatus
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
WHERE
tblc_usuario.Permisos =  '3' $condCampus AND tblc_usuario.IdEstatus =  '8'
ORDER BY
tblp_educativa.IdGrado ASC,
tblc_usuario.IdOferta ASC
");
?>
<div class="box-header">
  <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de baja de alumnos del ciclo escolar</h3>
</div>
<div class="box-body">

<table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;" >
      <thead>
        <tr>
          <th>MATRICULA</th>
          <th>NOMBRE</th>
          <th>PLAN DE ESTUDIOS</th>
          <th>ESTATUS</th>
        </tr>
      </thead>
      <tbody>
        <?php while($matx = $db->recorrer($sql_lst)){ ?>
        <tr>
          <td><?php echo $matx["Usuario"]; ?></td>
          <td><?php echo $matx["APaterno"].' '.$matx["AMaterno"].' '.$matx["Nombre"]; ?></td>
          <td><?php echo $matx["Educativa"]; ?></td>
          <td><?php echo $matx["Estatus"]; ?></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>



</div>
<script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
  <!-- Custom and plugin javascript -->
  <script src="assets/table/js/scriptAgregado1.js"></script>
