<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/consulta_class.php');
  $t=new Consultas();
  
   $IdGrado = $_POST['IdGrado'];
   $Pagado = $_POST['Pagado'];
   $IdCampus = $_POST['IdCampus'];
  


   
   $total = $t->get_lista_alumnos_graduados($IdCampus,$IdGrado);
 
   
  ?>
 
  <div class="box-body">
    <table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;" >
      <thead>
        <tr>
          <th>PLAN DE ESTUDIOS</th>
          <th>USUARIO</th>
          <th>NOMBRE DEL ALUMNO</th>
          <th>ESTATUS ALUMNO</th>
          <th>TRÁMITES</th>
          <th>ESTATUS PAGO</th>
          <th>MONTO</th>
        </tr>
        </thead>
      <tbody>
      <?php 
      $v = 0; 
      for ($i=0;$i< sizeof($total);$i++) {
      $estatus = $t->get_pago_generado_id($total[$i]['IdUsua']);
      $color = "";
      if(isset($estatus[0]['IdPago'])){
          $tramite = "GENERADO";
          $monto = $estatus[0]['Monto'];
          if($estatus[0]['IdEstatus'] == 4){ $estatus = "PAGADO";  $color = "style='color: blue;'";  } else { $estatus = "PENDIENTE"; $color = "style='color: red;'"; }
      } else {
          $tramite = "";
          $estatus = "";
          $monto = "";
      }
      
      ?>
        <tr <?php echo $color; ?>>
          <td><?php echo $total[$i]['Educativa']; ?></td>
          <td><?php echo $total[$i]['Usuario']; ?></td>
          <td><?php echo $total[$i]['APaterno']; ?> <?php echo $total[$i]['AMaterno']; ?> <?php echo $total[$i]['Nombre']; ?></td>
          <td><?php echo $total[$i]['Estatus']; ?></td>
          <td><?php echo $tramite; ?></td>
          <td><?php echo $estatus; ?></td>
          <td><?php echo $monto;  ?></td>
        </tr>
        <?php } ?>
    </tfoot></table>

  </div>
  
  <script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
  <!-- Custom and plugin javascript -->
  <script src="assets/table/js/scriptAgregado1.js"></script>

