<?php
ob_start();
require('class.System.php');


class Registro {


  public function get_mis_pagos($IdUsua) {
    $db = new Conexion();
    $gPagosId = [];

    $sql = $db->query("SELECT tblc_conceptosplanes.NomPlan, tblc_estatus.Estatus, tblp_pagos.IdModulo, tblp_pagos.Facturar, tblp_pagos.IdPago, tblp_pagos.FecBase, tblh_detallepagos.Archivo, tblh_detallepagos.Estatus AS EstatusPago FROM tblp_pagos Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus Left Join tblh_detallepagos ON tblh_detallepagos.IdUsua = tblp_pagos.IdUsua AND tblh_detallepagos.IdPago = tblp_pagos.IdPago WHERE tblp_pagos.TipoSolicitud = '2' AND tblp_pagos.IdUsua = '$IdUsua'  AND tblp_pagos.IdEstatus <> '4'");
    while($x = $db->recorrer($sql)){
      $gPagosId[] = $x;
    }
    return $gPagosId;
  }

  public function add_com_pago(){
    $Id = $_POST["IdPago"];
    $Idx = "CPAGO-".$_POST["IdUsua"]."-".$Id."-";
    $variable = "txtPago-".$Id;
    $carpeta = "assets/docs/Pagos/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
		$archivo = $_FILES[$variable]['name']; //nombre del archivo
		$tamaño = $_FILES[$variable]['size']; //tamaño del archivo
		$nombreImg = explode(".", $archivo);
    $code = md5(rand() * time());
    $archivo = $code .'-'.$Idx.$archivo;

		if(!move_uploaded_file($_FILES[$variable]['tmp_name'], $carpeta.$archivo)){
      $_SESSION['Alerta']="0";
      echo "<script type='text/javascript'>window.location='registroDoc.php';</script>";
      exit();
    }
    $db = new Conexion();
    $sql9 = $db->query("SELECT * FROM tblh_detallepagos WHERE tblh_detallepagos.IdPago = '$Id'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdDetallePag = $datos91["IdDetallePagos"];
    if($IdDetallePag){
      $insertar = $db->query("DELETE FROM tblh_detallepagos WHERE tblh_detallepagos.IdPago = '$Id'");
    }
    $insertar = $db->query("INSERT INTO tblh_detallepagos (IdUsua, IdPago, Archivo, FecCap, Estatus, Visto) VALUES('".$_POST["IdUsua"]."', '$Id','$archivo',NOW(),'2','1')");
    if($insertar){
      // $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '2', tblp_pagos.Capturado = '2' WHERE tblp_pagos.IdPago = '$Id'");
    }

    $sql4 = $db->query("SELECT tblp_docs_solicitados.IdDocumento FROM tblp_docs_solicitados WHERE tblp_docs_solicitados.IdPago =  '$Id' ");
    $db->rows($sql4);
    $datos41 = $db->recorrer($sql4);
    $IdDocss = $datos41["IdDocumento"];

    if($IdDocss){
      $insertar = $db->query("UPDATE tblp_docs_solicitados SET tblp_docs_solicitados.IdVisto = '0', tblp_docs_solicitados.IdEstatus = '3', tblp_docs_solicitados.FecSubida = NOW(), tblp_docs_solicitados.Archivo = '$archivo'  WHERE tblp_docs_solicitados.IdDocumento = '$IdDocss'");
    }
		if ($insertar) {


      $_SESSION['Alerta']="1";
			echo "<script type='text/javascript'>window.location='registroDoc.php';</script>";
		} else {
      $_SESSION['Alerta']="0";
			echo "<script type='text/javascript'>window.location='registroDoc.php';</script>";
		}
  }

  public function env_correo_codigo($correo){
    $db = new Conexion();
    $sql1 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Permisos = '3'AND Correo = '$correo'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $code = $datos2["Code"];
    $fol = $datos2["Folio"];
    $nombre = $datos2["Nombre"];
    $correo = $datos2["Correo"];
    $IdEduca = $datos2["IdOferta"];
    $idCam = $datos2["IdCampus"];

    $destinatario = $datos2["Correo"];
    $Nombre = $datos2["Nombre"].' '.$datos2["APaterno"].' '.$datos2["AMaterno"];

    $sql2 = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdEduca'");
    $db->rows($sql2);
    $datos3 = $db->recorrer($sql2);
    $OfertaEduca = $datos3["Nombre"];

    $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
    $db->rows($sql_camp);
    $_camp = $db->recorrer($sql_camp);
    $url = $_camp["Link"];
    $Institucion = $_camp["Campus"];


    $nombre = htmlentities($Nombre.' '.$Paterno.' '.$Materno);


    $asunto = 'Registro en la Plataforma ENAPROC';
    $sub_titulo = "Datos de acceso a la Plataforma";
    $nom_plataforma = "Plataforma ENAPROC";
    $link="https://escuelanacionalpcchiapas.mx/continuar.php";

    $cuerpo = "<table style='border-collapse:collapse;height:100%;margin:0;padding:0;width:100%;background-color:#f2f4fc' width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
        <tbody><tr>
            <td style='height:100%;margin:0;padding:10px;width:100%;border-top:0' valign='top' align='center'>
                <table style='border-collapse:collapse;border:0;max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0'>
                    <tbody><tr>
                        <td style='background:#000f33; color:#fff; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; padding:10px' valign='top'>$sub_titulo</td>
                    </tr>
                    <tr>
                        <td style='background:#ffffff;' valign='top'>
                        <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                            <tbody>
                                <tr>
                                    <td style='padding-top:9px' valign='top'>
                                        <table style='max-width:100%;min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                            <tbody>
                                              <tr>
                                                  <td style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;word-break:break-word;color:black; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size:12px;line-height:150%;text-align:left;' valign='top'>
                                                      <div>
                                                        <b>NOMBRE: </b> $nombre <br></br>
                                                        Estimado alumno(a) puede ingresar a la $nom_plataforma con el siguiente folio para subir sus documentos, que se le solicita para su proceso de Inscripci&oacute;n<br><br>

                                                        <b style='color: blue; font-size: 14px;'>Folio: </b> <b style='color: red; font-size: 14px;'> $fol </b><br>
                                                        </div>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td style='font-size:12px; line-height:17px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-weight:600; ' height='80' align='center'>
                                                    <a href='$link' style='color:inherit;text-decoration:none;text-align:center;display:inline-block; background: #525fff; border-radius: 25px; padding: 8px; color: white;' target='_blank'> &nbsp;&nbsp;&nbsp;&nbsp; Subir mis documentos &nbsp;&nbsp;&nbsp;&nbsp; </a>
                                                  </td>
                                              </tr>

                                              <tr>
                                                  <td style='background: #d5d3d0; padding-top:5px; padding-right:18px; padding-bottom:5px;padding-left:18px;word-break:break-word;color:black; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size:12px;line-height:150%;text-align:center' valign='top'>
                                                      <div>Todos los derechos reservados<br><b>$nom_plataforma</b></div>
                                                  </td>
                                              </tr>

                                        </tbody></table>
                                    </td>
                                </tr>
                            </tbody>
                        </table></td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody></table>";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "From: $nom_plataforma <info@mwcomenius.com.mx>\r\n";
    $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

    mail($destinatario,$asunto,$cuerpo,$headers);


		if ($OfertaEduca) {
      header("Location: continuar.php?x=3");
		} else {
      header("Location: continuar.php");
		}
  }




  # OBTENER CONFIGURACIÓN
  public function get_configuracionPri() {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_configuracion");
    while($x = $db->recorrer($sql)){
      $gConfigt[] = $x;
    }
    return $gConfigt;
  }

  # OBTENER OFERTA EDUCATIVA (ACTIVA)
  public function get_OfertaEduc() {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.Modalidad = '1' ORDER BY tblp_educativa.IdGrado ASC, tblp_educativa.Nombre ASC ");
    while($x = $db->recorrer($sql)){
      $gOfertaE[] = $x;
    }
    return $gOfertaE;
  }

  public function get_usuariosLST($Folio) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Folio='$Folio'");
    while($x = $db->recorrer($sql)){
      $gUsuariosLt[] = $x;
    }
    return $gUsuariosLt;
  }


  # OBTENER INFORMACION DE REGISTRO
  public function get_usuarioCode($Code) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE Code ='$Code'");
    while($x = $db->recorrer($sql)){
      $gUserCode[] = $x;
    }
    return $gUserCode;
  }

}

class Password {
    const SALT = 'MwC%6gA6w1W#8s';
    public static function hash($password) {
        return hash('sha512', self::SALT . $password);
    }
    public static function verify($password, $hash) {
        return ($hash == self::hash($password));
    }
}
?>
