<?php session_start();
  require('../../php/clases/class_practicas.php');
  $practicas = new Class_practicas();
  $lst = $practicas->get_avisos_capturados_tit();

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <div class="bg-purple-active color-palette" style="padding: 5px;"><span><i class="fa fa-fw fa-sort-amount-desc"></i> Avisos capturados</span> <button style='float: right;' onclick="crea_aviso(<?php echo $_SESSION['IdUsua']; ?>)" type="button" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-edit"></i> Crear aviso</button></div>
  <br>
  <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr>
        <th></th>
        <th>TITULO DEL AVISO</th>
        <th>PERIODO ESCOLAR</th>
        <th>FEC.CAP</th>
      </tr>
    </thead>
    <tbody>
      <?php $bi=0; $bf=0; $s = 0;
      for ($x=0;$x< sizeof($lst);$x++) { ?>
      <tr>
        <td style="width: 105px;">
            <button title="Eliminar aviso" onclick="del_aviso_id(<?php echo $lst[$x]['IdAviso']; ?>)" type="button" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-fw fa-trash"></i></button>
            <button title="Configurar usuarios" onclick="configurar_aviso(<?php echo $lst[$x]['IdAviso']; ?>,<?php echo $lst[$x]['IdCiclo']; ?>)" type="button" class="btn bg-navy btn-flat btn-xs"><i class="fa fa-fw fa-cog"></i></button>
            <button title="Usuario que ya vieron el aviso" onclick="ver_avance_reporte(<?php echo $lst[$x]['IdAviso']; ?>)" type="button" class="btn bg-purple btn-flat btn-xs"><i class="fa fa-fw fa-users"></i></button>
        </td>
        <td><?php echo $lst[$x]['Titulo']; ?></td>
        <td><?php echo $lst[$x]['Ciclo']; ?></td>
        <td><?php echo $lst[$x]['FecCap']; ?></td>
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
