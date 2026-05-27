<?php
include('../hace.php');

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdDocente = substr($_POST["IdDocente"], 10, 10);
  $IdAsignacion = $_POST["IdAsignacion"];
  $prom = 0;
  $dispo = 0;

  $sqlX = $db->query("SELECT tblx_respuesta.IdRespuesta, tblx_respuesta.IdPregunta, tblx_respuesta.IdDocente, tblx_respuesta.IdGrupo, tblx_respuesta.IdOferta, tblx_respuesta.IdAsignacion, tblx_respuesta.IdModulo, tblx_respuesta.IdCiclo, tblx_pregunta.Pregunta FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta WHERE tblx_respuesta.IdDocente = '$IdDocente' AND tblx_respuesta.IdAsignacion = '$IdAsignacion' AND tblx_pregunta._Tipo =  '1' GROUP BY tblx_respuesta.IdPregunta ");

  $sqlV = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdDocente'");
  $db->rows($sqlV);
  $datos91 = $db->recorrer($sqlV);

  $sqlH = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_educativa.Nombre, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_grupo.CveGrupo FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2' ");
  $db->rows($sqlH);
  $datos81 = $db->recorrer($sqlH);

  $sql_prom1 = $db->query("SELECT tblx_grafica_materia.IdPregunta, tblx_grafica_materia.Promedio, tblx_pregunta.Pregunta FROM tblx_grafica_materia Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_grafica_materia.IdPregunta WHERE tblx_grafica_materia.IdAsignacion =  '$IdAsignacion' ");

