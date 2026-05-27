<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../../php/clases/class.System.php');
require('../../hace.php');
$db = new Conexion();
$IdAsignacion = $_POST['IdAsignacion'];
$IdActividad = $_POST['IdActividad'];

$sql_lsta = $db->query("SELECT tblp_tareas.IdTarea, tblc_usuario.Foto, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_tareas.Link, tblp_tareas.Link2, tblp_tareas.Link3, tblp_tareas.FecCap, tblp_tareas.Calificacion FROM tblp_tareas Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_tareas.IdAlumno WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' AND tblp_tareas.IdActividadesDocente =  '$IdActividad' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC ");

?>
<div class="box-body">
  <ul class="products-list product-list-in-box">
    <?php $t = 0;
    $col = '';
    while ($lst = $db->recorrer($sql_lsta)) {
      if ((isset($lst['Link'])) || (isset($lst['Link2'])) || (isset($lst['Link']))) {
        $t = 1;
      } else {
        $t = 0;
      }

    ?>
      <li class="item">
        <div class="product-img">
          <img src="assets/perfil/<?php echo $lst['Foto']; ?>" alt="Product Image">
        </div>
        <div class="product-info">
          <a href="javascript:void(0)" class="product-title"><?php echo $lst['APaterno'] . ' ' . $lst['AMaterno'] . ' ' . $lst['Nombre']; ?>
            <span class="label label-success pull-right"><?php if ($t == 1) { ?> <i class="fa fa-fw fa-check-circle"></i> Tarea subida <?php } ?></span></a>
          <span class="product-description">
            <?php if ($t == 0) { ?>
              <b style='color: red;'>No subio archivo.</b>
            <?php } ?>
            <?php if (isset($lst['Calificacion'])) { ?>
              <b style='color: blue;'> Tarea calificada: <?php echo $lst['Calificacion']; ?></b>
            <?php } ?>
          </span>
        </div>
      </li>
    <?php } ?>
  </ul>
</div>