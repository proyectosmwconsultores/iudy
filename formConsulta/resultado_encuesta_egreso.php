<?php
include('../hace.php');
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdToks = $_POST["IdToks"];
  $pieces = explode("_", $IdToks);
  $IdCampus = $pieces[0];
  $IdCiclo = $pieces[1];
  $IdGrupo = $pieces[2];
  $IdTipo = $pieces[3];
  $IdEvaluacionX = $pieces[4];
  $IdAsignacion = $pieces[5];

  $sql_ev = $db->query("SELECT tblc_tipoevaluacion.Evaluacion FROM tblc_tipoevaluacion WHERE tblc_tipoevaluacion.IdTipoEvaluacion = '$IdTipo'");
  $db->rows($sql_ev);
  $_ev = $db->recorrer($sql_ev);


  $prom = 0;
  $dispo = 0;

  $sqlX = $db->query("SELECT
tblx_respuesta.IdPregunta,
tblx_pregunta.Pregunta,
tblx_pregunta.IdMod,
tblx_pregunta.IdBloque,
tblx_modulo.Nombre_mod,
tblx_bloque.Bloque
FROM
tblx_respuesta
Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta
Left Join tblx_modulo ON tblx_modulo.IdMod = tblx_pregunta.IdMod
Left Join tblx_bloque ON tblx_bloque.IdBloque = tblx_pregunta.IdBloque
WHERE
tblx_respuesta.IdEvaluacion =  '$IdEvaluacionX' AND
tblx_pregunta._Tipo =  '1'
ORDER BY
tblx_pregunta.IdMod ASC,
tblx_pregunta.IdBloque ASC
 ");


 $sql_prom1 = $db->query("SELECT tblx_grafica_materia.IdPregunta, tblx_grafica_materia.Promedio, tblx_pregunta.Pregunta, tblx_modulo.Nombre_mod, tblx_pregunta.IdMod FROM tblx_grafica_materia Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_grafica_materia.IdPregunta Left Join tblx_modulo ON tblx_modulo.IdMod = tblx_pregunta.IdMod WHERE tblx_grafica_materia.IdAsignacion =  '$IdAsignacion' ORDER BY tblx_pregunta.IdMod ASC ");

  $sql_mt = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.CveGrupo, tblp_educativa.Nombre, tblc_modalidad._Modalidad, tblp_grupo.TipoCiclo, tblc_dias_clases._Dias FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
  $db->rows($sql_mt);
  $_mt = $db->recorrer($sql_mt); ?>
  <input type="hidden" name="docente" id="docente" value="<?php echo $_ev["Evaluacion"]; ?>">
  <table class="table table-striped" style="font-size: 12px;">
         <tbody>
           <tr style="background: #5a284f; color: #fbeb00; padding: 10px;">
             <td colspan="7">
               <b><?php echo $_mt['Nombre'].' - '.$_mt['_Modalidad'].' - '.$_mt['_Dias']; ?> </b>
             </td>
           </tr>
           <tr style="background: #003A70; color: white;">
             <td style="padding: 10px;" colspan="5"><b><?php echo $_ev["Evaluacion"]; ?></b></td>
             <td style="padding: 10px;" colspan="2"><b>GRUPO:</b> <?php echo $_mt["CveGrupo"]; ?></td>
           </tr>
           <?php $x = 0; $_px = 0;
           $mi = 0; $mf = 0;  $h = 0; $bi = 0; $bf = 0;
           while($x = $db->recorrer($sqlX)){ $dispo = 1;
             $mi = $x["IdMod"]; $bi = $x["IdBloque"];
             $preg = $x["IdPregunta"];
             $IdPregunta = $x["IdPregunta"];
             $_px = ($_px + 1);
             if($mi <> $mf){ ?>
               <tr style="background: #3c8dbc; color: black;">
                 <td colspan="7">
                   <b><i class="fa fa-fw fa-bookmark-o"></i> <?php echo $x['Nombre_mod']; ?> </b>
                 </td>
               </tr>
             <?php }
             if($bi <> $bf){ ?>
               <tr style="background: #b5bbc8; color: black;">
                 <td colspan='7'>
                   <i class="fa fa-fw fa-check-circle"></i> <?php echo $x["Bloque"]; ?>
                 </td>
             </tr> <?php }

             $sql2 = $db->query("SELECT tblx_pregunta.IdPregunta, tblx_pregunta.Pregunta, tblxx_respuesta.Texto, tblxx_respuesta.Valor FROM tblx_pregunta Left Join tblxx_respuesta ON tblxx_respuesta.IdPregunta = tblx_pregunta.IdPregunta WHERE tblx_pregunta.IdPregunta =  '$preg'"); ?>
         <tr>
           <td colspan="7"><b><?php echo $x["Pregunta"]; ?></b></td>
         </tr>

         <?php $_spt = 0; $_spr = 0; $_prom = 0;
         while($x2 = $db->recorrer($sql2)){
           $_val = $x2['Valor'];

            $sql_s = $db->query("SELECT tblx_respuesta.IdRespuesta, Count(tblx_respuesta.IdPregunta) AS Total, tblx_respuesta.Respuesta AS Valor, tblx_evaluacion.IdTipo, tblx_respuesta.IdGrupo, tblx_respuesta.IdCampus, tblx_respuesta.IdCiclo FROM tblx_respuesta Left Join tblx_evaluacion ON tblx_evaluacion.IdEvaluacionX = tblx_respuesta.IdEvaluacion WHERE tblx_respuesta.IdPregunta = '$IdPregunta' AND tblx_respuesta.Respuesta = '$_val' AND tblx_evaluacion.IdTipo = '$IdTipo' AND tblx_respuesta.IdGrupo = '$IdGrupo' AND tblx_respuesta.IdCampus = '$IdCampus' AND tblx_respuesta.IdCiclo = '$IdCiclo' GROUP BY tblx_respuesta.Respuesta");
           $db->rows($sql_s);
           $_sum = $db->recorrer($sql_s);
           ?>
         <tr>
           <td><?php echo $x2["Valor"]; ?> Pts</td>
           <td colspan="4"><?php echo $x2['Texto']; ?></td>
           <td style="text-align: center; width: 80px;"><?php if($_sum['Total']){ echo $_sum['Total']; } else { echo 0;} ?></td>
           <td style="text-align: center; width: 80px;"> (<?php echo $_vSum = ($_sum['Total'] * $_sum['Valor']); ?> ptos)</td>
         </tr>
         <?php $_spt = ($_spt + $_sum['Total']); $_spr = ($_spr + $_vSum);
        } ?>
         <?php
            $_prom = ($_spr / $_spt); round($_prom,2);
            $sqlV = $db->query("SELECT tblx_grafica_materia.IdGrafica FROM tblx_grafica_materia WHERE tblx_grafica_materia.IdAsignacion = '$IdAsignacion' AND tblx_grafica_materia.IdCiclo = '$IdCiclo' AND tblx_grafica_materia.IdPregunta = '$IdPregunta' ");
            $db->rows($sqlV);
            $datos91 = $db->recorrer($sqlV);
            $_idGraf = $datos91['IdGrafica'];
            if(!$_idGraf){
              $sqlV = $db->query("INSERT INTO tblx_grafica_materia (IdAsignacion, IdPregunta, Promedio, IdCiclo) VALUES ('$IdAsignacion', '$IdPregunta', '$_prom', '$IdCiclo') ");
            } else {
              $sqlV = $db->query("UPDATE tblx_grafica_materia SET tblx_grafica_materia.Promedio = '$_prom' WHERE tblx_grafica_materia.IdGrafica = '$_idGraf' ");
            }
           ?>
         <tr>
           <td colspan="5" style="text-align: right;"><b>Promedio:</b></td>
           <td colspan="2" style="text-align: center;"><b style="color: blue;"><?php echo round($_prom,2); ?></b></td>
         </tr>


       <?php $mf = $x["IdMod"]; $bf = $x["IdBloque"]; }  ?>
       </tbody>
</table>
<?php if($dispo == 1){ ?>
<div id="container_prom_ex" style="width: 100%;"></div>
<table id="datatable_prom_ex" class="table table-striped" style="font-size: 12px;">
  <thead>
    <tr>
      <th>PREGUNTAS DE LA ENCUESTAS</th>
      <th style="text-align: center;">PROMEDIO</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $p = 0; $_sxprom = 0; $mxi=0; $mxf=0;
    while($_pro1 = $db->recorrer($sql_prom1)){ $mxi=$_pro1['IdMod'];
      if($mxi <> $mxf){ ?>
      <tr style="background: #3c8dbc; color: black;">
        <td colspan="2"><i class="fa fa-fw fa-bookmark-o"></i> <?php echo $_pro1['Nombre_mod']; ?></td>
      </tr>
      <?php }
      ?>
    <tr>
      <td><?php echo $p = ($p + 1); ?>.- <?php echo $_pro1['Pregunta']; ?></td>
      <td style="text-align: center;"><?php echo number_format($_pro1['Promedio'], 2, '.', ','); ?></td>
    </tr><?php $_sxprom = ($_sxprom + $_pro1['Promedio']);  $mxf=$_pro1['IdMod']; } ?>
  </tbody>
  <?php
  if($_sxprom){
    $promx = number_format(($_sxprom / $p), 2, '.', ',');

  }
  ?>
</table>
<div class="bg-gray-active color-palette" style="padding: 10px; text-align: right; padding-right: 20px;"><span style="color: black;"> <i class="fa fa-fw fa-check-circle"></i> Promedio alcanzado en esta encuesta: <b style="color: blue;"><?php echo $promx; ?></b></span></div>
<br>
<button onclick="javascript:window.open('formConsulta/resultado_encuesta_egreso_ex.php?IdToks=<?php echo $IdToks; ?>');"  href="javascript:void(0);" type="button" class="btn btn-block btn-danger btn-sm"><i class="fa fa-download"></i> Descargar en formato excel</button>
<?php } ?>



<script>
var Docente = document.getElementById("docente").value;


Highcharts.chart('container_prom_ex', {
data: {
  table: 'datatable_prom_ex'
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
  text: 'Resultado de la encuesta<br>' + Docente
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
