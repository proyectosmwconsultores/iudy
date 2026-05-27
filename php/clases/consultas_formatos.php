<?php
require('class.System.php');
class Class_formatos {

  public function obtener_lista_materias($IdUsua) {
    $db = new Conexion();
    $obtener_lista_materias = [];

    $sql = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion._obs, tblp_calificacion.IdUsua, tblp_calificacion.Usuario, tblp_calificacion.Promedio, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblc_ciclo.Ciclo, tblp_calificacion.IdCiclo FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo WHERE tblp_calificacion.IdEstatus = '10' AND tblp_calificacion.IdUsua =  '$IdUsua' ORDER BY tblc_ciclo.FInicio ASC, tblp_modulo.CodeModulo ASC");
    while($x = $db->recorrer($sql)){
      $obtener_lista_materias[] = $x;
    }
    return $obtener_lista_materias;
	}
	
  public function get_donacion_id($IdUsua)
  {
    $db = new Conexion();
    $get_donacion_id = [];
    $sql = $db->query("SELECT * FROM tblp_donacion WHERE tblp_donacion.IdUsua = '$IdUsua'");
    while ($x = $db->recorrer($sql)) {
      $get_donacion_id[] = $x;
    }
    return $get_donacion_id;
  }
  
  public function get_mis_grados_estudiados($IdAlumno) {
    $db = new Conexion();
    $get_mis_grados_estudiados = [];

    $sql = $db->query("SELECT
	tblc_alumnos.IdActivo, 
	tblc_alumnos.Grado, 
	tblc_alumnos.IdUsua, 
	tblc_alumnos.IdCiclo, 
	tblc_ciclo.Ciclo, 
	tblp_grupo.Dia
FROM
	tblc_alumnos
	LEFT JOIN
	tblc_ciclo
	ON 
		tblc_alumnos.IdCiclo = tblc_ciclo.IdCiclo
	LEFT JOIN
	tblp_grupo
	ON 
		tblc_alumnos.IdGrupo = tblp_grupo.IdGrupo
WHERE
	tblc_alumnos.IdUsua = '$IdAlumno'
ORDER BY
	tblc_alumnos.Grado DESC");
    while($x = $db->recorrer($sql)){
      $get_mis_grados_estudiados[] = $x;
    }
    return $get_mis_grados_estudiados;
  }
  

  public function obtener_lista_materias_persona($IdUsua) {
    $db = new Conexion();
    $obtener_lista_materias = [];

    $sql = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion._obs, tblp_calificacion.IdUsua, tblp_calificacion.Usuario, tblp_calificacion.Promedio, tblp_modulo.Grado, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblc_ciclo.Ciclo, tblp_calificacion.IdCiclo FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo WHERE tblp_calificacion.IdEstatus = '10' AND tblp_calificacion.IdUsua =  '$IdUsua' ORDER BY tblp_modulo.Grado ASC, tblp_modulo.CodeModulo ASC");
    while($x = $db->recorrer($sql)){
      $obtener_lista_materias[] = $x;
    }
    return $obtener_lista_materias;
	}

  public function obtener_ciclo_impresion($IdCiclo, $Grado) {
		$db = new Conexion();
		
		$sql9 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo' ");
		$db->rows($sql9);
		$datos91 = $db->recorrer($sql9);
		$Tipo = $datos91['Tipo'];
		$Numero = $datos91['Numero'];
		if($Grado == 1){
			$Numero = $datos91['Numero'];
		} else {
      $Grado = ($Grado - 1);
			$Numero = ($Numero + $Grado);
		}

    

		$obtener_ciclo_impresion = [];
		$sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$Tipo' AND tblc_ciclo.Numero = '$Numero' ");
		while($x = $db->recorrer($sql)){
		  $obtener_ciclo_impresion[] = $x;
		}
		return $obtener_ciclo_impresion;
	  }

	
  public function get_mis_periodos($IdUsua) {
		$db = new Conexion();
		$get_mis_periodos = [];
	    $sql9 = $db->query("SELECT tblp_calificacion.IdCalificacion, tblc_ciclo.Tipo, tblc_ciclo.Numero, tblc_ciclo.Ciclo, tblp_calificacion.IdCiclo FROM tblp_calificacion Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo WHERE tblp_calificacion.IdUsua =  '$IdUsua' GROUP BY tblp_calificacion.IdCiclo ORDER BY tblc_ciclo.FInicio ASC LIMIT 1 ");
		$db->rows($sql9);
		$datos91 = $db->recorrer($sql9);
		$Tipo = $datos91['Tipo'];
		$Numero = $datos91['Numero'];
		
		
		
		$sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$Tipo'  ");
		while($x = $db->recorrer($sql)){
			$get_mis_periodos[] = $x;
		}
		return $get_mis_periodos;
	}

  public function get_tipo_titulacion() {
		$db = new Conexion();
		$get_tipo_titulacion = [];
	
		$sql = $db->query("SELECT * FROM tblp_tipo_titulacion");
		while($x = $db->recorrer($sql)){
			$get_tipo_titulacion[] = $x;
		}
		return $get_tipo_titulacion;
	}


  public function obtener_evaluacion_id($IdUsua) {
    $db = new Conexion();
    $obtener_evaluacion_id = [];

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
      $obtener_evaluacion_id[] = $x;
    }
    return $obtener_evaluacion_id;
	}

  public function obtener_evaluacion_doc_id($IdUsua) {
    $db = new Conexion();
    $obtener_evaluacion_doc_id = [];

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
    tblp_modulo.NombreMod,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno
    FROM
    tblx_evaluacion
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblx_evaluacion.IdCiclo
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblx_evaluacion.IdEstatus
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblx_evaluacion.IdModulo
    Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblx_evaluacion.IdAsignacion
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
    WHERE
    tblx_evaluacion.IdUsua =  '$IdUsua' AND
    tblx_evaluacion.IdEstatus =  '8' AND
    tblp_asignacion.Tipo =  '2'
    ORDER BY tblx_evaluacion.FecIni ASC, tblx_evaluacion.FecCap ASC
    ");
    while($x = $db->recorrer($sql)){
      $obtener_evaluacion_doc_id[] = $x;
    }
    return $obtener_evaluacion_doc_id;
	}

  public function obtener_datos_materia_id($IdAsignacion) {
    $db = new Conexion();
    $obtener_datos_materia_id = [];

    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
    while($x = $db->recorrer($sql)){
      $obtener_datos_materia_id[] = $x;
    }
    return $obtener_datos_materia_id;
	}

