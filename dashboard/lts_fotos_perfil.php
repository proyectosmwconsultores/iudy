<?php
  require('../php/clases/class.php');
  $t=new Trabajo();

  $sql_mat=$t->get_foto_perfil();

  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Fotos de perfil que deben ser validados</h3>
  </div>

  <div class="box-body">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th style="width: 10px;"></th>
          <th>FOTO ACTUAL</th>
          <th>FOTO NUEVA</th>
          <th>NOMBRE DEL USUARIO</th>
          <th>CARGO</th>
        </tr>
        <?php $_a = 0;
        for ($i=0;$i< sizeof($sql_mat);$i++) { ?>
        <tr>
          <td><b><?php echo $_a = ($_a + 1); ?>.- </b></td>
          <td style="width: 120px;">
            <div class="product-img">
              <img class="img-circle" style="width: 50px;" src="assets/perfil/<?php echo $sql_mat[$i]['Foto']; ?>" alt="Product Image">
            </div>
          </td>
          <td style="width: 120px;">
            <div class="product-img">
              <!-- <img onclick="ver_foto_perfil(<?php echo $sql_mat[$i]['IdUsua']; ?>)" class="img-circle" style="width: 50px; cursor: pointer;" src="assets/perfil/<?php echo $sql_mat[$i]['Estado']; ?>" alt="Product Image"> -->
            </div>
          </td>
          <td><?php echo $sql_mat[$i]['APaterno'].' '.$sql_mat[$i]['AMaterno'].' '.$sql_mat[$i]['Nombre']; ?></td>
          <td><?php echo $sql_mat[$i]['Cargo']; ?></td>
        </tr>
        <?php }  ?>
   </tbody></table>
 </div>
