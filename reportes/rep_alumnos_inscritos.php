<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/class.System.php');
$db = new Conexion();

$IdCiclo = $_POST['IdCiclo'];
$IdOferta = $_POST['IdOferta'];

$sql_lst = $db->query("SELECT
tblp_moduloalumno.IdUsua,
tblp_moduloalumno.IdGrupo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario._horario,
tblc_usuario.Sexo,
tblc_usuario.Curp,  
tblc_usuario.FecNac,  
tblc_estatus.Estatus,
tblp_grupo.CveGrupo,
tblc_dias_clases._Dias,
tblc_modalidad._Modalidad,
tblp_educativa.Nombre AS Educativa,
tblc_ciclogrupo.Grado
FROM
tblp_asignacion
Left Join tblp_moduloalumno ON tblp_moduloalumno.IdAsignacion = tblp_asignacion.IdAsignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdCiclo = tblp_asignacion.IdCiclo AND tblc_ciclogrupo.IdGrupo = tblp_asignacion.IdGrupo
WHERE tblp_asignacion.IdCiclo =  '$IdCiclo' AND
tblc_usuario.IdOferta =  '$IdOferta' AND tblp_asignacion.Tipo = '2' AND tblc_usuario.IdEstatus = '8' AND tblc_usuario.IdUsua IS NOT NULL 
GROUP BY
tblp_moduloalumno.IdUsua
ORDER BY
tblp_asignacion.IdGrupo ASC");
?>
<div class="box-header">
  <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de alumnos activos</h3>
</div>
<div class="box-body">

<table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;" >
      <thead>
        <tr>
          <th>MATRICULA</th>
          <th>NOMBRE</th>
          <th>PLAN DE ESTUDIOS</th>
          <th>GRADO</th>
          <th>GRUPO</th>
          <th>MODALIDAD</th>
          <th>DIA</th>
          <th>SEXO</th>
          <th>CURP</th>
          <th>FECHA NAC</th>
        </tr>
      </thead>
      <tbody>
        <?php while($matx = $db->recorrer($sql_lst)){ 
          $horario = $matx["_horario"]; 
          ?>
        <tr>
          <td><?php echo $matx["Usuario"]; ?></td>
          <td><?php echo $matx["APaterno"].' '.$matx["AMaterno"].' '.$matx["Nombre"]; ?></td>
          <td><?php echo $matx["Educativa"]; ?></td>
          <td><?php echo $matx["Grado"]; ?></td>
          <td><?php if($horario == 'P') { echo "PERSONALIZADO"; } else { echo $matx["CveGrupo"]; } ?></td>
          <td><?php if($horario == 'P') { echo "-----"; } else {  echo $matx["_Modalidad"]; } ?></td>
          <td><?php if($horario == 'P') { echo "-----"; } else {  echo $matx["_Dias"]; }  ?></td>
          <td><?php echo $matx["Sexo"]; ?></td>
          <td><?php echo $matx["Curp"]; ?></td>
          <td><?php echo $matx["FecNac"]; ?></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>



</div>
<script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
  <!-- Custom and plugin javascript -->
  <script src="assets/table/js/scriptAgregado1.js"></script>
