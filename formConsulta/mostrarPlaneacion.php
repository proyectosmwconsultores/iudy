<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdOferta = $_POST["IdOferta"];
  $Grado = $_POST["Grado"];
  $mod = $_POST["Modalidad"];
  if($mod == "S"){ $txtM = "Semestre"; } else { $txtM = "Cuatrimestre"; }
    $sql = $db->query("SELECT
tblp_libro.IdLibro,
tblp_libro.Nombre,
tblp_libro.Link,
tblp_libro.IdTema,
tblp_libro.Oferta,
tblp_libro.Code,
tblp_libro.IdGrado,
tblp_libro.Tipo
FROM
tblp_libro
WHERE tblp_libro.IdOferta = '$IdOferta' AND tblp_libro.Grado = '$Grado' AND tblp_libro.IdTema = '10' ORDER BY tblp_libro.Code ASC");


  ?>
  <div class="bg-red-active color-palette" style="padding: 10px;"><span><?php echo $Grado; ?>° <?php echo $txtM; ?></span> - <span>Mis planeaciones UDS</span></div>
  <ul class="mailbox-attachments clearfix">
    <?php while($x = $db->recorrer($sql)){
      $lib = '../assets/images/modulo/'.$x["IdGrado"].'/'.$x["IdTema"].'/'.$x["Tipo"].'/'.$x["Oferta"].$x["Code"].'.png';
      if (file_exists($lib)) { $img = $x["Oferta"].$x["Code"].'.png'; } else {  $img = 'MODULO.png'; }
      ?>
    <!-- <li onClick="window.open('assets/docs/libro/<?php echo $x["Oferta"]; ?>/<?php echo $x["Link"]; ?>','_blank')" href="javascript:void(0);" style="cursor: pointer;">
      <span class="mailbox-attachment-icon has-img"><img style="width: 185px; " src="assets/images/modulo/<?php echo $x["IdGrado"]; ?>/<?php echo $img; ?>" alt="Attachment"></span>
    </li> -->
    <li onclick="mostrarLib(<?php echo$x["IdLibro"]; ?>)" href="javascript:void(0);" style="cursor: pointer;">
      <span class="mailbox-attachment-icon has-img"><img style="height: 180px; " src="assets/images/modulo/<?php echo $x["IdGrado"]; ?>/<?php echo $x["IdTema"]; ?>/<?php echo $x["Tipo"]; ?>/<?php echo $img; ?>" alt="Attachment"></span>
    </li>
    <?php } ?>
  </ul>
