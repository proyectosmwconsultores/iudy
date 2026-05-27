<?php
  require('../php/clases/class.php');
  $t=new Trabajo();
  $IdCampus = $_POST['IdCampus'];
  $IdCiclo = $_POST['IdCiclo'];
  $Dias = $_POST['Dias'];
  $sql_mat=$t->get_calen_mat_asg($IdCampus,$IdCiclo,$Dias);

  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de materias asignadas a los docentes en un periodo escolar</h3>
  </div>
  <div class="col-xs-12" style="position: absolute; z-index:0; text-align: center; display: none;" id="btn_img">
    <img src="assets/images/procesando.gif">
  </div>
  <div class="box-body">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <?php $_a = 0; $p_i = 0; $p_f = 0;
        for ($i=0;$i< sizeof($sql_mat);$i++) { $p_i = $sql_mat[$i]["IdGrupo"];
          if($p_i <> $p_f){ $_a = 0; ?>
            <tr style="background: #00c0ef;">
              <th colspan="9" style="color: black;"><i class="fa fa-fw fa-check-circle"></i> <?php echo $sql_mat[$i]["Grado"]; ?>° <?php echo $sql_mat[$i]["Educativa"]; ?> - <?php echo $sql_mat[$i]["CveGrupo"]; ?> - <?php echo $sql_mat[$i]["_Modalidad"]; ?> - <?php echo $sql_mat[$i]["_Dias"]; ?></th>
            </tr>
            <tr>
              <th style="width: 10px;"></th>
              <th>NOMBRE DE LA MATERIA</th>
              <th>NOMBRE DEL DOCENTE</th>
              <th>INICIA</th>
              <th>FINALIZA</th>
              <th>ESTATUS</th>
              <th>ACTA</th>
              <th>SCANEADO</th>
              <th>ASISTENCIA</th>
            </tr>
          <?php } ?>
        <tr>
          <td><b><?php echo $_a = ($_a + 1); ?>.- </b></td>
          <td><?php echo $sql_mat[$i]['CodeModulo'].' - '.$sql_mat[$i]['NombreMod']; ?></td>
          <td><?php echo $sql_mat[$i]['APaterno'].' '.$sql_mat[$i]['AMaterno'].' '.$sql_mat[$i]['Nombre']; ?></td>
          <td><?php echo $sql_mat[$i]['FecIni']; ?></td>
          <td><?php echo $sql_mat[$i]['FecFin']; ?></td>
          <td><?php echo $sql_mat[$i]['Estatus']; ?></td>
          <td style="text-align: center;"><?php if($sql_mat[$i]['Fecha_impresion']){ ?>
            <button onclick="javascript:window.open('repositorio/portafolio/acta_calificacion_final.php?tokenId=<?php echo $sql_mat[$i]['IdAsignacion']; ?>&f=1');" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat btn-xs"><i class='fa fa-fw fa-download'></i></button>
          <?php } ?></td>
          <td style="text-align: center;"><?php if($sql_mat[$i]['Plantel']){ ?>
            <button onclick="javascript:window.open('assets/docs/adjunto/<?php echo $sql_mat[$i]['Anio']; ?>/<?php echo $sql_mat[$i]['Plantel']; ?>');" href="javascript:void(0);" title="Descargar acta de calificación con firma digital" type="button" class="btn bg-maroon btn-flat btn-xs"><i class='fa fa-fw fa-download'></i></button>
          <?php } ?></td>
          <td style="text-align: center;"><?php if($sql_mat[$i]['Fecha_impresion']){ ?>
            <button onclick="javascript:window.open('repositorio/portafolio/asistencia_licenciatura_ejecutiva.php?tokenId=<?php echo $sql_mat[$i]['IdAsignacion']; ?>&tok=1');" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat btn-xs"><i class='fa fa-fw fa-download'></i></button>
          <?php } ?></td>
        </tr>
        <?php $p_f = $sql_mat[$i]["IdGrupo"]; }  ?>
   </tbody></table>

 </div><br>
  <button onClick="window.open('dashboard/ex_calendario_materias_asignadas.php?IdCampus=<?php echo $IdCampus; ?>&IdCiclo=<?php echo $IdCiclo; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-cloud-download"></i> Descargar excel</button>
