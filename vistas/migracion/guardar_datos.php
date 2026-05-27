<?php
  require('../../php/clases/class.System.php');
  $db = new Conexion();
  $tipoGuardar = $_POST["TipoGuardar"];

  if($tipoGuardar == "act_rvoe_campus"){
    $IdRvoe = $_POST["IdRvoe"];
    $IdCampus = $_POST["IdCampus"];
    $IdEducativa = $_POST["IdEducativa"];

    $insertar = $db->query("INSERT INTO tblc_rvoe_campus (IdRvoe, IdCampus, IdEducativa) VALUES ('$IdRvoe','$IdCampus', '$IdEducativa')");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "quitar_rvoe_campus"){
    $IdRvoe = $_POST["IdRvoe"];
    $IdCampus = $_POST["IdCampus"];
    $IdEducativa = $_POST["IdEducativa"];

    $insertar = $db->query("DELETE FROM tblc_rvoe_campus WHERE tblc_rvoe_campus.IdRvoe = '$IdRvoe' AND tblc_rvoe_campus.IdCampus = '$IdCampus' AND tblc_rvoe_campus.IdEducativa = '$IdEducativa'");

    $db->close();
    echo $insertar;
  }


  if($tipoGuardar == "del_aviso_idok"){
    $IdAviso = $_POST["IdAviso"];

    $insertar = $db->query("DELETE FROM tbla_aviso_detalle WHERE tbla_aviso_detalle.IdAviso = '$IdAviso'");
    $insertar = $db->query("DELETE FROM tbla_aviso WHERE tbla_aviso.IdAviso = '$IdAviso'");

    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "sel_grp_actvar"){
    $IdAviso = $_POST["IdAviso"];
    $IdCiclo = $_POST["IdCiclo"];
    $IdGrupo = $_POST["IdGrupo"];
    $Tipo = $_POST["Tipo"];
    if($Tipo == 1){
      $sql = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8'");
      while($x = $db->recorrer($sql)){
        $insertar = $db->query("INSERT INTO tbla_aviso_detalle (IdAviso, IdUsua, IdEstatus, IdGrupo)  VALUES ('$IdAviso','".$x['IdUsua']."','1','$IdGrupo')");
      }
    } else {
      $insertar = $db->query("DELETE FROM tbla_aviso_detalle WHERE tbla_aviso_detalle.IdAviso = '$IdAviso' AND tbla_aviso_detalle.IdGrupo = '$IdGrupo'");
    }
    
    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "iniciar_reg_escolar"){
    $IdGrupo = $_POST["IdGrupo"];
    $IdCiclo = $_POST["IdCiclo"];
    $Grado = $_POST["Grado"];
    $Fecha = $_POST["Fecha"];

    $insertar = $db->query("UPDATE tblc_ciclogrupo SET tblc_ciclogrupo.IdEstatus = '8' WHERE tblc_ciclogrupo.IdGrupo = '$IdGrupo' AND tblc_ciclogrupo.IdCiclo = '$IdCiclo' AND tblc_ciclogrupo.Grado = '$Grado' ");
    if($insertar){
      $sql_cicxc = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' ");
      while ($x = $db->recorrer($sql_cicxc)) {
        $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap)  VALUES ('$IdGrupo','$IdCiclo','".$x['IdUsua']."','$Grado','R',8,NOW()) ");
      }
      $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.Fecha = '$Fecha', tblp_grupo.Disponible = 'SI', tblp_grupo.IdEstatus = '8' WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
    }
    $db->close();
    echo $insertar;
  }


  
  if($tipoGuardar == "eliminar_usuario_registro"){
    $IdActivo = $_POST["IdActivo"];
    
    $insertar = $db->query("DELETE FROM tblc_alumnos WHERE tblc_alumnos.IdActivo = '$IdActivo' ");
    
    $db->close();
    echo $insertar;
  }


  if($tipoGuardar == "mover_estatus_alumno"){
    $IdActivo = $_POST["IdActivo"];
    $Valor = $_POST["Valor"];
    
    $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = '$Valor' WHERE tblc_alumnos.IdActivo = '$IdActivo' ");
    
    $db->close();
    echo $insertar;
  }



  if($tipoGuardar == "migrar_alumnos_sig"){
    $IdGrupo = $_POST["IdGrupo"];
    $IdCiclo = $_POST["IdCiclo"];
    $Grado = $_POST["Grado"];
    
    $sql_grp = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.IdOferta, tblp_grupo.IdCicloIni, tblp_educativa.IdGrado FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo =  '$IdGrupo' ");
    $db->rows($sql_grp);
    $_grp = $db->recorrer($sql_grp);
    $_idCicloIni = $_grp["IdCicloIni"];
    $_idGrado = $_grp["IdGrado"];
    $_idOferta = $_grp["IdOferta"];

    $sql1 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '$IdCiclo'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $IdCicloAnterior = $datos2["IdCiclo"];
    $_tipo = $datos2["Tipo"];
    $_numero = ($datos2["Numero"] + 1);

    $sql_cic = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Numero = '$_numero' AND tblc_ciclo.Tipo =  '$_tipo'");
    $db->rows($sql_cic);
    $_cix = $db->recorrer($sql_cic);
    $_fecInsc = $_cix["FInicio"];
    $ciclo = isset($_cix["IdCiclo"]);
    
    if(!$ciclo){
      echo 2;
      exit();
    }
  
    $idCicloActual = $_cix["IdCiclo"];

    $sql_col = $db->query("SELECT Count(tblc_conceptosdetalle.IdConceptoDetalle) AS Total FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta = '$_idOferta' AND tblc_conceptosdetalle.IdConcepto < '3' AND tblc_costos_ciclo.IdCiclo =  '$idCicloActual' ");
    $db->rows($sql_col);
    $_col = $db->recorrer($sql_col);
    $_total = $_col["Total"];

    if($_total <> 2){
      echo 8;
      exit();
    }

    #INSCRIPCION
    
    $sql_insc = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosdetalle.IdOferta, tblc_conceptosdetalle.IdConcepto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta = '$_idOferta' AND tblc_conceptosdetalle.IdConcepto = '1' AND tblc_costos_ciclo.IdCiclo =  '$idCicloActual'");
    $db->rows($sql_insc);
    $_insc = $db->recorrer($sql_insc);
    $_monto = $_insc["Monto"];
    $_plan = $_insc["IdConceptoPlan"];
    $_fecha = $_insc["Fecha"];

    $sql_nivel = $db->query("SELECT tblc_ciclogrupo.Grado FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblc_ciclogrupo.IdGrupo =  '$IdGrupo'");
    $db->rows($sql_nivel);
    $_nivel = $db->recorrer($sql_nivel);
    $_niv = $_nivel["Grado"];

    $sql_nivel = $db->query("SELECT Count(tblc_ciclogrupo.Grado) AS Total FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdGrupo =  '$IdGrupo'");
    $db->rows($sql_nivel);
    $_nivel = $db->recorrer($sql_nivel);
    $_niv = $_nivel["Total"];
    $_niv = ($_niv + 1);

    $insertar = $db->query("INSERT INTO tblc_ciclogrupo (IdCiclo, IdGrupo, FecCap, Grado, IdEstatus) VALUES ('$idCicloActual','$IdGrupo',NOW(),'$_niv','8')");
    $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.Grado = '$_niv' WHERE tblp_grupo.IdGrupo = '$IdGrupo'");

    $anioHoy = date("Y");
    if($Grado == 3){

      $sqlyx = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua, tblc_usuario.Usuario FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdEstatus = '8' AND tblc_alumnos.Valor = '1' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCicloAnterior'");
      while($zy = $db->recorrer($sqlyx)){ 
        $IdUs = $zy['IdUsua'];
        $IdActivo = $zy['IdActivo'];
        $_val = $zy['Valor'];
        $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor) VALUES ('$IdGrupo','$idCicloActual','".$zy['IdUsua']."','$_niv','R',8,NOW(),1)");
        $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus,IdGrupo,_idEstatus, IdConcepto,TotalPagado, Recargos, Descuento)  VALUES ('".$zy["IdUsua"]."','$_plan','$_monto','1',NOW(),'$_fecha','$_fecha','$_fecha','$_fecha','NO-F47','1','$anioHoy','$_idOferta','".$zy["Usuario"]."','1','$idCicloActual','1','$IdGrupo','32','1',0,0,0)");
        $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = '3' WHERE tblc_alumnos.IdActivo = '$IdActivo'");
        $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.SemCua = '$_niv' WHERE tblc_usuario.IdUsua = '$IdUs'");
      }

      $sql_col = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosdetalle.IdOferta, tblc_conceptosdetalle.IdConcepto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta = '$_idOferta' AND tblc_conceptosdetalle.IdConcepto = '2' AND tblc_costos_ciclo.IdCiclo =  '$idCicloActual'");
      $db->rows($sql_col);
      $_col = $db->recorrer($sql_col);
      $rwNumero = $_col["Numero"];
      $rwMonto = $_col["Monto"];
      $rwIdConceptoPlan = $_col["IdConceptoPlan"];
      $fecha_actual = $_col["Fecha"];
      
      for ($i = 1; $i <= $rwNumero; $i++) {
        $anio = substr($fecha_actual, 0, 4);
        $sql_user2 = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua, tblc_usuario.Usuario FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdEstatus = '8' AND tblc_alumnos.Valor = '3' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCicloAnterior'");
        while ($_user2 = $db->recorrer($sql_user2)) {
          $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus,IdGrupo,_idEstatus, IdConcepto,TotalPagado, Recargos, Descuento)  VALUES ('".$_user2["IdUsua"]."','$rwIdConceptoPlan','$rwMonto','1',NOW(),'$fecha_actual','$fecha_actual','$fecha_actual','$fecha_actual','NO-F48','1','$anioHoy','$_idOferta','".$_user2["Usuario"]."','1','$idCicloActual','1','$IdGrupo','32','2',0,0,0)");
        }
        $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
      }
      $sqlyv = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua FROM tblc_alumnos WHERE tblc_alumnos.IdEstatus = '8' AND tblc_alumnos.Valor = '2' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCicloAnterior'");
      while($zv = $db->recorrer($sqlyv)){ 
        $IdActivo = $zv['IdActivo'];
        $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = '4' WHERE tblc_alumnos.IdActivo = '$IdActivo'");
      }

    } else {
      $_fecha = $_POST["Fecha"];
      $sqlyx = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua, tblc_usuario.Usuario FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdEstatus = '8' AND tblc_alumnos.Valor = '1' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCicloAnterior'");
      while($zy = $db->recorrer($sqlyx)){ 
        $IdUs = $zy['IdUsua'];
        $IdActivo = $zy['IdActivo'];
        $_val = $zy['Valor'];
        $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap) VALUES ('$IdGrupo','$idCicloActual','".$zy['IdUsua']."','$_niv','R',8,NOW())");
        $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus,IdGrupo,_idEstatus, IdConcepto,TotalPagado, Recargos, Descuento)  VALUES ('".$zy["IdUsua"]."','$_plan','$_monto','1',NOW(),'$_fecha','$_fecha','$_fecha','$_fecha','NO-F49','1','$anioHoy','$_idOferta','".$zy["Usuario"]."','1','$idCicloActual','1','$IdGrupo','32','1',0,0,0)");
        $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = '3' WHERE tblc_alumnos.IdActivo = '$IdActivo'");
        $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.SemCua = '$_niv' WHERE tblc_usuario.IdUsua = '$IdUs'");
      }

      $sqlyv = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua FROM tblc_alumnos WHERE tblc_alumnos.IdEstatus = '8' AND tblc_alumnos.Valor = '2' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCicloAnterior'");
      while($zv = $db->recorrer($sqlyv)){ 
        $IdActivo = $zv['IdActivo'];
        $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = '4' WHERE tblc_alumnos.IdActivo = '$IdActivo'");
      }
    }

    $insertar = $db->query("UPDATE tblc_ciclogrupo SET tblc_ciclogrupo.Migrado = '1', tblc_ciclogrupo.IdEstatus = '8' WHERE tblc_ciclogrupo.IdGrupo = '$IdGrupo' AND tblc_ciclogrupo.IdCiclo = '$IdCicloAnterior' ");
    $insertar = $db->query("UPDATE tblc_ciclogrupo SET tblc_ciclogrupo.IdEstatus = '8' WHERE tblc_ciclogrupo.IdGrupo = '$IdGrupo' AND tblc_ciclogrupo.IdCiclo = '$idCicloActual' ");
    
    $db->close();
    echo $insertar;
  }

  if ($tipoGuardar == "sav_enlaza_grp") {
    $IdCiclo = $_POST["IdCiclo"];
    $IdGrupo = $_POST["IdGrupo"];
    $Grado = $_POST["Grado"];

    if($Grado == 1){
      $IdConGrado = "1";
    } else {
      $IdConGrado = "3";
    }
    
    
    $_vax = 0;
    $db = new Conexion();
    $grado_nuevo = $Grado + 1;
  
    $sql_cx = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '$IdCiclo'");
    $db->rows($sql_cx);
    $_cicx = $db->recorrer($sql_cx);
    $rwTipo = $_cicx["Tipo"];
    $rwNumero = $_cicx["Numero"] + 1;
    $_grado = $rwNumero;
  
    #Id del plan de estudios
    $sql_ofer = $db->query("SELECT tblp_grupo.IdOferta, tblp_grupo.IdCampus, tblp_educativa.IdGrado FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
    $db->rows($sql_ofer);
    $_oferta = $db->recorrer($sql_ofer);
    $IdOferta = $_oferta["IdOferta"];
    $IdCampus = $_oferta["IdCampus"];
    $IdGrado = $_oferta["IdGrado"];
  
    #Ciclo nuevo
    $sql_cicl = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Numero =  '$rwNumero' AND tblc_ciclo.Tipo = '$rwTipo' ");
    $db->rows($sql_cicl);
    $_ciclo = $db->recorrer($sql_cicl);
    $rwIdCiclo = $_ciclo["IdCiclo"];
  
    
    #Verificamos que exista el pago reinscripcion
    $pag_reins = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdPlan, tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
    $db->rows($pag_reins);
    $pag_reins = $db->recorrer($pag_reins);
      
    if (!isset($pag_reins["IdConceptoDetalle"])) {
      echo 3;
      exit();
    }
    $monto_reins = $pag_reins["Monto"];
    $fecha_reins = $pag_reins["Fecha"];
    $IdPlan_reins = $pag_reins["IdPlan"];

    #Verificamos que exista el pago colegiatura
    $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '2' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
    $db->rows($sql_cicl);
    $_ciclo = $db->recorrer($sql_cicl);
    

    
  
    if (!isset($_ciclo["IdConceptoDetalle"])) {
      echo 2;
      exit();
    }
    $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];
    $rwMonto = $_ciclo["Monto"];
    $rwNumero = $_ciclo["Numero"];
    $rwFecha = $_ciclo["Fecha"];
    $rwIdConceptoPlan = $_ciclo["IdConceptoPlan"];

    $anioHoy = date("Y");

    $reins_importe = $monto_reins;
    $porcentaje = 0;


    $sqlyx = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua, tblc_usuario.Usuario FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdEstatus = '8' AND tblc_alumnos.Valor = '1' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
    while($zy = $db->recorrer($sqlyx)){
      $IdUs = $zy['IdUsua'];
      $IdActivo = $zy['IdActivo'];
      $_val = $zy['Valor'];

      #Obtenemos la beca anterior
      // $sql_beca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUs' AND tblp_beca.IdConcepto = '$IdConGrado' AND  tblp_beca.IdCiclo = '$IdCiclo' ");
      // $db->rows($sql_beca);
      // $_beca = $db->recorrer($sql_beca);  

      // if($IdGrado == 1){
      //   #Obtenemos la beca anterior
      //   // $sql_beca = $db->query("SELECT * FROm tblp_beca WHERE tblp_beca.IdUsua = '$IdUs' AND tblp_beca.IdCiclo = '$IdCiclo' ");
      //   // $db->rows($sql_beca);
      //   // $_beca = $db->recorrer($sql_beca);
      //   $reins_importe = $monto_reins; $reins_descuento = 0; $reins_total = $monto_reins; $porcentaje = 0;
        
        

      // } elseif($IdGrado == 2){
      //     $reins_importe = $monto_reins; $reins_descuento = 0; $reins_total = $monto_reins; $porcentaje = 0;
  
      // } elseif($IdGrado == 3){
              
      //   $reins_importe = $monto_reins;
      //   $pago_actual = $_beca['Total'];
      //   $reins_descuento = ($reins_importe - $pago_actual);
        
      //   $_porx = $pago_actual / $reins_importe;
      //   $_col = ($_porx * 100);
      //   $cal1 = (100 - $_col);
      //   $porcentaje = intval($cal1);

      //   $reins_total = $pago_actual;
      //   if($pago_porcentaje >= 80){
      //     $reins_importe = $monto_reins; $reins_descuento = 0; $reins_total = $monto_reins; $porcentaje = 0;
      //   }

      // } elseif($IdGrado == 4){
      //   $reins_importe = $monto_reins; $reins_descuento = 0; $reins_total = $monto_reins; $porcentaje = 0;
      // }

      // if(isset($_beca['Total'])){
      //   if($_beca['Total'] > $monto_reins){
      //     $reins_importe = $_beca['Total']; $reins_descuento = 0; $reins_total = $_beca['Total']; $porcentaje = 0;
      //   }
      // }

      // if(isset($_beca['Porcentaje'])){
      //   if($_beca['Porcentaje'] >= 80){
      //     $reins_importe = $monto_reins; $reins_descuento = 0; $reins_total = $monto_reins; $porcentaje = 0;
      //   }
      // }

      
      $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor) VALUES ('$IdGrupo','$rwIdCiclo','".$zy['IdUsua']."','$grado_nuevo','R',8,NOW(),1)");
      $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,FecCap,Fecha,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus,IdGrupo,_idEstatus, IdConcepto,TotalPagado, Recargos, Descuento,IdConceptoPlan) VALUES ('".$zy["IdUsua"]."','$reins_importe','1',NOW(),'$fecha_reins','NO','1','$anioHoy','$IdOferta','".$zy["Usuario"]."','1','$rwIdCiclo','1','$IdGrupo','32','3',0,0,0,'$IdPlan_reins')");
      $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = '3' WHERE tblc_alumnos.IdActivo = '$IdActivo'");
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.SemCua = '$grado_nuevo' WHERE tblc_usuario.IdUsua = '$IdUs'");
      $insertar = $db->query("INSERT INTO tblp_personalizado (IdUsua, IdCiclo, IdOferta, FecCap, Tipo, Grado, IdGrupo) VALUES ('" . $zy['IdUsua'] . "','$rwIdCiclo','$IdOferta',NOW(),'R','$grado_nuevo','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('" . $zy['IdUsua'] . "','103','1','$rwIdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('" . $zy['IdUsua'] . "','105','1','$rwIdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total, IdGrupo)  
      VALUES ('" . $zy['IdUsua'] . "','3','$porcentaje',NOW(),'1','8','1000','$rwIdCiclo','0','".$reins_importe."', '0', '".$reins_importe."', '$IdGrupo')");

    }

  
    $mens_importe = $rwMonto;

    $mont = 0;
    $fecha_actual = $rwFecha;
    for ($i = 1; $i <= $rwNumero; $i++) {
      $anio = substr($fecha_actual, 0, 4);
      // $sql_user2 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdEstatus = '8' AND tblc_usuario.IdGrupo = '$IdGrupo'");
      $sql_user2 = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua, tblc_usuario.Usuario FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdEstatus = '8' AND tblc_alumnos.Valor = '3' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
      while ($_user2 = $db->recorrer($sql_user2)) {
        $mont = 0;
        $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('" . $_user2['IdUsua'] . "','$rwMonto','1','$IdOferta',NOW(),'$fecha_actual','$rwIdCiclo','$anio','$rwIdConceptoPlan','$IdCampus','NO-F51','2','1','32','2',0,0,0,'$IdGrupo')");
        $IdUsuarioId = $_user2['IdUsua'];
        // if($IdGrado == 4){
        //   $mens_importe = $rwMonto; $mens_descuento = 0; $mens_total = $rwMonto; $porcentaje = 0;
  
        // } else{
        //   #Obtenemos la beca anterior
        //   $sql_beca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsuarioId' AND tblp_beca.IdConcepto = '2' AND  tblp_beca.IdCiclo = '$IdCiclo' ");
        //   $db->rows($sql_beca);
        //   $_beca = $db->recorrer($sql_beca);        
        //   $mens_importe = $rwMonto;
        //   $pago_actual = $_beca['Total'];
        //   $pago_porcentaje = $_beca['Porcentaje'];
        //   $mens_descuento = ($mens_importe - $pago_actual);
          
        //   $_porx = $pago_actual / $mens_importe;
        //   $_col = ($_porx * 100);
        //   $cal1 = (100 - $_col);
        //   $porcentaje = intval($cal1);
  
        //   $mens_total = $pago_actual;
  
        //   if($pago_porcentaje >= 80){
        //     $porcentaje = 0;
        //     $mens_importe = $rwMonto;
        //     $mens_total = $rwMonto;
        //     $mens_descuento = 0;
        //   }
        // }
        $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total, IdGrupo) 
        VALUES ('$IdUsuarioId','2','$porcentaje',NOW(),'1','8','1000','$rwIdCiclo','0','".$mens_importe."', '0', '".$mens_importe."', '$IdGrupo')");  
        
      }

      $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
    }


    $sqlyv = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua FROM tblc_alumnos WHERE tblc_alumnos.IdEstatus = '8' AND tblc_alumnos.Valor = '2' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
    while($zv = $db->recorrer($sqlyv)){ 
      $IdActivo = $zv['IdActivo'];
      $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = '4' WHERE tblc_alumnos.IdActivo = '$IdActivo'");
    }

    $bi = 0;
    $bf = 0;
    $beca_dup = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto =  '2' AND tblp_beca.IdGrupo = '$IdGrupo' AND tblp_beca.IdCiclo = '$rwIdCiclo' ORDER BY tblp_beca.IdUsua");
    while($_bex = $db->recorrer($beca_dup)){
      $bi = $_bex['IdUsua'];
      if($bi <> $bf){
      } else {
        $insertar = $db->query("DELETE FROM tblp_beca WHERE tblp_beca.IdBeca = '".$_bex['IdBeca']."' ");
      }
      $bf = $_bex['IdUsua'];
    }



    #VALIDAMOS LA BECA DEDL PERIODO ANTERIOR

    $sql_all = $db->query("SELECT tblc_alumnos.IdUsua FROM tblc_alumnos WHERE tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$rwIdCiclo'");
    while($all = $db->recorrer($sql_all)){
      $IdUsua = $all['IdUsua'];
      

      $sqlyv = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$rwIdCiclo'");
      while($zv = $db->recorrer($sqlyv)){
        $IdConcepto = $zv['IdConcepto'];

        // if($grado_nuevo == 2){
        //   if($zv['IdConcepto'] == 3){
        //     $IdConcepto = 1; 
        //   } else {
        //     $IdConcepto = $zv['IdConcepto'];
        //   }
        // }
        
        if($zv['IdConcepto'] == 2){
          $IdConcepto = 2;
          #Verificamos la beca anterior del periodo anterior
          $pag_vaca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto = '$IdConcepto' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' ");
          
          $db->rows($pag_vaca);
          $pago_vaca = $db->recorrer($pag_vaca);    
          $Total = $pago_vaca['Total'];
          $IdUsuaCap = $pago_vaca['IdUsuaCap'];
          $Importe = $zv['Importe'];
          
          $descuento = ($Importe - $Total);

          $_porx = $Total / $Importe;
          $_col = ($_porx * 100);
          $cal1 = (100 - $_col);
          $cal1 = substr($cal1, 0, 8);
          $comentario = $pago_vaca['Comentario'].'- MIGRACION';

          if($cal1 < 90){
            $IdEstatus = 8;
          } else {
            $IdEstatus = 1;
          }

          $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.IdEstatus = '$IdEstatus', tblp_beca.IdUsuaCap = '$IdUsuaCap', tblp_beca.Descuento = '$descuento', tblp_beca.Total = '$Total', tblp_beca.Porcentaje = '$cal1',  tblp_beca.Comentario = '$comentario' WHERE tblp_beca.IdBeca = '".$zv['IdBeca']."' ");

      } else {
          $IdConcepto = 3;
          #Verificamos la beca anterior del periodo anterior
          $pag_vaca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto = '3' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' ");
          $db->rows($pag_vaca);
          $pago_vaca = $db->recorrer($pag_vaca);
          if(isset($pago_vaca['IdBeca'])){
            $Total = $pago_vaca['Total'];
            $IdUsuaCap = $pago_vaca['IdUsuaCap'];
            $comentario = $pago_vaca['Comentario'].'- MIGRACION';

          } else {
            $pag_vaca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto = '1' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' ");
            $db->rows($pag_vaca);
            $pago_vaca = $db->recorrer($pag_vaca);

            $Total = $pago_vaca['Total'];
            $IdUsuaCap = $pago_vaca['IdUsuaCap'];
            $comentario = $pago_vaca['Comentario'].'- MIGRACION';

          }
          $Importe = $zv['Importe'];
          
          $descuento = ($Importe - $Total);

          $_porx = $Total / $Importe;
          $_col = ($_porx * 100);
          $cal1 = (100 - $_col);
          $cal1 = substr($cal1, 0, 8);
          

          if($cal1 < 90){
            $IdEstatus = 8;
          } else {
            $IdEstatus = 1;
          }

          $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.IdEstatus = '$IdEstatus', tblp_beca.IdUsuaCap = '$IdUsuaCap', tblp_beca.Descuento = '$descuento', tblp_beca.Total = '$Total', tblp_beca.Porcentaje = '$cal1',  tblp_beca.Comentario = '$comentario' WHERE tblp_beca.IdBeca = '".$zv['IdBeca']."' ");

      }
        
      }
    }



    
    $insertar = $db->query("UPDATE tblc_ciclogrupo SET tblc_ciclogrupo.Migrado = '1', tblc_ciclogrupo.IdEstatus = '8' WHERE tblc_ciclogrupo.IdGrupo = '$IdGrupo' AND tblc_ciclogrupo.IdCiclo = '$IdCiclo' ");
    

    $insertar = $db->query("INSERT INTO tblc_ciclogrupo (IdCiclo, IdGrupo, FecCap, Grado, IdEstatus) VALUES ('$rwIdCiclo','$IdGrupo',NOW(),'$grado_nuevo','8')");
    $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.Grado = '$grado_nuevo' WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  

    if ($insertar) {
      echo $insertar;
    } else {
      echo 0;
    }
  }

  if ($tipoGuardar == "sav_enlaza_grp_especial_id") {
    $IdCiclo = $_POST["IdCiclo"];
    $IdGrupo = $_POST["IdGrupo"];
    $Grado = $_POST["Grado"];
    $IdUsua = $_POST["IdUsua"];

    if($Grado == 1){
      $IdConGrado = "1";
    } else {
      $IdConGrado = "3";
    }
    
    
    $_vax = 0;
    $db = new Conexion();
    $grado_nuevo = $Grado + 1;
  
    $sql_cx = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '$IdCiclo'");
    $db->rows($sql_cx);
    $_cicx = $db->recorrer($sql_cx);
    $rwTipo = $_cicx["Tipo"];
    $rwNumero = $_cicx["Numero"] + 1;
    $_grado = $rwNumero;
  
    #Id del plan de estudios
    $sql_ofer = $db->query("SELECT tblp_grupo.IdOferta, tblp_grupo.IdCampus, tblp_educativa.IdGrado FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
    $db->rows($sql_ofer);
    $_oferta = $db->recorrer($sql_ofer);
    $IdOferta = $_oferta["IdOferta"];
    $IdCampus = $_oferta["IdCampus"];
    $IdGrado = $_oferta["IdGrado"];
  
    #Ciclo nuevo
    $sql_cicl = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Numero =  '$rwNumero' AND tblc_ciclo.Tipo = '$rwTipo' ");
    $db->rows($sql_cicl);
    $_ciclo = $db->recorrer($sql_cicl);
    $rwIdCiclo = $_ciclo["IdCiclo"];
  
    
    #Verificamos que exista el pago reinscripcion
    $pag_reins = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdPlan, tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
    $db->rows($pag_reins);
    $pag_reins = $db->recorrer($pag_reins);
      
    if (!isset($pag_reins["IdConceptoDetalle"])) {
      echo 3;
      exit();
    }
    $monto_reins = $pag_reins["Monto"];
    $fecha_reins = $pag_reins["Fecha"];
    $IdPlan_reins = $pag_reins["IdPlan"];

    #Verificamos que exista el pago colegiatura
    $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '2' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
    $db->rows($sql_cicl);
    $_ciclo = $db->recorrer($sql_cicl);
    

    
  
    if (!isset($_ciclo["IdConceptoDetalle"])) {
      echo 2;
      exit();
    }
    $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];
    $rwMonto = $_ciclo["Monto"];
    $rwNumero = $_ciclo["Numero"];
    $rwFecha = $_ciclo["Fecha"];
    $rwIdConceptoPlan = $_ciclo["IdConceptoPlan"];

    $anioHoy = date("Y");

    $reins_importe = $monto_reins;
    $porcentaje = 0;


    $sqlyx = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua, tblc_usuario.Usuario FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdEstatus = '8' AND tblc_alumnos.IdUsua = '$IdUsua' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
    while($zy = $db->recorrer($sqlyx)){
      $IdUs = $zy['IdUsua'];
      $IdActivo = $zy['IdActivo'];
      $_val = $zy['Valor'];

      $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor) VALUES ('$IdGrupo','$rwIdCiclo','".$zy['IdUsua']."','$grado_nuevo','R',8,NOW(),1)");
      $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,FecCap,Fecha,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus,IdGrupo,_idEstatus, IdConcepto,TotalPagado, Recargos, Descuento,IdConceptoPlan) VALUES ('".$zy["IdUsua"]."','$reins_importe','1',NOW(),'$fecha_reins','NO','1','$anioHoy','$IdOferta','".$zy["Usuario"]."','1','$rwIdCiclo','1','$IdGrupo','32','3',0,0,0,'$IdPlan_reins')");
      $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = '3' WHERE tblc_alumnos.IdActivo = '$IdActivo'");
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.SemCua = '$grado_nuevo' WHERE tblc_usuario.IdUsua = '$IdUs'");
      $insertar = $db->query("INSERT INTO tblp_personalizado (IdUsua, IdCiclo, IdOferta, FecCap, Tipo, Grado, IdGrupo) VALUES ('" . $zy['IdUsua'] . "','$rwIdCiclo','$IdOferta',NOW(),'R','$grado_nuevo','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('" . $zy['IdUsua'] . "','103','1','$rwIdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('" . $zy['IdUsua'] . "','105','1','$rwIdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total, IdGrupo)  
      VALUES ('" . $zy['IdUsua'] . "','3','$porcentaje',NOW(),'1','8','1000','$rwIdCiclo','0','".$reins_importe."', '0', '".$reins_importe."', '$IdGrupo')");

    }

  
    $mens_importe = $rwMonto;

    $mont = 0;
    $fecha_actual = $rwFecha;
    for ($i = 1; $i <= $rwNumero; $i++) {
      $anio = substr($fecha_actual, 0, 4);
      // $sql_user2 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdEstatus = '8' AND tblc_usuario.IdGrupo = '$IdGrupo'");
      $sql_user2 = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua, tblc_usuario.Usuario FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdEstatus = '8' AND tblc_alumnos.IdUsua = '$IdUsua' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
      while ($_user2 = $db->recorrer($sql_user2)) {
        $mont = 0;
        $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('" . $_user2['IdUsua'] . "','$rwMonto','1','$IdOferta',NOW(),'$fecha_actual','$rwIdCiclo','$anio','$rwIdConceptoPlan','$IdCampus','NO-F51','2','1','32','2',0,0,0,'$IdGrupo')");
        $IdUsuarioId = $_user2['IdUsua'];
        
        $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total, IdGrupo) 
        VALUES ('$IdUsuarioId','2','$porcentaje',NOW(),'1','8','1000','$rwIdCiclo','0','".$mens_importe."', '0', '".$mens_importe."', '$IdGrupo')");  
        
      }

      $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
    }


    

    $bi = 0;
    $bf = 0;
    $beca_dup = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto =  '2' AND tblp_beca.IdGrupo = '$IdGrupo' AND tblp_beca.IdCiclo = '$rwIdCiclo' ORDER BY tblp_beca.IdUsua");
    while($_bex = $db->recorrer($beca_dup)){
      $bi = $_bex['IdUsua'];
      if($bi <> $bf){
      } else {
        $insertar = $db->query("DELETE FROM tblp_beca WHERE tblp_beca.IdBeca = '".$_bex['IdBeca']."' ");
      }
      $bf = $_bex['IdUsua'];
    }



    #VALIDAMOS LA BECA DEDL PERIODO ANTERIOR

    $sql_all = $db->query("SELECT tblc_alumnos.IdUsua FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$rwIdCiclo'");
    while($all = $db->recorrer($sql_all)){
      $IdUsua = $all['IdUsua'];
      

      $sqlyv = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$rwIdCiclo'");
      while($zv = $db->recorrer($sqlyv)){
        $IdConcepto = $zv['IdConcepto'];

        // if($grado_nuevo == 2){
        //   if($zv['IdConcepto'] == 3){
        //     $IdConcepto = 1; 
        //   } else {
        //     $IdConcepto = $zv['IdConcepto'];
        //   }
        // }
        
        if($zv['IdConcepto'] == 2){
          $IdConcepto = 2;
          #Verificamos la beca anterior del periodo anterior
          $pag_vaca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto = '$IdConcepto' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' ");
          
          $db->rows($pag_vaca);
          $pago_vaca = $db->recorrer($pag_vaca);    
          $Total = $pago_vaca['Total'];
          $IdUsuaCap = $pago_vaca['IdUsuaCap'];
          $Importe = $zv['Importe'];
          
          $descuento = ($Importe - $Total);

          $_porx = $Total / $Importe;
          $_col = ($_porx * 100);
          $cal1 = (100 - $_col);
          $cal1 = substr($cal1, 0, 8);
          $comentario = $pago_vaca['Comentario'].'- MIGRACION';

          if($cal1 < 90){
            $IdEstatus = 8;
          } else {
            $IdEstatus = 1;
          }

          $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.IdEstatus = '$IdEstatus', tblp_beca.IdUsuaCap = '$IdUsuaCap', tblp_beca.Descuento = '$descuento', tblp_beca.Total = '$Total', tblp_beca.Porcentaje = '$cal1',  tblp_beca.Comentario = '$comentario' WHERE tblp_beca.IdBeca = '".$zv['IdBeca']."' ");

      } else {
          $IdConcepto = 3;
          #Verificamos la beca anterior del periodo anterior
          $pag_vaca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto = '3' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' ");
          $db->rows($pag_vaca);
          $pago_vaca = $db->recorrer($pag_vaca);
          if(isset($pago_vaca['IdBeca'])){
            $Total = $pago_vaca['Total'];
            $IdUsuaCap = $pago_vaca['IdUsuaCap'];
            $comentario = $pago_vaca['Comentario'].'- MIGRACION';

          } else {
            $pag_vaca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto = '1' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo' ");
            $db->rows($pag_vaca);
            $pago_vaca = $db->recorrer($pag_vaca);

            $Total = $pago_vaca['Total'];
            $IdUsuaCap = $pago_vaca['IdUsuaCap'];
            $comentario = $pago_vaca['Comentario'].'- MIGRACION';

          }
          $Importe = $zv['Importe'];
          
          $descuento = ($Importe - $Total);

          $_porx = $Total / $Importe;
          $_col = ($_porx * 100);
          $cal1 = (100 - $_col);
          $cal1 = substr($cal1, 0, 8);
          

          if($cal1 < 90){
            $IdEstatus = 8;
          } else {
            $IdEstatus = 1;
          }

          $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.IdEstatus = '$IdEstatus', tblp_beca.IdUsuaCap = '$IdUsuaCap', tblp_beca.Descuento = '$descuento', tblp_beca.Total = '$Total', tblp_beca.Porcentaje = '$cal1',  tblp_beca.Comentario = '$comentario' WHERE tblp_beca.IdBeca = '".$zv['IdBeca']."' ");

      }
        
      }
    }

    $asig = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.Tipo= '2' AND  tblp_asignacion.IdCiclo = '$rwIdCiclo' AND tblp_asignacion.IdGrupo = '$IdGrupo' ");
    while($_asig = $db->recorrer($asig)){
      $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo)  VALUES ('".$_asig['IdEducativa']."','".$_asig['IdModulo']."','".$_asig['Grupo']."','$IdUsua','Activo',NOW(),'".$_asig['IdAsignacion']."','$IdGrupo')");
    }



    if ($insertar) {
      echo $insertar;
    } else {
      echo 0;
    }
  }


  if ($tipoGuardar == "inscribir_alumno_especial_id") {
    $IdCiclo = $_POST["IdCiclo"];
    $Nota = $_POST["Nota"];
    $IdAdmin = $_POST["IdAdmin"];
    $IdUsua = $_POST["IdUsua"];

    $sql_mi = $db->query("SELECT * FROM tblc_alumnos WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_alumnos.IdUsua = '$IdUsua'");
    $db->rows($sql_mi);
    $_mi = $db->recorrer($sql_mi);
    $IdGrupo = $_mi["IdGrupo"];
    $Grado = $_mi["Grado"];

    if($Grado == 1){
      $IdConGrado = "1";
    } else {
      $IdConGrado = "3";
    }
    
    
    $_vax = 0;
    $db = new Conexion();
    $grado_nuevo = $Grado + 1;
  
    $sql_cx = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '$IdCiclo'");
    $db->rows($sql_cx);
    $_cicx = $db->recorrer($sql_cx);
    $rwTipo = $_cicx["Tipo"];
    $rwNumero = $_cicx["Numero"] + 1;
    $_grado = $rwNumero;
  
    #Id del plan de estudios
    $sql_ofer = $db->query("SELECT tblp_grupo.IdOferta, tblp_grupo.IdCampus, tblp_educativa.IdGrado FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
    $db->rows($sql_ofer);
    $_oferta = $db->recorrer($sql_ofer);
    $IdOferta = $_oferta["IdOferta"];
    $IdCampus = $_oferta["IdCampus"];
    $IdGrado = $_oferta["IdGrado"];
  
    #Ciclo nuevo
    $sql_cicl = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Numero =  '$rwNumero' AND tblc_ciclo.Tipo = '$rwTipo' ");
    $db->rows($sql_cicl);
    $_ciclo = $db->recorrer($sql_cicl);
    $rwIdCiclo = $_ciclo["IdCiclo"];
  
    #Verificamos que exista el pago reinscripcion
    $pag_reins = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdPlan, tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
    $db->rows($pag_reins);
    $pag_reins = $db->recorrer($pag_reins);
      
    if (!isset($pag_reins["IdConceptoDetalle"])) {
      echo 3;
      exit();
    }
    $monto_reins = $pag_reins["Monto"];
    $fecha_reins = $pag_reins["Fecha"];
    $IdPlan_reins = $pag_reins["IdPlan"];

    #Verificamos que exista el pago colegiatura
    $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '2' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
    $db->rows($sql_cicl);
    $_ciclo = $db->recorrer($sql_cicl);
    
    
  
    if (!isset($_ciclo["IdConceptoDetalle"])) {
      echo 2;
      exit();
    }
    $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];
    $rwMonto = $_ciclo["Monto"];
    $rwNumero = $_ciclo["Numero"];
    $rwFecha = $_ciclo["Fecha"];
    $rwIdConceptoPlan = $_ciclo["IdConceptoPlan"];

    $anioHoy = date("Y");

    $sqlyx = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua, tblc_usuario.Usuario FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.Valor = '4' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
    while($zy = $db->recorrer($sqlyx)){
      $IdUs = $zy['IdUsua'];
      $IdActivo = $zy['IdActivo'];
      $_val = $zy['Valor'];

      #Obtenemos la beca anterior
      $sql_beca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUs' AND tblp_beca.IdConcepto = '$IdConGrado' AND  tblp_beca.IdCiclo = '$IdCiclo' ");
      $db->rows($sql_beca);
      $_beca = $db->recorrer($sql_beca);  

      if($IdGrado == 1){
        #Obtenemos la beca anterior
        // $sql_beca = $db->query("SELECT * FROm tblp_beca WHERE tblp_beca.IdUsua = '$IdUs' AND tblp_beca.IdCiclo = '$IdCiclo' ");
        // $db->rows($sql_beca);
        // $_beca = $db->recorrer($sql_beca);
        $reins_importe = $monto_reins; $reins_descuento = 0; $reins_total = $monto_reins; $porcentaje = 0;
        
        

      } elseif($IdGrado == 2){
          $reins_importe = $monto_reins; $reins_descuento = 0; $reins_total = $monto_reins; $porcentaje = 0;
  
      } elseif($IdGrado == 3){
              
        $reins_importe = $monto_reins;
        $pago_actual = $_beca['Total'];
        $reins_descuento = ($reins_importe - $pago_actual);
        
        $_porx = $pago_actual / $reins_importe;
        $_col = ($_porx * 100);
        $cal1 = (100 - $_col);
        $porcentaje = intval($cal1);

        $reins_total = $pago_actual;
        if($pago_porcentaje >= 80){
          $reins_importe = $monto_reins; $reins_descuento = 0; $reins_total = $monto_reins; $porcentaje = 0;
        }

      } elseif($IdGrado == 4){
        $reins_importe = $monto_reins; $reins_descuento = 0; $reins_total = $monto_reins; $porcentaje = 0;
      }

      if(isset($_beca['Total'])){
        if($_beca['Total'] > $monto_reins){
          $reins_importe = $_beca['Total']; $reins_descuento = 0; $reins_total = $_beca['Total']; $porcentaje = 0;
        }
      }

      if(isset($_beca['Porcentaje'])){
        if($_beca['Porcentaje'] >= 80){
          $reins_importe = $monto_reins; $reins_descuento = 0; $reins_total = $monto_reins; $porcentaje = 0;
        }
      }



      $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor) VALUES ('$IdGrupo','$rwIdCiclo','".$zy['IdUsua']."','$grado_nuevo','R',8,NOW(),1)");
      $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,FecCap,Fecha,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus,IdGrupo,_idEstatus, IdConcepto,TotalPagado, Recargos, Descuento,IdConceptoPlan) VALUES ('".$zy["IdUsua"]."','$reins_importe','1',NOW(),'$fecha_reins','NO-F52','1','$anioHoy','$IdOferta','".$zy["Usuario"]."','1','$rwIdCiclo','1','$IdGrupo','32','3',0,0,0,'$IdPlan_reins')");
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.SemCua = '$grado_nuevo' WHERE tblc_usuario.IdUsua = '$IdUs'");
      $insertar = $db->query("INSERT INTO tblp_personalizado (IdUsua, IdCiclo, IdOferta, FecCap, Tipo, Grado, IdGrupo) VALUES ('" . $zy['IdUsua'] . "','$rwIdCiclo','$IdOferta',NOW(),'R','$grado_nuevo','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('" . $zy['IdUsua'] . "','103','1','$rwIdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('" . $zy['IdUsua'] . "','105','1','$rwIdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total, IdGrupo)  VALUES ('" . $zy['IdUsua'] . "','3','$porcentaje',NOW(),'1','8','1000','$rwIdCiclo','0','".$reins_importe."', '$reins_descuento', '".$reins_total."', '$IdGrupo')");

    }

  
  
    $mont = 0;
    $fecha_actual = $rwFecha;
    for ($i = 1; $i <= $rwNumero; $i++) {
      $anio = substr($fecha_actual, 0, 4);
      $sql_user2 = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua, tblc_usuario.Usuario FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.Valor = '4' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
      while ($_user2 = $db->recorrer($sql_user2)) {
        $mont = 0;
        $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('" . $_user2['IdUsua'] . "','$rwMonto','1','$IdOferta',NOW(),'$fecha_actual','$rwIdCiclo','$anio','$rwIdConceptoPlan','$IdCampus','NO-F53','2','1','32','2',0,0,0,'$IdGrupo')");
        $IdUsuarioId = $_user2['IdUsua'];
        if($IdGrado == 4){
          $mens_importe = $rwMonto; $mens_descuento = 0; $mens_total = $rwMonto; $porcentaje = 0;
  
        } else{
          #Obtenemos la beca anterior
          $sql_beca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsuarioId' AND tblp_beca.IdConcepto = '2' AND  tblp_beca.IdCiclo = '$IdCiclo' ");
          $db->rows($sql_beca);
          $_beca = $db->recorrer($sql_beca);        
          $mens_importe = $rwMonto;
          $pago_actual = $_beca['Total'];
          $pago_porcentaje = $_beca['Porcentaje'];
          $mens_descuento = ($mens_importe - $pago_actual);
          
          $_porx = $pago_actual / $mens_importe;
          $_col = ($_porx * 100);
          $cal1 = (100 - $_col);
          $porcentaje = intval($cal1);
  
          $mens_total = $pago_actual;
  
          if($pago_porcentaje >= 80){
            $porcentaje = 0;
            $mens_importe = $rwMonto;
            $mens_total = $rwMonto;
            $mens_descuento = 0;
          }
        }
        $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total, IdGrupo) VALUES ('$IdUsuarioId','2','$porcentaje',NOW(),'1','8','1000','$rwIdCiclo','0','".$mens_importe."', '$mens_descuento', '".$mens_total."', '$IdGrupo')");  
        
      }

      $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
    }


    $sqlyv = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.Valor = '4' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
    while($zv = $db->recorrer($sqlyv)){ 
      $IdActivo = $zv['IdActivo'];
      $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = '3' WHERE tblc_alumnos.IdActivo = '$IdActivo'");
    }


    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_asignacion.Grupo FROM tblp_asignacion WHERE tblp_asignacion.IdCiclo = '$rwIdCiclo' AND  tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.Tipo = '2'");
    while ($x = $db->recorrer($sql)) {
      $IdOferta = $x["IdEducativa"];
      $IdMod = $x["IdModulo"];
      $IdAsig = $x["IdAsignacion"];
      $Grp = $x["Grupo"];
      $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo) VALUES ('$IdOferta','$IdMod','$Grp',$IdUsua,'Activo',NOW(),'$IdAsig','$IdGrupo')");
    }

    $sql2 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_tareas.IdTarea, tblp_tareas.IdParcialDocente, tblp_tareas.IdActividadesDocente FROM tblp_asignacion Left Join tblp_tareas ON tblp_tareas.IdAsignacion = tblp_asignacion.IdAsignacion WHERE tblp_asignacion.IdCiclo = '$rwIdCiclo' AND tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.Tipo =  '2' GROUP BY tblp_tareas.IdActividadesDocente");
    while ($x = $db->recorrer($sql2)) {
      $IdAsignacion = $x["IdAsignacion"];
      $IdParcialDocente = $x["IdParcialDocente"];
      $IdActividadesDocente = $x["IdActividadesDocente"];
      $insertar = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente) VALUES ('$IdAsignacion','$IdUsua','$IdActividadesDocente','$IdParcialDocente')");
    }


    $Fecha = date("Y-m-d");
    $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin)  VALUES ('$IdUsua','$rwIdCiclo','$Fecha',NOW(),'$Nota','3','$IdAdmin')");

    // $bi = 0;
    // $bf = 0;
    // $beca_dup = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto =  '2' AND tblp_beca.IdGrupo = '$IdGrupo' AND tblp_beca.IdCiclo = '$rwIdCiclo' ORDER BY tblp_beca.IdUsua");
    // while($_bex = $db->recorrer($beca_dup)){
    //   $bi = $_bex['IdUsua'];
    //   if($bi <> $bf){
    //   } else {
    //     $insertar = $db->query("DELETE FROM tblp_beca WHERE tblp_beca.IdBeca = '".$_bex['IdBeca']."' ");
    //   }
    //   $bf = $_bex['IdUsua'];
    // }


    
    // $insertar = $db->query("UPDATE tblc_ciclogrupo SET tblc_ciclogrupo.Migrado = '1', tblc_ciclogrupo.IdEstatus = '8' WHERE tblc_ciclogrupo.IdGrupo = '$IdGrupo' AND tblc_ciclogrupo.IdCiclo = '$IdCiclo' ");
    

    // $insertar = $db->query("INSERT INTO tblc_ciclogrupo (IdCiclo, IdGrupo, FecCap, Grado, IdEstatus) VALUES ('$rwIdCiclo','$IdGrupo',NOW(),'$grado_nuevo','8')");
    // $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.Grado = '$grado_nuevo' WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  
  
    if ($insertar) {
      echo $insertar;
    } else {
      echo 0;
    }
  }


  if($tipoGuardar == "migrar_alumnos_id"){
    $IdGrupo = $_POST["IdGrupo"];
    $IdCiclo = $_POST["IdCiclo"];
    $IdUsua = $_POST["IdUsua"];

    $sql_grp = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.IdOferta, tblp_grupo.IdCicloIni, tblp_educativa.IdGrado FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo =  '$IdGrupo' ");
    $db->rows($sql_grp);
    $_grp = $db->recorrer($sql_grp);
    $_idCicloIni = $_grp["IdCicloIni"];
    $_idGrado = $_grp["IdGrado"];
    $_idOferta = $_grp["IdOferta"];



    $sql1 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '$IdCiclo'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $_tipo = $datos2["Tipo"];
    $_numero = ($datos2["Numero"] + 1);

    $sql_cic = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Numero = '$_numero' AND tblc_ciclo.Tipo =  '$_tipo'");
    $db->rows($sql_cic);
    $_cix = $db->recorrer($sql_cic);
    $_fecInsc = $_cix["FInicio"];
    $ciclo = isset($_cix["IdCiclo"]);
    
    if(!$ciclo){
      echo 2;
      exit();
    }

    $ciclo = $_cix["IdCiclo"];
    $idCicloActual = $_cix["IdCiclo"];

    $sql_insc = $db->query("SELECT tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.IdPlan, tblc_costos_ciclo.Monto FROM tblc_costos_ciclo Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_costos_ciclo.IdPlan WHERE tblc_costos_ciclo.IdCiclo =  '$_idCicloIni' AND tblc_conceptosplanes.IdGrado =  '$_idGrado' AND tblc_conceptosplanes.IdConcepto =  '1'");
    $db->rows($sql_insc);
    $_insc = $db->recorrer($sql_insc);
    $_idCostoIns = $_insc["IdCosto"];
    
    if(!$_idCostoIns){
      echo 7;
      exit();
    }

    $idPlanInsc = $_insc["IdPlan"]; //PLAN DE INSCRICPION
    $montoInsc = $_insc["Monto"]; //Monto inscricpion

    $sql_col = $db->query("SELECT tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.IdPlan, tblc_costos_ciclo.Numero, tblc_costos_ciclo.Monto FROM tblc_costos_ciclo Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_costos_ciclo.IdPlan WHERE tblc_costos_ciclo.IdCiclo =  '$_idCicloIni' AND tblc_conceptosplanes.IdGrado =  '$_idGrado' AND tblc_conceptosplanes.IdConcepto =  '2'");
    $db->rows($sql_col);
    $_col = $db->recorrer($sql_col);
    $_idCostoCol = isset($_col["IdCosto"]);
    
    if(!$_idCostoCol){
      echo 8;
      exit();
    }

    $_idCostoCol = $_col["IdCosto"];


    $sql_nivel = $db->query("SELECT Count(tblc_ciclogrupo.Grado) AS Total FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdGrupo =  '$IdGrupo'");
    $db->rows($sql_nivel);
    $_nivel = $db->recorrer($sql_nivel);
    $_niv = $_nivel["Total"];
    // $_niv = ($_niv + 1);


    // $insertar = $db->query("INSERT INTO tblc_ciclogrupo (IdCiclo, IdGrupo, FecCap, Grado, IdEstatus) VALUES ('$ciclo','$IdGrupo',NOW(),'$_niv','8')");
    // $insertar = $db->query("INSERT INTO tblp_evaluacion (IdCiclo, IdGrupo, Valor) VALUES ('$ciclo','$IdGrupo','1')");


    // $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.Grado = '$_niv' WHERE tblp_grupo.IdGrupo = '$IdGrupo'");

    $fecha_insc = substr($_fecInsc, 0, 7);
    $fecha_insc = $fecha_insc.'-15';
     $fecha_actual = $fecha_insc.'-15';
    $anioHoy = date("Y");

    $sqlyx = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua, tblc_usuario.Usuario FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
    while($zy = $db->recorrer($sqlyx)){ 
      $IdUs = $zy['IdUsua'];
      $IdActivo = $zy['IdActivo'];
      $_val = $zy['Valor'];
      
      $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap) VALUES ('$IdGrupo','$ciclo','".$zy['IdUsua']."','$_niv','R',8,NOW())");

      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc) VALUES ('$IdUs','103','1','$ciclo','T')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc) VALUES ('$IdUs','104','1','$ciclo','T')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc) VALUES ('$IdUs','105','1','$ciclo','T')");

      $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus,IdGrupo,_idEstatus, IdConcepto,TotalPagado, Recargos, Descuento) VALUES ('".$zy["IdUsua"]."','$idPlanInsc','$montoInsc','1',NOW(),'$fecha_insc','$fecha_insc','$fecha_insc','$fecha_insc','NO-F54','1','$anioHoy','$_idOferta','".$zy["Usuario"]."','1','$idCicloActual','1','$IdGrupo','32','1',0,0,0)");
      
      $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = '3' WHERE tblc_alumnos.IdActivo = '$IdActivo'");

      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.SemCua = '$_niv' WHERE tblc_usuario.IdUsua = '$IdUs'");
    }

    $rwNumero = $_col["Numero"];
    $rwMonto = $_col["Monto"];
    $rwIdConceptoPlan = $_col["IdPlan"];
    
    for ($i = 1; $i <= $rwNumero; $i++) {
      $anio = substr($fecha_actual, 0, 4);

      $sql_user2 = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua, tblc_usuario.Usuario FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
      while ($_user2 = $db->recorrer($sql_user2)) {
        
        $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus,IdGrupo,_idEstatus, IdConcepto,TotalPagado, Recargos, Descuento)  VALUES ('".$_user2["IdUsua"]."','$rwIdConceptoPlan','$rwMonto','1',NOW(),'$fecha_actual','$fecha_actual','$fecha_actual','$fecha_actual','NO-F55','1','$anioHoy','$_idOferta','".$_user2["Usuario"]."','1','$idCicloActual','1','$IdGrupo','32','2',0,0,0)");
      }
      $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
    }



    // $sqlyv = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Valor, tblc_alumnos.IdUsua FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '8' AND tblc_alumnos.Valor = '2' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
    // while($zv = $db->recorrer($sqlyv)){ 
    //   $IdActivo = $zv['IdActivo'];
      
      
    //   $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = '4' WHERE tblc_alumnos.IdActivo = '$IdActivo'");

    // }

    

    #RENOVACION DE BECA DEL ALUMNO

    $sqly = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Promedio, tblc_alumnos.Valor, tblc_alumnos.IdUsua FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
    while($z = $db->recorrer($sqly)){
       $prom = $z["Promedio"];
       $IdEstI = 1;
       $IdEstC = 1;
       $IdUs = $z["IdUsua"];

       $sql_ins = $db->query("SELECT tblp_beca.Porcentaje, tblp_beca.IdUsuaCap FROM tblp_beca WHERE tblp_beca.IdConcepto = '1' AND tblp_beca.IdUsua = '$IdUs' ORDER BY tblp_beca.FecCap DESC");
       $db->rows($sql_ins);
       $_ins = $db->recorrer($sql_ins);
       $Inscripcion = $_ins['Porcentaje'];
       $IdUsCap = $_ins['IdUsuaCap'];
       

       $sql_col = $db->query("SELECT tblp_beca.Porcentaje FROM tblp_beca WHERE tblp_beca.IdConcepto = '2' AND tblp_beca.IdUsua = '$IdUs' ORDER BY tblp_beca.FecCap DESC");
       $db->rows($sql_col);
       $_col = $db->recorrer($sql_col);
       $colegiatura = $_col['Porcentaje'];

       
       if($prom >= 9){
         
         $IdEstI = 8;
          $IdEstC = 8;
       }

       if(!$Inscripcion){ $Inscripcion = 0; }
       if(!$colegiatura){ $colegiatura = 0; }

       if($Inscripcion > 90){ $IdEstI = 1; }
       if($colegiatura > 90){ $IdEstC = 1; }

       $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio) VALUES ('$IdUs','1','$Inscripcion',NOW(),'3','$IdEstI','1','$idCicloActual','$prom')");
       $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio) VALUES ('$IdUs','2','$colegiatura',NOW(),'3','$IdEstC','1','$idCicloActual','$prom')");
      //  $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.IdEstatus = '22' WHERE tblp_beca.IdUsua = '$IdUs' AND tblp_beca.IdCiclo <> '$IdCiclo'");
    }

    // $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.Grado = '$_niv' WHERE tblp_grupo.IdGrupo = '$IdGrupo'");

    // $insertar = $db->query("UPDATE tblc_ciclogrupo SET tblc_ciclogrupo.Migrado = '1', tblc_ciclogrupo.IdEstatus = '8' WHERE tblc_ciclogrupo.IdGrupo = '$IdGrupo' AND tblc_ciclogrupo.IdCiclo = '$IdCiclo' ");
    

      
    $db->close();
    echo $insertar;
  }


