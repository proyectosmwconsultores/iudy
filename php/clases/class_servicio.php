<?php
require('class.System.php');
class Class_servicio {

  public function get_avisos_capturados_tit() {
    $db = new Conexion();
    $get_avisos_capturados_tit = [];
   
    $sql = $db->query("SELECT
    tbla_aviso_servicio.IdAviso,
    tbla_aviso_servicio.Titulo,
    tbla_aviso_servicio.FecCap,
    tblc_ciclo.Ciclo,
    tblc_periodo_ps.Periodo,
    tblc_periodo_ps.Anio,
    tblc_periodo_ps.Inicia,
    tblc_periodo_ps.Finaliza
    FROM
    tbla_aviso_servicio
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tbla_aviso_servicio.IdCiclo
    Left Join tblc_periodo_ps ON tblc_periodo_ps.IdPeriodo = tbla_aviso_servicio.IdCiclo
    ORDER BY tblc_ciclo.FInicio ASC, tbla_aviso_servicio.FecCap ASC
    
    ");
    while($x = $db->recorrer($sql)){
      $get_avisos_capturados_tit[] = $x;
    }
    return $get_avisos_capturados_tit;
  }

  public function get_mi_practica_id($IdUsua) {
    $db = new Conexion();
    $get_mi_practica_id = [];  
    $sql = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdUsua = '$IdUsua' AND tblp_servicio.IdEstatus = '4'");
    while($x = $db->recorrer($sql)){
      $get_mi_practica_id[] = $x;
    }
    return $get_mi_practica_id;
  }

  public function get_mi_servicio_all($IdUsua,$IdAviso) {
    $db = new Conexion();
    $get_mi_servicio_all = [];  
    $sql = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdUsua = '$IdUsua' AND tblp_servicio.IdAviso = '$IdAviso' ");
    while($x = $db->recorrer($sql)){
      $get_mi_servicio_all[] = $x;
    }
    return $get_mi_servicio_all;
  }

  public function get_aviso_id($IdAviso) {
    $db = new Conexion();

    $get_aviso_id = [];
    $sql = $db->query("SELECT * FROM tbla_aviso_servicio WHERE tbla_aviso_servicio.IdAviso = '$IdAviso' ");
    while($x = $db->recorrer($sql)){
      $get_aviso_id[] = $x;
    }
    return $get_aviso_id;
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


  public function get_docs_practica_id($IdUsua,$IdServicio) {
    $db = new Conexion();
    $get_docs_practica_id = [];
    $sql = $db->query("SELECT
    tblp_servicio_docs.IdDocsServicio,
    tblp_servicio_docs.Ruta,
    tblp_servicio_docs.IdEstatus,
    tblp_servicio_docs.FecCap,
    tblp_servicio_docs.Formato,
    tblc_tipodocumento.NomDocumento,
    tblc_estatus.Estatus
    FROM
    tblp_servicio_docs
    Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblp_servicio_docs.IdTipo
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_servicio_docs.IdEstatus
    WHERE tblp_servicio_docs.IdUsua = '$IdUsua' AND tblp_servicio_docs.IdServicio = '$IdServicio'
    ORDER BY
    tblp_servicio_docs.FecCap ASC
    ");
    while($x = $db->recorrer($sql)){
      $get_docs_practica_id[] = $x;
    }
    return $get_docs_practica_id;
  }

  public function get_mis_avisos_practica_id($IdUsua) {
    $db = new Conexion();
    // $sql_fol = $db->query("SELECT * FROM tbla_aviso_servicio WHERE tbla_aviso_servicio.IdEstatus = 12");
    // while ($fol = $db->recorrer($sql_fol)) {
    //   $hoy = date("Y-m-d");
    //   $_fecha = $fol['Inicio'];
    //   if($_fecha == $hoy){
    //     $insertar = $db->query("UPDATE tbla_aviso_servicio SET tbla_aviso_servicio.IdEstatus = '8' WHERE tbla_aviso_servicio.IdAviso = '".$fol['IdAviso']."'");
    //   }
    // }

    // $sql_fol2 = $db->query("SELECT * FROM tbla_aviso_servicio WHERE tbla_aviso_servicio.IdEstatus = 8");
    // while ($fol2 = $db->recorrer($sql_fol2)) {
    //   $hoy = date("Y-m-d");
    //   $_fecha = $fol2['Final'];
    //   if($hoy > $_fecha){
    //     $insertar = $db->query("UPDATE tbla_aviso_servicio SET tbla_aviso_servicio.IdEstatus = '10' WHERE tbla_aviso_servicio.IdAviso = '".$fol2['IdAviso']."'");
    //   }
    // }

    $sql9 = $db->query("SELECT tblc_usuario.IdGrupo, tblc_usuario.IdCampus, tblc_usuario.IdOferta, tblc_usuario._horario, tblc_usuario.IdUsua, tblp_educativa.IdGrado FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $Grad = $datos91['IdGrado'];
    $IdOferta = $datos91['IdOferta'];
    $IdCampus = $datos91['IdCampus'];
    $IdGrupo = $datos91['IdGrupo'];
    $_IdGrupo = $datos91['IdGrupo'];
    $_horario = $datos91['_horario'];


    $sql_gpx = $db->query("SELECT tblc_ciclogrupo.Grado FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdGrupo = '$_IdGrupo' AND tblc_ciclogrupo.Grado >=  '8'");
    $db->rows($sql_gpx);
    $_goxs = $db->recorrer($sql_gpx);
    $_grapx = isset($_goxs['Grado']);
   $porceActual = 0;
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
    
    
   
    if(($Grad == 3) && ($porceActual >= 68)){
    $get_mis_avisos_practica_id = [];
      $sql_av = $db->query("SELECT tbla_aviso_servicio.IdAviso FROM tbla_aviso_servicio WHERE tbla_aviso_servicio.IdEstatus = '8' LIMIT 1");
      $db->rows($sql_av);
      $_avix = $db->recorrer($sql_av);
      $IdAvis = isset($_avix['IdAviso']);
      if($IdAvis){
        $IdAvis = $_avix['IdAviso'];
        $sql_usx = $db->query("SELECT tbla_aviso_servicio_detalle.IdDetalle FROM tbla_aviso_servicio_detalle WHERE tbla_aviso_servicio_detalle.IdUsua = '$IdUsua' AND tbla_aviso_servicio_detalle.IdAviso = '$IdAvis'");
        $db->rows($sql_usx);
        $_usx = $db->recorrer($sql_usx);
        $IdDetx = $_usx['IdDetalle'];
        if(!$IdDetx){
          $insertar = $db->query("INSERT INTO tbla_aviso_servicio_detalle (IdAviso, IdUsua, IdEstatus, IdGrupo, Fec_visto)  VALUES ('$IdAvis','$IdUsua',1,'$IdGrupo',NOW()) ");
        }

        $sql = $db->query("SELECT * FROM tbla_aviso_servicio WHERE tbla_aviso_servicio.IdEstatus = '8' LIMIT 1 ");
        while($x = $db->recorrer($sql)){
          $get_mis_avisos_practica_id[] = $x;
        }
      }
    }

    return $get_mis_avisos_practica_id;
  }

   public function obtener_lista_avisos($IdAviso) {
    $db = new Conexion();
    $validar_datos_pago = [];

    $sql = $db->query("SELECT
    tbla_aviso_servicio_detalle.IdDetalle,
    tbla_aviso_servicio_detalle.Fec_visto,
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
    tbla_aviso_servicio_detalle
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tbla_aviso_servicio_detalle.IdUsua
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
    Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
    WHERE tbla_aviso_servicio_detalle.IdAviso = '$IdAviso'
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

  public function inscripcion_practicas_id($IdUsua, $IdDetalle, $IdAviso) {
    $db = new Conexion();
    $inscripcion_practicas_id = [];

    $sql_inf = $db->query("SELECT * FROM tblp_informacion WHERE tblp_informacion.IdUsua = '$IdUsua'");
    $db->rows($sql_inf);
    $_inf = $db->recorrer($sql_inf);
    if(!$_inf['IdInformacion']){
      $sql_ins = $db->query("INSERT INTO tblp_informacion (IdUsua) VALUES ('$IdUsua') ");
    }


    $sql_fac = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdUsua = '$IdUsua' AND tblp_servicio.IdAviso = '$IdAviso' ");
    $db->rows($sql_fac);
    $_fac = $db->recorrer($sql_fac);
    if(!$_fac['IdServicio']){
      $sql_ins = $db->query("INSERT INTO tblp_servicio (IdUsua, IdEstatus, IdAviso, IdDetalle) VALUES ('$IdUsua',1,'$IdAviso', 1) ");
    }

    $sql = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdUsua = '$IdUsua' AND tblp_servicio.IdAviso = '$IdAviso'");
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

  public function get_rep_servicio_social_sep($IdAviso) {
    $db = new Conexion();
    $get_rep_servicio_social_sep = [];
    
    $sql = $db->query("SELECT
    tblp_servicio.IdServicio,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblp_servicio.Empresa,
    tblp_servicio.Area_ubicacion,
    tblp_servicio.Grado_responsable,
    tblp_servicio.Nombre_responsable,
    tblp_servicio.Cargo,
    tblp_servicio.Area_asignado,
    tblp_servicio.Area_atencion,
    tblc_usuario.Usuario,
    tblc_usuario.Curp,
    tblc_rvoe.Educativa,
    tblc_rvoe.Rvoe,
    tblc_usuario.Sexo,
    tblp_servicio.Grado
    FROM
    tblp_servicio
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_servicio.IdUsua
    Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe
    WHERE tblp_servicio.IdAviso = '$IdAviso' AND tblp_servicio.IdEstatus = '4'
    ");
    while($x = $db->recorrer($sql)){
      $get_rep_servicio_social_sep[] = $x;
    }
    return $get_rep_servicio_social_sep;
	}

  public function get_ver_docs_practica_id($IdDocs) {
    $db = new Conexion();
    $get_ver_docs_practica_id = [];
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
      $get_ver_docs_practica_id[] = $x;
    }
    return $get_ver_docs_practica_id;
	}

  public function get_user_practicas_activas($IdAviso,$IdEstatus, $IdUsua, $Permiso) {
    $db = new Conexion();
    //echo $Permiso; 
    $get_user_practicas_activas = [];
    if($IdEstatus == 1){
      $condx = "";
    } else {
      $condx = " AND tblp_servicio.IdEstatus = '$IdEstatus'";
    }

    $sql_fac = $db->query("SELECT tblc_usuario.Tipo, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $db->rows($sql_fac);
    $_fac = $db->recorrer($sql_fac);
    $_idCamp= $_fac['IdCampus'];


    $sql = $db->query("SELECT
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_usuario.IdOferta,
    tblc_usuario.Usuario,
    tblp_servicio.Empresa,
    tblp_servicio.IdAviso,
    tblp_servicio.IdUsua,
    tblp_servicio.IdDetalle,
    tblc_estatus.Estatus,
    tblp_educativa.Nombre AS Educativa,
    tblc_campus.Campus
    FROM
    tblc_usuario
    Left Join tblp_servicio ON tblp_servicio.IdUsua = tblc_usuario.IdUsua
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_servicio.IdEstatus
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
    Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
    WHERE
    tblp_servicio.IdCiclo = '$IdAviso' AND 
    tblp_servicio.IdEstatus = '$IdEstatus'
    ");
    while($x = $db->recorrer($sql)){
      $get_user_practicas_activas[] = $x;
    }
    return $get_user_practicas_activas;
	}





}



 
?>
