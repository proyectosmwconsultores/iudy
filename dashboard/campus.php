<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION['IdUsua'];

  $sql_cam = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.id_usua = '$IdUsua'");

  ?>
  <div class="box-body">
    <input type="hidden" name="nom_" id="nom_" value="Mis campus / escuelas">
    <ul class="products-list product-list-in-box">
      <?php while($camp = $db->recorrer($sql_cam)){ ?>
      <li class="item">
        <div class="product-img">
          <?php if($camp['Logo']){ ?>
          <img src="assets/images/logos/<?php echo $camp['Logo']; ?>" alt="Product Image">
          <?php } else { ?>
          <img src="assets/images/logo.png" alt="Product Image">
          <?php } ?>

        </div>
        <div class="product-info">
          <a href="javascript:void(0)" class="product-title"><?php echo $camp['Campus']; ?>
          <span class="product-description">
                Activo
              </span>
        </div>
      </li><?php } ?>
    </ul>
  </div>

  <script>
    $(document).ready(function(){
      var nom_ = document.getElementById("nom_").value;
      document.getElementById('lbl_Pre').innerHTML = nom_;
    });
  </script>
