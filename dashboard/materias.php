<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION['IdUsua'];

  $sql_mat = $db->query("SELECT
tblp_educativa.IdEducativa,
tblp_educativa.Nombre,
tblp_modulo.NombreMod
FROM
tblp_educativa
Left Join tblp_modulo ON tblp_modulo.IdEducativa = tblp_educativa.IdEducativa
 WHERE tblp_educativa.id_usua = '$IdUsua'
ORDER BY
tblp_educativa.IdEducativa ASC
");

  ?>
  <div class="box-body">
    <input type="hidden" name="nom_" id="nom_" value="Mis materias agregadas">
    <table class="table table-striped">
                <tbody>

                <?php $v = 0; $i = 0; $f = 0; while($mat = $db->recorrer($sql_mat)){ if($mat['NombreMod']){ $i = $mat['IdEducativa'];
                  if($i <> $f){ ?>
                <tr style="background: #a6a6a6;">
                  <th colspan="2"><?php echo $mat['Nombre']; ?></th>
                </tr><?php } ?>
                <tr>
                  <td><?php echo $v = $v + 1; ?>.- </td>
                  <td><?php echo $mat['NombreMod']; ?></td>
                </tr><?php $f = $mat['IdEducativa']; } } ?>
              </tbody></table>


  </div>

  <script>
    $(document).ready(function(){
      var nom_ = document.getElementById("nom_").value;
      document.getElementById('lbl_Pre').innerHTML = nom_;
    });
  </script>
