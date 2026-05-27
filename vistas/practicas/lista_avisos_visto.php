<?php
session_start();
require('../../php/clases/class_practicas.php');
require('../../hace.php');
$practicas = new Class_practicas();
$IdAviso = $_POST['IdAviso'];
$lst = $practicas->obtener_lista_avisos($IdAviso);

?>

<form name="frm2xfYj" id="frm2xfYj" action="capturar_gastos.php" method="POST" enctype="multipart/form-data">

  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th style="width: 10px"></th>
        <th>Matricula</th>
        <th>Nombre</th>
        <th>Fecha visto</th>
      </tr>
      <?php $sv = 0; $sa = 0; $v = 0; $oi = 0; $of = 0; $ci = 0; $cf = 0;
      for ($i=0;$i< sizeof($lst);$i++) { 
        $ci = $lst[$i]['IdCampus'];
        $oi = $lst[$i]['IdOferta'];
          if($lst[$i]['Fec_visto']){ $sv = ($sv + 1); }
          if($ci <> $cf){ ?>
            <tr style="background: #1d3462; color: white;">
              <td colspan="5"><i class="fa fa-fw fa-bank"></i> <?php echo $lst[$i]['Campus']; ?></td>
            </tr>
            <?php $of = 0; }
            
        if($oi <> $of){ ?>
        <tr style="background: #d8ccff;">
          <td colspan="5"><i class="fa fa-fw fa-book"></i> <?php echo $lst[$i]['Educativa']; ?></td>
        </tr>
        <?php }
        ?>
      <tr>
        <td><b><?php  echo $v = ($v + 1); ?>.-</b></td>
        <td><?php echo $lst[$i]['Usuario']; ?></td>
        <td><?php echo $lst[$i]['APaterno'].' '.$lst[$i]['AMaterno'].' '.$lst[$i]['Nombre']; ?></td>
        <td><?php echo $lst[$i]['Fec_visto']; ?></td>
      </tr>
      <?php $of = $lst[$i]['IdOferta']; $cf = $lst[$i]['IdCampus']; } ?>

      <tr>
        <td colspan="4" style="text-align: right;"><b>Total alumnos que ya vieron el aviso:</b></td>
        <td><?php echo $sv; ?></td>
      </tr>
    </tbody>
  </table>

</form>