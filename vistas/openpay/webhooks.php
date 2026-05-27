<?php
require('../../php/clases/class.System.php');
$db = new Conexion();
 $arreglo = json_decode(file_get_contents('php://input'), true);
$arreglo2 = serialize($arreglo);
 $insertar = $db->query("INSERT INTO tblp_openpay (texto, feccap) VALUES ('$arreglo',NOW())");

//$insertar = $db->query("INSERT INTO tblp_openpay (openpay, type, event_date, id, authorization, operation_type, transaction_type, card_type, card_brand, card_card_number, card_holder_name, card_expiration_year, card_expiration_month, card_bank_name, card_bank_code, status, feccap) VALUES ('$arreglo2','".$arreglo['type']."','".$arreglo['event_date']."','".$arreglo['transaction']['id']."','".$arreglo['transaction']['authorization']."','".$arreglo['transaction']['operation_type']."','".$arreglo['transaction']['card']['transaction_type']."', '".$arreglo['transaction']['card']['card_type']."','".$arreglo['transaction']['card']['card_brand']."','".$arreglo['transaction']['card']['card_card_number']."','".$arreglo['transaction']['card']['card_holder_name']."', '".$arreglo['transaction']['card']['card_expiration_year']."', '".$arreglo['transaction']['card']['card_expiration_month']."','".$arreglo['transaction']['card']['card_bank_name']."','".$arreglo['transaction']['card']['card_bank_code']."','".$arreglo['transaction']['card']['estatus']."',NOW())");

$estatus = $arreglo['type'];

$insertar = $db->query("INSERT INTO tblp_openpay (openpay, type, event_date, id, authorization, operation_type, transaction_type, card_type, card_brand, card_bank_name, card_bank_code, status, description, error_message, order_id, currency, amount, id_estatus, feccap, _amount, _tax) VALUES ('$arreglo2','".$arreglo['type']."','".$arreglo['event_date']."','".$arreglo['transaction']['id']."','".$arreglo['transaction']['authorization']."','".$arreglo['transaction']['operation_type']."','".$arreglo['transaction']['transaction_type']."','".$arreglo['transaction']['card']['type']."','".$arreglo['transaction']['card']['brand']."','".$arreglo['transaction']['card']['bank_name']."','".$arreglo['transaction']['card']['bank_code']."','".$arreglo['transaction']['status']."','".$arreglo['transaction']['description']."','".$arreglo['transaction']['error_message']."','".$arreglo['transaction']['order_id']."','".$arreglo['transaction']['currency']."','".$arreglo['transaction']['amount']."','2' ,NOW(),'".$arreglo['transaction']['fee']['amount']."','".$arreglo['transaction']['fee']['tax']."')");
$id_opne = $db->insert_id;

if($estatus == 'charge.succeeded'){
  $datos = $arreglo['transaction']['order_id'];
  $authorization = $arreglo['transaction']['authorization'];
  $amount = $arreglo['transaction']['fee']['amount'];
  $tax = $arreglo['transaction']['fee']['tax'];
  $tot = $arreglo['transaction']['amount'];

  $idPago = $arreglo['transaction']['order_id'];
  
  $datxc = explode("_", $idPago);
 $idPago = $datxc[0];

  
  $datos = $arreglo['transaction']['description'];

  $pieces = explode("_", $datos);
  $info = $pieces[0];
  $importe = $pieces[1];
  $descuento = $pieces[2];
  $recargos = $pieces[3];
  $abono = $pieces[4];
  $total = $pieces[5];
  $IdUsua = $pieces[6];
  $_total = $pieces[7];
  if($arreglo['transaction']['card']['type'] == 'credit'){
    $Forma = 5;
  } else {
    $Forma = 4;
  }
  
  $pagadoActual = intval($abono);
  if($pagadoActual == 0){ $_met = 'PUE';
    $importe = ($importe + $recargos);
    $descuento = $descuento;
    $total = $_total;
  } else { $_met = 'PPD';
    $importe = ($importe + $recargos - $descuento - $abono);
    $descuento = 0;
    $total = $_total;
  }


  $pag = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdPago = '$idPago'");
  $db->rows($pag);
  $_pag = $db->recorrer($pag);
  $_IdOferta = $_pag['IdOferta'];
  $_IdCampus = $_pag['IdCampus'];
  $_IdCiclo = $_pag['IdCiclo'];
  $IdUsua = $_pag['IdUsua'];
  
    $sql_us = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Correo, tblc_usuario.IdOferta, tblc_usuario.IdCampus, tblc_campus.Letra FROM tblc_usuario Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql_us);
    $datos_u = $db->recorrer($sql_us);
    $_IdOferta = $datos_u["IdOferta"];
    $_IdCampus = $datos_u["IdCampus"];
    $idCam = $datos_u["Letra"];
    

  $IdBanco = '2';
  $IdProcedencia = '2';
  $IdAdmin = '1';
  
  $anio = date("Y");
  $_anio = substr($anio, 2, 2);
  $Fecha = date("Y-m-d");
  $messs = date("m");
  $anioM = date("Y-m");
  
  $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $longitud = 1;
  $cod =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);

  $folio = $db->query("SELECT tblp_foliospago.Folio FROM tblp_foliospago WHERE tblp_foliospago.Anio = '$anio' ORDER BY tblp_foliospago.Folio DESC");
  $db->rows($folio);
  $_folx = $db->recorrer($folio);
  $_nofolx = $_folx['Folio'] + 1;
  $cadenaNumero = $_anioFol . str_pad($_nofolx, 5, "0", STR_PAD_LEFT);
  $cadenaNumero = $idCam.$cadenaNumero.$cod;

  $insertar = $db->query("INSERT INTO tblp_foliospago (NoFolio, Anio, Folio, IdPago, Estatus, FecCap, FecPago, IdEstatus, IdForma, Tipo, IdUsua, Monto, IdOferta, IdCampus, Mes, IdBanco, Nota, IdProcedencia, IdAdmin, AnioMes, IdCiclo, Factura, _tipo, _importe, _descuento, _total, _metodo)  VALUES('$cadenaNumero','$anio','$_nofolx','$idPago','4',NOW(),'$Fecha','4','$Forma','P','$IdUsua','$total','$_IdOferta','$_IdCampus','$messs','$IdBanco','PAGO POR OPENPAY','$IdProcedencia','$IdAdmin','$anioM', '$_IdCiclo','1','OPENPAY','$importe','$descuento','$total','$_met')");
  
  $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Totalpagado = '$amount', tblp_pagos.IdEstatus = '4' WHERE tblp_pagos.IdPago = '$idPago'");

}

