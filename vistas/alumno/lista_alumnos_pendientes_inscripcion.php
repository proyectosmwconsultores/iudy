<?php
$IdCiclo = $_POST['IdCiclo'];
require('../../php/clases/consultas_formatos.php');

$formatos = new Class_formatos();
$Usuarios = $formatos->obtener_alumnos_pendientes($IdCiclo);

?>
<div class="box">
  <div class="box-body">
    <div class="table-responsive">
      <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
        <thead>
          <tr>
            <th></th>
            <th>NOMBRE DEL ALUMNO</th>
            <th>GRUPO</th>
            <th>CAMPUS</th>
            <th>PLAN DE ESTUDIOS</th>
          </tr>
        </thead>
        <tbody>
          <?php for ($i = 0; $i < sizeof($Usuarios); $i++) {  ?>
            <tr>
              <td>
                <button type="button" class="btn bg-orange btn-flat" onClick="window.open('perfil.php?token=<?php echo time().$Usuarios[$i]["IdUsua"]; ?>','_self')" href="javascript:void(0);"><i class="fa fa-user"></i></button>
                <button type="button" class="btn bg-navy btn-flat" href="javascript:void(0);" onclick="inscripcion_especial(<?php echo $Usuarios[$i]["IdUsua"]; ?>,<?php echo $IdCiclo; ?>)"><i class="fa fa-warning"></i></button>
              </td>
              <td><?php echo $Usuarios[$i]["APaterno"] . ' ' . $Usuarios[$i]["AMaterno"] . ' ' . $Usuarios[$i]["Nombre"]; ?></td>
              <td><?php echo $Usuarios[$i]["Grado"].'° '.$Usuarios[$i]["CveGrupo"].' / '.$Usuarios[$i]["_Dias"]; ?></td>
              <td><?php echo $Usuarios[$i]["Campus"]; ?></td>
              <td><?php echo $Usuarios[$i]["Educativa"]; ?></td>
            </tr>
          <?php } ?>
          </tfoot>
      </table>
    </div>
  </div>
</div>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  		$(function() {
			$('#example1').DataTable()
		})

</script>