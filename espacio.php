<?php
ob_start();                                         //====================================================
class Espacio {                                     //= Ultima actualización: 21/05/2019 17:32 p.m.      =
  public function add_envCorreo(){                  //= SF: MWComenius                                   =
    $img = $_FILES['foto']['size'];                 //= (c) 2017 - 2019, Pedro González                  =
    $archivo = "";                                  //====================================================
    $idDep = $_POST["txtDepartamento"];
    if($idDep == 9){
      $TipoEnvio = "3";
      $IdGrupo = $_POST["txtGrupo"];
    } else if($idDep == 10) {
      $TipoEnvio = "3";
      $IdGrupo = "";
    } else {
      $TipoEnvio = $_POST["txtDepartamento"];
      $IdGrupo = "";
    }
    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblp_correo (IdUsua, Asunto, Mensaje, FecCap, Imagen, Tipo, Visto, DeptoDe, DeptoPara, IdUsuaCap, IdDepartamento, IdGrupo)VALUES('".$_POST["IdUsua"]."','".$_POST["txtAsunto"]."','".$_POST["compose-textarea"]."',NOW(),'$archivo','S','1','".$_POST["Permisos"]."','$TipoEnvio','".$_POST["IdUsua"]."','".$_POST["txtDepartamento"]."','$IdGrupo')");
    $IdDesInser = $db->insert_id;

    if($idDep == 9){
    $sqly = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo'");
      while($z = $db->recorrer($sqly)){
        $insertar = $db->query("INSERT INTO tblp_correo (IdUsua, Asunto, Mensaje, FecCap, Imagen, Tipo, Visto, DeptoDe, DeptoPara, IdUsuaCap, IdCorreoPrincipal) VALUES('".$z["IdUsua"]."','".$_POST["txtAsunto"]."','".$_POST["compose-textarea"]."',NOW(),'$archivo','E','1','".$_POST["Permisos"]."','$TipoEnvio','".$_POST["IdUsua"]."','$IdDesInser')");
      }
    } elseif($idDep == 10){
      $insertar = $db->query("INSERT INTO tblp_correo (IdUsua, Asunto, Mensaje, FecCap, Imagen, Tipo, Visto, DeptoDe, DeptoPara, IdUsuaCap, IdCorreoPrincipal)VALUES('".$_POST["txtAlumno"]."','".$_POST["txtAsunto"]."','".$_POST["compose-textarea"]."',NOW(),'$archivo','E','1','".$_POST["Permisos"]."','$TipoEnvio','".$_POST["IdUsua"]."','$IdDesInser')");
    }  else {
      $insertar = $db->query("INSERT INTO tblp_correo (IdUsua, Asunto, Mensaje, FecCap, Imagen, Tipo, Visto, DeptoDe, DeptoPara, IdUsuaCap, IdCorreoPrincipal)VALUES('".$_POST["IdUsua"]."','".$_POST["txtAsunto"]."','".$_POST["compose-textarea"]."',NOW(),'$archivo','E','1','".$_POST["Permisos"]."','$TipoEnvio','".$_POST["IdUsua"]."','$IdDesInser')");
    }
    if ($insertar) {
      $_SESSION['Alerta']="1";
      echo "<script type='text/javascript'>window.location='miSend.php';</script>";
    } else {
      $_SESSION['Alerta']="0";
      echo "<script type='text/javascript'>window.location='miBuzCrear.php';</script>";
    }
  }

