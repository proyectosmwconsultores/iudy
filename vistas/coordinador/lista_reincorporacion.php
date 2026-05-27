<?php
$IdCampus = $_POST['IdCampus'];
require('../../php/clases/consultas_formatos.php');

$formatos = new Class_formatos();
$Usuarios = $formatos->obtener_lista_bajas($IdCampus);

?>
<div class="box">
  <div class="box-body">
    <div class="table-responsive">
      <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
        <thead>
          <tr>
            <th></th>
            <th>MATRICULA</th>
            <th>NOMBRE DEL ALUMNO</th>
            <th>PLAN DE ESTUDIOS</th>
            <th>TIPO BAJA</th>
          </tr>
        </thead>
        <tbody>
          <?php for ($i = 0; $i < sizeof($Usuarios); $i++) {  ?>
            <tr id="<?php echo $Usuarios[$i]["IdUsua"]; ?>">
              <td>
                <button type="button" class="btn bg-orange btn-flat" href="javascript:void(0);" onclick="congGrupo(<?php echo $Usuarios[$i]["IdUsua"]; ?>)"><i class="fa fa-warning"></i></button>
              </td>
              <td><?php echo $Usuarios[$i]["Usuario"]; ?></td>
              <td><?php echo $Usuarios[$i]["APaterno"] . ' ' . $Usuarios[$i]["AMaterno"] . ' ' . $Usuarios[$i]["Nombre"]; ?></td>
              <td><?php echo $Usuarios[$i]["NomEducativa"]; ?></td>
              <td><?php echo $Usuarios[$i]["Estatus"]; ?></td>
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