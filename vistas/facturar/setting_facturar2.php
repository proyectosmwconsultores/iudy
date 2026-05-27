
<?php
  require('../../php/clases/class.System.php');
  require('../../hace.php');
  $db = new Conexion();
  date_default_timezone_set('America/Mexico_City');

  require_once '../../assets/sw-sdk-php/SWSDK.php';
  use SWServices\Authentication\AuthenticationService as Authentication;
  use SWServices\Stamp\StampService as StampService;
  use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;
  use SWServices\Validation\ValidarXML as ValidarXML;
  use SWServices\Validation\ValidaLco as ValidaLco;
  use SWServices\Validation\ValidaLrfc as ValidaLrfc;
  use SWServices\JSonIssuer\JsonEmisionTimbrado as JsonEmisionTimbrado;
  use SWServices\Cancelation\CancelationService as CancelationService;
  use SWServices\AccountBalance\AccountBalanceService as AccountBalanceService;
  use SWServices\SatQuery\ServicioConsultaSAT as ConsultaCfdiSAT;
  use SWServices\Csd\CsdService as CsdService;
  use SWServices\Taxpayer\TaxpayerService as ValidarListaNegra;
  header('Content-type: text/plain');
  $params = array(
      "url"=>"http://services.test.sw.com.mx",
      "user"=>"sandbox@conectia.mx",
      "password"=> "1234567890"
        );
  $tipoGuardar = $_POST["TipoGuardar"];

  if($tipoGuardar == "process_fact_id"){
    $IdUsua = $_POST["IdUsua"];
    $NoFolio = $_POST["NoFolio"];
    $Forma = $_POST["Forma"];
    $_total = $_POST["Total"];
    
    $_procesado = 0;
    if($Forma < 10){ $Forma = '0'.$Forma; } else { $Forma = $Forma; }
    $_folio = time();
    
    $e_rfc = "CIE090115D22";
    $e_nombre = "CENTRO INTEGRAL DE ESTUDIOS PROFESIONALES";
    $e_regimen = "601";
    $e_cp = "86280";

    // "\n\n--------------- Lista certificados por Rfc ------------------\n\n";
    try {
    CsdService::Set($params);
    $response = CsdService::GetListCsdByRfc('CIE090115D22');
    $res = $response->status;
      if($res == 'success'){
        $NoSerie_emisor = $response->data[0]->certificate_number;
      } else {
        $_procesado = "0_No ha podido encontrar el numero de certificado del emisor.";
        echo $_procesado;
        die();
      }
    }
      catch(Exception $e){
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    $sql_dat_us = $db->query("SELECT tblp_foliospago.IdFolio, tblp_foliospago.IdCampus, tblp_foliospago._tipo, tblp_foliospago.IdPago, tblc_ciclogrupo.IdCiclo, tblc_ciclogrupo.Grado, tblp_grupo.Grupo FROM tblp_foliospago Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdCiclo = tblp_pagos.IdCiclo AND tblc_ciclogrupo.IdGrupo = tblp_pagos.IdGrupo Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_pagos.IdGrupo AND tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo WHERE tblp_foliospago.NoFolio =  '$NoFolio' ");
    $db->rows($sql_dat_us);
    $_user_dat = $db->recorrer($sql_dat_us);
    if($_user_dat['IdCampus'] == 1){ $Serie = "V"; }
    if($_user_dat['IdCampus'] == 2){ $Serie = "C"; }
    if($_user_dat['IdCampus'] == 3){ $Serie = "T"; }
    if($_user_dat['IdCampus'] == 4){ $Serie = "Z"; }
    
    if(!$Serie){
        $_procesado = "0_Favor de comunicarse con el administrador no existe el la seria de la factura.";
        echo $_procesado;
        die();
    }
    
    $sql_folio_dis = $db->query("SELECT * FROM tblg_folio WHERE tblg_folio.IdEstatus =  '8' AND tblg_folio.Serie = '$Serie' ORDER BY tblg_folio.Folio ASC LIMIT 1 ");
    $db->rows($sql_folio_dis);
    $_folio_dis = $db->recorrer($sql_folio_dis);
    $_folio_ok = $_folio_dis['Folio'];
    $_idfolio_ok = '9999';
    if(!$_folio_ok){
        $_procesado = "0_Favor de comunicarse con el administrador ya que no tiene mas folios disponibles para facturar.";
        echo $_procesado;
        die();
    }
    //$insertar = $db->query("UPDATE tblg_folio SET tblg_folio.IdEstatus = '6' WHERE tblg_folio.IdFolio = '$_idfolio_ok' ");

    $emisor["Rfc"]="$e_rfc";
    $emisor["Nombre"]="$e_nombre";
    $emisor["RegimenFiscal"]="$e_regimen";
    $conceptos = null;

    $sql_us = $db->query("SELECT tblc_datosfactura.IdUsua, tblc_datosfactura.tipoPersona, tblc_datosfactura.RFC, tblc_datosfactura.Razon, tblc_datosfactura.CP, tblc_usocfdi.Clave AS UsoCFDI, tblc_regimen_fiscal.Clave AS RegimenFiscal FROM tblc_datosfactura Left Join tblc_usocfdi ON tblc_usocfdi.IdUso = tblc_datosfactura.IdUso Left Join tblc_regimen_fiscal ON tblc_regimen_fiscal.IdRegimen = tblc_datosfactura.IdRegimen WHERE tblc_datosfactura.IdUsua =  '$IdUsua' ");
    $db->rows($sql_us);
    $_user = $db->recorrer($sql_us);
    
    $tipoPersona = $_user['tipoPersona'];
    

    $receptor["Rfc"] = $_user['RFC'];
    $receptor["Nombre"] = $_user['Razon'];
    $receptor["DomicilioFiscalReceptor"] = $_user['CP'];
    $receptor["RegimenFiscalReceptor"] = $_user['RegimenFiscal'];
    $receptor["UsoCFDI"] = $_user['UsoCFDI'];

    $_fecha = date('Y-m-d\TH:i:s');

    $comprobante["Version"] = "4.0";
    $comprobante["FormaPago"] = $Forma;
    $comprobante["Serie"] = "$Serie";
    $comprobante["Folio"] = "$_folio_ok";
    $comprobante["Fecha"] = $_fecha;
    $comprobante["MetodoPago"] = "PUE";
    $comprobante["Sello"] = "";
    $comprobante["NoCertificado"] = "";
    $comprobante["Certificado"] = "";
    $comprobante["CondicionesDePago"] = "CondicionesDePago";
    $comprobante["Moneda"] = "MXN";
    $comprobante["TipoCambio"] = "1";
    $comprobante["TipoDeComprobante"] = "I";
    $comprobante["Exportacion"] = "01";
    $comprobante["LugarExpedicion"] = "$e_cp";
    $comprobante["Emisor"] = $emisor;
    $comprobante["Receptor"] = $receptor;
    $comprobante["Conceptos"] = $conceptos;

    $_desc = '';
    $_sumImp= 0;
    $_sumDes= 0;
    
  $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $longitud = 34;
  $_anio = date("Y");
  $_mes = date("m");
  $codigoFactura =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);
  $codigoFactura = $_anio.$codigoFactura.$_mes;
      
    $sql_pag = $db->query("SELECT
tblp_foliospago.IdFolio,
tblp_foliospago.NoFolio,
tblp_foliospago.Monto,
tblp_foliospago._importe,
tblp_foliospago._descuento,
tblp_foliospago._total,
tblp_foliospago._fac,
tblp_pagos.Fecha,
tblp_educativa.IdGrado,
tblp_foliospago.Estatus,
tblp_pagos.Monto AS TotalPagar,
tblc_formapago.c_FormaPago,
tblc_formapago.c_Descripcion,
tblp_educativa.Nombre,
tblc_conceptos.NomConcepto,
tblc_conceptosplanes.Unidad,
tblc_conceptosplanes.ClaveUnidad,
tblc_conceptosplanes.ClaveProdServ
FROM
tblp_foliospago
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta
Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma
Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
WHERE tblp_foliospago.IdUsua = '$IdUsua' AND  tblp_foliospago.NoFolio = '$NoFolio' ");
    $i = 0;
    while($_pag = $db->recorrer($sql_pag)){
      $_fac =  $_pag['_fac'];
      $_idEstatus =  $_pag['Estatus'];
      
      $nomP =  $_pag['Nombre'].' '.$_pag['NomConcepto'].' '.obtener_AnioMesMAY($_pag['Fecha']); 
      $nomP = limpiar_cadena_id($nomP);

      if($_fac == 1){
        $va_unitario = $_pag['_importe'];
        $va_importe = $_pag['_importe'];
        $va_descuento = $_pag['_descuento'];
      } else {
          $va_descuento = $_pag['_descuento'];
          if($va_descuento < 0){
                $va_unitario = $_pag['_importe'];
                $va_importe = $_pag['_importe'];
                $va_descuento = 0;
          } else {
                $va_unitario = $_pag['_importe'];
                $va_importe = $_pag['_importe'];
                $va_descuento = $_pag['_descuento'];
          }
      }
      
      
      
      $Impuestos["Base"] = 1;
      $Impuestos["Impuesto"] = "002";
      $Impuestos["TipoFactor"] = "Exento";
      
      $Conceptos["Traslados"] = [$Impuestos];
      $concepto["Impuestos"] = $Conceptos;
      
      
      $va_unitario = number_format($va_unitario, 2, '.', '');
      $unidad = "Unidad de servicio";
      $_unidad = $_pag['NomConcepto'];
      $concepto["ClaveProdServ"] = $_pag['ClaveProdServ'];
      $concepto["NoIdentificacion"] = $_pag['NoFolio'];
      $concepto["Cantidad"] = "1.0";
      $concepto["ClaveUnidad"] = $_pag['ClaveUnidad'];
      $concepto["Unidad"] = $unidad;
      $concepto["Descripcion"] = $nomP;
      $concepto["ValorUnitario"] = $va_unitario;
      $concepto["Importe"] = $va_unitario;
      $concepto["Descuento"] = $va_descuento;
      $concepto["ObjetoImp"] = "01";
      
      
        
      $conceptos[$i]=$concepto;

      //$insertar = $db->query("INSERT INTO tblg_conceptos_factura (FolioPago,ClaveProdServ,Cantidad,ClaveUnidad,Unidad,Descripcion,ValorUnitario,Importe,Descuento,ObjetoImp, FecCap, Precio, _folio, _codigoFactura, _unidad) VALUES('$NoFolio','".$_pag['ClaveProdServ']."','1','".$_pag['ClaveUnidad']."','$unidad','$nomP','$va_unitario','$va_importe','$va_descuento','01', NOW(),'$va_unitario','$_folio','$codigoFactura','$_unidad')");
      $i = ($i + 1);
      $_sumImp= ($_sumImp + $va_unitario);
      $_sumDes= ($_sumDes + $va_descuento);
    }
    $_tox = 0;
    $_sumImp = number_format($_sumImp, 2, '.', '');
    $_sumDes = number_format($_sumDes, 2, '.', '');
    $_tox = ($_sumImp - $_sumDes);
    $_tox = number_format($_tox, 2, '.', '');

    $comprobante["SubTotal"] = $_sumImp;
    $comprobante["Descuento"] = $_sumDes;
    $comprobante["Total"] = $_tox;

    $comprobante["Conceptos"] = $conceptos;
    
    $Impuestos["Base"] = 1;
    $Impuestos["Impuesto"] = "002";
    $Impuestos["TipoFactor"] = "Exento";
  
    $Conceptos["Traslados"] = [$Impuestos];
    $comprobante["Impuestos"] = $Conceptos;
      
      

    $jsonx = json_encode($comprobante); 
 echo   $jsonx;

    $_anio = date("Y");
    $_mes = date("m");
    $nombre = $_folio.'.json';
    $directorio = "../../assets/docs/factura/$_anio/$_mes/$nombre";
die('ok');
    file_put_contents("$directorio", $jsonx);

    $insertar = $db->query("INSERT INTO tblg_datos_factura (FolioPago,IdEstatus, Version, FormaPago, Serie, Folio, Fecha, MetodoPago, Sello, NoCertificado, Certificado, CondicionesDePago, SubTotal, Descuento, Moneda, TipoCambio, Total, TipoDeComprobante, Exportacion, LugarExpedicion, E_Rfc, E_Nombre, E_RegimenFiscal, R_Rfc, R_Nombre, R_DomicilioFiscalReceptor, R_RegimenFiscalReceptor, R_UsoCFDI, Anio, Mes, Json, FecCap, NoSerie_emisor, _folio, _codigoFactura, _tipo) VALUES('$NoFolio','12','4.0','$Forma','$Serie','$_folio_ok','$_fecha','PUE','---','-----','******','CondicionesDePago','$_sumImp','$_sumDes','MXN','1','$_tox','I','01','$e_cp','$e_rfc','$e_nombre','$e_regimen','".$_user['RFC']."','".$_user['Razon']."','".$_user['CP']."','".$_user['RegimenFiscal']."','".$_user['UsoCFDI']."','$_anio','$_mes','$nombre',NOW(),'$NoSerie_emisor','$_folio','$codigoFactura','$Serie')");
    $IdGenerar = $db->insert_id;


    try {
        $json = file_get_contents("$directorio");
        
        JsonEmisionTimbrado::Set($params);
        $resultadoJson = JsonEmisionTimbrado::JsonEmisionTimbradoV4($json);

        $res = $resultadoJson->status;
        if($res == 'success'){
                $cadenaOriginalSAT = $resultadoJson->data->cadenaOriginalSAT;
                $noCertificadoSAT = $resultadoJson->data->noCertificadoSAT;
                $noCertificadoCFDI0 = $resultadoJson->data->noCertificadoCFDI;
                $uuid = $resultadoJson->data->uuid;
                $selloSAT = $resultadoJson->data->selloSAT;
                $selloCFDI = $resultadoJson->data->selloCFDI;
                $fechaTimbrado = $resultadoJson->data->fechaTimbrado;
                $qrCode = $resultadoJson->data->qrCode;
                $cfdi = $resultadoJson->data->cfdi;
              } else {
                $message = ($resultadoJson->message);
                $messageDetail = ($resultadoJson->messageDetail);
              }
    }
    catch(Exception $e){
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    $nombre_img = $_folio;

    $imgdata = base64_decode($qrCode);
    $f = finfo_open();
    $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
    $temp=explode('/',$mime_type);
    $path = "../../assets/docs/factura/$_anio/$_mes/$nombre_img.$temp[1]";
    file_put_contents($path,base64_decode($qrCode));

    header('Content-type: text/html; charset=utf-8');

    $nombrex = $_folio.'.xml';
    $directorio = "../../assets/docs/factura/$_anio/$_mes/$nombre";

    $archivo = fopen("../../assets/docs/factura/$_anio/$_mes/$nombrex", "a") or die("Error al crear el txt");

    fwrite($archivo,$cfdi);

    fclose($archivo);

    if($cadenaOriginalSAT){
      $hoy = date('Y-m-d');
      $insertar = $db->query("INSERT INTO tblg_factura (FolioPago, IdGenerar, IdEstatus, cadenaOriginalSAT, noCertificadoSAT, noCertificadoCFDI, uuid, selloSAT, selloCFDI, fechaTimbrado, qrCode, cfdi, Fecha, IdUsua, _folio, _Grado, _Grupo, _idCiclo, _codigoFactura) VALUES('$NoFolio','$IdGenerar','4','$cadenaOriginalSAT','$noCertificadoSAT','$noCertificadoCFDI','$uuid','$selloSAT','$selloCFDI','$fechaTimbrado', '$qrCode','$cfdi','$hoy','$IdUsua','$_folio','".$_user_dat['Grado']."','".$_user_dat['Grupo']."', '".$_user_dat['IdCiclo']."','$codigoFactura')");
      $IdFac = $db->insert_id;
      $insertar = $db->query("UPDATE tblp_foliospago SET tblp_foliospago._codigoFactura = '$codigoFactura', tblp_foliospago.IdFactura = '$IdFac', tblp_foliospago.Factura = '3' WHERE tblp_foliospago.NoFolio = '$NoFolio' ");
      $insertar = $db->query("UPDATE tblg_conceptos_factura SET tblg_conceptos_factura.IdFactura = '$IdFac' WHERE tblg_conceptos_factura.FolioPago = '$NoFolio' ");
      $insertar = $db->query("UPDATE tblg_datos_factura SET tblg_datos_factura.IdFactura = '$IdFac' WHERE tblg_datos_factura.FolioPago = '$NoFolio' ");
      $insertar = $db->query("UPDATE tblg_folio SET tblg_folio.IdEstatus = '6', tblg_folio.FecUtilizado = NOW(), tblg_folio._codeFactura = '$codigoFactura' WHERE tblg_folio.IdFolio = '$_idfolio_ok' ");
      $_procesado = "1_1";
    } else {
      $insertar = $db->query("DELETE FROM tblg_conceptos_factura WHERE tblg_conceptos_factura.FolioPago = '$NoFolio' ");
      $insertar = $db->query("DELETE FROM tblg_datos_factura WHERE tblg_datos_factura.FolioPago = '$NoFolio' ");
      $insertar = $db->query("UPDATE tblg_folio SET tblg_folio.IdEstatus = '8' WHERE tblg_folio.IdFolio = '$_idfolio_ok' ");

      $_procesado = "0_".$message;
    }

    $db->close();
    echo $_procesado;
  }
  
  
  
  
  

  function limpiar_cadena_id($cadena){
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);
        $cadena=str_ireplace("Á","A",$cadena);
        $cadena=str_ireplace("É","E",$cadena);
        $cadena=str_ireplace("Í","I",$cadena);
        $cadena=str_ireplace("Ó","O",$cadena);
        $cadena=str_ireplace("Ú","U",$cadena);
        $cadena=stripslashes($cadena);
        $cadena=trim($cadena);
        return $cadena;
      }
