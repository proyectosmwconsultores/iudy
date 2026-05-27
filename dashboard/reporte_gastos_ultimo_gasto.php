<?php
  require('../php/clases/consulta_class.php');
  $con=new Consultas();
  include('../hace.php');
  $lst_gasto=$con->get_ultimo_gastos();

  ?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <div class="bg-purple-active color-palette" style="padding: 5px;"><span><i class="fa fa-fw fa-sort-amount-desc"></i> Gastos agregados recientemente</span></div>
  <br>
  <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr>
        <th></th>
        <th>TIPO DE GASTO</th>
        <th>BENEFICIARIO</th>
        <th>DESCRIPCIÓN</th>
        <th>CHEQUE</th>
        <th>PARTIDA</th>
        <th>FEC.CAP</th>
        <th>FECHA</th>
        <th style="text-align: right;">IMPORTE</th>
      </tr>
    </thead>
    <tbody>
      <?php $bi=0; $bf=0; $s = 0;
      for ($x=0;$x< sizeof($lst_gasto);$x++) { ?>
      <tr <?php if($lst_gasto[$x]['IdEstatus'] == 10){ echo "style='color: red; '"; } else { echo ""; } ?>>
        <td style="width: 105px;">
          <button onclick="del_gasto_id(<?php echo $lst_gasto[$x]['IdGasto']; ?>)" type="button" class="btn bg-maroon btn-flat btn-xs"><i class="fa fa-fw fa-trash-o"></i></button>
          <?php if(($lst_gasto[$x]['Valor'] == 2) && ($lst_gasto[$x]['IdEstatus'] == 8)){ ?>
            <button onclick="mostrar_planes(<?php echo $lst_gasto[$x]['IdGasto']; ?>)" type="button" class="btn bg-navy btn-flat btn-xs"><i class="fa fa-fw fa-info-circle"></i></button>
            <button onclick="editar_gasto_id(<?php echo $lst_gasto[$x]['IdGasto']; ?>)" type="button" class="btn bg-purple btn-flat btn-xs"><i class="fa fa-fw fa-edit"></i></button>
          <?php } ?>
          <?php if(($lst_gasto[$x]['Valor'] == 1) && ($lst_gasto[$x]['IdEstatus'] == 8)){ ?>
            <button onclick="configurar_pag(<?php echo $lst_gasto[$x]['IdGasto']; ?>)" type="button" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-fw fa-cog"></i></button>
          <button onclick="configurar_pag_ind(<?php echo $lst_gasto[$x]['IdGasto']; ?>)" type="button" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-fw fa-gears"></i></button>
          <?php } ?>
        </td>
        <td><?php echo $lst_gasto[$x]['Nombre_gasto2']; ?></td>
        <td><?php echo $lst_gasto[$x]['Beneficiario']; ?></td>
        <td><?php echo $lst_gasto[$x]['Descripcion']; ?></td>
        <td><?php echo $lst_gasto[$x]['Cheque']; ?></td>
        <td><?php echo $lst_gasto[$x]['Partida']; ?></td>
        <td><?php echo $lst_gasto[$x]['FecCap']; ?></td>
        <td><?php echo $lst_gasto[$x]['Fecha']; ?></td>
        <td style="text-align: right; width: 110px;">$ <?php echo number_format($lst_gasto[$x]['Importe'], 2, '.', ','); ?></td>
      </tr>
      <?php  } ?>
  </tbody></table>
  <!-- DataTables -->
  <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
$(function () {
	$('#example1').DataTable()
})

</script>
