<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/consulta_class.php');
  $t=new Consultas();
  
  
  $IdCampus = $_POST['IdCampus'];


   $rep = $t->get_alumnos_all_ins($IdCampus);
  
  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de alumnos</h3>
  </div>
  <div class="box-body">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th colspan="11" style="background: #aaafff;">REPORTE DE ALUMNOS</th>
        </tr>
        <tr>
          <th></th>
          <th>PLAN DE ESTUDIOS</th>
          <th>USUARIO</th>
          <th>NOMBRE DEL ALUMNO</th>
          <th>ESTATUS</th>
          <th style="text-align: center;">PAGO GENERADO</th>
          <th style="text-align: center;">FECHA DE PAGO</th>
          <th style="text-align: center;">ESTATUS</th>
          <th style="text-align: center;">MONTO</th>
          <th style="text-align: center;">TOTAL PAGADO</th>
          <th style="text-align: center;">PENDIENTE POR PAGAR</th>
        </tr>
      <?php 
      $v = 0; $s= 0;
      for ($n=0;$n< sizeof($rep);$n++) { 
        $monto = $t->get_alumnos_titulacion($rep[$n]['IdUsua']);
        ?>
      <tr>
        <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
        <td><?php echo $rep[$n]['Educativa']; ?></td>        
        <td><?php echo $rep[$n]['Usuario']; ?></td>        
        <td><?php echo $rep[$n]['Nombre']; ?> <?php echo $rep[$n]['APaterno']; ?> <?php echo $rep[$n]['AMaterno']; ?></td>
        <td><?php echo $rep[$n]['Estatus']; ?></td>        
        <td style="text-align: center;"><?php if(isset($monto[0])) { if(($monto[0]['IdEstatus'] == 1) || ($monto[0]['IdEstatus'] == 4)){ echo "SI"; }  else { echo "NO"; }  } else { echo "NO"; } ?></td>
        <td style="text-align: center;"><?php if(isset($monto[0])) { echo $monto[0]['Fecha']; } else { echo "NO"; } ?></td>
        <td style="text-align: center;"><?php if(isset($monto[0])) { if($monto[0]['IdEstatus'] == 4) { echo "PAGADO"; }   else { echo "PENDIENTE"; } } ?></td>
        <td style="text-align: center;"><?php if(isset($monto[0])) { echo number_format($monto[0]['Monto'], 2, '.', ',');  }   else { echo ""; }  ?></td>
        <td style="text-align: center;"><?php if(isset($monto[0])) { echo number_format($monto[0]['Total'], 2, '.', ',');  }   else { echo ""; }  ?></td>
        <td style="text-align: center;"><?php if(isset($monto[0])) { $totalz =  ($monto[0]['Monto'] - $monto[0]['Total']  - $monto[0]['Descuento'] - $monto[0]['Descuento2']); echo number_format($totalz, 2, '.', ','); }   else { echo ""; }  ?></td>
      </tr>
      <?php  } ?>
    
    </tbody></table>

    <button onClick="window.open('dashboard/reporte_pagos_titulacion.php?IdCampus=<?php echo $_POST['IdCampus']; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-warning btn-sm"><i class="fa fa-fw fa-cloud-download"></i> Descargar en Excel</button>
  </div>
