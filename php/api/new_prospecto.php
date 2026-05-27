<?php
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  header('Access-Control-Allow-Methods: POST');
  // header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

  $_folio = time();
  header("Content-Type: application/json");
  require('../clases/class.System.php');
  $db = new Conexion();
  sleep(3);
  $input = json_decode(file_get_contents('php://input'), true);

  $sql8 = $db->query("SELECT tblc_convenio.IdConvenio FROM tblc_convenio WHERE tblc_convenio.IdConvenio =  '".$input['IdActividad']."' ");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $rwC = $datos91["IdUsua"];
  if(!$rwC){
    $insertar = $db->query("INSERT INTO tblc_convenio (IdConvenio, Convenio) VALUES('".$input['IdActividad']."','".$input['Convenio']."')");
  }


  $sql9 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Correo =  '".$input['Correo']."' AND tblc_usuario.IdEstatus = '12'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $rwIdUs = $datos91["IdUsua"];
  if($rwIdUs){
    $procesar['valor']['IdUs'] = $rwIdUs;
    $procesar['valor']['IdEstatus'] = 55;
    echo json_encode($procesar);
    exit();
  } else {
    $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Celular, Correo, Permisos, FecCap, Foto, Sexo,FecNac, IdEstatus, IdOferta, IdCampus, Grado, id_ciclo_ini, id_paquete, Semblanza, id_actividad, Folio, SemCua, Educacion) VALUES('".$input['Nombre']."','".$input['APaterno']."','".$input['AMaterno']."','Alumno','".$input['Celular']."','".$input['Correo']."','3',NOW(),'nuevo.png','".$input['Sexo']."','".$input['FecNac']."','12','".$input['IdOferta']."','".$input['IdCampus']."','".$input['IdNivel']."','".$input['IdCiclo']."','CRM','".$input['Info']."','".$input['IdActividad']."','$_folio','".$input['Grado']."','".$input['Id_u']."')");
    $IdUs = $db->insert_id;
    $insertar2 = $db->query("INSERT INTO tblp_informacion (IdUsua, IdOferta, Telefono, Medio, Ciudad, Estado, Pais, Domicilio, CP, Procedencia, LugarNac, Asesor, E_escuela_procedencia, E_nivel_procedencia, E_estado_procedencia, E_estudio, E_promedio, E_tipo, E_titulo, E_cedula, E_posgrado, P_curp, P_depende, P_trabaja, P_civil, C_id, C_nombre, C_tipo, D_pais, D_estado, D_municipio, D_ciudad, D_colonia, D_cp, D_direccion, D_calle) VALUES('$IdUs','".$input['IdOferta']."','".$input['Celular']."','".$input['Medio']."','".$input['Ciudad']."','".$input['Estado']."','MÉXICO','".$input['Domicilio']."','".$input['CP']."','".$input['Procedencia']."', '".$input['Nacimiento']."', '".$input['Asesor']."', '".$input['Procedencia']."', '".$input['ProcedenciaNivel']."', '".$input['ProcedenciaEstado']."', '".$input['Carrera_estudio']."', '".$input['Promedio']."', '".$input['Tipo_institucion']."','".$input['Titulo']."', '".$input['Cedula']."','".$input['Posgrado']."', '".$input['Curp']."','".$input['Depende']."','".$input['Trabaja']."','".$input['IdCivil']."','".$input['IdActividad']."','".$input['Convenio']."','".$input['Tipo_ingreso']."','".$input['Pais']."','".$input['IdEstado']."','".$input['IdMunicipio']."','".$input['IdCiudad']."','".$input['Colonia']."','".$input['CP']."','".$input['Direccion']."','".$input['Calle']."')");

    // $sql_beca = $db->query("SELECT tblc_conceptosplanes.NomPlan, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosplanes.Code, tblc_conceptosplanes.IdConcepto FROM tblc_conceptosdetalle Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblc_conceptosplanes.IdConcepto WHERE tblc_conceptosdetalle.IdOferta =  '".$input['IdOferta']."' AND tblc_conceptos.Grado1 =  '1' ");
    // while($x = $db->recorrer($sql_beca)){
    //   $IdCon = $x['IdConcepto'];
    //   $IdPlan = $x['IdConceptoPlan'];
    //   if($IdCon == 1){ $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConceptoPlan, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConcepto, Nota) VALUES ('$IdUs','$IdPlan','".$input['Promo1']."',NOW(),'".$input['Id_u']."','8','99','".$input['Asesor']."')"); }
    //   if($IdCon == 2){ $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConceptoPlan, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConcepto, Nota) VALUES ('$IdUs','$IdPlan','".$input['Promo2']."',NOW(),'".$input['Id_u']."','8','99','".$input['Asesor']."')"); }
    // }
    // $p1 = $input['Promo1'];
    // $p2 = $input['Promo2'];
    $ase = 'CRM - '.$input['Asesor'];
    $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConcepto, Nota, IdConvenio, Crm, IdCiclo) VALUES ('$IdUs','".$input['Promo1']."',NOW(),'".$input['Id_u']."','8','1','$ase', '".$input['IdActividad']."','1','".$input['IdCiclo']."')");
    $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConcepto, Nota, IdConvenio, Crm, IdCiclo) VALUES ('$IdUs','".$input['Promo2']."',NOW(),'".$input['Id_u']."','8','2','$ase', '".$input['IdActividad']."','1','".$input['IdCiclo']."')");

    $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc) VALUES ('$IdUs','103','1','".$input['IdCiclo']."','T')");
    $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc) VALUES ('$IdUs','104','1','".$input['IdCiclo']."','T')");
    $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc) VALUES ('$IdUs','105','1','".$input['IdCiclo']."','T')");

    $sql = $db->query("SELECT * FROM tblh_tipodocumento WHERE tblh_tipodocumento.Grado = '".$input['IdNivel']."' AND tblh_tipodocumento.Valor = '1'");
    while($xyv = $db->recorrer($sql)){
      $IdTDc = $xyv["IdTipoDoc"];
      $insertar = $db->query("INSERT INTO tblp_documentos (IdUsua, IdTipoDocumento, FecCap)VALUES ('$IdUs','$IdTDc',NOW())");
    }

    $nombre = htmlentities($input['Nombre'].' '.$input['APaterno'].' '.$input['AMaterno']);

    $destinatario = $input['Correo'];
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

                                                        <b style='color: blue; font-size: 14px;'>Folio: </b> <b style='color: red; font-size: 14px;'> $_folio </b><br>
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


    if($insertar){
      $procesar['valor']['IdUs'] = $IdUs;
      $procesar['valor']['IdEstatus'] = 98;
      echo json_encode($procesar);
      exit();
    } else {
      $procesar['valor']['IdEstatus'] = 32;
      echo json_encode($procesar);
      exit();
    }
  }





?>
