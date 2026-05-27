<?php
require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdDocente = $_POST["IdUsua"];
  $IdCiclo = $_POST["IdCiclo"];

  $valor = 1;

  $sqlX = $db->query("SELECT
tblx_respuesta.IdRespuesta,
tblx_respuesta.IdPregunta,
tblx_respuesta.IdDocente,
tblx_respuesta.IdGrupo,
tblx_respuesta.IdModulo
FROM
tblx_respuesta
WHERE tblx_respuesta.IdDocente =  '$IdDocente' AND tblx_respuesta.IdCiclo =  '$IdCiclo' GROUP BY tblx_respuesta.IdAsignacion ");


$sqlV = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdDocente'");
$db->rows($sqlV);
$datos91 = $db->recorrer($sqlV);

$sqlH = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
$db->rows($sqlH);
$datos81 = $db->recorrer($sqlH);

// $sqlD = $db->query("SELECT tblp_evaluaciondocente.IdEvaluacion FROM tblp_evaluaciondocente WHERE tblp_evaluaciondocente.IdCiclo = '$IdCiclo' AND tblp_evaluaciondocente.IdUsua = '$IdDocente'");
// $db->rows($sqlD);
// $datos41 = $db->recorrer($sqlD);
// if(!$datos41["IdEvaluacion"]){ $valor = 1;
//   $insertar = $db->query("INSERT INTO tblp_evaluaciondocente (IdUsua, IdCiclo, FecCap)VALUES ('$IdDocente','$IdCiclo',NOW())");
//   $IdEvaDoc = $db->insert_id;
// } else {
//   $IdEvaDoc = $datos41["IdEvaluacion"];
// }

if($valor == 1){
while($x = $db->recorrer($sqlX)){
                      $IdModulo = $x["IdModulo"];
                      $IdGrupo = $x["IdGrupo"];


                      $sql = $db->query("SELECT tblx_respuesta.IdPregunta, Sum(tblx_respuesta.Respuesta) AS Total, tblx_pregunta.Pregunta FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta WHERE tblx_respuesta.IdModulo =  '$IdModulo' AND tblx_respuesta.IdDocente = '$IdDocente' AND tblx_respuesta.IdGrupo = '$IdGrupo' GROUP BY tblx_respuesta.IdPregunta");
                      while($x = $db->recorrer($sql)){ $preg = $x["IdPregunta"]; $snx = $snx + 1;
                        $sum10 = 0; $sum9 = 0; $sum8 = 0; $sum7 = 0;
                      $sql2 = $db->query("SELECT tblx_respuesta.IdPregunta, Count(tblx_respuesta.Respuesta) AS Suma, tblx_pregunta.Pregunta, tblx_respuesta.Respuesta, tblxx_respuesta.Texto FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta Left Join tblxx_respuesta ON tblxx_respuesta.IdResp = tblx_respuesta.Respuesta WHERE tblx_respuesta.IdModulo =  '$IdModulo' AND tblx_respuesta.IdPregunta =  '$preg' AND tblx_respuesta.IdDocente =  '$IdDocente' GROUP BY tblx_respuesta.Respuesta ORDER BY tblx_respuesta.Respuesta DESC");
                       $pts = 0; $sumP = 0; while($x2 = $db->recorrer($sql2)){
                      if($x2["Respuesta"] == 10) { $sum10 = $x2["Suma"];  $res10 = $x2["Respuesta"]; }
                      if($x2["Respuesta"] == 9) { $sum9 = $x2["Suma"];  $res9 = $x2["Respuesta"]; }
                      if($x2["Respuesta"] == 8) { $sum8 = $x2["Suma"];  $res8 = $x2["Respuesta"]; }
                      if($x2["Respuesta"] == 7) { $sum7 = $x2["Suma"];  $res7 = $x2["Respuesta"]; }
                      if($x2["Respuesta"] == 6) { $sum6 = $x2["Suma"];  $res6 = $x2["Respuesta"]; }
                      $pts = ($pts + $x2["Suma"]);

                    }

                       $x1 = ($sum10 * $res10);
                       $x2 = ($sum9 * $res9);
                      $x3 = ($sum8 * $res8);
                       $x4 = ($sum7 * $res7);
                      $x5 = ($sum6 * $res6);



                     $sumPx = ($sum10 + $sum9 + $sum8 + $sum7 + $sum6);
                     $tot = ($x1 + $x2 + $x3 + $x4 + $x5);
                      $c = ($tot/$sumPx);   $prom = ($prom + $c);

                 $x1 = 0; $x2 = 0; $x3 = 0; $x4 = 0; $x5 = 0; }

              if($prom){ $pmr = ($prom/$snx);  }

                   $vbvc = ($pmr + $vbvc);  $sTods = ($sTods + 1); }
                   if($vbvc){ $psmrX = ($vbvc/$sTods);  }
$prms = round($psmrX,2);
// echo $insertar = $db->query("UPDATE tblp_evaluaciondocente SET tblp_evaluaciondocente.Promedio = '$prms' WHERE tblp_evaluaciondocente.IdEvaluacion = '$IdEvaDoc'");
}
 ?>
