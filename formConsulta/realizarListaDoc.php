<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  echo $IdEvaluacionX =  $_POST["employee_id"];
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

           $sql = $db->query("SELECT
tblx_respuesta.IdRespuesta,
tblx_pregunta.Tipo,
tblx_pregunta.Pregunta,
tblx_pregunta.IdPregunta,
tblx_pregunta._Tipo,
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_modulo.NombreMod
FROM 
tblx_respuesta
Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblx_respuesta.IdDocente
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblx_respuesta.IdModulo
WHERE
tblx_respuesta.IdEvaluacion =  '$IdEvaluacionX' AND tblx_respuesta.IdEstatus = '8'"); ?>

        <div class="col-md-12">
          <table class="table table-striped">
                <tbody>

                <?php $pI= 0; $pF = 0; while($x = $db->recorrer($sql)){ $Es = 1;
                  $pTipo = $x["_Tipo"];
                  $idPreg = $x["IdPregunta"];
                  $pI = $x["IdUsua"];
                    if($pI <> $pF){
                  ?>
                <tr style="font-size: 12px; background: #b78bf7;">
                  <td colspan="3"><?php echo $x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"]; ?></td>
                  <td colspan="2"><?php echo $x["NombreMod"]; ?></td>
                </tr><?php } ?>
                <tr>
                  <td colspan="5" style="background: #8c8a8a;"><?php echo $x["Pregunta"]; ?></td>
                </tr>
                <tr>
                  <td colspan="5">
                    <?php if($pTipo == 1){
                      $sql6 = $db->query("SELECT * FROM tblxx_respuesta WHERE tblxx_respuesta.IdPregunta = '$idPreg' AND tblxx_respuesta.IdEstatus = '8' ");
                      while($m = $db->recorrer($sql6)){
                      ?>
                        <a onClick="add_respuesta(<?php echo $m['Valor']; ?>,<?php echo $x['IdRespuesta']; ?>,<?php echo $IdEvaluacionX; ?>)" class="btn btn-app">
                          <i class="fa fa-check-circle"></i> <?php echo $m['Texto']; ?>
                        </a>
                  <?php } } else { ?>
                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="txtRes-<?php echo $x['IdRespuesta']; ?>" id="txtRes-<?php echo $x['IdRespuesta']; ?>"></textarea>
                    <br>
                    <button type="button" onclick="saveEnc(<?php echo $x['IdRespuesta']; ?>,<?php echo $IdEvaluacionX; ?>)" class="btn btn-info pull-right">Guardar respuesta</button>
                  <?php } ?>
                  </td>
                </tr>

              <?php $pF = $x["IdUsua"]; } ?>

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
                <span class="info-box-text">Encuesta de satisfacción académica del cuatrimestre completado</span>
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
  function saveEnc(IdRespuesta,employee_id){
    var Escribir = "txtRes-"+IdRespuesta;

    var Texto = document.getElementById(Escribir).value;
    if (Texto ==''){
        swal("Error al guardar", "Debe escribir en el espacio.", "error");
        document.getElementById(Texto).focus();
        return 0;
    }


    var TipoGuardar = "addEncuestaOtro";
    var datos = 'TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta + '&Texto=' + Texto;
  	$.ajax({
  		type:"POST",
  		url:"insertar.php",
  		data:datos,
  		success:function(data){
        $.ajax({
          url:"formConsulta/realizarListaDoc.php",
          method:"POST",
             data:{employee_id:employee_id},
             success:function(data){
                  $('#employee_detail3').html(data);
                  $('#dataModal3').modal('show');
             }
        });
  		}
  	})

  }

function add_respuesta(Valor,IdRespuesta,employee_id)
{
	var TipoGuardar = "addEncuestaCal";
	var datos = 'TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta + '&Valor=' + Valor;
	$.ajax({
		type:"POST",
		url:"insertar.php",
		data:datos,
		success:function(data){ //alert(data);
      $.ajax({
        url:"formConsulta/realizarListaDoc.php",
        method:"POST",
           data:{employee_id:employee_id},
           success:function(data){
                $('#employee_detail3').html(data);
                $('#dataModal3').modal('show');
           }
      });
		}
	})
}
</script>
