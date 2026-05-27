<?php
if(isset($_POST["employee_id"])){

  $IdCalificacion = $_POST["employee_id"];
  $IdUsua = $_POST["IdUsua"];
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $output .= '
  <form name="fdrm" id="fdrm" action="modCalificacion.php" method="POST" enctype="multipart/form-data">
  <input id="IdCalificacion" name="IdCalificacion" value="'.$IdCalificacion.'" type="hidden"/>
  <input id="IdUsua" name="IdUsua" value="'.$IdUsua.'" type="hidden"/>
    <div class="box-body no-padding">
        <table class="table table-striped">
          <tbody>
          <tr>
            <td style="text-align: right;"><b>Nueva Calificación:</b></td>
            <td><input class="form-control" id="txtCalificacion" name="txtCalificacion" type="text" onchange="val_numeross(this,txtCalificacion)"></td>
          </tr>
          <tr>
            <td><b>Contraseña:</b> Administrador</td>
            <td><b>Contraseña:</b> Académico</td>
          </tr>
          <tr>
            <td><input class="form-control" id="txtPass1" name="txtPass1" type="password"></td>
            <td><input class="form-control" id="txtPass2" name="txtPass2" type="password"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="box-footer">
      <button type="button" class="btn btn-info pull-right" onClick="val_modCalifi()">Actualizar Calificaci&oacute;n</button>
    </div>
  </form>';
  echo $output;
}
?>
