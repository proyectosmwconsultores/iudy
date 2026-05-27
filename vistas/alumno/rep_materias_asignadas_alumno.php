<?php session_start();
$IdUsua = $_POST['IdUsua'];
require('../../php/clases/consultas_formatos.php');
require('../../hace.php');
$formatos = new Class_formatos();
$matAsig = $formatos->get_materias_asig_id($IdUsua);
$_mod71 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 71);
?>
<table class="table table-striped" style="font-size: 12px;">
  <?php $ci = 0;
  $cf = 0;
  for ($i = 0; $i < sizeof($matAsig); $i++) {
    $IdMod = $matAsig[$i]["IdModuloAlumno"];
    $ci = $matAsig[$i]["IdCiclo"];
    if ($ci <> $cf) { ?>
      <tr style="background: #c1c5ffc4; color: black;">
        <td colspan="5"><b>PERIODO ESCOLAR: </b><?php echo $matAsig[$i]["Ciclo"]; ?> <?php if($_SESSION['IdUsua'] == 1){ ?> <b onclick="validar_listamaterias(<?php echo $IdUsua; ?>,<?php echo $matAsig[$i]["IdCiclo"]; ?>)" style="float: right; color: blue; cursor: pointer;"><i class="fa fa-fw fa-refresh"></i></b> <?php } ?> </td>
      </tr>
      <tr>
        <th>MATERIA SEGUN RVOE</th>
        <th>MATERIA ASIGNADA</th>
        <th>DOCENTE</th>
        <th style="text-align: center;">ESTATUS</th>
      </tr>
    <?php } ?>
    <tr>
      <td>
        <?php if ($matAsig[$i]["_idModulo"]) {
          echo $matAsig[$i]["RCodeMode"]; ?> <?php echo $matAsig[$i]["RNombreMod"]; 
          if (isset($_mod71[0])) {
            echo "<br><b onclick='modificar_materia_asig($IdMod)' style='color: blue; cursor: pointer'>*Personalizado</b>";
          } else {
            echo "<br><b style='color: red;'>*Personalizado</b>";
          }
          ?>
          <?php } ?>
        </td>
      <td><?php echo $matAsig[$i]["CodeModulo"]; ?> <?php echo $matAsig[$i]["NombreMod"]; ?> <?php if($_SESSION['IdUsua'] == 1) { echo $matAsig[$i]["IdAsignacion"]; } ?> </td>
      <td><i class="fa fa-fw fa-user"></i> <?php echo $matAsig[$i]["Nombre"] . ' ' . $matAsig[$i]["APaterno"] . ' ' . $matAsig[$i]["AMaterno"]; ?><br>
        <i class="fa fa-fw fa-calendar"></i><?php echo obtener_dia($matAsig[$i]["FecIni"]) . ' al ' . obtener_dia($matAsig[$i]["FecFin"]); ?>
      </td>
      <td style="text-align: center;"><?php if (isset($matAsig[$i]["Fecha_impresion"])) { echo "<b title='Calificación publicada' style='color: blue;'><i class='fa fa-fw fa-check-circle'></i></b>"; } else { echo "<b title='El docente no ha emitido el acta de calificación.' style='color: red;'><i class='fa fa-exclamation-circle'></i></b>"; } ?> <?php echo $matAsig[$i]["Estatus"]; ?> </td>
    </tr>
  <?php $cf = $matAsig[$i]["IdCiclo"];
  } ?>
</table>