  public function add_respuesta(){
    $db = new Conexion();
    $sql9 = $db->query("SELECT * FROM tblp_correo WHERE tblp_correo.IdCorreo =  '".$_POST["IdCorreo"]."'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $rwIdUsua = $datos91["IdUsua"];
    $rwAsunto = $datos91["Asunto"];
    $rwMensaje = $datos91["Mensaje"];
    $rwDe = $datos91["DeptoDe"];
    $rwPara = $datos91["DeptoPara"];
    $rwIdCorroPrincipal = $datos91["IdCorreoPrincipal"];

    $insertar = $db->query("INSERT INTO tblp_correo (IdUsua, Asunto, Mensaje, FecCap, Tipo, Visto, Respuesta, IdCorreoAnterior, DeptoDe, DeptoPara, IdUsuaCap,IdCorreoPrincipal) VALUES('".$_POST["IdUsua"]."','$rwAsunto','".$_POST["inputExperience"]."',NOW(),'S','1','SI','".$_POST["IdCorreo"]."','$rwPara','$rwDe','".$_POST["IdUsua"]."','$rwIdCorroPrincipal')");
    $IdDesInser = $db->insert_id;
    $insertar = $db->query("UPDATE tblp_correo SET tblp_correo.IdCorreoAnterior = '$IdDesInser', tblp_correo.Respuesta = 'SI' WHERE tblp_correo.IdCorreo = '".$_POST["IdCorreo"]."'");
    $insertar = $db->query("INSERT INTO tblp_correo (IdUsua, Asunto, Mensaje, FecCap, Tipo, Visto, Respuesta, IdCorreoAnterior, DeptoDe, DeptoPara, IdUsuaCap,IdCorreoPrincipal)VALUES('$rwIdUsua','$rwAsunto','$rwMensaje',NOW(),'E','1','SI','$IdDesInser','$rwPara','$rwDe','".$_POST["IdUsua"]."','$rwIdCorroPrincipal')");
    if ($insertar) {
      $_SESSION['Alerta']="1";
      echo "<script type='text/javascript'>window.location='miSend.php';</script>";

    } else {
      $_SESSION['Alerta']="0";
      echo "<script type='text/javascript'>window.location='miBuzCrear.php';</script>";
    }
  }

  public function add_comPago(){
    $Id = $_POST["IdPago"];
    $Idx = "CPAGO-".$_POST["IdUsua"]."-".$Id."-";
    $variable = "txtPago-".$Id;
    $carpeta = "assets/docs/Pagos/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
		$archivo = $_FILES[$variable]['name']; //nombre del archivo
		$tamaño = $_FILES[$variable]['size']; //tamaño del archivo

    $archivo = time().'_'.$archivo;

		if(!move_uploaded_file($_FILES[$variable]['tmp_name'], $carpeta.$archivo)){
      $_SESSION['Alerta']="0";
      echo "<script type='text/javascript'>window.location='misPagos.php';</script>";
      exit();
    }
    $db = new Conexion();
    $sql9 = $db->query("SELECT * FROM tblh_detallepagos WHERE tblh_detallepagos.IdPago = '$Id'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdDetallePag = $datos91["IdDetallePagos"];
    if($IdDetallePag){
      $insertar = $db->query("DELETE FROM tblh_detallepagos WHERE tblh_detallepagos.IdPago = '$Id'");
      // $insertar = $db->query("UPDATE tblh_detallepagos SET tblh_detallepagos.Estatus = '7', tblh_detallepagos.Visto = '0'  WHERE tblh_detallepagos.IdPago = '$Id'");
    }
    $insertar = $db->query("INSERT INTO tblh_detallepagos (IdUsua, IdPago, Archivo, FecCap, Estatus, Visto) VALUES('".$_POST["IdUsua"]."', '$Id','$archivo',NOW(),'2','1')");
    if($insertar){
      // $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '2' WHERE tblp_pagos.IdPago = '$Id'");
    }

    $sql4 = $db->query("SELECT tblp_docs_solicitados.IdDocumento FROM tblp_docs_solicitados WHERE tblp_docs_solicitados.IdPago =  '$Id' ");
    $db->rows($sql4);
    $datos41 = $db->recorrer($sql4);
    $IdDocss = $datos41["IdDocumento"];

    if($IdDocss){
      $insertar = $db->query("UPDATE tblp_docs_solicitados SET tblp_docs_solicitados.IdVisto = '0', tblp_docs_solicitados.IdEstatus = '3', tblp_docs_solicitados.FecSubida = NOW(), tblp_docs_solicitados.Archivo = '$archivo'  WHERE tblp_docs_solicitados.IdDocumento = '$IdDocss'");
    }
		if ($insertar) {
      // $sql8 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '".$_POST["IdUsua"]."'");
      // $db->rows($sql8);
      // $datos8 = $db->recorrer($sql8);
      // $Alumno = $datos8["Nombre"].' '.$datos8["APaterno"].' '.$datos8["AMaterno"];
      // $idO = $datos8["IdOferta"];
      //
      // $sql7 = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$idO'");
      // $db->rows($sql7);
      // $datos7 = $db->recorrer($sql7);
      // $OfertaEduca = $datos8["Nombre"];
      //
      // $sql22 = $db->query("SELECT * FROM tblp_configuracion WHERE tblp_configuracion.IdConfig = '17' ");
      // $db->rows($sql22);
      // $datos221 = $db->recorrer($sql22);
      // $url = $datos221["Descripcion"];
      // $linkLogo = $url.'assets/images/campus/logo_inicio.png';
      // $Code = uniqid();
      // $destinatario = "pedro.goca@hotmail.com";
      // $asunto = "Registro de pago - ".$Code;
      // $cuerpo = "
      // <html>
      // <head>
      //    <title>Registro pago</title>
      // </head>
      // <body>
      // 	<table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
      //     <tr>
      //         <td colspan='3' height='100' align='center'>
      //         <b style='color:#FE9900; font-size:24px; text-align: center; font-family:Century Gothic,Arial;'>
      //           <img src= '$linkLogo' >
      //         </b></td>
      //     </tr>
      //     <tr style='background: #3b5868; color: #fff;'>
      //         <td colspan='3' height='100' align='center'>
      //         <b style='color:#fff; font-size:14px; text-align: center; font-family:Century Gothic,Arial;'>
      //         Se ha ingresado un nuevo pago
      //         </b></td>
      //     </tr>
  		// 	  <tr>
      //     <td colspan='3' style='background: #3b5868; color: #fff;'>
      //       <table border='0' cellpadding='0' width='100%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
      //         <tr>
      //           <td style=' text-align: right; padding: 10px;'>  Alumno: </td><td style='padding: 10px;'> <b>  ";  $cuerpo .= $Alumno." </b></td>
      //         </tr>
      //         <tr>
      //           <td style=' text-align: right; padding: 10px;'>  Oferta educativa: </td><td style='padding: 10px;'> <b>  ";  $cuerpo .= htmlentities($OfertaEduca)." </b></td>
      //         </tr>
      //       </table>
  		// 		</td>
      //     </tr>
      // 	</table>";
      // $headers = "MIME-Version: 1.0\r\n";
      // $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
      // $headers .= "From: Registro de pago - $Code <info@hotmail.com.mx>\r\n";
      // $headers .= "Bcc: pedroo.goca@gmail.com\r\n";
      // mail($destinatario,$asunto,$cuerpo,$headers);

      $_SESSION['Alerta']="1";
			echo "<script type='text/javascript'>window.location='misPagos.php';</script>";
		} else {
      $_SESSION['Alerta']="0";
			echo "<script type='text/javascript'>window.location='misPagos.php';</script>";
		}
  }

  public function get_docs_sol() {
   $db = new Conexion();
   $get_docs_sol = [];

   $sql = $db->query("SELECT tblp_docs_solicitados.IdDocumento FROM tblp_docs_solicitados WHERE tblp_docs_solicitados.IdEstatus =  '3' AND tblp_docs_solicitados.IdVisto = '0' ");
   while($x = $db->recorrer($sql)){
     $get_docs_sol[] = $x;
   }
   return $get_docs_sol;
 }

  public function add_comPagoSaldo(){
    $Id = $_POST["IdSaldo"];
    $carpeta = "assets/docs/Saldos/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)

    $info = new SplFileInfo($_FILES["txtPagoSaldo"]['name']);
    $tipox_t =  $info->getExtension();
    $archivo = $_POST["IdUsua"].'_'.time().'.'.$tipox_t;

		if(!move_uploaded_file($_FILES['txtPagoSaldo']['tmp_name'], $carpeta.$archivo)){
      $_SESSION['Alerta']="0";
      echo "<script type='text/javascript'>window.location='misPagos.php';</script>";
      exit();
    }
    $db = new Conexion();


    $insertar = $db->query("INSERT INTO tblh_saldoimg (IdSaldo, IdUsua, Imagen, IdEstatus, FecCap)VALUES('$Id','".$_POST["IdUsua"]."','$archivo','2',NOW())");

		if ($insertar) {
      $_SESSION['Alerta']="1";
			echo "<script type='text/javascript'>window.location='misPagos.php';</script>";
		} else {
      $_SESSION['Alerta']="0";
			echo "<script type='text/javascript'>window.location='misPagos.php';</script>";
		}
  }

  public function add_documentoDoc(){
    $TipoDoc = $_POST["txtTipoDoc"];
    $IdUsua = $_POST["IdUsua"];
    $anio = date('Y');
    $mes = date('m');
    $dir_anio = "assets/docs/Docentes/$anio/";
    $dir_mes = "assets/docs/Docentes/$anio/$mes/";
    // if (!file_exists($dir_anio)) { mkdir($dir_anio, 0777, true); }
    // if (!file_exists($dir_mes)) { mkdir($dir_mes, 0777, true); }

    $carpeta = $dir_mes; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
		$archivo = $_FILES["txtDocumento"]['name']; //nombre del archivo
		$tamaño = $_FILES["txtDocumento"]['size']; //tamaño del archivo
    $archivo = time().'_'.$archivo;
    $info = new SplFileInfo($_FILES["txtDocumento"]['name']);
    $tipox =  $info->getExtension();

		if(!move_uploaded_file($_FILES["txtDocumento"]['tmp_name'], $carpeta.$archivo)){
      $_SESSION['Alerta']="0";
			echo "<script type='text/javascript'>window.location='misDocDocente.php';</script>";
      exit();
    }
    $db = new Conexion();

    $insertar = $db->query("INSERT INTO tblc_docdocentes (IdUsua, IdTipoDocumento, Archivo, Estatus, FecCap, Anio, Mes, Formato) VALUES('".$_POST["IdUsua"]."','".$_POST["txtTipoDoc"]."','$archivo','2',NOW(),'$anio','$mes','$tipox')");
		if ($insertar) {
      $_SESSION['Alerta']="1";
			echo "<script type='text/javascript'>window.location='misDocDocente.php';</script>";
		} else {
      $_SESSION['Alerta']="0";
			echo "<script type='text/javascript'>window.location='misDocDocente.php';</script>";
		}
  }

  public function add_reconoxc(){
    $IdUsua = $_POST["IdUsua"];
    $Fecha = $_POST["txt_fecha"];
    $NomDoc = $_POST["txt_nombre"];
    $IdUsua = $_POST["IdUsua"];
    $archivo = $_FILES["txtDocumento"]['name']; //nombre del archivo
    $archivo = time().'_'.$archivo;
    $_anio = date("Y");
    $_aniomes = date("m");
    $info = new SplFileInfo($_FILES["txtDocumento"]['name']);
    $tipox =  $info->getExtension();

    // $anio = date('Y');
    // $mes = date('m');
    // $dir_anio = "assets/docs/Docentes/$anio/";
    // $dir_mes = "assets/docs/Docentes/$anio/$mes/";
    // if (!file_exists($dir_anio)) { mkdir($dir_anio, 0777, true); }
    // if (!file_exists($dir_mes)) { mkdir($dir_mes, 0777, true); }

    // $carpeta = $dir_mes; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
		// $archivo = $_FILES["txtDocumento"]['name']; //nombre del archivo
		// $tamaño = $_FILES["txtDocumento"]['size']; //tamaño del archivo
    // $archivo = time().'_'.$archivo;
    // $info = new SplFileInfo($_FILES["txtDocumento"]['name']);
    // $tipox =  $info->getExtension();

    // if(!move_uploaded_file($_FILES["txtDocumento"]['tmp_name'], $carpeta.$archivo)){
		if(!move_uploaded_file($_FILES["txtDocumento"]["tmp_name"], "assets/docs/files/$_anio/$_aniomes/".$archivo)){
      $_SESSION['Alerta']="0";
			echo "<script type='text/javascript'>window.location='mi_reconocimiento.php';</script>";
      exit();
    }
    $db = new Conexion();

    $insertar = $db->query("INSERT INTO tblp_reconocimiento (IdTipo, IdUsua, Fecha, FecCap, Anio, Mes, Archivo, IdUsuaCap, Formato, Texto) VALUES ('6','$IdUsua','$Fecha',NOW(),'$_anio','$_aniomes','$archivo','$IdUsua','$tipox','$NomDoc') ");

		if ($insertar) {
      $_SESSION['Alerta']="1";
			echo "<script type='text/javascript'>window.location='mi_reconocimiento.php';</script>";
		} else {
      $_SESSION['Alerta']="0";
			echo "<script type='text/javascript'>window.location='mi_reconocimiento.php';</script>";
		}
  }

  public function add_alumGrupo(){
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdGrupo = '".$_POST["txtGrupo"]."' WHERE tblc_usuario.IdUsua = '".$_POST["Id"]."'");
    $id = $_POST["Id"];
    $var = uniqid(); $var2 = uniqid(); $var3 = uniqid(); $var4 = uniqid();
    $tok = $var.$var2.$var3.$var4.$id;
		if ($insertar) {
      $_SESSION['Alerta']="1";
			echo "<script type='text/javascript'>window.location='adConfigAlumno.php?Id=$tok';</script>";
		} else {
      $_SESSION['Alerta']="0";
			echo "<script type='text/javascript'>window.location='adConfigAlumno.php?Id=$tok';</script>";
		}
  }

  public function add_asigModulo(){
    $IdUsua = $_POST["Id"];
    $db = new Conexion();

    $sql8 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.Id = '".$_POST["IdAsig"]."'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $IdAsignacion = $datos81["IdAsignacion"];
    $IdDocMod = $datos81["IdUsua"];
    $IdCicloN = $datos81["IdCiclo"];

    $sql9v = $db->query("SELECT * FROM tblp_reincorporacion WHERE tblp_reincorporacion.IdUsua = '$IdUsua' AND tblp_reincorporacion.IdCiclo = '$IdCicloN'");
    $db->rows($sql9v);
    $datos91v = $db->recorrer($sql9v);
    $rwIdReinc = $datos91v["IdReincorporacion"];
    if($rwIdReinc){ $condIn = ", Inicio"; $condFi = ", 'REI'"; } else { $condIn = " "; $condFi = " "; }

    $sql7 = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' GROUP BY tblp_moduloalumno.IdAsignacion");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $IdEducativa = $datos71["IdEducativa"];
    $IdModulo = $datos71["IdModulo"];
    $Grupo = $datos71["Grupo"];
    $IdGrupo = $datos71["IdGrupo"];
    $EstatusMod = $datos71["Estatus"];

    if($EstatusMod == "Finalizado"){
      $tabCond = ", IdDocente";
      $datCond = ", '$IdDocMod'";
    } else {
      $tabCond = " ";
      $datCond = " ";
    }

    $sql9 = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdModulo =  '$IdModulo'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $semcua = $datos91["Grado"];

    $code = md5(rand() * time());
    $IdModAlum = $code;

    $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo $condIn) VALUES ('$IdEducativa','$IdModulo','$Grupo','$IdUsua','$EstatusMod',NOW(),'$IdAsignacion','$IdGrupo' $condFi)");

    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.SemCua = '$semcua'  WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $anio = date("Y");
    $mes = date("m");
    $sqly = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.IdAsignacion, tblp_tareas.IdAlumno, tblp_tareas.IdActividadesDocente, tblp_tareas.IdParcialDocente, tblp_actividadesdocente.IdTipoActividad FROM tblp_tareas Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdActividadesDocente = tblp_tareas.IdActividadesDocente WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' GROUP BY tblp_tareas.IdActividadesDocente");
    while($z = $db->recorrer($sqly)){
      $IdTipoA = $z["IdTipoActividad"];
      $IdActividad = $z["IdActividadesDocente"];
      $IdParcial = $z["IdParcialDocente"];

    $sql1e = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, Visto, IdEditor, IdActividadesDocente, IdParcialDocente) VALUES ('$IdAsignacion','$IdUsua','1','$IdT','$IdActividad','$IdParcial')");
    $IdTx = $db->insert_id;
    if($IdTipoA == 1){
      $sql2 = $db->query("INSERT INTO tblp_examusuario (IdTarea, IdAsignacion, IdParcialDocente, IdActividadesDocente, IdUsua, IdEstatus) VALUES('$IdTx','$IdAsignacion','$IdParcial','$IdActividad','$IdUsua','12')");
    } else {
       $sql2 = $db->query("INSERT INTO tblp_editor (IdTarea, IdActividadesDocente, IdParcialDocente, IdUsua, IdPermiso, IdAsignacion, Anio, Mes, IdEstatus) VALUES ('$IdTx','$IdActividad','$IdParcial','$IdUsua','3','$IdAsignacion','$anio','$mes','12')");
    }

      //$insertar = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, NoActividad, Visto) VALUES ('$IdAsignacion','$IdUsua','$NoActiv','0')");
    }

    $var = uniqid(); $var2 = uniqid(); $var3 = uniqid(); $var4 = uniqid();
    $tok = $var.$var2.$var3.$var4.$IdUsua;
    if ($insertar) {
      $_SESSION['Alerta']="1";
      echo "<script type='text/javascript'>window.location='adConfigAlumno.php?Id=$tok';</script>";
    } else {
      $_SESSION['Alerta']="0";
      echo "<script type='text/javascript'>window.location='adConfigAlumno.php?Id=$tok';</script>";
    }
  }
  public function add_video(){
    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblp_videos (IdAsignacion, IdUsua, Titulo, Link, Estatus, FecCap, Tipo, IdDatosM) VALUES('".$_POST["Id"]."','".$_POST["IdUsua"]."','".$_POST["txtTitulo"]."','','1',NOW(),'','".$_POST["IdDatosM"]."')");
		if ($insertar) {
      $_SESSION['Alerta']="1";
			echo "<script type='text/javascript'>window.location='doSelDatosM.php';</script>";
		} else {
      $_SESSION['Alerta']="0";
			echo "<script type='text/javascript'>window.location='doSelDatosM.php';</script>";
		}
  }

  public function add_docAlumno(){
    $Tramite = $_POST["Tramite"];
    $TipoDoc = $_POST["txtTipoDoc"];
    $IdUsua = $_POST["IdUsua"];
    $anio = date("Y");
    $mes = date("m");
    if($Tramite == "SS"){
      $carpeta = "assets/docs/ServicioSocial/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
      $archivo = $_FILES["txtDocumento"]['name']; //nombre del archivo
      $tamaño = $_FILES["txtDocumento"]['size']; //tamaño del archivo
      $code = md5(rand() * time());
      $archivo = $code .'-'.$IdUsua.'-'.$TipoDoc.'-'.$archivo;
      if(!move_uploaded_file($_FILES["txtDocumento"]['tmp_name'], $carpeta.$archivo)){
        $_SESSION['Alerta']="0";
        echo "<script type='text/javascript'>window.location='misServicios.php';</script>";
        exit();
      }
      $db = new Conexion();
      $insertar = $db->query("INSERT INTO tblc_doctramite (IdUsua, IdTipoDocumento, Archivo, Estatus, FecCap, Visto, Tipo) VALUES('".$_POST["IdUsua"]."','".$_POST["txtTipoDoc"]."','$archivo','2',NOW(),'1','33')");
      if ($insertar) {
        $_SESSION['Alerta']="1";
        echo "<script type='text/javascript'>window.location='misServicios.php';</script>";
      } else {
        $_SESSION['Alerta']="0";
        echo "<script type='text/javascript'>window.location='misServicios.php';</script>";
      }
    } else {
      $carpeta = "assets/docs/files/$anio/$mes/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
      $archivo = $_FILES["txtDocumento"]['name']; //nombre del archivo
      $tamaño = $_FILES["txtDocumento"]['size']; //tamaño del archivo
      $code = md5(rand() * time());
      $archivo = $code .'-'.$IdUsua.'-'.$TipoDoc.'-'.$archivo;
      if(!move_uploaded_file($_FILES["txtDocumento"]['tmp_name'], $carpeta.$archivo)){
        $_SESSION['Alerta']="0";
        echo "<script type='text/javascript'>window.location='misDocumentos.php';</script>";
        exit();
      }
      $db = new Conexion();
      $sql7 = $db->query("SELECT tblc_docalumnos.IdDocAlumno FROM tblc_docalumnos WHERE tblc_docalumnos.IdTipoDocumento =  '$TipoDoc' AND tblc_docalumnos.Estatus <>  '5' AND tblc_docalumnos.IdUsua = '$IdUsua'");
      $db->rows($sql7);
      $datos71 = $db->recorrer($sql7);
      $IdDocX = $datos71["IdDocAlumno"];
      if($IdDocX){ $IdDoc = 0; } else { $IdDoc = 1; }
      $sql6 = $db->query("SELECT tblc_usuario.NoDoc FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
      $db->rows($sql6);
      $datos61 = $db->recorrer($sql6);
      $NoDoc = $datos61["NoDoc"];
      $NoDocv = $NoDoc + $IdDoc;
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Archivo, Estatus, FecCap, Visto, Anio, Mes) VALUES('".$_POST["IdUsua"]."','".$_POST["txtTipoDoc"]."','$archivo','2',NOW(),'1','$anio','$mes')");
      if($NoDocv <= 5){
          $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.NoDoc = '$NoDocv' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
      }
      if ($insertar) {
        $_SESSION['Alerta']="1";
        echo "<script type='text/javascript'>window.location='misDocumentos.php';</script>";
      } else {
        $_SESSION['Alerta']="0";
        echo "<script type='text/javascript'>window.location='misDocDocente.php';</script>";
      }
    }
  }

