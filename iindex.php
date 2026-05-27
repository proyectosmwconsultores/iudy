<?php



$body = [
    'Messages' => [
        [
        'From' => [
            'Email' => "seuninnova@gmail.com",
            'Name' => "Pedro 1"
        ],
        'To' => [
            [
                'Email' => "pedro.goca@hotmail.com",
                'Name' => "Hola pedro"
            ]
        ],
        'Subject' => "Greetings from Mailjet.",
        'HTMLPart' => "<h3>Dear User, welcome to Mailjet!</h3><br />May the delivery force be with you!"
        ]
    ]
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json')
);
curl_setopt($ch, CURLOPT_USERPWD, "2eba03c2bd27d56f669a0970c7f5ac32:efa7e29f22b50ff5d1e991fdb1725fa1");
$server_output = curl_exec($ch);
curl_close ($ch);

$response = json_decode($server_output);
if ($response->Messages[0]->Status == 'success') {
    echo "Email sent successfully.";
}


die();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'email/PHPMailer/Exception.php';
require 'email/PHPMailer/PHPMailer.php';
require 'email/PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

$nombre = 'Pedro Gonzalez Calvo';
$pass = 'mwcomenius';
$matricula = '75843';
$cuerpo = "<table id='x_bodyTable' style='border-collapse: collapse; height: 100%; margin: 0px; padding: 0px; width: 100%; transform: scale(0.87); transform-origin: left top 0px;' min-scale='0.87' width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td id='x_bodyCell' style='height:100%; margin:0; padding:0; width:100%' valign='top' align='center'><table style='border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td id='x_templateHeader' style='background:#F7F7F7 none no-repeat center/cover; background-color:#F7F7F7; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0px; padding-bottom:0px' valign='top' align='center'><table class='x_templateContainer' style='border-collapse:collapse; max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td class='x_headerContainer' style='background:transparent none no-repeat center/cover; background-color:transparent; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0; padding-bottom:0' valign='top'></td></tr></tbody></table></td></tr><tr><td id='x_templateBody' style='background:#FFFFFF none no-repeat center/cover; background-color:#FFFFFF; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:27px; padding-bottom:63px' valign='top' align='center'><table class='x_templateContainer' style='border-collapse:collapse; max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td class='x_bodyContainer' style='background:transparent none no-repeat center/cover; background-color:transparent; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0; padding-bottom:0' valign='top'><table class='x_mcnTextBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnTextBlockOuter'><tr><td class='x_mcnTextBlockInner' style='padding-top:9px' valign='top'><table class='x_mcnTextContentContainer' style='max-width:100%; min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnTextContent' style='padding:0px 18px 9px; color:#828282; word-break:break-word; font-family:Helvetica; font-size:16px; line-height:150%; text-align:left' valign='top'></td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnImageBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnImageBlockOuter'><tr><td class='x_mcnImageBlockInner' style='padding:9px' valign='top'><table class='x_mcnImageContentContainer' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnImageContent' style='padding-right:9px; padding-left:9px; padding-top:0; padding-bottom:0; text-align:center' valign='top'><img data-imagetype='External' src='https://plataforma.mwcomenius.com.mx/assets/images/registro.jpg' alt='' class='x_mcnImage' style='max-width:2400px; padding-bottom:0; display:inline!important; vertical-align:bottom; border:0; height:auto; outline:none; text-decoration:none' width='564' align='middle'> </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnTextBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnTextBlockOuter'><tr><td class='x_mcnTextBlockInner' style='padding-top:9px' valign='top'><table class='x_mcnTextContentContainer' style='max-width:100%; min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnTextContent' style='padding:0px 18px 9px; font-family:Lato,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; word-break:break-word; color:#757575; font-size:16px; line-height:150%; text-align:left' valign='top'><p style='text-align: center;'><strong>¡Registro exitoso!</strong></p><br><br>Estimado usuario<strong> $nombre, </strong>su registro ha sido exitoso.<br><br>Ahora ya puedes ingresar a la Plataforma, recuerda que puedes ingresar en cualquier momento.<br><br>De la misma manera se te ha generado un usuario y password para poder ingresar a la Plataforma MWComenius en cualquier momento.<br><br>Tus datos de acceso los los siguientes:<br><br><b>Usuario:</b> $matricula<br><b>Password</b>: $pass <br><br><br>  </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnButtonBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnButtonBlockOuter'><tr><td class='x_mcnButtonBlockInner' style='padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px' valign='top' align='center'><table class='x_mcnButtonContentContainer' style='border-collapse:separate!important; border-radius:28px; background-color:#0047FF' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td class='x_mcnButtonContent' style='font-family:Arial; font-size:16px; padding:18px' valign='middle' align='center'><a href='https://plataforma.mwcomenius.com.mx/' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' class='x_mcnButton' title='Ir a la Plataforma MasterAcademy' style='font-weight:bold; letter-spacing:normal; line-height:100%; text-align:center; text-decoration:none; color:#FFFFFF; display:block'>Ingresar a la Plataforma MWComenius</a> </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnDividerBlock' style='min-width:100%; border-collapse:collapse; table-layout:fixed!important' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnDividerBlockOuter'><tr><td class='x_mcnDividerBlockInner' style='min-width:100%; padding:18px'><table class='x_mcnDividerContent' style='min-width:100%; border-top:2px solid #EAEAEA; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td style=''><span></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table> ";



try {
    //Server settings
    $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    // $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'noreply.mwcomenius@gmail.com';                     //SMTP username
    $mail->Password   = 'Cushu7677';                               //SMTP password
    $mail->SMTPSecure = 'tls'; // PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('noreplaya@mwcomenius.com.mx', 'Registro en la Plataforma MWComenius');
    $mail->addAddress('pedro.goca@hotmail.com', 'Pedro Gonzalez');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
     $mail->addBCC('pedroo.goca@gmail.com');
    // $mail->addCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('https://plataforma.mwcomenius.com.mx/assets/images/registro.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = $cuerpo;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



 ?>
