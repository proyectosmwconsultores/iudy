<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  $IdUsua =  $_POST["IdUsua"];
  $IdEvaluacionX =  $_POST["employee_id"];
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $Es = 0;

  $sql8 = $db->query("SELECT * FROM tblx_evaluacion WHERE tblx_evaluacion.IdEvaluacionX =  '$IdEvaluacionX'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Id_camp = $datos81['IdCampus'];
  $Id_est = $datos81['IdEstatus'];
  $f_ini = $datos81['Ini'];
  $f_fin = $datos81['Fin'];
  if(!$f_ini){
    $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.Ini = NOW() WHERE tblx_evaluacion.IdEvaluacionX = '$IdEvaluacionX'");
  }

  if($Id_camp == 10){
    $i1 = 30; $i2 = 38;
  } else {
    $i1 = 1; $i2 = 10; 
  }


 ?>

  <form name="frm" id="frm" action="addGrupo.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">

        <div class="box-body">
        <?php


        for($i=$i1; $i<=$i2; $i++){
          // for($i=1; $i<=10; $i++){


            $sql = $db->query("SELECT
          tblx_respuesta.IdRespuesta,
          tblx_respuesta.IdPregunta,
          tblx_respuesta.Respuesta,
          tblx_respuesta.IdEstatus,
          tblc_usuario.Nombre,
          tblc_usuario.APaterno,
          tblc_usuario.AMaterno,
          tblx_pregunta.Pregunta,
          tblp_modulo.NombreMod
          FROM
          tblx_respuesta
          Left Join tblc_usuario ON tblc_usuario.IdUsua = tblx_respuesta.IdDocente
          Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta
          Left Join tblp_modulo ON tblp_modulo.IdModulo = tblx_respuesta.IdModulo
          WHERE
          tblx_respuesta.IdUsua =  '$IdUsua' AND
          tblx_respuesta.IdPregunta =  '$i' AND tblx_respuesta.IdEstatus = '8' ");



?>

        <div class="col-md-12">
          <table class="table table-striped">
                <tbody>

                <?php $pI= 0; $pF = 0; while($x = $db->recorrer($sql)){ $Es = 1;
                  $pI = $x["IdPregunta"];

                  if($pI <> $pF){
                  ?>
                  <tr>
                    <th colspan="6" style="background: #8c8a8a;"><?php echo $x["Pregunta"]; ?></th>
                  </tr> <?php } ?>
                <tr id="A<?php echo $x["IdRespuesta"]; ?>">
                  <td colspan="6"><b>ASIGNATURA:</b> <?php echo $x["NombreMod"]; ?></td>
                </tr>
                <tr id="B<?php echo $x["IdRespuesta"]; ?>">
                  <td><?php echo $x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"]; ?></td>
                  <td><a class="btn btn-app" onClick="add_encuesta(10,<?php echo $x["IdRespuesta"]; ?>)">&#128512; <br> Excelente</a></td>
                  <td><a class="btn btn-app" onClick="add_encuesta(9,<?php echo $x["IdRespuesta"]; ?>)"> &#128521; <br> Bueno</a></td>
                  <td><a class="btn btn-app" onClick="add_encuesta(8,<?php echo $x["IdRespuesta"]; ?>)">&#128528; <br> Regular</a></td>
                  <td><a class="btn btn-app" onClick="add_encuesta(7,<?php echo $x["IdRespuesta"]; ?>)">&#128533; <br> Malo</a></td>
                  <td><a class="btn btn-app" onClick="add_encuesta(6,<?php echo $x["IdRespuesta"]; ?>)">&#128545; <br> Muy malo</a></td>

                </tr>

              <?php $pF = $x["IdPregunta"]; } ?>

              </tbody></table>


        </div>
      <?php }
         }

         if(($Es == 0) && ($Id_est == 8)){
             $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.Fin = NOW(), tblx_evaluacion.IdEstatus = '10' WHERE tblx_evaluacion.IdEvaluacionX = '$IdEvaluacionX'");
         }

         if($Id_est == 10){ ?>
  <div class="col-md-12 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
              <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Evaluación del cuatrimestre completado</span>
                <span class="info-box-number">Completado 100%</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                    <span class="progress-description">
                      Inició: <?php echo $f_ini;  ?> finalizó: <?php echo $f_fin; ?>
                    </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
<?php }
           ?>


        </div>

  </div>
  </form>

<script>
function add_encuesta(Valor,IdRespuesta)
{
	var TipoGuardar = "addEncuesta";
  var ResA = "A"+IdRespuesta;
  var ResB = "B"+IdRespuesta;
	var datos = 'TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta + '&Valor=' + Valor;
	$.ajax({
		type:"POST",
		url:"insertar.php",
		data:datos,
		success:function(data){
      //alert(data);
      document.getElementById(ResA).style.display = 'none';
      document.getElementById(ResB).style.display = 'none';
    //   document.getElementById("employee_id").value = 5;

		}
	})
}
</script>
