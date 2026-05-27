<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  date_default_timezone_set('America/Mexico_City');   //====================================================
  $idAsignacion = $_POST["idAsignacion"];
  $IdParcial = $_POST["IdParcial"];
  $IdSemana = $_POST["IdSemana"];
  $IdActividad = $_POST["IdActividad"];
  $NoSemana = $_POST["NoSemana"];
  $IdUsua = $_SESSION["IdUsua"];

  $sql8 = $db->query("SELECT tblp_tareas.IdTarea FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '".$_POST["idAsignacion"]."' AND tblp_tareas.IdActividadesDocente = '".$_POST["IdActividad"]."' AND tblp_tareas.IdAlumno= '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdTarea = $datos81["IdTarea"];
  if(!$IdTarea){
    $insertar = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente, FecCap) VALUES ('".$_POST["idAsignacion"]."','$IdUsua','".$_POST["IdActividad"]."','$IdParcial',NOW())");
    $IdTarea = $db->insert_id;
    $sql2 = $db->query("INSERT INTO tblp_examusuario (IdTarea, IdAsignacion, IdParcialDocente, IdActividadesDocente, IdUsua, IdEstatus) VALUES('$IdTarea','$idAsignacion','$IdParcial','$IdActividad','$IdUsua','12')");
  }

  $sql_act = $db->query("SELECT tblp_actividadesdocente.NomActividad, tblp_actividadesdocente.FecIni, tblp_actividadesdocente.FecFin, tblp_actividadesdocente.Tiempo, tblp_actividadesdocente.Ini, tblp_actividadesdocente.Fin, tblp_actividadesdocente.Mostrar FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividad'");
  $db->rows($sql_act);
  $datos_act = $db->recorrer($sql_act);

  $inicio = 0;
  $fini = $datos_act["Ini"];

  if($fini){
    $fini = strtotime($datos_act["Ini"]);
    $ffin = strtotime($datos_act["Fin"]);
    $hoy = strtotime(date("Y-m-d H:m:s"));
    if (($hoy >= $fini) && ($hoy <= $ffin) ){
       $inicio = 1;
     } else {
       $inicio = 0;
     }
  } else {
    $inicio = 1;
  }



   $sql_exam = $db->query("SELECT * FROM tblp_examusuario WHERE tblp_examusuario.IdAsignacion = '$idAsignacion' AND tblp_examusuario.IdParcialDocente = '$IdParcial' AND tblp_examusuario.IdActividadesDocente = '$IdActividad' AND tblp_examusuario.IdUsua = '$IdUsua' AND tblp_examusuario.IdTarea = '$IdTarea'");
   $db->rows($sql_exam);
   $datos71 = $db->recorrer($sql_exam);
   $IdExamU = $datos71['IdExamenUsua'];
   if(($datos71["IdEstatus"] == 12) && ($datos71["Valor"] == 1) && ($inicio == 1)){
     $Tiempo = $datos_act['Tiempo'];

     $sql6 = $db->query("SELECT tblp_exampregunta.IdPregunta FROM tblp_exampregunta WHERE tblp_exampregunta.IdAsignacion = '$idAsignacion' AND tblp_exampregunta.IdActividadesDocente = '$IdActividad' AND tblp_exampregunta.IdParcialDocente = '$IdParcial'");
     while($xx = $db->recorrer($sql6)){
       $IdPreg = $xx["IdPregunta"];
       $insertar = $db->query("INSERT INTO tblp_examresultado (IdUsua, IdAsignacion, IdExamenUsuario, IdParcialDocente, IdActividadesDocente, IdPregunta)VALUES('$IdUsua','$idAsignacion','$IdExamU','$IdParcial','$IdActividad','$IdPreg')");
     }

      $min =date("i-s");
      $anio = date("Y");
      $mes = date("m");
      $dia = date("d");
      $hora = date("G") + $Tiempo;
      if($hora > 24){ $dia = $dia + 1; $hora =  ($hora - 24);  }

      $ini =date("Y-m-d G-i-s");
      $fin =date("Y-m-$dia $hora-i-s");

      $insertar = $db->query("UPDATE tblp_examusuario SET tblp_examusuario.IdEstatus = '8',  tblp_examusuario.FecIni = '$ini', tblp_examusuario.FecFin = '$fin' WHERE tblp_examusuario.IdExamenUsua = '$IdExamU'");

   }

   $text = "Su evaluación no esta activo.";

   if(($datos71["Valor"] == 1) && ($inicio == 1)){ $text = "";
     $sql_preg = $db->query("SELECT tblp_examresultado.IdResultado, tblp_examresultado.IdPregunta, tblp_exampregunta.Pregunta, tblp_exampregunta.Tipo, tblp_exampregunta.Imagen  FROM tblp_examresultado Left Join tblp_exampregunta ON tblp_exampregunta.IdPregunta = tblp_examresultado.IdPregunta WHERE tblp_examresultado.IdExamenUsuario = '$IdExamU' AND tblp_examresultado.IdAsignacion = '$idAsignacion' AND tblp_examresultado.IdActividadesDocente = '$IdActividad' AND tblp_examresultado.Valor IS NULL LIMIT 1 ");
     $db->rows($sql_preg);
     $datos_preg = $db->recorrer($sql_preg);

     $sql_pIni = $db->query("SELECT Count(tblp_examresultado.IdResultado) AS Preguntas FROM tblp_examresultado WHERE tblp_examresultado.IdExamenUsuario = '$IdExamU' ");
     $db->rows($sql_pIni);
     $datos_I = $db->recorrer($sql_pIni);

     $sql_pAva = $db->query("SELECT Count(tblp_examresultado.IdResultado) AS Contestadas FROM tblp_examresultado WHERE tblp_examresultado.IdExamenUsuario =  '$IdExamU' AND tblp_examresultado.Valor IS NOT NULL ");
     $db->rows($sql_pAva);
     $datos_A = $db->recorrer($sql_pAva);



   if($datos_I["Preguntas"]){
     $valorPre = (100 / $datos_I["Preguntas"]);
     $avaPre = ($datos_A["Contestadas"] * $valorPre);
   }

   if($datos_I["Preguntas"] == $datos_A["Contestadas"]){
    $text = "Haz contestado todas las preguntas";
   }

   }


  ?>
  <form name="frm" id="frm" action="doSelActa.php" method="POST" enctype="multipart/form-data">

    <div class="row">
  		<div class="col-md-8">
        <div class="box-primary">
          <div class="box-body">
            <div class="box-header with-border">
              <i class="fa fa-comments"></i>
              <h3 class="box-title"><?php echo $datos_act['NomActividad']; ?></h3>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box-primary">
          <div class="box-body">
            <a class="btn btn-app" onclick="actualizarEva(<?php echo $IdParcial; ?>,<?php echo $IdSemana; ?>,<?php echo $NoSemana; ?>,<?php echo $IdActividad; ?>)" href="javascript:void(0);">
              <span class="badge bg-gren"><i class="fa fa-refresh"></i></span>
              <i class="fa fa-refresh"></i> Actualizar
            </a>
            <a class="btn btn-app" onclick="miUnidad(<?php echo $IdParcial; ?>,<?php echo $IdSemana; ?>,<?php echo $NoSemana; ?>)">
              <span class="badge bg-red"><i class="fa fa-reply"></i></span>
              <i class="fa fa-reply-all"></i> Regresar
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="bg-purple color-palette" style="padding: 10px; font-weight: bold; font-size: 16px;">
          <span>Fecha la de evaluación: <?php echo $datos_act["Ini"]; ?> hasta el <?php echo $datos_act["Fin"]; ?></span>
        </div>

        <div class="box-primary">
          <div class="box-body">
            <div class="box-header with-border">
                <h3 class="box-title">Semana <?php echo $NoSemana; ?></h3>
                <?php if($datos71["FecIni"]){ ?>
                <div class="box-tools pull-right">
                  <a style="color: black;" href="#" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Previous"><i class="fa fa-clock-o"></i> Inicia su evaluación: <?php echo $datos71["FecIni"]; ?> finaliza a las <?php echo substr($datos71["FecFin"], 10,10); ?></a>
                </div><?php } ?>
              </div>
          </div>

          <?php if($text){ ?> <br><br><div class="bg-navy color-palette" style="padding: 20px; text-align: center;"><span><b><i class="fa fa-fw fa-warning"></i> <?php echo $text; ?></b></span></div> <?php  } ?>


          <?php if(($datos71["Valor"] == 1) && ($inicio == 1)){  ?>

            <div class="box-body">
              <div class="box-header with-border">
                  <h3 class="box-title">Avance de preguntas contestadas: <?php echo $datos_A["Contestadas"]; ?> de <?php  echo $datos_I["Preguntas"]; ?></h3>
                  <div class="progress progress-sm active">
                    <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avaPre; ?>%">
                      <span class="sr-only">20% Complete</span>
                    </div>
                  </div>
                </div>
            </div>

            <div class="box-body">
              <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $datos_preg["Pregunta"]; ?></h3>
                  <?php if(isset($datos_preg["IdResultado"])){ ?>
                  <table class="table table-striped">
                    <thead>
                      <?php if($datos_preg["Imagen"]){ ?>
                        <img src="assets/images/examen/<?php echo $datos_preg["Imagen"]; ?>" width="100%">
                      <?php } ?>
                      <?php if($datos_preg["Tipo"] == "O"){ $IdP = $datos_preg['IdPregunta'];
                        $sql_res = $db->query("SELECT * FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdPregunta ='$IdP'");
                      $xF= 0;  while($res = $db->recorrer($sql_res)){ ?>
                    <tr>
                      <th width="100px;">
                        <button onclick="addResponder(<?php echo $datos_preg["IdResultado"]; ?>,<?php echo $res["IdRespuesta"]; ?>,<?php echo $IdParcial; ?>,<?php echo $IdSemana; ?>,<?php echo $NoSemana; ?>,<?php echo $IdActividad; ?>)" type="button" class="btn btn-default"><i class="fa fa-fw fa-check-circle"></i></button>
                      </th>
                      <th>
                        <?php echo $xF = $xF + 1; ?>)  <?php echo $res["Respuesta"]; ?>
                      </th>

                    </tr><?php } } else { ?>
                      <tr>
                        <th><p class="lead"><b>Escriba su respuesta:</b> </p></th>
                      </tr>
                      <tr>
                        <th>
                          <textarea class="form-control" name="txtRespuesta-<?php echo $datos_preg["IdResultado"]; ?>" id="txtRespuesta-<?php echo $datos_preg["IdResultado"]; ?>"></textarea>
                        </th>

                      </tr>
                      <tr>
                        <th><button onclick="envioResAb(<?php echo $datos_preg["IdResultado"]; ?>,<?php echo $IdParcial; ?>,<?php echo $IdSemana; ?>,<?php echo $NoSemana; ?>,<?php echo $IdActividad; ?>)" type="button" class="btn btn-primary pull-right"><i class="fa fa-send"></i> Responder</button></th>
                      </tr>
                    <?php } ?>
                    </thead>

                  </table>
                  <?php } ?>

                </div>
            </div>
          <?php } else { ?>

          <?php } ?>

        </div>
      </div>
    </div>

