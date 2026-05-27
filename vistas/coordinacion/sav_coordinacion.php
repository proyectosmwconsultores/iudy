<?php
  require('../../php/clases/class.System.php');
  $db = new Conexion();
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\SMTP;



  $tipoGuardar = $_POST["TipoGuardar"];

  if($tipoGuardar == "mod_calificacion_final"){
    $AnteriorPromedio = $_POST["AnteriorPromedio"];
    $IdCalificacion = $_POST["IdCalificacion"];
    $IdUsua = $_POST["IdUsua"];
    $Promedio = $_POST["Promedio"];
    $Motivo = $_POST["Motivo"];

    $insertar = $db->query("INSERT INTO tblp_calificacion_cambios (IdCalificacion, IdUsua, PromedioAnterior, PromedioNuevo, Motivo, FecCap) VALUES ('$IdCalificacion','$IdUsua','$AnteriorPromedio','$Promedio','$Motivo',NOW())");
    
    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$Promedio' WHERE tblp_calificacion.IdCalificacion = '$IdCalificacion'");

    $db->close();
    echo $insertar;
}


# AGREGAR ASIGNACION MODULO A DOCENTES
if($tipoGuardar == "invitacion_docente_id"){
  $db = new Conexion();
  $anio = date("Y");
  $mes = date("m");
  $anioo = substr($anio, 2, 2);

  $IdCampus = $_POST['IdCampus'];
  $IdCiclo = $_POST['IdCiclo'];
  $IdGrupo = $_POST['IdGrupo'];
  $IdModulo = $_POST['IdModulo'];
  $IdDocente = $_POST['IdDocente'];
  $IdCoordinador = $_POST['IdCoordinador'];
  $Inicio = $_POST['Inicio'];
  $Final = $_POST['Final'];

  $porciones = explode("_", $IdGrupo);
  $IdGrupo = $porciones[0]; // porción1
  $Grado =  $porciones[1]; // porción2

  
  $sql6 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdModulo =  '$IdModulo' AND tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.IdCiclo = '$IdCiclo' ");
  $db->rows($sql6);
  $datos61 = $db->recorrer($sql6);
  
  if (!isset($datos61["IdAsignacion"])) {
    // $IdAsiX = $datos61["IdAsignacion"];
    $dir = 'assets/trabajos/' . $anio . '/' . $mes . '/';
    $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud = 15;
    $IdAsig =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);
    $carpeta = $dir . $IdAsig;
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
    }

    $carpetaCrear2 = "assets/trabajos/$anio/$mes/$IdAsig/tareas";
    if (!file_exists($carpetaCrear2)) {
      mkdir($carpetaCrear2, 0777, true);
    }


    $Estatus = "Activo";
    $sql8 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $grupo = $datos81["Grupo"];
    $_dia = $datos81["Dia"];

    $sql3 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '$IdCiclo'");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);
    $Fini = $datos31["FInicio"];
    $Ffin = $datos31["FFinal"];

    $sql5 = $db->query("SELECT Max(tblp_planeacion.Folio) AS Folio FROM tblp_planeacion WHERE tblp_planeacion.IdUsua = '$IdDocente'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $FFolio = $datos51["Folio"] + 1;

    $sql23 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdDocente'");
    $db->rows($sql23);
    $datos231 = $db->recorrer($sql23);
    $idCam = $datos231["IdCampus"];
    $nom = substr($datos231["Nombre"], 0, 1);
    $pat = substr($datos231["APaterno"], 0, 1);
    $codNomPat = $nom . $pat;


    $sql9 = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdModulo =  '$IdModulo'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdOferta = $datos91["IdEducativa"];
    $semcua = $datos91["Grado"];
    $codeMod = $datos91["CodeModulo"];
    $IdCamp = $datos91["IdCampus"];
    $NombreMod = $datos91["NombreMod"];
    $cadFol = str_pad($FFolio, 3, "0", STR_PAD_LEFT);

    $codeMod = substr($codeMod, 8, 1);
    $cod = $codeMod . $codNomPat . $anioo . $cadFol;

    $sql_n = $db->query("SELECT tblp_educativa.IdGrado, tblc_grado.Contenido FROM tblp_educativa Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
    $db->rows($sql_n);
    $datos_n = $db->recorrer($sql_n);
    $_texto = $datos_n["Contenido"];
    $_idGrado = $datos_n["IdGrado"];
    $pxs = 0;

    $sql_pagx = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.IdGrupo =  '$IdGrupo' AND tblp_asignacion.Tipo =  '2' ");
    $db->rows($sql_pagx);
    $_pag = $db->recorrer($sql_pagx);
    
    if (!isset($_pag["IdAsignacion"])) {
      $pxs = 0;
    }

    $_idAigx = $_pag["IdAsignacion"];
    $anioHoy = date("Y");
    $insertar = $db->query("INSERT INTO tblp_asignacion (IdAsignacion,IdEducativa, IdModulo, Grupo, IdUsua, FecIni, FecFin, Estatus, FecCap,Tipo,IdGrupo, IdCiclo, IdEstatus, IdCampus, Curso, Anio, Mes, Fondo, _texto, _idEstatus, _estatus, _grado) VALUES ('$IdAsig','$IdOferta','$IdModulo','$grupo','$IdDocente','$Inicio','$Final','PENDIENTE',NOW(),'2','$IdGrupo','$IdCiclo','1','$IdCampus','0','$anio','$mes','img_1.jpg','$_texto','1','V','$Grado')");
    $insertar = $db->query("INSERT INTO tblp_asignacion (IdAsignacion,IdEducativa, IdModulo, Grupo, IdUsua, FecIni, FecFin, Estatus, FecCap,Tipo,IdGrupo, IdCiclo, IdEstatus, IdCampus, Curso, Anio, Mes, Fondo, _texto, _idEstatus, _estatus, _grado) VALUES ('$IdAsig','$IdOferta','$IdModulo','$grupo','$IdCoordinador','$Inicio','$Final','PENDIENTE',NOW(),'4','$IdGrupo','$IdCiclo','1','$IdCampus','0','$anio','$mes','img_1.jpg','$_texto','1','V','$Grado')");
    $insertar = $db->query("INSERT INTO tblp_planeacion (IdAsignacion,IdUsua,FecAsignacion, Folio, Planeacion, IdEstatus, IdCampus) VALUES ('$IdAsig','$IdDocente',NOW(),'$FFolio','$cod','31','$IdCampus')");


    $_v = 0;
    if ($_dia == 'S') {
      $_v = 6;
    }
    if ($_dia == 'D') {
      $_v = 7;
    }
    $cond_i = "";
    $cond_v = "";
    for ($i = 1; $i < 8; $i++) {
      if ($i == $_v) {
        $cond_i = " ,HraIni, MinIni, HraFin, MinFin, Total";
        $cond_v = ",'08','00','14','00','6'";
      } else {
        $cond_i = "";
        $cond_v = "";
      }
      $insertar = $db->query("INSERT INTO tblp_horario (IdAsignacion, IdDia $cond_i) VALUES ('$IdAsig','$i' $cond_v)");
    }

    if ($insertar) {

      require '../../assets/PHPMailer/src/Exception.php';
      require '../../assets/PHPMailer/src/PHPMailer.php';
      require '../../assets/PHPMailer/src/SMTP.php';

      $sql_user = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdDocente'  ");
  $db->rows($sql_user);
  $_user = $db->recorrer($sql_user);


  $nombre = $_user["Nombre"].' '.$_user["APaterno"].' '.$_user["AMaterno"];
  $correo = $_user["Correo"];
  $correo = "pedro.goca@hotmail.com";


  $mail = new PHPMailer(true);

  $html = "
<body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;'>
    <div style='max-width: 700px; margin: 20px auto; background-color: #ffffff; padding: 30px; border-radius: 10px 10px 0px 0px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); text-align: justify;'>
        <div style='background-color: white; color: #2c3e50; padding: 20px; border-radius: 10px 10px 0 0; text-align: center;'>
            <img src='https://sciudy.com/assets/images/campus/logo_inicio.png' alt='IUDY Logo' style='width: 150px; margin-top: 10px;'>
        </div>
        
        <p style='font-weight: bold; color: #b51e36; text-align: center; font-size: 20px;'>ATENTA INVITACI&Oacute;N</p>

        <h2 style='color: #2c3e50; margin-bottom: 20px; font-size: 18px;'>HOLA, $nombre </h2>
        
        <p>Por este medio nos dirigimos a usted con el prop&oacute;sito de extenderle un afectuoso saludo y una cordial invitaci&oacute;n para impartir clases en nuestra instituci&oacute;n.</p>
        
        <p>Confiamos en que su experiencia y conocimientos ser&aacute;n de gran valor para enriquecer la experiencia educativa de nuestros estudiantes.</p>
        <p>Encontrar&aacute; el programa de estudio adjunto a trav&eacute;s de un enlace en la invitaci&oacute;n favor de dar clic <span style='font-weight: bold; color: #b51e36;'> <a href = 'https://sciudy.com/invitacion.php?idToken=$IdAsig'> AQU&Iacute; </a></span>.</p>
        <p>Esperamos con optimismo una respuesta afirmativa de su parte y agradecemos sinceramente la atenci&oacute;n que ha brindado a esta invitaci&oacute;n.</p>
        <a href = 'https://sciudy.com/invitacion.php?idToken=$IdAsig'>
        <div style='background-color:#1d3462; padding:8px; border-radius:8px; margin-top:30px'><p style='font-size:16px; color:white; text-align:center; margin:0'><b>Ver invitaci&oacute;n de la materia</b></p></div>
        </a>

    </div>
    
</body>
";


  $asunto = "Invitacion a clase - ".$IdAsig;

  try {
    $mail->SMTPDebug = 0; // Sin mensajes de depuración
    $mail->isSMTP();
    $mail->Host = "mail.sciudy.com";
    $mail->SMTPAuth = true;
    $mail->Username = "master@sciudy.com";
    $mail->Password = "G27m6626YD8c";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = "465";

    $mail->setFrom('master@sciudy.com', 'PLATAFORMA SCIUDY');
    $mail->addAddress($correo);
    $mail->addBCC('pedroo.goca@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = $asunto;
    $mail->Body = $html;
    $mail->AltBody = $html;
    $mail->send();
  } catch (Exception $e) {
    //echo  "CORREO NO ENVIADO. Error: {$mail->ErrorInfo}";
  }

    

      echo 1;
    } else {
      echo 0;
    }
  } else {
    echo 2;
  }
}
