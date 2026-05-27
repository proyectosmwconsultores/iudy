<?php session_start();
$IdUsua = $_POST['IdUsua'];
require('../../php/clases/consultas_formatos.php');
require('../../hace.php');
$formatos = new Class_formatos();
$cal = $formatos->get_cal_all_us($IdUsua);
$user = $formatos->get_datos_alumno_id($IdUsua);
$grpz = $user[0]["TipoCiclo"];

$_mod68 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 68);
$_mod75 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 75);

if ($grpz == "C") {
  $txtGrp = "CUATRIMESTRE";
} elseif ($grpz == "S") {
  $txtGrp = "SEMESTRE";
} else {
  $txtGrp = "TRIMESTRE";
} 

?>

<table class="table table-striped">
  <?php $gi = 0;
  $gf = 0; $c = 0;
  for ($x = 0; $x < sizeof($cal); $x++) { $c = ($c + 1);
    $gi = $cal[$x]["Grado"];
    $pm = $cal[$x]["Promedio"];
    if ($gi <> $gf) { ?>
      <tr style="background: #c1c5ffc4 !important; color: white;">
        <td colspan="2" style="color: black;">
        <?php if (isset($_mod68[0])) { ?>
          <button type="button" class="btn btn-danger btn-sm" onclick="javascript:window.open('repositorio/formatos/boleta.php?idToks=<?php echo time() . $IdUsua; ?>&idCiclo=<?php echo time() . $cal[$x]["IdCiclo"]; ?>');" href="javascript:void(0);" title="Descargar boleta calificaciones"><i class="fa fa-align-left"></i> Imprimir</button>
          <?php } ?>
          <?php echo $cal[$x]["Grado"]; ?>° <?php echo $txtGrp;  ?> 
          <?php //echo $cal[$x]["Ciclo"]; ?>
        </td>
        <td style="text-align: center; color: black;">PROMEDIO</td>
        <!-- <td style="text-align: center; color: black;">OBSERVACIONES</td> -->
      </tr>
    <?php } ?>
    <tr>
      <td>
        <button onclick="cambiar_calificacion(<?php echo $cal[$x]["IdCalificacion"]; ?>)" type="button" class="btn bg-navy btn-flat btn-xs"><i class="fa fa-fw fa-gear"></i></button>
        <?php if(($pm < 6) && (isset($_mod75[0]))){ ?>
        <button onclick="capturar_extra(<?php echo $cal[$x]["IdCalificacion"]; ?>)" type="button" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-fw fa-gear"></i></button>
        <?php } ?>
      </td>
      <td><?php echo $cal[$x]["CodeModulo"]; ?> <?php echo $cal[$x]["NombreMod"]; ?></td>
      <td style="text-align: center; width: 80px;">
        <?php echo $pm; ?> <?php echo $cal[$x]["_obs"]; ?>
      </td>
      <!-- <td style="text-align: center; width: 80px;">
        <?php echo $cal[$x]["Descripcion"]; ?>
      </td> -->
    </tr>
  <?php $gf = $cal[$x]["Grado"];
  } ?>
</table>

<?php if($c == 0) { ?>
<p style="text-align: center;">
  <img src="assets/images/campus/no_data.gif" style="width: 50%;">
</p>
<?php } ?>

