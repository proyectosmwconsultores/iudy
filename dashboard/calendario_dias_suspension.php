<?php
  require('../php/clases/class.php');
  include('../hace.php');
  $t=new Trabajo();
  $Anio = $_POST['Anio'];

  $sql_mat=$t->get_calen_suspx($Anio);

  ?>
  <div class="bg-aqua color-palette" style="padding: 10px;"><span style="color: black;"> <i class="fa fa-fw fa-calendar"></i> Días de suspensión capturados</span></div>
  <div class="box-body">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th style="width: 10px;">#</th>
          <th>DIA DE SUSPENSIÓN</th>
          <th>MOTIVO</th>
          <th>FEC.CAP</th>
          <th>CAPTURADO POR</th>
          <th></th>
        </tr>
        <?php $_a = 0;  for ($i=0;$i< sizeof($sql_mat);$i++) { ?>
        <tr>
          <td><b><?php echo $_a = ($_a + 1); ?>.- </b></td>
          <td><?php echo obtenerFechaEnLetra($sql_mat[$i]['Fecha']); ?></td>
          <td><?php echo $sql_mat[$i]['Motivo']; ?></td>
          <td><?php echo $sql_mat[$i]['FecCap']; ?></td>
          <td><?php echo $sql_mat[$i]['APaterno'].' '.$sql_mat[$i]['AMaterno'].' '.$sql_mat[$i]['Nombre']; ?></td>
          <td>
            <button onclick="del_dia_s(<?php echo $sql_mat[$i]['IdSuspension']; ?>)" type="button" class="btn bg-navy btn-flat btn-sm"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
        <?php  }  ?>
   </tbody></table>

  </div>
