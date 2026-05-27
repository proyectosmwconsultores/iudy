<?php
$token_id = $_POST['token_id'];
$deviceSessionId = $_POST['deviceSessionId'];

$IdUsua = $_POST['IdUsua'];
$IdPago = $_POST['IdPago'];

require('../../php/clases/class_openpay.php');
require('../../hace.php');
$open = new Class_openpay();
$pago = $open->obtener_pago_id($IdPago);
$user = $open->obtener_usuario_id($IdUsua);


$importe = $pago[0]["Monto"];
$descuento = $pago[0]["Descuento"];
$recargos = $pago[0]["Recargos"];
$abono = $pago[0]["TotalPagado"];
$total = ($pago[0]["Monto"] + $pago[0]["Recargos"] - $pago[0]["Descuento"] - $pago[0]["TotalPagado"] - $pago[0]["Descuento2"]); 



$precio = ($pago[0]["Monto"] + $pago[0]["Recargos"] - $pago[0]["Descuento"] - $pago[0]["TotalPagado"] - $pago[0]["Descuento2"]);

$descripcion = $pago[0]["NomConcepto"] . ' ' . obtener_AnioMesMAY($pago[0]["Fecha"]).'_'.$importe.'_'.$descuento.'_'.$recargos.'_'.$abono.'_'.$total.'_'.$IdUsua.'_'.$precio;

$nombre = $user[0]["Nombre"];
$apellidos = $user[0]["APaterno"] . ' ' . $user[0]["AMaterno"];
$telefono = $user[0]["Celular"];
$correo = $user[0]["Correo"];

require(dirname(__FILE__) . '/../../assets/Openpay/Openpay.php');

Openpay::setId('mamgnh5fl28kbvylfzid');
  Openpay::setApiKey('pk_9b5b3af386d74f52a9b31e7aa7d25976');
  Openpay::setProductionMode(true);
  $openpay = Openpay::getInstance('mamgnh5fl28kbvylfzid', 'sk_06aa0d852c444178bc2957723b626a08');
$id = time();
$customer = array(
  'name' => "$nombre",
  'last_name' => "$apellidos",
  'phone_number' => "$telefono",
  'email' => "$correo",
);


$IdPago = $IdPago.'_'.time();
if($precio < 1000){
$chargeData = array(
  'method' => 'card',
  'source_id' => "$token_id",
  'amount' => "$precio", // formato númerico con hasta dos dígitos decimales.
  'description' => "$descripcion",
  'order_id' => "$IdPago",
  'device_session_id' => "$deviceSessionId",
  'customer' => $customer
);


$charge = $openpay->charges->create($chargeData);
$res = $charge->status;
if($res = 'completed'){
  $pag = $open->update_estatus_pago($IdPago,$total);
  echo 1;
} else {
  echo 0;
}



} else {
$chargeData = array(
  'method' => 'card',
  'source_id' => "$token_id",
  'amount' => "$precio", // formato númerico con hasta dos dígitos decimales.
  'description' => "$descripcion",
  'order_id' => "$IdPago",
  'device_session_id' => "$deviceSessionId",
  'redirect_url' => "https://sciudy.com/misPagos.php",
  'use_3d_secure' => "true",
  
  'customer' => $customer
);


$charge = $openpay->charges->create($chargeData);
 $res = $charge->status;
 $url = $charge->payment_method->url;
if($res = 'charge_pending'){
    $id = $charge->id;
    $open->update_estatus_pago_link($IdPago,$url,$id);
   echo $url = $charge->payment_method->url;
   
   // header("$url");
//    exit;
  
  //echo 1;
} else {
  echo 0;
}


}



?>
