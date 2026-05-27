<?php
include('../hace.php');

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdCiclo = substr($_GET["idE"], 10,10);
  $IdCampus = substr($_GET["idC"],10,10);
  $IdOferta = substr($_GET["idO"],10,10);
echo "SELECT
tblx_respuesta.IdDocente,
tblx_respuesta.IdModulo,
tblx_respuesta.IdGrupo
FROM
tblx_respuesta
WHERE
tblx_respuesta.IdCiclo =  '$IdCiclo' AND
tblx_respuesta.IdOferta =  '$IdOferta' AND
tblx_respuesta.IdCampus =  '$IdCampus'
GROUP BY
tblx_respuesta.IdModulo";

  $sqlM = $db->query("SELECT
tblx_respuesta.IdDocente,
tblx_respuesta.IdModulo,
tblx_respuesta.IdGrupo
FROM
tblx_respuesta
WHERE
tblx_respuesta.IdCiclo =  '$IdCiclo' AND
tblx_respuesta.IdOferta =  '$IdOferta' AND
tblx_respuesta.IdCampus =  '$IdCampus'
GROUP BY
tblx_respuesta.IdModulo");




    ?>

   <style>


   table {
       font-family: arial, sans-serif;
       border-collapse: collapse;
       width: 100%;
   		font-size: 12px;
   }

   td, th {
       border: 1px solid #dddddd;
       padding: 3px;
   }
   tr:nth-child(even) {
       background-color: #dddddd;
   }


   </style>
   <title>Vista de respuestas</title>
  <form name="frm" id="frm" action="addGrupo.php" method="POST" enctype="multipart/form-data">
    <div class="table-responsive">
          <div class="box-body">
            <div class="box-header">
              <h3 class="box-title">Resultado de la evaluación docente</h3>
            </div>

            <?php while($m = $db->recorrer($sqlM)){
              $IdDocente = $m["IdDocente"];
              $IdModulo = $m["IdModulo"];
              $IdGrupo = $m["IdGrupo"];

              $sql9 = $db->query("SELECT tblx_respuesta.IdDocente, tblx_respuesta.IdModulo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_grupo.CveGrupo FROM tblx_respuesta Left Join tblc_usuario ON tblc_usuario.IdUsua = tblx_respuesta.IdDocente Left Join tblp_modulo ON tblp_modulo.IdModulo = tblx_respuesta.IdModulo Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblx_respuesta.IdGrupo WHERE tblx_respuesta.IdDocente =  '$IdDocente' AND tblx_respuesta.IdModulo =  '$IdModulo' AND tblx_respuesta.IdGrupo =  '$IdGrupo' GROUP BY tblx_respuesta.IdDocente");
              $db->rows($sql9);
              $datos91 = $db->recorrer($sql9);

              $sql = $db->query("SELECT tblx_respuesta.IdPregunta, Sum(tblx_respuesta.Respuesta) AS Total, tblx_pregunta.Pregunta FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta WHERE tblx_respuesta.IdModulo =  '$IdModulo' AND tblx_respuesta.IdDocente = '$IdDocente' AND tblx_respuesta.IdGrupo = '$IdGrupo' GROUP BY tblx_respuesta.IdPregunta");
               ?>
          <div class="col-md-12">
            <table class="table table-striped">
                  <tbody>

                    <tr style="background: gray; padding: 10px;">
                      <td style="width: 80px;"><img class="img-circle" style="width: 50px;" src="../assets/perfil/<?php echo $datos91["Foto"]; ?>" alt="Sin foto de perfil"></td>
                      <td colspan="5">
                        <b>Profesor: </b> <?php echo $datos91["APaterno"].' '.$datos91["AMaterno"].' '.$datos91["Nombre"]; ?><br>
                        <b>Materia: </b> <?php echo $datos91["CodeModulo"].' '.$datos91["NombreMod"]; ?><br>
                        <b>Grupo: </b> <?php echo $datos91["CveGrupo"]; ?>
                      </td>
                    </tr>

                    <?php while($x = $db->recorrer($sql)){ $preg = $x["IdPregunta"];
                      $sql2 = $db->query("SELECT tblx_respuesta.IdPregunta, Count(tblx_respuesta.Respuesta) AS Suma, tblx_pregunta.Pregunta, tblx_respuesta.Respuesta, tblxx_respuesta.Texto FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta Left Join tblxx_respuesta ON tblxx_respuesta.IdResp = tblx_respuesta.Respuesta WHERE tblx_respuesta.IdModulo =  '$IdModulo' AND tblx_respuesta.IdPregunta =  '$preg' AND tblx_respuesta.IdDocente =  '$IdDocente' GROUP BY tblx_respuesta.Respuesta ORDER BY tblx_respuesta.Respuesta DESC");
                      ?>
                  <tr>
                    <td colspan="6"><b><?php echo $x["Pregunta"]; ?></b></td>
                  </tr>
                  <tr>
                    <?php while($x2 = $db->recorrer($sql2)){ ?>
                    <td><?php echo $x2["Texto"]; ?> <br><?php echo $x2["Suma"]; ?> (<?php echo $x = ($x2["Suma"] * $x2["Respuesta"]); ?> pts.)</td>
                    <?php $pts = ($pts + $x2["Suma"]); $tls = ($tls + $x);  } ?>
                    <td style="text-align: center;"><b>Promedio:</b><br><?php if($pts){ $c = ($tls/$pts);  echo round($c,2);  $prom = ($prom + $c); } ?></td>
                  </tr>
                <?php }  ?>
                <tr>
                  <td colspan="5" style="text-align: right; font-size: 14px; padding: 10px;"><b>promedio del docente:</b></td>
                  <td style="text-align: center; font-size: 14px; padding: 10px;"><b><?php if($prom){ $pmr = ($prom/10);  echo round($pmr,2);} ?></b></td>
                </tr>
                </tbody></table>
              </div>
            <?php $prom = 0;} ?>



          </div>
    </div>
  </form>
