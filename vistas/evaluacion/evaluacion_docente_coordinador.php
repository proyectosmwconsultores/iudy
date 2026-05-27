<?php session_start();
require('../../php/clases/consultas_formatos.php');
require('../../hace.php');
$formatos = new Class_formatos();
$eval = $formatos->obtener_evaluacion_doc_id($_SESSION['IdUsua']);
$hoy = date("Y-m-d");


?>

<div class="box-body table-responsive no-padding">


  <table class="table table-hover">
    <tbody>

      <tr style="background: #e1dede; color: #000; ">
        <!-- <th>PERIODO ESCOLAR</th> -->
        <th></th>
        <th>DOCENTE</th>
        <th>MATERIA</th>
        <th>ESTATUS</th>
        <th>FECHA</th>
        
      </tr>
      <?php for ($x = 0; $x < sizeof($eval); $x++) { ?>
        <tr>
            <td>
          <?php if($eval[$x]["IdEstatus"] == 8) { ?>
            <button onclick="realizar_evaluacion_id(<?php echo $eval[$x]["IdEvaluacionX"]; ?>)" style="cursor: pointer;" type="button" class="btn btn-danger btn-sm" href="javascript:void(0);"> <i class="fa fa-unlock"></i> Pendiente</button>
          <?php } ?>
          <?php if($eval[$x]["IdEstatus"] == 10) { ?>
            <button onclick="realizar_evaluacion_id(<?php echo $eval[$x]["IdEvaluacionX"]; ?>)" style="cursor: pointer;" type="button" class="btn btn-primary btn-sm" href="javascript:void(0);"> <i class="fa fa-check-circle"></i> Hecho</button>
          <?php } ?>
          </td>
          <!-- <td><?php echo $eval[$x]["Ciclo"]; ?></td> -->
          <td><?php echo $eval[$x]["Nombre"].' '.$eval[$x]["APaterno"].' '.$eval[$x]["AMaterno"]; ?></td>
          <td><?php echo $eval[$x]["NombreMod"]; ?></td>
          <td><?php echo $eval[$x]["Estatus"]; ?></td>
          <td><?php echo $eval[$x]["FecIni"] . ' al ' . $eval[$x]["FecFin"]; ?></td>
          
        </tr>
      <?php  }  ?>
    </tbody>
  </table>

</div>