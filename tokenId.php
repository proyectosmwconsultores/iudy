<?php
include("php/estructura/session.php");
require('php/clases/registro.php');
$Regis=new Registro();
$token = $_GET['token'];
if($token){
    $okver=$Regis->get_tokenId($token);
} else {
  header("Location:success.php");
}




?>
