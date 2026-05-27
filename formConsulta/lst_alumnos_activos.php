<?php
session_start();
include('../hace.php');
if(isset($_POST["IdGrupo"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();


  $sql_con = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.IdGrupo = '".$_POST["IdGrupo"]."' GROUP BY tblc_usuario.IdEstatus ORDER BY Total DESC ");
  $sql_lst = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_estatus.Estatus, tblc_usuario.Usuario FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.IdGrupo = '".$_POST["IdGrupo"]."' ORDER BY tblc_usuario.IdEstatus ASC");

?>
  <div class="table-responsive">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody><tr>
        <th colspan="3" style="background: #c5d9ff;">CONCENTRADO POR ESTATUS DE LOS ALUMNOS</th>
      </tr>
      <tr>
        <th style="width: 10px">#</th>
        <th>ESTATUS</th>
        <th style="text-align: center;">TOTAL</th>
      </tr>
      <?php $v = 0; while($_con = $db->recorrer($sql_con)){ ?>
      <tr>
        <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
        <td><?php echo $_con['Estatus']; ?></td>
        <td style="text-align: center;"><?php echo $_con['Total']; ?></td>
      </tr><?php } ?>
      </tbody></table>

      <table class="table table-striped" style="font-size: 12px;">
        <tbody><tr>
          <th colspan="4" style="background: #c5d9ff;">LISTA DE ALUMNOS DEL GRUPO</th>
        </tr><tr>
          <th style="width: 10px">#</th>
          <th>MATRÍCULA</th>
          <th>NOMBRE</th>
          <th>ESTATUS</th>
        </tr>
        <?php $v = 0; while($_alu = $db->recorrer($sql_lst)){ ?>
        <tr>
          <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
          <td><?php echo $_alu['Usuario']; ?></td>
          <td><?php echo $_alu['APaterno'].' '.$_alu['AMaterno'].' '.$_alu['Nombre']; ?></td>
          <td><?php echo $_alu['Estatus']; ?></td>
        </tr><?php } ?>
      </tbody></table>
  </div>
<?php } ?>
