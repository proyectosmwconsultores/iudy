<?php
  require('../php/clases/consulta_class.php');
  $t=new Consultas();
  // $Inicio = $_POST['Inicio'];
  // $Final = $_POST['Final'];
  include('../hace.php');
  $facturas = $t->get_facturas_solicitadas_pendi();

  ?>
  <div class="box-body">
  <div class="table-responsive">
    <table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;">
      <thead>
        <tr>
          <th>AJUSTES</th>
          <th style="width: 100px;">FOLIO</th>
          <th>RFC</th>
          <th>NOMBRE</th>
          <th>CONCEPTO</th>
          <th>FECHA</th>
          <th style="width: 100px; text-align: right;">MONTO</th>
          <th style="width: 100px; text-align: right;">DESCUENTO</th>
          <th style="width: 100px; text-align: right;">TOTAL</th>
        </tr>
      </thead>
      <tbody>
        <?php $_sum = 0; $s_i = 0; $s_d = 0; $s_t = 0; for ($i=0;$i< sizeof($facturas);$i++) {
          
          if($facturas[$i]['_fac'] == 1){
            $_impor = $facturas[$i]['_importe'];
            $_descu = $facturas[$i]['_descuento'];
            $_total = $facturas[$i]['_total'];
          } else {
            $_impor = $facturas[$i]['_importe'];
            $_descu = $facturas[$i]['_descuento'];
            $_total = $facturas[$i]['_total'];
            $_sum = ($_descu + $_total);
            if($_sum <> $_impor){
              $_impor = $facturas[$i]['_total'];
              $_descu = 0;
              $_total = $facturas[$i]['_total'];
            }
          }
          $s_i = ($s_i + $_impor);
          $s_d = ($s_d + $_descu);
          $s_t = ($s_t + $_total);

          // if($facturas[$i]['IdEstatus'] == 8){
          //   $color = "navy";
          //   $ico = "check-circle";
          // } else {
          //   $color = "orange";
          //   $ico = "info-circle";
          // }
          ?>
        <tr>
          <td width="120px">
            <button type="button" title="Datos para facturar" class="btn bg-purple btn-flat btn-sm" onclick="datos_factura_id(<?php echo $facturas[$i]['IdUsua']; ?>)" href="javascript:void(0);"> <i class="fa fa-edit"></i></button>
            <button type="button" title="Facturar ingreso" class="btn bg-navy btn-flat btn-sm" onclick="generar_factura_id(<?php echo $facturas[$i]['IdUsua']; ?>,'<?php echo $facturas[$i]['NoFolio']; ?>')" href="javascript:void(0);"> <i class="fa fa-flag"></i></button> 
          </td>
          
          <td><?php echo $facturas[$i]['NoFolio']; ?></td>
          <td><?php echo $facturas[$i]['RFC']; ?></td>
            <td><?php echo $facturas[$i]['Nombre'].' '.$facturas[$i]['APaterno'].' '.$facturas[$i]['AMaterno']; ?></td>
            <td><?php echo $facturas[$i]['NomPlan']; ?> <?php echo obtener_AnioMesMAY($facturas[$i]['Fecha']); ?></td>
            <td><?php echo $facturas[$i]['FecPago']; ?></td>
            <td style="text-align: right;">$ <?php echo number_format($_impor, 2, '.', ','); ?></td>
            <td style="text-align: right;">$ <?php echo number_format($_descu, 2, '.', ','); ?></td>
            <td style="text-align: right;">$ <?php echo number_format($_total, 2, '.', ','); ?></td>
        </tr><?php } ?>
      </tfoot>
    </table>
  </div>
  </div>

  <script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
  <!-- Custom and plugin javascript -->
  <script src="assets/table/js/scriptAgregado1.js"></script>
