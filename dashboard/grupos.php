<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION['IdUsua'];
  $IdEstatus = $_POST['IdEstatus'];
  if($IdEstatus == 0){
    $cond = "";
  } else {
    $cond = " AND tblp_grupo.IdEstatus = '$IdEstatus' ";
  }
  $sql_grp = $db->query("SELECT
tblc_campus.IdCampus,
tblc_campus.Campus,
tblp_grupo.CveGrupo,
tblc_estatus.Estatus
FROM
tblc_campus
Left Join tblp_grupo ON tblp_grupo.IdCampus = tblc_campus.IdCampus
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_grupo.IdEstatus
WHERE
tblc_campus.id_usua =  '$IdUsua' AND
tblp_grupo.id_usua =  '$IdUsua' $cond
ORDER BY
tblp_grupo.IdCampus ASC,
tblc_estatus.IdEstatus ASC

");

  ?>
  <div class="box-body">
    <input type="hidden" name="nom_" id="nom_" value="Mis grupos agregados">
    <table class="table table-striped">
                <tbody>

                <?php $v = 0; $i = 0; $f = 0; while($grp = $db->recorrer($sql_grp)){ $i = $grp['IdCampus'];
                  if($i <> $f){ ?>
                <tr style="background: #a6a6a6;">
                  <th colspan="3"><?php echo $grp['Campus']; ?></th>
                </tr><?php } ?>
                <tr>
                  <td><?php echo $v = $v + 1; ?>.- </td>
                  <td><?php echo $grp['CveGrupo']; ?></td>
                  <td><?php echo $grp['Estatus']; ?></td>
                </tr><?php $f = $grp['IdCampus']; } ?>
              </tbody></table>


  </div>

  <script>
    $(document).ready(function(){
      var nom_ = document.getElementById("nom_").value;
      document.getElementById('lbl_Pre').innerHTML = nom_;
    });
  </script>
