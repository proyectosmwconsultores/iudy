<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../../php/clases/class.System.php');
  $db = new Conexion();
  
  $IdCampus = $_POST['IdCampus'];

  $sql_lst = $db->query("SELECT
  tblc_usuario.IdUsua,
  tblc_usuario.Usuario,
  tblc_usuario.Nombre,
  tblc_usuario.APaterno,
  tblc_usuario.AMaterno,
  tblc_usuario.Permisos,
  tblc_usuario._horario,
  tblc_usuario.IdOferta,
  tblp_educativa.Nombre AS Educativa,
  tblc_dias_clases._Dias
  FROM
  tblc_usuario
  Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta 
  Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblc_usuario._Dia
WHERE tblc_usuario.IdEstatus = '8'AND tblc_usuario.Permisos = '3' AND tblc_usuario.IdCampus = '$IdCampus' AND tblc_usuario._horario = 'P' ORDER BY tblc_usuario.IdOferta ASC ");

  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de alumnos con horario personalizado</h3>
  </div>
  <div class="box-body">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th></th>
          <th>MATRICULA</th>
          <th>NOMBRE DEL ALUMNO</th>
          <th>DIA</th>
        </tr>
      <?php $oi = 0; $of = 0; $v = 0; while($mat = $db->recorrer($sql_lst)){ $oi = $mat['IdOferta'];
        if($oi <> $of){ ?>
        <tr>
          <th colspan="4"><?php echo $mat['Educativa']; ?></th>
        </tr>
        <?php }
        ?>
      <tr>
        <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
        <td><?php echo $mat['Usuario']; ?></td>
        <td><?php echo $mat['APaterno'].' '.$mat['AMaterno'].' '.$mat['Nombre'];  ?></td>
        <td><?php echo $mat['_Dias']; ?></td>
      </tr><?php $of = $mat['IdOferta']; } ?>
    </tbody></table>
  </div>
