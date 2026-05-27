<?php

if(isset($_POST["employee_id"])){
$id = $_POST["employee_id"];

if($id == 101){
  $texto1 = "Crear planeación académica";
}
if($id == 102){
  $texto1 = "Crear actividad y rúbrica";
}
if($id == 103){
  $texto1 = "Configuración de examen";
}
if($id == 104){
  $texto1 = "Generar acta de calificación";
}
  ?>
  <div class="modal-header" style="background: #1d3462; color: white; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title"><?php echo $texto1; ?></h4>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <video controls src="assets/videos/<?php echo $id; ?>.mp4" width="100%">
          <source src="assets/videos/<?php echo $id; ?>.mp4" type="video/mp4">
          <img src="imagen.png" alt="Video no soportado">
          Su navegador no soporta contenido multimedia.
        </video>
      </div>
    </table>
  </div>
<?php
}
?>
