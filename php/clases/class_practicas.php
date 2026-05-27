<?php
require('class.System.php');
class Class_practicas {

  public function get_avisos_capturados_tit() {
    $db = new Conexion();
    $get_avisos_capturados_tit = [];
   
    $sql = $db->query("SELECT
    tbla_aviso_practicas.IdAviso,
    tbla_aviso_practicas.Titulo,
    tbla_aviso_practicas.FecCap,
    tblc_ciclo.Ciclo,
    tblc_periodo_ps.Periodo,
    tblc_periodo_ps.Anio,
    tblc_periodo_ps.Inicia,
    tblc_periodo_ps.Finaliza
    FROM
    tbla_aviso_practicas
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tbla_aviso_practicas.IdCiclo
    Left Join tblc_periodo_ps ON tblc_periodo_ps.IdPeriodo = tbla_aviso_practicas.IdCiclo
    ORDER BY tblc_ciclo.FInicio ASC, tbla_aviso_practicas.FecCap ASC
    
    ");
    while($x = $db->recorrer($sql)){
      $get_avisos_capturados_tit[] = $x;
    }
    return $get_avisos_capturados_tit;
  }

  public function get_mi_practica_id($IdUsua) {
    $db = new Conexion();

    $get_mi_practica_id = [];
    $sql = $db->query("SELECT * FROM tblp_practicas WHERE tblp_practicas.IdUsua = '$IdUsua' AND tblp_practicas.IdEstatus = '4'");
    while($x = $db->recorrer($sql)){
      $get_mi_practica_id[] = $x;
    }
    return $get_mi_practica_id;
  }

  public function get_aviso_id($IdAviso) {
    $db = new Conexion();

    $get_aviso_id = [];
    $sql = $db->query("SELECT * FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdAviso = '$IdAviso' ");
    while($x = $db->recorrer($sql)){
      $get_aviso_id[] = $x;
    }
    return $get_aviso_id;
  }

  public function get_aviso_servicio_id($IdAviso) {
    $db = new Conexion();

    $get_aviso_servicio_id = [];
    $sql = $db->query("SELECT * FROM tbla_aviso_servicio WHERE tbla_aviso_servicio.IdAviso = '$IdAviso' ");
    while($x = $db->recorrer($sql)){
      $get_aviso_servicio_id[] = $x;
    }
    return $get_aviso_servicio_id;
  }

  public function get_mi_practica_id_prac($IdPractica) {
    $db = new Conexion();
    $get_mi_practica_id_prac = [];
    $sql = $db->query("SELECT * FROM tblp_practicas WHERE tblp_practicas.IdPractica = '$IdPractica' ");
    while($x = $db->recorrer($sql)){
      $get_mi_practica_id_prac[] = $x;
    }
    return $get_mi_practica_id_prac;
  }

  public function get_mi_servicio_id($IdServicio) {
    $db = new Conexion();
    $get_mi_servicio_id = [];
    $sql = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdServicio = '$IdServicio' ");
    while($x = $db->recorrer($sql)){
      $get_mi_servicio_id[] = $x;
    }
    return $get_mi_servicio_id;
  }

  public function get_historico_practica_id($IdUsua) {
    $db = new Conexion();
    $get_mi_practica_id_prac = [];
    $sql = $db->query("SELECT
    tblp_practicas.IdPractica,
    tbla_aviso_practicas.Titulo,
    tblc_estatus.Estatus,
    tblp_practicas.FecCap,
    tblp_practicas_cancelado.Fecha,
    tblp_practicas_cancelado.Motivo
    FROM
    tblp_practicas
    Left Join tbla_aviso_practicas ON tbla_aviso_practicas.IdAviso = tblp_practicas.IdAviso
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_practicas.IdEstatus
    Left Join tblp_practicas_cancelado ON tblp_practicas_cancelado.IdPractica = tblp_practicas.IdPractica
    WHERE
    tblp_practicas.IdUsua =  '$IdUsua'
    ORDER BY
    tblp_practicas.IdPractica ASC
     ");
    while($x = $db->recorrer($sql)){
      $get_mi_practica_id_prac[] = $x;
    }
    return $get_mi_practica_id_prac;
  }

  public function get_historico_servicio_id($IdUsua) {
    $db = new Conexion();
    
    $get_historico_servicio_id = [];
    $sql = $db->query("SELECT
    tblp_servicio.IdServicio,
    tbla_aviso_servicio.Titulo,
    tblc_estatus.Estatus,
    tblp_servicio.FecCap,
    tblp_servicio_cancelado.Fecha,
    tblp_servicio_cancelado.Motivo
    FROM
    tblp_servicio
    Left Join tbla_aviso_servicio ON tbla_aviso_servicio.IdAviso = tblp_servicio.IdAviso
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_servicio.IdEstatus
    Left Join tblp_servicio_cancelado ON tblp_servicio_cancelado.IdServicio = tblp_servicio.IdServicio
    WHERE
    tblp_servicio.IdUsua =  '$IdUsua'
    ORDER BY
    tblp_servicio.IdServicio ASC
     ");
    while($x = $db->recorrer($sql)){
      $get_historico_servicio_id[] = $x;
    }
    return $get_historico_servicio_id;
  }

  public function get_cargar_lista_docs($IdUsua,$Tipo) {
    $db = new Conexion();
    $sql9 = $db->query("SELECT tblp_servicio.IdServicio FROM tblp_servicio WHERE tblp_servicio.IdUsua =  '$IdUsua' AND tblp_servicio.IdEstatus = '4'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdServicio = $datos91['IdServicio'];

    $db->query("DELETE FROM tblp_servicio_expediente WHERE tblp_servicio_expediente.IdServicio = '$IdServicio' AND tblp_servicio_expediente.IdUsua = '$IdUsua'");

    $get_mi_practica_id_prac = [];
    $sql = $db->query("SELECT * FROM tblc_tipodocumento WHERE tblc_tipodocumento.Cedula = '$Tipo' ");
    while($x = $db->recorrer($sql)){
      $db->query("INSERT INTO tblp_servicio_expediente (Tipo, IdDocumento, IdEstatus, IdServicio, IdUsua)  VALUES ('$Tipo','".$x['IdTipoDocumento']."',1,'$IdServicio','$IdUsua')");
    }
  }

  public function get_lista_docs($IdUsua) {
    $db = new Conexion();
    $sql9 = $db->query("SELECT tblp_servicio.IdServicio FROM tblp_servicio WHERE tblp_servicio.IdUsua =  '$IdUsua' AND tblp_servicio.IdEstatus = '4'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $IdServicio = $datos91['IdServicio'];

    $get_lista_docs = [];
    $sql = $db->query("SELECT tblp_servicio_expediente.IdExpediente, tblp_servicio_expediente.Giro, tblp_servicio_expediente.TipoEmp, tblp_servicio_expediente.IdServicio, tblp_servicio_expediente.Tipo, tblc_estatus.Estatus, tblc_tipodocumento.NomDocumento, tblp_servicio_expediente.IdEstatus FROM tblp_servicio_expediente Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_servicio_expediente.IdEstatus Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblp_servicio_expediente.IdDocumento WHERE tblp_servicio_expediente.IdUsua = '$IdUsua' AND tblp_servicio_expediente.IdServicio = '$IdServicio' ");
    while($x = $db->recorrer($sql)){
      $get_lista_docs[] = $x;
    }
    return $get_lista_docs;
  }


  public function get_servicio_id($IdServicio) {
    $db = new Conexion();


    $get_servicio_id = [];
    $sql = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdServicio = '$IdServicio'");
    while($x = $db->recorrer($sql)){
      $get_servicio_id[] = $x;
    }
    return $get_servicio_id;
  }


  public function get_docs_practica_id($IdUsua) {
    $db = new Conexion();
    $get_docs_practica_id = [];
    
    $sql = $db->query("SELECT
    tblp_practica_docs.IdDocsPractica,
    tblp_practica_docs.Ruta,
    tblp_practica_docs.IdEstatus,
    tblp_practica_docs.FecCap,
    tblp_practica_docs.Formato,
    tblc_tipodocumento.NomDocumento,
    tblc_estatus.Estatus
    FROM
    tblp_practica_docs
    Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblp_practica_docs.IdTipo
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_practica_docs.IdEstatus
    WHERE tblp_practica_docs.IdUsua = '$IdUsua'
    ORDER BY
    tblp_practica_docs.FecCap ASC
    ");
    while($x = $db->recorrer($sql)){
      $get_docs_practica_id[] = $x;
    }
    return $get_docs_practica_id;
  }

  public function get_mis_avisos_practica_id($IdUsua) {
    $db = new Conexion();
    $IdPractica = '';
    $sql_fol = $db->query("SELECT * FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdEstatus = 12");
    while ($fol = $db->recorrer($sql_fol)) {
      $hoy = date("Y-m-d");
      $_fecha = $fol['Inicio'];
      if($_fecha == $hoy){
        $insertar = $db->query("UPDATE tbla_aviso_practicas SET tbla_aviso_practicas.IdEstatus = '8' WHERE tbla_aviso_practicas.IdAviso = '".$fol['IdAviso']."'");
      }
    }

    $sql_fol2 = $db->query("SELECT * FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdEstatus = 8");
    while ($fol2 = $db->recorrer($sql_fol2)) {
      $hoy = date("Y-m-d");
      $_fecha = $fol2['Final'];
      if($hoy > $_fecha){
        $insertar = $db->query("UPDATE tbla_aviso_practicas SET tbla_aviso_practicas.IdEstatus = '10' WHERE tbla_aviso_practicas.IdAviso = '".$fol2['IdAviso']."'");
      }
    }

    $sql_aprobado = $db->query("SELECT * FROM tblp_practicas WHERE tblp_practicas.IdUsua = '$IdUsua' AND tblp_practicas.IdEstatus = '4'");
    $db->rows($sql_aprobado);
    $_aprobado = $db->recorrer($sql_aprobado);
    if(!isset($_aprobado['IdPractica'])){

    $sql9 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdCampus, tblc_usuario.IdGrupo, tblc_usuario._horario, tblc_usuario.IdGrupo, tblc_usuario.IdOferta, tblp_educativa.IdGrado FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $Grad = $datos91['IdGrado'];
    $_IdGrupo = $datos91['IdGrupo'];
    $_horario = $datos91['_horario'];
    $IdOferta = $datos91['IdOferta'];
    $IdCampus = $datos91['IdCampus'];

    if($Grad == 3){
      if($IdOferta == 30){ $cred = 456; } else { 
        $sql_cred = $db->query("SELECT Sum(tblp_modulo.Creditos) AS Total FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' AND tblp_modulo.IdCampus =  '$IdCampus'");
        $db->rows($sql_cred);
        $_cred = $db->recorrer($sql_cred);
        $cred = $_cred['Total'];
      }

      $sql_miscred = $db->query("SELECT Sum(tblp_modulo.Creditos) AS Total FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_calificacion.IdEstatus =  '10' AND tblp_calificacion.Promedio >  '5'");
      $db->rows($sql_miscred);
      $_miscred = $db->recorrer($sql_miscred);
      
      $divi = (100 / $cred);
     $porceActual = intval($divi * $_miscred['Total']);
    }

    if($porceActual >= 40){
      $get_mis_avisos_practica_id = [];
      $sql = $db->query("SELECT * FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdEstatus = '8' LIMIT 1 ");
        while($x = $db->recorrer($sql)){
          $get_mis_avisos_practica_id[] = $x;
          $IdAviso = $x['IdAviso'];
          
          $sql_4 = $db->query("SELECT * FROM tblp_practicas WHERE tblp_practicas.IdUsua = '$IdUsua' AND tblp_practicas.IdAviso = '$IdAviso' AND tblp_practicas.IdEstatus = '4'");
          $db->rows($sql_4);
          $_sql4 = $db->recorrer($sql_4);
          if(!isset($_sql4['IdPractica'])){
            $sql_11 = $db->query("SELECT * FROM tblp_practicas WHERE tblp_practicas.IdUsua = '$IdUsua' AND tblp_practicas.IdAviso = '$IdAviso' AND tblp_practicas.IdEstatus = '11'");
            $db->rows($sql_11);
            $_sql11 = $db->recorrer($sql_11);
            if(isset($_sql11['IdPractica'])){
              $sql_fac = $db->query("SELECT * FROM tblp_practicas WHERE tblp_practicas.IdUsua = '$IdUsua' AND tblp_practicas.IdAviso = '$IdAviso' AND ((tblp_practicas.IdEstatus = '1') || (tblp_practicas.IdEstatus = '2') || (tblp_practicas.IdEstatus = '3') || (tblp_practicas.IdEstatus = '5'))");
              $db->rows($sql_fac);
              $_fac = $db->recorrer($sql_fac);
              if(!isset($_fac['IdPractica'])){
                $sql_ins = $db->query("INSERT INTO tblp_practicas (IdUsua, IdEstatus, IdAviso) VALUES ('$IdUsua',1,'$IdAviso')");
              }
            }
          }
        }
        return $get_mis_avisos_practica_id;
    }
  }

    // $sql_fol = $db->query("SELECT * FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdEstatus = 12");
    // while ($fol = $db->recorrer($sql_fol)) {
    //   $hoy = date("Y-m-d");
    //   $_fecha = $fol['Inicio'];
    //   if($_fecha == $hoy){
    //     $insertar = $db->query("UPDATE tbla_aviso_practicas SET tbla_aviso_practicas.IdEstatus = '8' WHERE tbla_aviso_practicas.IdAviso = '".$fol['IdAviso']."'");
    //   }
    // }

    // $sql_fol2 = $db->query("SELECT * FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdEstatus = 8");
    // while ($fol2 = $db->recorrer($sql_fol2)) {
    //   $hoy = date("Y-m-d");
    //   $_fecha = $fol2['Final'];
    //   if($hoy > $_fecha){
    //     $insertar = $db->query("UPDATE tbla_aviso_practicas SET tbla_aviso_practicas.IdEstatus = '10' WHERE tbla_aviso_practicas.IdAviso = '".$fol2['IdAviso']."'");
    //   }
    // }

    // $sql9 = $db->query("SELECT tblc_usuario.especial, tblc_usuario.IdGrupo, tblc_usuario._horario, tblc_usuario.IdUsua, tblp_educativa.IdGrado FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    // $db->rows($sql9);
    // $datos91 = $db->recorrer($sql9);
    // $Grad = $datos91['IdGrado'];
    // $IdGrupo = $datos91['IdGrupo'];
    // $_IdGrupo = $datos91['IdGrupo'];
    // $_horario = $datos91['_horario'];
    // $especial = $datos91['especial'];

    // $sql_gpx = $db->query("SELECT tblc_ciclogrupo.Grado FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdGrupo = '$_IdGrupo' AND tblc_ciclogrupo.Grado >=  '5'");
    // $db->rows($sql_gpx);
    // $_goxs = $db->recorrer($sql_gpx);
    // $_grapx = $_goxs['Grado'];
    // if($_grapx){
    //   $_grapx = 5;
    // } else {
    //   $_grapx = 0;
    // }

    // if($_horario == 'P'){
    //   $_grapx = 5;
    // }

    // if($especial == 1){
    //   $_grapx = 5;
    // }


    // $get_mis_avisos_practica_id = [];
   
    // if(($Grad == 3) && ($_grapx == 5)){

    //   $sql_av = $db->query("SELECT tbla_aviso_practicas.IdAviso FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdEstatus = '8' LIMIT 1");
    //   $db->rows($sql_av);
    //   $_avix = $db->recorrer($sql_av);
    //   $IdAvis = $_avix['IdAviso'];

    //   $sql_usx = $db->query("SELECT tbla_aviso_practicas_detalle.IdDetalle FROM tbla_aviso_practicas_detalle WHERE tbla_aviso_practicas_detalle.IdUsua = '$IdUsua' AND tbla_aviso_practicas_detalle.IdAviso = '$IdAvis'");
    //   $db->rows($sql_usx);
    //   $_usx = $db->recorrer($sql_usx);
    //   $IdDetx = $_usx['IdDetalle'];
    //   if(!$IdDetx){
        
    //     $insertar = $db->query("INSERT INTO tbla_aviso_practicas_detalle (IdAviso, IdUsua, IdEstatus, IdGrupo, Fec_visto)  VALUES ('$IdAvis','$IdUsua',1,'$IdGrupo',NOW()) ");
    //   }

    //   $sql = $db->query("SELECT * FROM tbla_aviso_practicas WHERE tbla_aviso_practicas.IdEstatus = '8' LIMIT 1 ");
    //   while($x = $db->recorrer($sql)){
    //     $get_mis_avisos_practica_id[] = $x;
    //   }
    // }

    // return $get_mis_avisos_practica_id;
  }

   public function obtener_lista_avisos($IdAviso) {
    $db = new Conexion();
    $validar_datos_pago = [];

    $sql = $db->query("SELECT
    tbla_aviso_practicas_detalle.IdDetalle,
    tbla_aviso_practicas_detalle.Fec_visto,
    tblc_usuario.IdOferta,
    tblc_usuario.Usuario,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblp_educativa.Nombre AS Educativa,
    tblc_campus.Campus,
    tblc_usuario.IdGrupo,
    tblp_grupo.IdCampus
    FROM
    tbla_aviso_practicas_detalle
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tbla_aviso_practicas_detalle.IdUsua
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
    Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
    WHERE tbla_aviso_practicas_detalle.IdAviso = '$IdAviso'
    ORDER BY
    tblc_usuario.IdCampus ASC,
    tblc_usuario.IdOferta ASC,
    tblc_usuario.APaterno ASC
    ");
    while($x = $db->recorrer($sql)){
      $validar_datos_pago[] = $x;
    }
    return $validar_datos_pago;
	}

  public function inscripcion_practicas_id($IdUsua, $IdDetalle,$IdAviso) {
    $db = new Conexion();
    $inscripcion_practicas_id = [];

    $sql_inf = $db->query("SELECT * FROM tblp_informacion WHERE tblp_informacion.IdUsua = '$IdUsua'");
    $db->rows($sql_inf);
    $_inf = $db->recorrer($sql_inf);
    if(!$_inf['IdInformacion']){
      $sql_ins = $db->query("INSERT INTO tblp_informacion (IdUsua) VALUES ('$IdUsua') ");
    }


    // $sql_fac = $db->query("SELECT * FROM tblp_practicas WHERE tblp_practicas.IdUsua = '$IdUsua' AND tblp_practicas.IdAviso = '$IdAviso'");
    // $db->rows($sql_fac);
    // $_fac = $db->recorrer($sql_fac);
    // if(!$_fac['IdPractica']){
    //   // $sql_ins = $db->query("INSERT INTO tblp_practicas (IdUsua, IdEstatus, IdAviso) VALUES ('$IdUsua',1,'$IdAviso') ");
    // }

    $sql = $db->query("SELECT * FROM tblp_practicas WHERE tblp_practicas.IdUsua = '$IdUsua' AND tblp_practicas.IdAviso = '$IdAviso' ORDER BY tblp_practicas.IdPractica DESC");
    while($x = $db->recorrer($sql)){
      $inscripcion_practicas_id[] = $x;
    }
    return $inscripcion_practicas_id;
	}

  public function usuario_id($IdUsua) {
    $db = new Conexion();
    $usuario_id = [];
    

    
    $sql = $db->query("SELECT
    tblc_usuario.IdUsua,
    tblc_usuario.Celular,
    tblc_usuario.Curp,
    tblp_informacion.D_estado,
    tblp_informacion.D_municipio,
    tblp_informacion.D_cp,
    tblp_informacion.D_direccion
    FROM
    tblc_usuario
    Left Join tblp_informacion ON tblp_informacion.IdUsua = tblc_usuario.IdUsua
    WHERE
    tblc_usuario.IdUsua =  '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $usuario_id[] = $x;
    }
    return $usuario_id;
	}

  public function get_gestion_escolar() {
    $db = new Conexion();
    $get_gestion_escolar = [];
    
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Estado = '1' AND tblc_usuario.IdEstatus = '8' ORDER BY tblc_usuario.Nombre ASC");
    while($x = $db->recorrer($sql)){
      $get_gestion_escolar[] = $x;
    }
    return $get_gestion_escolar;
	}

  public function get_estados() {
    $db = new Conexion();
    $get_estados = [];
    $sql = $db->query("SELECT * FROM tblc_estado");
    while($x = $db->recorrer($sql)){
      $get_estados[] = $x;
    }
    return $get_estados;
	}

  public function get_ver_docs_practica_id($IdDocs) {
    $db = new Conexion();
    $get_ver_docs_practica_id = [];
    
    $sql = $db->query("SELECT
    tblp_servicio_docs.IdDocsServicio,
    tblp_servicio_docs.Ruta,
    tblp_servicio_docs.IdEstatus,
    tblp_servicio_docs.FecCap,
    tblp_servicio_docs.Formato,
    tblc_tipodocumento.NomDocumento,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_usuario.Foto
    FROM
    tblp_servicio_docs
    Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblp_servicio_docs.IdTipo
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_servicio_docs.IdUsua WHERE tblp_servicio_docs.IdDocsServicio = '$IdDocs' ");
    while($x = $db->recorrer($sql)){
      $get_ver_docs_practica_id[] = $x;
    }
    return $get_ver_docs_practica_id;
	}


  public function get_ver_docs_profesional_id($IdDocs) {
    $db = new Conexion();
    $get_ver_docs_profesional_id = [];
    
    $sql = $db->query("SELECT
    tblp_practica_docs.IdDocsPractica,
    tblp_practica_docs.Ruta,
    tblp_practica_docs.IdEstatus,
    tblp_practica_docs.FecCap,
    tblp_practica_docs.Formato,
    tblc_tipodocumento.NomDocumento,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_usuario.Foto
    FROM
    tblp_practica_docs
    Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblp_practica_docs.IdTipo
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_practica_docs.IdUsua WHERE tblp_practica_docs.IdDocsPractica = '$IdDocs' ");
    while($x = $db->recorrer($sql)){
      $get_ver_docs_profesional_id[] = $x;
    }
    return $get_ver_docs_profesional_id;
	}

  public function get_user_practicas_activas($IdAviso,$IdEstatus, $IdUsua, $Permiso) {
    $db = new Conexion();
    //echo $Permiso; 
    $get_user_practicas_activas = [];
    if($IdEstatus == 1){
      $condx = "";
    } else {
      $condx = " AND tblp_practicas.IdEstatus = '$IdEstatus'";
    }
if($Permiso == 9){
    $sql = $db->query("SELECT
    tblp_coordinador.IdCoordinador,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_usuario.IdOferta,
    tblc_usuario.Usuario,
    tblp_practicas.Empresa,
    tblp_practicas.IdAviso,
    tblp_practicas.IdUsua,
    tblp_practicas.IdDetalle,
    tblc_estatus.Estatus,
    tblp_educativa.Nombre AS Educativa,
    tblc_campus.Campus
    FROM
    tblp_coordinador
    Left Join tblc_usuario ON tblc_usuario.IdOferta = tblp_coordinador.IdOferta AND tblc_usuario.IdCampus = tblp_coordinador.IdCampus
    Left Join tblp_practicas ON tblp_practicas.IdUsua = tblc_usuario.IdUsua
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_practicas.IdEstatus
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
    Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
    WHERE
    tblp_practicas.IdCiclo = '$IdAviso' AND 
    tblp_coordinador.IdUsua = '$IdUsua'
    $condx
    ");
    while($x = $db->recorrer($sql)){
      $get_user_practicas_activas[] = $x;
    }
    return $get_user_practicas_activas;
  } else {

    $sql_fac = $db->query("SELECT tblc_usuario.Tipo, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $db->rows($sql_fac);
    $_fac = $db->recorrer($sql_fac);
    $_idCamp= $_fac['IdCampus'];

    if($Permiso == 1){
      $gbxs = " AND tblc_usuario.IdCampus = '$_idCamp' ";
    } else {
      $gbxs = " ";
    }
    $gbxs = " AND tblc_usuario.IdCampus = '$_idCamp' ";

    if($_fac['Tipo'] == 1){
      $gbxs = " ";
    }

    $sql = $db->query("SELECT
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_usuario.IdOferta,
    tblc_usuario.Usuario,
    tblp_practicas.Empresa,
    tblp_practicas.IdAviso,
    tblp_practicas.IdUsua,
    tblp_practicas.IdDetalle,
    tblc_estatus.Estatus,
    tblp_educativa.Nombre AS Educativa,
    tblc_campus.Campus
    FROM
    tblc_usuario
    Left Join tblp_practicas ON tblp_practicas.IdUsua = tblc_usuario.IdUsua
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_practicas.IdEstatus
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
    Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
    WHERE
    tblp_practicas.IdCiclo = '$IdAviso'
    $condx $gbxs
    ");
    while($x = $db->recorrer($sql)){
      $get_user_practicas_activas[] = $x;
    }
    return $get_user_practicas_activas;
  }
	}





}



 
?>
