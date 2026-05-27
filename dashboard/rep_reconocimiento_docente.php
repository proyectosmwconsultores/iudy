<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST['IdUsua'];
  $IdDocente = $_POST['IdDocente'];

  //
  $sql_seg = $db->query("SELECT
tblp_reconocimiento.IdReconocimiento,
tblp_reconocimiento.Fecha,
tblp_reconocimiento.FecCap,
tblp_reconocimiento.Anio,
tblp_reconocimiento.Mes,
tblp_reconocimiento.Archivo,
tblc_tipo_reconocomiento.Reconocimiento
FROM
tblp_reconocimiento
Left Join tblc_tipo_reconocomiento ON tblc_tipo_reconocomiento.IdTipoReconocimiento = tblp_reconocimiento.IdTipo
WHERE tblp_reconocimiento.IdUsua = '$IdDocente'
ORDER BY
tblp_reconocimiento.Fecha DESC");

  ?>
  <button onclick="subir_reconox_upload(<?php echo $IdUsua; ?>,<?php echo $IdDocente; ?>)" type="button" class="btn btn-block btn-primary btn-sm"><i class="fa fa-fw fa-upload"></i> Subir reconocimiento</button>

<?php  ?>
<table class="table table-striped">
  <tbody>

      <tr style="background: #aeaaaa; color: #000; font-size: 12px; ">
        <th colspan="6">Lista de reconocimiento subidos al docente</th>
      </tr>
      <tr style="background: #e1dede; color: #000; font-size: 12px;">
        <th>#</th>
        <th>Tipo de reconocimiento</th>
        <th>Fec. Publicación</th>
        <th>Ajuste</th>

      </tr>
      <?php $xc = 0;
       while($_seg = $db->recorrer($sql_seg)){
      ?>
      <tr style="font-size: 12px;">
        <td><b><?php echo $xc = ($xc + 1); ?>.- </b></td>
        <td><?php echo $_seg["Reconocimiento"]; ?></td>
        <td><?php echo $_seg["Fecha"]; ?></td>
        <td>
          <button onclick="ver_reconx(<?php echo $_seg["IdReconocimiento"]; ?>)" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat"><i class="fa fa-fw fa-eye"></i></button>
          <button onclick="del_reconx(<?php echo $_seg["IdReconocimiento"]; ?>,<?php echo $IdUsua; ?>,<?php echo $IdDocente; ?>)" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat"><i class="fa fa-fw fa-trash"></i></button>
        </td>
      </tr>
  <?php }  ?>
</tbody></table>
