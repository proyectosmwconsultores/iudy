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
  $Id_est = $datos81['IdEstatus'];
  $f_ini = $datos81['Ini'];
  $f_fin = $datos81['Fin'];
  if(!$f_ini){
    $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.Ini = NOW() WHERE tblx_evaluacion.IdEvaluacionX = '$IdEvaluacionX'");
  }



 ?>

  <form name="frm" id="frm" action="addGrupo.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">

        <div class="box-body">
        <?php
            $sql = $db->query("SELECT tblx_encuesta.IdEncuesta, tblx_encuesta.IdEstatus, tblx_pregunta.Pregunta, tblx_encuesta.IdPregunta FROM tblx_encuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_encuesta.IdPregunta WHERE tblx_encuesta.IdUsua =  '$IdUsua' AND tblx_encuesta.IdEstatus = '8' AND tblx_encuesta.IdEvaluacion = '$IdEvaluacionX' "); ?>

        <div class="col-md-12">
          <table class="table table-striped">
                <tbody>

                <?php $pI= 0; $pF = 0; while($x = $db->recorrer($sql)){ $Es = 1;
                  $pI = $x["IdPregunta"];
                  ?>

                <tr id="A<?php echo $x["IdEncuesta"]; ?>">
                  <td colspan="5" style="background: #8c8a8a;"><?php echo $x["Pregunta"]; ?></td>
                </tr>
                <tr id="B<?php echo $x["IdEncuesta"]; ?>">
                  <?php if($x["IdPregunta"] == 18) { ?>
                  <td colspan="5">
                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="txtRes" id="txtRes"></textarea>
                    <br>
                    <button type="button" onclick="saveEnc(<?php echo $x["IdEncuesta"]; ?>)" class="btn btn-info pull-right">Guardar respuesta</button>
                  </td>
                <?php } elseif($x["IdPregunta"] == 16) { ?>
                  <td><a class="btn btn-app" onClick="add_encuesta(10,<?php echo $x["IdEncuesta"]; ?>)"> Pasión por Educar</a></td>
                  <td><a class="btn btn-app" onClick="add_encuesta(9,<?php echo $x["IdEncuesta"]; ?>)"> Responsabilidad</a></td>
                  <td><a class="btn btn-app" onClick="add_encuesta(8,<?php echo $x["IdEncuesta"]; ?>)"> Calidad</a></td>
                  <td><a class="btn btn-app" onClick="add_encuesta(7,<?php echo $x["IdEncuesta"]; ?>)"> Educación</a></td>
                  <td><a class="btn btn-app" > Otro:
                    <input onchange="addOtro(<?php echo $x["IdEncuesta"]; ?>)" type="text" name="txtOtro" id="txtOtro" class="form-control">
                  </a></td>
                <?php } else { ?>
                  <td><a class="btn btn-app" onClick="add_encuesta(10,<?php echo $x["IdEncuesta"]; ?>)">&#128512; <br> Excelente</a></td>
                  <td><a class="btn btn-app" onClick="add_encuesta(9,<?php echo $x["IdEncuesta"]; ?>)"> &#128521; <br> Bueno</a></td>
                  <td><a class="btn btn-app" onClick="add_encuesta(8,<?php echo $x["IdEncuesta"]; ?>)">&#128528; <br> Regular</a></td>
                  <td><a class="btn btn-app" onClick="add_encuesta(7,<?php echo $x["IdEncuesta"]; ?>)">&#128533; <br> Malo</a></td>
                  <td><a class="btn btn-app" onClick="add_encuesta(6,<?php echo $x["IdEncuesta"]; ?>)">&#128545; <br> Muy malo</a></td>
                <?php } ?>
                </tr>

              <?php } ?>

              </tbody></table>


        </div>
      <?php
         }

         if(($Es == 0) && ($Id_est == 8)){
             $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.Fin = NOW(), tblx_evaluacion.IdEstatus = '10' WHERE tblx_evaluacion.IdEvaluacionX = '$IdEvaluacionX'");
             $Id_est = 10;
         }

         if($Id_est == 10){ ?>
  <div class="col-md-12 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
              <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Encuesta de calidad cuatrimestre completado</span>
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

  function addOtro(IdRespuesta){
    var Texto = document.getElementById("txtOtro").value;
    var ResA = "A"+IdRespuesta;
    var ResB = "B"+IdRespuesta;
    var TipoGuardar = "addEncuestaOtro";
    var datos = 'TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta + '&Texto=' + Texto;
  	$.ajax({
  		type:"POST",
  		url:"insertar.php",
  		data:datos,
  		success:function(data){
        document.getElementById(ResA).style.display = 'none';
        document.getElementById(ResB).style.display = 'none';
  		}
  	})

  }

  function saveEnc(IdRespuesta){
    var Texto = document.getElementById("txtRes").value;
    if (Texto ==''){
        swal("Error al guardar", "Debe escribir sus 3 sugerencias.", "error");
        document.getElementById("txtRes").focus();
        return 0;
    }

    var ResA = "A"+IdRespuesta;
    var ResB = "B"+IdRespuesta;
    var TipoGuardar = "addEncuestaOtro";
    var datos = 'TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta + '&Texto=' + Texto;
  	$.ajax({
  		type:"POST",
  		url:"insertar.php",
  		data:datos,
  		success:function(data){
        document.getElementById(ResA).style.display = 'none';
        document.getElementById(ResB).style.display = 'none';
  		}
  	})

  }

function add_encuesta(Valor,IdRespuesta)
{
	var TipoGuardar = "addEncuestaCal";
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
