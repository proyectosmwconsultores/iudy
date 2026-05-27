<?php
include('../hace.php');
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdDocente = substr($_POST["IdDocente"], 10, 10);
  $IdAsignacion = $_POST["IdAsignacion"];
  $prom = 0;
  $dispo = 0;

  $sqlX = $db->query("SELECT tblx_respuesta.IdRespuesta, tblx_respuesta.IdPregunta, tblx_respuesta.IdDocente, tblx_respuesta.IdGrupo, tblx_respuesta.IdOferta, tblx_respuesta.IdAsignacion, tblx_respuesta.IdModulo, tblx_respuesta.IdCiclo, tblx_pregunta.Pregunta, tblx_modulo.IdMod, tblx_modulo.Nombre_mod FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta Left Join tblx_modulo ON tblx_modulo.IdMod = tblx_pregunta.IdMod WHERE tblx_respuesta.IdDocente = '$IdDocente' AND tblx_respuesta.IdAsignacion = '$IdAsignacion' AND tblx_pregunta._Tipo =  '1' GROUP BY tblx_respuesta.IdPregunta ORDER BY tblx_modulo.IdMod ASC ");

  $sqlV = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdDocente'");
  $db->rows($sqlV);
  $datos91 = $db->recorrer($sqlV);

  $sqlH = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_educativa.Nombre, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_grupo.CveGrupo FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2' ");
  $db->rows($sqlH);
  $datos81 = $db->recorrer($sqlH);
  ?>
  <input type="hidden" name="docente" id="docente" value="DOCENTE: <?php echo $datos91["Nombre"].' '.$datos91["APaterno"].' '.$datos91["AMaterno"]; ?> " >
  <table class="table table-striped" style="font-size: 12px;">
     <tbody>
       <tr style="background: #5a284f; color: #fbeb00; padding: 10px;">
         <td style="width: 10px;"><img class="img-circle" style="width: 50px;" src="assets/perfil/<?php echo $datos91["Foto"]; ?>" alt="Sin foto de perfil"></td>
         <td colspan="6"><br>
           <b> <?php echo $datos91["Nombre"].' '.$datos91["APaterno"].' '.$datos91["AMaterno"]; ?></b>
         </td>
       </tr>
       <tr style="background: #003A70; color: white;">
         <td style="padding: 10px;" colspan="5"><b>MATERIA:</b> <?php echo $datos81["CodeModulo"].' '.$datos81["NombreMod"]; ?></td>
         <td style="padding: 10px;" colspan="2"><b>GRUPO:</b> <?php echo $datos81["CveGrupo"]; ?></td>
       </tr>
       <?php $mi=0; $mf=0; $x = 0; $_px = 0; while($x = $db->recorrer($sqlX)){ $dispo = 1;
         $preg = $x["IdPregunta"];
         $IdModulo = $x["IdModulo"];
         $IdAsig = $x["IdAsignacion"];
         $IdCiclo = $x["IdCiclo"];
         $IdPregunta = $x["IdPregunta"];
         $mi = $x["IdMod"];

         $_px = ($_px + 1);

         $sql2 = $db->query("SELECT tblx_pregunta.IdPregunta, tblx_pregunta.Pregunta, tblxx_respuesta.Texto, tblxx_respuesta.Valor FROM tblx_pregunta Left Join tblxx_respuesta ON tblxx_respuesta.IdPregunta = tblx_pregunta.IdPregunta WHERE tblx_pregunta.IdPregunta =  '$preg' ");
         if($mi <> $mf){ ?>
           <tr style="background: #8f9ebf; color: #001f3f;">
             <td colspan="7"><b><i class="fa fa-fw fa-map-signs"></i> <?php echo $x["Nombre_mod"]; ?></b></td>
           </tr>
         <?php } ?>


         <tr style="background: #e1dede;">
           <td colspan="7"><b><?php echo $_px.'.- '.$x["Pregunta"]; ?></b></td>
         </tr>

         <?php $_spt = 0; $_spr = 0; $_prom = 0;
         while($x2 = $db->recorrer($sql2)){
           $_val = $x2['Valor'];
           $sql_s = $db->query("SELECT tblx_respuesta.IdRespuesta, Count(tblx_respuesta.IdPregunta) AS Total, tblx_respuesta.Respuesta AS Valor FROM tblx_respuesta WHERE tblx_respuesta.IdAsignacion =  '$IdAsig' AND tblx_respuesta.IdPregunta =  '$IdPregunta' AND tblx_respuesta.Respuesta = '$_val' GROUP BY tblx_respuesta.Respuesta");
           $db->rows($sql_s);
           $_sum = $db->recorrer($sql_s);

           ?>

         <tr>
           <td><?php echo $x2["Valor"]; ?> Pts</td>
           <td colspan="4"><?php echo $x2['Texto']; ?></td>
           <td style="text-align: center;"><?php if($_sum['Total']){ echo $_sum['Total']; } else { echo 0;} ?></td>
           <td style="text-align: center;"> (<?php echo $_vSum = ($_sum['Total'] * $_sum['Valor']); ?> ptos)</td>
         </tr>
         <?php $_spt = ($_spt + $_sum['Total']); $_spr = ($_spr + $_vSum);   } ?>
         <?php
            $_prom = ($_spr / $_spt); round($_prom,2);
            $sqlV = $db->query("SELECT tblx_grafica_materia.IdGrafica FROM tblx_grafica_materia WHERE tblx_grafica_materia.IdDocente = '$IdDocente' AND tblx_grafica_materia.IdAsignacion = '$IdAsig' AND tblx_grafica_materia.IdCiclo = '$IdCiclo' AND tblx_grafica_materia.IdPregunta = '$IdPregunta' ");
            $db->rows($sqlV);
            $datos91 = $db->recorrer($sqlV);
            $_idGraf = $datos91['IdGrafica'];
            if(!$_idGraf){
              $sqlV = $db->query("INSERT INTO tblx_grafica_materia (IdAsignacion, IdDocente, IdPregunta, Promedio, IdCiclo) VALUES ('$IdAsig', '$IdDocente', '$IdPregunta', '$_prom', '$IdCiclo') ");
            } else {
              $sqlV = $db->query("UPDATE tblx_grafica_materia SET tblx_grafica_materia.Promedio = '$_prom' WHERE tblx_grafica_materia.IdGrafica = '$_idGraf' ");
            }
           ?>
         <tr>
           <td colspan="5" style="text-align: right;"><b>Promedio:</b></td>
           <td colspan="2" style="text-align: center;"><b style="color: blue;"><?php echo round($_prom,2); ?></b></td>
         </tr>


       <?php $mf = $x["IdMod"]; }  ?>
       </tbody>
