<?php
  require('../php/clases/class.php');
  $t=new Trabajo();
  $IdCampus = $_POST['IdCampus'];
  $IdCiclo = $_POST['IdCiclo'];
  include('../hace.php');
  $sql_gral=$t->get_lst_enc_gral($IdCampus,$IdCiclo);
  $sql_grp=$t->get_lst_enc_xgrp($IdCampus,$IdCiclo);
  $sql_plan=$t->get_lst_enc_plan($IdCampus,$IdCiclo);
  $sql_nivel=$t->get_lst_enc_nivel($IdCampus,$IdCiclo);

  ?>

<table class="table table-striped" style="font-size: 12px;">
  <tbody>
    <tr style="background: #94FFFF; color: black;">
      <th colspan="3"><i class="fa fa-fw fa-flag-checkered"></i> PROMEDIO POR MATERIA</th>
    </tr>
    <?php $oi=0; $of=0; for ($i=0;$i< sizeof($sql_gral);$i++){ $oi=$sql_gral[$i]['IdGrupo'];
      if($oi <> $of){ ?>
        <tr style="background: #39CCCC; color: black;">
          <th colspan="3"><i class="fa fa-fw fa-folder-open"></i> <?php echo $sql_gral[$i]['Educativa']; ?> - <?php echo $sql_gral[$i]['CveGrupo'].' - '.$sql_gral[$i]['_Modalidad'].' - '.$sql_gral[$i]['_Dias']; ?></th>
        </tr>
      <?php }?>
    <tr>
      <td><?php echo $sql_gral[$i]['NombreMod']; ?></td>
      <td><?php echo $sql_gral[$i]['Nombre'].' '.$sql_gral[$i]['APaterno'].' '.$sql_gral[$i]['AMaterno']; ?></td>
      <td style="text-align: center; "><?php echo $sql_gral[$i]['Promedio']; ?></td>
    </tr><?php $of=$sql_gral[$i]['IdGrupo']; } ?>
  </tbody>
</table>
<br>
<table class="table table-striped" style="font-size: 12px;">
  <tbody>
    <tr style="background: #94FFFF; color: black;">
      <th colspan="2"><i class="fa fa-fw fa-flag-o"></i> PROMEDIO POR GRUPO</th>
    </tr>
    <?php $ei=0; $ef=0; for ($i=0;$i< sizeof($sql_grp);$i++){ $ei=$sql_grp[$i]['IdEducativa'];
      if($ei <> $ef){ ?>
        <tr style="background: #39CCCC; color: black;">
          <th colspan="2"><i class="fa fa-fw fa-folder-open"></i> <?php echo $sql_gral[$i]['Educativa']; ?></th>
        </tr>
      <?php }?>
    <tr>
      <td><?php echo $sql_grp[$i]['CveGrupo'].' - '.$sql_grp[$i]['_Modalidad'].' - '.$sql_grp[$i]['_Dias']; ?></td>
      <td style="text-align: center; "><?php echo $sql_grp[$i]['Promedio']; ?></td>
    </tr><?php $ef=$sql_grp[$i]['IdEducativa']; } ?>
  </tbody>
</table>

<br>
<table class="table table-striped" style="font-size: 12px;">
  <tbody>
    <tr style="background: #94FFFF; color: black;">
      <th colspan="2"><i class="fa fa-fw fa-flag"></i> PROMEDIO POR OFERTA EDUCATIVA</th>
    </tr>
    <?php $pi=0; $pf=0; for ($i=0;$i< sizeof($sql_plan);$i++){ $pi=$sql_plan[$i]['IdGrado'];
      if($pi <> $pf){ ?>
        <tr style="background: #39CCCC; color: black;">
          <th colspan="2"><i class="fa fa-fw fa-folder-open"></i> <?php echo $sql_plan[$i]['_Grado']; ?></th>
        </tr>
      <?php }?>
    <tr>
      <td><?php echo $sql_plan[$i]['Educativa']; ?></td>
      <td style="text-align: center; "><?php echo $sql_plan[$i]['Promedio']; ?></td>
    </tr><?php $pf=$sql_plan[$i]['IdGrado']; } ?>
  </tbody>
</table>

<br>
<table class="table table-striped" style="font-size: 12px;">
  <tbody>
    <tr style="background: #94FFFF; color: black;">
      <th colspan="2"><i class="fa fa-fw fa-flag"></i> PROMEDIO POR GRADO DE ESTUDIO</th>
    </tr>
    <?php for($i=0;$i< sizeof($sql_nivel);$i++){ ?>
    <tr>
      <td><?php echo $sql_nivel[$i]['_Grado']; ?></td>
      <td style="text-align: center; "><?php echo $sql_nivel[$i]['Promedio']; ?></td>
    </tr><?php } ?>
  </tbody>
</table>

<table id="datatable_banco" style="display: none;">
  <thead>
    <tr>
      <th></th>
      <?php for ($_b=0;$_b< sizeof($sql_plan);$_b++) { ?>
      <th><?php echo $sql_plan[$_b]['Educativa']; ?></th><?php } ?>
    </tr>
  </thead>
  <tbody>
    <tr>
      <?php for ($_b=0;$_b< sizeof($sql_plan);$_b++) { ?>
      <td><?php echo $sql_plan[$_b]['Educativa']; ?></td>
      <td><?php echo $sql_plan[$_b]['Promedio']; ?></td><?php } ?>
    </tr>

  </tbody>
</table>


<div id="container_banco"></div>
<?php if($_b){ ?>
<br>
<button onClick="window.open('dashboard/resultado_encuesta_gral_ex.php?IdCampus=<?php echo $IdCampus; ?>&IdCiclo=<?php echo $IdCiclo; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-cloud-download"></i> Descargar excel</button>
<?php } ?>
<script>
Highcharts.chart('container_banco', {
  data: {
    table: 'datatable_banco'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: 'PROMEDIO POR OFERTA EDUCATIVA'
  },
  yAxis: {
    allowDecimals: false,
    title: {
      text: 'Promedio'
    }
  },
  tooltip: {
    formatter: function () {
      return '<b>' + this.series.name + '</b> ' +this.point.y;
    }
  }
});
</script>
