<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["employee_id"];
  $sql9 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdOferta, tblp_educativa.IdGrado FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua =  '$IdUsua'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $rwIdGrado = $datos91["IdGrado"];

  if(isset($_POST["Mov"]) && $_POST["Mov"]=="addSolicitud"){
    $espacio->add_comPago();
    exit;
  }

  $Hoy = date("Y-m-d");
  $dia = date("d");
  $mes = date("m");
  $anio = date("Y");
  $dia = $dia  + 13;

  if($dia > 30){
     $dia = $dia - 30;
    $mes = $mes + 1;
    if($dia < 10) { $dia = '0'.$dia; } else { $dia = $dia; }
    if($mes < 10) { $mes = '0'.$mes; } else { $mes = $mes; }
  }
  if($mes > 12){
    $mes = "01";
    $anio = $anio + 1;
  }

$fecha = $anio.'-'.$mes.'-'.$dia;

  $sql8 = $db->query("SELECT tblc_conceptos.IdConcepto, tblc_conceptos.NomConcepto, tblc_conceptos.Grado$rwIdGrado FROM tblc_conceptos WHERE tblc_conceptos.Grado$rwIdGrado IS NOT NULL AND tblc_conceptos.Solicitud = '3' ");
  $output .= '
  <form class="form-horizontal" name="frm" id="frm" action="viewDocumento.php" method="POST" enctype="multipart/form-data">
  <input id="IdUsua" name="IdUsua" value="'.$IdUsua.'" type="hidden"/>
    <input id="FechaLim" name="FechaLim" value="'.$fecha.'" type="hidden"/>
  <table class="table table-condensed">
                <tr>
                  <td style="width: 160px; text-align: right;"><b>Seleccione concepto:</b></td>
                  <td>
                  <select class="form-control" name="txtConcepto" id="txtConcepto">
                    <option value=""> - Seleccione - </option>
                    ';
                    while($x = $db->recorrer($sql8)){
                      $IdConcepto = $x["IdConcepto"];
                      $Descripcion = $x["NomConcepto"];
                      $Precio = $x[2];
                      $output .= '
                        <option class="form-control"  value="'.$IdConcepto.'" >$ '.$Precio.'.00 / '.$Descripcion.' </option> ';
                     }
                    $output .= '
                  </select>
                  </td>
                </tr>
                <tr>
                  <td style="width: 160px; text-align: right;"><b>Fecha l&iacute;mite de pago:</b></td>
                  <td>
                      <input type="text" class="form-control" disabled value="'.$fecha.'" >
                  </td>
                </tr>

                <tr>
                  <td colspan="2"  style=" text-align: right;"><b style="color: red;">Nota: al solicitar este documento usted tiene 10 d&iacute;as como m&aacute;ximo para realizar este pago.</b></td>

                </tr>
                <tr>
                  <td style="width: 160px; text-align: right;"></td>
                  <td>
                      <button type="button" class="btn btn-block btn-info btn-xs" onClick="val_solDocumento()"> <i class="fa fa-fw fa-file"></i> Generar comprobante de pago </button></td>

                </tr>

              </tbody></table>
</form>

  </div>';
  echo $output;
}
?>
