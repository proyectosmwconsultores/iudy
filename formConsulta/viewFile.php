<?php
include('../hace.php');
if(isset($_POST["IdTarea"])){
  $LinkU = $_POST["Ubicacion"];
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

// echo "SELECT * FROM tblp_tareas WHERE tblp_tareas.IdTarea = '".$_POST["IdTarea"]."'";

  $sql9 = $db->query("SELECT * FROM tblp_tareas WHERE tblp_tareas.IdTarea = '".$_POST["IdTarea"]."'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $link = $datos91["$LinkU"];
  $IdAsignacion = $datos91["IdAsignacion"];

  $sql3 = $db->query("SELECT tblp_asignacion.Anio, tblp_asignacion.server, tblp_asignacion.Mes FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion ='$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
  $db->rows($sql3);
  $datos31 = $db->recorrer($sql3);
  $AAnio = $datos31["Anio"];
  $MMes = $datos31["Mes"];
  echo $server = $datos31["server"];


  if($LinkU == "Link"){
    // $Comentario = $datos91["Comen1"];
    $Fecha = $datos91["Fec1"];
  }
  if($LinkU == "Link2"){
      // $Comentario = $datos91["Comen2"];
      $Fecha = $datos91["Fec2"];
  }
  if($LinkU == "Link3"){
      // $Comentario = $datos91["Comen3"];
      $Fecha = $datos91["Fec3"];
  }

  $porciones = explode(".", $link);
  $lik =  $porciones[1]; // porción2
  //
  // $video = explode("=", $link);
  // $likViINi =  $video[0]; // porción2
  // $likVideo =  $video[1]; // porción2
  //
  // $varlor = 0;
  //
  // if($likViINi == "https://www.youtube.com/watch?v"){
  //   $varlor = 3;
  // } else {
  //
  //    $leer = substr($likViINi, 0,5);
  //   if($leer == "https"){
  //     $varlor = 4;
  //   }
  // }


//https://fileservice.s3mwc.com/storage/sciudy/biblioteca/2025/04/thk1VcHaHnqBAwxR6xAh-ACTIVIDAD_1_1.docx

if($server == 0){
    $ubicacion = "https://fileservice.s3mwc.com/storage/sciudy/";
} else {
    $ubicacion = "";
}

$farchivo = $ubicacion."assets/trabajos/$AAnio/$MMes/$IdAsignacion/tareas/$link";

if($lik == "pdf"){ $varlor = 1;
  $fii = $ubicacion."assets/trabajos/$AAnio/$MMes/$IdAsignacion/tareas/$link";
}

if(($lik == "jpg") || ($lik == "jpeg") || ($lik == "png") || ($lik == "gif")){ $varlor = 2;
  $fii = $ubicacion."assets/trabajos/$AAnio/$MMes/$IdAsignacion/tareas/$link";
}

if($Fecha){
  echo "<b style='font-size: 15px; color: blue;'>Fecha en que subió el archivo el alumno: ".$Fecha."</b><br>";
}

if($varlor == 1){

   ?>



   <button type="button" onClick="window.open('<?php echo $fii; ?>','_blank')" href="javascript:void(0);" class="btn btn-block btn-danger btn-sm"><b style="color: black;">Abrir archivo en nueva pestaña</b></button>
  <br>
  <embed id="pdfdoc" src="<?php echo $fii; ?>" width="100%" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">

<?php }



if($varlor == 2){ ?>
  <!-- <b>Comentario:</b><br><?php echo $Comentario; ?> <br> -->
<img src="<?php echo $fii; ?>" width="100%">
<?php }
if($varlor == 3){  ?>

  <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?php echo $likVideo;  ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<?php }
if($varlor == 4){  ?> <br><br><br><br>
 <button type="button" onClick="window.open('<?php echo $link; ?>','_blank')" href="javascript:void(0);" class="btn btn-block btn-danger btn-sm"><b style="color: black;"> Abrir enlace en nueva pestaña</b></button>
 <br><br><br><br>
<?php  }
if($varlor == 0){  ?> <br><br><br><br>
 <button type="button" onClick="window.open('<?php echo $farchivo; ?>','_blank')" href="javascript:void(0);" class="btn btn-block btn-danger btn-sm"><b style="color: black;"> Abrir archivo en nueva pestaña</b></button>
 <br><br><br><br>
<?php  } ?>

<?php } ?>
