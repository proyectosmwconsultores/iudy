<?php
  require('../php/clases/consulta_class.php');
  $t=new Consultas();

  $lst=$t->get_dos_sol_all();

  ?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr>
        <th></th>
        <th>NOMBRE EL ALUMNO</th>
        <th>PERIODO ESCOLAR</th>
        <th>FEC.CAP</th>
        <th>FECHA CREACIÓN</th>
      </tr>
    </thead>
    <tbody>
      <?php
      for ($x=0;$x< sizeof($lst);$x++) { ?>
      <tr>
        <td>
          <button title="Imprimir constancia" onclick="javascript:window.open('repositorio/formatos/constancia.php?idToks=<?php echo $lst[$x]['qrCode']; ?>');" type="button" class="btn bg-maroon btn-flat btn-sm" href="javascript:void(0);"><i class="fa fa-fw fa-file-pdf-o"></i></button>
          <button title="Imprimir constancia sin firma" onclick="javascript:window.open('repositorio/formatos/constancia.php?idToks=<?php echo $lst[$x]['qrCode']; ?>&x=x');" type="button" class="btn bg-navy btn-flat btn-sm" href="javascript:void(0);"><i class="fa fa-fw fa-file-pdf-o"></i></button>
          <button title="Modificar datos de la constancia" type="button" class="btn bg-purple btn-flat btn-sm" onclick="validar_pagox(<?php echo $lst[$x]['IdDocumento']; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-cog"></i></button>
        </td>
        <td><?php echo $lst[$x]['APaterno'].' '.$lst[$x]['AMaterno'].' '.$lst[$x]['Nombre']; ?></td>
        <td><?php echo $lst[$x]['Ciclo']; ?></td>
        <td><?php echo $lst[$x]['FecCap']; ?></td>
        <td><?php echo $lst[$x]['Fecha']; ?></td>
      </tr>
      <?php } ?>
  </tbody></table>
 <!-- DataTables -->
 <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
 <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
$(function () {
	$('#example1').DataTable()
})
</script>