</table>
<?php
$sql_preg = $db->query("SELECT tblx_respuesta.IdRespuesta, tblx_respuesta.IdPregunta, tblx_respuesta.Respuesta,tblx_respuesta.Texto, tblx_pregunta.Pregunta, tblx_pregunta._Tipo FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta WHERE tblx_respuesta.IdAsignacion =  '$IdAsignacion' AND tblx_pregunta._Tipo =  '2' ORDER BY tblx_respuesta.IdPregunta ASC "); ?>
<div class="bg-navy color-palette" style="padding: 10px;"><span style="color: yellow;"> <i class="fa fa-fw fa-check-circle"></i> Resultado de las preguntas abiertas</span></div>
<table class="table table-striped" style="font-size: 12px;">
<?php $_i = 0; $_f = 0; while($_preg = $db->recorrer($sql_preg)){ $_i = $_preg["IdPregunta"];
  if($_i <> $_f){
  ?>
  <tr style="background: #b5bbc8;">
    <td><b><?php echo $_preg["Pregunta"]; ?></b></td>
  </tr><?php } ?>
  <tr>
    <td><b><?php echo $_preg["Texto"]; ?></b></td>
  </tr>
<?php $_f = $_preg["IdPregunta"]; } ?>
</table>
<?php if($dispo == 1){

  $sql_prom1 = $db->query("SELECT tblx_grafica_materia.IdPregunta, tblx_grafica_materia.Promedio, tblx_pregunta.Pregunta, tblx_modulo.IdMod, tblx_modulo.Nombre_mod FROM tblx_grafica_materia Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_grafica_materia.IdPregunta Left Join tblx_modulo ON tblx_modulo.IdMod = tblx_pregunta.IdMod WHERE tblx_grafica_materia.IdAsignacion =  '$IdAsignacion' ORDER BY tblx_pregunta.IdMod ASC ");
  ?>
<div id="container_prom" style="width: 100%;"></div>


<table id="datatable_prom" class="table table-striped" style="font-size: 12px;">
  <thead>
    <tr>
      <th>PREGUNTAS DE LA ENCUESTA</th>
      <th style="text-align: center;">PROMEDIO</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $p = 0; $_sxprom = 0; $mxi=0; $mxf=0;
    $prom1 = 0; $prom2 = 0;
    $_sp1 = 0; $_sp2 = 0;
    while($_pro1 = $db->recorrer($sql_prom1)){  $mxi = $_pro1['IdMod'];
      if($mxi == 1){ $prom1 = ($prom1 + $_pro1['Promedio']); $_sp1 = ($_sp1 + 1); }
      if($mxi == 2){ $prom2 = ($prom2 + $_pro1['Promedio']); $_sp2 = ($_sp2 + 1); }

    if($mxi <> $mxf){ ?>
      <tr style="background: #8f9ebf; color: #001f3f;">
        <td colspan="2"><b><i class="fa fa-fw fa-map-signs"></i> <?php echo $_pro1["Nombre_mod"]; ?></b></td>
      </tr>
    <?php } ?>
    <tr>
      <td><?php echo $p = ($p + 1); ?>.- <?php echo $_pro1['Pregunta']; ?></td>
      <td style="text-align: center;"><?php echo number_format($_pro1['Promedio'], 2, '.', ','); ?></td>
    </tr><?php
    $mxf = $_pro1['IdMod']; }
    $promx1 = ($prom1 / $_sp1);
    $promx1 = number_format($promx1, 2, '.', ',');
    $promx2 = ($prom2 / $_sp2);
    $promx2 = number_format($promx2, 2, '.', ',');
     ?>
    <tr style="background: #b5bbc8; color: #001f3f;">
      <td style="text-align: right;"><b><i class="fa fa-fw fa-check-circle"></i> Promedio del docente:</b></td>
      <td style="text-align: center;"><b><?php echo $promx1; ?></b></td>
    </tr>
    <tr style="background: #b5bbc8; color: #001f3f;">
      <td style="text-align: right;"><b><i class="fa fa-fw fa-check-circle"></i> Promedio del personal administrativo:</b></td>
      <td style="text-align: center;"><b><?php echo $promx2; ?></b></td>
    </tr>
  </tbody>
  <?php
  if($promx1){
    $sql_promx = $db->query("SELECT tblx_grafica_prom_materia.IdGrafica_prom FROM tblx_grafica_prom_materia WHERE tblx_grafica_prom_materia.IdDocente = '$IdDocente' AND tblx_grafica_prom_materia.IdAsignacion = '$IdAsig' AND tblx_grafica_prom_materia.IdCiclo = '$IdCiclo' ");
    $db->rows($sql_promx);
    $datos91 = $db->recorrer($sql_promx);
    $_idGrafx = $datos91['IdGrafica_prom'];
    if(!$_idGrafx){
      $sqlV = $db->query("INSERT INTO tblx_grafica_prom_materia (IdAsignacion, IdDocente, Promedio, IdCiclo, Prom_admin) VALUES ('$IdAsig', '$IdDocente', '$promx1', '$IdCiclo', '$promx2') ");
    } else {
      $sqlV = $db->query("UPDATE tblx_grafica_prom_materia SET tblx_grafica_prom_materia.Promedio = '$promx1', tblx_grafica_prom_materia.Prom_admin = '$promx2' WHERE tblx_grafica_prom_materia.IdGrafica_prom = '$_idGrafx' ");
    }
  }
  ?>
</table>

<?php } ?>


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
  text: 'Resultado de la encuesta del docente <br>' + Docente
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
