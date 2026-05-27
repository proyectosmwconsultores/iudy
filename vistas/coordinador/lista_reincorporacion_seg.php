<?php
$IdCiclo = $_POST['IdCiclo'];
require('../../php/clases/consultas_formatos.php');

$formatos = new Class_formatos();
$Usuarios = $formatos->obtener_lst_proc_rein($IdCiclo);

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
            <th>ESTATUS</th>
          </tr>
        </thead>
        <tbody>
          <?php for ($i = 0; $i < sizeof($Usuarios); $i++) {  ?>
            <tr>
              <td>
              <button type="button" class="btn bg-orange btn-flat" onClick="window.open('perfil.php?token=<?php echo time().$Usuarios[$i]["IdUsua"]; ?>','_self')" href="javascript:void(0);"><i class="fa fa-user"></i></button>
              <?php if($Usuarios[$i]["IdEstatus"] == 3){ ?>
                <button type="button" class="btn bg-navy btn-flat" href="javascript:void(0);" onclick="congGrupo(<?php echo $Usuarios[$i]["IdUsua"]; ?>,<?php echo $Usuarios[$i]["IdReincorporacion"]; ?>)"><i class="fa fa-warning"></i></button>
              <?php } else { ?>
                <button type="button" class="btn bg-teal btn-flat" onclick="javascript:window.open('repositorio/formatos/formato_reincorporacion.php?idToks=<?php echo time().$Usuarios[$i]["IdUsua"]; ?>');" href="javascript:void(0);"  href="javascript:void(0);"><i class="fa fa-file-pdf-o"></i></button>
                <button type="button" class="btn bg-maroon btn-flat" href="javascript:void(0);" onclick="congGrupo(<?php echo $Usuarios[$i]["IdUsua"]; ?>,<?php echo $Usuarios[$i]["IdReincorporacion"]; ?>)"><i class="fa fa-check-circle"></i></button>
              <?php } ?>
                
              </td>
              <td><?php echo $Usuarios[$i]["APaterno"] . ' ' . $Usuarios[$i]["AMaterno"] . ' ' . $Usuarios[$i]["Nombre"]; ?></td>
              <td><?php echo $Usuarios[$i]["Grado"].'° '.$Usuarios[$i]["CveGrupo"].' / '.$Usuarios[$i]["_Dias"]; ?></td>
              <td><?php echo $Usuarios[$i]["Campus"]; ?></td>
              <td><?php echo $Usuarios[$i]["Educativa"]; ?></td>
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