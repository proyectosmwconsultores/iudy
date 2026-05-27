<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];
  $miUsua = $_SESSION['IdUsua'];

  $sql2 = $db->query("SELECT
tblp_buzon.IdBuzon,
tblp_buzon.IdUsuaEnvia,
tblp_buzon.IdUsuaRecibe,
tblp_buzon.FecCap,
tblp_buzon.Visto,
tblc_usuario.Nombre AS ENombre,
tblc_usuario.APaterno AS EPaterno,
tblc_usuario.AMaterno AS EMaterno,
tblc_usuario.Cargo AS ECargo,
tblc_usuario.Foto AS EFoto,
RUsuario.Nombre AS RNombre,
RUsuario.APaterno AS RPaterno,
RUsuario.AMaterno AS RMaterno,
RUsuario.Cargo AS RCargo,
RUsuario.Foto AS RFoto
FROM
tblp_buzon
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_buzon.IdUsuaEnvia
Left Join tblc_usuario AS RUsuario ON RUsuario.IdUsua = tblp_buzon.IdUsuaRecibe
WHERE ((tblp_buzon.IdUsuaEnvia = '$IdUsua') || (tblp_buzon.IdUsuaRecibe = '$IdUsua'))
GROUP BY
tblp_buzon.IdUnico
ORDER BY
tblp_buzon.Visto DESC ");

  ?>


    <?php $cb = 0; $msjx = 0; while($x = $db->recorrer($sql2)){ $msjx = 1;  $cb = $cb + 1;
      if($IdUsua == $x['IdUsuaRecibe']){ //echo 'responde-'.$cb;
      ?>
      <li class="item" onclick="cargarComen(<?php echo $x['IdUsuaRecibe']; ?>,<?php echo $x['IdUsuaEnvia']; ?>)" style="cursor: pointer;">
        <div class="product-img">
          <img style="border-radius: 25px;" src="assets/perfil/<?php echo $x['EFoto']; ?>" alt="Foto">
        </div>
        <div class="product-info">
          <a href="javascript:void(0)" class="product-title"><?php echo $x['ENombre'].' '.$x['EPaterno'].' '.$x['EMaterno']; ?>
            </a>
          <span class="product-description">
            <?php if($x['Visto'] == 1){ ?>
            <i style="color: blue;" class="fa fa-fw fa-circle"></i>
            <?php } ?>
                <?php echo $x['ECargo']; ?>
                <span class="label label-info pull-right"><?php echo $x['FecCap']; ?></span>
              </span>
        </div>
      </li>

    <?php } elseif($IdUsua == $x['IdUsuaEnvia']) { ?>
      <li class="item" onclick="cargarComen(<?php echo $x['IdUsuaEnvia']; ?>,<?php echo $x['IdUsuaRecibe']; ?>)" style="cursor: pointer;">
        <div class="product-img">
          <img style="border-radius: 25px;" src="assets/perfil/<?php echo $x['RFoto']; ?>" alt="Foto">
        </div>
        <div class="product-info">
          <a href="javascript:void(0)" class="product-title"><?php echo $x['RNombre'].' '.$x['RPaterno'].' '.$x['RMaterno']; ?>
            </a>
          <span class="product-description">

                <?php echo $x['RCargo']; ?>
                <span class="label label-info pull-right"><?php echo $x['FecCap']; ?></span>
              </span>
        </div>
      </li>
    <?php } } ?>

    <?php if($msjx == 0){ ?>
      <br><br>
      <img src="assets/images/recientes.jpg" style="width: 100%;">
      <p style="text-align: center;">No hay mensajes recientes.</p>
    <?php } ?>
