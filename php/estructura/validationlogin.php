<?php
ob_start();
//Si no se cumple la existencia de las variables de sesion obligatorias regresar al index
if(!isset($_SESSION['NombreUser']) || !isset($_SESSION['Permisos'])  || !isset($_SESSION['IdUsua']) ||  !isset($_SESSION['IdEstatus']) )
{

 echo "<script type='text/javascript'>
            alert('No se ha logeado o la sesión concluyó. Por favor, ingrese su usuario y contraseña nuevamente');
            window.location='index.php';
            </script>";

}

ob_end_flush ();
?>
