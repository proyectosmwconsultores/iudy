<?php
 require('php/clases/class.System.php');
 $db = new Conexion();
 $code = time();
 $IdDocDocente =  $_POST["IdDocDocente"];
 $NoCedula =  $_POST["NoCedula"];

 $_anio = date("Y");
 $_mes = date("m");

 if (is_array($_FILES) && count($_FILES) > 0) {
   $info = new SplFileInfo($_FILES["files3"]['name']);
   $tipox_t =  $info->getExtension();
   $archivo_tit = time().'_U_.'.$tipox_t;
   if (move_uploaded_file($_FILES["files3"]["tmp_name"], "assets/docs/Docentes/$_anio/$_mes/".$archivo_tit)) {
     $insertar = $db->query("UPDATE tblc_docdocentes SET tblc_docdocentes.Archivo = '$archivo_tit', tblc_docdocentes.Numero = '$NoCedula', tblc_docdocentes.Estatus = '2', tblc_docdocentes.FecCap = NOW(), tblc_docdocentes.Anio = '$_anio', tblc_docdocentes.Mes = '$_mes', tblc_docdocentes.Formato = '$tipox_t' WHERE tblc_docdocentes.IdDocDocente = '$IdDocDocente'");
     echo 1;
   } else { echo 0; }
 } else {
   echo 0;
 }
