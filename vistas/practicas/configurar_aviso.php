<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();
$Anio = date("Y");
$IdCiclo = $_POST['IdCiclo'];
$IdAviso = $_POST['IdAviso'];

$sql_grp = $db->query("SELECT
tblc_ciclogrupo.IdGrupo,
tblp_grupo.IdOferta,
tblp_educativa.Nombre,
tblc_campus.Campus,
tblp_grupo.IdCampus
FROM
tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
WHERE
tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND
tblc_ciclogrupo.Grado >=  4 AND
tblp_educativa.IdGrado =  '3'
GROUP BY
tblp_grupo.IdOferta,
tblp_grupo.IdCampus
ORDER BY tblp_grupo.IdCampus ASC, tblp_grupo.IdOferta ASC
");

?>

<table class="table table-bordered">
  <tbody> 
    <?php $ci = 0; $cf = 0; while ($_grp = $db->recorrer($sql_grp)) {
      $ci = $_grp['IdCampus'];
      $IdOf = $_grp['IdOferta'];
      if($ci <> $cf){ ?>
        <tr style="background: #e3ccff;">
        <th><i class="fa fa-fw fa-bank"></i> <?php echo $_grp['Campus']; ?> </th>
      </tr>
      <?php }
      $sql_sel = $db->query("SELECT tblc_ciclogrupo.IdGrupo, tblc_ciclogrupo.Grado, tblp_grupo.IdOferta, tblp_grupo.CveGrupo FROM tblc_ciclogrupo Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo WHERE tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND  tblp_grupo.IdOferta =  '$IdOf' AND tblp_grupo.IdCampus = '$ci' AND tblc_ciclogrupo.Grado >= 5 ORDER BY tblc_ciclogrupo.Grado ASC "); ?>
      <tr>
        <th><i class="fa fa-fw fa-book"></i> <?php echo $_grp['Nombre']; ?> </th>
      </tr>
      <tr>
        <td>
          <?php while ($_sel = $db->recorrer($sql_sel)) {
            $grpx = $db->query("SELECT tbla_aviso_practicas_detalle.IdDetalle FROM tbla_aviso_practicas_detalle WHERE tbla_aviso_practicas_detalle.IdAviso = '$IdAviso' AND tbla_aviso_practicas_detalle.IdGrupo = '".$_sel['IdGrupo']."'");
            $db->rows($grpx);
            $_gbx = $db->recorrer($grpx);
            $IdD = $_gbx['IdDetalle'];
            if($IdD){
              $_tipo = 0;
              $txt = 'primary';
            } else {
              $_tipo = 1;
              $txt = 'default';
            }
            
            ?>
            <button onclick="sel_grp_aviso(<?php echo $_sel['IdGrupo']; ?>,<?php echo $IdCiclo; ?>,<?php echo $IdAviso; ?>,<?php echo $_tipo; ?>)" type="button" class="btn btn-<?php echo $txt; ?>"><?php echo $_sel['Grado'] . '° ' . $_sel['CveGrupo'];; ?></button>
          <?php } ?>
        </td>
      </tr>
    <?php $cf = $_grp['IdCampus']; } ?>
  </tbody>
</table>

<script>
  function sel_grp_aviso(IdGrupo, IdCiclo, IdAviso,Tipo) {
    var TipoGuardar = 'sel_grp_actvar';
    $.ajax({
      type: "POST",
      url: "vistas/practicas/sav_desarrollo.php",
      data: {
        TipoGuardar:TipoGuardar,
            IdAviso: IdAviso,
            IdCiclo: IdCiclo,
            IdGrupo: IdGrupo,
            Tipo:Tipo
      },
        success: function(data) {
            $.ajax({
            url: "vistas/practicas/configurar_aviso.php",
            method: "POST",
            data: {
              IdAviso: IdAviso,
              IdCiclo:IdCiclo
            },
            success: function(data) {
              $('#employee_detailA').html(data);
              $('#dataModalA').modal('show');
            }
          });
          
      }
    });
  }
</script>