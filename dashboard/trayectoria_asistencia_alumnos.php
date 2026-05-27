<?php
  require('../php/clases/class.php');
  $t=new Trabajo();
  $Tipo = $_POST['Tipo'];
  $IdCampus = $_POST['IdCampus'];
  $IdGrupo = $_POST['IdGrupo'];
  include('../hace.php');
  $sql_lista_mat=$t->get_lst_tray_asig($IdGrupo);
  $sql_grp=$t->get_lst_grp($IdGrupo);
  if($Tipo == 'A'){ $txt = 'ASISTENCIA'; } elseif($Tipo == 'F'){ $txt = 'FALTAS'; } else { $txt = 'PERMISOS'; }

  $sql_cic=$t->get_lst_cic($IdGrupo,$Tipo);

  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de trayectoria de los alumnos</h3>
  </div>
  <div class="bg-maroon-active color-palette" style="padding: 8px;"><span style="color: yellow;"><i class="fa fa-fw fa-bookmark"></i> <?php echo $sql_grp[0]["Nombre"].' - '.$sql_grp[0]["_Modalidad"].' - '.$sql_grp[0]["_Dias"]; ?> </span></div>
  <?php $_as = 0; $p_i = 0; $p_f = 0;
  for ($i=0;$i< sizeof($sql_lista_mat);$i++) { $p_i = $sql_lista_mat[$i]["IdCiclo"]; ?>

  <div class="box-body">
    <?php
       $_user=$t->get_user_lista_tra($IdGrupo,$sql_lista_mat[$i]["IdCiclo"]);
       $_mat=$t->get_no_mat_tra($IdGrupo,$sql_lista_mat[$i]["IdCiclo"]);
       $_matlst=$t->get_no_mat_tralst($IdGrupo,$sql_lista_mat[$i]["IdCiclo"]);
    ?>
    <div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"> <i class="fa fa-fw fa-check-circle"></i> TRAYECTORIA DEL PERIODO ESCOLAR <?php echo $sql_lista_mat[$i]["Ciclo"]; ?></span></div>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th style="width: 10px;"><br>#</th>
          <th style="width: 50px;"><br>NO. CONTROL</th>
          <th style="width: 200px;"><br>NOMBRE DEL ALUMNO</th>
          <?php for ($ma=0;$ma< sizeof($_matlst);$ma++) { ?>
          <th style="width: 10px; text-align: center;"><?php echo $_matlst[$ma]["NombreMod"]; ?><?php if($_matlst[$ma]["FecIni"]){ echo '<br>'.obtenerAnioMes($_matlst[$ma]["FecIni"]); } ?></th>
          <?php } ?>
          <th style="width: 10px; background: white; text-align: center;">TOTAL <?php echo $txt; ?></th>
        </tr>

        <?php $cx = 0; $s_a = 0; $s_r = 0; $s_f = 0; $alu = 0; $c = 0;
        for ($x=0;$x< sizeof($_user);$x++) { $alu = ($alu + 1); $_as = 1; ?>
        <tr>
          <td><b><?php echo $c = ($c + 1); ?>.- </b></td>
          <td><?php echo $_user[$x]['Usuario']; ?></td>
          <td><?php echo $_user[$x]['APaterno'].' '.$_user[$x]['AMaterno'].' '.$_user[$x]['Nombre']; ?></td>
          <?php $_sum1 = 0; for ($m=0;$m< sizeof($_matlst);$m++) {
            $_total=$t->get_user_valor_tra($_user[$x]['IdUsua'],$_matlst[$m]['IdModulo'],$sql_lista_mat[$i]["IdCiclo"],$Tipo); ?>

          <td style="text-align: center; "><?php if(isset($_total[0])){ echo $_total[0][0]; $_sum1 = ($_sum1 + $_total[0][0]); } ?></td>
          <?php   } ?>

          <td style="text-align: center; "><?php echo  $_sum1; ?></td>
        </tr><?php

       } ?>
   </tbody></table>

  </div>
<?php $p_f = $sql_lista_mat[$i]["IdCiclo"]; }

$_txt_g1 = "GRÁFICA DE ".$txt." DEL GRUPO POR MATERIA";
?>
<br>
<div class="bg-gray-active color-palette" style="padding: 8px;"><span style="color: black;"><i class="fa fa-fw fa-bookmark"></i> REPORTE DE TRAYECTORIA DE <?php echo $txt; ?> POR MATERIA</span></div>
<input type="hidden" name="_g1" id="_g1" value="<?php echo $_txt_g1; ?>">
<table id="datatable_us" class="table table-striped" style="font-size: 12px; display: none;">

        <tbody>
          <tr>
            <th>Nombre de la materia</th>
            <th style="text-align: center;">Total</th>

          </tr>
            <?php for ($ci=0;$ci< sizeof($sql_cic);$ci++) { ?>
            <tr>
              <th><?php echo $sql_cic[$ci]['CodeModulo']; ?> <?php echo $sql_cic[$ci]['NombreMod']; ?> </th>
              <th style="text-align: center;"><?php echo $sql_cic[$ci]['Total']; ?></th>

            </tr><?php } ?> </tbody>
    </table>
    <figure class="highcharts-figure">
        <div id="container_us"></div>

    </figure>
    <script>
    var Texto = document.getElementById("_g1").value;

    Highcharts.chart('container_us', {
        data: {
            table: 'datatable_us'
        },
        chart: {
            type: 'column'
        },
        title: {
            text: Texto
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Total'
            }
        },
        tooltip: {
            formatter: function () {
                return this.point.name + ': <b>' + this.point.y + '<b>';
            }
        }
    });
    </script>
