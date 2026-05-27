<?php
require('../php/clases/class.php');
  require('../hace.php');
  $t=new Trabajo();

  $sql_mat=$t->get_rep_mat_asg();

  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de actas de calificaciones publicadas recientemente</h3>
  </div>
  
  <div class="box-body">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th style="width: 10px;"></th>
          <th>CAMPUS</th>
          <th>PLAN DE ESTUDIOS</th>
          <th>NOMBRE DE LA MATERIA</th>
          <th>NOMBRE DEL DOCENTE</th>
          <th>GRUPO</th>
          <th>PUBLICADO</th>
          <th>ACTA</th>
          <th>SCANEADO</th>
        </tr>

        <?php $_a = 0;
        for ($i=0;$i< sizeof($sql_mat);$i++) {  ?>
        <tr>
          <td><b><?php echo $_a = ($_a + 1); ?>.- </b></td>
          <td><?php echo $sql_mat[$i]['Campus']; ?></td>
          <td><?php echo $sql_mat[$i]['Educativa']; ?></td>
          <td><?php echo $sql_mat[$i]['CodeModulo'].' - '.$sql_mat[$i]['NombreMod']; ?></td>
          <td><?php echo $sql_mat[$i]['APaterno'].' '.$sql_mat[$i]['AMaterno'].' '.$sql_mat[$i]['Nombre']; ?></td>
          <td><?php echo $sql_mat[$i]["CveGrupo"]; ?> - <?php echo $sql_mat[$i]["_Modalidad"]; ?> - <?php echo $sql_mat[$i]["_Dias"]; ?></td>
          <td><?php echo tiempo_transcurrido($sql_mat[$i]['_fecEnvio']); ?></td>
          <td style="text-align: center;"><?php if($sql_mat[$i]['Fecha_impresion']){ ?>
            <button onclick="javascript:window.open('repositorio/portafolio/acta_calificacion_final.php?tokenId=<?php echo $sql_mat[$i]['IdAsignacion']; ?>');" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat btn-xs"><i class='fa fa-fw fa-download'></i></button>
          <?php } ?></td>
          
          <td style="text-align: center;"><?php if($sql_mat[$i]['Plantel']){ ?>
            <button onclick="javascript:window.open('assets/docs/adjunto/<?php echo $sql_mat[$i]['Anio']; ?>/<?php echo $sql_mat[$i]['Plantel']; ?>');" href="javascript:void(0);" title="Descargar acta de calificación con firma digital" type="button" class="btn bg-maroon btn-flat btn-xs"><i class='fa fa-fw fa-download'></i></button>
          <?php } ?></td>
        </tr>
        <?php }  ?>
   </tbody></table>

 </div>
