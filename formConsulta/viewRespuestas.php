<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $valor = $_POST["Valor"];
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $sql = $db->query("SELECT * FROM tblp_respuestaexamen WHERE tblp_respuestaexamen.IdExamen = '".$_POST["employee_id"]."'");

  $output .= '
  <div class="table-responsive">
    <div class="box" style="border-top: none;">
          <div class="box-body">
            <table class="table table-bordered">
              <tbody><tr>
                <th>#</th>
                <th>Respuesta</th>
                <th>R. Correcta</th>
                <th style="text-align: center;">Opción</th>
              </tr>'; $s = 0;
              while($x = $db->recorrer($sql)){ $s= $s +1;
              $output .= '
              <tr id='.$x["IdRespuesta"].'>
                <td>'.$s.'</td>
                <td>'.$x["Respuesta"].'</td>
                <td>'.$x["Valor"].'</td>
                <td style="text-align: center;">
                  <button type="button" class="btn btn-primary" onClick="val_eliminarRes('.$x["IdRespuesta"].','.$valor.')" name="add" value="add" id="4" style="text-align: center;" data-toggle="tooltip" data-placement="top" title="Eliminar respuestas"><i class="fa fa-fw fa-trash"></i> </button>
                </td>
              </tr>';
                }
            $output .= '
            </tbody></table>
          </div>
        </div>
  </div>';
  echo $output;
}
?>
