<?php
  require('../../php/clases/consulta_escolar.php');
  
  $escolar=new Escolar();
  $IdCiclo = $_POST['IdCiclo'];
  
  $sql_user=$escolar->get_lista_us($IdCiclo);
  
  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de trayectoria de los alumnos</h3>
  </div>
  

  <div class="box-body">
  <form name="frm22" id="frm22" action="updGrupo.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <?php $v = 0; $oi = 0; $of = 0;
      for ($i = 0; $i < sizeof($sql_user); $i++) { 
      //while ($x = $db->recorrer($sql_user)) { 
        $oi = $sql_user[$i]['IdOferta'];
      if($oi <> $of){ ?>
        <tr style="background: #d8caff;">
          <td colspan="4"><b><?php echo $sql_user[$i]['Nombre']; ?></b></td>
        </tr>
      <?php }
      ?>
        <tr>
          <td style="width: 15px;"><b><?php echo $v = ($v + 1); ?>.- </b></td>
          <td><?php echo $sql_user[$i]['Grado']; ?>° <?php echo $sql_user[$i]['CveGrupo']; ?></td>
          <td><?php echo $sql_user[$i]['_Dias']; ?></td>
          <td>
            <?php if($sql_user[$i]['Migrado'] == 1){ ?>
              <button onclick="cargar_lista_alumnos(<?php echo $sql_user[$i]['IdGrupo']; ?>)" type="button" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-fw fa-check-circle"></i> Migrado</button>
            <?php } else { ?>
              <button onclick="cargar_lista_alumnos(<?php echo $sql_user[$i]['IdGrupo']; ?>)" type="button" class="btn bg-navy btn-flat btn-sm"><i class="fa fa-fw fa-warning"></i> Procesar migración</button>
            <?php  } ?>            
          </td>
        </tr><?php $of = $sql_user[$i]['IdOferta']; } ?>
    </tbody>
  </table>
  </div>
</form>
  </div>