  public function usuario_id($IdUsua) {
    $db = new Conexion();
    $usuario_id = [];

    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $usuario_id[] = $x;
    }
    return $usuario_id;
	}


  public function obtener_alumnos_pendientes($IdCiclo) {
    $db = new Conexion();
    $obtener_alumnos_pendientes = [];

    $sql = $db->query("SELECT
    tblc_alumnos.IdActivo,
    tblc_alumnos.IdCiclo,
    tblc_alumnos.Grado,
    tblc_alumnos.IdGrupo,
    tblc_usuario.Usuario,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblp_educativa.Nombre AS Educativa,
    tblp_grupo.CveGrupo,
    tblc_dias_clases._Dias,
    tblc_alumnos.IdUsua,
    tblc_campus.Campus
    FROM
    tblc_alumnos
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
    Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
    Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
    WHERE
    tblc_alumnos.Valor =  '4' AND
    tblc_alumnos.IdEstatus = '8' AND
    tblc_alumnos.IdCiclo =  '$IdCiclo'
    ");
    while($x = $db->recorrer($sql)){
      $obtener_alumnos_pendientes[] = $x;
    }
    return $obtener_alumnos_pendientes;
	}


  public function obtener_materias_rvoe($IdMod) {
    $db = new Conexion();
    $sql3 = $db->query("SELECT tblp_moduloalumno.IdModuloAlumno, tblp_moduloalumno.IdUsua, tblc_usuario._idCampus, tblc_usuario._idOferta FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdModuloAlumno =  '$IdMod'");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);
    $IdCampus = $datos31['_idCampus'];
    $IdOferta = $datos31['_idOferta'];

    $obtener_materias_rvoe = [];

    $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.IdCampus = '$IdCampus'");
    while($x = $db->recorrer($sql)){
      $obtener_materias_rvoe[] = $x;
    }
    return $obtener_materias_rvoe;
	}


  public function obtener_datos_materia_asignada($IdMod) {
    $db = new Conexion();

    $obtener_datos_materia_asignada = [];
    $sql = $db->query("SELECT
    tblp_moduloalumno.IdModuloAlumno,
    tblp_moduloalumno.IdUsua,
    tblp_moduloalumno.IdAsignacion,
    tblp_moduloalumno.IdEducativa,
    tblp_moduloalumno.IdModulo,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblp_modulo.Grado,
    tblc_ciclo.Ciclo,
    tblp_asignacion.IdCiclo,
    tblp_asignacion.Fecha_impresion,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_estatus.Estatus,
    tblp_asignacion.FecIni,
    tblp_asignacion.FecFin,
    tblp_moduloalumno._idModulo,
    ModRvoe.CodeModulo AS RCodeMode,
    ModRvoe.NombreMod AS RNombreMod
    FROM
    tblp_moduloalumno
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
    Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_asignacion.IdEstatus
    Left Join tblp_modulo AS ModRvoe ON ModRvoe.IdModulo = tblp_moduloalumno._idModulo
    WHERE tblp_moduloalumno.IdModuloAlumno =  '$IdMod' AND tblp_asignacion.Tipo = '2'");
    while($x = $db->recorrer($sql)){
      $obtener_datos_materia_asignada[] = $x;
    }
    return $obtener_datos_materia_asignada;
	}


  public function obtener_datos_certificado($IdUsua) {
    $db = new Conexion();
    $sql_inf = $db->query("SELECT * FROM tblp_certificado WHERE tblp_certificado.IdUsua = '$IdUsua'");
    $db->rows($sql_inf);
    $_inf = $db->recorrer($sql_inf);
    if(!isset($_inf['IdCertificado'])){
      $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $longitud = 15;
      $code =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);

      $sql_ins = $db->query("INSERT INTO tblp_certificado (IdUsua, Code) VALUES ('$IdUsua','$code') ");
    }

    $obtener_datos_certificado = [];

    $sql = $db->query("SELECT * FROM tblp_certificado WHERE tblp_certificado.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $obtener_datos_certificado[] = $x;
    }
    return $obtener_datos_certificado;
	}

  public function obtener_periodo_escolar($IdUsua) {
    $db = new Conexion();
    $sql_inf = $db->query("SELECT tblc_usuario.IdUsua, tblp_grupo.TipoCiclo FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql_inf);
    $_inf = $db->recorrer($sql_inf);
    $TipoCiclo = $_inf['TipoCiclo'];
    if($TipoCiclo == 'S') { $_cic = 'SEMESTRE'; }
    if($TipoCiclo == 'C') { $_cic = 'CUATRIMESTRE'; }
    if($TipoCiclo == 'T') { $_cic = 'TRIMESTRE'; }
    $obtener_periodo_escolar = [];

    $sql = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$_cic' ORDER BY tblc_ciclo.FInicio DESC");
    while($x = $db->recorrer($sql)){
      $obtener_periodo_escolar[] = $x;
    }
    return $obtener_periodo_escolar;
	}

  public function obtener_grado_materias($IdUsua) {
    $db = new Conexion();
    $sql_inf = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql_inf);
    $_inf = $db->recorrer($sql_inf);
    $IdOferta = $_inf['_idOferta'];
    $IdCampus = $_inf['_idCampus'];
    
    $obtener_grado_materias = [];

    $sql = $db->query("SELECT tblp_modulo.Grado FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' AND tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.Grado ORDER BY tblp_modulo.Grado ASC ");
    while($x = $db->recorrer($sql)){
      $obtener_grado_materias[] = $x;
    }
    return $obtener_grado_materias;
	}


  public function obtener_lista_materias_equi($IdUsua) {
    $db = new Conexion();
    $obtener_lista_materias_equi = [];
    
    $sql = $db->query("SELECT tblh_equivalencia.IdEquivalencia, tblh_equivalencia.Promedio, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblc_ciclo.Ciclo, tblh_equivalencia.IdCiclo FROM tblh_equivalencia Left Join tblp_modulo ON tblp_modulo.IdModulo = tblh_equivalencia.IdModulo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblh_equivalencia.IdCiclo WHERE tblh_equivalencia.Tipo = 'E' AND  tblh_equivalencia.IdUsua = '$IdUsua' ORDER BY tblc_ciclo.FInicio ASC, tblp_modulo.CodeModulo ASC");
    while($x = $db->recorrer($sql)){
      $obtener_lista_materias_equi[] = $x;
    }
    return $obtener_lista_materias_equi;
	}

  public function obtener_lista_materias_conva($IdUsua) {
    $db = new Conexion();
    $obtener_lista_materias_equi = [];
    
    $sql = $db->query("SELECT tblh_equivalencia.IdEquivalencia, tblh_equivalencia.Promedio, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblc_ciclo.Ciclo, tblh_equivalencia.IdCiclo FROM tblh_equivalencia Left Join tblp_modulo ON tblp_modulo.IdModulo = tblh_equivalencia.IdModulo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblh_equivalencia.IdCiclo WHERE tblh_equivalencia.Tipo = 'C' AND  tblh_equivalencia.IdUsua = '$IdUsua' ORDER BY tblc_ciclo.FInicio ASC, tblp_modulo.CodeModulo ASC");
    while($x = $db->recorrer($sql)){
      $obtener_lista_materias_equi[] = $x;
    }
    return $obtener_lista_materias_equi;
	}

  public function obtener_aviso_id($IdAviso, $IdUsua) {
    $db = new Conexion();

    $sql_inf = $db->query("SELECT * FROM tbla_aviso_detalle WHERE tbla_aviso_detalle.IdAviso = '$IdAviso' AND  tbla_aviso_detalle.IdUsua =  '$IdUsua'");
    $db->rows($sql_inf);
    $_inf = $db->recorrer($sql_inf);
    
    if(!isset($_inf['IdDetalle'])){

      $sql_us = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
      $db->rows($sql_us);
      $_user = $db->recorrer($sql_us);
      $IdGrupo = $_user['IdGrupo'];

      $sql_ins = $db->query("INSERT INTO tbla_aviso_detalle (IdAviso, IdUsua, Fec_visto, IdEstatus, IdGrupo)  VALUES ('$IdAviso','$IdUsua',NOW(),'10',$IdGrupo) ");
    }


    $obtener_aviso_id = [];
    
    $sql = $db->query("SELECT * FROM tbla_aviso WHERE tbla_aviso.IdAviso = '$IdAviso' ");
    while($x = $db->recorrer($sql)){
      $obtener_aviso_id[] = $x;
    }
    return $obtener_aviso_id;
	}

  public function obtener_lista_materias_finales($IdUsua) {
    $db = new Conexion();
    $obtener_lista_materias_finales = [];
    
    $sql = $db->query("SELECT
    tblp_calificacion.IdCalificacion,
    tblp_calificacion.Promedio,
    tblp_calificacion.IdCiclo,
    tblp_calificacion._obs,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblc_ciclo.Ciclo
    FROM
    tblp_calificacion
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo
    WHERE
    tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_calificacion.IdEstatus = '10'
    ORDER BY
    tblc_ciclo.FInicio ASC,
    tblp_modulo.CodeModulo ASC
    ");
    while($x = $db->recorrer($sql)){
      $obtener_lista_materias_finales[] = $x;
    }
    return $obtener_lista_materias_finales;
	}



  public function obtener_lista_bajas($IdCampus) {
    $db = new Conexion();
    $obtener_lista_bajas = [];

    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Usuario, tblc_usuario.IdOferta, tblc_estatus.Estatus, tblc_estatus.Estatus, tblp_educativa.Nombre AS NomEducativa FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.IdCampus = '$IdCampus' AND ((tblc_usuario.IdEstatus = '14') || (tblc_usuario.IdEstatus = '15') )");
    while($x = $db->recorrer($sql)){
      $obtener_lista_bajas[] = $x;
    }
    return $obtener_lista_bajas;
	}

  public function lista_tareas_creadas($IdAsignacion) {
    $db = new Conexion();
    $lista_tareas_creadas = [];

    $sql = $db->query("SELECT
    tblp_actividadesdocente.IdActividadesDocente,
    tblp_actividadesdocente.IdEstatus,
    tblp_actividadesdocente.Porcentaje,
    tblp_actividadesdocente.NomActividad,
    tblc_tipoactividad.TipoActividad
    FROM
    tblp_actividadesdocente
    Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad
    WHERE
    tblp_actividadesdocente.IdAsignacion =  '$IdAsignacion'
    ORDER BY
    tblp_actividadesdocente.FecIni ASC
    ");
    while($x = $db->recorrer($sql)){
      $lista_tareas_creadas[] = $x;
    }
    return $lista_tareas_creadas;
	}

  public function materia_finalizada_id($IdAsignacion) {
    $db = new Conexion();
    $materia_finalizada_id = [];

    $sql = $db->query("SELECT
    tblp_asignacion.IdAsignacion,
    tblp_asignacion.Fecha_impresion,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno
    FROM
    tblp_asignacion
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
    WHERE
    tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND
    tblp_asignacion.Tipo =  '2'
    ");
    while($x = $db->recorrer($sql)){
      $materia_finalizada_id[] = $x;
    }
    return $materia_finalizada_id;
	}

  public function tareas_entregdas($IdAsignacion,$IdActividad) {
    $db = new Conexion();
    $lista_tareas_creadas = [];

    $sql = $db->query("SELECT
    Count(tblp_tareas.FecCap) AS Entregadas
    FROM
    tblp_tareas
    WHERE
    tblp_tareas.IdAsignacion =  '$IdAsignacion' AND
    tblp_tareas.IdActividadesDocente =  '$IdActividad'
    
    ");
    while($x = $db->recorrer($sql)){
      $lista_tareas_creadas[] = $x;
    }
    return $lista_tareas_creadas;
	}

  public function get_lista_materia($IdOferta, $IdCampus, $Termino) {
    $db = new Conexion();
    $get_lista_materia = [];

    if($Termino > 1){
      $cond = " AND ((tblp_modulo.NoModulo = 1) || (tblp_modulo.NoModulo = $Termino))";
    } else {
        $cond = "";
    }


    $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.IdCampus = '$IdCampus' $cond ORDER BY tblp_modulo.Grado ASC, tblp_modulo.CodeModulo ASC ");
    while($x = $db->recorrer($sql)){
      $get_lista_materia[] = $x;
    }
    return $get_lista_materia;
	}

  public function get_validar_materia_generada($IdUsua,$IdOferta, $IdModulo, $Code) {
    $db = new Conexion();
    $get_validar_materia_generada = [];

    $sql = $db->query("SELECT * FROM tblp_calificacion WHERE tblp_calificacion.Promedio > 5 AND tblp_calificacion.IdModulo = '$IdModulo' AND tblp_calificacion.IdUsua = '$IdUsua' ");
    while($x = $db->recorrer($sql)){
      $get_validar_materia_generada[] = $x;
    }
    return $get_validar_materia_generada;
	}


  public function get_grupos_invitacion($IdCiclo,$IdCampus) {
    $db = new Conexion();
    

    $sql1 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '$IdCiclo'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $_tipo = $datos2["Tipo"];
    $_numero = ($datos2["Numero"] - 1);


    $sql_cic = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Numero = '$_numero' AND tblc_ciclo.Tipo =  '$_tipo'");
    $db->rows($sql_cic);
    $_cix = $db->recorrer($sql_cic);
    $IdCicloAnterior = $_cix["IdCiclo"];

    $get_grupos_invitacion = [];
    $sql = $db->query("SELECT
tblc_ciclogrupo.IdCicloGrupo,
tblc_ciclogrupo.IdCiclo,
tblc_ciclogrupo.IdGrupo,
tblc_ciclogrupo.Grado,
tblp_grupo.CveGrupo,
tblc_dias_clases._Dias,
tblp_educativa.Abreviatura,
tblp_educativa.Nombre AS Educativa
FROM
tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
WHERE
tblc_ciclogrupo.IdCiclo =  '$IdCicloAnterior' AND
tblp_grupo.IdCampus =  '$IdCampus' AND
tblc_dias_clases.Tipo =  '1'
ORDER BY
tblp_educativa.IdGrado ASC,
tblp_educativa.Nombre ASC,
tblc_ciclogrupo.Grado ASC
 ");
    while($x = $db->recorrer($sql)){
      $get_grupos_invitacion[] = $x;
    }
    return $get_grupos_invitacion;
	}

  public function get_materias_grupo_id($IdGrupo)
  {
    if ($IdGrupo) {
      $db = new Conexion();
      $sql1 = $db->query("SELECT tblc_rvoe.Educativa, tblc_rvoe.IdEducativa, tblc_rvoe.IdCampus, tblp_grupo.IdGrupo, tblc_rvoe.Rvoe FROM tblp_grupo Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblp_grupo.id_rvoe WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
      $db->rows($sql1);
      $datos2 = $db->recorrer($sql1);
      $IdCampus = $datos2["IdCampus"];
      $IdEducativa = $datos2["IdEducativa"];
      $gusuariosT = [];

      if($IdEducativa == 32){
        $sql1 = $db->query("SELECT tblp_grupo.IdCampus FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
      $db->rows($sql1);
      $datos2 = $db->recorrer($sql1);
      $IdCampus = $datos2["IdCampus"];
      }

      if($IdEducativa == 38){
        $sql1 = $db->query("SELECT tblp_grupo.IdCampus FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
      $db->rows($sql1);
      $datos2 = $db->recorrer($sql1);
      $IdCampus = $datos2["IdCampus"];
      }
      
      $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdEducativa' AND tblp_modulo.IdCampus = '$IdCampus' ORDER BY tblp_modulo.Grado ASC, tblp_modulo.Code ASC ");
      while ($x = $db->recorrer($sql)) {
        $gusuariosT[] = $x;
      }
      return $gusuariosT;
    }
  }

  # OBTENER LA LISTA DE DOCENTES ACTIVOS
  public function get_docentes()
  {
    $db = new Conexion();
    $get_docentes = [];
    $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Permisos = '2' AND tblc_usuario.IdEstatus= '8' ORDER BY tblc_usuario.Nombre ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_docentes[] = $x;
    }
    return $get_docentes;
  }

   # OBTENER LA LISTA DE TUTORES ACTIVOS
   public function get_coordinadores_lst()
   {
     $db = new Conexion();
     $get_coordinadores_lst = [];
     $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdEstatus= '8' AND ((tblc_usuario.Permisos = '9') || (tblc_usuario.Permisos = '5')) ORDER BY tblc_usuario.Nombre ASC ");
     while ($x = $db->recorrer($sql)) {
       $get_coordinadores_lst[] = $x;
     }
     return $get_coordinadores_lst;
   }

  public function get_valida_asignacion($IdModulo, $IdEducativa, $IdGrupo)
  {
    $db = new Conexion();
    $get_valida_asignacion = [];
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdEstatus FROM tblp_asignacion WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdEducativa = '$IdEducativa' AND tblp_asignacion.IdModulo = '$IdModulo' AND tblp_asignacion.IdGrupo = '$IdGrupo'");
    while ($x = $db->recorrer($sql)) {
      $get_valida_asignacion[] = $x;
    }
    return $get_valida_asignacion;
  }



  public function tareas_calificadas($IdAsignacion,$IdActividad) {
    $db = new Conexion();
    $lista_tareas_creadas = [];

    $sql = $db->query("SELECT
    Count(tblp_tareas.Calificacion) AS Calificado
    FROM
    tblp_tareas
    WHERE
    tblp_tareas.IdAsignacion =  '$IdAsignacion' AND
    tblp_tareas.IdActividadesDocente =  '$IdActividad'
    ");
    while($x = $db->recorrer($sql)){
      $lista_tareas_creadas[] = $x;
    }
    return $lista_tareas_creadas;
	}


  public function get_materias_activas($IdUsua)
  {
    $db = new Conexion();
    $get_ModuloAsig = [];
    $sql = $db->query("SELECT
        tblp_asignacion.IdAsignacion,
        tblp_asignacion.IdEducativa,
        tblp_asignacion.IdModulo,
        tblp_asignacion.IdUsua,
        tblp_asignacion.FecIni,
        tblp_asignacion.FecFin,
        tblp_asignacion.Estatus,
        tblp_modulo.CodeModulo,
        tblp_modulo.NombreMod,
        tblp_modulo.NoModulo,
        tblp_modulo.Grado,
        tblp_asignacion.Grupo,
        tblc_abreviatura.Abreviatura,
        tblp_modulo.Oferta,
        tblp_educativa.Color,
        tblp_educativa.Texto,
        tblp_educativa.Nombre AS NomEducativa,
        tblp_grupo.CveGrupo
        FROM
        tblp_asignacion
        Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
        Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado
        Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
        Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo WHERE tblp_asignacion.IdUsua='$IdUsua' AND tblp_asignacion.Tipo = '4' AND ((tblp_asignacion.IdEstatus = '8') || (tblp_asignacion.IdEstatus = '12')) ORDER BY tblp_asignacion.Estatus ASC, tblp_asignacion.FecIni ASC");
    while ($x = $db->recorrer($sql)) {
      $get_ModuloAsig[] = $x;
    }
    return $get_ModuloAsig;
  }

  public function get_materias_finalizadas($IdUsua,$IdCiclo)
  {
    $db = new Conexion();
    
    $get_materias_finalizadas = [];
    $sql = $db->query("SELECT
        tblp_asignacion.IdAsignacion,
        tblp_asignacion.IdEducativa,
        tblp_asignacion.IdModulo,
        tblp_asignacion.IdUsua,
        tblp_asignacion.FecIni,
        tblp_asignacion.FecFin,
        tblp_asignacion.Estatus,
        tblp_modulo.CodeModulo,
        tblp_modulo.NombreMod,
        tblp_modulo.NoModulo,
        tblp_modulo.Grado,
        tblp_asignacion.Grupo,
        tblc_abreviatura.Abreviatura,
        tblp_modulo.Oferta,
        tblp_educativa.Color,
        tblp_educativa.Texto,
        tblp_educativa.Nombre AS NomEducativa,
        tblp_grupo.CveGrupo
        FROM
        tblp_asignacion
        Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
        Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado
        Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
        Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo WHERE tblp_asignacion.Tipo = '4' AND tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_asignacion.IdUsua='$IdUsua' AND tblp_asignacion.IdEstatus = '26' ORDER BY tblp_asignacion.Estatus ASC, tblp_asignacion.FecIni ASC");
    while ($x = $db->recorrer($sql)) {
      $get_materias_finalizadas[] = $x;
    }
    return $get_materias_finalizadas;
  }


  public function obtener_lst_proc_rein($IdCiclo) {
    $db = new Conexion();
    $obtener_lst_proc_rein = [];

    $sql = $db->query("SELECT
    tblp_reincorporacion.IdReincorporacion,
    tblp_reincorporacion.Grado,
    tblp_reincorporacion.IdEstatus,
    tblc_usuario.IdUsua,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblp_reincorporacion.FecCap,
    tblp_grupo.CveGrupo,
    tblc_dias_clases._Dias,
    tblc_campus.Campus,
    tblp_educativa.Nombre AS Educativa,
    tblc_estatus.Estatus
    FROM
    tblp_reincorporacion
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_reincorporacion.IdUsua
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_reincorporacion.IdGrupo
    Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
    Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_reincorporacion.IdEstatus
    WHERE tblp_reincorporacion.IdCiclo = '$IdCiclo' ");
    while($x = $db->recorrer($sql)){
      $obtener_lst_proc_rein[] = $x;
    }
    return $obtener_lst_proc_rein;
	}

  public function get_pagAprobados($IdUsua)
  {
    $db = new Conexion();

    $get_pagAprobados = [];
    $sql = $db->query("SELECT
tblp_foliospago.NoFolio,
tblp_foliospago.FecCap,
tblp_foliospago.FecPago,
tblp_foliospago.IdPago,
tblp_foliospago.IdEstatus,
tblp_foliospago.Factura,
tblp_foliospago._facturado,
tblp_foliospago._codigoFactura,
Sum(tblp_foliospago.Monto) AS Monto,
tblp_foliospago.IdForma,
tblc_formapago.Descripcion,
tblc_estatus.Estatus,
tblp_pagos.DocFactura,
tblg_factura._folio,
tblg_factura._tipo,
tblg_factura.IdUsua,
tblg_factura.Fecha
FROM
tblp_foliospago
Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_foliospago.IdEstatus
Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
Left Join tblg_factura ON tblg_factura._codigoFactura = tblp_foliospago._codigoFactura
WHERE
tblp_foliospago.IdUsua =  '$IdUsua'
GROUP BY
tblp_foliospago.NoFolio
 ");
    while ($x = $db->recorrer($sql)) {
      $get_pagAprobados[] = $x;
    }
    return $get_pagAprobados;
  }

  public function get_materias_asig_id($IdUsua)
  {
    $db = new Conexion();
    $get_datKardex = [];

    $sql = $db->query("SELECT
    tblp_moduloalumno.IdModuloAlumno,
    tblp_moduloalumno.IdUsua,
    tblp_moduloalumno.IdAsignacion,
    tblp_moduloalumno.IdEducativa,
    tblp_moduloalumno.IdModulo,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblp_modulo.Grado,
    tblc_ciclo.Ciclo,
    tblp_asignacion.IdCiclo,
    tblp_asignacion.Fecha_impresion,
    tblc_usuario.Nombre,
    tblc_usuario.APaterno,
    tblc_usuario.AMaterno,
    tblc_estatus.Estatus,
    tblp_asignacion.FecIni,
    tblp_asignacion.FecFin,
    tblp_moduloalumno._idModulo,
    ModRvoe.CodeModulo AS RCodeMode,
    ModRvoe.NombreMod AS RNombreMod
    FROM
    tblp_moduloalumno
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_moduloalumno.IdModulo
    Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_asignacion.IdEstatus
    Left Join tblp_modulo AS ModRvoe ON ModRvoe.IdModulo = tblp_moduloalumno._idModulo
    WHERE tblp_moduloalumno.IdUsua =  '$IdUsua' AND tblp_asignacion.Tipo = '2'
    ORDER BY
    tblc_ciclo.FInicio ASC,
    tblp_modulo.CodeModulo ASC");
    while ($x = $db->recorrer($sql)) {
      $get_datKardex[] = $x;
    }
    return $get_datKardex;
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


  public function chek_materias_repetidas($IdUsua) {
    $db = new Conexion();
    $chek_materias_repetidas = [];


    


    $sql = $db->query("SELECT Count(tblp_calificacion.IdCalificacion) As Total, tblp_calificacion.IdUsua, tblp_calificacion.IdModulo, tblp_calificacion.Usuario FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdEstatus = '10' GROUP BY tblp_calificacion.IdUsua, tblp_calificacion.IdModulo ORDER BY Total DESC LIMIT 15 ");
    
    while($x = $db->recorrer($sql)){
      if($x['Total'] > 1){
        $nx = 0;
        $sql_buscar = $db->query("SELECT * FROM tblp_calificacion WHERE tblp_calificacion.IdModulo = '".$x['IdModulo']."' AND tblp_calificacion.IdUsua = '$IdUsua' ORDER BY tblp_calificacion.Promedio DESC");
        while($busc = $db->recorrer($sql_buscar)){
          $nx = ($nx + 1);
          if($nx == 1){
            $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion._obs = '' WHERE tblp_calificacion.IdCalificacion = '".$busc['IdCalificacion']."' ");
          } else {
            $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdEstatus = '8' WHERE tblp_calificacion.IdCalificacion = '".$busc['IdCalificacion']."' ");
          }
        }
      }
    }
  }


  public function get_cal_all_us($IdUsua){
		$db = new Conexion();



    $sql8 = $db->query("SELECT tblc_usuario.id_ciclo_fin, tblc_usuario._tipoReincorporacion, tblc_usuario.Usuario, tblc_usuario.IdGrupo, tblc_usuario.IdEstatus FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $rwIdE = $datos81["IdEstatus"];
    $rwIdG = $datos81["IdGrupo"];
    $rwCicF = $datos81["id_ciclo_fin"];
    $rwTipo = $datos81["_tipoReincorporacion"];
    $rwUsuario = $datos81["Usuario"];
    if($rwIdE == 8){
      $sql7 = $db->query("SELECT tblc_ciclogrupo.IdCicloGrupo, tblc_ciclogrupo.Grado FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdGrupo =  '$rwIdG' ORDER BY tblc_ciclogrupo.Grado DESC");
      $db->rows($sql7);
      $datos_7 = $db->recorrer($sql7);
      $rwSemCua = $datos_7["Grado"];
     // $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.SemCua = '$rwSemCua' WHERE tblc_usuario.IdUsua= '$IdUsua' ");
    }

    if(($rwTipo <> 'SI') && (($rwIdE == 15) || ($rwIdE == 14))){
      
      $sql7 = $db->query("SELECT tblc_ciclogrupo.IdCicloGrupo, tblc_ciclogrupo.Grado, tblc_ciclo.Tipo, tblc_ciclo.Numero FROM tblc_ciclogrupo Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo WHERE tblc_ciclogrupo.IdCiclo = '$rwCicF' AND tblc_ciclogrupo.IdGrupo =  '$rwIdG' ");
      $db->rows($sql7);
      $datos_7 = $db->recorrer($sql7);
      $rwSemCua = $datos_7["Grado"];
      $rwTipo = $datos_7["Tipo"];
      $rwNumero = $datos_7["Numero"];
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.SemCua = '$rwSemCua' WHERE tblc_usuario.IdUsua= '$IdUsua' ");

      $sql_c = $db->query("SELECT tblc_ciclo.IdCiclo, tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.Tipo =  '$rwTipo' AND tblc_ciclo.Numero >  '$rwNumero' ORDER BY tblc_ciclo.Numero ASC ");
      $db->rows($sql_c);
      $datos_cicx = $db->recorrer($sql_c);
      $IdCiclo = $datos_cicx["IdCiclo"];
      if($IdCiclo){
        $sql_asig = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.IdGrupo =  '$rwIdG' ");
        while($y = $db->recorrer($sql_asig)){

        $insertar = $db->query("DELETE FROM tblp_calificacion WHERE tblp_calificacion.IdAsignacion = '".$y['IdAsignacion']."' AND tblp_calificacion.IdUsua = '$IdUsua'");
        $insertar = $db->query("DELETE FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '".$y['IdAsignacion']."' AND tblp_moduloalumno.IdUsua = '$IdUsua'");
        $insertar = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion = '".$y['IdAsignacion']."' AND tblp_asistencia.IdUsua = '$IdUsua'");
        }

        $insertar = $db->query("DELETE FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdCiclo = '$IdCiclo' AND ((tblp_pagos.IdEstatus = 1) || (tblp_pagos.IdEstatus = 58)) ");
        $insertar = $db->query("DELETE FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.IdCiclo = '$IdCiclo' ");
      }
    }

  $get_cal_all_us = [];
  
   //$sql_cal = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.Promedio, tblp_calificacion.IdAsignacion, tblp_calificacion.IdModulo FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion._IdModulo IS NULL ");
   $sql_cal = $db->query("SELECT
   tblp_calificacion.IdCalificacion,
   tblp_calificacion.Promedio,
   tblp_calificacion.IdAsignacion,
   tblp_calificacion.IdModulo,
   tblp_educativa.IdGrado
   FROM tblp_calificacion
   Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_calificacion.IdOferta
   WHERE
   tblp_calificacion.IdUsua =  '$IdUsua' AND
   tblp_calificacion.IdAsignacion IS NOT NULL 
   ");
    while ($_cal = $db->recorrer($sql_cal)) {
      $idGra = $_cal['IdGrado'];
      if($idGra == 3){
        $cal_us = $db->query("SELECT
        tblp_moduloalumno.IdModuloAlumno,
        tblp_moduloalumno._idModulo
        FROM tblp_moduloalumno
        WHERE
        tblp_moduloalumno.IdAsignacion =  '".$_cal['IdAsignacion']."' AND
        tblp_moduloalumno.IdUsua =  '$IdUsua' AND
        tblp_moduloalumno._idModulo IS NOT NULL");
        $db->rows($cal_us);
        $_calMod = $db->recorrer($cal_us);
        $_idModulo = isset($_calMod['_idModulo']);
        if($_idModulo){ 
          $_idModulo = $_calMod['_idModulo'];
          if($_cal['Promedio']<=5){ $_Obs = "RR"; } else { $_Obs = "RE"; }
          $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion._IdModulo = '".$_cal['IdModulo']."', tblp_calificacion.Observacion = '$_Obs', tblp_calificacion.IdModulo = '$_idModulo' WHERE tblp_calificacion.IdCalificacion = '".$_cal['IdCalificacion']."'");
        }
      }
    }

    
    $sql = $db->query("SELECT
    tblp_calificacion.IdCalificacion,
    tblp_calificacion.Promedio,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblp_modulo.Grado,
    tblp_modulo.Creditos,
    tblp_calificacion.Observacion,
    tblc_ciclo.Ciclo,
    tblp_calificacion.IdCiclo,
    tblp_calificacion._obs,
    tblc_observaciones.Descripcion
    FROM tblp_calificacion
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_calificacion.IdCiclo
    Left Join tblc_observaciones ON tblc_observaciones.Tipo = tblp_calificacion.Observacion
    WHERE tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_calificacion.IdEstatus =  '10'
    ORDER BY tblp_modulo.Grado ASC, tblp_modulo.CodeModulo ASC ");
    while($x = $db->recorrer($sql)){
      $get_cal_all_us[] = $x;
    }
    return $get_cal_all_us;
  }

  public function get_mod_lista_id($IdUsua, $IdModulo)
  {
    $db = new Conexion();
    $get_mod_lista_id = [];
    $sql = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$IdUsua' AND tblc_modulousuario.IdModulo = '$IdModulo'");
    while ($x = $db->recorrer($sql)) {
      $get_mod_lista_id[] = $x;
    }
    return $get_mod_lista_id;
  }

  public function get_pagPendientes($IdUsua)
  {
    $db = new Conexion();
    $get_pagPendientes = [];

    $sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdUsua, tblp_pagos.Monto, tblp_pagos.Fecha, tblp_pagos.IdBeca, tblp_pagos.TotalPagado, tblp_pagos.Descuento, tblp_pagos.Descuento2, tblp_pagos.Referencia, tblp_pagos.IdEstatus, tblp_pagos._img, tblp_pagos.IdModulo, tblc_estatus.Estatus, tblc_conceptosplanes.NomPlan
FROM tblp_pagos
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus <> 4 ORDER BY tblp_pagos.Fecha ASC");
    while ($x = $db->recorrer($sql)) {
      $get_pagPendientes[] = $x;
    }
    return $get_pagPendientes;
  }

  public function get_datBeca($IdUsua)
  {
    $db = new Conexion();
    $get_datBeca = [];


    $sql = $db->query("SELECT tblp_beca.IdBeca, tblp_beca.Porcentaje, tblp_beca.FecCap, tblp_beca.IdCiclo, tblc_conceptos.NomConcepto, tblp_beca.Crm, tblp_beca.Nota, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_estatus.Estatus, tblc_ciclo.Ciclo
    FROM
    tblp_beca
    Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_beca.IdConcepto
    Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_beca.IdUsuaCap
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_beca.IdEstatus
    Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_beca.IdCiclo
    WHERE tblp_beca.IdUsua = '$IdUsua' ORDER BY tblc_ciclo.FInicio ASC ");
    while ($x = $db->recorrer($sql)) {
      $get_datBeca[] = $x;
    }
    return $get_datBeca;
  }

  public function get_total_creditos($IdOferta,$IdCampus,$Termino,$IdGrado) {
		$db = new Conexion();

    
        // $sql = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdEstatus = '8' AND tblc_usuario.Permisos = '3' AND tblc_usuario.Grado <= '4' ");
        // while($x = $db->recorrer($sql)){
        //   $IdUsua = $x['IdUsua'];
        //   $IdOferta = $x['IdOferta'];
        //   $IdCampus = $x['IdCampus'];
        //   if($IdOferta == 30){
        //     $cred = 456;  
        //   } else {
        //     $sqlH = $db->query("SELECT Sum(tblp_modulo.Creditos) AS Total FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' AND tblp_modulo.IdCampus =  '$IdCampus'");
        //     $db->rows($sqlH);
        //     $datos81 = $db->recorrer($sqlH);
        //     $cred = $datos81['Total'];
        //   }

        //   $sql_cred = $db->query("SELECT Sum(tblp_modulo.Creditos) AS Total FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_calificacion.IdEstatus =  '10' AND tblp_calificacion.Promedio >  '5'");
        //   $db->rows($sql_cred);
        //   $_cred = $db->recorrer($sql_cred);
        //   $miscreditos = $_cred['Total'];
        //   if($miscreditos > 10){
        //     if($cred == $miscreditos){
        //       echo $cred.'<->'.$miscreditos;
        //       echo "holaaa- > ".$x['Usuario'];
        //       echo "<br>";
        //     }
        //   }
        // }
        
    
    if($IdCampus == 5){
        $IdCampus = 1;
    }

    if($IdGrado == 7){
      $IdCampus = 6;
    }

		$get_total_creditos = [];
		
		if($Termino > 1){
		    $cond = " AND ((tblp_modulo.NoModulo = 1) || (tblp_modulo.NoModulo = $Termino))";
		} else {
		    $cond = "";
		}


		$sql = $db->query("SELECT Sum(tblp_modulo.Creditos) AS Total FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' AND tblp_modulo.IdCampus =  '$IdCampus' $cond");
		while($x = $db->recorrer($sql)){
			$get_total_creditos[] = $x;
		}
		return $get_total_creditos;




	}

  public function get_mis_creditos($IdUsua) {
		$db = new Conexion();
		$get_mis_creditos = [];
	
    	$sqlH = $db->query("SELECT tblc_usuario.IdUsua, tblp_educativa.IdGrado, tblc_grado.Promedio FROM tblc_usuario LEFT JOIN tblp_educativa ON tblc_usuario.IdOferta = tblp_educativa.IdEducativa LEFT JOIN tblc_grado ON tblp_educativa.IdGrado = tblc_grado.IdGrado WHERE tblc_usuario.IdUsua = '$IdUsua' ");
        $db->rows($sqlH);
        $datos81 = $db->recorrer($sqlH);
        $minino = $datos81['Promedio']; 
    
    
		$sql = $db->query("SELECT Sum(tblp_modulo.Creditos) AS Total FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_calificacion.IdEstatus =  '10' AND tblp_calificacion.Promedio >=  '$minino' ");
		while($x = $db->recorrer($sql)){
			$get_mis_creditos[] = $x;
		}
		return $get_mis_creditos;
	}

  public function get_mod_lista($IdUsua, $Tipo)
  {
    $db = new Conexion();
    $get_mod_lista = [];
    $sql = $db->query("SELECT tblc_modulousuario.IdModUsua, tblc_modulo.IdModulo, tblc_modulo.Modulo, tblc_modulo.Nombre, tblc_modulo.Link, tblc_modulo.Tipo, tblc_modulo.Icono, tblc_modulo.Lista FROM tblc_modulousuario Left Join tblc_modulo ON tblc_modulo.IdModulo = tblc_modulousuario.IdModulo WHERE tblc_modulousuario.IdUsua = '$IdUsua' AND tblc_modulo.Lista = '$Tipo'");
    while ($x = $db->recorrer($sql)) {
      $get_mod_lista[] = $x;
    }
    return $get_mod_lista;
  }


  public function get_datos_alumno_id($IdUsua)
  {
    $db = new Conexion();
    $get_datAlumno = [];
    

    $sql = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario._horario, tblc_usuario._idCampus, tblc_usuario.Termino, tblc_usuario.IdCampus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.IdOferta, tblc_usuario.AMaterno, tblc_usuario.Telefono, tblc_usuario.Correo, tblc_usuario.Foto, tblc_usuario.IdCampus, tblc_usuario.Usuario, tblc_usuario.Matricula, tblc_usuario.Code, tblc_usuario.IdEstatus, tblc_usuario.Celular, tblc_usuario.Grado, tblc_usuario._alfanumerica, tblc_usuario._numerica, tblc_usuario._certificado, tblc_estatus.Estatus, tblp_educativa.Nombre AS NomEducativa, tblc_usuario.SemCua, tblp_educativa.IdGrado, tblp_educativa.IdEducativa, tblc_abreviatura.Abreviatura, tblp_educativa.Clave, tblp_educativa.Publicidad, tblp_educativa.Color, tblp_grupo.CveGrupo, tblp_grupo.Tipo, tblp_grupo.Turno, tblp_grupo.TipoCiclo, tblp_grupo.Dia, tblc_campus.Campus, tblc_dias_clases._Dias, tblc_modalidad._Modalidad, tblc_trayectoria.Trayectoria FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblc_usuario.SemCua Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia Left Join tblc_modalidad ON tblc_modalidad.Mod = tblp_grupo.Modalidad Left Join tblc_trayectoria ON tblc_trayectoria.IdTipoTrayectoria = tblc_usuario.IdTrayectoria WHERE tblc_usuario.IdUsua = '$IdUsua' ");
    while ($x = $db->recorrer($sql)) {
      $get_datAlumno[] = $x;
    }
    return $get_datAlumno;
  }

  public function get_concluido_creditos($IdUsua,$Grado) {
		$db = new Conexion();

    if($Grado == 1){
      $sqlH = $db->query("SELECT * FROM tblp_trayectoria_alumno WHERE tblp_trayectoria_alumno.IdUsua =  '$IdUsua' AND tblp_trayectoria_alumno.IdTipo = '18'");
      $db->rows($sqlH);
      $datos81 = $db->recorrer($sqlH);
      if(!isset($datos81['IdTrayectoria'])){
        $Fecha = date("Y-m-d");
        $insertar = $db->query("INSERT INTO tblp_trayectoria_alumno (IdUsua, IdTipo, Fecha, FecCap, IdEstatus, Nota) VALUES ('$IdUsua','18','$Fecha',NOW(),'8','Proceso automático de cierre por plataforma IUDY, por haber completado el 100% de los créditos.') ");
        $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '62', tblc_usuario.IdTrayectoria = '18' WHERE tblc_usuario.IdUsua = '$IdUsua'");
      }
    }

    if($Grado == 2){
      $sqlH = $db->query("SELECT * FROM tblp_trayectoria_alumno WHERE tblp_trayectoria_alumno.IdUsua =  '$IdUsua' AND tblp_trayectoria_alumno.IdTipo = '19'");
      $db->rows($sqlH);
      $datos81 = $db->recorrer($sqlH);
      if(!isset($datos81['IdTrayectoria'])){
        $Fecha = date("Y-m-d");
        $insertar = $db->query("INSERT INTO tblp_trayectoria_alumno (IdUsua, IdTipo, Fecha, FecCap, IdEstatus, Nota) VALUES ('$IdUsua','19','$Fecha',NOW(),'8','Proceso automático de cierre por plataforma IUDY, por haber completado el 100% de los créditos.') ");
        $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '62', tblc_usuario.IdTrayectoria = '19' WHERE tblc_usuario.IdUsua = '$IdUsua'");
      }
    }

    if($Grado == 3){
      $sqlH = $db->query("SELECT * FROM tblp_trayectoria_alumno WHERE tblp_trayectoria_alumno.IdUsua =  '$IdUsua' AND tblp_trayectoria_alumno.IdTipo = '20'");
      $db->rows($sqlH);
      $datos81 = $db->recorrer($sqlH);
      if(!isset($datos81['IdTrayectoria'])){
        $Fecha = date("Y-m-d");
        $insertar = $db->query("INSERT INTO tblp_trayectoria_alumno (IdUsua, IdTipo, Fecha, FecCap, IdEstatus, Nota) VALUES ('$IdUsua','20','$Fecha',NOW(),'8','Proceso automático de cierre por plataforma IUDY, por haber completado el 100% de los créditos.') ");
        $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '61', tblc_usuario.IdTrayectoria = '20' WHERE tblc_usuario.IdUsua = '$IdUsua'");
      }
    }

    if($Grado == 4){
      $sqlH = $db->query("SELECT * FROM tblp_trayectoria_alumno WHERE tblp_trayectoria_alumno.IdUsua =  '$IdUsua' AND tblp_trayectoria_alumno.IdTipo = '23'");
      $db->rows($sqlH);
      $datos81 = $db->recorrer($sqlH);
      if(!isset($datos81['IdTrayectoria'])){
        $Fecha = date("Y-m-d");
        $insertar = $db->query("INSERT INTO tblp_trayectoria_alumno (IdUsua, IdTipo, Fecha, FecCap, IdEstatus, Nota) VALUES ('$IdUsua','23','$Fecha',NOW(),'8','Proceso automático de cierre por plataforma IUDY, por haber completado el 100% de los créditos.') ");
        $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '55', tblc_usuario.IdTrayectoria = '23' WHERE tblc_usuario.IdUsua = '$IdUsua'");
      }
    }

    if($Grado == 7){
      $sqlH = $db->query("SELECT * FROM tblp_trayectoria_alumno WHERE tblp_trayectoria_alumno.IdUsua =  '$IdUsua' AND tblp_trayectoria_alumno.IdTipo = '24'");
      $db->rows($sqlH);
      $datos81 = $db->recorrer($sqlH);
      if(!isset($datos81['IdTrayectoria'])){
        $Fecha = date("Y-m-d");
        $insertar = $db->query("INSERT INTO tblp_trayectoria_alumno (IdUsua, IdTipo, Fecha, FecCap, IdEstatus, Nota) VALUES ('$IdUsua','24','$Fecha',NOW(),'8','Proceso automático de cierre por plataforma IUDY, por haber completado el 100% de los créditos.') ");
        $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '55', tblc_usuario.IdTrayectoria = '24' WHERE tblc_usuario.IdUsua = '$IdUsua'");
      }
    }

    

    $sqlH = $db->query("SELECT tblc_usuario.IdUsua, tblp_educativa.IdGrado, tblc_grado.Promedio FROM tblc_usuario LEFT JOIN tblp_educativa ON tblc_usuario.IdOferta = tblp_educativa.IdEducativa LEFT JOIN tblc_grado ON tblp_educativa.IdGrado = tblc_grado.IdGrado WHERE tblc_usuario.IdUsua = '$IdUsua' ");
    $db->rows($sqlH);
    $datos81 = $db->recorrer($sqlH);
    $minino = $datos81['Promedio']; 


		$get_concluido_creditos = [];
	
		$sql = $db->query("SELECT Sum(tblp_modulo.Creditos) AS Total FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_calificacion.IdEstatus =  '10' AND tblp_calificacion.Promedio >= '$minino' ");
		while($x = $db->recorrer($sql)){
			$get_concluido_creditos[] = $x;
		}
		return $get_concluido_creditos;
	}



}
 
?>
