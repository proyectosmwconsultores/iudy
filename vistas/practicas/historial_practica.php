<?php session_start();
$IdUsua = $_POST['IdUsua'];

require('../../php/clases/class_practicas.php');
require('../../hace.php');
$practicas = new Class_practicas();


$histo = $practicas->get_historico_practica_id($IdUsua);

?>
<form name="frm22" id="frm22" action="addFirmas.php" method="POST" enctype="multipart/form-data" class="form-horizontal">

  <div class="box-body">

    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th>Titulo</th>
          <th>Estatus</th>
          <th>Fecha baja</th>
          <th>Motivo baja</th>
        </tr>
        <?php for ($i=0;$i< sizeof($histo);$i++) { ?>
        <tr>
          <td><?php echo $histo[$i]['Titulo']; ?></td>
          <td><?php echo $histo[$i]['Estatus']; ?></td>
          <td><?php echo $histo[$i]['Fecha']; ?></td>
          <td><?php echo $histo[$i]['Motivo']; ?></td>
        </tr><?php } ?>
      </tbody>
    </table>
  </div>
</form>