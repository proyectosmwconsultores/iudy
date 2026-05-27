<?php
include('../hace.php');
if (isset($_POST["IdActividadDoc"])) {
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdActivadadDoc = $_POST["IdActividadDoc"];
  $sql = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.FecFinal, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblp_tareas Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_tareas.IdAlumno WHERE tblp_tareas.IdActividadesDocente = '$IdActivadadDoc' ORDER BY tblc_usuario.APaterno ASC ");
?>
  <form name="frm22" id="frm22" action="addRvoe.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <input id="IdActividadDoc" name="IdActividadDoc" value="<?php echo $IdActivadadDoc; ?>" type="hidden" />
    <table class="table table-striped">
      <tbody>
        <tr>
          <th style="width: 10px">#</th>
          <th>Nombre del alumno</th>
          <th>Fecha final</th>
        </tr>
        <?php $g = 0;
        while ($x = $db->recorrer($sql)) { ?>
          <tr>
            <td><?php echo $g = $g + 1; ?></td>
            <td><?php echo $x["APaterno"] . ' ' . $x["AMaterno"] . ' ' . $x["Nombre"]; ?></td>
            <td>
              <div class="input-group input-group-sm">
                <input placeholder="yyyy-mm-dd" type="text" class="form-control pull-right" id="txtFecha<?php echo $x["IdTarea"]; ?>" name="txtFecha<?php echo $x["IdTarea"]; ?>" value="<?php echo $x["FecFinal"]; ?>">
                <span class="input-group-btn">
                  <button onclick="saveFechaN(<?php echo $x["IdTarea"]; ?>)" type="button" class="btn btn-info btn-flat">Guardar</button>
                </span>
              </div>
            </td>

          </tr>
        <?php } ?>

      </tbody>
    </table>
  </form>
<?php
}
?>