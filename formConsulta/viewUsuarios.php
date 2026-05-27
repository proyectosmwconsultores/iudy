<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $Id = $_POST["employee_id"];


  $porciones = explode("-", $Id);
  $IdModulo =  $porciones[0]; // porción1
  $IdAsignacion =  $porciones[1]; // porción1
  $sql = $db->query("SELECT
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Cargo,
tblc_campus.Campus,
tblp_moduloalumno.IdModulo
FROM
tblp_moduloalumno
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdModulo = '$IdModulo'");

  ?>
  <form name="frm5Vb" id="frm5Vb" action="configCurso.php" method="POST" enctype="multipart/form-data">

    <input id="IdModulo" name="IdModulo" value="<?php echo $_POST["IdModulo"]; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAs; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="savCursodat" type="hidden"/>
    <input id="IdUsuaXX" name="IdUsuaXX" value="<?php echo $IdUsua; ?>" type="hidden"/>

    <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Tipo usuario</th>
                    <th>Campus</th>
                  </tr>
                  <?php  while($x = $db->recorrer($sql)){  ?>
                  <tr>
                    <td><?php echo $i = $i + 1; ?></td>
                    <td><?php echo $x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"];?></td>
                    <td><?php echo $x["Cargo"];?></td>
                    <td><?php echo $x["Campus"];?></td>
                  </tr><?php } ?>

                </tbody></table>
              </div>

  </form>
