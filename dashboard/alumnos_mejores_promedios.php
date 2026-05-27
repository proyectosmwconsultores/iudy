<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/consulta_class.php');
  $t=new Consultas();
  
  $IdOferta = $_POST['IdOferta'];
  $IdPeriodo = $_POST['IdPeriodo'];
     
   $total = $t->get_alumnos_mejores_promedios($IdOferta,$IdPeriodo);
  
  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de alumnos por rvoe</h3>
  </div>
  <div class="box-body">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th></th>
          <th>MATRICULA</th>
          <th>NOMBRE</th>
          <th style="text-align: center;">PORCENTAJE</th>
          <th style="text-align: center;">GRADO</th>
          <th style="text-align: center;">PROMEDIO</th>
        </tr>
      <?php  $v  = 0;
      for ($i=0;$i< sizeof($total);$i++) {  ?>
      <tr>
        <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
        <td><?php echo $total[$i]['Usuario'];  ?></td>
        <td><?php echo $total[$i]['Nombre'];  ?> <?php echo $total[$i]['APaterno'];  ?> <?php echo $total[$i]['AMaterno'];  ?></td>
        <td style="text-align: center;"><?php echo $total[$i]['porcentaje']; ?>%</td>        
        <td style="text-align: center;"><?php echo $total[$i]['Grado']; ?>°</td>        
        <td style="text-align: center;"><?php echo $total[$i]['Promedio']; ?></td>        
      </tr>
      <?php } ?>
    </tbody></table>
    <hr>
    <br><br>
    
  </div>
