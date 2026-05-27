<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require('../php/clases/class.System.php');
$db = new Conexion();
date_default_timezone_set('America/Mexico_City');

$tipoGuardar = $_POST["TipoGuardar"];
if($tipoGuardar == "enviar_correo_id"){
  $IdUsua = $_POST["IdUsua"];
  $sql8 = $db->query("SELECT * FROM tblc_usuario WHERE  tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Nombre = $datos81["Nombre"].' '.$datos81["APaterno"];
  // $correo = $datos81["Correo"];
  $correo = "pedro.goca@hotmail.com";

  require '../assets/PHPMailer/src/Exception.php';
  require '../assets/PHPMailer/src/PHPMailer.php';
  require '../assets/PHPMailer/src/SMTP.php';
  $mail = new PHPMailer(true);

  $html = "
  <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f5f5f5;'>
      <div style='max-width: 600px; margin: 20px auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>
        <p style='text-align: center;'>
        <img src='https://sciudy.com/assets/images/campus/logo_inicio.png' style='width: 200px;'>
        </p><br>
        <p style='color: #666; line-height: 1.6;'>HOLA, $Nombre </p>
        <p style='color: #666; line-height: 1.6; text-aling: justify;'>Te informamos que tu constancia de estudios solicitado ya se encuentra disponible en la Plataforma SCIUDY. A partir de ahora, podr&aacute;s descargar el documento.</p><br>
        <p style='color: #666; line-height: 1.6; text-align: center;'>Gracias por utilizar nuestros servicios.</p>
        
        
      </div>
  </body>
  </html>";

  $asunto = "Constancia de estudios";
  //$correo = "pedro.goca@hotmail.com";

  try {
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;
      $mail->isSMTP();
      $mail->Host = "mail.sciudy.com";
      $mail->SMTPAuth = true;
      $mail->Username = "no-reply@sciudy.com";
      $mail->Password = "sMNkSvzjwZOv";
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Port = "465";

      $mail->setFrom('no-reply@sciudy.com','PLATAFORMA SCIUDY');
      $mail->addAddress($correo);
      $mail->addBCC('pedroo.goca@gmail.com');
      $mail->isHTML(true);
      $mail->Subject = $asunto;
      $mail->Body = $html;
      $mail->AltBody = $html;
      $mail->send();
      echo "CORREO ENVIADO";

  } catch (Exception $e) {
      echo "CORREO NO ENVIADO. Error: {$mail->ErrorInfo}";
  }
    
  echo 1;
}