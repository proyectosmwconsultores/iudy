<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdPago = $_POST["employee_id"];
  $sql9 = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdEducativa,
tblp_asignacion.IdModulo,
tblp_asignacion.Grupo,
tblp_asignacion.IdCiclo,
tblp_educativa.Nombre AS NomEducativa,
tblp_modulo.NombreMod,
tblc_ciclo.Ciclo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_asignacion
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
WHERE
tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND
tblp_asignacion.Tipo =  '4'
");

  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);


  $output .= '
  <table class="table table-condensed">
                <tr>
                  <td style="width: 160px; text-align: right;"><b>Oferta Educativa:</b></td>
                  <td>'.$datos91["NomEducativa"].'</td>
                </tr>
                <tr>
                  <td style="width: 160px; text-align: right;"><b>Asignatura:</b></td>
                  <td>'.$datos91["NombreMod"].'</td>
                </tr>
                <tr>
                  <td style="width: 160px; text-align: right;"><b>Tutor:</b></td>
                  <td>'.$datos91["Nombre"].' '.$datos91["APaterno"].' '.$datos91["AMaterno"].'</td>
                </tr>
                <tr>
                  <td style="width: 160px; text-align: right;"><b>Grupo:</b></td>
                  <td>'.$datos91["Grupo"].'</td>
                </tr>
                <tr>
                  <td style="width: 160px; text-align: right;"><b>Ciclo Escolar:</b></td>
                  <td>'.$datos91["Ciclo"].'</td>
                </tr>
                <tr>
                  <td style="width: 160px; text-align: right;"><b>Lista de alumnos:</b></td>
                  <td><a href="repositorio/pdf/listaAlumnos.php?Id='.$IdAsignacion.'" target="_blank">
                      <button type="button" class="btn btn-block btn-success btn-xs"> <i class="fa fa-fw fa-cloud-download"></i> Descargar </button></td>
                      </a>
                </tr>

              </tbody></table>


  </div>';
  echo $output;
}
?>
