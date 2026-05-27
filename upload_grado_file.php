<?php
 require('php/clases/class.System.php');
 $db = new Conexion();
 $code = time();
 $Grado =  $_POST["Grado"];
 $Nombre =  $_POST["Nombre"];
 $IdUsua =  $_POST["IdUsua"];
 $Titulo =  $_POST["Titulo"];
 $Cedula =  $_POST["Cedula"];
 $NoCedula =  $_POST["NoCedula"];
 $archivo_tit = '';
 $tipox_t = '';
 $id_esta_tit = 2;

 $archivo_ced = '';
 $tipox_c = '';
 $id_esta_ced = 2;


 $_anio = date("Y");
 $_mes = date("m");

 if($Titulo == 2){
   $info = new SplFileInfo($_FILES["file1"]['name']);
   $tipox_t =  $info->getExtension();
   $archivo_tit = time().'_T_.'.$tipox_t;
   if (move_uploaded_file($_FILES["file1"]["tmp_name"], "assets/docs/Docentes/$_anio/$_mes/".$archivo_tit)) {
     $id_esta_tit = 2;
   } else { $archivo_tit = ''; }
 } else {
   $id_esta_tit = 12;
 }

 if($Cedula == 2){
   $info = new SplFileInfo($_FILES["file2"]['name']);
   $tipox_c =  $info->getExtension();
   $archivo_ced = time().'_C_.'.$tipox_c;
   if (move_uploaded_file($_FILES["file2"]["tmp_name"], "assets/docs/Docentes/$_anio/$_mes/".$archivo_ced)) {
     $id_esta_ced = 2;
   } else { $archivo_ced = ''; }
 } else {
   $id_esta_ced = 12;
 }


 if($Grado == 3){ $IdTipoDocT = 5; }
 if($Grado == 2){ $IdTipoDocT = 6; }
 if($Grado == 1){ $IdTipoDocT = 7; }

 if($Grado == 3){ $IdTipoDocC = 8; }
 if($Grado == 2){ $IdTipoDocC = 9; }
 if($Grado == 1){ $IdTipoDocC = 35; }

 $insertar = $db->query("INSERT INTO tblc_docdocentes (IdUsua, IdTipoDocumento, Archivo, Estatus, FecCap, Anio, Mes, Formato, Nombre, Code) VALUES('$IdUsua','$IdTipoDocT','$archivo_tit','$id_esta_tit',NOW(),'$_anio','$_mes','$tipox_t','$Nombre','$code')");
 $insertar = $db->query("INSERT INTO tblc_docdocentes (IdUsua, IdTipoDocumento, Archivo, Estatus, FecCap, Anio, Mes, Formato, Nombre, Code, Numero) VALUES('$IdUsua','$IdTipoDocC','$archivo_ced','$id_esta_ced',NOW(),'$_anio','$_mes','$tipox_c','$Nombre','$code','$NoCedula')");
 echo 1;
