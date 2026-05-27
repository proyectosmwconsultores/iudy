<?php
session_start();
$IdAdmin = $_SESSION['IdUsua'];
$IdUsua = $_POST['IdUsua'];
require('../../php/clases/consultas_formatos.php');
$formatos = new Class_formatos();
$_ciclo = $formatos->obtener_periodo_escolar($IdUsua);
$_grados = $formatos->obtener_grado_materias($IdUsua);
$_lst = $formatos->obtener_lista_materias_finales($IdUsua);
// $_cert = $formatos->obtener_datos_certificado($IdUsua);

?>

<form class="form-horizontal">
  <table class="table table-striped">
    <tbody>
      <tr>
      </tr>

      <?php $ci = 0;
      $cf = 0;
      for ($i = 0; $i < sizeof($_lst); $i++) {
        $ci = $_lst[$i]['IdCiclo'];
        if ($ci <> $cf) { ?>
          <tr>
            <th colspan="4" style="background: #1d3462; color: white;">PERIODO ESCOLAR: <?php echo $_lst[$i]['Ciclo']; ?> </th>
          </tr>
          <tr>
            <th></th>
            <th>NOMBRE DE LA MATERIA</th>
            <th style="text-align: center;">PROMEDIO</th>
            <th style="text-align: center;">OBSERVACIONES</th>
          </tr>
        <?php }
        ?>
        <tr>
          <td>
            <button onclick="eliminar_calificacion_id(<?php echo $IdUsua; ?>,<?php echo $_lst[$i]['IdCalificacion']; ?>)" type="button" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-trash"></i></button>
          </td>
          <td><?php echo $_lst[$i]['CodeModulo']; ?> <?php echo $_lst[$i]['NombreMod']; ?></td>
          <td style="text-align: center;"> <?php echo $_lst[$i]['Promedio']; ?> </td>
          <td style="text-align: center;"> <?php echo $_lst[$i]['_obs']; ?> </td>
        </tr>
      <?php $cf = $_lst[$i]['IdCiclo'];
      } ?>
    </tbody>
  </table>
</form>
