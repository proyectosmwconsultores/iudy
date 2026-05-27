<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/consulta_class.php');
$t = new Consultas();

$IdPeriodo = $_POST['IdPeriodo'];

$total = $t->get_alumnos_mejores_promedios_periodo($IdPeriodo);
?>

<div class="box-header">
  <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de alumnos por rvoe</h3>
</div>

<div class="box-body">
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th></th>
        <th>MATRICULA</th>
        <th>NOMBRE</th>
        <th style="text-align: center;">PORCENTAJE</th>
        <th style="text-align: center;">GRADO</th>
        <th style="text-align: center;">PROMEDIO</th>
      </tr>

      <?php
      $campusAnterior = '';
      $ofertaAnterior = '';
      $contadorCarrera = 0;
      $v = 0;

      for ($i = 0; $i < sizeof($total); $i++) {

        $campusActual = $total[$i]['IdCampus'];
        $ofertaActual = $total[$i]['IdOferta'];

        // Mostrar encabezado de campus si cambia
        if ($campusActual != $campusAnterior) {
          ?>
          <tr style="background: #9db1ff;">
            <td colspan="6"><b><i class="fa fa-flag"></i> CAMPUS: <?php echo $total[$i]['Campus']; ?></b></td>
          </tr>
          <?php

          // Al cambiar de campus, forzar nueva carrera
          $ofertaAnterior = '';
        }

        // Mostrar encabezado de carrera si cambia
        if ($ofertaActual != $ofertaAnterior) {
          $contadorCarrera = 0;
          ?>
          <tr style="background: #949dbe;">
            <td></td>
            <td colspan="5"><b><i class="fa fa-book"></i> <?php echo $total[$i]['Educativa']; ?></b></td>
          </tr>
          <?php
        }

        // Contador por carrera
        $contadorCarrera++;

        ?>

        <tr>
          <td>
           
            <b><?php echo (++$v); ?>.-</b>
          </td>
          <td><?php echo $total[$i]['Usuario']; ?></td>
          <td><?php echo $total[$i]['Nombre'] . ' ' . $total[$i]['APaterno'] . ' ' . $total[$i]['AMaterno']; ?></td>
          <td style="text-align: center;"><?php echo $total[$i]['porcentaje']; ?>%</td>
          <td style="text-align: center;"><?php echo $total[$i]['Grado']; ?>°</td>
          <td style="text-align: center;"><?php echo $total[$i]['Promedio']; ?>  <?php
            if ($contadorCarrera == 1) {
              echo '🥇 ';
            } elseif ($contadorCarrera == 2) {
              echo '🥈 ';
            } elseif ($contadorCarrera == 3) {
              echo '🥉 ';
            }
            ?></td>
        </tr>

        <?php
        $campusAnterior = $campusActual;
        $ofertaAnterior = $ofertaActual;
      }
      ?>
    </tbody>
  </table>

  <hr>
  <br><br>
</div>