<?php
  require('../php/clases/conexion_crm.php');
  $db = new Conexion();
  date_default_timezone_set('America/Mexico_City');

  $tipoGuardar = $_POST["TipoGuardar"];

  if($tipoGuardar == "registroUserx"){
    $IdOferta = $_POST["Tipo"];
    $Email = $_POST["Email"];
    $Nombre = $_POST["Nombre"];
    $Paterno = $_POST["Paterno"];
    $Materno = $_POST["Materno"];
    $Telefono = $_POST["Telefono"];
    $Sexo = $_POST["Sexo"];

    $sql9 = $db->query("SELECT tblp_prospecto.IdProspecto FROM tblp_prospecto WHERE tblp_prospecto.Correo = '$Email' AND tblp_prospecto.Celular = '$Telefono' ");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $_IdProspecto = $datos91["IdProspecto"];


    if($_IdProspecto){
      echo 1;
      exit();
    } else {

    $_IdCampus = 1;
    $insertar2 = $db->query("INSERT INTO tblp_prospecto (Nombre, APaterno, AMaterno, Celular, Correo, FecCap, IdMedio, Hace, IdOferta, IdCampus, Externo, Tipo, Sexo, IdActividad, IdPrograma) VALUES ('$Nombre','$Paterno','$Materno','$Telefono','$Email',NOW(),'16',NOW(),'$IdOferta','1','2','CAPFORM','$Sexo','10','1')");
    $IdUsua = $db->insert_id;
    $insertar = $db->query("INSERT INTO tblc_pro_domicilio (IdProspecto, Pais) VALUES ('$IdUsua','146')");
    $insertar = $db->query("INSERT INTO tblc_pro_nacimiento (IdProspecto, Pais) VALUES ('$IdUsua','146')");

    $insertar = $db->query("INSERT INTO tblp_seguimiento (IdProspecto, IdUsua, Seguimiento, FecCap, Fecha, IdTipo, IdEstatus, Valor, Externo, IdCal) VALUES ('$IdUsua','$IdUsua','Se hace el proceso captura del prospecto desde el formulario de registro.',NOW(),NOW(),'6','15','0','1','30')");




    $IdPrograma = 1;

    $sql2 = $db->query("SELECT tblp_oferta.IdNivel FROM tblp_oferta WHERE tblp_oferta.IdOferta = '$IdOferta' ");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $IdNivel = $datos21["IdNivel"];

    //$consdx = ", tblp_prospecto.IdPrograma = '$IdPrograma', tblp_prospecto.IdActividad = '1', tblp_prospecto.IdNivel = '$IdNivel' ";

    $_mes = date("m");
    $sqlx = $db->query("SELECT tblp_configuracion.IdConfiguracion, tblp_configuracion.Numero, tblp_configuracion.IdUsua FROM tblp_configuracion WHERE tblp_configuracion.IdCampus =  '1' AND tblp_configuracion.IdGrado =  '$IdNivel' GROUP BY tblp_configuracion.IdUsua ORDER BY tblp_configuracion.Numero ASC ");
    $db->rows($sqlx);
    $datosx = $db->recorrer($sqlx);
    $_IdUsua = $datosx["IdUsua"];
    $_IdConfiguracion = $datosx["IdConfiguracion"];
    $_Numero = $datosx["Numero"] + 1;

    $insertar = $db->query("INSERT INTO tblp_seguimiento (IdProspecto, IdUsua, Seguimiento, FecCap, Fecha, IdTipo, IdEstatus, Valor, Externo, IdCal) VALUES ('$IdUsua','$_IdUsua','Se hace el proceso de envio del prospecto al asesor.',NOW(),NOW(),'1','15','0','1','31')");
    $insertar = $db->query("UPDATE tblp_prospecto SET tblp_prospecto.Fec_envio_asesor = NOW(), tblp_prospecto.IdEstatus = '1', tblp_prospecto.Externo = '2', tblp_prospecto.IdUsua = '$_IdUsua', tblp_prospecto.Hace = NOW() WHERE tblp_prospecto.IdProspecto = '$IdUsua'");
    $insertar = $db->query("UPDATE tblp_configuracion SET tblp_configuracion.Numero = '$_Numero' WHERE tblp_configuracion.IdConfiguracion = '$_IdConfiguracion'");

    $nombre = htmlentities($Nombre.' '.$Paterno.' '.$Materno);
    $pass = $code;

    $destinatario = $Email;
    $asunto = 'Proceso de registro en la Plataforma ENAPROC';
    $sub_titulo = "Su registro esta en proceso";
    $nom_plataforma = "Plataforma ENAPROC";


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
                                                      <div><br>
                                                        <b>NOMBRE: </b> $nombre <br><br>
                                                        Estimado aspirante, en un momento uno de nuestros asesores se podra en contacto contigo para proporcionarte mas informacion.<br>

                                                        </div>
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
    $headers .= "From: Plataforma ENAPROC <info@escuelanacionalpcchiapas.mx>\r\n";
    $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

    mail($destinatario,$asunto,$cuerpo,$headers);




    $sqlx = $db->query("SELECT tblc_usuario.Correo FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$_IdUsua' ");
    $db->rows($sqlx);
    $datosx = $db->recorrer($sqlx);
    $Nombre = $datosx["Nombre"];
    $Paterno = $datosx["APaterno"];
    $Email = $datosx["Correo"];

    $destinatario = $Email;
    $asunto = 'Registro de nuevo aspirante';
    $sub_titulo = "Usted tiene un nuevo aspirante para seguimiento";
    $nom_plataforma = "ENAPROC CRM";


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
                                                      <div><br>
                                                        <b>NOMBRE DEL ASPIRANTE: </b> $nombre <br><br>
                                                        Estimado asesor, este aspirante se encuentra en la Plataforma CRM para su seguimiento.<br>

                                                        </div>
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
    $headers .= "From: $nom_plataforma <info@escuelanacionalpcchiapas.mx>\r\n";
    $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

    mail($destinatario,$asunto,$cuerpo,$headers);



    $db->close();
    echo 2;
  }

  }
  if($tipoGuardar == "validar_email_docs"){
    $Email = $_POST["Email"];


    $sql9 = $db->query("SELECT tblp_prospecto.IdProspecto FROM tblp_prospecto WHERE tblp_prospecto.Correo = '$Email'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdUsua = $datos91["IdProspecto"];

    if($IdUsua){
      echo 1;
      exit();
    } else {
      echo 2;
      exit();
    }

    $db->close();
  }
