<?php
ob_start();
require('class.System.php');


class captura {
  public function get_campus() {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_campus.IdCampus, tblc_campus.Campus FROM tblc_campus WHERE tblc_campus.IdEstatus='8'");
    while($x = $db->recorrer($sql)){
      $get_campus[] = $x;
    }
    return $get_campus;
  }

  public function get_misDocAlumnos($IdAlumno) {
    $db = new Conexion();
    $gmisDocAlmId = [];
    $sql = $db->query("SELECT tblc_docalumnos.IdDocAlumno, tblc_docalumnos.IdUsua, tblc_docalumnos.Archivo, tblc_docalumnos.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_docalumnos Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docalumnos.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docalumnos.Estatus WHERE tblc_docalumnos.IdUsua = '$IdAlumno' AND tblc_docalumnos.Estatus <> 4 ORDER BY tblc_tipodocumento.NomDocumento ASC");
    while($x = $db->recorrer($sql)){
      $gmisDocAlmId[] = $x;
    }
    return $gmisDocAlmId;
  }

  public function get_usuariosLST($Folio) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Folio='$Folio'");
    while($x = $db->recorrer($sql)){
      $gUsuariosLt[] = $x;
    }
    return $gUsuariosLt;
  }

  public function get_tipoDoc($IdUsua, $Tipo, $IdOferta) {
      $db = new Conexion();
      if($Tipo){
        $coond = "AND tblc_tipodocumento.TipoUsuario = '$Tipo' ";
      } else { $coond= ""; }

      $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $IdGrado = $datos91['IdGrado'];

      $sql = $db->query("SELECT * FROM tblc_tipodocumento WHERE tblc_tipodocumento.Grado$IdGrado = '1' $coond ");
      while($x = $db->recorrer($sql)){
        $gTipoDocId[] = $x;
      }
      return $gTipoDocId;
    }

    public function get_configuracionPri() {
      $db = new Conexion();
      $sql = $db->query("SELECT * FROM tblp_configuracion");
      while($x = $db->recorrer($sql)){
        $gConfigt[] = $x;
      }
      return $gConfigt;
    }



	# Registro de nuevo Prospescto
  public function add_registro(){
    if($_POST["gender"]=="HOMBRE"){
      $tSexo = "hombre.png";
    }elseif($_POST["gender"]=="MUJER"){
      $tSexo = "mujer.png";
    }

    $db = new Conexion();
    $sql1 = $db->query("SELECT * FROM tblc_usuario WHERE Cargo = 'Alumno' AND Tipo = '3' AND Correo = '".$_POST["txtCorreo"]."' AND  Permisos = '3' AND  IdOferta = '".$_POST["txtOferta"]."'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $code = $datos2["Code"];

    if($code){
      header("Location:continuar.php?xx=2");
      exit();
    } else {
      $nombre = $_POST["txtNombre"];
      $apellido = $_POST["txtAPaterno"];
      $correo = $_POST["txtCorreo"];
      $nombre = substr($nombre, 0, 1);
      $apellido = substr($apellido, 0, 1);
      $correo = substr($correo, 0, 2);
      $fecP=date("s");
      $fecP= ($fecP * 3);
      $fol = time();
      $_SESSION['Folio'] = $fol;
      $Code = $nombre.$apellido.$correo.$fecP; //uniqid();
      $_SESSION['Code'] = $Code;
      $pass_php = Password::hash($Code);

      $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Tipo, Telefono, Correo, Usuario, Pass_php, FecAlta, Permisos, FecCap, Estado, Estatus, Foto, IdOferta, Sexo, FecNac, Code, Visto,Documentos, Folio, Revalidar) VALUES ('".$_POST["txtNombre"]."','".$_POST["txtAPaterno"]."','".$_POST["txtAMaterno"]."','Alumno','3','".$_POST["txtTelefono"]."','".$_POST["txtCorreo"]."','".$_POST["txtCorreo"]."','$pass_php',NOW(),'3',NOW(),'Activo','Incompleto','$tSexo','".$_POST["txtOferta"]."','".$_POST["gender"]."','".$_POST["datepicker"]."','$Code','1','NO','$fol','".$_POST["revalida"]."')");
      $IdU = $db->insert_id;

      $destinatario = $_POST["txtCorreo"];
      $Nombre = $_POST["txtNombre"].' '.$_POST["txtAPaterno"].' '.$_POST["txtAMaterno"];

      $sql2 = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '".$_POST["txtOferta"]."'");
      $db->rows($sql2);
      $datos3 = $db->recorrer($sql2);
      $OfertaEduca = $datos3["Nombre"];

      $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '1'");
      $db->rows($sql_camp);
      $_camp = $db->recorrer($sql_camp);
      $url = $_camp["Link"];
      $Institucion = $_camp["Campus"];

      $linkLogo = $url.'assets/images/campus/logo_inicio.png';
      $linkContinuar = $url.'continuar.php';
      $linkClicImg = $url.'assets/images/click.png';



      require('Mailin.php');
      $mailin = new Mailin('https://api.sendinblue.com/v2.0','dXQZ0V6pyfM5B1tG');
      $data = array( "to" => array("$destinatario"=>" $Nombre "),
    			//"cc" => array("pedro.goca@hotmail.com"=>"cc whom!"),
    			"from" => array("info@uni.edu.mx"," $Institucion"),
    			"subject" => "Confirmación de su registro en la Plataforma",
    			"text" => "Plataforma de Educación en Linea MWComenius | $Institucion",

    			"html" =>  "<img src=\"{myinlineimage1.png}\" alt=\"-\" border=\"1\">
    					   <table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
            <tr>
                <td colspan='3' height='100' align='center'>
                <b style=' color: rgb(105, 108, 110); font-size:24px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                  <img src= '$linkLogo' >
                </b></td>
            </tr>
            <tr style=' color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:20px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Termine de crear su cuenta.
                </b></td>
            </tr>
            <tr style='background: #f5f5f5; color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Su registro a sido satisfactorio en la <br>Plataforma de Educaci&oacute;n en L&iacute;nea
                </b></td>
            </tr>
    			  <tr>
            <td colspan='3' style='background: #f5f5f5; color: #676a8f;'>
              <table border='0' cellpadding='0' width='100%' style='border-collapse: collapse; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; '>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Alumno: </td><td style='padding: 10px;'> $Nombre </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Oferta educativa: </td><td style='padding: 10px;'> $OfertaEduca </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Folio: </td><td style='padding: 10px;'> $fol </td>
                </tr>
              </table>
    				</td>
            </tr>
            <tr style='background: #f5f5f5; color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Para continuar su registro favor de subir sus documentos que se le solicita<br>
                <a href='$linkContinuar'>
                  HAZ CLICK AQU&Iacute;
                </a>
                </b>
                <b style=' color: rgb(105, 108, 110); font-size:24px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                <a href='$linkContinuar'>
                  <img src= '$linkClicImg' >
                </a>
                </b>
                </td>
            </tr>
            <tr style='background: #f5f5f5; color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:12px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>

                </b></td>
            </tr>
        	</table>",
    			"attachment" => array(),
    			"headers" => array("Content-Type"=> "text/html; charset=iso-8859-1","X-param1"=> "value1", "X-param2"=> "value2","X-Mailin-custom"=>"my custom value", "X-Mailin-IP"=> "102.102.1.2", "X-Mailin-Tag" => "My tag"),
    			"inline_image" => array('myinlineimage1.png' => "your_png_files_base64_encoded_chunk_data",'myinlineimage2.jpg' => "your_jpg_files_base64_encoded_chunk_data")
    );
      var_dump($mailin->send_email($data));
      $_SESSION["RegiX"] = 1;
      header("Location:registro.php");
    }
		if ($insertar) {
			return 1;
		} else {
			return 0;
		}
  }



  public function env_correo($correo){
    $db = new Conexion();
    $sql1 = $db->query("SELECT * FROM tblc_usuario WHERE Cargo = 'Alumno' AND Tipo = '3' AND Correo = '$correo' AND  Permisos = '3' AND  Estatus = 'Incompleto'");
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

    $linkLogo = $url.'assets/images/campus/logo_inicio.png';
    $linkContinuar = $url.'continuar.php';
    $linkClicImg = $url.'assets/images/click.png';

    require('Mailin.php');
    $mailin = new Mailin('https://api.sendinblue.com/v2.0','dXQZ0V6pyfM5B1tG');
    $data = array( "to" => array("$destinatario"=>" $Nombre "),
    			//"cc" => array("pedro.goca@hotmail.com"=>"cc whom!"),
    			"from" => array("info@uni.edu.mx"," $Institucion"),
    			"subject" => "Confirmación de su registro en la Plataforma",
    			"text" => "Plataforma de Educación en Linea MWComenius | $Institucion",

    			"html" =>  "<img src=\"{myinlineimage1.png}\" alt=\"-\" border=\"1\">
    					   <table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
            <tr>
                <td colspan='3' height='100' align='center'>
                <b style=' color: rgb(105, 108, 110); font-size:24px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                  <img src= '$linkLogo'>
                </b></td>
            </tr>
            <tr style=' color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:20px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Termine de crear su cuenta.
                </b></td>
            </tr>
            <tr style='background: #f5f5f5; color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Su registro a sido satisfactorio en la <br>Plataforma de Educaci&oacute;n en L&iacute;nea
                </b></td>
            </tr>
    			  <tr>
            <td colspan='3' style='background: #f5f5f5; color: #676a8f;'>
              <table border='0' cellpadding='0' width='100%' style='border-collapse: collapse; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; '>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Alumno: </td><td style='padding: 10px;'> $Nombre </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Oferta educativa: </td><td style='padding: 10px;'> $OfertaEduca </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Folio: </td><td style='padding: 10px;'> $fol </td>
                </tr>
              </table>
    				</td>
            </tr>
            <tr style='background: #f5f5f5; color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Para continuar su registro favor de subir sus documentos que se le solicita<br>
                <a href='$linkContinuar'>
                  HAZ CLICK AQU&Iacute;
                </a>
                </b>
                <b style=' color: rgb(105, 108, 110); font-size:24px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                <a href='$linkContinuar'>
                  <img src= '$linkClicImg' >
                </a>
                </b>
                </td>
            </tr>
            <tr style='background: #f5f5f5; color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:12px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>

                </b></td>
            </tr>
        	</table>",
    			"attachment" => array(),
    			"headers" => array("Content-Type"=> "text/html; charset=iso-8859-1","X-param1"=> "value1", "X-param2"=> "value2","X-Mailin-custom"=>"my custom value", "X-Mailin-IP"=> "102.102.1.2", "X-Mailin-Tag" => "My tag"),
    			"inline_image" => array('myinlineimage1.png' => "your_png_files_base64_encoded_chunk_data",'myinlineimage2.jpg' => "your_jpg_files_base64_encoded_chunk_data")
    );
    var_dump($mailin->send_email($data));
		if ($OfertaEduca) {
      header("Location: continuar.php?x=3");
		} else {
      header("Location: continuar.php");
		}
  }

  public function add_registroDoc(){
    if($_POST["gender"]=="HOMBRE"){ $tSexo = "hombre.png"; } elseif($_POST["gender"]=="MUJER"){ $tSexo = "mujer.png"; }
    $db = new Conexion();
    $sql1 = $db->query("SELECT * FROM tblc_usuario WHERE Cargo = 'Docente' AND Tipo = '2' AND Correo = '".$_POST["txtCorreo"]."' AND  Permisos = '2'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $code = $datos2["Code"];

    if($code){
      header("Location:success.php?xx=$code");
      exit();
    } else {
      $nombre = $_POST["txtNombre"];
      $correo = $_POST["txtCorreo"];
      $nombre = substr($nombre, 0, 1);
      $correo = substr($correo, 0, 2);
      $fecP=date("s");
      $fecP = ($fecP * 4);

      $Code = $nombre.$correo.$fecP; //uniqid();
      $_SESSION['Code'] = $Code;
      $pass_php = Password::hash($Code);
      $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Tipo, Telefono, Correo, Usuario, Pass_php, FecAlta, Permisos, FecCap, Estado, Estatus, Foto, Sexo, FecNac, Code, Visto,Documentos) VALUES ('".$_POST["txtNombre"]."','".$_POST["txtAPaterno"]."','".$_POST["txtAMaterno"]."','Docente','2','".$_POST["txtTelefono"]."','".$_POST["txtCorreo"]."','".$_POST["txtCorreo"]."','$pass_php',NOW(),'2',NOW(),'Inactivo','Completo','$tSexo','".$_POST["gender"]."','".$_POST["datepicker"]."','$Code','1','NO')");
      $IdU = $db->insert_id;
      $insertar = $db->query("INSERT INTO tblp_docente (IdUsua, Nombre, APaterno, AMaterno, FecCap, Estatus, FecNac,Sexo) VALUES ('$IdU','".$_POST["txtNombre"]."','".$_POST["txtAPaterno"]."','".$_POST["txtAMaterno"]."',NOW(),'Inactivo','".$_POST["datepicker"]."','".$_POST["gender"]."')");

      $destinatario = $_POST["txtCorreo"];
      $Nombre = $_POST["txtNombre"].' '.$_POST["txtAPaterno"].' '.$_POST["txtAMaterno"];

      $sql2 = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '".$_POST["txtOferta"]."'");
      $db->rows($sql2);
      $datos3 = $db->recorrer($sql2);
      $OfertaEduca = $datos3["Nombre"];

      $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '1'");
      $db->rows($sql_camp);
      $_camp = $db->recorrer($sql_camp);
      $url = $_camp["Link"];
      $Institucion = $_camp["Campus"];

      $linkLogo = $url.'assets/images/campus/logo_inicio.png';

      require('Mailin.php');
      $mailin = new Mailin('https://api.sendinblue.com/v2.0','dXQZ0V6pyfM5B1tG');
      $data = array( "to" => array("$destinatario"=>" $Nombre "),
    			//"cc" => array("pedro.goca@hotmail.com"=>"cc whom!"),
    			"from" => array("info@uni.edu.mx"," $Institucion"),
    			"subject" => "Confirmación de su registro en la Plataforma",
    			"text" => "Plataforma de Educación en Linea MWComenius | $Institucion",

    			"html" =>  "<img src=\"{myinlineimage1.png}\" alt=\"-\" border=\"1\">
    					   <table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
            <tr>
                <td colspan='3' height='100' align='center'>
                <b style=' color: rgb(105, 108, 110); font-size:24px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                  <img src= '$linkLogo' >
                </b></td>
            </tr>
            <tr style=' color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:20px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Su registro en la Plataforma ha sido &eacute;xitoso, nosotros nos comunicaremos con usted
                </b></td>
            </tr>
            <tr style='background: #f5f5f5; color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Confirmaci&oacute;n de Registro en la <br>Plataforma de Educaci&oacute;n en L&iacute;nea
                </b></td>
            </tr>
    			  <tr>
            <td colspan='3' style='background: #f5f5f5; color: #676a8f;'>
              <table border='0' cellpadding='0' width='100%' style='border-collapse: collapse; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; '>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Alumno: </td><td style='padding: 10px;'> $Nombre </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Correo: </td><td style='padding: 10px;'> $destinatario </td>
                </tr>

              </table>
    				</td>
            </tr>
            <tr style='background: #f5f5f5; color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:12px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>

                </b></td>
            </tr>
        	</table>",
    			"attachment" => array(),
    			"headers" => array("Content-Type"=> "text/html; charset=iso-8859-1","X-param1"=> "value1", "X-param2"=> "value2","X-Mailin-custom"=>"my custom value", "X-Mailin-IP"=> "102.102.1.2", "X-Mailin-Tag" => "My tag"),
    			"inline_image" => array('myinlineimage1.png' => "your_png_files_base64_encoded_chunk_data",'myinlineimage2.jpg' => "your_jpg_files_base64_encoded_chunk_data")
      );
    var_dump($mailin->send_email($data));
    header("Location:success.php");
    }
		if ($insertar) {
			return 1;
		} else {
			return 0;
		}
  }

  public function get_tokenId($token){
    $db = new Conexion();
    $sql1 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Code = '$token' AND tblc_usuario.Estatus = 'Incompleto'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $IdUsua = $datos2["IdUsua"];
    if($IdUsua){
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Estatus = 'Completo' WHERE tblc_usuario.IdUsua = '$IdUsua' AND tblc_usuario.Code = '$token'");
      header("Location:index.php?x=ok");
    } else {
      header("Location:success.php");
    }
  }



  # OBTENER OFERTA EDUCATIVA (ACTIVA)
  public function get_OfertaEduc() {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_educativa WHERE Estatus='Activo' ORDER BY tblp_educativa.Nombre ASC ");
    while($x = $db->recorrer($sql)){
      $gOfertaE[] = $x;
    }
    return $gOfertaE;
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
