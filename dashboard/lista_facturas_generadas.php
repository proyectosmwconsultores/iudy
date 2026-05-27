<?php
  require('../php/clases/consulta_class.php');
  $t=new Consultas();
  $Inicio = $_POST['Inicio'];
  $Final = $_POST['Final'];
  // include('../hace.php');
  $facturas = $t->get_facturas_generadas($Inicio, $Final);

  ?>
  <div class="box-body">
  <div class="table-responsive">
    <table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;">
      <thead>
        <tr>
          <th>Ajustes</th>
          <th>Folio factura</th>
          <th>Folio pago</th>
          <th>Nombre</th>
          <th>Fecha timbrado</th>
          <th>SubTotal</th>
          <th>Descuento</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0;$i< sizeof($facturas);$i++) { ?>
        <tr <?php if($facturas[$i]['IdEstatus'] == 7){ echo "style='color: red;'"; } ?>>
          <td width="120px">
            <?php if($facturas[$i]['_tipo'] == 'G'){  ?>
              <button type="button" class="btn btn-primary btn-sm" onclick="javascript:window.open('repositorio/pdf/mi_factura_global.php?idToks=<?php echo $facturas[$i]["_codigoFactura"]; ?>');" href="javascript:void(0);" title="Descargar factura"><i class="fa fa-fw fa-file-pdf-o"></i></button>
            <?php } else { ?>
              <button type="button" class="btn btn-primary btn-sm" onclick="javascript:window.open('repositorio/pdf/mi_factura.php?idToks=<?php echo $facturas[$i]["_codigoFactura"]; ?>');" href="javascript:void(0);" title="Descargar factura"><i class="fa fa-fw fa-file-pdf-o"></i></button>
            <?php } ?>
            <button type="button" class="btn btn-danger btn-sm" onclick="javascript:window.open('dashboard/descargar_xml.php?idToks=<?php echo $facturas[$i]['_folio']; ?>&url=<?php echo $facturas[$i]['Anio'].'/'.$facturas[$i]['Mes']; ?>');" href="javascript:void(0);" title="Descargar xml"><i class="fa fa-fw fa-file-code-o"></i></button>
            <!-- <button type="button" class="btn btn-warning btn-sm" onclick="cancelar_factura(<?php echo $facturas[$i]['IdFactura']; ?>)"  href="javascript:void(0);" title="Cancelar factura"><i class="fa fa-fw fa-trash"></i></button> -->
          </td>
          <td><?php echo $facturas[$i]['Serie'].'-'.$facturas[$i]['Folio']; ?></td>
          <td><?php if($facturas[$i]['_tipo'] == 'G'){  echo " ****** "; } else { echo $facturas[$i]['FolioPago']; } ?></td>
          <td><?php if($facturas[$i]['_tipo'] == 'G'){  echo "PÚBLICO EN GENERAL"; } else { echo $facturas[$i]['R_Nombre']; } ?></td>
          <td><?php echo $facturas[$i]['Fecha']; ?></td>
          <td>$ <?php echo number_format($facturas[$i]['SubTotal'], 2, '.', ','); ?></td>
          <td>$ <?php echo number_format($facturas[$i]['Descuento'], 2, '.', ','); ?></td>
          <td>$ <?php echo number_format($facturas[$i]['Total'], 2, '.', ','); ?></td>
        </tr><?php } ?>
      </tfoot>
    </table>
  </div>
  </div>

  <script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
  <!-- Custom and plugin javascript -->
  <script src="assets/table/js/scriptAgregado1.js"></script>

  <script>

    
  </script>
