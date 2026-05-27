<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/consulta_class.php');
  $t=new Consultas();
  
  $IdCiclo = $_POST['IdCiclo'];
  $IdCampus = $_POST['IdCampus'];


   
   $total = $t->get_alumnos_por_rvoe($IdCampus,$IdCiclo);
   $rep = $t->get_alumnos_por_rvoe_reprob($IdCampus,$IdCiclo);
   

  // $sql_lst = $db->query("SELECT tblc_alumnos.IdActivo, tblc_usuario.IdEstatus, tblc_rvoe.Educativa, tblc_rvoe.Rvoe, tblc_campus.Campus, tblc_rvoe.IdRvoe, Count(tblc_usuario._idRvoe) AS Total FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe Left Join tblc_campus ON tblc_campus.IdCampus = tblc_rvoe.IdCampus WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' GROUP BY tblc_usuario._idRvoe");
//$sql_8 = $db->query("SELECT tblc_alumnos.IdActivo, Count(tblc_usuario._idRvoe) AS Total FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario._idRvoe =  '".$mat['IdRvoe']."' AND tblc_usuario.IdEstatus =  '8' GROUP BY tblc_usuario._idRvoe ");
  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de alumnos por rvoe</h3>
  </div>
  <div class="box-body">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th></th>
          <th>CAMPUS RVOE</th>
          <th>RVOE</th>
          <th>PLAN DE ESTUDIOS</th>
          <th style="text-align: center;">ACTIVOS</th>
          <th style="text-align: center;">CONCLUIDOS</th>
          <th style="text-align: center;">EGRESADOS</th>
          <th style="text-align: center;">GRADUADOS</th>
          <th style="text-align: center;">BAJA TEMPORAL</th>
          <th style="text-align: center;">BAJA DEFINITIVA</th>
          <th style="text-align: center;">TOTAL</th>
        </tr>
      <?php 
      $v = 0; $var8  =  0; $var61  =  0; $var62  =  0; $var55  =  0; $var14  =  0; $var15  =  0; $var0  =  0; 
      for ($i=0;$i< sizeof($total);$i++) { 
        $estatus_8 = $t->get_alumnos_por_rvoe_estatus($IdCampus,$IdCiclo,$total[$i]['IdRvoe'],8);
        $estatus_61 = $t->get_alumnos_por_rvoe_estatus($IdCampus,$IdCiclo,$total[$i]['IdRvoe'],61);
        $estatus_62 = $t->get_alumnos_por_rvoe_estatus($IdCampus,$IdCiclo,$total[$i]['IdRvoe'],62);
        $estatus_55 = $t->get_alumnos_por_rvoe_estatus($IdCampus,$IdCiclo,$total[$i]['IdRvoe'],55);
        $estatus_14 = $t->get_alumnos_por_rvoe_estatus($IdCampus,$IdCiclo,$total[$i]['IdRvoe'],14);
        $estatus_15 = $t->get_alumnos_por_rvoe_estatus($IdCampus,$IdCiclo,$total[$i]['IdRvoe'],15);
        
       
        
        
        
        
        

        ?>
      <tr>
        <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
        <td><?php echo $total[$i]['Campus'];  ?></td>
        <td><?php echo $total[$i]['Rvoe']; ?></td>        
        <td><?php echo $total[$i]['Educativa']; ?></td>        
        <td style="text-align: center; cursor: pointer;" onclick="mostrar_lista_user(<?php echo $IdCampus.','.$IdCiclo.','.$total[$i]['IdRvoe'].',8'; ?>)"><?php if(isset($estatus_8[0]['Total'])){ echo $estatus_8[0]['Total']; $var8 = ($var8 + $estatus_8[0]['Total']); } else { echo "--";}  ?></td>
        <td style="text-align: center; cursor: pointer;" onclick="mostrar_lista_user(<?php echo $IdCampus.','.$IdCiclo.','.$total[$i]['IdRvoe'].',61'; ?>)"><?php if(isset($estatus_61[0]['Total'])){ echo $estatus_61[0]['Total'];  $var61 = ($var61 + $estatus_61[0]['Total']); } else { echo "--";}  ?></td>
        <td style="text-align: center; cursor: pointer;" onclick="mostrar_lista_user(<?php echo $IdCampus.','.$IdCiclo.','.$total[$i]['IdRvoe'].',62'; ?>)"><?php if(isset($estatus_62[0]['Total'])){ echo $estatus_62[0]['Total']; $var62 = ($var62 + $estatus_62[0]['Total']); } else { echo "--";}  ?></td>
        <td style="text-align: center; cursor: pointer;" onclick="mostrar_lista_user(<?php echo $IdCampus.','.$IdCiclo.','.$total[$i]['IdRvoe'].',55'; ?>)"><?php if(isset($estatus_55[0]['Total'])){ echo $estatus_55[0]['Total']; $var55 = ($var55 + $estatus_55[0]['Total']); } else { echo "--";}  ?></td>
        <td style="text-align: center; cursor: pointer;" onclick="mostrar_lista_user(<?php echo $IdCampus.','.$IdCiclo.','.$total[$i]['IdRvoe'].',14'; ?>)"><?php if(isset($estatus_14[0]['Total'])){ echo $estatus_14[0]['Total']; $var14 = ($var14 + $estatus_14[0]['Total']); } else { echo "--";}  ?></td>
        <td style="text-align: center; cursor: pointer;" onclick="mostrar_lista_user(<?php echo $IdCampus.','.$IdCiclo.','.$total[$i]['IdRvoe'].',15'; ?>)"><?php if(isset($estatus_15[0]['Total'])){ echo $estatus_15[0]['Total']; $var15 = ($var15 + $estatus_15[0]['Total']); } else { echo "--";}  ?></td>
        <td style="text-align: center; cursor: pointer;" onclick="mostrar_lista_user(<?php echo $IdCampus.','.$IdCiclo.','.$total[$i]['IdRvoe'].',0'; ?>)"><?php echo $total[$i]['Total']; $var0 = ($var0 + $total[$i]['Total']); ?></td>
        
      </tr>
      <?php } ?>
      <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <td style="text-align: center;">ACTIVOS</td>
          <td style="text-align: center;">CONCLUIDOS</td>
          <td style="text-align: center;">EGRESADOS</td>
          <td style="text-align: center;">GRADUADOS</td>
          <td style="text-align: center;">BAJA TEMPORAL</td>
          <td style="text-align: center;">BAJA DEFINITIVA</td>
          <td style="text-align: center;">TOTAL</td>
        </tr>
        <tr>
          <th colspan="4" style="text-align: right;">TOTAL:</th>
          <th style="text-align: center; background: yellow;"><?php echo $var8; ?></th>
          <th style="text-align: center; background: yellow;"><?php echo $var61; ?></th>
          <th style="text-align: center; background: yellow;"><?php echo $var62; ?></th>
          <th style="text-align: center; background: yellow;"><?php echo $var55; ?></th>
          <th style="text-align: center; background: yellow;"><?php echo $var14; ?></th>
          <th style="text-align: center; background: yellow;"><?php echo $var15; ?></th>
          <th style="text-align: center; background: yellow;"><?php echo $var0; ?></th>
        </tr>
    </tbody></table>
    <hr>
    <button onclick="window.open('dashboard/exp_alumnos_inscritos.php?IdCiclo=<?php echo $IdCiclo; ?>','_self')" href="javascript:void(0);" type="button" class="btn bg-purple btn-flat margin"><i class="fa fa-fw fa-cloud-download"></i> Descargar concentrado SEP</button>
    <br><br>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th colspan="7" style="background: #aaafff;">REPORTE DE ALUMNOS REPROBADOS</th>
        </tr>
        <tr>
          <th></th>
          <th>CAMPUS RVOE</th>
          <th>RVOE</th>
          <th>PLAN DE ESTUDIOS</th>
          <th style="text-align: center;">TOTAL INSCRITOS</th>
          <th style="text-align: center;">TOTAL REPROBADOS</th>
          <th style="text-align: center;">% DESERCIÓN</th>
        </tr>
      <?php 
      $v = 0; $s= 0;
      for ($n=0;$n< sizeof($rep);$n++) { 
        $totalall = $t->get_alumnos_inscritos_rvoe_total($IdCampus,$IdCiclo,$rep[$n]['IdRvoe']);
        $reptotal = $t->get_alumnos_reprobados_rvoe_total($IdCampus,$IdCiclo,$rep[$n]['IdRvoe']);
        $sux = 0;
        for ($sx=0;$sx< sizeof($reptotal);$sx++) { 
          $sux = ($sux + 1);
        }

        $porcentaje = 0;

        $porcentaje = ($sux / $totalall[0]['Total']);
        $porcentaje = round(($porcentaje * 100), 2);

         ?>
      <tr>
        <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
        <td><?php echo $rep[$n]['Campus'];  ?></td>
        <td><?php echo $rep[$n]['Rvoe']; ?></td>        
        <td><?php echo $rep[$n]['Educativa']; ?></td>        
        <td style="text-align: center;"><?php echo $totalall[0]['Total']; ?></td>
        <td style="text-align: center; cursor: pointer;" onclick="mostrar_lista_user_reprobados(<?php echo $IdCampus.','.$IdCiclo.','.$rep[$n]['IdRvoe']; ?>)"><?php echo $sux; ?></td>
        <td style="text-align: center; cursor: pointer;" onclick="mostrar_lista_user_reprobados(<?php echo $IdCampus.','.$IdCiclo.','.$rep[$n]['IdRvoe']; ?>)"><?php echo $porcentaje; ?>%</td>
      </tr>
      <?php $s = ($s + $rep[$n]['Total']); } ?>
    
    </tbody></table>
  </div>
