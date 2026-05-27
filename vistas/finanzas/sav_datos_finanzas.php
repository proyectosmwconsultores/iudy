<?php
  require('../../php/clases/class.System.php');
  $db = new Conexion();
  $tipoGuardar = $_POST["TipoGuardar"];

  if($tipoGuardar == "procesar_filtro_1"){
    
    $insertar = $db->query("UPDATE tblh_temporal_conciliar SET tblh_temporal_conciliar.idestatus = '2' WHERE tblh_temporal_conciliar.idestatus = '1'");
    $db->close();

    echo $insertar;
  }


  if($tipoGuardar == "quitar_pago_id"){
    $IdFolio = $_POST['IdFolio'];
   
    $insertar = $db->query("UPDATE tblp_foliospago SET tblp_foliospago.Factura = '4' WHERE tblp_foliospago.IdFolio = '$IdFolio'");
    $db->close();

    echo $insertar;
  }


  if($tipoGuardar == "eliminar_registro_id"){
    $IdTemporal = $_POST["IdTemporal"];
    

    $insertar = $db->query("UPDATE tblh_temporal_conciliar SET tblh_temporal_conciliar._idestatus = '10', tblh_temporal_conciliar.idestatus = '7' WHERE tblh_temporal_conciliar.IdTemporal = '$IdTemporal'");
    $db->close();

    echo $insertar;
  }


  if($tipoGuardar == "sav_tipoPersona"){
    $IdUsua = $_POST["IdUsua"];
    $tipoPersona = $_POST["tipoPersona"];

    $insertar = $db->query("UPDATE tblc_datosfactura SET tblc_datosfactura.tipoPersona = '$tipoPersona', tblc_datosfactura.IdEstatus = '1' WHERE tblc_datosfactura.IdUsua = '$IdUsua'");

    if($tipoPersona == 3){
      $sql_us = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
      $db->rows($sql_us);
      $datos = $db->recorrer($sql_us);
      $Nombre = $datos["Nombre"].' '.$datos["APaterno"].' '.$datos["AMaterno"];
      $insertar = $db->query("UPDATE tblc_datosfactura SET tblc_datosfactura.RFC = 'XAXX010101000', tblc_datosfactura.Razon = '$Nombre', tblc_datosfactura.IdUso = '22', tblc_datosfactura.IdRegimen = '12' WHERE tblc_datosfactura.IdUsua = '$IdUsua'");
    }

    $db->close();
    echo $insertar;
}

if($tipoGuardar == "activa_datos_factura"){
    $IdUsua = $_POST["IdUsua"];

    $insertar = $db->query("UPDATE tblc_datosfactura SET tblc_datosfactura.IdEstatus = '8' WHERE tblc_datosfactura.IdUsua = '$IdUsua'");

    $db->close();
    echo $insertar;
}

if($tipoGuardar == "sav_datos_factura"){
  $tipoPersona = $_POST["tipoPersona"];
  $IdUsua = $_POST["IdUsua"];
  $IdRegimen = $_POST["IdRegimen"];
  $IdUso = $_POST["IdUso"];
  $Razon = $_POST["Razon"];
  $Rfc = $_POST["Rfc"];
  if(($tipoPersona == 1) || ($tipoPersona == 2)){
    $Domicilio = $_POST["Domicilio"];
    $Colonia = $_POST["Colonia"];
    $Exterior = $_POST["Exterior"];
    $Estado = $_POST["Estado"];
    $Municipio = $_POST["Municipio"];
    $CPx = $_POST["CPx"];

    $sql_us = $db->query("SELECT * FROM tblc_postal WHERE tblc_postal.IdPostal = '$Colonia' ");
    $db->rows($sql_us);
    $datos = $db->recorrer($sql_us);
    $_colonia = $datos["Colonia"];


    $insertar = $db->query("UPDATE tblc_datosfactura SET tblc_datosfactura.idcp = '$Colonia', tblc_datosfactura.IdRegimen = '$IdRegimen', tblc_datosfactura.IdUso = '$IdUso', tblc_datosfactura.Razon = '$Razon', tblc_datosfactura.RFC = '$Rfc', tblc_datosfactura.Domicilio = '$Domicilio', tblc_datosfactura.Colonia = '$_colonia', tblc_datosfactura.NoExterior = '$Exterior', tblc_datosfactura.Estado = '$Estado', tblc_datosfactura.Municipio = '$Municipio', tblc_datosfactura.CP = '$CPx', tblc_datosfactura.IdEstatus = '3' WHERE tblc_datosfactura.IdUsua = '$IdUsua'");
  } else {
    $insertar = $db->query("UPDATE tblc_datosfactura SET tblc_datosfactura.IdRegimen = '$IdRegimen', tblc_datosfactura.IdUso = '$IdUso', tblc_datosfactura.Razon = '$Razon', tblc_datosfactura.RFC = '$Rfc', tblc_datosfactura.IdEstatus = '3' WHERE tblc_datosfactura.IdUsua = '$IdUsua'");
  }

  $db->close();
  echo $insertar;
}

if($tipoGuardar == "generar_ofocio_donacion_id"){
    $IdFolio = $_POST["IdFolio"];

    $sql_us = $db->query("SELECT * FROM tblp_foliospago WHERE tblp_foliospago.IdFolio = '$IdFolio' ");
    $db->rows($sql_us);
    $datos = $db->recorrer($sql_us);
    $idCam = $datos['IdCampus'];
    $_IdOferta = $datos['IdOferta'];
    $IdPag = $datos['IdPago'];
    $cadenaNumero = $datos['NoFolio'];
    $pagarAhora = $datos['Monto'];
    $IdUsua = $datos['IdUsua'];
    
    $anio = date("Y");
    $_anio = substr($anio, 2, 2);
  
    $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud = 20;
    $cod =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);
    $mesdia= date("md");
    $hoy = date("YmdHms");
    $numero = $idCam.$_anio.$mesdia."|DLB|".$hoy.'|'.$_IdOferta.'|'.$IdPag.'|'.$cadenaNumero;
    $insertar = $db->query("INSERT INTO tblp_donacion (IdFolio, Folio, Numero, Monto, Code, FecCap, IdUsua) VALUES('$IdFolio','$cadenaNumero','$numero','$pagarAhora','$cod',NOW(),'$IdUsua')");
    

    $db->close();
    echo $insertar;
}




if($tipoGuardar == "del_pago_user"){
  $IdPago = $_POST['IdPago'];
 
  $insertar = $db->query("DELETE FROM tblp_foliospagos WHERE tblp_foliospagos.IdPago = '$IdPago' ");
  $insertar = $db->query("DELETE FROM tblp_pagos WHERE tblp_pagos.IdPago = '$IdPago' ");

  $db->close();

  echo $insertar;
}