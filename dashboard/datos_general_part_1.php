<?php
  require('../php/clases/consulta_class.php');
  $t=new Consultas();
  $total = $t->get_sum_alumnos();
  $_nivel = $t->get_sum_alumnos_nivel();
  $sum = 0;
  for ($i=0;$i< sizeof($total);$i++) {
    $sum = ($sum + $total[$i]['Total']);
  }
  $por = (100 / $sum);
  ?>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-aqua">
      <span class="info-box-icon"><i class="fa fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">&nbsp;</span>
        <span class="info-box-number"><?php echo $sum; ?> alumnos</span>
        <div class="progress">
          <div class="progress-bar" style="width: 100%"></div>
        </div>
        <span class="progress-description">
        Alumnos activos
        </span>
      </div>
    </div>
  </div>
  <?php for ($i=0;$i< sizeof($total);$i++) {
    $_porx = ($por * $total[$i]['Total']);
    $_resul = round($_porx, 2); ?>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-red">
      <span class="info-box-icon"><i class="fa fa-user"></i></span>
      <div class="info-box-content">
        <span class="info-box-text"><?php echo $total[$i]['Descripcion']; ?></span>
        <span class="info-box-number"><?php echo $total[$i]['Total']; ?> alumnos</span>
        <div class="progress">
          <div class="progress-bar" style="width: <?php echo $_resul; ?>%"></div>
        </div>
        <span class="progress-description">
        Representa el <?php echo $_resul; ?>%
        </span>
      </div>
    </div>
  </div>
<?php } ?>