?>
<input type="hidden" name="docente" id="docente" value="DOCENTE: <?php echo $datos91["Nombre"].' '.$datos91["APaterno"].' '.$datos91["AMaterno"]; ?> " >
   <table class="table table-striped" style="font-size: 12px;">
         <tbody>
           <tr style="background: #5a284f; color: #fbeb00; padding: 10px;">
             <td style="width: 80px;"><img class="img-circle" style="width: 50px;" src="assets/perfil/<?php echo $datos91["Foto"]; ?>" alt="Sin foto de perfil"></td>
             <td colspan="5">
               <b>ASESOR:</b> <?php echo $datos91["APaterno"].' '.$datos91["AMaterno"].' '.$datos91["Nombre"]; ?><br>
               <?php echo $datos81["Nombre"]; ?>
             </td>
             <td>
               Fecha de impresión:<br> <?php echo date("Y-m-d H-m-s"); ?>
             </td>
           </tr>
           <tr style="background: #003A70; color: white;">
             <td style="padding: 10px;" colspan="5"><b>MATERIA:</b> <?php echo $datos81["CodeModulo"].' '.$datos81["NombreMod"]; ?></td>
             <td style="padding: 10px;" colspan="2"><b>GRUPO:</b> <?php echo $datos81["CveGrupo"]; ?></td>
           </tr>
           <?php $x = 0; $snx = 0; while($x = $db->recorrer($sqlX)){ $dispo = 1;
             $preg = $x["IdPregunta"];
             $IdModulo = $x["IdModulo"];
             $IdAsig = $x["IdAsignacion"];
             $IdCiclo = $x["IdCiclo"];

             $snx = $snx + 1;
             $sum10 = 0; $sum9 = 0; $sum8 = 0; $sum7 = 0;
echo "SELECT tblx_respuesta.IdPregunta, Count(tblx_respuesta.Respuesta) AS Suma, tblx_pregunta.Pregunta, tblx_respuesta.Respuesta, tblxx_respuesta.Texto FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta Left Join tblxx_respuesta ON tblxx_respuesta.IdResp = tblx_respuesta.Respuesta WHERE tblx_respuesta.IdModulo =  '$IdModulo' AND tblx_respuesta.IdPregunta =  '$preg' AND tblx_respuesta.IdDocente =  '$IdDocente' GROUP BY tblx_respuesta.Respuesta ORDER BY tblx_respuesta.IdPregunta ASC,  tblx_respuesta.Respuesta DESC"; echo "<br><br>";
             $sql2 = $db->query("SELECT tblx_respuesta.IdPregunta, Count(tblx_respuesta.Respuesta) AS Suma, tblx_pregunta.Pregunta, tblx_respuesta.Respuesta, tblxx_respuesta.Texto FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta Left Join tblxx_respuesta ON tblxx_respuesta.IdResp = tblx_respuesta.Respuesta WHERE tblx_respuesta.IdModulo =  '$IdModulo' AND tblx_respuesta.IdPregunta =  '$preg' AND tblx_respuesta.IdDocente =  '$IdDocente' GROUP BY tblx_respuesta.Respuesta ORDER BY tblx_respuesta.IdPregunta ASC, tblx_respuesta.Respuesta DESC");
             ?>
         <tr>
           <td colspan="7"><b><?php echo $x["Pregunta"]; ?></b></td>
         </tr>
         <tr>
           <?php   $res9 = 0; $res8= 0; $res7 = 0; $sum6 = 0; $sum5 = 0; $res6 = 0; $res5 = 0; $pts = 0; $sumP = 0;
           $t10 = ''; $t9 = ''; $t8 = ''; $t7 = ''; $t6 = ''; $t5 = '';
           while($x2 = $db->recorrer($sql2)){
             if($x2["Respuesta"] == 10) { $sum10 = $x2["Suma"];  $res10 = $x2["Respuesta"]; $t10 = $x2["Texto"]; } else { $t10 = ''; }
             if($x2["Respuesta"] == 9) { $sum9 = $x2["Suma"];  $res9 = $x2["Respuesta"]; $t9 = $x2["Texto"]; } else { $t9 = ''; }
             if($x2["Respuesta"] == 8) { $sum8 = $x2["Suma"];  $res8 = $x2["Respuesta"]; $t8 = $x2["Texto"]; } else { $t8 = ''; }
             if($x2["Respuesta"] == 7) { $sum7 = $x2["Suma"];  $res7 = $x2["Respuesta"]; $t7 = $x2["Texto"]; } else { $t7 = ''; }
             if($x2["Respuesta"] == 6) { $sum6 = $x2["Suma"];  $res6 = $x2["Respuesta"]; $t6 = $x2["Texto"]; } else { $t6 = ''; }
             if($x2["Respuesta"] == 5) { $sum5 = $x2["Suma"];  $res5 = $x2["Respuesta"]; $t5 = $x2["Texto"]; } else { $t5 = ''; }
             $pts = ($pts + $x2["Suma"]);

           }
             ?>
             <td style="width: 16%;"><?php if($t10){ echo $t10; ?><br><?php echo $sum10; ?> (<?php echo $x1 = ($sum10 * $res10); ?> pts.) <?php } else { $x1 = 0; } ?></td>
             <td style="width: 16%;"><?php if($t9){ echo $t10; ?><br><?php echo $sum9; ?> (<?php echo $x2 = ($sum9 * $res9); ?> pts.) <?php } else { $x2 = 0; } ?></td>
             <td style="width: 16%;"><?php if($t8){ echo $t10; ?><br><?php echo $sum8; ?> (<?php echo $x3 = ($sum8 * $res8); ?> pts.) <?php } else { $x3 = 0; } ?></td>
             <td style="width: 16%;"><?php if($t7){ echo $t10; ?><br><?php echo $sum7; ?> (<?php echo $x4 = ($sum7 * $res7); ?> pts.) <?php } else { $x4 = 0; } ?></td>
             <td style="width: 16%;"><?php if($t6){ echo $t10; ?><br><?php echo $sum6; ?> (<?php echo $x6 = ($sum6 * $res6); ?> pts.) <?php } else { $x5 = 0; } ?></td>
             <td style="width: 16%;"><?php if($t5){ echo $t10; ?><br><?php echo $sum5; ?> (<?php echo $x5 = ($sum5 * $res5); ?> pts.) <?php } else { $x6 = 0; } ?></td>


           <?php

            $sumPx = ($sum10 + $sum9 + $sum8 + $sum7 + $sum6);
            $tot = ($x1 + $x2 + $x3 + $x4 + $x5);
            ?>
           <td style="text-align: center;">

             <b>Promedio: </b><br><b><?php if($pts){ $c = ($tot/$sumPx);  echo round($c,2);  $prom = ($prom + $c);
               $sqlV = $db->query("SELECT tblx_grafica_materia.IdGrafica FROM tblx_grafica_materia WHERE tblx_grafica_materia.IdDocente = '$IdDocente' AND tblx_grafica_materia.IdAsignacion = '$IdAsig' AND tblx_grafica_materia.IdCiclo = '$IdCiclo' AND tblx_grafica_materia.IdPregunta = '$preg' ");
               $db->rows($sqlV);
               $datos91 = $db->recorrer($sqlV);
               $_idGraf = $datos91['IdGrafica'];
               if(!$_idGraf){
                 $sqlV = $db->query("INSERT INTO tblx_grafica_materia (IdAsignacion, IdDocente, IdPregunta, Promedio, IdCiclo) VALUES ('$IdAsig', '$IdDocente', '$preg', '$c', '$IdCiclo') ");
               } else {
                 $sqlV = $db->query("UPDATE tblx_grafica_materia SET tblx_grafica_materia.Promedio = '$c' WHERE tblx_grafica_materia.IdGrafica = '$_idGraf' ");
               }
             } ?></b>
           </td>
         </tr>
       <?php $x1 = 0; $x2 = 0; $x3 = 0; $x4 = 0; $x5 = 0; }  ?>
       <tr style="background: #5a284f; color: #fbeb00;">
         <td colspan="5" style="text-align: right; padding: 14px;"><b>PROMEDIO DEL DOCENTE:</b></td>
         <td style="padding: 10px; font-size: 14px; text-align: center;"><b><?php if($prom){
            $pmr = ($prom/$snx);
            echo $_prmx = round($pmr,2);
           $sql_promx = $db->query("SELECT tblx_grafica_prom_materia.IdGrafica_prom FROM tblx_grafica_prom_materia WHERE tblx_grafica_prom_materia.IdDocente = '$IdDocente' AND tblx_grafica_prom_materia.IdAsignacion = '$IdAsig' AND tblx_grafica_prom_materia.IdCiclo = '$IdCiclo' ");
           $db->rows($sql_promx);
           $datos91 = $db->recorrer($sql_promx);
           $_idGrafx = $datos91['IdGrafica_prom'];
           if(!$_idGrafx){
             $sqlV = $db->query("INSERT INTO tblx_grafica_prom_materia (IdAsignacion, IdDocente, Promedio, IdCiclo) VALUES ('$IdAsig', '$IdDocente', '$_prmx', '$IdCiclo') ");
           } else {
             $sqlV = $db->query("UPDATE tblx_grafica_prom_materia SET tblx_grafica_prom_materia.Promedio = '$_prmx' WHERE tblx_grafica_prom_materia.IdGrafica_prom = '$_idGraf' ");
           }
         } ?></b></td>
       </tr>
       </tbody>
