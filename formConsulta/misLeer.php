<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];
  $miUsua = $_SESSION['IdUsua'];

  $_sql2 = $db->query("SELECT
tblp_buzon.IdBuzon,
tblp_buzon.IdUsua,
tblp_buzon.Mensaje,
tblp_buzon.FecCap,
tblp_buzon.IdUnico,
tblp_buzon.IdUsuaEnvia,
tblp_buzon.IdUsuaRecibe,
tblp_buzon.Archivo,
tblp_buzon.Visto,
tblp_buzon.FecUltimo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Cargo,
tblc_usuario.Foto
FROM
tblp_buzon
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_buzon.IdUsua
WHERE tblp_buzon.IdUsuaRecibe =  '$miUsua' AND tblp_buzon.Visto =  '1'
GROUP BY
tblp_buzon.IdUsua
ORDER BY
tblp_buzon.FecCap ASC
 ");

  ?>


    <?php $cb = 0; $_msjx = 0; while($u = $db->recorrer($_sql2)){ $_msjx = 1;  $cb = $cb + 1;

      ?>
      <li class="item" onclick="cargarComen(<?php echo $u['IdUsuaRecibe']; ?>,<?php echo $u['IdUsuaEnvia']; ?>)" style="cursor: pointer;">
        <div class="product-img">
          <img style="border-radius: 25px;" src="assets/perfil/<?php echo $u['Foto']; ?>" alt="Foto">
        </div>
        <div class="product-info">
          <a href="javascript:void(0)" class="product-title"><?php echo $u['Nombre'].' '.$u['APaterno'].' '.$u['AMaterno']; ?>
            </a>
          <span class="product-description">
            <?php if($u['Visto'] == 1){ ?>
            <i style="color: blue;" class="fa fa-fw fa-circle"></i>
            <?php } ?>
                <?php echo $u['Cargo']; ?>
                <span class="label label-info pull-right"><?php echo $u['FecCap']; ?></span>
              </span>
        </div>
      </li>

    <?php } ?>

    <?php if($_msjx == 0){ ?>
      <br>
      <p style="text-align: center; background: #777070; padding: 5px; border-radius: 16px; color: white;">No hay mensajes sin leer.</p>
    <?php } ?>
