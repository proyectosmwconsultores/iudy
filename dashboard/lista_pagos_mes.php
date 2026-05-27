<?php
  require('../php/clases/consulta_class.php');
  $t=new Consultas();
  $Inicio = $_POST['Inicio'];
  $Final = $_POST['Final'];
  include('../hace.php');
  $facturas = $t->get_facturas_mes($Inicio, $Final);

  ?>
  <div class="box-body">
  <div class="table-responsive">
  
    <table id="example" class="table table-striped" style="font-size: 12px;">
      <thead>
        <tr>
          <th></th>
          <th style="width: 100px;">FOLIO</th>
          <th>NOMBRE</th>
          <th>CONCEPTO</th>
          <th>FECHA</th>
          <th>FORMA PAGO</th>
          <th style="width: 100px; text-align: right;">MONTO</th>
          <th style="width: 100px; text-align: right;">DESCUENTO</th>
          <th style="width: 100px; text-align: right;">TOTAL</th>
        </tr>
      </thead>
      <tbody>
        <?php $b = 0; $_sum = 0; $s_i = 0; $s_d = 0; $s_t = 0; for ($i=0;$i< sizeof($facturas);$i++) {
          
          $_descu = $facturas[$i]['_descuento'];
          if($_descu < 0){
            $_impor = $facturas[$i]['_total'];
            $_descu = 0;
            $_total = $facturas[$i]['_total'];
          } else {
            $_impor = $facturas[$i]['_importe'];
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

          ?>
          <tr>
            <td><b><?php echo $b = ($b + 1); ?>.- </b></td>
            <td><b onclick="quitar_pago(<?php echo $facturas[$i]['IdFolio']; ?>)" style="color: blue; cursor: pointer;"><i class="fa fa-fw fa-trash"></i></b><?php echo $facturas[$i]['NoFolio']; ?></td>
            <td><?php echo $facturas[$i]['Nombre'].' '.$facturas[$i]['APaterno'].' '.$facturas[$i]['AMaterno']; ?></td>
            <td><?php echo $facturas[$i]['NomPlan']; ?> <?php echo obtener_AnioMesMAY($facturas[$i]['Fecha']); ?></td>
            <td><?php echo $facturas[$i]['FecPago']; ?></td>
            <td><?php echo $facturas[$i]['_Descripcion']; ?></td>
            <td style="text-align: right;">$ <?php echo number_format($_impor, 2, '.', ','); ?></td>
            <td style="text-align: right;">$ <?php echo number_format($_descu, 2, '.', ','); ?></td>
            <td style="text-align: right;">$ <?php echo number_format($_total, 2, '.', ','); ?></td>
          </tr><?php } ?>
          <tr>
            <td style="text-align: right;" colspan="8"><b>SUBTOTAL:</b></td>
            <td style="text-align: right; background: yellow;">$ <?php echo number_format($s_i, 2, '.', ','); ?></td>
          </tr>
          <tr>
            <td style="text-align: right;" colspan="8"><b>DESCUENTO: </b></td>
            <td style="text-align: right; background: yellow;">$ <?php echo number_format($s_d, 2, '.', ','); ?></td>
          </tr>
          <tr>
            <td style="text-align: right;" colspan="8"><b>TOTAL FACTURAR:</b></td>
            <td style="text-align: right; background: yellow;">$ <?php echo number_format($s_t, 2, '.', ','); ?></td>
          </tr>
      </tfoot>
    </table>
    <hr>
    <table id="example" class="table table-striped" style="font-size: 12px;">
      <thead>
        <tr>
          <th>FORMA PAGO</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $fi=0; $ff = 0; for ($i=0;$i< sizeof($facturas);$i++) {
           $fi = $facturas[$i]['IdForma'];
           if($fi <> $ff){ ?>
          <tr>
            <td><?php echo $facturas[$i]['_Descripcion']; ?></td>
            <td><button onclick="gener_factura_global(<?php echo $facturas[$i]['IdForma']; ?>)" type="button" class="btn bg-navy btn-flat"><i class="fa fa-flag"></i> Generar factura</button></td>
          </tr>
          <?php } ?>
          <?php $ff = $facturas[$i]['IdForma']; } ?>
      </tfoot>
    </table>

    


  </div>
  <br>
  <!-- <button onclick="gener_factura_global()" type="button" class="btn btn-block btn-danger"><i class="fa fa-fw fa-question-circle"></i> Generar factura global</button> -->
  </div>
