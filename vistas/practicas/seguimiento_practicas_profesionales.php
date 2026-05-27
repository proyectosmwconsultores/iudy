<?php session_start();
require('../../php/clases/class_practicas.php');
$practicas = new Class_practicas();
$IdAviso = $_POST['IdAviso'];
$IdEstatus = $_POST['IdEstatus'];

$sql_lsta = $practicas->get_user_practicas_activas($IdAviso,$IdEstatus,$_SESSION['IdUsua'], $_SESSION['Permisos']);
?>
<div class="box-body">
  <div class="btn-group">
    <!-- <button type="button" onclick="load_user_beca(1)" class="btn btn-<?php if($IdEstatus == 1){ echo 'success'; } else { echo "default"; } ?>">Todos</button> -->
    <!-- <button type="button" onclick="load_user_beca(31)" class="btn btn-<?php if($IdEstatus == 31){ echo 'success'; } else { echo "default"; } ?>">En captura</button> -->
    <?php if(($_SESSION['Permisos'] == 9) || ($_SESSION['Permisos'] == 1))  { ?>
    <button type="button" onclick="load_user_beca(2)" class="btn btn-<?php if($IdEstatus == 2){ echo 'success'; } else { echo "default"; } ?>">Enviado a revisión Coordinador</button>
    <?php } ?>
    <?php if(($_SESSION['Permisos'] == 6) || ($_SESSION['Permisos'] == 7) || ($_SESSION['Permisos'] == 1))  { ?>
    <button type="button" onclick="load_user_beca(3)" class="btn btn-<?php if($IdEstatus == 3){ echo 'success'; } else { echo "default"; } ?>">En revisión Gestión Escolar</button>
    <?php } ?>
    <button type="button" onclick="load_user_beca(5)" class="btn btn-<?php if($IdEstatus == 5){ echo 'success'; } else { echo "default"; } ?>">No aprobado</button>
    <button type="button" onclick="load_user_beca(4)" class="btn btn-<?php if($IdEstatus == 4){ echo 'success'; } else { echo "default"; } ?>">Aprobado</button>
  </div>
</div>
<div class="box-body">
  <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead> 
      <tr>
        <th>NOMBRE DEL ALUMNO</th>
        <th>PLAN DE ESTUDIOS</th>
        <th>CAMPUS UBICACIÓN</th>
        <th>EMPRESA</th>
        <th>ESTATUS</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php $g = 0;
      $oi = 0;
      $of = 0;
      foreach ($sql_lsta as $matx) { ?>
        <tr>
          <td><?php echo $matx['APaterno'] . ' ' . $matx['AMaterno'] . ' ' . $matx['Nombre']; ?></td>
          <td><?php echo $matx['Educativa']; ?></td>
          <td><?php echo $matx['Campus']; ?></td>
          <td><?php echo $matx['Empresa']; ?></td>
          <td style="text-align: left;"><?php echo $matx['Estatus']; ?></td>
          <td><button onclick="inscripcion_practica(<?php echo $matx['IdUsua']; ?>,<?php echo $matx['IdAviso']; ?>,<?php echo $matx['IdDetalle']; ?>)" type="button" class="btn bg-maroon btn-flat btn-xs"><i class="fa fa-fw fa-gear"></i></button></td>
        </tr><?php $of = $matx['IdOferta']; } ?>
    </tbody>
  </table>
</div>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  		$(function() {
			$('#example1').DataTable()
		})

</script>