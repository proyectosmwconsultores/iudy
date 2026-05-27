<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdDocente = $_POST['IdDocente'];

  $sql_seg = $db->query("SELECT tblc_docdocentes.IdDocDocente,tblc_docdocentes.Anio, tblc_docdocentes.Mes, tblc_docdocentes.Archivo, tblc_docdocentes.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.IdEstatus, tblc_estatus.Estatus FROM tblc_docdocentes Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docdocentes.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docdocentes.Estatus WHERE tblc_docdocentes.IdUsua = '$IdDocente' ORDER BY tblc_docdocentes.FecCap DESC");
  ?>
<?php  ?>
<table class="table table-striped">
  <tbody>

      <tr style="background: #aeaaaa; color: #000; font-size: 12px; ">
        <th colspan="6">Lista de documentos subidos por el docente</th>
      </tr>
      <tr style="background: #e1dede; color: #000; font-size: 12px;">
        <th>#</th>
        <th>Nombre del documento</th>
        <th>Estatus</th>
        <th>Fec. captura</th>
        <th>Ajuste</th>
      </tr>
      <?php $xc = 0;
       while($_seg = $db->recorrer($sql_seg)){
      ?>
      <tr style="font-size: 12px;">
        <td><b><?php echo $xc = ($xc + 1); ?>.- </b></td>
        <td><?php echo $_seg["NomDocumento"]; ?></td>
        <td><?php echo $_seg["Estatus"]; ?></td>
        <td><?php echo $_seg["FecCap"]; ?></td>
        <td>
          <?php if($_seg["IdEstatus"] <> 12){ ?>
          <button onclick="ver_docs_docente(<?php echo $_seg["IdDocDocente"]; ?>)" type="button" class="btn btn-primary btn-xs"> <i class="fa fa-fw fa-eye"></i> Ver</button>
          <?php } ?>
          <?php if(($_seg["IdEstatus"] <> 4) && ($_seg["IdEstatus"] <> 12)){ ?>
          <button onclick="mod_estatusx(<?php echo $_seg["IdDocDocente"]; ?>,<?php echo $IdDocente; ?>, 4)" title="Aprobar documento" type="button" class="btn btn-success btn-xs"> <i class="fa fa-fw fa-check-circle"></i></button>
          <button onclick="mod_estatusx(<?php echo $_seg["IdDocDocente"]; ?>,<?php echo $IdDocente; ?>, 5)" title="No aprobar documento" type="button" class="btn btn-danger btn-xs"> <i class="fa fa-fw fa-times-circle"></i></button>
          <?php } ?>
          </td>
      </tr>
  <?php }  ?>
</tbody></table>
