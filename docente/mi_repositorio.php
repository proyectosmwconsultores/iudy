<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/class.php');
$t = new Trabajo();
$lst_recursos = $t->lst_biblioteca_all($_SESSION['IdUsua'], $_POST["idToks"]);

?>

<table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
  <thead>
    <tr>
      <th>Nombre del material didáctico </th>
      <th>Tipo</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php for ($i = 0; $i < sizeof($lst_recursos); $i++) {
      $IdR = $lst_recursos[$i]["IdBiblioteca"];
      $_tip = $lst_recursos[$i]['Tipo'];
      $_tem = $lst_recursos[$i]['IdTema'];
      $_icono = "<i class='fa fa-fw fa-file-text'></i>";
      if ($_tem == 10) {
        if ($_tip == 'link') {
          $_icono = "<i class='fa fa-fw fa-external-link'></i>";
        } else {
          $_icono = "<i class='fa fa-fw fa-share-alt-square'></i>";
        }
      } elseif ($_tem == 7) {
        if ($_tip == 'youtube') {
          $_icono = "<i class='fa fa-fw fa-toggle-right'></i>";
        } else {
          $_icono = "<i class='fa fa-fw fa-share-alt-square'></i>";
        }
      } elseif ($_tem == 8) {
        if ($_tip == 'tv') {
          $_icono = "<i class='fa fa-fw fa-toggle-right'></i>";
        } else {
          $_icono = "<i class='fa fa-fw fa-share-alt-square'></i>";
        }
      } else {
        if ($_tip == 'pdf') {
          $_icono = "<i class='fa fa-fw fa-file-pdf-o'></i>";
        } elseif ($_tip == 'docx') {
          $_icono = "<i class='fa fa-fw fa-file-word-o'></i>";
        } elseif ($_tip == 'xlsx') {
          $_icono = "<i class='fa fa-fw fa-file-excel-o'></i>";
        }
      }
    ?>
      <tr id="L-<?php echo $IdR; ?>">
        <td><?php echo $lst_recursos[$i]["Nombre"]; ?></td>
        <td><?php echo $_tip; ?></td>
        <td>
          <button onclick="verBiblioteca(<?php echo $lst_recursos[$i]['IdBiblioteca']; ?>)" type="button" class="btn btn-success" href="javascript:void(0);"><?php echo $_icono; ?></button>
          <button onClick="copiar_recurso(<?php echo $IdR; ?>,'<?php echo $_POST["idToks"]; ?>')" name="add" id="add" type="button" class="btn btn-primary"><i class="fa fa-files-o"></i> Copiar archivo</button>

        </td>
      </tr>
    <?php } ?>
    </tfoot>
</table>

<script>
  $(function() {
    $('#example1').DataTable()
  })
</script>