</table>
<?php if($dispo == 1){ ?>
<div id="container_prom" style="width: 100%;"></div>
<table id="datatable_prom" class="table table-striped" style="font-size: 12px;">
  <thead>
    <tr>
      <th>Pregunta de la encuesta</th>
      <th>Puntos</th>
    </tr>
  </thead>
  <tbody>
    <?php while($_pro1 = $db->recorrer($sql_prom1)){ ?>
    <tr>
      <td><?php echo $_pro1['Pregunta']; ?></td>
      <td><?php echo number_format($_pro1['Promedio'], 2, '.', ','); ?></td>
    </tr><?php } ?>

  </tbody>
</table><?php } ?>

<script>
var Docente = document.getElementById("docente").value;


Highcharts.chart('container_prom', {
data: {
  table: 'datatable_prom'
},
// chart: {
//   type: 'column'
// },
chart: {
  type: 'column',
  options3d: {
    enabled: true,
    alpha: 10,
    beta: 25,
    depth: 70
  }
},
title: {
  text: 'Resultado de la encuesta de todo el ciclo escolar del docente <br>' + Docente
},
yAxis: {
  allowDecimals: false,
  title: {
    text: 'Promedio alcanzado'
  }
},
tooltip: {
  formatter: function () {
    return '<b>Pregunta: </b> ' + this.point.name.toLowerCase() + ' <br> <b>Promedio: </b> ' + this.point.y;
  }
}
});
</script>