</form>

<script>
function actualizarEva(IdParcial,IdSemana,NoSemana,IdActividad){

    var PanelPar1 = "panel_4"+NoSemana;
    var PanelPar2 = "#panel_4"+NoSemana;
    var idAsignacion = document.getElementById("idAsignacion").value;
    var IdMenu = document.getElementById("IdMenu").value;
    var div = "panel_"+IdMenu;
    document.getElementById(div).style.display = 'none';
    document.getElementById(PanelPar1).style.display = 'block';

    var Capa = PanelPar2;
    $(Capa).load("alumnos/miExamen.php",{idAsignacion:idAsignacion,IdParcial:IdParcial,IdSemana:IdSemana, IdActividad:IdActividad, NoSemana:NoSemana}, function(response, status, xhr) {
      if (status == "error") { alert(status);
        var msg = "Error!, algo ha sucedido: ";
        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
      }
    });
    document.getElementById("IdMenu").value = '4'+NoSemana;
}

function envioResAb(IdResultado,IdParcial,IdSemana,NoSemana,IdActividad){
  var Respuesta = document.getElementById("txtRespuesta-"+IdResultado).value;
  var IdAsignacion = document.getElementById("idAsignacion").value;
  if (Respuesta ==''){
      swal("Error al guardar", "Debe escribir su respuesta a esta pregunta.", "error");
      document.getElementById("txtRespuesta").focus();
      return 0;
  }

	var TipoGuardar = "savRespuetsaExs";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea enviar esta respuesta?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			$(".confirm").attr('disabled', 'disabled');
      $.ajax({
        type:"POST",
        url:"alumnos/setting.php",
        data:{Respuesta:Respuesta,IdResultado:IdResultado,TipoGuardar:TipoGuardar},
        success:function(data){
          var PanelPar1 = "panel_4"+NoSemana;
          var PanelPar2 = "#panel_4"+NoSemana;
          var idAsignacion = document.getElementById("idAsignacion").value;
          var IdMenu = document.getElementById("IdMenu").value;
          var div = "panel_"+IdMenu;
          document.getElementById(div).style.display = 'none';
          document.getElementById(PanelPar1).style.display = 'block';

          var Capa = PanelPar2;
          $(Capa).load("alumnos/miExamen.php",{idAsignacion:idAsignacion,IdParcial:IdParcial,IdSemana:IdSemana, IdActividad:IdActividad, NoSemana:NoSemana}, function(response, status, xhr) {
            if (status == "error") { alert(status);
              var msg = "Error!, algo ha sucedido: ";
              $(Capa).html(msg + xhr.status + " " + xhr.statusText);
            }
          });
          document.getElementById("IdMenu").value = '4'+NoSemana;
        }
      })
		}
	});
}

