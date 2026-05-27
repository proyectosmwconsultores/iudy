<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdAsignacion = $_POST["IdAsignacion"];

$sql = $db->query("SELECT
tblp_moduloalumno.IdUsua,
tblp_moduloalumno.Extra1,
tblp_moduloalumno.Extra2,
tblp_moduloalumno.Cal,
tblp_moduloalumno.CalExtra1,
tblp_moduloalumno.CalExtra2,
tblp_moduloalumno.Recursar,
tblp_moduloalumno.CalFinal,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_moduloalumno
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' ");


  ?>
  <form name="frm2" id="frm2" action="vievCalificacion.php" method="POST" enctype="multipart/form-data">
    <div class="box-body no-padding">
                  <table class="table table-striped">
                    <tbody><tr>
                      <th style="width: 10px">#</th>
                      <th>Nombre</th>
                      <th style="text-align: center;">Calificaci&oacute;n</th>
                    </tr>
                    <?php while($x = $db->recorrer($sql)){
                      $extra2 = $x["CalExtra2"];
                      $extra1 = $x["CalExtra1"];
                      $normal = $x["CalFinal"];

                      if($extra2){ $cal = $x["CalExtra2"]; $txt = "*E"; if($extra2 < 70) { $txt = "*R";} }
                      elseif($extra1){ $cal = $x["CalExtra1"]; $txt = "*ET"; }
                      elseif($normal){ $cal = $x["CalFinal"]; $txt = ""; }


                      ?>
                    <tr>
                      <td><?php echo $c = $c + 1; ?></td>
                      <td><?php echo $x["APaterno"].' '.$x["AMaterno"].' '.$x["Nombre"]; ?></td>
                      <td style="text-align: center;"><?php echo round($cal,0); ?> <b style="color: red;"><?php echo $txt; ?></b></td>
                    </tr>
                  <?php } ?>
                </tbody></table><hr>
                  <b style="color: red;">*E: </b> Extraordinario
                  <b style="color: red;">*T: </b> Título de suficiencia
                  <b style="color: red;">*R: </b> Reprobado
                </div>



  </form>
