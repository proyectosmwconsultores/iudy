<?php
include('../../hace.php');
$IdEvaluacionX =  $_POST["IdEvaluacion"];
require('../../php/clases/class.System.php');
$db = new Conexion();
$Es = 0;
$_dispo = 0;
$sql8 = $db->query("SELECT * FROM tblx_evaluacion WHERE tblx_evaluacion.IdEvaluacionX =  '$IdEvaluacionX'");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);
$Id_est = $datos81['IdEstatus'];
$f_ini = $datos81['Ini'];
$f_fin = $datos81['Fin'];
$IdAsignacion = $datos81['IdAsignacion'];
if (!$f_ini) {
  $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.Ini = NOW() WHERE tblx_evaluacion.IdEvaluacionX = '$IdEvaluacionX'");
}

$sql9 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);


?>
<form name="frm" id="frm" action="realizar_encuesta.php.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="IdEvaluacionX" id="IdEvaluacionX" value="<?php echo  $_POST["IdEvaluacion"]; ?>">
  <ul class="products-list product-list-in-box">
    <li class="item">
      <div class="product-img">
        <img src="assets/perfil/<?php echo $datos91['Foto']; ?>" alt="Product Image" class="img-circle" style="width: 50px; height: 50px;">
      </div>
      <div class="product-info">
        <a href="javascript:void(0)" class="product-title"><?php echo $datos91['Nombre'] . ' ' . $datos91['APaterno'] . ' ' . $datos91['AMaterno']; ?></a>
        <span class="product-description">
          <?php echo $datos91['NombreMod']; ?>
        </span>
      </div>
    </li>
  </ul>

  <?php

  $sql = $db->query("SELECT
           tblx_respuesta.IdRespuesta,
           tblx_pregunta.Tipo,
           tblx_pregunta.Pregunta,
           tblx_pregunta.IdPregunta,
           tblx_pregunta._Tipo,
           tblx_modulo.Nombre_mod,
           tblx_pregunta.IdMod,
           tblx_pregunta.IdBloque
           FROM
           tblx_respuesta
           Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta
           Left Join tblx_modulo ON tblx_modulo.IdMod = tblx_pregunta.IdMod
           WHERE tblx_respuesta.IdEvaluacion = '$IdEvaluacionX' AND tblx_respuesta.IdEstatus = '8'
           ORDER BY
           tblx_pregunta.IdMod ASC"); ?>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <?php $mi = 0;
      $mf = 0;
      $bi = 0;
      $bf = 0;
      $s = 0;
      while ($x = $db->recorrer($sql)) { $s = ($s + 1);
        $Es = 1;
        $mi = $x["IdMod"];
        $idPreg = $x["IdPregunta"];
        $pTipo = $x["_Tipo"];
        if ($mi <> $mf) { ?>
          <tr>
            <td colspan="5" style="background: #001F3F; color: white; text-align: left;"><b><i class="fa fa-fw fa-flag-checkered"></i> <?php echo $x["Nombre_mod"]; ?></b></td>
          </tr>
        <?php } ?>
        <tr>
          <td colspan="5" style="background: #cbddff; color: black;"><i class="fa fa-fw fa-question-circle"></i> <?php echo $x["Pregunta"]; ?></td>
        </tr>
        <tr>
          <td colspan="5">
            <?php if ($pTipo == 1) {
              $sql6 = $db->query("SELECT * FROM tblxx_respuesta WHERE tblxx_respuesta.IdPregunta = '$idPreg' AND tblxx_respuesta.IdEstatus = '8' ");
              while ($m = $db->recorrer($sql6)) {
            ?>
                <a onClick="add_respuesta(<?php echo $m['Valor']; ?>,<?php echo $x['IdRespuesta']; ?>,<?php echo $IdEvaluacionX; ?>)" class="btn btn-app" style="margin-left: 40px; height: auto;">
                  <i class="fa fa-smile-o"></i> <?php echo $m['Texto']; ?>
                </a>
              <?php }
            } else { ?>
              <textarea class="form-control" rows="3" placeholder="Enter ..." name="txtRes-<?php echo $x['IdRespuesta']; ?>" id="txtRes-<?php echo $x['IdRespuesta']; ?>"></textarea>
              <br>
              <button type="button" onclick="saveEnc(<?php echo $x['IdRespuesta']; ?>,<?php echo $IdEvaluacionX; ?>)" class="btn btn-info pull-right">Guardar respuesta</button>
            <?php } ?>
          </td>
        </tr>

      <?php $mf = $x["IdMod"];
      } ?>

    </tbody>
  </table>
  <?php

  if (($s == 0) && ($Id_est == 8)) {

    $sql_res = $db->query("SELECT tblx_respuesta.IdRespuesta, Avg(tblx_respuesta.Respuesta) AS Promedio FROM tblx_respuesta WHERE tblx_respuesta.IdEvaluacion =  '$IdEvaluacionX' AND tblx_respuesta.IdEstatus =  '26' GROUP BY tblx_respuesta.IdAsignacion");
    $db->rows($sql_res); 
    $_res = $db->recorrer($sql_res);

    $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.Promedio = '".$_res['Promedio']."', tblx_evaluacion.Fin = NOW(), tblx_evaluacion.IdEstatus = '10' WHERE tblx_evaluacion.IdEvaluacionX = '$IdEvaluacionX'");
    $Id_est = 10;

    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.pro_coo = '".$_res['Promedio']."' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");

  }

  if ($Id_est == 10) { 
    
    ?>
    <div class="col-md-12 col-sm-6 col-xs-12">
      <div class="info-box bg-green">
        <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
        <div class="info-box-content">
          <span class="info-box-number">Completado 100%</span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="progress-description">
            Inició: <?php echo $f_ini;  ?> finalizó: <?php echo $f_fin; ?>
          </span>
        </div>
      </div>
    </div><br><br><br><br>
  <?php } ?>
</form>

<script>
  
  function saveEnc(IdRespuesta, IdEvaluacion) {
    var Escribir = "txtRes-" + IdRespuesta;

    var Texto = document.getElementById(Escribir).value;
    if (Texto == '') {
      swal("Error al guardar", "Debe escribir en el espacio.", "error");
      document.getElementById(Texto).focus();
      return 0;
    }


    var TipoGuardar = "addEncuestaOtro";
    var datos = 'TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta + '&Texto=' + Texto;
    $.ajax({
      type: "POST",
      url: "insertar.php",
      data: datos,
      success: function(data) {
        $.ajax({
					url: "vistas/evaluacion/realizar_encuesta_coordinador.php",
					method: "POST",
					data: {
						IdEvaluacion: IdEvaluacion
					},
					success: function(data) {
						$('#employee_detailE').html(data);
						$('#dataModalE').modal('show');
					}
				});
      }
    })

  }

  function add_respuesta(Valor, IdRespuesta, IdEvaluacion) {
    var TipoGuardar = "addEncuestaCal";
    var datos = 'TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta + '&Valor=' + Valor;
    $.ajax({
      type: "POST",
      url: "insertar.php",
      data: datos,
      success: function(data) { //alert(data);
        $.ajax({
					url: "vistas/evaluacion/realizar_encuesta_coordinador.php",
					method: "POST",
					data: {
						IdEvaluacion: IdEvaluacion
					},
					success: function(data) {
						$('#employee_detailE').html(data);
						$('#dataModalE').modal('show');
					}
				});
      }
    })
  }
</script>