function addResponder(IdResultado, IdRespuesta,IdParcial,IdSemana,NoSemana,IdActividad){
  var IdAsignacion = document.getElementById("idAsignacion").value;
  var TipoGuardar = "savExamenRes";
  swal({
    title: "\u00BFEst\u00E1 seguro de enviar estar respuesta como correcta?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Aceptar',
    cancelButtonText: "Cancelar",
  },
  function (isConfirm) {
    if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      $.ajax({
        type:"POST",
        url:"alumnos/setting.php",
        data:{IdRespuesta:IdRespuesta,IdResultado:IdResultado,TipoGuardar:TipoGuardar},
        success:function(data){
          var PanelPar1 = "panel_4"+NoSemana;
          var PanelPar2 = "#panel_4"+NoSemana;
          var idAsignacion = document.getElementById("idAsignacion").value;
          var IdMenu = document.getElementById("IdMenu").value;
          var div = "panel_"+IdMenu;
          document.getElementById(div).style.display = 'none';
          document.getElementById(PanelPar1).style.display = 'block';

          var Capa = PanelPar2;
          $(Capa).load("alumnos/miExamen.php",{idAsignacion:idAsignacion,IdParcial:IdParcial,IdSemana:IdSemana, IdActividad:IdActividad, NoSemana:NoSemana}, function(response, status, xhr) {
            if (status == "error") { alert(status);
              var msg = "Error!, algo ha sucedido: ";
              $(Capa).html(msg + xhr.status + " " + xhr.statusText);
            }
          });
          document.getElementById("IdMenu").value = '4'+NoSemana;

        }
      })
    }
  });
}
</script>
