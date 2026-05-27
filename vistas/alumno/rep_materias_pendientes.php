<?php session_start();
$IdUsua = $_POST['IdUsua'];
$IdOferta = $_POST['IdEducativa'];
$IdCampus = $_POST['IdCampus'];
require('../../php/clases/consultas_formatos.php');
require('../../hace.php');

$formatos = new Class_formatos();
$alumx = $formatos->get_datos_alumno_id($IdUsua);
$matAsig = $formatos->get_lista_materia($IdOferta, $IdCampus, $alumx[0]['Termino']);

?>
<?php if ($alumx[0]["IdOferta"] == 30) { ?>
  <?php if ($alumx[0]["Termino"] == '1') { ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-warning"></i> La terminación del Plan de Estudios no se ha configurado</h4>
    </div>
<?php }
} ?> </b></p>



<table class="table table-striped" style="font-size: 12px;">
  <?php $ci = 0;
  $cf = 0;
  for ($i = 0; $i < sizeof($matAsig); $i++) {
    $res = $formatos->get_validar_materia_generada($IdUsua, $IdOferta, $matAsig[$i]['IdModulo'], $matAsig[$i]['CodeModulo']);
    $ci = $matAsig[$i]["Grado"];
    if (!isset($res[0][0])) {
      if ($ci <> $cf) { ?>
        <tr style="background: #c1c5ffc4; color: black;">
          <td><b><?php echo $matAsig[$i]["Grado"]; ?>° CUATRIMESTRE</b></td>
        </tr>
      <?php } ?>
      <tr>
        <td><?php echo $matAsig[$i]["CodeModulo"]; ?> <?php echo $matAsig[$i]["NombreMod"]; ?></td>
      </tr>
  <?php $cf = $matAsig[$i]["Grado"];
    }
  } ?>
</table>