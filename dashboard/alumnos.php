<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION['IdUsua'];
  $IdEstatus = $_POST['IdEstatus'];

   // $insertar = $db->query("ALTER TABLE tblh_log ADD COLUMN email VARCHAR(1) NULL");
   // $insertar = $db->query("ALTER TABLE tblh_log DROP COLUMN email");


  if($IdEstatus == 0){
    $cond = "";
  } else {
    $cond = " AND tblc_usuario.IdEstatus = '$IdEstatus' ";
  }
  $sql_use = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_campus.Campus,
tblc_campus.IdCampus,
tblc_estatus.Estatus
FROM
tblc_usuario
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
WHERE
tblc_usuario.id_usua =  '$IdUsua' $cond
ORDER BY
tblc_campus.IdCampus ASC,
tblc_usuario.Nombre ASC
");

  ?>
  <div class="box-body">
    <input type="hidden" name="nom_" id="nom_" value="Lista de alumnos">
    <table class="table table-striped">
                <tbody>

                <?php $v = 0; $i = 0; $f = 0; while($use = $db->recorrer($sql_use)){
                   $i = $use['IdCampus'];
                  if($i <> $f){  ?>
                <tr style="background: #a6a6a6;">
                  <th colspan="4"><?php echo $use['Campus']; ?></th>
                </tr><?php } ?>
                <tr>
                  <td><?php echo $v = $v + 1; ?>.- </td>
                  <td><?php echo $use['Usuario']; ?></td>
                  <td><?php echo $use['Nombre'].' '.$use['APaterno'].' '.$use['AMaterno']; ?></td>
                  <td><?php echo $use['Estatus']; ?></td>
                </tr><?php $f = $use['IdCampus']; } ?>
              </tbody></table>


  </div>

  <script>
    $(document).ready(function(){
      var nom_ = document.getElementById("nom_").value;
      document.getElementById('lbl_Pre').innerHTML = nom_;
    });
  </script>