// a:3:{
//   s:4:"type"; s:16:"charge.succeeded";
//   s:10:"event_date"; s:25:"2021-01-30T13:53:36-06:00";
//   s:11:"transaction"; a:17:
//     {
//       s:2:"id"; s:20:"trc3mcenkmeeqq3wikeu";
//       s:13:"authorization"; s:6:"801585";
//       s:14:"operation_type"; s:2:"in";
//       s:16:"transaction_type"; s:6:"charge";
//       s:4:"card"; a:13:
//       {
//         s:4:"type"; s:6:"credit";
//         s:5:"brand"; s:4:"visa";
//         s:7:"address";N;
//         s:11:"card_number"; s:16:"424242XXXXXX4242";
//         s:11:"holder_name"; s:23:"WALTER PEREZ CASILLEJOS";
//         s:15:"expiration_year"; s:2:"29";
//         s:16:"expiration_month"; s:2:"09";
//         s:14:"allows_charges"; b:1;
//         s:14:"allows_payouts";b:0;
//         s:9:"bank_name"; s:8:"BANCOMER";
//         s:11:"points_type"; s:8:"bancomer";
//         s:9:"bank_code"; s:3:"012";
//         s:11:"points_card";b:1;
//       }
//       s:6:"status"; s:9:"completed";
//       s:11:"conciliated";b:0;
//       s:13:"creation_date"; s:25:"2021-01-30T13:53:29-06:00";
//       s:14:"operation_date"; s:25:"2021-01-30T13:53:30-06:00";
//       s:11:"description"; s:13:"pago de curso";
//       s:13:"error_message";N;
//       s:8:"order_id";N;
//       s:8:"currency"; s:3:"MXN";
//       s:6:"amount";d:500;
//       s:8:"customer";a:8:
//       {
//         s:4:"name"; s:5:"PEDRO";
//         s:9:"last_name"; s:8:"GONLZARZ";
//         s:5:"email"; s:22:"pedro.goca@hotmail.com";
//         s:12:"phone_number"; s:10:"9611758584";
//         s:7:"address";N;
//         s:13:"creation_date"; s:25:"2021-01-30T13:53:29-06:00";
//         s:11:"external_id";N;
//         s:5:"clabe";N;
//       }
//       s:3:"fee";a:3:
//       {
//         s:6:"amount";d:17;
//         s:3:"tax";d:2.720000000000000195399252334027551114559173583984375;
//         s:8:"currency"; s:3:"MXN";
//       }s:6:"method"; s:4:"card";
//     }
//   }

//Cushu7677#$-!
// a:4:{
//   s:4:"type";
//   s:12:"verification";
//   s:10:"event_date";
//   s:25:"2021-01-30T13:50:06-06:00";
//   s:17:"verification_code";
//   s:8:"9881cGJb"; // ESTE ES EL CODIGO DE VERIFICACIÓN
//   s:2:"id";
//   s:20:"w1ug5fi2xbmd4bn01yq6";}

?>
