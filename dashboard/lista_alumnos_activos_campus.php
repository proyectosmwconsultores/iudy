<?php
session_start();

require('../php/clases/class.System.php');
$db = new Conexion();
$IdCampus = $_POST['IdCampus'];
$IdCiclo = $_POST['IdCiclo'];
$IdOferta = $_POST['IdOferta'];



$lista = $db->query("SELECT
tblc_alumnos.IdActivo,
tblc_alumnos.IdGrupo,
tblc_alumnos.IdCiclo,
tblc_alumnos.IdUsua,
tblc_alumnos.Grado,
tblc_alumnos.Tipo,
tblc_alumnos.IdEstatus,
tblc_alumnos.FecCap,
tblc_alumnos.Valor,
tblc_alumnos.Horario,
tblc_alumnos.Pago,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblp_grupo.CveGrupo,
tblp_grupo.Dia,
tblc_dias_clases._Dias,
tblc_estatus.Estatus
FROM
tblc_alumnos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
WHERE
tblc_alumnos.IdCiclo =  '$IdCiclo' AND
tblc_usuario.IdOferta =  '$IdOferta' AND
tblc_usuario.IdCampus =  '$IdCampus'
ORDER BY tblc_alumnos.Grado ASC, tblp_grupo.Grupo ASC

 ");

?>


<table class="table table-striped" style="font-size: 12px;">
  <tbody>
    <tr>
      <th></th>
      <th>USUARIO</th>
      <th>NOMBRE</th>
      <th>GRUPO</th>
      <th>DIA</th>
      <th>ESTATUS</th>
    </tr>
    <?php $c = 0; $sum_total = 0;
    while ($lst = $db->recorrer($lista)) {
      $c = ($c + 1); ?>
      <tr>
        <td><b><?php echo $c; ?>.- </b></td>
        <td><?php echo $lst['Usuario']; ?></td>
        <td><?php echo $lst['APaterno'].' '.$lst['AMaterno'].' '.$lst['Nombre']; ?></td>
        <td><?php echo $lst['Grado']; ?>° <?php echo $lst['CveGrupo']; ?></td>
        <td><?php echo $lst['_Dias']; ?></td>
        <td><?php echo $lst['Estatus']; ?></td>
      </tr><?php } ?>
  </tbody>
</table>