  public function add_doc_tramite(){
    $IdDocAlumno = $_POST["txtTipoDoc"];
    $IdUsua = $_POST["IdUsua"];
    $anio = date("Y");
    $mes = date("m");

      $carpeta = "assets/docs/files/$anio/$mes/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
      $archivo = $_FILES["txtDocumento"]['name']; //nombre del archivo
      $tamaño = $_FILES["txtDocumento"]['size']; //tamaño del archivo
      $code = md5(rand() * time());
      $archivo = time().'_'.$archivo;
      if(!move_uploaded_file($_FILES["txtDocumento"]['tmp_name'], $carpeta.$archivo)){
        $_SESSION['Alerta']="0";
        echo "<script type='text/javascript'>window.location='misTramites.php';</script>";
        exit();
      }
      $db = new Conexion();

      $insertar = $db->query("UPDATE tblc_docalumnos SET tblc_docalumnos.Estatus = '59', tblc_docalumnos.Archivo = '$archivo', tblc_docalumnos.FecCap = NOW(), tblc_docalumnos.Anio = '$anio', tblc_docalumnos.Mes = '$mes' WHERE tblc_docalumnos.IdDocAlumno = '$IdDocAlumno' ");
      if ($insertar) {
        $_SESSION['Alerta']="1";
        echo "<script type='text/javascript'>window.location='misTramites.php';</script>";
      } else {
        $_SESSION['Alerta']="0";
        echo "<script type='text/javascript'>window.location='misTramites.php';</script>";
      }

  }

