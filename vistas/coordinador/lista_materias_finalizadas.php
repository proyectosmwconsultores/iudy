<?php session_start();
$IdCiclo = $_POST['IdCiclo'];
require('../../php/clases/consultas_formatos.php');

$formatos = new Class_formatos();

$moduloA = $formatos->get_materias_finalizadas($_SESSION['IdUsua'], $IdCiclo);
?>

  <div class="box-body">
    <div class="table-responsive">
      <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
        <thead>
          <tr>
            <th>Oferta</th>
            <th>Nombre de la asignatura</th>
            <th>CveGrupo</th>
            <th>Fecha</th>
            <th>Ingresar</th>
          </tr>
        </thead>
        <tbody>
          <?php for ($x = 0; $x < sizeof($moduloA); $x++) { ?>
              <tr>
                <td><?php echo $moduloA[$x]["NomEducativa"]; ?></td>
                <td><?php echo $moduloA[$x]["CodeModulo"]; ?> <?php echo $moduloA[$x]["NombreMod"]; ?></td>
                <td><?php echo $moduloA[$x]["CveGrupo"]; ?></td>
                <td><?php echo $moduloA[$x]["FecIni"] . ' al ' . $moduloA[$x]["FecFin"]; ?></td>
                <td>
                  <button onClick="window.open('doMiPlaneacion.php?idToks=<?php echo $moduloA[$x]["IdAsignacion"]; ?>&T=F','_self')" href="javascript:void(0);" style="cursor: pointer;" type="button" class="btn btn-block btn-default btn-sm"> <i class="fa fa-fw fa-arrow-circle-o-right"></i> Ingresar </button>
              </tr>
          <?php } ?>
          </tfoot>
      </table>
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