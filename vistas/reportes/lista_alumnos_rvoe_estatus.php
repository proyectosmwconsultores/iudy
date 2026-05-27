<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdCampus = $_POST['IdCampus'];
$IdCiclo = $_POST['IdCiclo'];
$IdRvoe = $_POST['IdRvoe'];
 $IdEstatus = $_POST['IdEstatus'];

if($IdEstatus == 0){
  $cond = "";
} else {
  $cond = " AND tblc_usuario.IdEstatus =  '$IdEstatus'";
}


$sql_lsta = $db->query("SELECT
tblc_alumnos.IdActivo,
tblc_usuario._idRvoe,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_alumnos.IdGrupo,
tblc_alumnos.Grado,
tblc_alumnos.Tipo,
tblp_grupo.CveGrupo,
tblc_dias_clases._Dias,
tblc_modalidad._Modalidad,
tblp_educativa.Nombre AS Educativa,
tblc_estatus.Estatus
FROM
tblc_alumnos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_alumnos.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_modalidad ON tblc_modalidad.Mod = tblp_grupo.Modalidad
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario._idRvoe =  '$IdRvoe' $cond
ORDER BY
tblc_alumnos.Grado ASC,
tblc_alumnos.IdGrupo ASC
 ");

?>

<div class="box-body">

  <table id="example" class="table table-striped" style="font-size: 12px;">
    <thead>

    </thead>
    <tbody>
      <?php $c = 0;
      $cI = 0;
      $cF = 0;
      while ($matx = $db->recorrer($sql_lsta)) {
        $cI = $matx["IdGrupo"];
        if ($cI <> $cF) {
          $c = 0; ?>
          <tr style="background: #c8b9ff;">
            <td colspan="5"><b><?php if($matx["_Dias"] == 'PERSONALIZADO') { echo $matx["CveGrupo"].' - '.$matx["_Modalidad"].' '.$matx["_Dias"]; } else { echo $matx["Grado"]; ?>° - <?php echo $matx["CveGrupo"]; ?> - <?php echo $matx["_Modalidad"]; ?> - <?php echo $matx["_Dias"];  } ?></b></td>
          </tr>
          <tr>
            <th></th>
            <th>USUARIO</th>
            <th >NOMBRE DEL ALUMNO</th>
            <th>ESTATUS</th>
            <th>TIPO</th>
          </tr>
        <?php }
        ?>
        <tr>
          <td><b><?php echo $c = ($c + 1); ?>.- </b></td>
          <td><?php echo $matx["Usuario"]; ?></td>
          <td><?php echo $matx["APaterno"] . ' ' . $matx["AMaterno"] . ' ' . $matx["Nombre"]; ?></td>
          <td><?php echo $matx["Estatus"]; ?></td>
          <td><?php echo $matx["Tipo"]; ?></td>
        </tr>
      <?php $cF = $matx["IdGrupo"];
      } ?>
      </tfoot>
  </table>
</div>