  public function add_docBaja(){
    $TipoDoc = $_POST["txtTipoDoc"];
    $IdUsua = $_POST["IdUsua"];
    $carpeta = "assets/docs/Baja/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtDocumento"]['name']; //nombre del archivo
    $tamaño = $_FILES["txtDocumento"]['size']; //tamaño del archivo
    $code = md5(rand() * time());
    $archivo = $code .'-'.$IdUsua.'-'.$TipoDoc.'-'.$archivo;
    if(!move_uploaded_file($_FILES["txtDocumento"]['tmp_name'], $carpeta.$archivo)){
      $_SESSION['Alerta']="0";
      echo "<script type='text/javascript'>window.location='miBaja.php';</script>";
      exit();
    }
    $db = new Conexion();
    $insertar = $db->query("INSERT INTO tblc_doctramite (IdUsua, IdTipoDocumento, Archivo, Estatus, FecCap, Visto,Tipo) VALUES('".$_POST["IdUsua"]."','".$_POST["txtTipoDoc"]."','$archivo','2',NOW(),'1','45')");
    if ($insertar) {
      $_SESSION['Alerta']="1";
      echo "<script type='text/javascript'>window.location='miBaja.php';</script>";
    } else {
      $_SESSION['Alerta']="0";
      echo "<script type='text/javascript'>window.location='miBaja.php';</script>";
    }
  }

  public function add_docAlumnoR(){
    $anio=date("Y");
    $mes=date("m");
    $TipoDoc = $_POST["txtTipoDoc"];
    $IdUsua = $_POST["IdUsua"];

    $carpeta = "assets/docs/files/$anio/$mes/";
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
    }

    $carpeta = "assets/docs/files/$anio/$mes/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["txtDocumento"]['name']; //nombre del archivo
    $archivo = time().'_'.$archivo;
    if(!move_uploaded_file($_FILES["txtDocumento"]['tmp_name'], $carpeta.$archivo)){
      $_SESSION['Alerta']="0";
      echo "<script type='text/javascript'>window.location='registroDoc.php'</script>";
      exit();
    }
    $db = new Conexion();
     $nombre_fichero = $carpeta.$archivo;

     if (file_exists($nombre_fichero)) {


       $sql5 = $db->query("SELECT tblh_tipodocumento.Grado FROM tblh_tipodocumento WHERE tblh_tipodocumento.IdTipoDoc =  '$TipoDoc'");
       $db->rows($sql5);
       $datos51 = $db->recorrer($sql5);
       $IdGrado = $datos51['Grado'];

       $sql8 = $db->query("SELECT Sum(tblh_tipodocumento.IdTipoDoc) FROM tblh_tipodocumento WHERE tblh_tipodocumento.Grado = '$IdGrado'");
       $db->rows($sql8);
       $datos81 = $db->recorrer($sql8);
       $noDocs = $datos81[0];

       $sql7 = $db->query("SELECT tblc_docalumnos.IdDocAlumno FROM tblc_docalumnos WHERE tblc_docalumnos.IdTipoDocumento =  '$TipoDoc' AND tblc_docalumnos.IdUsua = '$IdUsua'");
       $db->rows($sql7);
       $datos71 = $db->recorrer($sql7);
       $IdDocX = $datos71["IdDocAlumno"];
       if($IdDocX){ $IdDoc = 0; } else { $IdDoc = 1; }

       $sql6 = $db->query("SELECT tblc_usuario.NoDoc FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
       $db->rows($sql6);
       $datos61 = $db->recorrer($sql6);
       $NoDoc = $datos61["NoDoc"];
       $NoDocv = $NoDoc + $IdDoc;

       $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Archivo, Estatus, FecCap, Anio, Mes)VALUES ('$IdUsua','$TipoDoc','$archivo','2',NOW(),'$anio','$mes')");

       if($NoDocv <= $noDocs){

           $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.NoDoc = '$NoDocv' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
       }

       $_SESSION['Alerta']="1";
       echo "<script type='text/javascript'>window.location='registroDoc.php';</script>";
     }
     $_SESSION['Alerta']="0";
     echo "<script type='text/javascript'>window.location='registroDoc.php';</script>";

  }

  public function add_matIndividual($IdUsua){
    $anio = date("Y");
    $annio = substr($anio, 2, 2);

    $db = new Conexion();
    $sql3 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);
    $IdOferta = $datos31["IdOferta"];
    $IdGrupo = $datos31["IdGrupo"];

    $sql5 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $IdGrado = $datos51['IdGrado'];

    if($IdGrado == "1") { $TipoNom = "Doctorado"; } elseif($IdGrado == "2") { $TipoNom = "Maestria"; } elseif($IdGrado == "3") { $TipoNom = "Licenciatura"; }elseif($IdGrado == "4") { $TipoNom = "Diplomado"; }elseif($IdGrado == "5") { $TipoNom = "Curso";}

    $sql2 = $db->query("SELECT * FROM tblp_configuracion WHERE tblp_configuracion.Nombre = '$TipoNom'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $Tipo = $datos21["Descripcion"];

    $sql9 = $db->query("SELECT Count(tblc_matricula.Numero) AS numTotal FROM tblc_matricula WHERE tblc_matricula.Anio =  '$anio' AND tblc_matricula.IdGrado = '$IdGrado'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $numero = $datos91["numTotal"];

    $numero = $numero + 1;
    $mat = str_pad($numero,4,"0",STR_PAD_LEFT);
    $matricula = $Tipo.$annio.$mat;
    $insertar = $db->query("INSERT INTO tblc_matricula (Anio, Numero, Matricula, IdUsua, IdGrado, IdOferta, IdGrupo ) VALUES ('$anio','$numero','$matricula','$IdUsua','$IdGrado','$IdOferta','$IdGrupo')");
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Matricula = '$matricula' WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $valor = 5;

    if ($insertar) {
      $_SESSION['Alerta']="5";
      echo "<script type='text/javascript'>window.location='adConfigMatr.php';</script>";
    } else {
      $_SESSION['Alerta']="6";
      echo "<script type='text/javascript'>window.location='adConfigMatr.php';</script>";
    }
  }

  public function del_prospecto(){
    $db = new Conexion();
    $sql6 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '".$_POST["IdAlumno"]."'");
    $db->rows($sql6);
    $datos61 = $db->recorrer($sql6);
    $insertar = $db->query("INSERT INTO tblh_prospectos (IdUsua, Nombre, APaterno, AMaterno, Cargo, Tipo, Telefono, Correo, Usuario, Pass_php, FecAlta, Permisos, FecCap, Estado, Estatus, Foto, IdOferta, Sexo, FecNac, Code, IdGrupo, Matricula, Visto, Documentos, GPago, NoDoc) VALUES ('".$datos61[0]."','".$datos61[1]."','".$datos61[2]."','".$datos61[3]."','".$datos61[4]."','".$datos61[5]."','".$datos61[6]."','".$datos61[7]."','".$datos61[8]."','".$datos61[9]."','".$datos61[10]."','".$datos61[11]."','".$datos61[12]."','".$datos61[13]."','".$datos61[14]."','".$datos61[15]."','".$datos61[16]."','".$datos61[17]."','".$datos61[18]."','".$datos61[19]."','".$datos61[21]."','".$datos61[22]."','".$datos61[23]."','".$datos61[24]."','".$datos61[25]."','".$datos61[26]."')");
    $insertar = $db->query("DELETE FROM tblc_usuario WHERE tblc_usuario.IdUsua = '".$_POST["IdAlumno"]."'");
    if ($insertar) {
      $_SESSION['Alerta']="1";
      echo "<script type='text/javascript'>window.location='ctrlProspectos.php';</script>";
    } else {
      $_SESSION['Alerta']="0";
      echo "<script type='text/javascript'>window.location='ctrlProspectos.php';</script>";
    }
  }

  public function acept_prospecto(){
    $db = new Conexion();
    $IdAlumno = $_POST["IdAlumno"];
    $apkKey = 'bTzZxWjN0hsYO5rG';
    $mailUni = 'info@universida.mx';


    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Valor = '1', tblc_usuario.Documentos = 'SI', tblc_usuario.Estatus = 'Completo', tblc_usuario.IdEstatus = '8'  WHERE tblc_usuario.IdUsua = '$IdAlumno'");
    $sql1 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdAlumno'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $code = $datos2["Code"];
    $fol = $datos2["Folio"];
    $correo = $datos2["Correo"];
    $IdEduca = $datos2["IdOferta"];
    $idCam = $datos2["IdCampus"];
    $destinatario = $datos2["Correo"];
    $Nombre = $datos2["Nombre"].' '.$datos2["APaterno"].' '.$datos2["AMaterno"];

    $sql2 = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdEduca'");
    $db->rows($sql2);
    $datos3 = $db->recorrer($sql2);
    $OfertaEduca = $datos3["Nombre"];

    $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
    $db->rows($sql_camp);
    $_camp = $db->recorrer($sql_camp);
    $url = $_camp["Link"];
    $Institucion = $_camp["Campus"];

    $linkLogo = $url.'assets/images/campus/logo_inicio.png';
    $linkClicImg = $url.'assets/images/click.png';

    require('Mailin.php');
    $mailin = new Mailin("https://api.sendinblue.com/v2.0","$apkKey");
    $data = array( "to" => array("$destinatario"=>" $Nombre "),
    			"from" => array("$mailUni"," $Institucion"),
    			"subject" => "Felicidades, estas a un paso de formar parte de $Institucion",
    			"text" => "Plataforma de Educación en Linea MWComenius | $Institucion",

    			"html" =>  "<img src=\"{myinlineimage1.png}\" alt=\"-\" border=\"1\">
    					   <table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
            <tr>
                <td colspan='3' height='100' align='center'>
                <b style=' color: rgb(105, 108, 110); font-size:24px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                  <img src= '$linkLogo' >
                </b></td>
            </tr>

            <tr style='color: #676a8f;'>
                <td colspan='3' height='100' align='center'><br>
                <p style='color: #676a8f; font-size:14px; padding: 5px; text-align: justify; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Nuestro compromiso, es de estar siempre a la vanguardia y cumpliendo con nuestra filosof&iacute;a institucional <b>con sentido humano y visi&oacute;n global sustentable</b>, nos permiten ofrecerte esta Plataforma Tecnol&oacute;gica Educativa MWComenius, para que contin&uacute;es con tus estudios profesionales y logres alcanzar todas tus metas.<br><br>
                </p></td>
            </tr>
    			  <tr>
            <td colspan='3' style='color: #676a8f;'>
              <table border='0' cellpadding='0' width='100%' style='border-collapse: collapse; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; '>
                <tr>
                  <td colspan='2' style=' text-align: center; font-size: 16px; color: red; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                  <b style='color: #676a8f; font-size:16px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                  Favor de revisar su estatus financiero <br> Espacio > Estatus Financiero</b>
                  </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Alumno: </td><td style='padding: 10px;'> $Nombre </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Oferta educativa: </td><td style='padding: 10px;'> $OfertaEduca </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Usuario: </td><td style='padding: 10px;'> $correo </td>
                </tr>
                <tr>
                  <td style=' text-align: right; padding: 10px; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>  Password: </td><td style='padding: 10px;'> $code </td>
                </tr>
              </table>
    				</td>
            </tr>
            <tr style='color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:14px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                Para ingresar a la Plataforma de Educaci&oacute;n en L&iacute;nea MWComenius<br><br>
                <a href='$url'>
                  HAZ CLICK AQU&Iacute;
                </a>
                </b><br>
                <b style=' color: rgb(105, 108, 110); font-size:24px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>
                <a href='$url'>
                  <img src= '$linkClicImg' >
                </a>
                </b>
                </td>
            </tr>
            <tr style='color: #676a8f;'>
                <td colspan='3' height='100' align='center'>
                <b style='color: #676a8f; font-size:12px; text-align: center; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;'>

                </b>
                </td>
            </tr>
        	</table>",

    			"attachment" => array(),
    			"headers" => array("Content-Type"=> "text/html; charset=iso-8859-1","X-param1"=> "value1", "X-param2"=> "value2","X-Mailin-custom"=>"my custom value", "X-Mailin-IP"=> "102.102.1.2", "X-Mailin-Tag" => "My tag"),
    			"inline_image" => array('myinlineimage1.png' => "your_png_files_base64_encoded_chunk_data",'myinlineimage2.jpg' => "your_jpg_files_base64_encoded_chunk_data")
    );

    $mailin->send_email($data);
    if ($mailin) {
      $_SESSION['Alerta']="4";
      echo "<script type='text/javascript'>window.location='ctrlProspectos.php';</script>";
    } else {
      $_SESSION['Alerta']="5";
      echo "<script type='text/javascript'>window.location='ctrlProspectos.php';</script>";
    }
  }

  public function get_mailEnviado($IdUsua,$IdPermiso) {
    if($IdPermiso == 3){
      $cond = " AND tblp_correo.IdUsua = '$IdUsua' ";
    } else {
      $cond = "";
    }
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_correo.IdCorreo, tblp_correo.IdUsua, tblp_correo.Asunto, tblp_correo.Mensaje, tblp_correo.FecCap, tblp_correo.Visto, tblp_correo.Imagen, tblp_correo.Respuesta, tblp_correo.DeptoPara, tblp_correo.IdDepartamento, tblp_correo.IdGrupo, tblc_departamento.NomDepartamento AS Para FROM tblp_correo Left Join tblc_departamento ON tblc_departamento.IdDepartamento = tblp_correo.DeptoPara WHERE tblp_correo.Tipo =  'S' AND tblp_correo.DeptoDe = '$IdPermiso' $cond ORDER BY tblp_correo.FecCap DESC");
    while($x = $db->recorrer($sql)){
      $gMailSend[] = $x;
    }
    return $gMailSend;
  }

  public function get_mailEntrada($IdUsa,$IdPermiso) {
    if($IdPermiso == 3){
      $cond = " AND tblp_correo.IdUsua = '$IdUsa' ";
    } else {
      $cond = "";
    }
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_correo.IdCorreo, tblp_correo.IdUsua, tblp_correo.Asunto, tblp_correo.Mensaje, tblp_correo.FecCap, tblp_correo.Visto, tblp_correo.Respuesta, tblp_correo.DeptoDe, tblc_departamento.NomDepartamento AS De, tblp_correo.Imagen FROM tblp_correo Left Join tblc_departamento ON tblc_departamento.IdDepartamento = tblp_correo.DeptoDe WHERE tblp_correo.Tipo =  'E' AND tblp_correo.DeptoPara =  '$IdPermiso' $cond ORDER BY tblp_correo.FecCap DESC");
    while($x = $db->recorrer($sql)){
      $gMailSendd[] = $x;
    }
    return $gMailSendd;
  }

  public function get_emailLeer($IdCorreo,$IdUsua,$IdPermiso) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_correo.IdCorreo, tblp_correo.Visto, tblp_correo.Asunto, tblp_correo.Mensaje, tblp_correo.FecCap, tblp_correo.Imagen, tblp_correo.Respuesta, tblp_correo.DeptoDe, tblp_correo.IdCorreoAnterior, tblp_correo.DeptoPara, tblc_departamento.NomDepartamento AS Para FROM tblp_correo Left Join tblc_departamento ON tblc_departamento.IdDepartamento = tblp_correo.DeptoPara WHERE tblp_correo.Tipo =  'S' AND tblp_correo.IdCorreo =  '$IdCorreo' AND tblp_correo.IdUsuaCap = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $gMailLeer[] = $x;
    }
    return $gMailLeer;
  }

  public function get_emailResId($IdCorreo) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_correo.IdCorreo, tblp_correo.IdUsua, tblp_correo.Asunto, tblp_correo.Mensaje, tblp_correo.FecCap, tblp_correo.DeptoDe, tblp_correo.DeptoPara, tblp_correo.Imagen, tblp_correo.IdCorreoPrincipal, tblc_departamento.NomDepartamento AS De, tblp_correo.IdDepartamento, tblp_correo.IdGrupo FROM tblp_correo Inner Join tblc_departamento ON tblc_departamento.IdDepartamento = tblp_correo.DeptoDe WHERE tblp_correo.IdCorreo =  '$IdCorreo'");
    while($x = $db->recorrer($sql)){
      $gMailLzeer[] = $x;
    }
    return $gMailLzeer;
  }

  public function get_emailLeerEntrda($IdCorreo,$IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_correo.IdCorreo, tblp_correo.IdUsua, tblp_correo.Asunto, tblp_correo.Mensaje, tblp_correo.FecCap, tblp_correo.Imagen, tblp_correo.Respuesta, tblp_correo.IdCorreoAnterior, tblp_correo.DeptoDe, tblp_correo.DeptoPara, tblp_correo.IdCorreoPrincipal, tblc_departamento.NomDepartamento AS De FROM tblp_correo Left Join tblc_departamento ON tblc_departamento.IdDepartamento = tblp_correo.DeptoDe WHERE tblp_correo.Tipo =  'E' AND tblp_correo.IdCorreo =  '$IdCorreo'");
    while($x = $db->recorrer($sql)){
      $gMailLzer[] = $x;
    }
    return $gMailLzer;
  }

  public function get_mailDe($IdDepto) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_departamento WHERE tblc_departamento.IdDepartamento = '$IdDepto'");
    while($x = $db->recorrer($sql)){
      $gDeptoDes[] = $x;
    }
    return $gDeptoDes;
  }

  public function get_grupoId($IdGrupo) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
    while($x = $db->recorrer($sql)){
      $gGrupoID[] = $x;
    }
    return $gGrupoID;
  }

  public function get_emailResp($IdCorreo,$IdUsa,$IdCorreoAnt) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_correo.IdCorreo, tblp_correo.Visto,tblp_correo.Asunto, tblp_correo.Mensaje, tblp_correo.FecCap, tblp_correo.Imagen, tblp_correo.Tipo, tblp_correo.Respuesta, tblp_correo.IdCorreoAnterior, tblc_departamento.NomDepartamento FROM tblp_correo Left Join tblc_departamento ON tblc_departamento.IdDepartamento = tblp_correo.IdDepartamento WHERE tblp_correo.IdCorreo = '$IdCorreoAnt'");
    while($x = $db->recorrer($sql)){
      $gMaailLeer[] = $x;
    }
    return $gMaailLeer;
  }

  public function get_nombreAl($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $gAlumnoID[] = $x;
    }
    return $gAlumnoID;
  }

  public function get_departamento($IdPermiso) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_departamento WHERE tblc_departamento.Permiso$IdPermiso = '1'");
    while($x = $db->recorrer($sql)){
      $gDeptos[] = $x;
    }
    return $gDeptos;
  }

  public function get_grupoLSTT() {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.Estatus = 'Activo' AND tblp_grupo.Tipo = 'Cerrado'");
    while($x = $db->recorrer($sql)){
      $gGeupoLt[] = $x;
    }
    return $gGeupoLt;
  }

  # MIS DOCMENTOS
  // public function get_documentos($IdUsua) {
  //   $db = new Conexion();
  //   $get_documentos = [];
  //   $sql = $db->query("SELECT * FROM tblc_documentos WHERE tblc_documentos.IdUsua = '$IdUsua'");
  //   while($x = $db->recorrer($sql)){
  //     $get_documentos[] = $x;
  //   }
  //   return $get_documentos;
  // }

  # MIS DOCMENTOS
  public function get_conceptosOf($IdOferta) {
    if($IdOferta){
      $db = new Conexion();
      $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $IdGrado = $datos91['IdGrado'];
      $sql = $db->query("SELECT * FROM tblc_conceptos WHERE tblc_conceptos.Grado$IdGrado <> 0");
      while($x = $db->recorrer($sql)){
        $gConceptosId[] = $x;
      }
      return $gConceptosId;
    }
  }

  public function get_grupoActiv($IdOferta) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.Estatus = 'Activo' AND tblp_grupo.IdOferta = '$IdOferta'");
    while($x = $db->recorrer($sql)){
      $gGrupoIDId[] = $x;
    }
    return $gGrupoIDId;
  }

  public function get_alumnosPag($IdGrupo) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo'");
    while($x = $db->recorrer($sql)){
      $gUsuariosP[] = $x;
    }
    return $gUsuariosP;
  }

  # MIS PAGOS POR REALIZAR
  public function get_misPagos($IdUsua) {
    $db = new Conexion();
    $gPagosId = [];

    $sql = $db->query("SELECT
tblc_conceptosplanes.NomPlan,
tblc_estatus.Estatus,
tblp_pagos.IdModulo,
tblp_pagos.Facturar,
tblp_pagos.IdPago,
tblp_pagos.IdEstatus,
tblp_pagos.Fecha
FROM
tblp_pagos
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus
WHERE tblp_pagos.IdUsua = '$IdUsua'  AND tblp_pagos.IdEstatus <> '4'
ORDER BY tblp_pagos.Fecha ASC
");
    while($x = $db->recorrer($sql)){
      $gPagosId[] = $x;
    }
    return $gPagosId;
  }

  public function get_misMat($IdModulo) {
    $db = new Conexion();
    $get_misMat = [];
    $sql = $db->query("SELECT tblp_modulo.NombreMod FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$IdModulo'");
    while($x = $db->recorrer($sql)){
      $get_misMat[] = $x;
    }
    return $get_misMat;
  }

  public function get_misPRechaz($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_pagos.IdPago,tblc_conceptos.NomConcepto, tblc_estatus.IdEstatus, tblc_estatus.Estatus, tblp_pagos.Monto, tblp_pagos.Pagar, tblh_detallepagos.Archivo, tblh_detallepagos.FecCap AS FecCapSubido, tblp_pagos.FecLimPago, tblp_pagos.Recargos FROM tblp_pagos Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus Left Join tblh_detallepagos ON tblh_detallepagos.IdPago = tblp_pagos.IdPago AND tblh_detallepagos.IdUsua = tblp_pagos.IdUsua WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdEstatus = '5'");
    while($x = $db->recorrer($sql)){
      $gPagosRecha[] = $x;
    }
    return $gPagosRecha;
  }


  public function get_misPagRec($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT Sum(tblp_pagos.Recargos) AS Recargos FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua'  AND tblp_pagos.IdEstatus <> '4'");
    while($x = $db->recorrer($sql)){
      $gPagosRec[] = $x;
    }
    return $gPagosRec;
  }

  public function get_misFecLim($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua'  AND tblp_pagos.IdEstatus <> '4' ORDER BY tblp_pagos.FecLimPago ASC");
    while($x = $db->recorrer($sql)){
      $gPagosReFEcLmi[] = $x;
    }
    return $gPagosReFEcLmi;
  }

  public function get_estatusPago($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua'  AND tblp_pagos.IdEstatus <> '4' ORDER BY tblp_pagos.FecLimPago ASC");
    while($x = $db->recorrer($sql)){
      $gEstatusPag[] = $x;
    }
    return $gEstatusPag;
  }

  public function get_revision($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_pagos.IdPago) AS Revision FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus =  '3'");
    while($x = $db->recorrer($sql)){
      $gPagRevision[] = $x;
    }
    return $gPagRevision;
  }

  public function get_pendiente($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_pagos.IdPago) AS Pendiente FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus =  '1'");
    while($x = $db->recorrer($sql)){
      $gPagPendiente[] = $x;
    }
    return $gPagPendiente;
  }

  public function get_noaprobado($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_pagos.IdPago) AS NoAprobado FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus =  '5'");
    while($x = $db->recorrer($sql)){
      $gPagNAprobado[] = $x;
    }
    return $gPagNAprobado;
  }

  public function get_tipoDoc($IdUsua, $Tipo, $IdOferta) {
      $db = new Conexion();
      if($Tipo){
        $coond = "AND tblc_tipodocumento.TipoUsuario = '$Tipo' ";
      } else { $coond= ""; }

      $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $IdGrado = $datos91['IdGrado'];
      $get_tipoDoc = [];
      $sql = $db->query("SELECT * FROM tblc_tipodocumento WHERE tblc_tipodocumento.Grado$IdGrado = '1' $coond ");
      while($x = $db->recorrer($sql)){
        $get_tipoDoc[] = $x;
      }
      return $get_tipoDoc;
    }

    public function get_tipo_docs($IdOferta) {
      $db = new Conexion();

      $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $IdGrado = $datos91['IdGrado'];
      $get_tipoDoc = [];
      $sql = $db->query("SELECT * FROM tblh_tipodocumento WHERE tblh_tipodocumento.Grado = '$IdGrado' ");
      while($x = $db->recorrer($sql)){
        $get_tipoDoc[] = $x;
      }
      return $get_tipoDoc;
    }

    public function get_lstTipoDoc($IdOferta) {
        $db = new Conexion();

        $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
        $db->rows($sql9);
        $datos91 = $db->recorrer($sql9);
        $IdGrado = $datos91['IdGrado'];

        $gTipoDocId = [];
        $sql = $db->query("SELECT * FROM tblh_tipodocumento WHERE tblh_tipodocumento.Grado = '$IdGrado' AND tblh_tipodocumento.IdEstatus = '8'");
        while($x = $db->recorrer($sql)){
          $gTipoDocId[] = $x;
        }
        return $gTipoDocId;
      }

  public function get_tipoDocC($IdUsua, $Tipo) {
    $db = new Conexion();
    if($Tipo == 2){
      $cond = "AND tblc_tipodocumento.IdGrado IS NULL";
    }
    $sql = $db->query("SELECT * FROM tblc_tipodocumento WHERE tblc_tipodocumento.TipoUsuario = '$Tipo' $cond");
    while($x = $db->recorrer($sql)){
      $gTipoDocIfd[] = $x;
    }
    return $gTipoDocIfd;
  }

  public function get_misDocumentos($IdDocente) {
    $db = new Conexion();
    $get_misDocumentos = [];
    $sql = $db->query("SELECT tblc_docdocentes.IdDocDocente, tblc_docdocentes.IdUsua, tblc_docdocentes.Anio, tblc_docdocentes.Mes, tblc_docdocentes.Archivo, tblc_docdocentes.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_docdocentes Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docdocentes.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docdocentes.Estatus WHERE tblc_docdocentes.IdUsua = '$IdDocente' AND tblc_docdocentes.Estatus <> 4 AND tblc_docdocentes.Code IS NULL ");
    while($x = $db->recorrer($sql)){
      $get_misDocumentos[] = $x;
    }
    return $get_misDocumentos;
  }

  public function get_reconox($IdUsua) {
    $db = new Conexion();
    $get_reconox = [];
    $sql = $db->query("SELECT * FROM tblp_reconocimiento WHERE tblp_reconocimiento.IdTipo = '6' AND tblp_reconocimiento.IdUsua ='$IdUsua' ORDER BY tblp_reconocimiento.Fecha DESC");
    while($x = $db->recorrer($sql)){
      $get_reconox[] = $x;
    }
    return $get_reconox;
  }

  public function get_misContratos($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_contrato.IdContrato, tblc_contrato.Archivo, tblc_contrato.FecCap, tblp_educativa.Nombre, tblp_modulo.NombreMod, tblc_estatus.Estatus FROM tblc_contrato Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_contrato.IdOferta Left Join tblp_modulo ON tblp_modulo.IdModulo = tblc_contrato.IdModulo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_contrato.Estatus WHERE tblc_contrato.IdUsua = '$IdUsua' AND tblc_contrato.Estatus <> '4'");
    while($x = $db->recorrer($sql)){
      $gmisContrId[] = $x;
    }
    return $gmisContrId;
  }

  public function get_misContratosAcp($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_contrato.IdContrato, tblc_contrato.Archivo, tblc_contrato.FecCap, tblp_educativa.Nombre, tblp_modulo.NombreMod, tblc_estatus.Estatus FROM tblc_contrato Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_contrato.IdOferta Left Join tblp_modulo ON tblp_modulo.IdModulo = tblc_contrato.IdModulo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_contrato.Estatus WHERE tblc_contrato.IdUsua = '$IdUsua' AND tblc_contrato.Estatus = '4'");
    while($x = $db->recorrer($sql)){
      $gmisContrIdx[] = $x;
    }
    return $gmisContrIdx;
  }



  public function get_misDocTramite($IdAlumno,$IdTipo) {
    $db = new Conexion();
    $get_misDocTramite = [];
    $sql = $db->query("SELECT tblc_doctramite.IdDocTramite, tblc_doctramite.IdUsua, tblc_doctramite.Archivo, tblc_doctramite.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_doctramite Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_doctramite.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_doctramite.Estatus WHERE tblc_doctramite.IdUsua = '$IdAlumno' AND tblc_doctramite.Estatus <> 4 AND tblc_doctramite.Tipo = '$IdTipo'");
    while($x = $db->recorrer($sql)){
      $get_misDocTramite[] = $x;
    }
    return $get_misDocTramite;
  }

  public function get_misDocAlumAcep($IdAlumno) {
    $db = new Conexion();
    $get_misDocAlumAcep = [];
    $sql = $db->query("SELECT tblc_docalumnos.IdDocAlumno, tblc_docalumnos.IdUsua, tblc_docalumnos.Archivo, tblc_docalumnos.FecCap, tblc_estatus.Estatus, tblh_tipodocumento.Nombre,tblc_docalumnos.Anio, tblc_docalumnos.Mes, tblc_docalumnos.IdGrupo FROM tblc_docalumnos Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docalumnos.Estatus Left Join tblh_tipodocumento ON tblh_tipodocumento.IdTipoDoc = tblc_docalumnos.IdTipoDocumento WHERE tblc_docalumnos.IdUsua = '$IdAlumno' AND tblc_docalumnos.Estatus = 4");
    //$sql = $db->query("SELECT tblc_docalumnos.IdDocAlumno, tblc_docalumnos.IdUsua, tblc_docalumnos.Archivo, tblc_docalumnos.FecCap, tblc_tipodocumento.NomDocumento, tblc_docalumnos.Anio, tblc_docalumnos.IdGrupo, tblc_estatus.Estatus FROM tblc_docalumnos Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docalumnos.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docalumnos.Estatus WHERE tblc_docalumnos.IdUsua = '$IdAlumno' AND tblc_docalumnos.Estatus = 4");
    while($x = $db->recorrer($sql)){
      $get_misDocAlumAcep[] = $x;
    }
    return $get_misDocAlumAcep;
  }

  public function get_docs_tram_true($IdAlumno) {
    $db = new Conexion();
    $get_misDocAlumAcep = [];
    $sql = $db->query("SELECT tblc_docalumnos.IdDocAlumno, tblc_docalumnos.Archivo, tblc_docalumnos.FecCap, tblc_docalumnos.Anio, tblc_docalumnos.Mes, tblc_ciclo.Ciclo, tblc_tipodocumento.NomDocumento FROM tblc_docalumnos Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_docalumnos.IdCiclo Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docalumnos.IdTipoDocumento WHERE tblc_docalumnos.IdUsua =  '$IdAlumno' AND tblc_docalumnos.Doc =  'T' AND tblc_docalumnos.Estatus =  '4'");
    while($x = $db->recorrer($sql)){
      $get_misDocAlumAcep[] = $x;
    }
    return $get_misDocAlumAcep;
  }

  public function get_cic_activo($IdGrupo) {
    $db = new Conexion();
    $get_cic_activo = [];

    $sql = $db->query("SELECT tblc_ciclogrupo.IdCicloGrupo, tblc_ciclogrupo.IdCiclo, tblc_ciclo.Ciclo, tblc_ciclogrupo.Grado FROM tblc_ciclogrupo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo WHERE tblc_ciclogrupo.IdGrupo =  '$IdGrupo' AND tblc_ciclo.IdEstatus =  '8' ORDER BY tblc_ciclogrupo.Grado DESC LIMIT 1");
    while($x = $db->recorrer($sql)){
      $get_cic_activo[] = $x;
    }
    return $get_cic_activo;
  }

  public function get_verifcar_docs($IdCiclo, $IdUsua, $IdGrupo, $IdOferta) {
    $db = new Conexion();
    $_vax = 0;
    if(($IdOferta == 1) || ($IdOferta == 2) || ($IdOferta == 3) || ($IdOferta == 4) || ($IdOferta == 5) || ($IdOferta == 6)){ $_vax = 1; }

    $sql9 = $db->query("SELECT * FROM tblc_docalumnos WHERE tblc_docalumnos.IdUsua =  '$IdUsua' AND tblc_docalumnos.IdTipoDocumento = '103' AND tblc_docalumnos.IdCiclo = '$IdCiclo'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdDocAlumno = $datos91['IdDocAlumno'];
    if(!$IdDocAlumno){
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','103','1','$cicIdCiclolo','T','$IdGrupo')");
      if($_vax == 1){
          $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','105','1','$IdCiclo','T','$IdGrupo')");
      }
    }
  }

  public function get_docs_regl($IdGrupo,$IdCiclo) {
    $db = new Conexion();
    $get_docs_regl = [];

    $sql = $db->query("SELECT tblp_docs.IdDocs, tblp_docs.Nombre, tblp_docs.Archivo, tblp_docs.Anio, tblp_docs.Mes, tblp_docs_grupo.IdGrupo FROM tblp_docs Left Join tblp_docs_grupo ON tblp_docs_grupo.IdDocs = tblp_docs.IdDocs WHERE tblp_docs.IdCiclo =  '$IdCiclo' AND tblp_docs_grupo.IdGrupo = '$IdGrupo' ");
    while($x = $db->recorrer($sql)){
      $get_docs_regl[] = $x;
    }
    return $get_docs_regl;
  }

  public function add_datSocial(){
   $db = new Conexion();
   $insertar = $db->query("UPDATE tblp_servicio SET tblp_servicio.NomDependencia = '".$_POST["txtDependencia"]."', tblp_servicio.NomPrograma = '".$_POST["txtPrograma"]."', tblp_servicio.Periodo = '".$_POST["txtPeriodo"]."', tblp_servicio.Actividades = '".$_POST["txtActividades"]."' WHERE tblp_servicio.IdUsua = '".$_POST["IdUsua"]."'");
   if ($insertar) {
     $_SESSION['Alerta']="2";
     echo "<script type='text/javascript'>window.location='misServicios.php';</script>";
   } else {
     $_SESSION['Alerta']="0";
     echo "<script type='text/javascript'>window.location='misServicios.php';</script>";
   }
 }

  public function get_misDocTraAcep($IdAlumno, $IdTipo) {
    $db = new Conexion();
    $get_misDocTraAcep = [];
    $sql = $db->query("SELECT tblc_doctramite.IdDocTramite, tblc_doctramite.IdUsua, tblc_doctramite.Archivo, tblc_doctramite.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_doctramite Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_doctramite.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_doctramite.Estatus WHERE tblc_doctramite.IdUsua = '$IdAlumno' AND tblc_doctramite.Estatus = 4 AND tblc_doctramite.Tipo = '$IdTipo'");
    while($x = $db->recorrer($sql)){
      $get_misDocTraAcep[] = $x;
    }
    return $get_misDocTraAcep;
  }

  public function get_Social($IdAlumno) {
    $db = new Conexion();
    $sql9 = $db->query("SELECT IdServicio FROM tblp_servicio WHERE tblp_servicio.IdUsua =  '$IdAlumno'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdServicio = $datos91['IdServicio'];
    if(!$IdServicio){
      $insertar = $db->query("INSERT INTO tblp_servicio (IdUsua, IdEstatus, FecCap) VALUES('$IdAlumno','8',NOW())");
    }
    $sql = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdUsua = '$IdAlumno'");
    while($x = $db->recorrer($sql)){
      $gServicio[] = $x;
    }
    return $gServicio;
  }

  public function get_misDocAcept($IdDocente) {
    $db = new Conexion();
    $get_misDocAcept = [];
    $sql = $db->query("SELECT tblc_docdocentes.IdDocDocente, tblc_docdocentes.Anio, tblc_docdocentes.Mes, tblc_docdocentes.IdUsua, tblc_docdocentes.Archivo, tblc_docdocentes.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_docdocentes Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docdocentes.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docdocentes.Estatus WHERE tblc_docdocentes.IdUsua = '$IdDocente' AND tblc_docdocentes.Estatus = 4");
    while($x = $db->recorrer($sql)){
      $get_misDocAcept[] = $x;
    }
    return $get_misDocAcept;
  }

  public function get_mis_docs_doc($IdDocente) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_docdocentes.Anio, tblc_docdocentes.Mes, tblc_docdocentes.Archivo, tblc_docdocentes.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_docdocentes Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docdocentes.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docdocentes.Estatus WHERE tblc_docdocentes.IdUsua = '$IdDocente' ORDER BY tblc_docdocentes.FecCap DESC");
    while($x = $db->recorrer($sql)){
      $gmisDocAceptcId[] = $x;
    }
    return $gmisDocAceptcId;
  }

  public function get_mis_gradx_doc($IdDocente) {
    $db = new Conexion();
    $get_mis_gradx_doc = [];

    $sql = $db->query("SELECT tblc_docdocentes.Nombre FROM tblc_docdocentes WHERE tblc_docdocentes.IdUsua = '$IdDocente' AND tblc_docdocentes.Code IS NOT NULL GROUP BY tblc_docdocentes.Code ORDER BY tblc_docdocentes.Nombre ASC");
    while($x = $db->recorrer($sql)){
      $get_mis_gradx_doc[] = $x;
    }
    return $get_mis_gradx_doc;
  }

  public function get_lstDocumentos($IdDocente) {
    $db = new Conexion();

    $sql = $db->query("SELECT tblc_docdocentes.IdDocDocente AS IdDocumento, tblc_docdocentes.IdUsua, tblc_docdocentes.Archivo, tblc_docdocentes.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_docdocentes Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docdocentes.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docdocentes.Estatus WHERE tblc_docdocentes.IdUsua = '$IdDocente'");
    while($x = $db->recorrer($sql)){
      $gmisDocAceptcId[] = $x;
    }
    return $gmisDocAceptcId;
  }

  public function get_lstDocAlumno($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblc_docalumnos.IdDocAlumno AS IdDocumento, tblc_docalumnos.IdUsua, tblc_docalumnos.FecCap, tblc_docalumnos.Archivo, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_docalumnos Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docalumnos.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docalumnos.Estatus WHERE tblc_docalumnos.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $gDocAlumno[] = $x;
    }
    return $gDocAlumno;
  }

  public function get_lstDocTramite($IdUsua) {
    $db = new Conexion();
    $gDocTramite = [];
    $sql = $db->query("SELECT tblc_doctramite.IdDocTramite AS IdDocumento, tblc_doctramite.IdUsua, tblc_doctramite.FecCap, tblc_doctramite.Archivo, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_doctramite Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_doctramite.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_doctramite.Estatus WHERE tblc_doctramite.IdUsua = '$IdUsua' ");
    while($x = $db->recorrer($sql)){
      $gDocTramite[] = $x;
    }
    return $gDocTramite;
  }

  public function get_lst_docs_tra($IdUsua) {
    $db = new Conexion();
    $get_lst_docs_tra = [];
    $sql = $db->query("SELECT
tblc_docalumnos.IdDocAlumno,
tblc_docalumnos.IdTipoDocumento,
tblc_docalumnos.FecCap,
tblc_docalumnos.Archivo,
tblc_docalumnos.Anio,
tblc_docalumnos.Mes,
tblc_docalumnos.Estatus AS IdEstatus,
tblc_ciclo.Ciclo,
tblc_estatus.Estatus,
tblc_docalumnos.IdCiclo,
tblc_tipodocumento.NomDocumento
FROM
tblc_docalumnos
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_docalumnos.IdCiclo
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docalumnos.Estatus
Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docalumnos.IdTipoDocumento
WHERE
tblc_docalumnos.IdUsua =  '$IdUsua' AND
tblc_docalumnos.Doc =  'T'
ORDER BY tblc_ciclo.FInicio DESC
 ");
    while($x = $db->recorrer($sql)){
      $get_lst_docs_tra[] = $x;
    }
    return $get_lst_docs_tra;
  }

  public function get_serivcio_id($IdUsua) {
    $db = new Conexion();
    $sql9 = $db->query("SELECT tblp_servicio.IdServicio FROM tblp_servicio WHERE tblp_servicio.IdUsua =  '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdServicio = $datos91['IdServicio'];
    if(!$IdServicio){
      $insertar = $db->query("INSERT INTO tblp_servicio (IdUsua, IdEstatus, FecCap) VALUES('$IdUsua','8',NOW())");
    }

    $get_serivcio_id = [];
    $sql = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $get_serivcio_id[] = $x;
    }
    return $get_serivcio_id;
  }

  # MIS PAGOS POR REALIZAR
  public function get_misPagosAprob($IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.FecCap, tblp_pagos.DocFactura, tblc_estatus.IdEstatus, tblc_estatus.Estatus, tblh_detallepagos.Archivo, tblh_detallepagos.FecCap AS FecCapSubido, tblh_detallepagos.Estatus AS DetEstatus, tblc_conceptos.NomConcepto, tblp_pagos.Pagar, tblp_pagos.TotalPagado, tblp_pagos.IdDescuento FROM tblp_pagos Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus Left Join tblh_detallepagos ON tblh_detallepagos.IdPago = tblp_pagos.IdPago AND tblh_detallepagos.IdUsua = tblp_pagos.IdUsua Inner Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdEstatus = '4'");
    while($x = $db->recorrer($sql)){
      $gPagosId[] = $x;
    }
    return $gPagosId;
  }

  public function get_misDocumentosS($IdPago) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblc_docsolicitado WHERE tblc_docsolicitado.IdPago = '$IdPago' AND tblc_docsolicitado.IdEstatus = '13'");
    while($x = $db->recorrer($sql)){
      $gDoscSolId[] = $x;
    }
    return $gDoscSolId;
  }

  public function get_ingresoDia() {
    $Hoy=date("Y-m-d");
    $anio=date("Y");
    $mes=date("m");

    $valorR = 1;
    $db = new Conexion();
    $IdDia = 0;
    //
    // $sqlx = $db->query("SELECT tblc_usuario.IdUsua, tblp_grupo.IdGrupo FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblp_grupo.IdEstatus =  '12'");
    // while($y = $db->recorrer($sqlx)){
    //   $IdUsuax = $y["IdUsua"];
    //
    //   $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '31' WHERE tblc_usuario.IdUsua = '$IdUsuax'");
    //
    // }

    $sql9 = $db->query("SELECT * FROM tblh_diaingreso WHERE tblh_diaingreso.Fecha =  '$Hoy'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdDia = isset($datos91['IdDiaIngreso']);
    if(!$IdDia){
      $diaList = date('Y-m-d', strtotime('-1 day'));

      $sql8 = $db->query("SELECT * FROM tblr_ingresomes WHERE tblr_ingresomes.Dia =  '$diaList'");
      $db->rows($sql8);
      $datos81 = $db->recorrer($sql8);
      $Id_Dia = $datos81['IdDia'];

      $insertar = $db->query("INSERT INTO tblh_diaingreso (Fecha) VALUES(NOW())");
      $insertar = $db->query("INSERT INTO tblr_ingresomes (Dia, Ingresos, Anio, Mes, Code, FecCap) VALUES(NOW(),'0','$anio','$mes','7677C',NOW())");
      $sum = 0;
      $sql = $db->query("SELECT Count(tblh_log.IdLog) AS Total, tblc_usuario.Permisos FROM tblh_log Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_log.IdUsua WHERE tblh_log.Fecha =  '$diaList' GROUP BY tblc_usuario.Permisos");
      while($x = $db->recorrer($sql)){
        $IdPermiso = $x["Permisos"];
        $Ingresos = $x["Total"];
        $insertar = $db->query("INSERT INTO tblr_ingresodia (IdDia, IdPermiso, Ingresos, Dia) VALUES('$Id_Dia','$IdPermiso','$Ingresos','$diaList')");
        $sum = $sum + $Ingresos;
      }
        $insertar = $db->query("UPDATE tblr_ingresomes SET tblr_ingresomes.Ingresos = '$sum' WHERE tblr_ingresomes.IdDia = '$Id_Dia'");

        $sqlx = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdEstatus, tblc_usuario.FecLimite FROM tblc_usuario WHERE tblc_usuario.IdEstatus = '8' AND tblc_usuario.Permisos = '3' AND tblc_usuario.FecLimite IS NOT NULL");
        while($x = $db->recorrer($sqlx)){
          if($x["FecLimite"] < $Hoy){
            $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '50'  WHERE tblc_usuario.IdUsua='".$x["IdUsua"]."'");
          }
        }

        $sqlx = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdEstatus = '8' AND tblp_actividadesdocente.FecFin = '$diaList' ");
        while($x = $db->recorrer($sqlx)){
            $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.IdEstatus = '26'  WHERE tblp_actividadesdocente.IdActividadesDocente='".$x["IdActividadesDocente"]."'");
        }

        $sqly = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdEstatus = '6' AND tblp_actividadesdocente.FecIni = '$Hoy' ");
        while($y = $db->recorrer($sqly)){
            $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.IdEstatus = '8'  WHERE tblp_actividadesdocente.IdActividadesDocente='".$y["IdActividadesDocente"]."'");
        }
    }
  }

  public function get_tipoConcepto($IdOferta) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_educativa.Tipo FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
    while($x = $db->recorrer($sql)){
      $gTipoConp[] = $x;
    }
    return $gTipoConp;
  }

  public function get_misConceptos($Tipo) {
    if($Tipo == "Doctorado"){
      $Grado = "Grado1";
    } elseif($Tipo == "Maestria"){
      $Grado = "Grado2";
    } elseif($Tipo == "Licenciatura"){
      $Grado = "Grado3";
    }

    $db = new Conexion();
    $sql = $db->query("SELECT tblc_conceptos.IdConcepto, tblc_conceptos.NomConcepto, tblc_conceptos.Tipo, tblc_conceptos.$Grado FROM tblc_conceptos WHERE tblc_conceptos.$Grado IS NOT NULL");
    while($x = $db->recorrer($sql)){
      $gConceptosId[] = $x;
    }
    return $gConceptosId;
  }

  public function get_vistosTareas($IdAsignacion,$IdUsua) {
    $db = new Conexion();
    $sql = $db->query("SELECT Sum(tblp_tareas.Visto) AS Vistos FROM tblp_tareas WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' AND tblp_tareas.IdAlumno =  '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $gVistosT[] = $x;
    }
    return $gVistosT;
  }

  public function get_misDescuentoId($IdPago) {
    $db = new Conexion();
    $sql = $db->query("SELECT tblp_descuento.IdDescuento, tblp_descuento.IdTipoDescuento, tblp_descuento.Porcentaje, tblp_descuento.Descuento, tblc_tipodescuento.NomDescuento, tblp_descuento.FecDescuento FROM tblp_descuento Inner Join tblc_tipodescuento ON tblc_tipodescuento.IdTipoDescuento = tblp_descuento.IdTipoDescuento WHERE tblp_descuento.IdPago = '$IdPago' AND tblp_descuento.Estatus = '8'");
    while($x = $db->recorrer($sql)){
      $gDespag[] = $x;
    }
    return $gDespag;
  }

  public function get_mailActivo($IdUsua,$IdPermiso) {
    if($IdPermiso == 3){
      $cond = " AND tblp_correo.IdUsua = '$IdUsua' ";
    } else {
      $cond = "";
    }
    $db = new Conexion();
    $sql = $db->query("SELECT Sum(tblp_correo.Visto) AS SumActivo FROM tblp_correo WHERE tblp_correo.Tipo = 'E' AND tblp_correo.DeptoPara = '$IdPermiso' $cond ");
    while($x = $db->recorrer($sql)){
      $gEmailV[] = $x;
    }
    return $gEmailV;
  }

  public function get_msj($IdUsua) {
    $db = new Conexion();
    // $sql = $db->query("SELECT * FROM tblp_buzon");
    // while($x = $db->recorrer($sql)){
    //   $IdUE = $x['IdUsuaEnvia'];
    //   $IdUR = $x['IdUsuaRecibe'];
    //   $val = ($IdUE * $IdUR);
    //   $IdB = $x['IdBuzon'];
    //   $insertar = $db->query("UPDATE tblp_buzon  SET tblp_buzon.IdUnico = '$val' WHERE tblp_buzon.IdBuzon = '$IdB'");
    // }


    $get_msj = [];
    $sql = $db->query("SELECT Count(tblp_buzon.IdBuzon) AS Msj FROM tblp_buzon WHERE tblp_buzon.IdUsuaRecibe =  '$IdUsua' AND tblp_buzon.Visto =  '1'");
    while($x = $db->recorrer($sql)){
      $get_msj[] = $x;
    }
    return $get_msj;
  }

  public function get_lstmsj($IdUsua) {
    $db = new Conexion();
    $get_lstmsj = [];


    $sql = $db->query("SELECT
  tblp_buzon.IdBuzon,
  tblp_buzon.IdUsuaEnvia,
  tblp_buzon.IdUsuaRecibe,
  tblp_buzon.FecCap,
  tblp_buzon.Mensaje,
  tblp_buzon.Visto,
  tblc_usuario.Nombre AS ENombre,
  tblc_usuario.APaterno AS EPaterno,
  tblc_usuario.AMaterno AS EMaterno,
  tblc_usuario.Cargo AS ECargo,
  tblc_usuario.Foto AS EFoto,
  RUsuario.Nombre AS RNombre,
  RUsuario.APaterno AS RPaterno,
  RUsuario.AMaterno AS RMaterno,
  RUsuario.Cargo AS RCargo,
  RUsuario.Foto AS RFoto
  FROM
  tblp_buzon
  Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_buzon.IdUsuaEnvia
  Left Join tblc_usuario AS RUsuario ON RUsuario.IdUsua = tblp_buzon.IdUsuaRecibe
  WHERE ((tblp_buzon.IdUsuaEnvia = '$IdUsua') || (tblp_buzon.IdUsuaRecibe = '$IdUsua'))
  GROUP BY
  tblp_buzon.IdUnico
  ORDER BY
  tblp_buzon.FecCap DESC");
    while($x = $db->recorrer($sql)){
      $get_lstmsj[] = $x;
    }
    return $get_lstmsj;
  }

  public function upd_vistoTarea($IdAsignacion,$IdUsa,$NoActividad){
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_tareas  SET tblp_tareas.Visto = '0' WHERE tblp_tareas.IdAsignacion = '$IdAsignacion' AND tblp_tareas.IdAlumno = '$IdUsa' AND tblp_tareas.NoActividad = '$NoActividad'");
    $db->close();
  }

  public function get_emailVisto($IdCorreo,$IdUsua){
    $db = new Conexion();
    $insertar = $db->query("UPDATE tblp_correo  SET tblp_correo.Visto = '0' WHERE tblp_correo.IdCorreo = '$IdCorreo'");
    $db->close();
  }

  public function get_newProspectosG1($IdGrado) {
    $db = new Conexion();
    $sql9 = $db->query("SELECT Sum(tblc_tipodocumento.Grado$IdGrado) FROM tblc_tipodocumento WHERE tblc_tipodocumento.Grado$IdGrado = '1'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $noDocs = $datos91[0]-1;

    $sql = $db->query("SELECT Sum(tblc_usuario.Visto) AS SumProspectos FROM tblc_usuario WHERE tblc_usuario.NoDoc = '$noDocs'");
    while($x = $db->recorrer($sql)){
      $gNewProspetX[] = $x;
    }
    return $gNewProspetX;

  }

  public function get_newPagos() {
    $db = new Conexion();
    $sql = $db->query("SELECT Sum(tblh_detallepagos.Visto) AS SumPagos FROM tblh_detallepagos WHERE tblh_detallepagos.Estatus = '2'");
    while($x = $db->recorrer($sql)){
      $gNewPagos[] = $x;
    }
    return $gNewPagos;
  }


  public function get_infoPerfil($IdUsua) {
    $db = new Conexion();
    // Tiempo de espera 3 minutos
    // $time = 3;
    // // Capturamos el tiempo de la conexión
    // $date = time();
    // // Captura de la IP de conexion
    // $ip = $_SERVER['REMOTE_ADDR'];
    // // Tiempo de espera
    // $limite = $date-$time*60;
    // // Si supera los 3 minutos borramos de la base de datos la conexion
    // // mysqli_query($con,"delete from usuarios_online where date < $limite") ;
    // $sql = $db->query("DELETE FROM tblc_usuarios_online WHERE tblc_usuarios_online.date < $limite");
    // $sql2 = $db->query("SELECT * FROM tblc_usuarios_online WHERE tblc_usuarios_online.id_usua='$IdUsua'");
    // $db->rows($sql2);
    // $datos21 = $db->recorrer($sql2);
    // $Id = $datos21["id_usua"];
    // if($Id) {
    //   $sql = $db->query("UPDATE tblc_usuarios_online set tblc_usuarios_online.date='$date', tblc_usuarios_online.fec_cap = NOW() WHERE tblc_usuarios_online.id_usua='$IdUsua'");
    // }
    // else {
    //   $sql = $db->query("INSERT INTO tblc_usuarios_online (date,ip,fec_cap,id_usua) values ('$date','$ip',NOW(),'$IdUsua')");
    // }

    $get_infoPerfil = [];
    $sql = $db->query("SELECT tblc_usuario.IdOferta, tblc_usuario.Semblanza,tblc_usuario.IdUsua, tblc_usuario.IdGrupo, tblc_usuario.Visto, tblc_usuario.Folio, tblc_usuario.FecLimite, tblc_campus.Campus, tblp_educativa.Nombre AS Oferta FROM tblc_usuario Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua = '$IdUsua' ");
    while($x = $db->recorrer($sql)){
      $get_infoPerfil[] = $x;
    }
    return $get_infoPerfil;
  }

  public function get_menuUsuario($IdUsua) {
    $db = new Conexion();
    $gMenuUser = [];
    $sql = $db->query("SELECT tblc_menuusuario.IdMenuUsua, tblc_menuusuario.IdMenu, tblc_menuusuario.IdUsua, tblc_menuusuario.FecCap, tblc_menu.Code, tblc_menu.Color, tblc_menu.Nombre, tblc_menu.Tipo, tblc_menu.Permisos, tblc_menu.Link, tblc_menu.Icono FROM tblc_menuusuario Left Join tblc_menu ON tblc_menu.IdMenu = tblc_menuusuario.IdMenu WHERE tblc_menuusuario.IdUsua = '$IdUsua' ORDER BY tblc_menu.Code ASC");
    while($x = $db->recorrer($sql)){
      $gMenuUser[] = $x;
    }
    return $gMenuUser;
  }


  public function get_misCom($IdPago) {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM tblp_foliospago WHERE tblp_foliospago.IdPago = '$IdPago' AND tblp_foliospago.Tipo = 'P'");
    while($x = $db->recorrer($sql)){
      $gFOlsr[] = $x;
    }
    return $gFOlsr;
  }

  public function get_chkAvisos($IdGrupo) {
    $db = new Conexion();
    $gAvisr = [];
    $sql = $db->query("SELECT tblc_avisodetalle.IdAvisoD, tblc_avisodetalle.IdAviso, tblc_avisodetalle.IdGrupo, tblc_aviso.Titulo, tblc_aviso.Aviso, tblc_aviso.Archivo, tblc_aviso.FecCap, tblc_aviso.Tipo FROM tblc_avisodetalle Left Join tblc_aviso ON tblc_aviso.IdAviso = tblc_avisodetalle.IdAviso WHERE tblc_avisodetalle.IdGrupo = '$IdGrupo' ORDER BY tblc_aviso.FecCap DESC LIMIT 4");
    while($x = $db->recorrer($sql)){
      $gAvisr[] = $x;
    }
    return $gAvisr;
  }

    public function get_chkAvisosDoc($IdCampus) {
    $db = new Conexion();
    $get_chkAvisosDoc = [];
    $sql = $db->query("SELECT
tblc_avisoasesor.IdAvisoD,
tblc_avisoasesor.IdAviso,
tblc_avisoasesor.IdCampus,
tblc_aviso.Titulo,
tblc_aviso.Aviso,
tblc_aviso.Archivo,
tblc_aviso.FecCap,
tblc_aviso.Tipo,
tblc_aviso.Permisos
FROM
tblc_avisoasesor
Left Join tblc_aviso ON tblc_aviso.IdAviso = tblc_avisoasesor.IdAviso
WHERE tblc_aviso.Permisos = '2' AND tblc_avisoasesor.IdCampus = '$IdCampus' ORDER BY tblc_aviso.FecCap DESC LIMIT 4 ");
    while($x = $db->recorrer($sql)){
      $get_chkAvisosDoc[] = $x;
    }
    return $get_chkAvisosDoc;
  }

  public function get_pagPend($IdUsua) {
    $db = new Conexion();
    $get_pagPend = [];
    $sql = $db->query("SELECT tblp_pagos.FecDesc, tblp_pagos.FecDesc FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus <>  '4' AND tblp_pagos.IdConceptoPlan <> '12' ORDER BY tblp_pagos.FecDesc ASC");
    while($x = $db->recorrer($sql)){
      $get_pagPend[] = $x;
    }
    return $get_pagPend;
  }

  public function get_chkEncuenta($IdUsua) {
    $db = new Conexion();

    $sql8 = $db->query("SELECT * FROM tblx_evaluacion WHERE tblx_evaluacion.IdUsua =  '$IdUsua' AND tblx_evaluacion.IdEstatus = '31'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $Id_eva = $datos81['IdEvaluacionX'];
    $Id_cic = $datos81['IdCiclo'];
    $id_grp = $datos81['IdGrupo'];
    $id_ofe = $datos81['IdOferta'];
    $id_cam = $datos81['IdCampus'];
    $_FecIni = $datos81['FecIni'];
    $_IdEs = $datos81['IdEstatus'];
    $id_tipo = $datos81['IdTipo'];
    $_idAsig = $datos81['IdAsignacion'];

    if($id_tipo == 1){
      $IdAsignacion = $datos81['IdAsignacion'];
      $sql9 = $db->query("SELECT tblp_asignacion.IdModulo, tblp_asignacion.IdUsua FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $IdModulo = $datos91['IdModulo'];
      $IdDoc = $datos91['IdUsua'];

      $sql2 = $db->query("SELECT tblx_pregunta.IdPregunta FROM tblx_pregunta WHERE tblx_pregunta.Tipo =  '$id_tipo' AND tblx_pregunta.IdEstatus =  '8'");
      while($y = $db->recorrer($sql2)){
        $IdP = $y["IdPregunta"];
          $insertar = $db->query("INSERT INTO tblx_respuesta (IdPregunta,IdDocente,IdEvaluacion,IdGrupo,IdUsua, FecCap,IdOferta,IdCampus,IdAsignacion,IdEstatus,IdModulo, IdCiclo) VALUES('$IdP','$IdDoc','$Id_eva','$id_grp','$IdUsua',NOW(),'$id_ofe','$id_cam','$IdAsignacion','8','$IdModulo','$Id_cic')");
      }
    } else {
        $sql2 = $db->query("SELECT tblx_pregunta.IdPregunta FROM tblx_pregunta WHERE tblx_pregunta.Tipo =  '$id_tipo' AND tblx_pregunta.IdEstatus =  '8'");
        while($y = $db->recorrer($sql2)){ $IdP = $y["IdPregunta"];
            $insertar = $db->query("INSERT INTO tblx_respuesta (IdPregunta,IdEvaluacion,IdGrupo,IdUsua, FecCap,IdOferta,IdCampus,IdEstatus,IdCiclo,IdAsignacion) VALUES('$IdP','$Id_eva','$id_grp','$IdUsua',NOW(),'$id_ofe','$id_cam','8','$Id_cic','$_idAsig')");
        }
    }


    $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.IdEstatus = '12' WHERE tblx_evaluacion.IdEvaluacionX = '$Id_eva'");

    $hoy = date("Y-m-d");
    $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.IdEstatus = '8' WHERE tblx_evaluacion.FecIni = '$hoy' AND tblx_evaluacion.IdEstatus = '12'");

    $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.IdEstatus = '8' WHERE tblx_evaluacion.FecIni < '$hoy' AND tblx_evaluacion.IdEstatus = '12'");

    $gFOlsrds = [];

    $sql = $db->query("SELECT tblx_evaluacion.IdEvaluacionX, tblx_evaluacion.FecCap, tblx_evaluacion.IdEstatus, tblx_evaluacion.FecIni, tblx_evaluacion.FecFin, tblc_ciclo.Ciclo, tblc_estatus.Estatus FROM tblx_evaluacion Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblx_evaluacion.IdCiclo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblx_evaluacion.IdEstatus WHERE tblx_evaluacion.IdUsua =  '$IdUsua' AND tblx_evaluacion.IdEstatus =  '8' ORDER BY tblx_evaluacion.IdEstatus ASC");
    while($x = $db->recorrer($sql)){
      $gFOlsrds[] = $x;
    }
    return $gFOlsrds;
  }

  public function get_chkEval($IdUsua) {
    $db = new Conexion();
    $get_chkEval = [] ;
    $sql = $db->query("SELECT
tblx_evaluacion.IdEvaluacionX,
tblx_evaluacion.FecCap,
tblx_evaluacion.IdEstatus,
tblx_evaluacion.FecIni,
tblx_evaluacion.FecFin,
tblx_evaluacion.Tipo,
tblc_ciclo.Ciclo,
tblc_estatus.Estatus,
tblc_tipoevaluacion.Evaluacion
FROM
tblx_evaluacion
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblx_evaluacion.IdCiclo
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblx_evaluacion.IdEstatus
Left Join tblc_tipoevaluacion ON tblc_tipoevaluacion.IdTipoEvaluacion = tblx_evaluacion.IdTipo WHERE tblx_evaluacion.IdUsua =  '$IdUsua' ORDER BY tblx_evaluacion.IdCiclo ASC");
    while($x = $db->recorrer($sql)){
      $get_chkEval[] = $x;
    }
    return $get_chkEval;
  }

  public function get_chk_docs_pen($IdUsua) {
    $db = new Conexion();
    $get_chk_docs_pen = [] ;
    $sql = $db->query("SELECT
tblc_tipodocumento.NomDocumento,
tblc_docalumnos.IdDocAlumno
FROM
tblc_docalumnos
Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docalumnos.IdTipoDocumento
WHERE
tblc_docalumnos.IdUsua =  '$IdUsua' AND
tblc_docalumnos.Estatus =  '1' AND ((tblc_docalumnos.IdTipoDocumento = '103') || (tblc_docalumnos.IdTipoDocumento = '105')) ");
    while($x = $db->recorrer($sql)){
      $get_chk_docs_pen[] = $x;
    }
    return $get_chk_docs_pen;
  }

  public function get_chkEvalU($IdUsua) {
    $db = new Conexion();

    $get_chkEvalU = [];
    $sql = $db->query("SELECT
tblx_evaluacion.IdEvaluacionX,
tblx_evaluacion.FecCap,
tblx_evaluacion.IdEstatus,
tblx_evaluacion.FecIni,
tblx_evaluacion.FecFin,
tblx_evaluacion.Tipo,
tblx_evaluacion.IdTipo,
tblc_ciclo.Ciclo,
tblc_estatus.Estatus,
tblc_tipoevaluacion.Evaluacion,
tblc_tipoevaluacion.Cve,
tblp_modulo.NombreMod
FROM
tblx_evaluacion
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblx_evaluacion.IdCiclo
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblx_evaluacion.IdEstatus
Left Join tblc_tipoevaluacion ON tblc_tipoevaluacion.IdTipoEvaluacion = tblx_evaluacion.IdTipo
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblx_evaluacion.IdModulo
WHERE tblx_evaluacion.IdUsua =  '$IdUsua'
ORDER BY
tblx_evaluacion.FecIni DESC
");
    while($x = $db->recorrer($sql)){
      $get_chkEvalU[] = $x;
    }
    return $get_chkEvalU;
  }

  public function get_misDocAlumnos($IdAlumno) {
    $db = new Conexion();
    $gmisDocAlmId = [];

    $sql = $db->query("SELECT
tblc_docalumnos.IdDocAlumno,
tblc_docalumnos.IdUsua,
tblc_docalumnos.Anio,
tblc_docalumnos.Mes,
tblc_docalumnos.Archivo,
tblc_docalumnos.FecCap,
tblc_estatus.Estatus,
tblh_tipodocumento.Nombre
FROM
tblc_docalumnos
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docalumnos.Estatus
Left Join tblh_tipodocumento ON tblh_tipodocumento.IdTipoDoc = tblc_docalumnos.IdTipoDocumento WHERE tblc_docalumnos.IdUsua = '$IdAlumno' AND tblc_docalumnos.Estatus <> 4 AND tblc_docalumnos.IdTipoDocumento < 100 ");
    while($x = $db->recorrer($sql)){
      $gmisDocAlmId[] = $x;
    }
    return $gmisDocAlmId;
  }

  public function get_mis_tramites($IdAlumno) {
    $db = new Conexion();
    $get_mis_tramites = [];
    $sql = $db->query("SELECT tblc_docalumnos.IdDocAlumno, tblc_docalumnos.IdUsua, tblc_docalumnos.Anio, tblc_docalumnos.Mes, tblc_docalumnos.Archivo, tblc_docalumnos.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_docalumnos Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docalumnos.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docalumnos.Estatus WHERE tblc_docalumnos.IdUsua = '$IdAlumno' AND tblc_docalumnos.Estatus = 59 ORDER BY tblc_tipodocumento.NomDocumento ASC");
    while($x = $db->recorrer($sql)){
      $get_mis_tramites[] = $x;
    }
    return $get_mis_tramites;
  }

  public function get_mis_avisos_id($IdUsua) {
    $db = new Conexion();
    $get_mis_avisos_id = [];
    $sql = $db->query("SELECT
    tbla_aviso_detalle.IdDetalle,
    tbla_aviso_detalle.IdAviso,
    tbla_aviso_detalle.IdUsua,
    tbla_aviso_detalle.IdEstatus,
    tbla_aviso.Mensaje,
    tbla_aviso.Usuario,
    tbla_aviso.Archivo,
    tbla_aviso.Tipo,
    tbla_aviso.FecCap
    FROM
    tbla_aviso_detalle
    Inner Join tbla_aviso ON tbla_aviso.IdAviso = tbla_aviso_detalle.IdAviso
    WHERE
    tbla_aviso_detalle.IdUsua =  '$IdUsua' AND
    tbla_aviso_detalle.IdEstatus =  '1' LIMIT 1
    ");
    while($x = $db->recorrer($sql)){
      $get_mis_avisos_id[] = $x;
    }
    return $get_mis_avisos_id;
  }

  public function get_mis_reco($IdUsua) {
    $db = new Conexion();
    $get_mis_reco = [];
    $sql = $db->query("SELECT
tblp_reconocimiento.IdReconocimiento,
tblp_reconocimiento.Fecha,
tblp_reconocimiento.FecCap,
tblp_reconocimiento.Anio,
tblp_reconocimiento.Mes,
tblp_reconocimiento.Archivo,
tblp_reconocimiento.Formato,
tblc_tipo_reconocomiento.Reconocimiento
FROM
tblp_reconocimiento
Left Join tblc_tipo_reconocomiento ON tblc_tipo_reconocomiento.IdTipoReconocimiento = tblp_reconocimiento.IdTipo
WHERE tblp_reconocimiento.IdUsua = '$IdUsua'
ORDER BY
tblp_reconocimiento.Fecha DESC
 ");
    while($x = $db->recorrer($sql)){
      $get_mis_reco[] = $x;
    }
    return $get_mis_reco;
  }

  public function get_docs_tramite($IdUsua) {
    $db = new Conexion();
    $get_docs_tramite = [];
    $sql = $db->query("SELECT
tblc_docalumnos.IdDocAlumno,
tblc_docalumnos.IdUsua,
tblc_tipodocumento.NomDocumento,
tblc_ciclo.Ciclo
FROM
tblc_docalumnos
Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docalumnos.IdTipoDocumento
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_docalumnos.IdCiclo
WHERE
tblc_docalumnos.IdUsua =  '$IdUsua' AND
tblc_docalumnos.Estatus =  '1'
");
    while($x = $db->recorrer($sql)){
      $get_docs_tramite[] = $x;
    }
    return $get_docs_tramite;
  }

  public function get_configuracion_campus($IdCampus) {
    $db = new Conexion();
    $get_configuracion_campus = [];
    $sql = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
    while($x = $db->recorrer($sql)){
      $get_configuracion_campus[] = $x;
    }
    return $get_configuracion_campus;
  }

  public function add_asigRecursar(){
    $IdUsua = $_POST["Id"];
    $db = new Conexion();

    $sql8 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.Id = '".$_POST["IdAsig"]."'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $IdAsignacion = $datos81["IdAsignacion"];
    $IdDocMod = $datos81["IdUsua"];

    $sql7 = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' GROUP BY tblp_moduloalumno.IdAsignacion");
    $db->rows($sql7);
    $datos71 = $db->recorrer($sql7);
    $IdEducativa = $datos71["IdEducativa"];
    $IdModulo = $datos71["IdModulo"];
    $Grupo = $datos71["Grupo"];
    $IdGrupo = $datos71["IdGrupo"];
    $EstatusMod = $datos71["Estatus"];

    if($EstatusMod == "Finalizado"){
      $tabCond = ", IdDocente";
      $datCond = ", '$IdDocMod'";
    } else {
      $tabCond = " ";
      $datCond = " ";
    }

    $sql9 = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdModulo =  '$IdModulo'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $semcua = $datos91["Grado"];

    $code = md5(rand() * time());
    $IdModAlum = $code;

    $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo, Inicio) VALUES ('$IdEducativa','$IdModulo','$Grupo','$IdUsua','$EstatusMod',NOW(),'$IdAsignacion','$IdGrupo','REC')");

    $anio = date("Y");
    $mes = date("m");
    $sqly = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.IdAsignacion, tblp_tareas.IdAlumno, tblp_tareas.IdActividadesDocente, tblp_tareas.IdParcialDocente, tblp_actividadesdocente.IdTipoActividad FROM tblp_tareas Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdActividadesDocente = tblp_tareas.IdActividadesDocente WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' GROUP BY tblp_tareas.IdActividadesDocente");
    while($z = $db->recorrer($sqly)){
      $IdTipoA = $z["IdTipoActividad"];
      $IdActividad = $z["IdActividadesDocente"];
       $IdParcial = $z["IdParcialDocente"];

    $sql1e = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, Visto, IdEditor, IdActividadesDocente, IdParcialDocente) VALUES ('$IdAsignacion','$IdUsua','1','$IdT','$IdActividad','$IdParcial')");
    $IdTx = $db->insert_id;
    if($IdTipoA == 1){
      $insertar = $db->query("INSERT INTO tblp_examusuario (IdTarea, IdAsignacion, IdParcialDocente, IdActividadesDocente, IdUsua, IdEstatus) VALUES('$IdTx','$IdAsignacion','$IdParcial','$IdActividad','$IdUsua','12')");
    } else {
       $insertar = $db->query("INSERT INTO tblp_editor (IdTarea, IdActividadesDocente, IdParcialDocente, IdUsua, IdPermiso, IdAsignacion, Anio, Mes, IdEstatus) VALUES ('$IdTx','$IdActividad','$IdParcial','$IdUsua','3','$IdAsignacion','$anio','$mes','12')");
    }

      //$insertar = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, NoActividad, Visto) VALUES ('$IdAsignacion','$IdUsua','$NoActiv','0')");
    }



    if ($insertar) {
      $_SESSION['Alerta']="1";
      echo "<script type='text/javascript'>window.location='adRecursar.php?Id=1254879658$IdUsua&G=$IdGrupo';</script>";
    } else {
      $_SESSION['Alerta']="0";
      echo "<script type='text/javascript'>window.location='adRecursar.php?Id=1254879658$IdUsua&G=$IdGrupo';</script>";
    }
  }

}
?>
